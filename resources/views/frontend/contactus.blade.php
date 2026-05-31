@extends('frontend.layouts.app')

@section('title', 'Contact Us')

@section('content')
<main class="contact-page">
  <section class="hero-contact pt-5 pb-5">
    <div class="container py-4">
      <div class="row align-items-center g-5">
        <div class="col-lg-7">
          <span class="badge-ai mb-3 d-inline-block"><i class="bi bi-chat-dots-fill me-1"></i> We're here to help</span>
          <h1 class="display-4 fw-bold mb-4">Let's <span class="text-primary">connect</span> and make learning better together</h1>
          <p class="lead fs-5 text-secondary">Have questions, feedback, or partnership ideas? Our team is ready to assist you. Whether you're an educator, student, or organization — we’d love to hear from you.</p>
          <div class="d-flex flex-wrap gap-3 mt-4">
            <a href="#contactForm" class="btn btn-primary-custom"><i class="bi bi-envelope-paper-fill me-2"></i>Send a message</a>
            <a href="#faq" class="btn btn-outline-custom"><i class="bi bi-question-circle"></i> Frequently asked</a>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="contact-surface rounded-4 shadow-sm p-4 text-center border">
            <i class="bi bi-headset fs-1 text-primary opacity-75"></i>
            <p class="mt-2 fw-semibold">Average response time: &lt; 24 hours</p>
            <hr>
            <div class="d-flex justify-content-around">
              <div><i class="bi bi-chat-heart text-primary"></i> <span>98% satisfaction</span></div>
              <div><i class="bi bi-globe2 text-primary"></i> <span>Global support</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5">
    <div class="container">
      <div class="row g-4 mb-5">
        <div class="col-md-4">
          <div class="contact-card p-4 text-center h-100">
            <div class="contact-icon mx-auto"><i class="bi bi-envelope-fill"></i></div>
            <h5 class="fw-bold">Email us</h5>
            <p class="text-secondary">For general inquiries & support</p>
            <a href="mailto:findmynaukri.developerschool@gmail.com" class="text-primary fw-semibold text-decoration-none">findmynaukri.developerschool@gmail.com <i class="bi bi-arrow-right-short"></i></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-card p-4 text-center h-100">
            <div class="contact-icon mx-auto"><i class="bi bi-chat-dots"></i></div>
            <h5 class="fw-bold">Live chat</h5>
            <p class="text-secondary">Monday–Saturday, 9am–6pm (IST)</p>
            <a href="#" class="text-primary fw-semibold text-decoration-none">Start chat <i class="bi bi-arrow-right-short"></i></a>
          </div>
        </div>
        <div class="col-md-4">
          <div class="contact-card p-4 text-center h-100">
            <div class="contact-icon mx-auto"><i class="bi bi-twitter-x"></i></div>
            <h5 class="fw-bold">X / Twitter</h5>
            <p class="text-secondary">Get quick updates & community</p>
            <a href="#" class="text-primary fw-semibold text-decoration-none">@FindMyNaukri <i class="bi bi-arrow-right-short"></i></a>
          </div>
        </div>
      </div>

      <div class="row g-5 align-items-start" id="contactForm">
        <div class="col-lg-7">
          <div class="contact-surface p-4 rounded-4 shadow-sm border">
            <h3 class="fw-bold mb-2">Send us a message</h3>
            <p class="text-secondary mb-4">We'll get back to you within one business day.</p>
            
            @if (session('success'))
              <div class="alert alert-success mb-4" role="alert">
                ✅ {{ session('success') }}
              </div>
            @endif

            <form id="contactFormSubmit" action="{{ route('contact.submit') }}" method="post">
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Full name *</label>
                  <input type="text" name="full_name" class="form-control form-control-custom @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}" placeholder="Alex Johnson">
                  @error('full_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label fw-semibold">Email address *</label>
                  <input type="email" name="email" class="form-control form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="hello@example.com">
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold">Subject *</label>
                  <select name="subject" class="form-select form-control-custom @error('subject') is-invalid @enderror">
                    <option value="General inquiry" {{ old('subject') == 'General inquiry' ? 'selected' : '' }}>General inquiry</option>
                    <option value="Partnership / collaboration" {{ old('subject') == 'Partnership / collaboration' ? 'selected' : '' }}>Partnership / collaboration</option>
                    <option value="Technical support" {{ old('subject') == 'Technical support' ? 'selected' : '' }}>Technical support</option>
                    <option value="Feedback & suggestions" {{ old('subject') == 'Feedback & suggestions' ? 'selected' : '' }}>Feedback & suggestions</option>
                    <option value="Report an issue" {{ old('subject') == 'Report an issue' ? 'selected' : '' }}>Report an issue</option>
                  </select>
                  @error('subject')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                  <label class="form-label fw-semibold">Message *</label>
                  <textarea name="message" class="form-control form-control-custom @error('message') is-invalid @enderror" rows="5" placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                  @error('message')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input @error('privacy') is-invalid @enderror" type="checkbox" name="privacy" id="privacyCheck" value="1" {{ old('privacy') ? 'checked' : '' }}>
                    <label class="form-check-label text-secondary small" for="privacyCheck">
                      I agree to the <a href="#" class="text-primary">privacy policy</a> and consent to being contacted.
                    </label>
                    @error('privacy')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary-custom w-100 py-2"><i class="bi bi-send me-2"></i>Send message</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="contact-muted-surface p-4 rounded-4">
            <h4 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill text-primary me-2"></i> Our hub</h4>
            <p class="text-secondary"><strong>Find My Naukri Global</strong><br>4/1 Vivekanand Colony, Purani Basti<br>Jaipur, Rajasthan 302016</p>
            <hr>
            <h5 class="fw-semibold">Partnership & press</h5>
            <p class="text-secondary">For media inquiries or strategic partnerships: <br><a href="mailto:findmynaukri.developerschool@gmail.com" class="text-primary">findmynaukri.developerschool@gmail.com</a></p>
            <hr>
            <h5 class="fw-semibold"><i class="bi bi-telephone"></i> Phone support</h5>
            <p class="text-secondary">+91 7733932001, +91 8619604103<br><span class="small">Mon–Sat, 10am–6pm IST</span></p>
            <div class="mt-3 d-flex gap-3">
              {{-- <a href="#" class="contact-social-link fs-4"><i class="bi bi-linkedin"></i></a>
              <a href="#" class="contact-social-link fs-4"><i class="bi bi-youtube"></i></a>
              <a href="#" class="contact-social-link fs-4"><i class="bi bi-instagram"></i></a> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 contact-muted-section" id="faq">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Frequently asked questions</h2>
        <p class="text-secondary col-lg-7 mx-auto">Quick answers to common queries before you reach out.</p>
      </div>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="faq-item">
            <h5 class="fw-semibold"><i class="bi bi-question-circle-fill text-primary me-2"></i> Is Find My Naukri really free?</h5>
            <p class="text-secondary">Absolutely! Find My Naukri is 100% free with no premium tiers or hidden fees. We believe education should be accessible to everyone.</p>
          </div>
          <div class="faq-item">
            <h5 class="fw-semibold"><i class="bi bi-question-circle-fill text-primary me-2"></i> How does the AI quiz generation work?</h5>
            <p class="text-secondary">Our AI analyzes your topic and generates relevant questions, answers and distractors. You can edit them anytime — fully customizable.</p>
          </div>
          <div class="faq-item">
            <h5 class="fw-semibold"><i class="bi bi-question-circle-fill text-primary me-2"></i> Can I share quizzes with my students?</h5>
            <p class="text-secondary">Yes! You get a shareable link or embed code. Students can practice without creating an account.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="faq-item">
            <h5 class="fw-semibold"><i class="bi bi-question-circle-fill text-primary me-2"></i> Is there a mobile app?</h5>
            <p class="text-secondary">Our platform is fully responsive, and we're developing native iOS/Android apps — coming soon in 2025.</p>
          </div>
          <div class="faq-item">
            <h5 class="fw-semibold"><i class="bi bi-question-circle-fill text-primary me-2"></i> How do I report a bug or request a feature?</h5>
            <p class="text-secondary">Use the contact form above or email us directly at findmynaukri.developerschool@gmail.com. We love feedback from our community!</p>
          </div>
          <div class="faq-item">
            <h5 class="fw-semibold"><i class="bi bi-question-circle-fill text-primary me-2"></i> Can companies use Find My Naukri for training?</h5>
            <p class="text-secondary">Definitely! Many corporate trainers use Find My Naukri for onboarding and skill assessments. Contact us for team analytics.</p>
          </div>
        </div>
      </div>
      <div class="text-center mt-4">
        <p class="text-secondary">Still need help? <a href="#contactForm" class="text-primary fw-semibold">Get in touch directly →</a></p>
      </div>
    </div>
  </section>

  <section class="py-4">
    <div class="container">
      <div class="contact-surface rounded-4 overflow-hidden shadow-sm border">
        <div class="ratio ratio-21x9">
          <iframe src="https://www.openstreetmap.org/export/embed.html?bbox=13.3888599,52.5170365,13.398860,52.5230365&layer=mapnik&marker=52.5200365,13.3938599" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
      </div>
      <p class="text-center text-secondary small mt-2"><i class="bi bi-pin-map-fill"></i> Berlin, Germany — Our main innovation hub</p>
    </div>
  </section>

  <section class="py-5 contact-community-section">
    <div class="container text-center py-4">
      <h2 class="fw-bold mb-3">Join our global community</h2>
      <p class="lead mb-4 text-secondary">Stay updated about new AI features, tips, and educational content.</p>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="input-group contact-newsletter-group">
            <input type="email" class="form-control form-control-custom rounded-start-pill py-2" placeholder="Your best email" aria-label="Newsletter email">
            <button class="btn btn-primary-custom rounded-end-pill px-4">Subscribe</button>
          </div>
          <p class="small text-secondary mt-2">No spam, unsubscribe anytime.</p>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection

@section('scripts')
<script>
  // Contact form submission is handled server-side via Laravel
</script>
@endsection
