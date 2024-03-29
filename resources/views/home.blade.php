@extends('app')

@php
    $posts = collect(lina()->index('posts'))->sort(fn($a, $b) => $b->createdAt <=> $a->createdAt);
@endphp

@section('content')
    <div>
        <ul style="display: flex; flex-direction: column; gap: 0.5rem; list-style: none; padding: 0">
            @foreach($posts as $post)
                <li>
                    <div>
                        <x-date>{{ $post->createdAt }}</x-date>
                        <x-tags :tags="$post->tags" />
                    </div>
                    <a href="{{ $post->url() }}" class="block text-lg" style="padding: 0.25rem 0;">
                        {{ $post->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
