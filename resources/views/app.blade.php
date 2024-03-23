<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ implode(' | ', [$data->title ?? '', 'My awesome blog']) }}</title>

    <meta>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
</head>

<body>
    <div id="app">
        <header class="container">
            <nav class="main-menu">
                <a href="/">Home</a>
                <a href="/about">About</a>
            </nav>
        </header>

        <main class="container" style="padding: 4rem 0 0">
            @yield('content')
        </main>

        <footer class="flex container" style="justify-content: space-between">
            <div>&copy; Nguyen Viet</div>
            <a href="/wakatime" class="text-neutral-900">wakatime</a>
        </footer>
    </div>
</body>

</html>
