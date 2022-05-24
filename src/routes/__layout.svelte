<script>
    import '@unocss/reset/tailwind.css'
    import 'uno.css'
</script>

<div class="antialiased font-sans mx-auto flex flex-col min-h-screen px-5 pt-5 max-w-2xl overflow-y-hidden">
    <nav class="flex space-x-5 flex-none">
        <a href="/" class="text-slate-700 hover:underline" sveltekit:prefetch>blog</a>
        <a href="/open-source" class="text-slate-700 hover:underline" sveltekit:prefetch>open source</a>
        <a href="/about" class="text-slate-700 hover:underline" sveltekit:prefetch>about me</a>
    </nav>
    <div class="mt-24 flex-grow flex-shrink flex-1">
        <slot/>
    </div>
    <footer class="text-xs flex justify-end h-12 border-t border-slate-200 pt-3 mt-10 space-x-2">
        <p>
            crafted using <a href="https://kit.svelte.dev" target="_blank" class="text-rose-500">Sveltekit</a>
            and <a href="https://github.com/unocss/unocss" target="_blank" class="text-rose-500">Unocss</a>
            with ❤️.
        </p>
    </footer>
</div>
