@php
    // Consolidate error reporting to hide deprecated, strict, and notice warnings
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE);
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Location</title>
    <link href="https://fonts.googleapis.com/css2?family=Product+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #ffffff;
            --text: #1a1a1a;
            --accent: #4ec9b0;
            --card-bg: #ffffff;
            --shadow: none;
            --border: transparent;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Product Sans', 'Google Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            padding: 1rem;
            text-align: center;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 0;
            padding: 0;
            box-shadow: none;
            border: none;
            overflow: hidden;
        }

        h1 {
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        p {
            color: var(--text);
            opacity: 0.6;
            margin-bottom: 2.5rem;
            font-size: 1.2rem;
        }

        .map-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 0;
        }

        .map-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .actions {
            margin-top: 3rem;
        }

        .btn {
            display: inline-block;
            padding: 16px 40px;
            background-color: var(--text);
            color: #ffffff;
            text-decoration: none;
            border-radius: 100px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.2s ease;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 1.8rem;
            }
            .map-wrapper {
                padding-bottom: 100%; /* Square on mobile */
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Wedding Location</h1>
        <p>We can't wait to see you there!</p>

        <div class="card">
            <div class="map-wrapper">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3733.1914375046867!2d106.33737307251671!3d20.66178918653619!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMjDCsDM5JzQzLjIiTiAxMDbCsDIwJzE0LjkiRQ!5e0!3m2!1sen!2s!4v1766474722667!5m2!1sen!2s"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <div class="actions">
            <a href="https://www.google.com/maps/search/?api=1&query=20.661789,106.337373" target="_blank" class="btn">
                Get Directions
            </a>
        </div>
    </div>
</body>
</html>
