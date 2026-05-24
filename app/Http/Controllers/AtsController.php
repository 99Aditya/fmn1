<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

        $parser = new \App\Services\AtsParser();
        $result = $parser->parse($filePath);

        $job['status'] = 'processed';
        $job['paid'] = $job['paid'] ?? false;
        $job['premium_offer_shown'] = true;
        $job['result'] = $result;
        $disk->put($jobKey, json_encode($job));

        return view('frontend.ats_result', ['id' => $id, 'result' => $result, 'job' => $job]);
    }
}
