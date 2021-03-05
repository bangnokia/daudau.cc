<x-layout>
	<ul>
		@foreach($posts as $post)
			<li class="mt-5">
				<a href="{{ $post->link() }}">{{ $post->title }}</a>
				[<time datetime="{{ $post->created_at }}" class="text-gray-500">{{ $post->created_at }}</time>]
			</li>
		@endforeach
	</ul>
</x-layout>
