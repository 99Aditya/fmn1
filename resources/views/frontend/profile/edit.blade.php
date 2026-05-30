@extends('frontend.layouts.app')
@section('title', 'Edit Profile')

@section('styles')
<style>
.edit-page { background:#f4f7ff; min-height:100vh; padding:100px 0 60px; }
.edit-hero { background:linear-gradient(135deg,#0f172a,#1e40af,#3b82f6); padding:110px 0 50px; position:relative; overflow:hidden; }
.edit-hero::before { content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }

/* Tabs */
.edit-tabs { display:flex; gap:4px; background:#fff; border-radius:14px; padding:5px; border:1.5px solid #e8edf5; box-shadow:0 2px 12px rgba(0,0,0,.05); margin-bottom:24px; flex-wrap:wrap; }
.edit-tab { flex:1; min-width:100px; padding:9px 14px; border-radius:10px; border:none; background:transparent; font-weight:600; font-size:.85rem; color:#64748b; cursor:pointer; transition:all .15s; display:flex; align-items:center; justify-content:center; gap:6px; }
.edit-tab.active { background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; box-shadow:0 4px 12px rgba(37,99,235,.25); }
.edit-tab:hover:not(.active) { background:#f8faff; color:#2563eb; }

.tab-panel { display:none; }
.tab-panel.active { display:block; }

/* Cards */
.edit-card { background:#fff; border-radius:16px; border:1.5px solid #e8edf5; box-shadow:0 2px 12px rgba(0,0,0,.05); overflow:hidden; margin-bottom:18px; }
.edit-card-header { padding:16px 22px; background:#fafbfc; border-bottom:1.5px solid #f1f5f9; font-weight:800; font-size:.95rem; color:#0f172a; display:flex; align-items:center; gap:8px; }
.edit-card-header i { color:#2563eb; }
.edit-card-body { padding:22px; }

/* Form */
.form-label-custom { font-size:.8rem; font-weight:700; color:#475569; text-transform:uppercase; letter-spacing:.4px; margin-bottom:5px; }
.form-control-custom { width:100%; padding:10px 14px; border:1.5px solid #e2e8f0; border-radius:10px; font-size:.9rem; color:#0f172a; transition:all .15s; background:#fff; }
.form-control-custom:focus { outline:none; border-color:#2563eb; box-shadow:0 0 0 3px rgba(37,99,235,.12); }
.form-row-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }

/* Avatar uploader */
.avatar-uploader { display:flex; align-items:center; gap:20px; flex-wrap:wrap; }
.avatar-preview { width:88px; height:88px; border-radius:50%; object-fit:cover; border:3px solid #e2e8f0; flex-shrink:0; }
.upload-zone { flex:1; border:2px dashed #e2e8f0; border-radius:12px; padding:16px; text-align:center; cursor:pointer; transition:all .15s; }
.upload-zone:hover { border-color:#2563eb; background:#eff6ff; }
.upload-zone input { display:none; }

/* Skill list */
.skill-row { display:flex; align-items:center; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f1f5f9; }
.skill-row:last-child { border-bottom:none; }
.skill-name { font-weight:600; color:#0f172a; font-size:.9rem; }
.proficiency-bar { height:5px; border-radius:99px; margin-top:4px; }
.proficiency-bar.beginner { width:25%; background:#10b981; }
.proficiency-bar.intermediate { width:55%; background:#3b82f6; }
.proficiency-bar.advanced { width:80%; background:#7c3aed; }
.proficiency-bar.expert { width:100%; background:#f59e0b; }

/* Timeline items */
.timeline-edit-item { background:#f8faff; border:1.5px solid #e8edf5; border-radius:12px; padding:14px 16px; margin-bottom:10px; display:flex; justify-content:space-between; align-items:flex-start; gap:12px; }
.del-btn { width:32px; height:32px; border-radius:8px; background:#fee2e2; color:#ef4444; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; transition:all .15s; font-size:.85rem; }
.del-btn:hover { background:#ef4444; color:#fff; }

/* Save btn */
.save-btn { display:inline-flex; align-items:center; gap:7px; padding:11px 26px; border-radius:12px; background:linear-gradient(135deg,#2563eb,#3b82f6); color:#fff; font-weight:700; font-size:.9rem; border:none; cursor:pointer; transition:all .15s; }
.save-btn:hover { opacity:.9; box-shadow:0 6px 20px rgba(37,99,235,.3); }
.add-btn { display:inline-flex; align-items:center; gap:6px; padding:9px 18px; border-radius:10px; border:2px solid #2563eb; background:#eff6ff; color:#2563eb; font-weight:700; font-size:.85rem; cursor:pointer; transition:all .15s; }
.add-btn:hover { background:#2563eb; color:#fff; }

/* Alert */
.profile-alert { padding:12px 18px; border-radius:10px; margin-bottom:16px; font-size:.88rem; font-weight:600; }
.profile-alert.success { background:#d1fae5; color:#065f46; border:1.5px solid #86efac; }
.profile-alert.error { background:#fee2e2; color:#991b1b; border:1.5px solid #fca5a5; }

@media(max-width:600px) {
  .form-row-grid { grid-template-columns:1fr; }
  .edit-hero { padding:90px 0 40px; }
  .edit-tabs { gap:2px; }
  .edit-tab { font-size:.76rem; padding:8px 8px; }
}
</style>
@endsection

@section('content')
<div class="edit-page" style="padding-top:0">

<section class="edit-hero text-white">
  <div class="container position-relative">
    <h1 style="font-weight:800;font-size:clamp(1.5rem,3vw,2rem);margin-bottom:6px">Edit Your Profile</h1>
    <p style="opacity:.7;margin:0">
      Public link:
      <a href="{{ route('profile.public', $user->profile->username) }}" target="_blank" style="color:#93c5fd;font-weight:600">
        /u/{{ $user->profile->username }}
      </a>
    </p>
  </div>
</section>

<section class="py-4 py-md-5">
<div class="container" style="max-width:820px">

  @if(session('success'))
    <div class="profile-alert success"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="profile-alert error"><i class="bi bi-exclamation-circle-fill me-2"></i>{{ $errors->first() }}</div>
  @endif

  {{-- Tabs --}}
  <div class="edit-tabs">
    <button class="edit-tab active" onclick="switchTab('basic',this)"><i class="bi bi-person-fill"></i> Basic Info</button>
    <button class="edit-tab" onclick="switchTab('avatar',this)"><i class="bi bi-image"></i> Photo</button>
    <button class="edit-tab" onclick="switchTab('skills',this)"><i class="bi bi-stars"></i> Skills</button>
    <button class="edit-tab" onclick="switchTab('experience',this)"><i class="bi bi-briefcase-fill"></i> Experience</button>
    <button class="edit-tab" onclick="switchTab('education',this)"><i class="bi bi-mortarboard-fill"></i> Education</button>
  </div>

  {{-- ── BASIC INFO ── --}}
  <div class="tab-panel active" id="tab-basic">
    <div class="edit-card">
      <div class="edit-card-header"><i class="bi bi-person-fill"></i> Basic Information</div>
      <div class="edit-card-body">
        <form action="{{ route('profile.update.basic') }}" method="POST">
          @csrf
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Full Name *</div>
              <input type="text" name="name" class="form-control-custom" value="{{ old('name', $user->name) }}" required>
            </div>
            <div>
              <div class="form-label-custom">Username * <span style="font-size:.7rem;color:#94a3b8">(used in your URL)</span></div>
              <input type="text" name="username" class="form-control-custom" value="{{ old('username', $user->profile->username) }}" required>
            </div>
          </div>
          <div class="mb-3">
            <div class="form-label-custom">Professional Headline</div>
            <input type="text" name="headline" class="form-control-custom" value="{{ old('headline', $user->profile->headline) }}" placeholder="e.g. Full Stack Developer | PHP & Laravel Expert">
          </div>
          <div class="mb-3">
            <div class="form-label-custom">About / Bio</div>
            <textarea name="bio" class="form-control-custom" rows="4" placeholder="Tell your story...">{{ old('bio', $user->profile->bio) }}</textarea>
          </div>
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Location</div>
              <input type="text" name="location" class="form-control-custom" value="{{ old('location', $user->profile->location) }}" placeholder="City, Country">
            </div>
            <div>
              <div class="form-label-custom">Phone</div>
              <input type="text" name="phone" class="form-control-custom" value="{{ old('phone', $user->profile->phone) }}" placeholder="+91 9999999999">
            </div>
          </div>
          <div class="mb-3">
            <div class="form-label-custom">Website</div>
            <input type="url" name="website" class="form-control-custom" value="{{ old('website', $user->profile->website) }}" placeholder="https://yoursite.com">
          </div>
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">LinkedIn URL</div>
              <input type="url" name="linkedin_url" class="form-control-custom" value="{{ old('linkedin_url', $user->profile->linkedin_url) }}" placeholder="https://linkedin.com/in/...">
            </div>
            <div>
              <div class="form-label-custom">GitHub URL</div>
              <input type="url" name="github_url" class="form-control-custom" value="{{ old('github_url', $user->profile->github_url) }}" placeholder="https://github.com/...">
            </div>
          </div>
          <div class="mb-4">
            <div class="form-label-custom">Twitter / X URL</div>
            <input type="url" name="twitter_url" class="form-control-custom" value="{{ old('twitter_url', $user->profile->twitter_url) }}" placeholder="https://twitter.com/...">
          </div>
          <div class="mb-4 d-flex align-items-center gap-3">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:600;font-size:.88rem;color:#475569">
              <input type="checkbox" name="is_public" value="1" {{ $user->profile->is_public ? 'checked' : '' }} style="width:16px;height:16px;accent-color:#2563eb">
              Make my profile public (visible to everyone)
            </label>
          </div>
          <button type="submit" class="save-btn"><i class="bi bi-floppy-fill"></i> Save Changes</button>
        </form>
      </div>
    </div>
  </div>

  {{-- ── AVATAR ── --}}
  <div class="tab-panel" id="tab-avatar">
    <div class="edit-card">
      <div class="edit-card-header"><i class="bi bi-image"></i> Profile Photo</div>
      <div class="edit-card-body">
        <form action="{{ route('profile.update.avatar') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="avatar-uploader mb-4">
            <img src="{{ $user->profile->avatar_url }}" class="avatar-preview" id="avatarPreview" alt="">
            <div class="upload-zone" onclick="document.getElementById('avatarInput').click()">
              <input type="file" id="avatarInput" name="avatar" accept="image/*" onchange="previewAvatar(event)">
              <i class="bi bi-cloud-upload fs-2 text-primary mb-2"></i>
              <div style="font-weight:600;color:#475569;font-size:.9rem">Click to upload a new photo</div>
              <div style="font-size:.75rem;color:#94a3b8;margin-top:4px">JPG, PNG or WEBP — max 2MB</div>
            </div>
          </div>
          <button type="submit" class="save-btn"><i class="bi bi-floppy-fill"></i> Save Photo</button>
        </form>
      </div>
    </div>
  </div>

  {{-- ── SKILLS ── --}}
  <div class="tab-panel" id="tab-skills">
    <div class="edit-card">
      <div class="edit-card-header"><i class="bi bi-stars"></i> Skills ({{ $user->skills->count() }})</div>
      <div class="edit-card-body">
        @if($user->skills->count())
          @foreach($user->skills as $skill)
            <div class="skill-row">
              <div>
                <div class="skill-name">{{ $skill->skill_name }}</div>
                <div style="font-size:.72rem;color:#94a3b8">{{ ucfirst($skill->proficiency) }}</div>
                <div class="proficiency-bar {{ $skill->proficiency }}"></div>
              </div>
              <form action="{{ route('profile.skills.destroy', $skill) }}" method="POST" onsubmit="return confirm('Remove this skill?')">
                @csrf @method('DELETE')
                <button class="del-btn"><i class="bi bi-trash3-fill"></i></button>
              </form>
            </div>
          @endforeach
          <hr style="margin:16px 0;border-color:#f1f5f9">
        @endif
        <div style="font-weight:700;color:#0f172a;margin-bottom:12px">Add Skill</div>
        <form action="{{ route('profile.skills.store') }}" method="POST">
          @csrf
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Skill Name *</div>
              <input type="text" name="skill_name" class="form-control-custom" placeholder="e.g. PHP, Laravel, React" required>
            </div>
            <div>
              <div class="form-label-custom">Proficiency *</div>
              <select name="proficiency" class="form-control-custom" required>
                <option value="beginner">Beginner</option>
                <option value="intermediate" selected>Intermediate</option>
                <option value="advanced">Advanced</option>
                <option value="expert">Expert</option>
              </select>
            </div>
          </div>
          <button type="submit" class="add-btn"><i class="bi bi-plus-lg"></i> Add Skill</button>
        </form>
      </div>
    </div>
  </div>

  {{-- ── EXPERIENCE ── --}}
  <div class="tab-panel" id="tab-experience">
    <div class="edit-card">
      <div class="edit-card-header"><i class="bi bi-briefcase-fill"></i> Work Experience</div>
      <div class="edit-card-body">
        @foreach($user->experiences as $exp)
          <div class="timeline-edit-item">
            <div>
              <div style="font-weight:700;color:#0f172a">{{ $exp->position }}</div>
              <div style="font-size:.85rem;color:#2563eb;font-weight:600">{{ $exp->company }}</div>
              <div style="font-size:.75rem;color:#94a3b8;margin-top:2px">{{ $exp->duration }} &bull; {{ $exp->length }}</div>
            </div>
            <form action="{{ route('profile.experiences.destroy', $exp) }}" method="POST" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button class="del-btn"><i class="bi bi-trash3-fill"></i></button>
            </form>
          </div>
        @endforeach

        <div style="font-weight:700;color:#0f172a;margin:{{ $user->experiences->count() ? '16px' : '0' }} 0 12px">Add Experience</div>
        <form action="{{ route('profile.experiences.store') }}" method="POST">
          @csrf
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Job Title *</div>
              <input type="text" name="position" class="form-control-custom" placeholder="e.g. Full Stack Developer" required>
            </div>
            <div>
              <div class="form-label-custom">Company *</div>
              <input type="text" name="company" class="form-control-custom" placeholder="Company name" required>
            </div>
          </div>
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Employment Type</div>
              <select name="employment_type" class="form-control-custom">
                <option value="">Select type</option>
                <option>Full-time</option>
                <option>Part-time</option>
                <option>Freelance</option>
                <option>Internship</option>
                <option>Contract</option>
              </select>
            </div>
            <div>
              <div class="form-label-custom">Location</div>
              <input type="text" name="location" class="form-control-custom" placeholder="City, Remote">
            </div>
          </div>
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Start Date *</div>
              <input type="date" name="start_date" class="form-control-custom" required>
            </div>
            <div>
              <div class="form-label-custom">End Date</div>
              <input type="date" name="end_date" class="form-control-custom" id="expEndDate">
            </div>
          </div>
          <div class="mb-3">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.85rem;font-weight:600;color:#475569">
              <input type="checkbox" name="is_current" value="1" id="currentJob" style="accent-color:#2563eb" onchange="document.getElementById('expEndDate').disabled=this.checked">
              I currently work here
            </label>
          </div>
          <div class="mb-4">
            <div class="form-label-custom">Description</div>
            <textarea name="description" class="form-control-custom" rows="3" placeholder="Key responsibilities and achievements..."></textarea>
          </div>
          <button type="submit" class="add-btn"><i class="bi bi-plus-lg"></i> Add Experience</button>
        </form>
      </div>
    </div>
  </div>

  {{-- ── EDUCATION ── --}}
  <div class="tab-panel" id="tab-education">
    <div class="edit-card">
      <div class="edit-card-header"><i class="bi bi-mortarboard-fill"></i> Education</div>
      <div class="edit-card-body">
        @foreach($user->educations as $edu)
          <div class="timeline-edit-item">
            <div>
              <div style="font-weight:700;color:#0f172a">{{ $edu->institution }}</div>
              <div style="font-size:.85rem;color:#7c3aed;font-weight:600">{{ $edu->degree }}{{ $edu->field_of_study ? ' — '.$edu->field_of_study : '' }}</div>
              <div style="font-size:.75rem;color:#94a3b8;margin-top:2px">{{ $edu->duration }}</div>
            </div>
            <form action="{{ route('profile.educations.destroy', $edu) }}" method="POST" onsubmit="return confirm('Delete?')">
              @csrf @method('DELETE')
              <button class="del-btn"><i class="bi bi-trash3-fill"></i></button>
            </form>
          </div>
        @endforeach

        <div style="font-weight:700;color:#0f172a;margin:{{ $user->educations->count() ? '16px' : '0' }} 0 12px">Add Education</div>
        <form action="{{ route('profile.educations.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <div class="form-label-custom">Institution / University *</div>
            <input type="text" name="institution" class="form-control-custom" placeholder="e.g. University of Delhi" required>
          </div>
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Degree</div>
              <input type="text" name="degree" class="form-control-custom" placeholder="e.g. B.Tech, MBA, BCA">
            </div>
            <div>
              <div class="form-label-custom">Field of Study</div>
              <input type="text" name="field_of_study" class="form-control-custom" placeholder="e.g. Computer Science">
            </div>
          </div>
          <div class="form-row-grid mb-3">
            <div>
              <div class="form-label-custom">Start Year *</div>
              <input type="number" name="start_year" class="form-control-custom" placeholder="2020" min="1950" max="2030" required>
            </div>
            <div>
              <div class="form-label-custom">End Year</div>
              <input type="number" name="end_year" class="form-control-custom" placeholder="2024" min="1950" max="2030" id="eduEndYear">
            </div>
          </div>
          <div class="mb-3">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.85rem;font-weight:600;color:#475569">
              <input type="checkbox" name="is_current" value="1" style="accent-color:#2563eb" onchange="document.getElementById('eduEndYear').disabled=this.checked">
              Currently studying here
            </label>
          </div>
          <div class="mb-4">
            <div class="form-label-custom">Description</div>
            <textarea name="description" class="form-control-custom" rows="2" placeholder="Activities, achievements, GPA..."></textarea>
          </div>
          <button type="submit" class="add-btn"><i class="bi bi-plus-lg"></i> Add Education</button>
        </form>
      </div>
    </div>
  </div>

</div>
</section>
</div>
@endsection

@section('scripts')
<script>
function switchTab(name, btn) {
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.edit-tab').forEach(t => t.classList.remove('active'));
  document.getElementById('tab-' + name).classList.add('active');
  btn.classList.add('active');
  history.replaceState(null,'','?tab='+name);
}

// Restore tab from URL
const urlTab = new URLSearchParams(location.search).get('tab');
if (urlTab) {
  const btn = [...document.querySelectorAll('.edit-tab')].find(b => b.onclick.toString().includes("'"+urlTab+"'"));
  if (btn) switchTab(urlTab, btn);
}

function previewAvatar(e) {
  const file = e.target.files[0];
  if (file) document.getElementById('avatarPreview').src = URL.createObjectURL(file);
}
</script>
@endsection
