@extends('frontend.layouts.app')

@section('title', 'Terms & Conditions')

@section('content')
<main class="terms-page">

    {{-- Hero Section --}}
    <section class="hero-contact py-5">
        <div class="container py-4 text-center">
            <span class="badge-ai mb-3 d-inline-block">
                <i class="bi bi-file-earmark-text-fill me-1"></i> Terms & Conditions
            </span>

            <h1 class="display-4 fw-bold mb-3">
                Terms of Service
            </h1>

            <p class="lead text-secondary col-lg-8 mx-auto">
                These Terms & Conditions govern your access to and use of Find My Naukri, including job listings, resume analysis, assessments, subscriptions, and community features.
            </p>

            <p class="small text-muted mt-3">
                Last Updated: {{ date('F d, Y') }}
            </p>
        </div>
    </section>

    {{-- Acceptance --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">1. Acceptance of Terms</h2>

                <p class="text-secondary mb-0">
                    By accessing or using Find My Naukri, you agree to be bound by these Terms & Conditions. If you do not agree with any part of these terms, please do not use our platform.
                </p>
            </div>
        </div>
    </section>

    {{-- Eligibility --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">2. Eligibility</h2>

                <ul class="text-secondary mb-0">
                    <li>You must be at least 18 years old or legally eligible to work.</li>
                    <li>You must provide accurate and complete information.</li>
                    <li>You are responsible for maintaining account security.</li>
                    <li>You are responsible for activities performed through your account.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Candidate Terms --}}
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-5">3. Candidate Responsibilities</h2>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="contact-surface p-4 rounded-4 shadow-sm h-100">
                        <h5 class="fw-bold">Profile Accuracy</h5>
                        <p class="text-secondary mb-0">
                            Candidates must provide genuine resumes, qualifications, skills, and work experience information.
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="contact-surface p-4 rounded-4 shadow-sm h-100">
                        <h5 class="fw-bold">Responsible Usage</h5>
                        <p class="text-secondary mb-0">
                            Users must not upload false, misleading, illegal, offensive, or copyrighted content without authorization.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Employer Terms --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <h2 class="fw-bold mb-4">4. Employer Responsibilities</h2>

            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <ul class="text-secondary mb-0">
                    <li>Employers must post only genuine job opportunities.</li>
                    <li>Fake, misleading, or fraudulent job postings are prohibited.</li>
                    <li>Employers must comply with applicable labor and employment laws.</li>
                    <li>Employers are responsible for hiring decisions and communications.</li>
                    <li>Find My Naukri reserves the right to remove suspicious listings.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- ATS & AI --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">5. ATS, AI Tools & Assessments</h2>

                <ul class="text-secondary mb-0">
                    <li>ATS scores and resume recommendations are provided for guidance purposes only.</li>
                    <li>AI-generated suggestions do not guarantee employment.</li>
                    <li>Assessment results are intended for skill evaluation.</li>
                    <li>Mock interview feedback is informational and educational in nature.</li>
                    <li>Users are responsible for decisions made based on platform recommendations.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Subscription --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">6. Subscription Plans & Payments</h2>

                <ul class="text-secondary mb-0">
                    <li>Premium features may require paid subscriptions.</li>
                    <li>Subscription pricing may change with prior notice.</li>
                    <li>Payments are processed through authorized payment providers.</li>
                    <li>Subscription benefits remain active during the purchased period.</li>
                    <li>Abuse of subscription features may result in account suspension.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Community --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">7. Community & Blog Content</h2>

                <ul class="text-secondary mb-0">
                    <li>Users may publish career-related content and experiences.</li>
                    <li>Content must not be abusive, defamatory, misleading, or illegal.</li>
                    <li>Users retain ownership of their content.</li>
                    <li>By publishing content, you grant us permission to display it on the platform.</li>
                    <li>We reserve the right to remove content that violates these terms.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Prohibited Activities --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">8. Prohibited Activities</h2>

                <ul class="text-secondary mb-0">
                    <li>Posting fake jobs or fake candidate profiles.</li>
                    <li>Attempting unauthorized access to accounts or systems.</li>
                    <li>Uploading malware, viruses, or harmful code.</li>
                    <li>Harassing other users.</li>
                    <li>Using automated bots without permission.</li>
                    <li>Violating intellectual property rights.</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- Limitation --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">9. Limitation of Liability</h2>

                <p class="text-secondary mb-0">
                    Find My Naukri acts as a platform connecting candidates and employers. We do not guarantee job placement, interview success, hiring decisions, or employer responses. Users use the platform at their own risk.
                </p>
            </div>
        </div>
    </section>

    {{-- Termination --}}
    <section class="py-5 contact-muted-section">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">10. Account Suspension & Termination</h2>

                <p class="text-secondary mb-0">
                    We may suspend or terminate accounts that violate these Terms & Conditions, engage in fraudulent activity, abuse platform features, or threaten platform security.
                </p>
            </div>
        </div>
    </section>

    {{-- Changes --}}
    <section class="py-5">
        <div class="container">
            <div class="contact-surface p-4 rounded-4 shadow-sm">
                <h2 class="fw-bold mb-3">11. Changes to Terms</h2>

                <p class="text-secondary mb-0">
                    We may update these Terms & Conditions periodically. Continued use of the platform after updates constitutes acceptance of the revised terms.
                </p>
            </div>
        </div>
    </section>

    {{-- Contact --}}
    <section class="py-5 contact-community-section">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Questions About These Terms?</h2>

            <p class="lead text-secondary mb-4">
                If you have questions regarding these Terms & Conditions, please contact our support team.
            </p>

            <a href="{{ url('/contact') }}" class="btn btn-primary-custom rounded-pill px-4">
                <i class="bi bi-envelope-fill me-2"></i> Contact Us
            </a>
        </div>
    </section>

</main>
@endsection