<x-layout :title="$post->title">
    <h1>{{ $post->title }}</h1>
    <div>
        {!! $post->content !!}
    </div>
</x-layout>
