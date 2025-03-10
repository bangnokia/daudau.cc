<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ implode(' | ', [$data->title ?? '', 'Blog of Nguyen']) }}</title>
    <meta name="description" content="{{ $data->description ?: substr(strip_tags($data->content), 0, 165) }}">
    <meta property="twitter:author" content="@bangnokia" />
    <meta property="og:image" content="https://cdn.statically.io/og/{{ $data->title }}.jpg" />

    <link rel="icon" href="/favicon.png" type="image/x-icon"> <!-- Add this line for favicon -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/style.css?v={{ time() }}">
</head>

<body>
    <div id="app">
        <header class="container">
            <nav class="main-menu">
                <a href="/">Blog</a>
                <a href="/projects">Projects</a>
                <a href="/about">About</a>
            </nav>
        </header>

        <main class="container" style="padding-top: 4rem; flex-grow: 1; width: 100%; height: 100%">
            @yield('content')
        </main>

        <footer class="container">
            <div>&copy; {{ date('Y') }} Nguyen Viet. Built with <a href="https://github.com/bangnokia/lina"
                    target="_blank">Lina</a></div>
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
