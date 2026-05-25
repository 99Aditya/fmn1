@extends('frontend.layouts.app')

@section('title', 'CareerElevate | ATS Insight Hub - Smart Resume Analysis')

@section('content')
<div class="container">
    <h1>Blog</h1>

    @if(!empty($categories))
        <div class="blog-categories">
            <strong>Categories:</strong>
            @foreach($categories as $cat)
                @if(isset($activeCategory) && $activeCategory === $cat)
                    <span class="category active">{{ $cat }}</span>
                @else
                    <a href="{{ route('blog.category', ['category' => $cat]) }}" class="category">{{ $cat }}</a>
                @endif
            @endforeach
        </div>
    @endif

    @if(empty($posts))
        <p>No posts yet. Check back later.</p>
    @else
        <ul class="blog-list">
            @foreach($posts as $post)
                <li>
                    <h2><a href="{{ route('blog.show', ['slug' => $post['slug']]) }}">{{ $post['title'] }}</a></h2>
                    <p class="meta">Published: {{ $post['published_at'] ?? 'Unknown' }}</p>
                    <p>{{ $post['excerpt'] ?? '' }}</p>
                    <p><a href="{{ route('blog.show', ['slug' => $post['slug']]) }}">Read more →</a></p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
