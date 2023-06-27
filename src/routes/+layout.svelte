<script lang="ts">
	import '@unocss/reset/tailwind.css';
	import 'virtual:uno.css';
</script>

<main id="app" class="w-full h-full bg-neutral-900 text-neutral-400">
	<div class="antialiased font-sans mx-auto flex flex-col min-h-screen px-5 pt-5 max-w-2xl overflow-y-hidden">
		<nav class="flex space-x-5">
			<a href="/" class="text-gray-300" data-sveltekit-preload-data="hover">blog</a>
			<a href="/open-source" class="text-gray-300" data-sveltekit-preload-data="hover">open source</a>
			<a href="/about" class="text-gray-300" data-sveltekit-preload-data="hover">about me</a>
		</nav>
		<div class="mt-24 flex-grow flex-shrink flex-1">
			<slot />
		</div>
		<footer class="text-xs flex justify-between h-12 border-t border-neutral-500 pt-3 mt-10 space-x-2">
			<p>&copy; Nguyen Viet</p>
			<a href="/wakatime" class="text-neutral-900">wakatime</a>
		</footer>
	</div>
</main>
