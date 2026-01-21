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

    <!-- SPA-like navigation -->
    <script>
        (function() {
            const mainSelector = 'main.container';
            const cache = new Map();
            
            function isInternalLink(link) {
                return link.hostname === window.location.hostname && 
                       !link.href.includes('#') &&
                       !link.hasAttribute('download') &&
                       link.target !== '_blank';
            }

            async function fetchPage(url) {
                if (cache.has(url)) return cache.get(url);
                
                const response = await fetch(url);
                if (!response.ok) throw new Error('Network response was not ok');
                
                const html = await response.text();
                cache.set(url, html);
                return html;
            }

            async function navigate(url) {
                try {
                    const html = await fetchPage(url);
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    const newMain = doc.querySelector(mainSelector);
                    const currentMain = document.querySelector(mainSelector);
                    
                    if (newMain && currentMain) {
                        currentMain.innerHTML = newMain.innerHTML;
                        document.title = doc.title;
                        window.scrollTo(0, 0);
                        
                        // Track page view in GA
                        if (typeof gtag === 'function') {
                            gtag('config', 'G-3Q4R375R24', { page_path: new URL(url).pathname });
                        }
                    }
                } catch (error) {
                    window.location.href = url;
                }
            }

            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (link && isInternalLink(link)) {
                    e.preventDefault();
                    const url = link.href;
                    history.pushState(null, '', url);
                    navigate(url);
                }
            });

            document.addEventListener('mouseover', function(e) {
                const link = e.target.closest('a');
                if (link && isInternalLink(link) && !cache.has(link.href)) {
                    fetchPage(link.href);
                }
            });

            window.addEventListener('popstate', function() {
                navigate(window.location.href);
            });
        })();
    </script>

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
