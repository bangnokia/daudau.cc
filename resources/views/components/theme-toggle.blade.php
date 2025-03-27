<button id="theme-toggle" aria-label="Toggle dark mode" title="Toggle dark mode" class="theme-toggle">
    <svg xmlns="http://www.w3.org/2000/svg" class="theme-toggle-icon sun" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="5"></circle>
        <line x1="12" y1="1" x2="12" y2="3"></line>
        <line x1="12" y1="21" x2="12" y2="23"></line>
        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
        <line x1="1" y1="12" x2="3" y2="12"></line>
        <line x1="21" y1="12" x2="23" y2="12"></line>
        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" class="theme-toggle-icon moon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
    </svg>
</button>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeToggle = document.getElementById('theme-toggle');
        const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

        // Function to set theme
        const setTheme = (theme, withTransition = false) => {
            const html = document.documentElement;

            // Set data-theme attribute for styling
            html.setAttribute('data-theme', theme);

            // Set transition attribute only when requested (manual toggle)
            if (withTransition) {
                html.setAttribute('data-theme-transition', 'true');

                // Remove the transition attribute after transitions complete
                setTimeout(() => {
                    html.removeAttribute('data-theme-transition');
                }, 500); // Match this with the transition duration in CSS
            }

            localStorage.setItem('theme', theme);

            // Update button appearance
            if (theme === 'dark') {
                themeToggle.classList.add('dark-mode');
            } else {
                themeToggle.classList.remove('dark-mode');
            }
        };

        // Initialize theme without transition
        const savedTheme = localStorage.getItem('theme') ||
                          (prefersDarkScheme.matches ? 'dark' : 'light');
        setTheme(savedTheme, false);

        // Toggle theme with transition
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            setTheme(newTheme, true); // Apply with transition
        });

        // Listen for system preference changes
        prefersDarkScheme.addEventListener('change', (e) => {
            // Only change if user hasn't manually set a preference
            if (!localStorage.getItem('theme')) {
                setTheme(e.matches ? 'dark' : 'light', false); // No transition for system changes
            }
        });
    });
</script>
