@extends('layout')

@php
    $posts = collect(lina()->index('posts'))->sort(fn($a, $b) => $b->createdAt <=> $a->createdAt);
@endphp

@section('content')
    <div>
        <ul class="home-post-list">
            @foreach($posts as $post)
                <li class="home-post-item">
                    @php
                        $postUrl = $post->url();
                        if (!str_starts_with($postUrl, 'http://') && !str_starts_with($postUrl, 'https://') && !str_starts_with($postUrl, '/')) {
                            $postUrl = '/' . $postUrl;
                        }
                    @endphp
                    <div class="post-meta">
                        <x-date>{{ $post->createdAt }}</x-date>
                        <x-tags :tags="$post->tags" />
                    </div>
                    <a href="{{ $postUrl }}" class="block home-post-link">
                        {{ $post->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
