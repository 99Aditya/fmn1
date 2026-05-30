@extends('frontend.layouts.app')
@section('title', 'Certificate — ' . $certificate->certificate_no)

@section('styles')
<style>
.cert-page { background: #f4f7ff; padding: 80px 0 40px; min-height: 100vh; }

/* Action bar */
.cert-actions { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-bottom: 28px; }
.cert-actions .left { display: flex; align-items: center; gap: 10px; }
.cert-actions .right { display: flex; gap: 8px; flex-wrap: wrap; }
.action-btn {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 9px 18px; border-radius: 10px; font-size: .86rem; font-weight: 600;
  text-decoration: none; transition: all .15s; cursor: pointer; border: none;
}
.action-btn.outline { border: 1.5px solid #e2e8f0; background: #fff; color: #475569; }
.action-btn.outline:hover { border-color: #2563eb; color: #2563eb; background: #eff6ff; }
.action-btn.gold { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: #fff; }
.action-btn.gold:hover { opacity: .9; box-shadow: 0 4px 14px rgba(245,158,11,.35); color: #fff; }
.action-btn.primary { background: linear-gradient(135deg, #2563eb, #3b82f6); color: #fff; }
.action-btn.primary:hover { opacity: .9; color: #fff; }

/* Certificate */
.cert-outer {
  max-width: 860px;
  margin: 0 auto;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 20px 60px rgba(0,0,0,.15), 0 4px 16px rgba(0,0,0,.08);
  overflow: hidden;
}
.cert-border {
  border: 18px solid #1e3a5f;
  outline: 6px solid #f59e0b;
  outline-offset: -24px;
  padding: 50px 60px;
  position: relative;
}
.cert-watermark {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
  overflow: hidden;
  z-index: 0;
}
.cert-watermark span {
  font-size: 7rem;
  font-weight: 900;
  color: rgba(37,99,235,.04);
  transform: rotate(-25deg);
  white-space: nowrap;
  letter-spacing: 6px;
}
.cert-content { position: relative; z-index: 1; }

/* Cert header */
.cert-logo-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 30px; }
.cert-brand { font-size: 1.2rem; font-weight: 800; color: #1e3a5f; letter-spacing: .5px; }
.cert-id { font-size: .72rem; font-family: monospace; color: #94a3b8; background: #f8faff; padding: 4px 10px; border-radius: 6px; border: 1px solid #e2e8f0; }

/* Divider */
.cert-divider { display: flex; align-items: center; gap: 14px; margin: 20px 0; }
.cert-divider .line { flex: 1; height: 1.5px; background: linear-gradient(to right, transparent, #f59e0b, transparent); }
.cert-divider .star { color: #f59e0b; font-size: 1rem; }

/* Body */
.cert-title { font-size: 2.4rem; font-weight: 900; color: #1e3a5f; letter-spacing: 2px; text-transform: uppercase; text-align: center; margin-bottom: 4px; }
.cert-subtitle { text-align: center; font-size: .9rem; color: #94a3b8; letter-spacing: .4px; text-transform: uppercase; margin-bottom: 30px; }
.cert-certify { text-align: center; font-size: .95rem; color: #64748b; margin-bottom: 8px; }
.cert-name { text-align: center; font-size: 2.4rem; font-weight: 800; color: #2563eb; border-bottom: 2.5px solid #dbeafe; display: inline-block; padding-bottom: 6px; line-height: 1.1; }
.cert-name-wrap { text-align: center; margin-bottom: 18px; }
.cert-completed { text-align: center; font-size: .95rem; color: #64748b; margin-bottom: 6px; }
.cert-test-name { text-align: center; font-size: 1.4rem; font-weight: 800; color: #1e3a5f; margin-bottom: 6px; }
.cert-score-line { text-align: center; font-size: .9rem; color: #94a3b8; margin-bottom: 24px; }
.cert-score-line strong { color: #0f172a; }
.cert-icon { text-align: center; font-size: 3.2rem; margin-bottom: 16px; }

/* Footer */
.cert-footer { display: flex; justify-content: space-between; align-items: flex-end; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e8edf5; }
.cert-sign { text-align: center; }
.cert-sign-line { width: 140px; height: 1.5px; background: #1e3a5f; margin: 6px auto 4px; }
.cert-sign-label { font-size: .72rem; color: #64748b; text-transform: uppercase; letter-spacing: .4px; }
.cert-date-no { text-align: right; font-size: .78rem; color: #94a3b8; }
.cert-date-no .val { font-size: .85rem; font-weight: 600; color: #0f172a; }

/* Validity notice */
.cert-validity {
  text-align: center;
  margin-top: 28px;
  font-size: .72rem;
  color: #94a3b8;
  background: #f8faff;
  border-radius: 8px;
  padding: 10px 20px;
  border: 1px solid #e2e8f0;
}
.cert-validity a { color: #2563eb; }

/* Print */
@media print {
  .no-print, .cert-page > .container > .cert-actions { display: none !important; }
  .cert-page { padding: 0; background: #fff; }
  .cert-outer { box-shadow: none; max-width: 100%; }
  body * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
@media (max-width: 600px) {
  .cert-border { padding: 30px 20px; }
  .cert-title { font-size: 1.6rem; }
  .cert-name { font-size: 1.7rem; }
  .cert-test-name { font-size: 1.1rem; }
  .cert-footer { flex-direction: column; gap: 20px; align-items: center; text-align: center; }
  .cert-date-no { text-align: center; }
}
</style>
@endsection

@section('content')
<div class="cert-page">
  <div class="container">

    {{-- Actions --}}
    <div class="cert-actions no-print">
      <div class="left">
        <a href="{{ route('tests.index') }}" class="action-btn outline">
          <i class="bi bi-arrow-left"></i> Tests
        </a>
        <span style="font-size:.82rem;color:#94a3b8">Shareable Certificate</span>
      </div>
      <div class="right">
        <button onclick="copyLink()" class="action-btn outline" id="copyBtn">
          <i class="bi bi-link-45deg"></i> Copy Link
        </button>
        <button onclick="window.print()" class="action-btn gold">
          <i class="bi bi-printer-fill"></i> Print / PDF
        </button>
      </div>
    </div>

    {{-- Certificate --}}
    <div class="cert-outer">
      <div class="cert-border">
        <div class="cert-watermark"><span>CERTIFIED</span></div>
        <div class="cert-content">

          <div class="cert-logo-row">
            <div class="cert-brand">Find My Naukri</div>
            <div class="cert-id">{{ $certificate->certificate_no }}</div>
          </div>

          <div class="cert-divider">
            <div class="line"></div>
            <span class="star">★</span><span class="star">★</span><span class="star">★</span>
            <div class="line"></div>
          </div>

          <div class="cert-icon">🏆</div>
          <div class="cert-title">Certificate</div>
          <div class="cert-subtitle">of Achievement</div>

          <div class="cert-certify">This is to proudly certify that</div>
          <div class="cert-name-wrap">
            <span class="cert-name">{{ $user->name }}</span>
          </div>
          <div class="cert-completed">has successfully completed</div>
          <div class="cert-test-name">{{ $certificate->test->title }}</div>
          <div class="cert-score-line">
            with a score of <strong>{{ $certificate->attempt->percentage }}%</strong>
            &nbsp;({{ $certificate->attempt->score }} / {{ $certificate->test->total_marks }} marks)
            &nbsp;&bull;&nbsp; {{ $certificate->attempt->correct_answers }} correct answers
          </div>

          <div class="cert-divider">
            <div class="line"></div>
            <span class="star">✦</span>
            <div class="line"></div>
          </div>

          <div class="cert-footer">
            <div class="cert-sign">
              <div style="font-size:1.3rem;font-weight:800;color:#1e3a5f;font-style:italic">Find My Naukri</div>
              <div class="cert-sign-line"></div>
              <div class="cert-sign-label">Authorized Signature</div>
            </div>
            <div class="cert-date-no">
              <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;color:#94a3b8">Issue Date</div>
              <div class="val">{{ $certificate->issued_at->format('d F Y') }}</div>
              <div style="font-size:.72rem;text-transform:uppercase;letter-spacing:.4px;color:#94a3b8;margin-top:10px">Category</div>
              <div class="val" style="font-size:.82rem">{{ $certificate->test->category->name ?? '—' }}</div>
            </div>
          </div>

        </div>
      </div>
    </div>

    {{-- Verify notice --}}
    <div class="cert-validity no-print mt-3">
      <i class="bi bi-shield-check text-success me-1"></i>
      Verify this certificate at:
      <a href="{{ route('certificates.show', $certificate->certificate_no) }}">{{ route('certificates.show', $certificate->certificate_no) }}</a>
    </div>

  </div>
</div>
@endsection

@section('scripts')
<script>
function copyLink() {
  navigator.clipboard.writeText(window.location.href).then(() => {
    const btn = document.getElementById('copyBtn');
    btn.innerHTML = '<i class="bi bi-check-lg"></i> Copied!';
    btn.style.borderColor = '#10b981';
    btn.style.color = '#059669';
    setTimeout(() => {
      btn.innerHTML = '<i class="bi bi-link-45deg"></i> Copy Link';
      btn.style.borderColor = '';
      btn.style.color = '';
    }, 2500);
  });
}
</script>
@endsection
