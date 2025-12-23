<?php

// hide all deprecated warnings
error_reporting(E_ALL ^ E_DEPRECATED);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Location</title>
    <style>
        :root {
            --bg: #f9f9f9;
            --text: #1a1a1a;
            --accent: #4ec9b0;
            --card-bg: #ffffff;
            --shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            --border: #eaeaea;
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #101010;
                --text: #f0f0f0;
                --accent: #4ec9b0;
                --card-bg: #1a1a1a;
                --shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
                --border: #333333;
            }
        }

        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            width: 95%;
            max-width: 800px;
            padding: 2rem;
            text-align: center;
        }

        .card {
            background-color: var(--card-bg);
            border-radius: 24px;
            padding: 12px;
            box-shadow: var(--shadow);
            border: 1px solid var(--border);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-4px);
        }

        h1 {
            font-weight: 300;
            font-size: 2rem;
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        p {
            color: var(--text);
            opacity: 0.7;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .map-wrapper {
            position: relative;
            padding-bottom: 60%; /* Aspect Ratio */
            height: 0;
            overflow: hidden;
            border-radius: 16px;
            background: var(--bg);
        }

        .map-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
            filter: grayscale(0.1) contrast(1.1);
        }

        .actions {
            margin-top: 2rem;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            background-color: var(--accent);
            color: #101010;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(78, 201, 176, 0.2);
        }

        .btn:hover {
            transform: scale(1.02);
            box-shadow: 0 6px 20px rgba(78, 201, 176, 0.3);
            filter: brightness(1.1);
        }

        @media (max-width: 600px) {
            .container {
                padding: 1rem;
            }
            .map-wrapper {
                padding-bottom: 100%; /* Square on mobile */
            }
            h1 {
                font-size: 1.5rem;
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
