@props(['tags' => []])

@foreach ($tags as  $tag)
    <span class="tag">{{ $tag }}</span>
@endforeach