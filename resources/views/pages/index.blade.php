<x-layout>
	<ul>
        @foreach($posts as $post)
            @if ($post->status === 'published')
                <li class="mt-8">
                    <div class="block text-sm flex space-x-5 content-end">
                        <div class="text-gray-400">[<time datetime="{{ $post->created_at }}">{{ $post->created_at }}</time>]</div>
                        <div class="text-gray-600">{{ implode(', ', $post->tags ?? []) }}</div>
                    </div>

                    <a href="{{ $post->link() }}" class="text-lg mt-5">{{ $post->title }}</a>
                </li>
            @endif
		@endforeach
	</ul>
</x-layout>
