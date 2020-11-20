<x-layout>
	<ul>
		@foreach($posts as $post)
			<li>
				- <a href="{{ $post->link() }}">{{ $post->title }}</a>
				<span class="text-gray-500">[{{ $post->created_at }}]</span>
			</li>
		@endforeach
	</ul>
</x-layout>
