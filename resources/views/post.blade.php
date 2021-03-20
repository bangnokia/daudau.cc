<x-layout :title="$post->title" :description="$post->description()">
    <link rel="stylesheet" href="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/styles/default.min.css">

	<div id="post">
	    <h1 class="text-cyan-600 text-3xl mb-10 text-bold">{{ $post->title }}</h1>
	    <div class="mt-5 leading-7 post-content font-light text-lg">
	        {!! $post->content !!}
	    </div>
	</div>

    <script src="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/highlight.min.js"></script>
    <script src="https://unpkg.com/@highlightjs/cdn-assets@10.6.0/languages/php.min.js"></script>
    <script>hljs.highlightAll();</script>

</x-layout>
