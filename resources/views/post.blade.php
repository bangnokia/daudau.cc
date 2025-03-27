@extends('layout')

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
