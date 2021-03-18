<x-layout>
	<ul>
        @foreach($posts as $post)
            @if ($post->status === 'published')
                <li class="mt-5">
                    <a href="{{ $post->link() }}" class="text-lg">{{ $post->title }}</a>
                    [<time datetime="{{ $post->created_at }}" class="text-gray-500">{{ $post->created_at }}</time>]
                </li>
            @endif
		@endforeach
	</ul>
</x-layout>
