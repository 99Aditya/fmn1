@extends('frontend.layouts.app')

@section('title', 'Pricing & Plans — Find My Naukri')
@section('meta_description', 'Upgrade to Pro for adaptive tests, the full ATS resume report and unlimited practice. Simple monthly pricing.')

@section('styles')
<style>
.pr { font-family:'Inter',-apple-system,Segoe UI,Roboto,sans-serif; background:#eef2fb; min-height:100vh; }
.pr-hero { background:linear-gradient(135deg,#0b1220 0%,#1e3a8a 55%,#2563eb 100%); color:#fff; padding:60px 0 90px; text-align:center; position:relative; overflow:hidden; }
.pr-hero::after { content:''; position:absolute; inset:0; background:radial-gradient(circle at 80% 20%,rgba(255,255,255,.12),transparent 45%); }
.pr-hero .container { position:relative; z-index:2; }
.pr-hero h1 { font-size:2.2rem; font-weight:800; margin:6px 0 10px; }
.pr-hero p { opacity:.85; max-width:560px; margin:0 auto; }
.plan-wrap { max-width:880px; margin:-56px auto 60px; padding:0 18px; position:relative; z-index:5; }
.plan-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:20px; }
.plan { background:#fff; border-radius:18px; border:1px solid #e6ebf5; box-shadow:0 10px 32px rgba(15,23,42,.08); padding:30px; position:relative; display:flex; flex-direction:column; }
.plan.popular { border:2px solid #2563eb; box-shadow:0 16px 44px rgba(37,99,235,.18); }
.ribbon { position:absolute; top:-13px; left:50%; transform:translateX(-50%); background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; font-size:.72rem; font-weight:800; letter-spacing:.5px; text-transform:uppercase; padding:6px 16px; border-radius:50px; }
.plan h3 { font-size:1.25rem; font-weight:800; color:#0f172a; margin:0 0 4px; }
.plan .desc { color:#64748b; font-size:.88rem; min-height:42px; }
.price { display:flex; align-items:baseline; gap:4px; margin:16px 0 6px; }
.price .cur { font-size:1.3rem; font-weight:800; color:#0f172a; }
.price .amt { font-size:2.6rem; font-weight:900; color:#0f172a; line-height:1; }
.price .per { color:#94a3b8; font-weight:600; font-size:.9rem; }
.feat-list { list-style:none; padding:0; margin:18px 0 24px; flex-grow:1; }
.feat-list li { display:flex; gap:10px; align-items:flex-start; font-size:.9rem; color:#334155; padding:7px 0; }
.feat-list li i { color:#16a34a; margin-top:2px; }
.feat-list li.off { color:#cbd5e1; }
.feat-list li.off i { color:#e2e8f0; }
.plan-btn { display:block; text-align:center; padding:13px; border-radius:12px; font-weight:800; text-decoration:none; border:none; cursor:pointer; transition:.18s; width:100%; font-size:.98rem; }
.btn-pro { background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; }
.btn-pro:hover:not(:disabled) { box-shadow:0 12px 30px rgba(37,99,235,.32); transform:translateY(-1px); }
.btn-free { background:#f1f5f9; color:#475569; border:1px solid #e2e8f0; }
.btn-current { background:#dcfce7; color:#166534; cursor:default; }
.plan-btn:disabled { opacity:.6; cursor:not-allowed; }
.spinner { width:16px; height:16px; border:2.5px solid rgba(255,255,255,.4); border-top-color:#fff; border-radius:50%; animation:spin .7s linear infinite; display:inline-block; vertical-align:middle; }
@keyframes spin { to { transform:rotate(360deg); } }
.note { text-align:center; color:#94a3b8; font-size:.82rem; margin-top:22px; }
.alert-error { display:none; max-width:520px; margin:14px auto 0; background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:10px; padding:11px 14px; font-size:.86rem; text-align:center; }
.status-msg { max-width:520px; margin:0 auto 18px; background:#eff6ff; border:1px solid #bfdbfe; color:#1e40af; border-radius:10px; padding:11px 14px; font-size:.88rem; text-align:center; }
</style>
@endsection

@php
  $featureLabels = [
    'mcq'           => 'MCQ practice tests',
    'basic_ats'     => 'Basic ATS resume score',
    'advanced_ats'  => 'Full ATS report (graphs, fixes, before/after)',
    'adaptive'      => 'Adaptive tests (difficulty adapts to you)',
    'unlimited_mcq' => 'Unlimited test attempts',
  ];
  $allFeatures = array_keys($featureLabels);
  $currentPlanId = $current?->plan_id;
@endphp

@section('content')
<div class="pr">
  <div class="pr-hero">
    <div class="container">
      <h1>Simple, honest pricing</h1>
      <p>Start free. Upgrade to Pro when you’re ready for adaptive tests, the full ATS report and unlimited practice.</p>
    </div>
  </div>

  <div class="plan-wrap">
    @if(session('status'))
      <div class="status-msg">{{ session('status') }}</div>
    @endif
    <div class="alert-error" id="prError"></div>

    <div class="plan-grid">
      @foreach($plans as $plan)
        @php $isPopular = !$plan->is_free; @endphp
        <div class="plan {{ $isPopular ? 'popular' : '' }}">
          @if($isPopular)<span class="ribbon">Most Popular</span>@endif
          <h3>{{ $plan->name }}</h3>
          <div class="desc">{{ $plan->description }}</div>

          <div class="price">
            @if($plan->is_free)
              <span class="amt">Free</span>
            @else
              <span class="cur">₹</span><span class="amt">{{ (int) $plan->price }}</span><span class="per">{{ $plan->interval_label }}</span>
            @endif
          </div>

          <ul class="feat-list">
            @foreach($allFeatures as $f)
              @php $has = $plan->grants($f); @endphp
              <li class="{{ $has ? '' : 'off' }}">
                <i class="bi bi-{{ $has ? 'check-circle-fill' : 'dash-circle' }}"></i>
                <span>{{ $featureLabels[$f] }}</span>
              </li>
            @endforeach
          </ul>

          @auth
            @if($currentPlanId === $plan->id)
              <button class="plan-btn btn-current" disabled><i class="bi bi-check-lg"></i> Your current plan</button>
            @elseif($plan->is_free)
              <a href="{{ route('tests.index') }}" class="plan-btn btn-free">Start practising</a>
            @else
              <button class="plan-btn btn-pro" data-plan="{{ $plan->id }}"
                      data-order="{{ route('subscribe.order', $plan->id) }}"
                      data-verify="{{ route('subscribe.verify', $plan->id) }}">
                <i class="bi bi-stars"></i> {{ $current && !$current->plan->is_free ? 'Renew / Extend' : 'Upgrade to Pro' }}
              </button>
            @endif
          @else
            @if($plan->is_free)
              <a href="{{ route('register') }}" class="plan-btn btn-free">Get started free</a>
            @else
              <a href="{{ route('login') }}" class="plan-btn btn-pro"><i class="bi bi-stars"></i> Log in to upgrade</a>
            @endif
          @endauth
        </div>
      @endforeach
    </div>

    <p class="note"><i class="bi bi-shield-lock"></i> Secure payment via Razorpay · Cancel anytime · No auto-charge — you renew manually.</p>
  </div>
</div>
@endsection

@section('scripts')
@auth
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
(function () {
  var csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  var errBox = document.getElementById('prError');
  function showError(m){ errBox.textContent = m; errBox.style.display = 'block'; window.scrollTo({top:0,behavior:'smooth'}); }

  document.querySelectorAll('.btn-pro[data-plan]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      errBox.style.display = 'none';
      var orig = btn.innerHTML;
      btn.disabled = true; btn.innerHTML = '<span class="spinner"></span> Preparing…';

      fetch(btn.dataset.order, {
        method: 'POST',
        headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json' },
        body: '{}'
      })
      .then(function(r){ return r.json().then(function(d){ return {ok:r.ok,d:d}; }); })
      .then(function(res){
        if (!res.ok) throw new Error(res.d.message || 'Could not start checkout.');
        var o = res.d;
        var rzp = new Razorpay({
          key: o.key, amount: o.amount, currency: o.currency, order_id: o.order_id,
          name: 'Find My Naukri', description: o.plan + ' subscription',
          prefill: { name: o.name, email: o.email }, theme: { color: '#2563eb' },
          handler: function (resp) {
            fetch(btn.dataset.verify, {
              method:'POST',
              headers:{ 'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json' },
              body: JSON.stringify(resp)
            })
            .then(function(r){ return r.json(); })
            .then(function(d){
              if (d.verified) { window.location = d.redirect || '{{ route('billing') }}'; }
              else { showError(d.message || 'Payment could not be verified.'); btn.disabled=false; btn.innerHTML=orig; }
            })
            .catch(function(){ showError('Verification failed. If you were charged, contact us.'); btn.disabled=false; btn.innerHTML=orig; });
          },
          modal: { ondismiss: function(){ btn.disabled=false; btn.innerHTML=orig; } }
        });
        rzp.on('payment.failed', function(){ showError('Payment failed. Please try again.'); btn.disabled=false; btn.innerHTML=orig; });
        rzp.open();
      })
      .catch(function(e){ showError(e.message); btn.disabled=false; btn.innerHTML=orig; });
    });
  });
})();
</script>
@endauth
@endsection
