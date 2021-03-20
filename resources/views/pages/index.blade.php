<x-layout>
	<ul>
        @foreach($posts as $post)
            @if ($post->status === 'published')
                <li class="mt-5">
                    <div class="block text-gray-500 text-base">
                        [<time datetime="{{ $post->created_at }}">{{ $post->created_at }}</time>]
                    </div>
                    <a href="{{ $post->link() }}" class="text-lg">{{ $post->title }}</a>
                </li>
            @endif
		@endforeach
	</ul>
</x-layout>
