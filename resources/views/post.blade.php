@extends('layout')

@section('content')
@php
use Illuminate\Support\Str;
    // Parse headings (H2, H3) and insert anchors
    $content = $data->content;
    $dom = new DOMDocument();
    libxml_use_internal_errors(true);
    // Remove mb_convert_encoding, prepend meta to maintain UTF-8
    $dom->loadHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">' . $content);
    $headings = [];

    foreach ($dom->getElementsByTagName('*') as $node) {
        if (in_array($node->nodeName, ['h2','h3'])) {
            $id = Str::slug($node->textContent);
            $headings[] = [
                'level' => $node->nodeName,
                'text' => $node->textContent,
                'id' => $id
            ];
            // Insert id attribute for anchor
            $node->setAttribute('id', $id);
        }
    }

    // Save updated HTML
    $updatedContent = $dom->saveHTML($dom->documentElement);

@endphp

<div>
    <div class="main-content">
        <h1>{{ $data->title }}</h1>
        <x-date>{{ $data->createdAt }}</x-date>

        <article class="prose">
            {!! preg_replace('~^.*<body>(.*)</body>.*$~is', '$1', $updatedContent) !!}
        </article>
    </div>

    <!-- comments -->
    <div class="comments-section">
        <h3>Comments</h3>
        <div class="comments-container">
            <script src="https://utteranc.es/client.js"
                    repo="bangnokia/daudau.cc"
                    issue-term="pathname"
                    theme="github-light"
                    crossorigin="anonymous"
                    async>
            </script>
        </div>
    </div>
</div>
@endsection
