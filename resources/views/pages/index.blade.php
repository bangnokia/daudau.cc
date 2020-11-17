<x-layout title="daudau's stubs">
	<ul>
		@foreach($posts as $post)
			<li>
				<div class="text-gray-600">
					[{{ $post->created_at }}]
				</div>
				<a href="{{ $post->link() }}">{{ $post->title }}</a>
			</li>
		@endforeach
	</ul>
</x-layout>
