@extends('frontend.layouts.app')

@section('title', 'Support Us - FindMyNaukri')

@section('styles')
<style>
.donate { font-family:'Inter',-apple-system,Segoe UI,Roboto,sans-serif; }
.donate-hero { background:linear-gradient(135deg,#0b1220 0%,#1e3a8a 55%,#2563eb 100%); color:#fff; padding:60px 0 90px; position:relative; overflow:hidden; }
.donate-hero::after { content:''; position:absolute; inset:0; background:radial-gradient(circle at 80% 20%,rgba(255,255,255,.12),transparent 45%); }
.donate-hero .container { position:relative; z-index:2; }
.d-badge { display:inline-flex; align-items:center; gap:7px; background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.22); color:#fff; font-weight:700; font-size:.8rem; padding:7px 16px; border-radius:50px; }
.donate-hero h1 { font-size:2.3rem; font-weight:800; margin:16px 0 10px; }
.donate-hero .lead { opacity:.85; max-width:640px; margin:0 auto; font-size:1.05rem; }

.donate-wrap { max-width:980px; margin:-56px auto 60px; padding:0 18px; position:relative; z-index:5; }
.grid { display:grid; grid-template-columns:1.1fr .9fr; gap:20px; align-items:start; }
@media(max-width:820px){ .grid{ grid-template-columns:1fr; } }

.card { background:#fff; border-radius:18px; border:1px solid #e6ebf5; padding:26px; box-shadow:0 10px 32px rgba(15,23,42,.08); }
.card h5 { font-size:1.1rem; font-weight:800; color:#0f172a; margin:0 0 6px; }
.card .muted { color:#64748b; font-size:.9rem; margin:0 0 18px; }

.amounts { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
.amt { border:1.5px solid #e2e8f0; background:#f8fafc; border-radius:12px; padding:16px 8px; text-align:center; font-weight:800; color:#1e293b; cursor:pointer; transition:.15s; font-size:1.05rem; }
.amt small { display:block; font-weight:600; color:#94a3b8; font-size:.68rem; margin-top:3px; }
.amt:hover { border-color:#93c5fd; }
.amt.active { border-color:#2563eb; background:#eff4ff; color:#1d4ed8; box-shadow:0 0 0 3px rgba(37,99,235,.12); }

.field { margin-top:16px; }
.field label { display:block; font-size:.8rem; font-weight:700; color:#475569; margin-bottom:6px; }
.field .input { display:flex; align-items:center; border:1.5px solid #e2e8f0; border-radius:11px; overflow:hidden; transition:.15s; }
.field .input:focus-within { border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.12); }
.field .cur { padding:12px 14px; background:#f1f5f9; color:#475569; font-weight:800; }
.field input { border:none; outline:none; padding:12px 14px; width:100%; font-size:1rem; }
.row2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
@media(max-width:520px){ .row2{ grid-template-columns:1fr; } }

.btn-donate { width:100%; margin-top:22px; border:none; border-radius:12px; padding:15px; font-weight:800; font-size:1.05rem; color:#fff; background:linear-gradient(135deg,#e11d48,#f43f5e); cursor:pointer; transition:.18s; display:flex; align-items:center; justify-content:center; gap:9px; }
.btn-donate:hover:not(:disabled) { box-shadow:0 12px 30px rgba(225,29,72,.35); transform:translateY(-1px); }
.btn-donate:disabled { opacity:.55; cursor:not-allowed; }
.secure { text-align:center; color:#94a3b8; font-size:.78rem; margin-top:12px; display:flex; align-items:center; justify-content:center; gap:6px; }

.impact li { display:flex; gap:13px; align-items:flex-start; margin-bottom:16px; }
.impact li:last-child { margin-bottom:0; }
.impact .ic { width:40px; height:40px; border-radius:11px; background:#eff4ff; color:#2563eb; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
.impact .it { font-weight:700; color:#0f172a; font-size:.95rem; }
.impact .id { color:#64748b; font-size:.85rem; margin-top:2px; line-height:1.5; }

.disabled-note { background:#fffbeb; border:1px solid #fde68a; color:#92580a; border-radius:12px; padding:14px 16px; font-size:.88rem; margin-top:18px; }
.thanks { display:none; text-align:center; padding:24px 10px; }
.thanks .tick { width:74px; height:74px; border-radius:50%; background:#dcfce7; color:#16a34a; display:flex; align-items:center; justify-content:center; font-size:2.2rem; margin:0 auto 16px; }
.thanks h4 { font-weight:800; color:#0f172a; }
.thanks p { color:#64748b; }
.alert-error { display:none; background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:10px; padding:11px 14px; font-size:.85rem; margin-top:14px; }
</style>
@endsection

@section('content')
<div class="donate">

  <section class="donate-hero">
    <div class="container text-center" data-aos="fade-up">
      <span class="d-badge"><i class="bi bi-heart-fill text-danger"></i> Support FindMyNaukri</span>
      <h1>Help us keep careers moving</h1>
      <p class="lead">Our mock tests, ATS resume checker and community are free for every job seeker. If we’ve helped you, a small donation helps us keep the lights on and build more.</p>
    </div>
  </section>

  <div class="donate-wrap">
    <div class="grid">

      {{-- Donation form --}}
      <div class="card" data-aos="fade-up">
        <div id="donateForm">
          <h5>Make a donation</h5>
          <p class="muted">Choose an amount or enter your own. Every contribution counts.</p>

          <div class="amounts" id="amountGrid">
            <div class="amt" data-amt="99">₹99<small>Coffee</small></div>
            <div class="amt active" data-amt="299">₹299<small>Supporter</small></div>
            <div class="amt" data-amt="499">₹499<small>Booster</small></div>
            <div class="amt" data-amt="999">₹999<small>Champion</small></div>
            <div class="amt" data-amt="2100">₹2100<small>Patron</small></div>
            <div class="amt" data-amt="5100">₹5100<small>Hero</small></div>
          </div>

          <div class="field">
            <label for="customAmount">Or enter a custom amount</label>
            <div class="input"><span class="cur">₹</span><input type="number" id="customAmount" min="1" max="500000" placeholder="Enter amount" inputmode="numeric"></div>
          </div>

          <div class="row2">
            <div class="field"><label for="donorName">Name <span style="color:#94a3b8;font-weight:500">(optional)</span></label><div class="input"><input type="text" id="donorName" placeholder="Your name"></div></div>
            <div class="field"><label for="donorEmail">Email <span style="color:#94a3b8;font-weight:500">(optional)</span></label><div class="input"><input type="email" id="donorEmail" placeholder="you@email.com"></div></div>
          </div>

          @if($enabled)
            <button class="btn-donate" id="donateBtn"><i class="bi bi-heart-fill"></i> Donate <span id="btnAmount">₹299</span></button>
            <div class="secure"><i class="bi bi-shield-lock-fill"></i> Secured by Razorpay · Cards, UPI, Netbanking &amp; Wallets</div>
            <div class="alert-error" id="donateError"></div>
          @else
            <button class="btn-donate" disabled><i class="bi bi-clock-history"></i> Online donations coming soon</button>
            <div class="disabled-note"><i class="bi bi-info-circle"></i> The payment gateway isn’t configured yet. Add your <code>RAZORPAY_KEY</code> and <code>RAZORPAY_SECRET</code> to <code>.env</code> to enable live donations.</div>
          @endif
        </div>

        <div class="thanks" id="thanksBox">
          <div class="tick"><i class="bi bi-check-lg"></i></div>
          <h4>Thank you! 💙</h4>
          <p id="thanksMsg">Your support means the world to us and the job seekers we help every day.</p>
          <a href="/" class="btn btn-primary rounded-pill px-4 mt-2">Back to Home</a>
        </div>
      </div>

      {{-- Impact --}}
      <div class="card" data-aos="fade-up" data-aos-delay="100">
        <h5>Where your money goes</h5>
        <p class="muted">100% goes back into helping people land jobs.</p>
        <ul class="list-unstyled impact">
          <li><span class="ic"><i class="bi bi-hdd-network"></i></span><div><div class="it">Servers &amp; hosting</div><div class="id">Keeps the mock tests, ATS checker and site fast and online 24/7.</div></div></li>
          <li><span class="ic"><i class="bi bi-magic"></i></span><div><div class="it">New free tools</div><div class="id">Funds development of new features for job seekers — at no cost to them.</div></div></li>
          <li><span class="ic"><i class="bi bi-people"></i></span><div><div class="it">Community support</div><div class="id">Helps us keep the community free, open and growing.</div></div></li>
          <li><span class="ic"><i class="bi bi-mortarboard"></i></span><div><div class="it">Better content</div><div class="id">More practice questions, guides and resume resources.</div></div></li>
        </ul>
      </div>

    </div>
  </div>
</div>
@endsection

@section('scripts')
@if($enabled)
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(function () {
  var selected = 299;
  var grid = document.getElementById('amountGrid');
  var custom = document.getElementById('customAmount');
  var btn = document.getElementById('donateBtn');
  var btnAmt = document.getElementById('btnAmount');
  var errBox = document.getElementById('donateError');
  var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  function setAmount(v) {
    selected = v;
    btnAmt.textContent = v ? ('₹' + v) : '';
  }

  grid.addEventListener('click', function (e) {
    var card = e.target.closest('.amt');
    if (!card) return;
    grid.querySelectorAll('.amt').forEach(function (a) { a.classList.remove('active'); });
    card.classList.add('active');
    custom.value = '';
    setAmount(parseInt(card.dataset.amt, 10));
  });

  custom.addEventListener('input', function () {
    grid.querySelectorAll('.amt').forEach(function (a) { a.classList.remove('active'); });
    var v = parseInt(custom.value, 10);
    setAmount(isNaN(v) ? 0 : v);
  });

  function showError(msg) { errBox.textContent = msg; errBox.style.display = 'block'; }

  btn.addEventListener('click', function () {
    errBox.style.display = 'none';
    if (!selected || selected < 1) { showError('Please enter an amount of ₹1 or more.'); return; }

    btn.disabled = true;
    var original = btn.innerHTML;
    btn.innerHTML = 'Processing…';

    fetch('{{ route('donate.order') }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: JSON.stringify({
        amount: selected,
        name: document.getElementById('donorName').value,
        email: document.getElementById('donorEmail').value
      })
    })
    .then(function (r) { return r.json().then(function (d) { return { ok: r.ok, d: d }; }); })
    .then(function (res) {
      if (!res.ok) { throw new Error(res.d.message || 'Something went wrong.'); }
      var order = res.d;
      var rzp = new Razorpay({
        key: order.key,
        amount: order.amount,
        currency: order.currency,
        order_id: order.order_id,
        name: order.payee || 'FindMyNaukri',
        description: 'Donation — thank you for your support!',
        prefill: { name: order.name, email: order.email },
        theme: { color: '#2563eb' },
        handler: function (response) { verify(response); },
        modal: { ondismiss: function () { btn.disabled = false; btn.innerHTML = original; } }
      });
      rzp.on('payment.failed', function () { btn.disabled = false; btn.innerHTML = original; showError('Payment failed. Please try again.'); });
      rzp.open();
    })
    .catch(function (err) { btn.disabled = false; btn.innerHTML = original; showError(err.message); });
  });

  function verify(response) {
    fetch('{{ route('donate.verify') }}', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
      body: JSON.stringify(response)
    })
    .then(function (r) { return r.json(); })
    .then(function (d) {
      if (d.verified) {
        document.getElementById('donateForm').style.display = 'none';
        document.getElementById('thanksBox').style.display = 'block';
        if (d.message) document.getElementById('thanksMsg').textContent = d.message;
      } else {
        showError(d.message || 'Payment could not be verified. If you were charged, contact us.');
        btn.disabled = false;
      }
    })
    .catch(function () { showError('Verification failed. If you were charged, please contact us.'); });
  }
})();
</script>
@endif
@endsection
