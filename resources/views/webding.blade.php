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
            position: relative;
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

        .nyan-cat-icon {
            background: none !important;
            border: none !important;
        }

        .nyan-cat-icon img {
            width: 60px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
            transition: transform 0.05s linear;
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

        /* GPS Button Style */
        .gps-button {
            position: absolute;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            background: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
        }

        .gps-button:hover {
            transform: scale(1.05);
            background: #f9f9f9;
        }

        .gps-button svg {
            width: 24px;
            height: 24px;
            fill: #1a1a1a;
        }

        /* Partner Banner Styles (Renamed from ads to avoid ad-blockers) */
        .partner-banner {
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 970px;
            height: 120px;
            max-width: 90vw;
            background: rgba(240, 240, 240, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            text-decoration: none;
            transition: all 0.3s ease;
            opacity: 0.95;
        }

        .partner-banner:hover {
            transform: translateX(-50%) translateY(-1px);
            background: rgba(235, 235, 235, 0.95);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            opacity: 1;
        }

        .partner-content {
            text-align: center;
        }

        .partner-info {
            font-size: 18px;
            color: #555;
            font-weight: 700;
            letter-spacing: 1px;
        }

        @media (max-width: 1000px) {
            .partner-banner {
                width: 85vw;
                height: 50px; /* Much smaller height on mobile */
                top: 10px;    /* Move closer to the top edge */
            }
            .partner-info {
                font-size: 13px;
                letter-spacing: 0.5px;
            }
        }

        /* Love Line Improvements */
        .love-line-glow {
            filter: drop-shadow(0 0 4px #007bff);
        }

        @keyframes march {
            to {
                stroke-dashoffset: -20;
            }
        }

        .marching-line {
            animation: march 1s linear infinite;
        }
    </style>
</head>
<body>
    <div id="map" class="map-container">
        <!-- Banner is now inside map to respect Leaflet z-index layers -->
        <a href="#" class="partner-banner">
            <div class="partner-content">
                <div class="partner-info">970x120 - Contact Tinh Do</div>
            </div>
        </a>
    </div>

    <button class="gps-button" onclick="locateUser()" title="Find my location">
        <svg viewBox="0 0 24 24">
            <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3c-.46-4.17-3.77-7.48-7.94-7.94V1h-2v2.06C6.83 3.52 3.52 6.83 3.06 11H1v2h2.06c.46 4.17 3.77 7.48 7.94 7.94V23h2v-2.06c4.17-.46 7.48-3.77 7.94-7.94H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
        </svg>
    </button>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet-curve@1.0.0/leaflet.curve.min.js"></script>
    <script>
        // Coordinates
        const husband = [20.6619843, 106.3368383];
        const wife = [21.353508, 106.519327];
        let userLocation = null;

        // Function to generate Google Maps Direction Link
        function getDirectionLink(destLat, destLng) {
            if (userLocation) {
                // If we have user location, use it as origin
                return `https://www.google.com/maps/dir/?api=1&origin=${userLocation.lat},${userLocation.lng}&destination=${destLat},${destLng}&travelmode=driving`;
            } else {
                // Fallback to simple search/destination
                return `https://www.google.com/maps/search/?api=1&query=${destLat},${destLng}`;
            }
        }

        // Function to update all popup buttons with new links
        function updatePopupLinks() {
            husbandMarker.setPopupContent(`
                <div style="text-align: center; padding: 5px;">
                    <div style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">Nhà chú rể</div>
                    <a href="${getDirectionLink(husband[0], husband[1])}" target="_blank" class="popup-btn">Direction</a>
                </div>
            `);

            wifeMarker.setPopupContent(`
                <div style="text-align: center; padding: 5px;">
                    <div style="font-size: 16px; font-weight: 700; color: #1a1a1a; margin-bottom: 10px;">Nhà cô dâu</div>
                    <a href="${getDirectionLink(wife[0], wife[1])}" target="_blank" class="popup-btn">Direction</a>
                </div>
            `);
        }

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

        // Create custom animated icons for husband and wife
        const husbandIcon = L.divIcon({
            className: 'animated-icon',
            html: '<img src="/images/bang.png" alt="Bằng">',
            iconSize: [48, 48],
            iconAnchor: [24, 48]
        });

        const wifeIcon = L.divIcon({
            className: 'animated-icon',
            html: '<img src="/images/tinh.png" alt="Tính">',
            iconSize: [48, 48],
            iconAnchor: [24, 48]
        });

        // Add markers
        const husbandMarker = L.marker(husband, {
            icon: husbandIcon,
            zIndexOffset: 1000 // Ensure markers are above the banner
        }).addTo(map);

        const wifeMarker = L.marker(wife, {
            icon: wifeIcon,
            zIndexOffset: 1000 // Ensure markers are above the banner
        }).addTo(map);

        // Add Love Line (Curve with fallback to Polyline)
        try {
            if (typeof L.curve === 'function') {
                const offsetX = wife[1] - husband[1];
                const offsetY = wife[0] - husband[0];
                const r = Math.sqrt(Math.pow(offsetX, 2) + Math.pow(offsetY, 2));
                const theta = Math.atan2(offsetY, offsetX);
                const thetaOffset = 3.14 / 10;

                const r2 = (r / 2) / Math.cos(thetaOffset);
                const theta2 = theta + thetaOffset;
                const midpointX = (husband[1] + (r2 * Math.cos(theta2)));
                const midpointY = (husband[0] + (r2 * Math.sin(theta2)));

                L.curve(
                    [
                        'M', husband,
                        'Q', [midpointY, midpointX],
                        wife
                    ],
                    {
                        color: '#007bff',
                        weight: 2,
                        opacity: 0.8,
                        dashArray: '10, 10',
                        fill: false,
                        lineCap: 'round',
                        className: 'love-line-glow marching-line'
                    }
                ).addTo(map);

                // Add Nyan Cat Animation
                const nyanIcon = L.divIcon({
                    className: 'nyan-cat-icon',
                    html: '<img src="https://raw.githubusercontent.com/bpmn-io/bpmn-js-nyan/main/docs/cat.gif" alt="nyan">',
                    iconSize: [60, 40],
                    iconAnchor: [30, 20]
                });

                const nyanMarker = L.marker(husband, { icon: nyanIcon, zIndexOffset: 2000 }).addTo(map);

                let t = 0;
                let direction = 1; // 1 for husband to wife, -1 for wife to husband

                function animateNyan() {
                    if (!nyanMarker) return;

                    t += 0.002 * direction;

                    if (t >= 1) {
                        t = 1;
                        direction = -1;
                    } else if (t <= 0) {
                        t = 0;
                        direction = 1;
                    }

                    // Quadratic Bezier Formula: B(t) = (1-t)^2*P0 + 2(1-t)t*P1 + t^2*P2
                    const lat = Math.pow(1 - t, 2) * husband[0] + 2 * (1 - t) * t * midpointY + Math.pow(t, 2) * wife[0];
                    const lng = Math.pow(1 - t, 2) * husband[1] + 2 * (1 - t) * t * midpointX + Math.pow(t, 2) * wife[1];

                    nyanMarker.setLatLng([lat, lng]);

                    // Calculate Tangent (Derivative) B'(t) = 2(1-t)(P1 - P0) + 2t(P2 - P1)
                    const dy = 2 * (1 - t) * (midpointY - husband[0]) + 2 * t * (wife[0] - midpointY);
                    const dx = 2 * (1 - t) * (midpointX - husband[1]) + 2 * t * (wife[1] - midpointX);

                    // We use -dy and -dx for the base angle because in Leaflet/Maps,
                    // Latitude increases UP, but in CSS/Browser, Y increases DOWN.
                    const angle = Math.atan2(-dy, dx) * (180 / Math.PI);

                    // Apply rotation to the image element inside the icon
                    const element = nyanMarker.getElement();
                    if (element) {
                        const img = element.querySelector('img');
                        if (img) {
                            if (direction === -1) {
                                // Moving back (Wife to Husband):
                                // The cat naturally faces right, so we flip it to face left
                                // and adjust the rotation accordingly.
                                img.style.transform = `scaleX(-1) rotate(${-angle}deg)`;
                            } else {
                                // Moving forward (Husband to Wife):
                                // Cat faces right, we rotate it to match the curve slope.
                                img.style.transform = `rotate(${angle}deg)`;
                            }
                        }
                    }

                    requestAnimationFrame(animateNyan);
                }

                // Start animation with a small delay to ensure marker element is ready
                setTimeout(animateNyan, 100);
            } else {
                // Fallback to simple dashed polyline if L.curve fails to load
                L.polyline([husband, wife], {
                    color: '#007bff',
                    weight: 4,
                    opacity: 0.8,
                    dashArray: '10, 10',
                    lineCap: 'round'
                }).addTo(map);
            }
        } catch (e) {
            console.error("Curve error:", e);
        }

        // Add popups
        husbandMarker.bindPopup("", { maxWidth: 200, closeButton: false });
        wifeMarker.bindPopup("", { maxWidth: 200, closeButton: false });

        // Initial links
        updatePopupLinks();

        // Center point between husband and wife
        const centerLat = (husband[0] + wife[0]) / 2;
        const centerLng = (husband[1] + wife[1]) / 2;

        // Set initial view with a specific zoom level (e.g., 10)
        map.setView([centerLat, centerLng], 10);

        // Alternatively, uncomment to auto-fit both markers
        // const bounds = L.latLngBounds([husband, wife]);
        // map.fitBounds(bounds, { padding: [50, 50] });

        // GPS Location Function
        function locateUser() {
            map.locate({setView: false, maxZoom: 15});
        }

        map.on('locationfound', function(e) {
            userLocation = e.latlng;
            const userLatLng = e.latlng;

            // Update links in popups to use the found user location
            updatePopupLinks();

            // Clear existing user markers if any
            if (window.userMarker) map.removeLayer(window.userMarker);
            if (window.userCircle) map.removeLayer(window.userCircle);

            // Calculate distances
            const distHusband = (map.distance(userLatLng, husband) / 1000).toFixed(1);
            const distWife = (map.distance(userLatLng, wife) / 1000).toFixed(1);

            // Add user marker and circle
            window.userCircle = L.circle(userLatLng, e.accuracy / 2, {
                color: '#1a1a1a',
                fillColor: '#1a1a1a',
                fillOpacity: 0.1,
                weight: 1
            }).addTo(map);

            window.userMarker = L.marker(userLatLng).addTo(map)
                .bindPopup(`
                    <div style="text-align: center; padding: 5px;">
                        <div style="font-weight: 700; margin-bottom: 5px;">You are here!</div>
                        <div style="font-size: 12px; opacity: 0.8;">
                            ${distHusband}km to Nhà Bằng<br>
                            ${distWife}km to Nhà Tính
                        </div>
                    </div>
                `, { closeButton: false })
                .openPopup();

            // IMPORTANT: Instead of just zooming into the user,
            // we fit the view to show the user AND both wedding houses
            const bounds = L.latLngBounds([userLatLng, husband, wife]);
            map.fitBounds(bounds, { padding: [70, 70], animate: true, duration: 1.5 });
        });

        map.on('locationerror', function(e) {
            alert("Could not find your location: " + e.message);
        });
    </script>
</body>
</html>
