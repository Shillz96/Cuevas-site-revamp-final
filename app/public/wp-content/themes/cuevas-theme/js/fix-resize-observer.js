/**
 * Fix ResizeObserver errors
 * This script patches the ResizeObserver prototype to prevent errors with invalid nodes
 */
(function() {
    // Execute as soon as possible
    function patchResizeObserver() {
        if (typeof ResizeObserver !== 'undefined') {
            const originalObserve = ResizeObserver.prototype.observe;
            ResizeObserver.prototype.observe = function(target, options) {
                if (target && target.nodeType === 1) {
                    originalObserve.call(this, target, options);
                } else {
                    console.warn('Prevented ResizeObserver error with invalid target');
                }
            };
            console.log('ResizeObserver patched via external script');
        }
    }

    // Try to patch immediately
    patchResizeObserver();

    // Also patch on DOMContentLoaded as a backup
    document.addEventListener('DOMContentLoaded', patchResizeObserver);
})(); 