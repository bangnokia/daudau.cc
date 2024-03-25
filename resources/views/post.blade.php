@extends('app')

@section('content')
    <h1>{{ $data->title }}</h1>
    <x-date>{{ $data->createdAt }}</x-date>

    <article class="prose">
        {!! $data->content !!}
    </article>
@endsection
