@extends('frontend.layouts.app')
@section('title', $category->name . ' Tests')

@section('styles')
<style>
.mcq-page { background: #f8faff; min-height: 100vh; }
.cat-hero {
  background: linear-gradient(135deg, #0f172a 0%, #1e40af 60%, #3b82f6 100%);
  padding: 110px 0 60px;
  position: relative;
  overflow: hidden;
}
.cat-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.breadcrumb-white .breadcrumb-item a { color: rgba(255,255,255,.65); text-decoration: none; }
.breadcrumb-white .breadcrumb-item.active { color: #fff; }
.breadcrumb-white .breadcrumb-item+.breadcrumb-item::before { color: rgba(255,255,255,.4); }

.test-card {
  background: #fff;
  border: 1.5px solid #e8edf5;
  border-radius: 16px;
  overflow: hidden;
  transition: transform .22s cubic-bezier(.4,0,.2,1), box-shadow .22s;
  height: 100%;
  display: flex;
  flex-direction: column;
}
.test-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 16px 40px rgba(37,99,235,.12);
  border-color: #bfdbfe;
}
.card-accent { height: 4px; }
.card-accent.beginner { background: linear-gradient(90deg, #10b981, #34d399); }
.card-accent.intermediate { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
.card-accent.advanced { background: linear-gradient(90deg, #ef4444, #f87171); }
.card-body-inner { padding: 20px; flex: 1; display: flex; flex-direction: column; }
.diff-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 50px; font-size: .72rem; font-weight: 700; }
.diff-badge.beginner { background: #d1fae5; color: #065f46; }
.diff-badge.intermediate { background: #fef3c7; color: #92400e; }
.diff-badge.advanced { background: #fee2e2; color: #991b1b; }
.cert-badge { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 50px; font-size: .72rem; font-weight: 700; background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
.card-title-text { font-size: 1rem; font-weight: 700; color: #0f172a; line-height: 1.35; margin: 10px 0 6px; }
.card-desc { font-size: .83rem; color: #64748b; line-height: 1.55; }
.card-meta { display: flex; gap: 14px; margin: 14px 0 16px; flex-wrap: wrap; }
.meta-item { display: flex; align-items: center; gap: 5px; font-size: .78rem; color: #64748b; }
.meta-item i { color: #94a3b8; }
.card-cta { display: block; text-align: center; padding: 10px; border-radius: 10px; background: linear-gradient(135deg, #2563eb, #3b82f6); color: #fff; font-weight: 600; font-size: .9rem; text-decoration: none; transition: opacity .2s; margin-top: auto; }
.card-cta:hover { opacity: .88; color: #fff; }

.empty-state { text-align: center; padding: 80px 20px; }
.empty-state .icon { font-size: 3.5rem; color: #cbd5e1; }

@media (max-width: 576px) { .cat-hero { padding: 90px 0 50px; } }
</style>
@endsection

@section('content')
<div class="mcq-page">

<section class="cat-hero text-white">
  <div class="container position-relative">
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb breadcrumb-white mb-0">
        <li class="breadcrumb-item"><a href="{{ route('tests.index') }}">Tests</a></li>
        <li class="breadcrumb-item active">{{ $category->name }}</li>
      </ol>
    </nav>
    <h1 class="fw-800 mb-2" style="font-weight:800; font-size:clamp(1.8rem,4vw,2.8rem)">{{ $category->name }}</h1>
    @if($category->description)
      <p style="opacity:.75; font-size:1.05rem; max-width:500px">{{ $category->description }}</p>
    @endif
    <div class="d-flex align-items-center gap-3 mt-2" style="font-size:.85rem; opacity:.65">
      <span><i class="bi bi-clipboard-check me-1"></i>{{ $tests->count() }} test{{ $tests->count() != 1 ? 's' : '' }}</span>
      <span><i class="bi bi-people me-1"></i>{{ number_format($tests->sum('total_attempts')) }} total attempts</span>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    @if($tests->isEmpty())
      <div class="empty-state">
        <div class="icon mb-3"><i class="bi bi-clipboard2-x"></i></div>
        <h5 style="color:#475569; font-weight:700">No tests in this category yet</h5>
        <p style="color:#94a3b8">Tests are being added. Check back soon.</p>
        <a href="{{ route('tests.index') }}" class="btn btn-primary mt-2 rounded-pill px-4">Browse All Tests</a>
      </div>
    @else
      <div class="row g-3">
        @foreach($tests as $test)
          <div class="col-sm-6 col-lg-4">
            @include('frontend.tests.partials.card', ['test' => $test, 'category' => $category])
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>

</div>
@endsection
