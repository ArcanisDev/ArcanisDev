(function ($) {
    "use strict";

    jQuery(document).ready(function ($) {
        // AOS Animation Initialization
        AOS.init({
            // Global settings:
            disable: false, // Disable AOS? Accepts: 'phone', 'tablet', 'mobile', boolean, or a function
            startEvent: 'DOMContentLoaded', // Name of the event to initialize AOS
            initClassName: 'aos-init', // Class applied after AOS initializes
            animatedClassName: 'aos-animate', // Class applied on animation
            useClassNames: false, // If true, adds content of `data-aos` as classes on scroll
            disableMutationObserver: false, // Disable auto-detection of DOM mutations
            debounceDelay: 50, // Delay for debouncing (resizing)
            throttleDelay: 99, // Delay for throttling (scrolling)

            // Element-specific settings (can be overridden via `data-aos-*` attributes):
            offset: 120, // Offset from the trigger point in px
            delay: 0, // Animation delay in ms (0 to 3000, step of 50ms)
            duration: 400, // Animation duration in ms (0 to 3000, step of 50ms)
            easing: 'ease', // Default easing for animations
            once: true, // Should animation run only once while scrolling down?
            mirror: false, // Should elements animate out while scrolling past them?
            anchorPlacement: 'top-bottom', // Position of the element relative to the viewport to trigger animation
        });

        // Smooth Scrolling for Navigation Links
        $('a[href^="#"]').on('click', function (e) {
            e.preventDefault(); // Prevent default anchor behavior
            const target = $(this.getAttribute('href')); // Get target section by href

            if (target.length) {
                $('html, body').animate(
                    {
                        scrollTop: target.offset().top - 70, // Adjust for fixed headers
                    },
                    800 // Scroll duration in ms
                );
            }
        });

        // Custom Logic for Specific Interactions (Optional)
        // Example: Highlight menu links when scrolling past sections
        $(window).on('scroll', function () {
            const scrollPos = $(document).scrollTop();
            $('a[href^="#"]').each(function () {
                const target = $(this.getAttribute('href'));
                if (target.length) {
                    const offsetTop = target.offset().top - 100;
                    const offsetBottom = offsetTop + target.outerHeight();
                    if (scrollPos >= offsetTop && scrollPos <= offsetBottom) {
                        $(this).addClass('active'); // Add active class to the menu link
                    } else {
                        $(this).removeClass('active'); // Remove active class
                    }
                }
            });
        });
    });

    jQuery(window).on('load', function () {
        // Additional logic after all resources are loaded (optional)
    });
})(jQuery);
