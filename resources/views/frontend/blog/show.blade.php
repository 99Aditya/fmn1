@extends('frontend.layouts.app')
@section('title', $blog->meta_title ?: $blog->title)

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.css">
<meta name="description" content="{{ $blog->meta_description }}">
<meta property="og:title" content="{{ $blog->meta_title ?: $blog->title }}">
<meta property="og:description" content="{{ $blog->meta_description }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
@if($blog->featured_image)
<meta property="og:image" content="{{ $blog->featured_image_url }}">
@endif
<meta name="twitter:card" content="summary_large_image">
<link rel="canonical" href="{{ $blog->canonical_url ?: url()->current() }}">
@php
$jsonLd = ['@context'=>'https://schema.org','@type'=>'Article','headline'=>$blog->title,'description'=>$blog->meta_description,'datePublished'=>$blog->published_at?->toIso8601String(),'dateModified'=>$blog->updated_at->toIso8601String(),'author'=>['@type'=>'Person','name'=>$blog->author?->name??'Find My Naukri'],'publisher'=>['@type'=>'Organization','name'=>'Find My Naukri'],'url'=>url()->current()];
if($blog->featured_image) $jsonLd['image']=$blog->featured_image_url;
@endphp
<script type="application/ld+json">{!! json_encode($jsonLd,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>
<style>
.blog-detail-page{background:#f4f7ff;min-height:100vh}
.reading-progress{position:fixed;top:0;left:0;height:3px;background:linear-gradient(90deg,#2563eb,#34d399);z-index:9999;width:0%;transition:width .1s}
.article-hero{position:relative;min-height:420px;background:#0f172a;display:flex;align-items:flex-end;overflow:hidden}
.hero-img{position:absolute;inset:0;object-fit:cover;width:100%;height:100%}
.hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,.92) 0%,rgba(0,0,0,.5) 50%,rgba(0,0,0,.2) 100%)}
.hero-content{position:relative;z-index:2;padding:80px 0 36px}
.breadcrumb-white .breadcrumb-item a{color:rgba(255,255,255,.65);text-decoration:none}
.breadcrumb-white .breadcrumb-item.active{color:#fff}
.breadcrumb-white .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.3)}
.article-title{font-size:clamp(1.5rem,4vw,2.6rem);font-weight:800;color:#fff;line-height:1.2;max-width:760px}
.article-meta{display:flex;align-items:center;gap:14px;flex-wrap:wrap;margin-top:14px}
.meta-item{display:flex;align-items:center;gap:5px;font-size:.82rem;color:rgba(255,255,255,.7)}
.cat-pill{padding:4px 14px;border-radius:50px;background:rgba(37,99,235,.8);color:#fff;font-size:.75rem;font-weight:700;text-decoration:none}
.article-wrap{display:grid;grid-template-columns:1fr 300px;gap:32px;align-items:start}
.article-card{background:#fff;border-radius:20px;box-shadow:0 4px 24px rgba(0,0,0,.07);border:1.5px solid #e8edf5;overflow:hidden}
.article-body{padding:40px 44px}
.article-content{font-size:1rem;line-height:1.85;color:#334155}
.article-content h1,.article-content h2,.article-content h3,.article-content h4{font-weight:800;color:#0f172a;margin-top:2em;margin-bottom:.6em;line-height:1.3}
.article-content h2{font-size:1.45rem;border-bottom:2px solid #f1f5f9;padding-bottom:8px}
.article-content h3{font-size:1.2rem}
.article-content p{margin-bottom:1.2em}
.article-content a{color:#2563eb;text-decoration:underline}
.article-content ul,.article-content ol{padding-left:1.4em;margin-bottom:1.2em}
.article-content li{margin-bottom:.4em}
.article-content blockquote{border-left:4px solid #2563eb;background:#eff6ff;padding:16px 20px;border-radius:0 10px 10px 0;margin:1.5em 0;font-style:italic;color:#334155}
.article-content blockquote p{margin:0}
.article-content img{max-width:100%;border-radius:10px;margin:1em 0}
.article-content table{width:100%;border-collapse:collapse;margin:1.5em 0;font-size:.9rem}
.article-content table th{background:#0f172a;color:#fff;padding:10px 14px;text-align:left;font-weight:700}
.article-content table td{padding:10px 14px;border-bottom:1px solid #f1f5f9}
.article-content table tr:nth-child(even) td{background:#f8faff}
.article-content pre{border-radius:10px;margin:1.5em 0;font-size:.87rem}
.article-content code:not([class*="language"]){background:#f1f5f9;color:#e11d48;padding:2px 7px;border-radius:5px;font-size:.88em}
.tags-section{padding:20px 44px;border-top:1.5px solid #f1f5f9;display:flex;flex-wrap:wrap;gap:7px;align-items:center}
.tag-link{font-size:.78rem;font-weight:600;background:#f1f5f9;color:#475569;padding:5px 13px;border-radius:50px;text-decoration:none;transition:all .15s}
.tag-link:hover{background:#2563eb;color:#fff}
.share-bar{padding:20px 44px;border-top:1.5px solid #f1f5f9;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.share-btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:50px;font-size:.8rem;font-weight:700;text-decoration:none;transition:all .15s}
.share-btn.tw{background:#e0f2fe;color:#0369a1}
.share-btn.li{background:#eff6ff;color:#1e40af}
.share-btn.cp{background:#f1f5f9;color:#475569;border:none;cursor:pointer}
.share-btn:hover{transform:translateY(-1px);box-shadow:0 4px 12px rgba(0,0,0,.1)}
.sidebar-sticky{position:sticky;top:86px}
.sidebar-card{background:#fff;border-radius:14px;border:1.5px solid #e8edf5;overflow:hidden;margin-bottom:18px;box-shadow:0 2px 10px rgba(0,0,0,.05)}
.sidebar-card-header{padding:14px 18px;background:#fafbfc;border-bottom:1.5px solid #f1f5f9;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:#64748b}
.sidebar-card-body{padding:14px 18px}
.toc-link{display:block;padding:6px 0 6px 10px;border-left:2px solid #e2e8f0;font-size:.83rem;color:#475569;text-decoration:none;transition:all .15s;margin-bottom:2px}
.toc-link:hover,.toc-link.active{border-color:#2563eb;color:#2563eb;background:#eff6ff;border-radius:0 6px 6px 0}
.toc-h3{padding-left:20px;font-size:.78rem}
.related-card{display:flex;gap:12px;padding:10px 0;border-bottom:1px solid #f8faff;text-decoration:none}
.related-card:last-child{border-bottom:none}
.related-card img,.related-card .no-img{width:70px;height:60px;border-radius:8px;object-fit:cover;flex-shrink:0}
.related-card .no-img{background:linear-gradient(135deg,#1e3a5f,#2563eb)}
.related-card .rt{font-size:.8rem;font-weight:700;color:#0f172a;line-height:1.3}
.related-card:hover .rt{color:#2563eb}
.related-card .rm{font-size:.7rem;color:#94a3b8;margin-top:3px}
.author-avatar{width:54px;height:54px;border-radius:50%;object-fit:cover;border:2px solid #e2e8f0;flex-shrink:0}
@media(max-width:1024px){.article-wrap{grid-template-columns:1fr}.sidebar-sticky{position:static}}
@media(max-width:576px){.article-body,.tags-section,.share-bar{padding-left:20px;padding-right:20px}}
</style>
@endsection

@section('content')
<div class="blog-detail-page">
<div class="reading-progress" id="readingProgress"></div>

<div class="article-hero">
  @if($blog->featured_image)
    <img src="{{ $blog->featured_image_url }}" class="hero-img" alt="{{ $blog->title }}">
  @endif
  <div class="hero-overlay"></div>
  <div class="hero-content w-100">
    <div class="container">
      <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb breadcrumb-white mb-0">
          <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
          @if($blog->category)
            <li class="breadcrumb-item"><a href="{{ route('blog.category', $blog->category->slug) }}">{{ $blog->category->name }}</a></li>
          @endif
          <li class="breadcrumb-item active">{{ Str::limit($blog->title,40) }}</li>
        </ol>
      </nav>
      @if($blog->category)
        <a href="{{ route('blog.category', $blog->category->slug) }}" class="cat-pill mb-3 d-inline-block">{{ $blog->category->name }}</a>
      @endif
      <h1 class="article-title">{{ $blog->title }}</h1>
      <div class="article-meta">
        @if($blog->author)
          <span class="meta-item">
            <img src="{{ $blog->author->avatar_url }}" style="width:24px;height:24px;border-radius:50%;object-fit:cover;border:2px solid rgba(255,255,255,.4)" alt="">
            {{ $blog->author->name }}
          </span>
        @endif
        @if($blog->published_at)
          <span class="meta-item"><i class="bi bi-calendar3"></i>{{ $blog->published_at->format('d F Y') }}</span>
        @endif
        <span class="meta-item"><i class="bi bi-clock"></i>{{ $blog->read_time }} min read</span>
        <span class="meta-item"><i class="bi bi-eye"></i>{{ number_format($blog->views) }} views</span>
      </div>
    </div>
  </div>
</div>

<section class="py-4 py-md-5">
  <div class="container">
    <div class="article-wrap">

      <div>
        <div class="article-card">
          @if($blog->excerpt)
            <div style="padding:24px 44px 0">
              <div style="background:#eff6ff;border-left:4px solid #2563eb;padding:14px 18px;border-radius:0 10px 10px 0;font-size:.95rem;color:#334155;font-style:italic;line-height:1.65">{{ $blog->excerpt }}</div>
            </div>
          @endif
          <div class="article-body">
            <div class="article-content" id="articleContent">{!! $blog->content !!}</div>
          </div>
          @if($blog->tags_array)
            <div class="tags-section">
              <span style="font-size:.78rem;font-weight:700;color:#94a3b8;margin-right:4px">Tags:</span>
              @foreach($blog->tags_array as $tag)
                <a href="{{ route('blog.tag', $tag) }}" class="tag-link">#{{ $tag }}</a>
              @endforeach
            </div>
          @endif
          <div class="share-bar">
            <span style="font-size:.8rem;font-weight:700;color:#64748b;margin-right:4px">Share:</span>
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($blog->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn tw"><i class="bi bi-twitter-x"></i> Tweet</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn li"><i class="bi bi-linkedin"></i> Share</a>
            <button class="share-btn cp" onclick="copyUrl(this)"><i class="bi bi-link-45deg"></i> Copy link</button>
          </div>
        </div>

        @if($blog->author)
          <div style="background:#fff;border-radius:16px;border:1.5px solid #e8edf5;padding:22px;margin-top:18px;box-shadow:0 2px 10px rgba(0,0,0,.05)">
            <div style="font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;margin-bottom:14px">About the Author</div>
            <div style="display:flex;gap:14px;align-items:center">
              <img src="{{ $blog->author->avatar_url }}" class="author-avatar" alt="{{ $blog->author->name }}">
              <div>
                <div style="font-weight:700;color:#0f172a;font-size:.9rem">{{ $blog->author->name }}</div>
                @if($blog->author->profile && $blog->author->profile->headline)
                  <div style="font-size:.75rem;color:#64748b">{{ $blog->author->profile->headline }}</div>
                @endif
                @if($blog->author->profile && $blog->author->profile->username)
                  <a href="{{ route('profile.public', $blog->author->profile->username) }}" style="font-size:.75rem;color:#2563eb;font-weight:600;text-decoration:none;margin-top:5px;display:inline-flex;align-items:center;gap:4px">View profile <i class="bi bi-arrow-right"></i></a>
                @endif
              </div>
            </div>
          </div>
        @endif

        @if($related->count())
          <div style="background:#fff;border-radius:16px;border:1.5px solid #e8edf5;overflow:hidden;margin-top:18px;box-shadow:0 2px 10px rgba(0,0,0,.05)">
            <div style="padding:14px 20px;background:#fafbfc;border-bottom:1.5px solid #f1f5f9;font-size:.78rem;font-weight:800;text-transform:uppercase;letter-spacing:.5px;color:#64748b">Related Posts</div>
            <div style="padding:8px 20px">
              @foreach($related as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}" class="related-card">
                  @if($rel->featured_image)
                    <img src="{{ $rel->featured_image_url }}" alt="">
                  @else
                    <div class="no-img"></div>
                  @endif
                  <div>
                    <div class="rt">{{ Str::limit($rel->title, 65) }}</div>
                    <div class="rm"><i class="bi bi-clock me-1"></i>{{ $rel->read_time }} min &bull; {{ $rel->published_at?->format('d M Y') }}</div>
                  </div>
                </a>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      <div class="sidebar-sticky">
        <div class="sidebar-card" id="tocCard" style="display:none">
          <div class="sidebar-card-header">Table of Contents</div>
          <div class="sidebar-card-body" style="padding:10px 18px" id="tocList"></div>
        </div>

        @if($blog->tags_array)
          <div class="sidebar-card">
            <div class="sidebar-card-header">Tags</div>
            <div class="sidebar-card-body" style="display:flex;flex-wrap:wrap;gap:6px">
              @foreach($blog->tags_array as $tag)
                <a href="{{ route('blog.tag', $tag) }}" style="font-size:.75rem;font-weight:600;background:#f1f5f9;color:#475569;padding:4px 12px;border-radius:50px;text-decoration:none">#{{ $tag }}</a>
              @endforeach
            </div>
          </div>
        @endif

        @if($blog->category && $related->count())
          <div class="sidebar-card">
            <div class="sidebar-card-header">More in {{ $blog->category->name }}</div>
            <div class="sidebar-card-body" style="padding:8px 18px">
              @foreach($related->take(3) as $rel)
                <a href="{{ route('blog.show', $rel->slug) }}" class="related-card">
                  @if($rel->featured_image)
                    <img src="{{ $rel->featured_image_url }}" alt="">
                  @else
                    <div class="no-img"></div>
                  @endif
                  <div>
                    <div class="rt">{{ Str::limit($rel->title, 55) }}</div>
                    <div class="rm">{{ $rel->read_time }} min read</div>
                  </div>
                </a>
              @endforeach
              <a href="{{ route('blog.category', $blog->category->slug) }}" style="display:block;margin-top:10px;font-size:.8rem;color:#2563eb;font-weight:600;text-decoration:none">All {{ $blog->category->name }} posts →</a>
            </div>
          </div>
        @endif
      </div>

    </div>
  </div>
</section>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-core.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/autoloader/prism-autoloader.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/line-numbers/prism-line-numbers.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/toolbar/prism-toolbar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/plugins/copy-to-clipboard/prism-copy-to-clipboard.min.js"></script>
<script>
window.addEventListener('scroll', function() {
  var el = document.getElementById('articleContent');
  if (!el) return;
  var top = el.getBoundingClientRect().top + window.scrollY;
  var pct = Math.min(100, Math.max(0, (window.scrollY - top + window.innerHeight * 0.5) / el.offsetHeight * 100));
  document.getElementById('readingProgress').style.width = pct + '%';
});

(function() {
  var headings = document.querySelectorAll('#articleContent h2, #articleContent h3');
  if (headings.length < 2) return;
  var toc = document.getElementById('tocList');
  document.getElementById('tocCard').style.display = 'block';
  headings.forEach(function(h, i) {
    if (!h.id) h.id = 'h-' + i;
    var a = document.createElement('a');
    a.href = '#' + h.id;
    a.className = 'toc-link' + (h.tagName === 'H3' ? ' toc-h3' : '');
    a.textContent = h.textContent;
    a.onclick = function(e) { e.preventDefault(); h.scrollIntoView({behavior:'smooth'}); };
    toc.appendChild(a);
  });
  var obs = new IntersectionObserver(function(entries) {
    entries.forEach(function(e) {
      var l = toc.querySelector('a[href="#' + e.target.id + '"]');
      if (l) l.classList.toggle('active', e.isIntersecting);
    });
  }, {rootMargin:'-20% 0px -70% 0px'});
  headings.forEach(function(h) { obs.observe(h); });
})();

function copyUrl(btn) {
  navigator.clipboard.writeText(window.location.href).then(function() {
    var t = btn.innerHTML;
    btn.innerHTML = '<i class="bi bi-check-lg"></i> Copied!';
    setTimeout(function() { btn.innerHTML = t; }, 2000);
  });
}

document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('#articleContent pre code').forEach(function(el) {
    var m = el.className.match(/language-(\w+)/);
    if (m) el.className = 'language-' + m[1];
    el.parentElement.classList.add('line-numbers');
  });
  if (window.Prism) Prism.highlightAll();
});
</script>
@endsection