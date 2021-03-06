@props(['name'])

@php
    $data = file_get_contents(
        'https://api.github.com/repos/bangnokia/'.$name,
        false,
        stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => ['User-Agent: PHP']
            ]
        ])
    );

    $repo = json_decode($data, true);
@endphp

<div class="border py-5 px-3">
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            <a class="text-2xl text-blue-500" href="{{ $repo['html_url'] }}" target="_blank" title="{{ $repo['name'] }}">{{ $repo['name'] }}</a>
        </div>
        <div class="flex items-center">
            <span class="mr-5 font-bold">
                {{ $repo['language'] }}
            </span>
            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
            {{ $repo['stargazers_count'] }}
        </div>
    </div>
    <p class="mt-3">{{ $repo['description'] }}</p>
</div>
