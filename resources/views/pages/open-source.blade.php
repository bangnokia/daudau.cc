<x-layout title="Open sources">

    <h1 class="text-3xl text-cyan-500">My stuffs</h1>
    <p>Some stupid stuff wrote on my freetime.</p>

    <div class="grid mt-10 space-y-5 grid-cols-1">
        @foreach(['laravel-serve-livereload', 'pekyll', 'cdn-image', 'tomodoro'] as $name)
            <x-github-repo :name="$name" />
        @endforeach
    </div>
</x-layout>
