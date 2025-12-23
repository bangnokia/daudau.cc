<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wedding Location</title>
    <link href="https://fonts.googleapis.com/css2?family=Product+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        :root {
            --bg: #ffffff;
            --text: #1a1a1a;
            --card-bg: #ffffff;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Product Sans', 'Google Sans', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        .map-container {
            width: 100vw;
            height: 100vh;
            background: #f0f0f0;
            z-index: 1;
        }

        .overlay {
            position: absolute;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            text-align: center;
            width: 90%;
            max-width: 600px;
            pointer-events: none; /* Let clicks pass through to map if needed */
        }

        .overlay-content {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 1.5rem 2rem;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            pointer-events: auto; /* Re-enable clicks for content */
        }

        h1 {
            font-weight: 700;
            font-size: 1.8rem;
            margin: 0;
            letter-spacing: -0.01em;
        }

        p {
            color: var(--text);
            opacity: 0.6;
            margin: 0.5rem 0 0;
            font-size: 1.1rem;
        }

        .actions {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
        }

        .btn {
            display: inline-block;
            padding: 16px 40px;
            background-color: #ffffff;
            color: #1a1a1a;
            text-decoration: none;
            border-radius: 100px;
            font-weight: 700;
            font-size: 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(0,0,0,0.05);
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Custom Emoji Marker Style */
        .emoji-marker {
            font-size: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }

        /* Continuous Floating Animation */
        .animated-icon {
            background: none !important;
            border: none !important;
        }

        .animated-icon img {
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.3));
            animation: float 3s ease-in-out infinite;
            display: block;
            width: 100%;
            height: 100%;
            border-radius: 100px;
            border: 2px solid #ffffff;
            box-sizing: border-box;
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0); }
        }

        @media (max-width: 600px) {
            h1 { font-size: 1.5rem; }
            .overlay { top: 1rem; }
            .overlay-content { padding: 1rem; }
            .btn { padding: 14px 30px; font-size: 0.9rem; }
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="overlay-content">
            <h1>Wedding Location</h1>
            <p>We can't wait to see you there!</p>
        </div>
    </div>

    <div id="map" class="map-container"></div>

    <div class="actions">
        <a href="https://www.google.com/maps/search/?api=1&query=20.661789,106.337373" target="_blank" class="btn">
            Get Directions
        </a>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Coordinates from your original embed
        const lat = 20.661789;
        const lng = 106.337373;

        // Initialize map
        const map = L.map('map', {
            zoomControl: false,
            attributionControl: false
        }).setView([lat, lng], 10);

        // Use a clean, modern Street mode (CartoDB Voyager)
        L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
        }).addTo(map);

        // Create a custom animated icon using divIcon
        const customIcon = L.divIcon({
            className: 'animated-icon',
            html: '<img src="/icon.png" alt="marker">',
            iconSize: [48, 48],
            iconAnchor: [24, 48]
        });

        // Add the marker
        const marker = L.marker([lat, lng], { icon: customIcon }).addTo(map);

        // Zoom to 19 when marker is clicked
        marker.on('click', function() {
            map.setView([lat, lng], 15);
        });
    </script>
</body>
</html>
