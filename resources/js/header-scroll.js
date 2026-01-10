// Header Scroll Behavior - Hide/Show on Scroll
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    const body = document.body;
    let lastScrollTop = 0;
    let scrollThreshold = 100; // Minimum scroll distance before hiding
    let isScrolling = false;

    // Add fixed header classes
    header.classList.add('header-fixed', 'header-visible');
    body.classList.add('body-with-fixed-header');

    // Throttle scroll events for better performance
    function throttle(func, limit) {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }

    // Handle scroll behavior
    function handleScroll() {
        const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Add scrolled class for enhanced styling
        if (currentScrollTop > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        // Don't hide header if we're at the top of the page
        if (currentScrollTop <= scrollThreshold) {
            header.classList.remove('header-hidden');
            header.classList.add('header-visible');
            return;
        }

        // Scrolling down - hide header
        if (currentScrollTop > lastScrollTop && currentScrollTop > scrollThreshold) {
            header.classList.remove('header-visible');
            header.classList.add('header-hidden');
        } 
        // Scrolling up - show header
        else if (currentScrollTop < lastScrollTop) {
            header.classList.remove('header-hidden');
            header.classList.add('header-visible');
        }

        lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop; // For Mobile or negative scrolling
    }

    // Add scroll event listener with throttling
    window.addEventListener('scroll', throttle(handleScroll, 16)); // ~60fps

    // Handle window resize
    window.addEventListener('resize', function() {
        // Reset scroll position tracking on resize
        lastScrollTop = window.pageYOffset || document.documentElement.scrollTop;
    });

    // Optional: Add smooth scroll behavior for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerHeight = header.offsetHeight;
                const targetPosition = target.offsetTop - headerHeight - 20; // 20px extra padding
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });
});