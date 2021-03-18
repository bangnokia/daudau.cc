<x-layout :title="$post->title" :description="$post->description()">

	<div id="post">
	    <h1 class="text-cyan-600 text-3xl mb-10 text-bold">{{ $post->title }}</h1>
	    <div class="mt-5 leading-7 post-content font-light text-lg">
	        {!! $post->content !!}
	    </div>
	</div>

</x-layout>
