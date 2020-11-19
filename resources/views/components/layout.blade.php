@props(['title' => 'Home page', 'fullWidth' => false])
<!DOCTYPE html>
<html lang="vi">
<head>
	<title>{{ $title }}</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="icon" type="image/png" href="/images/favicon-32x32.png">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
</head>
<body>
	<div class="pl-2 pt-2 {{ $fullWidth ? '' : 'max-w-xl' }}">
		<x-navbar />
		<div class="mt-5">
			{{ $slot }}
		</div>
	</div>
</body>
</html>
