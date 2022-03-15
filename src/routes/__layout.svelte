<script>
	import '../app.css';
</script>

<div class="antialiased font-mono mx-auto flex flex-col min-h-screen px-5 pt-5 max-w-2xl">
	<div class="flex space-x-5 flex-none">
		<a href="/" class="text-slate-700 hover:underline">home</a>
		<a href="/open-source" class="text-slate-700 hover:underline">open source</a>
		<a href="/about" class="text-slate-700 hover:underline">about me</a>
	</div>
	<div class="mt-20 flex-grow flex-shrink flex-1">
		<slot />
	</div>
	<footer class="text-sm flex justify-end h-12 border-t pt-3 mt-10 space-x-2">
		<p>
			crafted by <a href="https://kit.svelte.dev">Sveltekit</a>
			and <a href="https://tailwindcss.com">Tailwind CSS</a>
			with ❤️.
		</p>
	</footer>
</div>
