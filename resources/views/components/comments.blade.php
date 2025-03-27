<div class="comments-section">
    <h3>Comments</h3>
    <div class="comments-container">
        <!-- Skeleton loading -->
        <div id="comments-skeleton">
            <div class="skeleton-comment">
                <div class="skeleton-avatar"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line skeleton-line-short"></div>
                    <div class="skeleton-line"></div>
                    <div class="skeleton-line"></div>
                    <div class="skeleton-line skeleton-line-medium"></div>
                </div>
            </div>
            <div class="skeleton-comment">
                <div class="skeleton-avatar"></div>
                <div class="skeleton-content">
                    <div class="skeleton-line skeleton-line-short"></div>
                    <div class="skeleton-line"></div>
                    <div class="skeleton-line skeleton-line-medium"></div>
                </div>
            </div>
        </div>

        <div id="utterances-container">
            <script src="https://utteranc.es/client.js"
                    repo="bangnokia/daudau.cc"
                    issue-term="pathname"
                    theme="github-light"
                    crossorigin="anonymous"
                    async>
            </script>
        </div>

        <script>
            console.log('Comments component initialized');

            const skeleton = document.getElementById('comments-skeleton');
            const utterancesContainer = document.getElementById('utterances-container');

            // Make sure skeleton is visible initially
            if (skeleton) {
                skeleton.style.display = 'block';
            }

            // Function to hide skeleton
            const hideSkeletonAndCleanup = () => {
                console.log('Comments loaded - hiding skeleton');
                if (skeleton) skeleton.style.display = 'none';

                // Clean up observers
                if (resizeObserver) resizeObserver.disconnect();
                if (mutationObserver) mutationObserver.disconnect();

                // Clear timeout
                if (fallbackTimeout) clearTimeout(fallbackTimeout);
            };

            // 1. Use ResizeObserver to detect when utterances loads (most modern approach)
            let resizeObserver;
            if (window.ResizeObserver && utterancesContainer) {
                resizeObserver = new ResizeObserver(entries => {
                    for (let entry of entries) {
                        // When the container gets a height, comments are loaded
                        if (entry.target.offsetHeight > 10) {
                            console.log('ResizeObserver: Utterances height changed to', entry.target.offsetHeight);
                            hideSkeletonAndCleanup();
                        }
                    }
                });

                resizeObserver.observe(utterancesContainer);
                console.log('ResizeObserver started');
            }

            // 2. Fallback: MutationObserver to watch for the iframe being added
            let mutationObserver;
            if (window.MutationObserver && utterancesContainer) {
                mutationObserver = new MutationObserver(mutations => {
                    for (let mutation of mutations) {
                        if (mutation.type === 'childList' && mutation.addedNodes.length) {
                            // Look for the utterances iframe
                            const iframe = utterancesContainer.querySelector('iframe');
                            if (iframe) {
                                console.log('MutationObserver: Utterances iframe detected');

                                // Wait a small amount of time for the iframe to initialize
                                setTimeout(hideSkeletonAndCleanup, 300);
                            }
                        }
                    }
                });

                mutationObserver.observe(utterancesContainer, {
                    childList: true,
                    subtree: true
                });
                console.log('MutationObserver started');
            }

            // 3. Final fallback: timeout
            const fallbackTimeout = setTimeout(() => {
                console.log('Fallback timeout triggered');
                hideSkeletonAndCleanup();
            }, 5000);
        </script>
    </div>
</div>
