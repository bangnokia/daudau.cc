<x-layout :title="$post->title">

    <h1 class="text-teal-500 text-xl">{{ $post->title }}</h1>

    <div class="mt-5 leading-7 post-content">
        {!! $post->content !!}
    </div>
</x-layout>
