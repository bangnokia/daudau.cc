@php
    // Determine OG image source with priority:
    // 1. Custom ogImage passed via array parameter
    // 2. Fallback to statically.io with title

    // Check if ogImage is passed via array parameter
    $ogImage = $ogImage ?? null;

    // Fallback to the current solution
    if (!$ogImage) {
        $ogImage = "https://og.skymage.net?text=" . ($data->title ?? 'Blog of Nguyen');
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ implode(' | ', [$data->title ?? '', 'Blog of Nguyen']) }}</title>
    <meta name="description" content="{{ $data->description ?: substr(strip_tags($data->content), 0, 165) }}">
    <meta property="twitter:author" content="@bangnokia" />
    <meta property="og:image" content="{{ $ogImage }}" />

    <!-- Prevent theme flash by applying theme immediately -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') ||
                             (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>

    <link rel="icon" href="/favicon.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/style.css?v={{ time() }}">
</head>

<body>
    <div id="app">
        <header class="container">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <nav class="main-menu">
                    <a href="/">Blog</a>
                    <a href="/projects">Projects</a>
                    <a href="/about">About</a>
                </nav>
                <x-theme-toggle />
            </div>
        </header>

        <main class="container" style="padding-top: 4rem; flex-grow: 1; width: 100%; height: 100%">
            @yield('content')
        </main>

        <footer class="container">
            <div>&copy; {{ date('Y') }} Nguyen Viet.</div>
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
