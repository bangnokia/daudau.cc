<script lang="ts">
	import type { Post } from '../types/post';
	import Tag from '../components/Tag.svelte';
	import { onMount } from 'svelte';

	/** @type {import('./$types').PageData}*/
	export let data;

	let posts: Post[] = data.posts;
	let filterTag = '';

	$: filteredPosts = filterTag ? posts.filter((post: Post) => post.tags.includes(filterTag)) : posts;

	function filterByTag(tag: string) {
		filterTag = tag;
	}

	onMount(() => {
		const tag = new URLSearchParams(location.search).get('tag');
		if (tag) {
			filterByTag(tag);
		}
	});
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
		Posts with tags: <Tag on:click={() => (filterTag = '')}>{filterTag}</Tag>
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
					<div class="text-neutral-600">
						<time datetime={post.createdAt}>{new Date(post.createdAt).toDateString()}</time>
					</div>
					<div class="flex gap-x-2 text-gray-600 text-xs">
						{#each post.tags as tag}
							<Tag on:click={() => filterByTag(tag)}>{tag}</Tag>
						{/each}
					</div>
				</div>
				<a
					href="/posts/{post.slug}"
					class="mt-5 text-gray-300 hover:text-gray-100 hover:no-underline text-lg transition"
					data-sveltekit-preload-data="hover"
				>
					{post.title}
				</a>
			</li>
		{/each}
	</ul>
</div>
