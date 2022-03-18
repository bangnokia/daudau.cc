<script>
	import '../app.css';
</script>

<div class="antialiased mx-auto flex flex-col min-h-screen px-5 pt-5 max-w-2xl">
	<nav class="flex space-x-5 flex-none">
		<a href="/" class="text-slate-700 hover:underline" sveltekit:prefetch>home</a>
		<a href="/open-source" class="text-slate-700 hover:underline" sveltekit:prefetch>open source</a>
		<a href="/about" class="text-slate-700 hover:underline" sveltekit:prefetch>about me</a>
	</nav>
	<div class="mt-20 flex-grow flex-shrink flex-1">
		<slot />
	</div>
	<footer class="text-xs flex justify-end h-12 border-t pt-3 mt-10 space-x-2">
		<p>
			crafted by <a href="https://kit.svelte.dev">Sveltekit</a>
			and <a href="https://tailwindcss.com">Tailwind CSS</a>
			with ❤️.
		</p>
	</footer>
</div>
