<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\TestAttempt;
use Illuminate\Support\Str;

class CertificateService
{
    public function issue(TestAttempt $attempt): Certificate
    {
        $existing = Certificate::where('attempt_id', $attempt->id)->first();
        if ($existing) {
            return $existing;
        }

        return Certificate::create([
            'user_id'        => $attempt->user_id,
            'test_id'        => $attempt->test_id,
            'attempt_id'     => $attempt->id,
            'certificate_no' => strtoupper(Str::random(4)) . '-' . date('Y') . '-' . str_pad($attempt->id, 6, '0', STR_PAD_LEFT),
            'certificate_url'=> null,
            'issued_at'      => now(),
        ]);
    }
}
