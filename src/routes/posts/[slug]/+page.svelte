<script context="module">
	export async function load({ params, fetch }) {
		const response = await fetch(`https://lab.daudau.cc/api/blog/posts/${params.slug}`);

		return {
			cache: 60 * 60 * 5,
			props: {
				post: await response.json()
			}
		};
	}
</script>

<script lang="ts">
	import type { Post } from 'src/types/post';
	import SvelteMarkDown from 'svelte-markdown';

	export let post: Post;

	let excerpt: string = post.content.split(' ').slice(0, 160).join(' ');
</script>

<svelte:head>
	<title>{post.title} | Blog of Nguyen</title>
	<meta name="description" content={excerpt} />
	<meta property="og:title" content={post.title} />
	<meta property="og:description" content={excerpt} />
	<meta property="og:type" content="article" />
	<meta property="og:image" content={`https://cdn.statically.io/og/${post.title}.jpg`} />
</svelte:head>

<article>
	<h1 class="text-rose-500 text-4xl mb-5 font-bold tracking-tight">{post.title}</h1>

	<div class="text-gray-500 font-mono text-xs mb-10 flex w-full items-center">
		<div>
			<time datetime={post.created_at} class="tracking-tight">
				{new Date(post.created_at).toDateString()}
			</time>
		</div>
		{#if post.tags.length > 0}
			<span class="mx-2">-</span>
			<div class="flex gap-2">
				{#each post.tags as tag}
					<span class="tag">{tag.name}</span>
				{/each}
			</div>
		{/if}
	</div>

	<div id="blog-post-content" class="prose prose-slate break-words text-gray-900">
		<SvelteMarkDown source={post.content} />
	</div>
</article>
