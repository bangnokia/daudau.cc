@props(['tags' => []])

@foreach ($tags as  $tag)
    <span class="tag text-sm">{{ $tag }}</span>
@endforeach