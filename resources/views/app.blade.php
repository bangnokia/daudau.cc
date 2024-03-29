<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ implode(' | ', [$data->title ?? '', 'Blog of Nguyen']) }}</title>
    <meta name="description" content="{{ $data->description ?: substr(strip_tags($data->content), 0, 165) }}">
    <meta property="twitter:author" content="@bangnokia" />
    <meta property="og:image" content="https://cdn.statically.io/og/{{ $data->title }}.jpg" />

    <link rel="icon" href="/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/style.css?v={{ time() }}">
</head>

<body>
    <div class="container">
        <header>
            <nav class="main-menu">
                <a href="/">Blog</a>
                <a href="/projects">Projects</a>
                <a href="/about">About</a>
            </nav>
        </header>

        <main style="padding-top: 4rem;">
            @yield('content')
        </main>

        <footer>
            <div>&copy; {{ date('Y') }} Nguyen Viet</div>
            <a href="/wakatime" style="color: transparent">wakatime</a>
        </footer>
    </div>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3Q4R375R24"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-3Q4R375R24');
    </script>
</body>

</html>
