<script context="module">
	export async function load({ fetch }) {
		const response = await fetch('https://lab.daudau.cc/api/blog/posts');
		const posts = await response.json();

		return {
			status: response.status,
			maxage: 60 * 60 * 5,
			props: {
				posts
			}
		};
	}
</script>

<script lang="ts">
	import type { Post } from 'src/types/post';

	export let posts: Post[];
</script>

<svelte:head>
	<title>My little Journey | Blog of Nguyen</title>
	<meta name="description" content="I write stupid stuff with words and code" />
</svelte:head>

<ul>
	{#each posts as post}
		<li class="mt-8">
			<div class=" text-sm flex space-x-5 content-end">
				<div class="text-gray-400">[<time datetime={post.created_at}>{post.created_at.substring(0, 10)}</time>]</div>
				<div class="flex gap-x-2 text-gray-600">
					{post.tags.map((tag) => tag.name).join(', ')}
				</div>
			</div>
			<a href="/posts/{post.slug}" class="mt-5 text-sky-500" sveltekit:prefetch>
				{post.title}
			</a>
		</li>
	{/each}
</ul>
