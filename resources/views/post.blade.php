@php
    // Extract the first image from the post content if any
    $firstImageUrl = null;
    if (isset($data->content)) {
        preg_match('/<img.+src=[\'"](?P<src>.+?)[\'"].*>/i', $data->content, $matches);
        if (!empty($matches['src'])) {
            $firstImageUrl = $matches['src'];
        }
    }
@endphp

@extends('layout', ['ogImage' => $firstImageUrl])

@section('content')
<div>
    <div class="main-content">
        <h1>{{ $data->title }}</h1>
        <x-date>{{ $data->createdAt }}</x-date>

        <article class="prose">
            {!! $data->content !!}
        </article>
    </div>

    <!-- Include the comments component -->
    <x-comments />
</div>
@endsection
