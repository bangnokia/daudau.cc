<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ implode(' | ', [$data->title ?? '', 'Blog of Nguyen']) }}</title>
    <meta name="description" content="{{ $data->description ?: substr(strip_tags($data->content), 0, 165) }}">
    <meta property="twitter:author" content="@bangnokia" />
    <meta property="og:image" content="https://cdn.statically.io/og/daudau blog.jpg" />

    <link rel="icon" href="/favicon.png" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <header class="container">
        <nav class="main-menu">
            <a href="/">Blog</a>
            <a href="/about">About</a>
        </nav>
    </header>

    <main class="container" style="padding: 4rem 0 0; width: 100%; height: 100%; flex-grow: 1">
        @yield('content')
    </main>

    <footer class="container">
        <div>&copy; Nguyen Viet</div>
        <a href="/wakatime" style="color: white">wakatime</a>
    </footer>
</body>

</html>
