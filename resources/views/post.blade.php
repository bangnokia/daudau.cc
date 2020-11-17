<x-layout :title="$post->title">

	<div id="post">
	    <h1 class="text-red-500 text-3xl">{{ $post->title }}</h1>
	    <div class="mt-5 leading-7 post-content">
	        {!! $post->content !!}
	    </div>
	</div>

</x-layout>
