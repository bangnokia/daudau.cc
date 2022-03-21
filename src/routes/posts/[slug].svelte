<script context="module">
	export async function load({ params, fetch }) {
		const response = await fetch(`https://lab.daudau.cc/api/blog/posts/${params.slug}`);

		return {
			maxage: 60 * 60 * 5,
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

	export let excerpt: string = post.content.split(' ').slice(0, 160).join(' ');
</script>

<svelte:head>
	<title>{post.title} | Blog of Nguyen</title>
	<meta name="description" content={excerpt} />
	<meta property="og:title" content={post.title} />
	<meta property="og:description" content={excerpt} />
	<meta property="og:type" content="article" />
	<meta property="og:image" content={`https://cdn.statically.io/og/${post.title}.jpg`} />
</svelte:head>

<div class="prose prose-lg prose-slate prose-a:text-sky-500">
	<h1 class="text-sky-500 text-3xl mb-5 font-bold tracking-tight">{post.title}</h1>

	<div class="text-gray-400 text-sm mb-10 flex items-center">
		<span>
			<time datetime={post.created_at} class="tracking-tight">
				{new Date(post.created_at).toDateString()}
			</time>
		</span>
	</div>

	<div id="blog-post-content" class="break-words">
		<SvelteMarkDown source={post.content} />
	</div>
</div>
