/**
 * Bootstrap 4 to 5 Migration Helper
 * This file provides compatibility functions for Bootstrap 4 to 5 migration
 */

// Initialize Bootstrap 5 components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Initialize toasts
    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl);
    });

    // Migrate data attributes from Bootstrap 4 to 5
    migrateDataAttributes();
});

/**
 * Migrate Bootstrap 4 data attributes to Bootstrap 5
 */
function migrateDataAttributes() {
    // Update data-toggle to data-bs-toggle
    document.querySelectorAll('[data-toggle]').forEach(function(element) {
        var toggleValue = element.getAttribute('data-toggle');
        element.setAttribute('data-bs-toggle', toggleValue);
        element.removeAttribute('data-toggle');
    });

    // Update data-target to data-bs-target
    document.querySelectorAll('[data-target]').forEach(function(element) {
        var targetValue = element.getAttribute('data-target');
        element.setAttribute('data-bs-target', targetValue);
        element.removeAttribute('data-target');
    });

    // Update data-dismiss to data-bs-dismiss
    document.querySelectorAll('[data-dismiss]').forEach(function(element) {
        var dismissValue = element.getAttribute('data-dismiss');
        element.setAttribute('data-bs-dismiss', dismissValue);
        element.removeAttribute('data-dismiss');
    });

    // Update data-placement to data-bs-placement
    document.querySelectorAll('[data-placement]').forEach(function(element) {
        var placementValue = element.getAttribute('data-placement');
        element.setAttribute('data-bs-placement', placementValue);
        element.removeAttribute('data-placement');
    });
}

/**
 * jQuery compatibility functions for Bootstrap 5
 */
if (typeof jQuery !== 'undefined') {
    (function($) {
        // Modal compatibility
        $.fn.modal = function(action) {
            return this.each(function() {
                var modal = bootstrap.Modal.getOrCreateInstance(this);
                if (action === 'show') {
                    modal.show();
                } else if (action === 'hide') {
                    modal.hide();
                } else if (action === 'toggle') {
                    modal.toggle();
                }
            });
        };

        // Tooltip compatibility
        $.fn.tooltip = function(action) {
            return this.each(function() {
                var tooltip = bootstrap.Tooltip.getOrCreateInstance(this);
                if (action === 'show') {
                    tooltip.show();
                } else if (action === 'hide') {
                    tooltip.hide();
                } else if (action === 'toggle') {
                    tooltip.toggle();
                } else if (action === 'dispose') {
                    tooltip.dispose();
                }
            });
        };

        // Popover compatibility
        $.fn.popover = function(action) {
            return this.each(function() {
                var popover = bootstrap.Popover.getOrCreateInstance(this);
                if (action === 'show') {
                    popover.show();
                } else if (action === 'hide') {
                    popover.hide();
                } else if (action === 'toggle') {
                    popover.toggle();
                } else if (action === 'dispose') {
                    popover.dispose();
                }
            });
        };

        // Dropdown compatibility
        $.fn.dropdown = function(action) {
            return this.each(function() {
                var dropdown = bootstrap.Dropdown.getOrCreateInstance(this);
                if (action === 'show') {
                    dropdown.show();
                } else if (action === 'hide') {
                    dropdown.hide();
                } else if (action === 'toggle') {
                    dropdown.toggle();
                }
            });
        };

        // Collapse compatibility
        $.fn.collapse = function(action) {
            return this.each(function() {
                var collapse = bootstrap.Collapse.getOrCreateInstance(this);
                if (action === 'show') {
                    collapse.show();
                } else if (action === 'hide') {
                    collapse.hide();
                } else if (action === 'toggle') {
                    collapse.toggle();
                }
            });
        };

        // Tab compatibility
        $.fn.tab = function(action) {
            return this.each(function() {
                var tab = bootstrap.Tab.getOrCreateInstance(this);
                if (action === 'show') {
                    tab.show();
                }
            });
        };

        // Carousel compatibility
        $.fn.carousel = function(action) {
            return this.each(function() {
                var carousel = bootstrap.Carousel.getOrCreateInstance(this);
                if (action === 'next') {
                    carousel.next();
                } else if (action === 'prev') {
                    carousel.prev();
                } else if (action === 'pause') {
                    carousel.pause();
                } else if (action === 'cycle') {
                    carousel.cycle();
                } else if (typeof action === 'number') {
                    carousel.to(action);
                }
            });
        };

    })(jQuery);
}

/**
 * Global helper functions for Bootstrap 5 migration
 */
window.Bootstrap5Migration = {
    
    // Show modal
    showModal: function(selector) {
        var modalEl = document.querySelector(selector);
        if (modalEl) {
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        }
    },

    // Hide modal
    hideModal: function(selector) {
        var modalEl = document.querySelector(selector);
        if (modalEl) {
            var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.hide();
        }
    },

    // Show toast
    showToast: function(selector) {
        var toastEl = document.querySelector(selector);
        if (toastEl) {
            var toast = bootstrap.Toast.getOrCreateInstance(toastEl);
            toast.show();
        }
    },

    // Initialize all Bootstrap components
    initializeAll: function() {
        // Initialize all tooltips
        var tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltips.forEach(function(tooltip) {
            new bootstrap.Tooltip(tooltip);
        });

        // Initialize all popovers
        var popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
        popovers.forEach(function(popover) {
            new bootstrap.Popover(popover);
        });

        // Initialize all toasts
        var toasts = document.querySelectorAll('.toast');
        toasts.forEach(function(toast) {
            new bootstrap.Toast(toast);
        });
    }
};