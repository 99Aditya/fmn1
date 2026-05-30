@extends('frontend.layouts.app')
@section('title', $test->title)

@section('styles')
<style>
.mcq-page { background: #f8faff; min-height: 100vh; }
.test-hero {
  background: linear-gradient(135deg, #0f172a 0%, #1e40af 60%, #3b82f6 100%);
  padding: 110px 0 60px;
  position: relative;
  overflow: hidden;
}
.test-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.breadcrumb-white .breadcrumb-item a { color: rgba(255,255,255,.65); text-decoration: none; }
.breadcrumb-white .breadcrumb-item.active { color: #fff; }
.breadcrumb-white .breadcrumb-item+.breadcrumb-item::before { color: rgba(255,255,255,.4); }
.diff-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 14px; border-radius: 50px; font-size: .78rem; font-weight: 700; }
.diff-badge.beginner { background: rgba(16,185,129,.2); color: #6ee7b7; border: 1px solid rgba(16,185,129,.3); }
.diff-badge.intermediate { background: rgba(245,158,11,.2); color: #fcd34d; border: 1px solid rgba(245,158,11,.3); }
.diff-badge.advanced { background: rgba(239,68,68,.2); color: #fca5a5; border: 1px solid rgba(239,68,68,.3); }

/* Stats strip */
.stats-strip {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,.07);
  display: flex;
  overflow: hidden;
}
.stat-item {
  flex: 1;
  padding: 20px 16px;
  text-align: center;
  border-right: 1px solid #f1f5f9;
  transition: background .15s;
}
.stat-item:last-child { border-right: none; }
.stat-item:hover { background: #f8faff; }
.stat-num { font-size: 1.5rem; font-weight: 800; color: #0f172a; }
.stat-lbl { font-size: .72rem; color: #94a3b8; text-transform: uppercase; letter-spacing: .4px; margin-top: 2px; }

/* Info card */
.info-section { background: #fff; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.feature-item { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid #f8faff; }
.feature-item:last-child { border-bottom: none; }
.feature-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: .95rem; }

/* CTA card */
.cta-card {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 8px 32px rgba(37,99,235,.12);
  border: 1.5px solid #e0eaff;
  position: sticky;
  top: 86px;
  overflow: hidden;
}
.cta-header {
  background: linear-gradient(135deg, #1e40af, #3b82f6);
  padding: 24px;
  color: #fff;
  text-align: center;
}
.cta-body { padding: 24px; }
.cta-feature { display: flex; align-items: center; gap: 10px; padding: 8px 0; font-size: .9rem; color: #475569; border-bottom: 1px solid #f8faff; }
.cta-feature:last-child { border-bottom: none; }
.cta-feature i { width: 22px; text-align: center; }
.start-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  width: 100%;
  padding: 14px;
  border-radius: 12px;
  background: linear-gradient(135deg, #2563eb, #3b82f6);
  color: #fff;
  font-weight: 700;
  font-size: 1rem;
  border: none;
  cursor: pointer;
  transition: transform .15s, box-shadow .15s;
  text-decoration: none;
  margin-top: 20px;
}
.start-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(37,99,235,.35); color: #fff; }

/* Previous attempts table */
.attempts-table { background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
.attempts-table table { margin-bottom: 0; }
.attempts-table thead th { background: #f8faff; font-size: .78rem; text-transform: uppercase; letter-spacing: .4px; color: #94a3b8; font-weight: 700; border-bottom: 2px solid #e8edf5; padding: 12px 16px; }
.attempts-table tbody td { padding: 12px 16px; vertical-align: middle; font-size: .88rem; border-color: #f1f5f9; }

.cert-notice {
  background: linear-gradient(135deg, #fffbeb, #fef3c7);
  border: 1.5px solid #fde68a;
  border-radius: 14px;
  padding: 16px 20px;
  display: flex;
  align-items: center;
  gap: 14px;
}
.tag-pill { display: inline-block; background: #f1f5f9; color: #475569; border-radius: 50px; font-size: .75rem; font-weight: 600; padding: 4px 12px; margin: 3px 2px; }

@media (max-width: 576px) {
  .test-hero { padding: 90px 0 50px; }
  .stats-strip { flex-wrap: wrap; }
  .stat-item { flex: 0 0 50%; border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; }
  .stat-item:nth-child(2n) { border-right: none; }
  .stat-item:nth-last-child(-n+2) { border-bottom: none; }
  .cta-card { position: static; margin-top: 24px; }
}
</style>
@endsection

@section('content')
<div class="mcq-page">

{{-- Hero --}}
<section class="test-hero text-white">
  <div class="container position-relative">
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb breadcrumb-white mb-0">
        <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">Tests</a></li>
        <li class="breadcrumb-item"><a href="{{ route('tests.category', $category->slug) }}">{{ $category->name }}</a></li>
        <li class="breadcrumb-item active">{{ Str::limit($test->title, 40) }}</li>
      </ol>
    </nav>
    <div class="d-flex flex-wrap gap-2 mb-3">
      <span class="diff-badge {{ $test->difficulty }}">{{ ucfirst($test->difficulty) }}</span>
      @if($test->has_certificate)
        <span style="background:rgba(251,191,36,.18);color:#fcd34d;border:1px solid rgba(251,191,36,.3);padding:5px 14px;border-radius:50px;font-size:.78rem;font-weight:700;display:inline-flex;align-items:center;gap:5px">
          <i class="bi bi-award-fill"></i> Certificate Available
        </span>
      @endif
    </div>
    <h1 style="font-weight:800; font-size:clamp(1.7rem,4vw,2.6rem); line-height:1.2; max-width:640px">{{ $test->title }}</h1>
    @if($test->description)
      <p style="opacity:.75; font-size:1rem; max-width:540px; margin-top:10px">{{ $test->description }}</p>
    @endif
  </div>
</section>

{{-- Body --}}
<section class="py-4 py-md-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-8">

        {{-- Stats strip --}}
        <div class="stats-strip mb-4">
          <div class="stat-item">
            <div class="stat-num">{{ $questionsCount }}</div>
            <div class="stat-lbl">Questions</div>
          </div>
          <div class="stat-item">
            <div class="stat-num">{{ $test->total_time }}<small style="font-size:.9rem;font-weight:500"> min</small></div>
            <div class="stat-lbl">Time Limit</div>
          </div>
          <div class="stat-item">
            <div class="stat-num">{{ $test->total_marks }}</div>
            <div class="stat-lbl">Total Marks</div>
          </div>
          <div class="stat-item">
            <div class="stat-num">{{ $test->passing_marks }}</div>
            <div class="stat-lbl">To Pass</div>
          </div>
        </div>

        {{-- Certificate notice --}}
        @if($test->has_certificate)
          <div class="cert-notice mb-4">
            <i class="bi bi-award-fill text-warning fs-3"></i>
            <div>
              <div style="font-weight:700;color:#0f172a">Certificate of Achievement</div>
              <div style="font-size:.85rem;color:#64748b">Score <strong>{{ $test->certificate_min_score }}%</strong> or above to earn a shareable certificate for this test.</div>
            </div>
          </div>
        @endif

        {{-- What to expect --}}
        <div class="info-section p-4 mb-4">
          <h5 style="font-weight:700;color:#0f172a;margin-bottom:16px">What to Expect</h5>
          <div class="feature-item">
            <div class="feature-icon" style="background:#eff6ff"><i class="bi bi-shield-check text-primary"></i></div>
            <div>
              <div style="font-weight:600;font-size:.9rem;color:#0f172a">{{ $questionsCount }} Multiple Choice Questions</div>
              <div style="font-size:.8rem;color:#64748b">Each question has 4 options with exactly one correct answer.</div>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon" style="background:#fef3c7"><i class="bi bi-clock text-warning"></i></div>
            <div>
              <div style="font-weight:600;font-size:.9rem;color:#0f172a">{{ $test->total_time }}-Minute Timer</div>
              <div style="font-size:.8rem;color:#64748b">Auto-submits when time runs out. You can submit early anytime.</div>
            </div>
          </div>
          <div class="feature-item">
            <div class="feature-icon" style="background:#f0fdf4"><i class="bi bi-bar-chart-fill text-success"></i></div>
            <div>
              <div style="font-weight:600;font-size:.9rem;color:#0f172a">Instant Results &amp; Explanations</div>
              <div style="font-size:.8rem;color:#64748b">See detailed answer review with explanations for each question.</div>
            </div>
          </div>
          @if($test->has_certificate)
          <div class="feature-item">
            <div class="feature-icon" style="background:#fffbeb"><i class="bi bi-award text-warning"></i></div>
            <div>
              <div style="font-weight:600;font-size:.9rem;color:#0f172a">Shareable Certificate</div>
              <div style="font-size:.8rem;color:#64748b">Earned certificates are shareable via a unique public link.</div>
            </div>
          </div>
          @endif
        </div>

        {{-- Tags --}}
        @if($test->hashtags)
          <div class="mb-4">
            <h6 style="font-weight:700;color:#0f172a;margin-bottom:10px">Topics Covered</h6>
            @foreach(explode(',', $test->hashtags) as $tag)
              <span class="tag-pill">#{{ trim($tag) }}</span>
            @endforeach
          </div>
        @endif

        {{-- YouTube --}}
        @if($test->youtube_video_link)
          <div class="info-section p-4 mb-4 d-flex align-items-center gap-3">
            <div style="width:44px;height:44px;background:#fee2e2;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
              <i class="bi bi-youtube" style="color:#ef4444;font-size:1.3rem"></i>
            </div>
            <div class="flex-grow-1">
              <div style="font-weight:700;color:#0f172a;font-size:.95rem">Study Material Available</div>
              <div style="font-size:.8rem;color:#64748b">Watch the related video before attempting the test.</div>
            </div>
            <a href="{{ $test->youtube_video_link }}" target="_blank" class="btn btn-sm rounded-pill px-3" style="background:#fee2e2;color:#ef4444;font-weight:600;border:none;white-space:nowrap">
              Watch Now
            </a>
          </div>
        @endif

        {{-- Previous attempts --}}
        @auth
          @if($userAttempts->count())
            <div class="attempts-table mb-4">
              <div class="px-4 py-3 d-flex justify-content-between align-items-center" style="border-bottom:1.5px solid #e8edf5">
                <h6 style="font-weight:700;color:#0f172a;margin:0">Your Previous Attempts</h6>
                <span style="font-size:.8rem;color:#94a3b8">{{ $userAttempts->count() }} attempt{{ $userAttempts->count() != 1 ? 's' : '' }}</span>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Score</th>
                      <th>Percentage</th>
                      <th>Result</th>
                      <th>Date</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($userAttempts as $att)
                      <tr>
                        <td style="color:#94a3b8">{{ $loop->iteration }}</td>
                        <td style="font-weight:600">{{ $att->score }}<span style="color:#94a3b8">/{{ $test->total_marks }}</span></td>
                        <td>
                          <div style="display:flex;align-items:center;gap:8px">
                            <div style="width:60px;height:5px;background:#f1f5f9;border-radius:99px;overflow:hidden">
                              <div style="width:{{ $att->percentage }}%;height:100%;background:{{ $att->passed ? '#10b981' : '#ef4444' }};border-radius:99px"></div>
                            </div>
                            <span style="font-size:.85rem;font-weight:600">{{ $att->percentage }}%</span>
                          </div>
                        </td>
                        <td>
                          @if($att->passed)
                            <span style="background:#d1fae5;color:#065f46;padding:3px 10px;border-radius:50px;font-size:.75rem;font-weight:700">Passed</span>
                          @else
                            <span style="background:#fee2e2;color:#991b1b;padding:3px 10px;border-radius:50px;font-size:.75rem;font-weight:700">Failed</span>
                          @endif
                          @if($att->certificate_earned)
                            <i class="bi bi-award-fill text-warning ms-1" title="Certificate earned"></i>
                          @endif
                        </td>
                        <td style="color:#64748b;font-size:.82rem">{{ $att->completed_at->format('d M Y') }}</td>
                        <td>
                          <a href="{{ route('tests.attempt.result', [$test, $att]) }}" style="font-size:.8rem;color:#2563eb;font-weight:600;text-decoration:none">Review →</a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          @endif
        @endauth

      </div>

      {{-- Sticky CTA Sidebar --}}
      <div class="col-lg-4">
        <div class="cta-card">
          <div class="cta-header">
            <div style="font-size:2rem;margin-bottom:8px">📋</div>
            <div style="font-weight:800;font-size:1.1rem">Ready to Test Yourself?</div>
            <div style="opacity:.75;font-size:.85rem;margin-top:4px">{{ $test->total_attempts }} people have attempted</div>
            @if($test->total_attempts > 0)
              <div style="margin-top:12px;font-size:.78rem;opacity:.7">Avg Pass Rate: {{ $test->success_rate }}%</div>
              <div style="height:4px;background:rgba(255,255,255,.2);border-radius:99px;overflow:hidden;margin-top:4px">
                <div style="width:{{ $test->success_rate }}%;height:100%;background:rgba(255,255,255,.7);border-radius:99px"></div>
              </div>
            @endif
          </div>
          <div class="cta-body">
            <div class="cta-feature"><i class="bi bi-check-circle-fill text-success"></i> {{ $questionsCount }} MCQ questions</div>
            <div class="cta-feature"><i class="bi bi-clock-fill text-primary"></i> {{ $test->total_time }} minute timer</div>
            <div class="cta-feature"><i class="bi bi-bar-chart-fill" style="color:#8b5cf6"></i> Instant result + explanations</div>
            <div class="cta-feature"><i class="bi bi-arrow-repeat" style="color:#f59e0b"></i> Unlimited retakes</div>
            @if($test->has_certificate)
              <div class="cta-feature"><i class="bi bi-award-fill text-warning"></i> Certificate on {{ $test->certificate_min_score }}%+</div>
            @endif

            @auth
              <form action="{{ route('tests.start', $test) }}" method="POST">
                @csrf
                <button type="submit" class="start-btn">
                  <i class="bi bi-play-fill"></i> Start Test Now
                </button>
              </form>
            @else
              <a href="{{ route('login') }}" class="start-btn">
                <i class="bi bi-box-arrow-in-right"></i> Login to Start
              </a>
              <div style="text-align:center;margin-top:12px;font-size:.78rem;color:#94a3b8">
                Don't have an account? <a href="{{ route('register') }}" style="color:#2563eb;font-weight:600">Sign Up free</a>
              </div>
            @endauth
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

</div>
@endsection
