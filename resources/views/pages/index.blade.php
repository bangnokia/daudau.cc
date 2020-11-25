<x-layout>
	<ul>
		@foreach($posts as $post)
			<li>
				<a href="{{ $post->link() }}">{{ $post->title }}</a>
				- <time class="text-gray-500">{{ $post->created_at }}</time>
			</li>
		@endforeach
	</ul>
</x-layout>
