@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('blog.index') }}">← Back to blog</a>
    <h1>{{ $post['title'] ?? 'Post' }}</h1>
    <p class="meta">Published: {{ $post['published_at'] ?? 'Unknown' }}</p>
    <div class="post-body">{!! $post['body'] ?? '' !!}</div>
</div>
@endsection
