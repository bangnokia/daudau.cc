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

        /* Popup Styles */
        .leaflet-popup-content-wrapper {
            border-radius: 16px;
            padding: 8px;
            background: #ffffff;
            color: #1a1a1a;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .leaflet-popup-tip {
            background: #ffffff;
        }

        .popup-btn {
            display: block;
            background: #ffffff;
            color: #1a1a1a;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 100px;
            font-weight: 700;
            text-align: center;
            font-size: 14px;
            margin-top: 8px;
            border: 1px solid rgba(0,0,0,0.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: all 0.2s ease;
        }

        .popup-btn:hover {
            background: #f9f9f9;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.12);
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div id="map" class="map-container"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Coordinates
        const husband = [20.6619843, 106.3368383];
        const wife = [21.353508, 106.519327];

        // Initialize map
        const map = L.map('map', {
            zoomControl: false,
            attributionControl: false
        });

        // Use Google Maps style tiles
        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 25,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; <a href="https://www.google.com/maps">Google Maps</a>'
        }).addTo(map);

        // Create a custom animated icon using divIcon
        const customIcon = L.divIcon({
            className: 'animated-icon',
            html: '<img src="/images/wedding-icon.png" alt="marker">',
            iconSize: [48, 48],
            iconAnchor: [24, 48]
        });

        // Add markers
        const husbandMarker = L.marker(husband, { icon: customIcon }).addTo(map);
        const wifeMarker = L.marker(wife, { icon: customIcon }).addTo(map);

        // Add popups
        husbandMarker.bindPopup(`
            <div style="text-align: center; padding: 5px;">
                <div style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">Nhà Bằng</div>
                <a href="https://www.google.com/maps/search/?api=1&query=${husband[0]},${husband[1]}" target="_blank" class="popup-btn">Direction</a>
            </div>
        `, { maxWidth: 200, closeButton: false });

        wifeMarker.bindPopup(`
            <div style="text-align: center; padding: 5px;">
                <div style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">Nhà Tính</div>
                <a href="https://www.google.com/maps/search/?api=1&query=${wife[0]},${wife[1]}" target="_blank" class="popup-btn">Direction</a>
            </div>
        `, { maxWidth: 200, closeButton: false });

        // Center point between husband and wife
        const centerLat = (husband[0] + wife[0]) / 2;
        const centerLng = (husband[1] + wife[1]) / 2;

        // Set initial view with a specific zoom level (e.g., 10)
        map.setView([centerLat, centerLng], 10);

        // Alternatively, uncomment to auto-fit both markers
        // const bounds = L.latLngBounds([husband, wife]);
        // map.fitBounds(bounds, { padding: [50, 50] });
    </script>
</body>
</html>
