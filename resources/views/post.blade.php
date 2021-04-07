<x-layout :title="$post->title" :description="$post->description()">

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/styles/default.min.css">
    @endpush

	<div id="post">
	    <h1 class="text-cyan-600 text-3xl mb-5 font-bold">{{ $post->title }}</h1>
	    <div class="text-gray-400 text-sm mb-10">
            <span>Published on</span>
            <time datetime="{{ $post->created_at }}" class="tracking-tight">
                {{ date('M, d Y', strtotime($post->created_at)) }}
            </time>
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
	    	<div class="mt-5">
	    		<strong>Tags:</strong>
	    		@foreach ($post->tags as $tag)
	    			<span class="tag bg-gray-200 px-2 py-1 cursor-pointer hover:bg-red-300">{{ $tag }}</span>
	    		@endforeach
	    	</div>
	    @endif

	</div>

    @push('scripts')
        <script src="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/highlight.min.js"></script>
        <script src="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/languages/php.min.js"></script>
        <script>hljs.highlightAll();</script>
    @endpush

</x-layout>
