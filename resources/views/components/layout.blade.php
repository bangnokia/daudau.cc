@props([
	'title' => null,
	'description' => null,
	'fullWidth' => false
])
<!DOCTYPE html>
<html lang="en">
<head>
	<title>{{ $title ? $title . ' | ' : '' }}daudau's blog</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $description ?? 'personal blog by Bang. I write stupid stuff with words and code.' }}">
	<link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400&display=swap" rel="stylesheet">
</head>
<body>
	<div class="main-body mx-auto flex flex-col min-h-screen px-5 pt-5 {{ $fullWidth ? '' : 'max-w-2xl' }}">
		<x-navbar class="flex-none" />

		<div class="mt-20 flex-grow flex-shrink flex-1">
			{{ $slot }}
		</div>

		<footer class="text-sm flex justify-end h-12 border-t pt-3 mt-10 space-x-2">
			<a href="https://github.com/bangnokia" title="github">my github</a>
			<span>|</span>
			<a href="/wakatime.html">wakatime</a>
			<span>|</span>
			<p>crafted by <a href="http://github.com/bangnokia/pekyll" target="_blank">pekyll</a> with ❤️.</p>
		</footer>
	</div>

    @stack('scripts')

	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-37232412-22"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-37232412-22');
	</script>
</body>
</html>
