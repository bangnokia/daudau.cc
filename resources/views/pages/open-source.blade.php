<x-layout title="Open sources">

    <h1 class="text-3xl text-cyan-500">My stuffs</h1>
    <p>Some cool stuffs writing on my freetimes.</p>

    <div class="grid mt-10 space-y-5 grid-cols-1">
        @foreach(['laravel-serve-livereload', 'pekyll', 'cdn-image'] as $name)
            <x-github-repo :name="$name" />
        @endforeach
    </div>
</x-layout>
