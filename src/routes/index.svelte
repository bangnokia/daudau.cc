<script context="module">
	export async function load({ fetch }) {
		const response = await fetch('https://lab.daudau.cc/api/blog/posts');
		const posts = await response.json();

		return {
			status: response.status,
			cache: 60 * 60 * 5,
			props: {
				posts
			}
		};
	}
</script>

<script lang="ts">
	import type { Post } from '../types/post';

	export let posts: Post[];

	let filterTag = '';

	$: filteredPosts = filterTag ? posts.filter((post) => post.tags.map((tag) => tag.name).includes(filterTag)) : posts;

	function filterByTag(tag: string) {
		filterTag = tag;
	}
</script>

<svelte:head>
	<title>My little journey | Blog of Nguyen</title>
	<meta name="description" content="I write stupid stuff with words and code" />
	<meta property="og:title" content="My little Journey | Blog of Nguyen" />
	<meta property="og:description" content="I write stupid stuff with words and code" />
	<meta property="og:type" content="website" />
	<meta property="og:image" content="https://cdn.statically.io/og/daudau blog.jpg" />
	<meta property="twitter:author" content="@bangnokia" />
</svelte:head>

<h1 class="hidden">Nguyen's blog posts</h1>

<div class="relative">
	<div class={`absolute top-0 -mt-10 text-sm ${filterTag ? 'visible' : 'invisible'}`}>
		Posts with tags: <span class="tag">{filterTag}</span>
		<button type="button" on:click={() => (filterTag = '')} class="hover:text-rose-500">
			<svg
				class="w-3 h-3 inline-block"
				fill="none"
				stroke="currentColor"
				viewBox="0 0 24 24"
				xmlns="http://www.w3.org/2000/svg"
				><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg
			>
		</button>
	</div>

	<ul class="flex flex-col gap-5">
		{#each filteredPosts as post}
			<li>
				<div class="text-sm flex space-x-5 content-end">
					<div class="text-gray-400">[<time datetime={post.created_at}>{post.created_at.substring(0, 10)}</time>]</div>
					<div class="flex gap-x-2 text-gray-600 text-xs">
						{#each post.tags.map((tag) => tag.name) as tagName}
							<span class="tag" on:click={() => filterByTag(tagName)}> {tagName}</span>
						{/each}
					</div>
				</div>
				<a href="/posts/{post.slug}" class="mt-5 text-rose-500 text-lg" sveltekit:prefetch>
					{post.title}
				</a>
			</li>
		{/each}
	</ul>
</div>
