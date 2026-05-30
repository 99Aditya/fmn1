@extends('frontend.layouts.app')
@section('title', isset($activeCategory) ? $activeCategory->name . ' — Blog' : (isset($activeTag) ? '#'.$activeTag.' — Blog' : 'Blog'))

@section('styles')
<style>
.blog-page { background:#f4f7ff; min-height:100vh; }
.blog-hero { background:linear-gradient(135deg,#0f172a,#1e40af,#3b82f6); padding:110px 0 60px; position:relative; overflow:hidden; }
.blog-hero::before { content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }

/* Post card */
.post-card { background:#fff; border-radius:16px; border:1.5px solid #e8edf5; overflow:hidden; transition:transform .2s,box-shadow .2s; height:100%; display:flex; flex-direction:column; }
.post-card:hover { transform:translateY(-5px); box-shadow:0 16px 40px rgba(37,99,235,.1); border-color:#bfdbfe; }
.post-card .img-wrap { height:200px; overflow:hidden; position:relative; background:linear-gradient(135deg,#1e3a5f,#2563eb); }
.post-card .img-wrap img { width:100%; height:100%; object-fit:cover; transition:transform .4s; }
.post-card:hover .img-wrap img { transform:scale(1.04); }
.post-card .img-placeholder { width:100%; height:100%; display:flex; align-items:center; justify-content:center; font-size:2.5rem; opacity:.3; }
.cat-badge { position:absolute; top:12px; left:12px; background:rgba(37,99,235,.85); backdrop-filter:blur(8px); color:#fff; padding:4px 12px; border-radius:50px; font-size:.72rem; font-weight:700; text-decoration:none; }
.cat-badge:hover { background:#2563eb; color:#fff; }
.post-body { padding:18px 20px; flex:1; display:flex; flex-direction:column; }
.post-title { font-size:1rem; font-weight:800; color:#0f172a; line-height:1.4; margin-bottom:8px; text-decoration:none; display:block; }
.post-title:hover { color:#2563eb; }
.post-excerpt { font-size:.83rem; color:#64748b; line-height:1.6; flex:1; }
.post-meta { display:flex; align-items:center; gap:10px; font-size:.74rem; color:#94a3b8; margin-top:14px; flex-wrap:wrap; }
.post-tags { margin-top:12px; display:flex; flex-wrap:wrap; gap:5px; }
.tag-pill { font-size:.7rem; font-weight:600; background:#f1f5f9; color:#475569; padding:3px 10px; border-radius:50px; text-decoration:none; transition:all .15s; }
.tag-pill:hover { background:#eff6ff; color:#2563eb; }
.post-read-link { display:inline-flex; align-items:center; gap:5px; margin-top:14px; font-size:.82rem; font-weight:700; color:#2563eb; text-decoration:none; }
.post-read-link:hover { text-decoration:underline; }

/* Sidebar */
.sidebar-card { background:#fff; border-radius:14px; border:1.5px solid #e8edf5; overflow:hidden; margin-bottom:18px; box-shadow:0 2px 10px rgba(0,0,0,.05); }
.sidebar-card-header { padding:14px 18px; background:#fafbfc; border-bottom:1.5px solid #f1f5f9; font-size:.82rem; font-weight:800; text-transform:uppercase; letter-spacing:.5px; color:#64748b; }
.sidebar-card-body { padding:16px 18px; }
.cat-link { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #f8faff; font-size:.85rem; text-decoration:none; color:#334155; font-weight:600; transition:color .15s; }
.cat-link:last-child { border-bottom:none; }
.cat-link:hover { color:#2563eb; }
.cat-link .count { background:#eff6ff; color:#1e40af; padding:2px 8px; border-radius:50px; font-size:.7rem; font-weight:700; }
.popular-post { display:flex; gap:12px; padding:10px 0; border-bottom:1px solid #f8faff; }
.popular-post:last-child { border-bottom:none; }
.popular-post img { width:64px; height:56px; border-radius:8px; object-fit:cover; flex-shrink:0; }
.popular-post .no-img { width:64px; height:56px; border-radius:8px; background:linear-gradient(135deg,#1e3a5f,#2563eb); flex-shrink:0; display:flex; align-items:center; justify-content:center; font-size:1.2rem; }
.popular-post .pt { font-size:.8rem; font-weight:700; color:#0f172a; line-height:1.3; text-decoration:none; display:block; }
.popular-post .pt:hover { color:#2563eb; }
.popular-post .pm { font-size:.7rem; color:#94a3b8; margin-top:3px; }
.cloud-tags { display:flex; flex-wrap:wrap; gap:6px; }
.cloud-tag { font-size:.75rem; font-weight:600; background:#f1f5f9; color:#475569; padding:4px 12px; border-radius:50px; text-decoration:none; transition:all .15s; }
.cloud-tag:hover { background:#2563eb; color:#fff; }
.cloud-tag.active { background:#2563eb; color:#fff; }

/* Filter bar */
.filter-bar { background:#fff; border-radius:12px; padding:12px 18px; border:1.5px solid #e8edf5; display:flex; align-items:center; gap:10px; flex-wrap:wrap; margin-bottom:24px; }
.filter-bar .label { font-size:.78rem; font-weight:700; color:#94a3b8; text-transform:uppercase; letter-spacing:.4px; white-space:nowrap; }
.filter-chip { font-size:.78rem; font-weight:600; padding:5px 14px; border-radius:50px; border:1.5px solid #e2e8f0; background:#fff; color:#475569; text-decoration:none; transition:all .15s; }
.filter-chip:hover, .filter-chip.active { border-color:#2563eb; background:#eff6ff; color:#2563eb; }

/* Empty */
.empty-state { text-align:center; padding:60px 20px; }
.empty-state .icon { font-size:3rem; color:#cbd5e1; margin-bottom:14px; }

@media(max-width:576px) { .blog-hero { padding:90px 0 50px; } }
</style>
@endsection

@section('content')
<div class="blog-page">

<section class="blog-hero text-white">
  <div class="container position-relative">
    @if(isset($activeCategory))
      <div style="font-size:.8rem;opacity:.55;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px">Category</div>
      <h1 style="font-weight:800;font-size:clamp(1.8rem,4vw,2.8rem)">{{ $activeCategory->name }}</h1>
      @if($activeCategory->description)
        <p style="opacity:.7;font-size:1rem;max-width:500px;margin-top:8px">{{ $activeCategory->description }}</p>
      @endif
    @elseif(isset($activeTag))
      <div style="font-size:.8rem;opacity:.55;text-transform:uppercase;letter-spacing:.6px;margin-bottom:8px">Tag</div>
      <h1 style="font-weight:800;font-size:clamp(1.8rem,4vw,2.8rem)">#{{ $activeTag }}</h1>
    @else
      <div style="display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);color:#fff;padding:5px 14px;border-radius:50px;font-size:.78rem;font-weight:700;letter-spacing:.4px;text-transform:uppercase;margin-bottom:16px">
        <i class="bi bi-journal-richtext"></i> Our Blog
      </div>
      <h1 style="font-weight:800;font-size:clamp(1.8rem,4vw,2.8rem);margin-bottom:8px">Tutorials, Tips & Insights</h1>
      <p style="opacity:.75;font-size:1rem;max-width:520px">PHP, Laravel, JavaScript, career tips and tech tutorials — written by practitioners.</p>
    @endif
  </div>
</section>

<section class="py-4 py-md-5">
  <div class="container">
    <div class="row g-4">

      {{-- Posts --}}
      <div class="col-lg-8">

        {{-- Filter chips --}}
        @if($categories->count())
          <div class="filter-bar">
            <span class="label">Filter:</span>
            <a href="{{ route('blog.index') }}" class="filter-chip {{ !isset($activeCategory) && !isset($activeTag) ? 'active' : '' }}">All</a>
            @foreach($categories as $cat)
              <a href="{{ route('blog.category', $cat->slug) }}" class="filter-chip {{ isset($activeCategory) && $activeCategory->id === $cat->id ? 'active' : '' }}">
                {{ $cat->name }}
                <span style="opacity:.6;font-size:.65rem;margin-left:3px">({{ $cat->blogs_count }})</span>
              </a>
            @endforeach
          </div>
        @endif

        @if($blogs->count())
          <div class="row g-3">
            @foreach($blogs as $blog)
              <div class="col-sm-6 col-lg-6">
                <div class="post-card">
                  <div class="img-wrap">
                    @if($blog->featured_image)
                      <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}">
                    @else
                      <div class="img-placeholder">📝</div>
                    @endif
                    @if($blog->category)
                      <a href="{{ route('blog.category', $blog->category->slug) }}" class="cat-badge">{{ $blog->category->name }}</a>
                    @endif
                  </div>
                  <div class="post-body">
                    <a href="{{ route('blog.show', $blog->slug) }}" class="post-title">{{ $blog->title }}</a>
                    @if($blog->excerpt)
                      <div class="post-excerpt">{{ Str::limit($blog->excerpt, 100) }}</div>
                    @endif
                    <div class="post-meta">
                      @if($blog->author)
                        <span><i class="bi bi-person-fill me-1"></i>{{ $blog->author->name }}</span>
                      @endif
                      <span><i class="bi bi-clock me-1"></i>{{ $blog->read_time }} min read</span>
                      <span><i class="bi bi-eye me-1"></i>{{ number_format($blog->views) }}</span>
                      @if($blog->published_at)
                        <span>{{ $blog->published_at->format('d M Y') }}</span>
                      @endif
                    </div>
                    @if($blog->tags_array)
                      <div class="post-tags">
                        @foreach(array_slice($blog->tags_array, 0, 3) as $tag)
                          <a href="{{ route('blog.tag', $tag) }}" class="tag-pill">#{{ $tag }}</a>
                        @endforeach
                      </div>
                    @endif
                    <a href="{{ route('blog.show', $blog->slug) }}" class="post-read-link">
                      Read more <i class="bi bi-arrow-right"></i>
                    </a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          @if($blogs->hasPages())
            <div class="d-flex justify-content-center mt-4">
              {{ $blogs->links() }}
            </div>
          @endif
        @else
          <div class="empty-state">
            <div class="icon"><i class="bi bi-journal-x"></i></div>
            <h5 style="color:#475569;font-weight:700">No posts found</h5>
            <p style="color:#94a3b8">Check back soon — new articles are being written.</p>
            <a href="{{ route('blog.index') }}" style="display:inline-flex;align-items:center;gap:6px;background:linear-gradient(135deg,#2563eb,#3b82f6);color:#fff;padding:10px 22px;border-radius:10px;font-weight:600;text-decoration:none;margin-top:8px">
              All Posts
            </a>
          </div>
        @endif

      </div>

      {{-- Sidebar --}}
      <div class="col-lg-4">

        @if($categories->count())
          <div class="sidebar-card">
            <div class="sidebar-card-header">Categories</div>
            <div class="sidebar-card-body" style="padding:8px 18px">
              @foreach($categories as $cat)
                <a href="{{ route('blog.category', $cat->slug) }}" class="cat-link {{ isset($activeCategory) && $activeCategory->id === $cat->id ? 'text-primary' : '' }}">
                  {{ $cat->name }}
                  <span class="count">{{ $cat->blogs_count }}</span>
                </a>
              @endforeach
            </div>
          </div>
        @endif

        @if(isset($popular) && $popular->count())
          <div class="sidebar-card">
            <div class="sidebar-card-header">Popular Posts</div>
            <div class="sidebar-card-body" style="padding:8px 18px">
              @foreach($popular as $p)
                <div class="popular-post">
                  @if($p->featured_image)
                    <img src="{{ $p->featured_image_url }}" alt="">
                  @else
                    <div class="no-img">📝</div>
                  @endif
                  <div>
                    <a href="{{ route('blog.show', $p->slug) }}" class="pt">{{ Str::limit($p->title, 55) }}</a>
                    <div class="pm"><i class="bi bi-eye me-1"></i>{{ number_format($p->views) }} views &bull; {{ $p->read_time }} min</div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif

        @if(isset($tags) && $tags->count())
          <div class="sidebar-card">
            <div class="sidebar-card-header">Popular Tags</div>
            <div class="sidebar-card-body">
              <div class="cloud-tags">
                @foreach($tags as $tag)
                  <a href="{{ route('blog.tag', $tag) }}" class="cloud-tag {{ isset($activeTag) && $activeTag === $tag ? 'active' : '' }}">#{{ $tag }}</a>
                @endforeach
              </div>
            </div>
          </div>
        @endif

      </div>

    </div>
  </div>
</section>

</div>
@endsection
