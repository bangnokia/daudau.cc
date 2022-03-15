<script context="module">
	export async function load({ params, fetch }) {
		const response = await fetch(`https://lab.daudau.cc/api/blog/posts/${params.slug}`);

		return {
			props: {
				post: await response.json()
			}
		};
	}
</script>

<script lang="ts">
	import type { Post } from 'src/types/post';
	import SvelteMarkDown from 'svelte-markdown';
	import { micromark } from 'micromark';

	export let post: Post;
</script>

<div class="prose prose-slate prose-a:text-sky-500">
	<h1 class="text-cyan-600 text-3xl mb-5 font-bold">{post.title}</h1>

	<div class="text-gray-400 text-sm mb-10 flex items-center">
		<span>
			Published on <time datetime={post.created_at} class="tracking-tight">
				{new Date(post.created_at).toDateString()}
			</time>
		</span>
	</div>

	<div id="blog-post-content" class="break-words">
		<SvelteMarkDown source={post.content} />
		<!-- {@html micromark(post.content)} -->
	</div>
</div>
