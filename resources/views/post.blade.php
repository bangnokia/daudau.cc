@extends('app')

@section('content')
    <h1>{{ $data->title }}</h1>

    <time>{{ $data->createdAt }}</time>
    <article>
        {!! $data->content !!}
{{--        {{ $data->content }}--}}
    </article>
@endsection
