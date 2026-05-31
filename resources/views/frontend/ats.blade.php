@extends('frontend.layouts.app')
@section('title', 'ATS Resume Checker')

@section('styles')
<style>
.ats-up { background:linear-gradient(160deg,#eef2fb 0%,#e0e9fb 100%); min-height:100vh; padding:60px 0; font-family:'Inter',-apple-system,Segoe UI,Roboto,sans-serif; }
.ats-up .head { text-align:center; max-width:640px; margin:0 auto 36px; }
.ats-up .pill { display:inline-flex; align-items:center; gap:7px; background:#dbe7ff; color:#1d4ed8; font-weight:700; font-size:.8rem; padding:6px 15px; border-radius:50px; margin-bottom:16px; }
.ats-up h1 { font-size:2.1rem; font-weight:800; color:#0f172a; margin:0 0 12px; }
.ats-up .lead { color:#64748b; font-size:1.02rem; line-height:1.6; }

.up-card { max-width:620px; margin:0 auto; background:#fff; border-radius:20px; box-shadow:0 12px 40px rgba(15,23,42,.1); padding:32px; }
.drop { border:2.5px dashed #c7d4ee; border-radius:16px; padding:44px 24px; text-align:center; cursor:pointer; transition:.2s; background:#f8faff; }
.drop:hover, .drop.drag { border-color:#2563eb; background:#eff4ff; }
.drop .icon { width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,#2563eb,#60a5fa); color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.7rem; margin:0 auto 16px; }
.drop .dt { font-weight:700; color:#0f172a; font-size:1.05rem; }
.drop .ds { color:#94a3b8; font-size:.85rem; margin-top:6px; }
.drop .formats { display:inline-flex; gap:6px; margin-top:16px; flex-wrap:wrap; justify-content:center; }
.drop .fmt { background:#eef2f9; color:#64748b; font-size:.7rem; font-weight:700; padding:4px 10px; border-radius:6px; }

.file-chosen { display:none; align-items:center; gap:13px; background:#ecfdf5; border:1px solid #bbf7d0; border-radius:12px; padding:14px 16px; margin-top:18px; }
.file-chosen .fi { width:40px; height:40px; border-radius:9px; background:#10b981; color:#fff; display:flex; align-items:center; justify-content:center; font-size:1.2rem; flex-shrink:0; }
.file-chosen .fn { font-weight:700; color:#065f46; font-size:.9rem; word-break:break-all; }
.file-chosen .fs { color:#059669; font-size:.78rem; }
.file-chosen .fx { margin-left:auto; color:#94a3b8; cursor:pointer; background:none; border:none; font-size:1.2rem; }

.btn-go { width:100%; margin-top:20px; padding:14px; border:none; border-radius:12px; background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; font-weight:800; font-size:1rem; cursor:pointer; transition:.2s; display:flex; align-items:center; justify-content:center; gap:9px; }
.btn-go:hover:not(:disabled) { box-shadow:0 10px 28px rgba(37,99,235,.35); }
.btn-go:disabled { opacity:.6; cursor:not-allowed; }
.spinner { width:18px; height:18px; border:2.5px solid rgba(255,255,255,.4); border-top-color:#fff; border-radius:50%; animation:spin .7s linear infinite; }
@keyframes spin { to { transform:rotate(360deg); } }

.trust { display:flex; justify-content:center; gap:26px; margin-top:30px; flex-wrap:wrap; }
.trust .ti { display:flex; align-items:center; gap:8px; color:#64748b; font-size:.85rem; font-weight:600; }
.trust .ti i { color:#10b981; }
.err { background:#fee2e2; border:1px solid #fecaca; color:#991b1b; border-radius:10px; padding:12px 14px; font-size:.88rem; margin-bottom:18px; }
</style>
@endsection

@section('content')
<div class="ats-up">
  <div class="container">

    <div class="head">
      <span class="pill"><i class="bi bi-shield-check"></i> Free ATS Scanner</span>
      <h1>Is your resume ATS-ready?</h1>
      <p class="lead">Upload your resume and get an instant compatibility score, with a detailed breakdown of what recruiters’ tracking systems see — and exactly how to improve it.</p>
    </div>

    <div class="up-card">
      @if($errors->any())
        <div class="err"><i class="bi bi-exclamation-triangle"></i> {{ $errors->first() }}</div>
      @endif

      <form action="{{ route('ats.upload') }}" method="POST" enctype="multipart/form-data" id="atsForm">
        @csrf

        <label class="drop" id="dropZone">
          <div class="icon"><i class="bi bi-cloud-arrow-up"></i></div>
          <div class="dt">Drop your resume here, or <span style="color:#2563eb">browse</span></div>
          <div class="ds">Maximum file size: 5 MB</div>
          <div class="formats">
            <span class="fmt">PDF</span><span class="fmt">DOCX</span><span class="fmt">DOC</span><span class="fmt">TXT</span>
          </div>
          <input type="file" name="resume" id="resumeInput" accept=".pdf,.doc,.docx,.txt" required hidden>
        </label>

        <div class="file-chosen" id="fileChosen">
          <div class="fi"><i class="bi bi-file-earmark-text"></i></div>
          <div>
            <div class="fn" id="fileName"></div>
            <div class="fs" id="fileSize"></div>
          </div>
          <button type="button" class="fx" id="fileRemove" title="Remove">&times;</button>
        </div>

        <button type="submit" class="btn-go" id="goBtn" disabled>
          <span id="goText"><i class="bi bi-magic"></i> Analyze My Resume</span>
        </button>
      </form>
    </div>

    <div class="trust">
      <div class="ti"><i class="bi bi-check-circle-fill"></i> Instant results</div>
      <div class="ti"><i class="bi bi-check-circle-fill"></i> No sign-up to scan</div>
      <div class="ti"><i class="bi bi-check-circle-fill"></i> 100% free</div>
    </div>

  </div>
</div>

<script>
(function () {
  var input = document.getElementById('resumeInput');
  var drop = document.getElementById('dropZone');
  var chosen = document.getElementById('fileChosen');
  var nameEl = document.getElementById('fileName');
  var sizeEl = document.getElementById('fileSize');
  var removeBtn = document.getElementById('fileRemove');
  var goBtn = document.getElementById('goBtn');
  var goText = document.getElementById('goText');
  var form = document.getElementById('atsForm');

  function fmtSize(b) {
    if (b < 1024) return b + ' B';
    if (b < 1048576) return (b / 1024).toFixed(1) + ' KB';
    return (b / 1048576).toFixed(1) + ' MB';
  }

  function showFile(file) {
    nameEl.textContent = file.name;
    sizeEl.textContent = fmtSize(file.size);
    chosen.style.display = 'flex';
    drop.style.display = 'none';
    goBtn.disabled = false;
  }

  input.addEventListener('change', function () {
    if (input.files.length) showFile(input.files[0]);
  });

  removeBtn.addEventListener('click', function () {
    input.value = '';
    chosen.style.display = 'none';
    drop.style.display = 'block';
    goBtn.disabled = true;
  });

  ['dragover', 'dragenter'].forEach(function (e) {
    drop.addEventListener(e, function (ev) { ev.preventDefault(); drop.classList.add('drag'); });
  });
  ['dragleave', 'drop'].forEach(function (e) {
    drop.addEventListener(e, function (ev) { ev.preventDefault(); drop.classList.remove('drag'); });
  });
  drop.addEventListener('drop', function (ev) {
    if (ev.dataTransfer.files.length) {
      input.files = ev.dataTransfer.files;
      showFile(ev.dataTransfer.files[0]);
    }
  });

  form.addEventListener('submit', function () {
    goBtn.disabled = true;
    goText.innerHTML = '<span class="spinner"></span> Analyzing…';
  });
})();
</script>
@endsection
