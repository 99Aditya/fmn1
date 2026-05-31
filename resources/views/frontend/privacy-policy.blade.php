@extends('frontend.layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<main class="privacy-page">

    {{-- Hero Section --}}
    <section class="hero-contact py-5">
        <div class="container py-4 text-center">
            <span class="badge-ai mb-3 d-inline-block">
                <i class="bi bi-shield-lock-fill me-1"></i> Privacy Policy
            </span>
            <h1 class="display-4 fw-bold mb-3">
                Your Privacy Matters
            </h1>
            <p class="lead text-secondary col-lg-8 mx-auto">
                At Find My Naukri, we are committed to protecting your personal information and ensuring transparency about how we collect, use, and safeguard your data.
            </p>
            <p class="small text-muted mt-3">
                Last Updated: {{ date('F d, Y') }}
            </p>
        </div>
    </section>

    {{-- Introduction --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">Introduction</h2>
                <p class="text-secondary">
                    Find My Naukri ("we", "our", "us") operates a career and hiring platform that connects candidates with employers through verified job opportunities, AI-powered resume analysis, assessments, mock interviews, and career development tools.
                </p>
                <p class="text-secondary mb-0">
                    This Privacy Policy explains how we collect, use, store, and protect your information when you use our platform.
                </p>
            </div>
        </div>
    </section>

    {{-- Information We Collect --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">Information We Collect</h2>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="contact-surface p-4 rounded-4 shadow-sm h-100">
                        <h5 class="fw-bold">
                            <i class="bi bi-person-fill text-primary me-2"></i>
                            Personal Information
                        </h5>
                        <ul class="text-secondary mb-0">
                            <li>Full Name</li>
                            <li>Email Address</li>
                            <li>Mobile Number</li>
                            <li>Date of Birth (if provided)</li>
                            <li>Location Information</li>
                            <li>Profile Information</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="contact-surface p-4 rounded-4 shadow-sm h-100">
                        <h5 class="fw-bold">
                            <i class="bi bi-file-earmark-person text-primary me-2"></i>
                            Career Information
                        </h5>
                        <ul class="text-secondary mb-0">
                            <li>Resume / CV Uploads</li>
                            <li>Skills & Qualifications</li>
                            <li>Work Experience</li>
                            <li>Education Details</li>
                            <li>Assessment Results</li>
                            <li>Interview Performance Data</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- How We Use Information --}}
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">How We Use Your Information</h2>

            <div class="row g-4">

                <div class="col-lg-4">
                    <div class="contact-surface p-4 rounded-4 shadow-sm h-100 text-center">
                        <i class="bi bi-briefcase-fill fs-1 text-primary"></i>
                        <h5 class="fw-bold mt-3">Job Matching</h5>
                        <p class="text-secondary mb-0">
                            Match candidates with relevant job opportunities and help employers find suitable talent.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="contact-surface p-4 rounded-4 shadow-sm h-100 text-center">
                        <i class="bi bi-robot fs-1 text-primary"></i>
                        <h5 class="fw-bold mt-3">ATS & AI Features</h5>
                        <p class="text-secondary mb-0">
                            Analyze resumes, provide optimization suggestions, and improve candidate-job matching.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="contact-surface p-4 rounded-4 shadow-sm h-100 text-center">
                        <i class="bi bi-graph-up-arrow fs-1 text-primary"></i>
                        <h5 class="fw-bold mt-3">Platform Improvement</h5>
                        <p class="text-secondary mb-0">
                            Improve platform performance, security, user experience, and feature development.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Data Sharing --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <h2 class="fw-bold mb-4">Information Sharing</h2>

            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <p class="text-secondary">
                    We do not sell your personal information.
                </p>

                <p class="text-secondary">
                    We may share information in the following situations:
                </p>

                <ul class="text-secondary">
                    <li>With verified employers when you apply for jobs.</li>
                    <li>With service providers that help operate our platform.</li>
                    <li>When required by law, legal process, or government authorities.</li>
                    <li>To prevent fraud, abuse, or security threats.</li>
                    <li>With your explicit consent.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Cookies --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">Cookies & Tracking Technologies</h2>

                <p class="text-secondary">
                    We use cookies and similar technologies to:
                </p>

                <ul class="text-secondary">
                    <li>Keep users logged in.</li>
                    <li>Remember preferences and settings.</li>
                    <li>Analyze website performance and usage.</li>
                    <li>Improve security and prevent unauthorized access.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Data Security --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">Data Security</h2>

                <p class="text-secondary mb-0">
                    We implement industry-standard security measures to protect your information against unauthorized access, alteration, disclosure, or destruction. While no online platform can guarantee absolute security, we continuously improve our systems to safeguard user data.
                </p>
            </div>
        </div>
    </section>

    {{-- User Rights --}}
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4">Your Rights</h2>

            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <ul class="text-secondary mb-0">
                    <li>Access your personal information.</li>
                    <li>Update or correct inaccurate information.</li>
                    <li>Delete your account and personal data.</li>
                    <li>Withdraw consent where applicable.</li>
                    <li>Request information about how your data is processed.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Retention --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">Data Retention</h2>

                <p class="text-secondary mb-0">
                    We retain personal information only as long as necessary to provide services, comply with legal obligations, resolve disputes, and enforce our agreements.
                </p>
            </div>
        </div>
    </section>

    {{-- Third Party --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">Third-Party Services</h2>

                <p class="text-secondary mb-0">
                    Our platform may contain links to third-party websites, services, or job postings. We are not responsible for the privacy practices of external websites and encourage users to review their privacy policies before sharing information.
                </p>
            </div>
        </div>
    </section>

    {{-- Updates --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">Policy Updates</h2>

                <p class="text-secondary mb-0">
                    We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated revision date.
                </p>
            </div>
        </div>
    </section>

</main>
@endsection