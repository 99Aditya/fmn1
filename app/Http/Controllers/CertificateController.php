<?php

namespace App\Http\Controllers;

use App\Models\Certificate;

class CertificateController extends Controller
{
    public function show(string $certificateNo)
    {
        $certificate = Certificate::where('certificate_no', $certificateNo)
            ->with(['test', 'attempt'])
            ->firstOrFail();

        $user = \App\Models\User::find($certificate->user_id);

        return view('frontend.certificates.show', compact('certificate', 'user'));
    }
}
