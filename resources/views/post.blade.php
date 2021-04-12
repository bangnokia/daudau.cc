<x-layout :title="$post->title" :description="$post->description()">

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/styles/default.min.css">
    @endpush

    <div id="post">
        <h1 class="text-cyan-600 text-3xl mb-5 font-bold">{{ $post->title }}</h1>
        <div class="text-gray-400 text-sm mb-10 flex items-center">
            <span>
               Published on <time datetime="{{ $post->created_at }}" class="tracking-tight">
                    {{ date('M, d Y', strtotime($post->created_at)) }}
                </time>
            </span>
            <x-posts.edit-button :date="$post->created_at" :slug="$post->slug" class="ml-5 text-gray-400" />
        </div>

        <div class="relative block">
            <div class="post-content mt-5 leading-7 post-content font-light text-lg box-border break-words">
                {!! $post->content !!}
            </div>
            <div class="absolute top-0 right-0 h-full z-0">
                <x-posts.toc class="hidden lg:block fixed"/>
            </div>
        </div>

        <!-- tags -->
        @if ($post->tags)
            <div class="mt-10">
                <strong>Tags:</strong>
                @foreach ($post->tags as $tag)
                    <span class="tag bg-gray-200 px-2 py-1 cursor-pointer hover:bg-red-300">{{ $tag }}</span>
                @endforeach
            </div>
        @endif

    </div>

    <div class="mt-10">
        <div class="commentbox"></div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/commentbox.io/dist/commentBox.min.js"></script>
        <script>commentBox('5672224602193920-proj')</script>
        <script src="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/highlight.min.js"></script>
        <script src="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/languages/php.min.js"></script>
        <script>hljs.highlightAll();</script>
    @endpush

</x-layout>
