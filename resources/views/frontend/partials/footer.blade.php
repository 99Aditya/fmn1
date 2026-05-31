<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-4 mt-5" data-bs-theme="dark">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-5">
        <a href="{{ url('/') }}" class="d-inline-flex align-items-center mb-3">
          <img src="{{ asset('logo/logo.png') }}" alt="" height="40" class="me-2" />
        </a>
        <p class="text-white-50">
          Empowering talents to land meaningful careers with confidence and clarity.
          Your future starts with a strong resume and career strategy.
        </p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-white-50"
            ><i class="bi bi-twitter-x fs-5"></i
          ></a>
          <a href="#" class="text-white-50"
            ><i class="bi bi-linkedin fs-5"></i
          ></a>
          <a href="#" class="text-white-50"
            ><i class="bi bi-instagram fs-5"></i
          ></a>
        </div>
      </div>
      <div class="col-md-3">
        <h5>Quick Links</h5>
        <ul class="list-unstyled">
          <li class="mb-2">
            <a href="#" class="text-white-50">About Us</a>
          </li>
          <li class="mb-2">
            <a href="#" class="text-white-50">Career Guide</a>
          </li>
          <li class="mb-2">
            <a href="#" class="text-white-50">Success Stories</a>
          </li>
          <li class="mb-2">
            <a href="#" class="text-white-50">Pricing</a>
          </li>
          <li class="mb-2">
            <a href="{{ url('/privacy-policy') }}" class="text-white-50">Privacy Policy</a>
          </li>
          <li class="mb-2">
            <a href="{{ url('/terms-of-service') }}" class="text-white-50">Terms of Service</a>
          </li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>Subscribe</h5>
        <p class="text-white-50">
          Get weekly resume tips & job market insights.
        </p>
        <div class="input-group">
          <input
            type="email"
            class="form-control bg-dark text-white border-secondary"
            placeholder="Email address"
          />
          <button class="btn btn-primary" type="button">Join</button>
        </div>
      </div>
    </div>
    <hr class="mt-4 opacity-25" />
    <div class="text-center text-white-50 small pb-2">
      © 2026 CareerElevate — Redefining job search with career clarity and growth.
    </div>
  </div>
</footer>
