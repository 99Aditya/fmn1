<?php

namespace App\Http\Controllers;

use App\Mail\ResumeAccountCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AtsController extends Controller
{
    public function upload(Request $request)
    {
        $validated = $request->validate([
            'resume' => 'required|file|max:5120|mimes:pdf,doc,docx,txt',
        ]);

        $file = $request->file('resume');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $disk = Storage::disk('local');

        if (!$disk->exists('ats_uploads')) {
            $disk->makeDirectory('ats_uploads');
        }
        if (!$disk->exists('ats_jobs')) {
            $disk->makeDirectory('ats_jobs');
        }

        $path = $file->storeAs('ats_uploads', $filename, 'local');
        $id = (string) Str::uuid();
        $job = [
            'id' => $id,
            'path' => $path,
            'status' => 'uploaded',
            'original' => $file->getClientOriginalName(),
            'user_id' => auth()->id(),
            'paid' => false,
            'premium_offer_shown' => false,
        ];

        $ok = $disk->put("ats_jobs/{$id}.json", json_encode($job));
        if (!$ok) {
            Log::error('Failed to save ATS job JSON', ['job' => $job]);
            return back()->withErrors(['resume' => 'Failed to save job. Check storage permissions.']);
        }

        return redirect()->route('ats.process', ['id' => $id]);
    }

    public function process($id)
    {
        $disk = Storage::disk('local');
        $jobKey = "ats_jobs/{$id}.json";

        if (!$disk->exists($jobKey)) {
            $result = [
                'score' => 0,
                'details' => [],
                'notes' => [],
                'suggestions' => ["Job not found or processing failed. If you just uploaded, try refreshing after a few seconds."],
                'raw' => '',
            ];
            return view('frontend.ats_result', ['id' => $id, 'result' => $result, 'job' => null]);
        }

        $job = json_decode($disk->get($jobKey), true);
        $filePath = $disk->path($job['path']);

        if (Auth::check() && empty($job['user_id'])) {
            $job['user_id'] = Auth::id();
            $disk->put($jobKey, json_encode($job));
        }

        $parser = new \App\Services\AtsParser();
        $result = $parser->parse($filePath);

        if (!Auth::check()) {
            if (empty($job['user_id'])) {
                $contact = $this->extractResumeContact($result['raw']);

                if ($contact['email']) {
                    $user = User::where('email', $contact['email'])->first();
                    $createdAccount = false;

                    if (!$user && $contact['name']) {
                        $randomPassword = Str::random(12);
                        $user = User::create([
                            'name' => $contact['name'],
                            'email' => $contact['email'],
                            'password' => Hash::make($randomPassword),
                        ]);

                        Mail::to($user->email)->send(new ResumeAccountCreated(
                            $user,
                            $randomPassword,
                            route('login')
                        ));

                        Auth::login($user);
                        $createdAccount = true;
                    }

                    if ($user) {
                        $job['user_id'] = $user->id;
                        $disk->put($jobKey, json_encode($job));

                        if ($createdAccount && Auth::check()) {
                            // Automatically log in and continue to show the ATS report.
                        } else {
                            return redirect()->guest(route('login'))
                                ->with('status', 'Your  resume was received. We found an account for this email or created one automatically. Please log in to view your ATS report.');
                        }
                    }
                }

                if (!Auth::check()) {
                    return redirect()->guest(route('login'))
                        ->with('status', 'Please log in or sign up to view your ATS report. We could not identify a usable email address from your resume.');
                }
            }

            if (!Auth::check()) {
                return redirect()->guest(route('login'))
                    ->with('status', 'Please log in to view your ATS report.');
            }
        }

        if (Auth::id() !== ($job['user_id'] ?? null)) {
            abort(403, 'Unauthorized access to this report.');
        }

        $job['status'] = 'processed';
        $job['paid'] = $job['paid'] ?? false;
        $job['premium_offer_shown'] = true;
        $job['result'] = $result;
        $disk->put($jobKey, json_encode($job));

        return view('frontend.ats_result', ['id' => $id, 'result' => $result, 'job' => $job]);
    }

    private function extractResumeContact(string $text): array
    {
        $text = trim($text);
        $email = null;
        if (preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', $text, $matches)) {
            $email = strtolower($matches[0]);
        }

        $name = null;
        $lines = preg_split('/\r?\n/', $text);
        $cleaned = array_filter(array_map('trim', $lines), fn($line) => $line !== '');

        $nameCandidates = [];
        foreach ($cleaned as $index => $line) {
            $lineLower = mb_strtolower($line);
            if ($email && str_contains($lineLower, $email)) {
                continue;
            }
            if (preg_match('/\b(resume|profile|summary|experience|education|skills|contact|phone|email|linkedin|github)\b/i', $line)) {
                continue;
            }

            $words = preg_split('/\s+/', $line);
            if (count($words) >= 2 && count($words) <= 4) {
                $valid = true;
                foreach ($words as $word) {
                    if (preg_match('/\d/', $word) || strlen($word) < 2) {
                        $valid = false;
                        break;
                    }
                }
                if ($valid) {
                    $nameCandidates[] = $line;
                }
            }
        }

        if (!empty($nameCandidates)) {
            $name = $nameCandidates[0];
        }

        return ['email' => $email, 'name' => $name];
    }
}
