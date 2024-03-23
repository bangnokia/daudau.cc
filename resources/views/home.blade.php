@extends('app')

@section('content')
    <div>
        <ul style="display: flex; flex-direction: column; gap: 1rem; list-style: none; padding: 0">
            @foreach(collect(cf()->index('posts'))->reverse() as $post)
                <li>
                    <x-date>{{ $post->createdAt }}</x-date>
                    <a href="{{ $post->url() }}" class="block" style="padding: 0.25rem 0;">
                        {{ $post->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
