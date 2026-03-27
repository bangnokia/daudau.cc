@extends('layout')

@php
    $posts = collect(lina()->index('posts'))->sort(fn($a, $b) => $b->createdAt <=> $a->createdAt);
@endphp

@section('content')
    <div>
        <ul style="display: flex; flex-direction: column; gap: 1rem; list-style: none; padding: 0">
            @foreach($posts as $post)
                <li>
                    @php
                        $postUrl = $post->url();
                        if (!str_starts_with($postUrl, 'http://') && !str_starts_with($postUrl, 'https://') && !str_starts_with($postUrl, '/')) {
                            $postUrl = '/' . $postUrl;
                        }
                    @endphp
                    <div class="text-sm">
                        <x-date>{{ $post->createdAt }}</x-date>
                        <x-tags :tags="$post->tags" />
                    </div>
                    <a href="{{ $postUrl }}" class="block home-post-link" style="padding: 0.25rem 0;">
                        {{ $post->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
