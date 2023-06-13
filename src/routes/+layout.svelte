<script lang="ts">
	import '../app.css';
	import '@unocss/reset/tailwind.css';
	import 'virtual:uno.css';
</script>

<div class="antialiased font-sans mx-auto flex flex-col min-h-screen px-5 pt-5 max-w-2xl overflow-y-hidden">
	<nav class="flex space-x-5">
		<a href="/" class="text-slate-700" sveltekit:prefetch>blog</a>
		<a href="/open-source" class="text-slate-700" sveltekit:prefetch>open source</a>
		<a href="/about" class="text-slate-700" sveltekit:prefetch>about me</a>
	</nav>
	<div class="mt-24 flex-grow flex-shrink flex-1">
		<slot />
	</div>
	<footer class="text-xs flex justify-end h-12 border-t border-slate-200 pt-3 mt-10 space-x-2">
		<a href="/wakatime" class="text-white">wakatime</a>
	</footer>
</div>
