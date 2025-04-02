document.addEventListener('DOMContentLoaded', function() {
    const adminBar = document.getElementById('wpadminbar');
    if (!adminBar) return;

    let lastScrollTop = 0;
    let isScrolling = false;
    let scrollTimeout;

    // Hide admin bar on touch
    document.addEventListener('touchstart', function() {
        adminBar.style.transform = 'translateY(-100%)';
    });

    // Show/hide admin bar on scroll
    window.addEventListener('scroll', function() {
        if (!isScrolling) {
            isScrolling = true;
            const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Show admin bar when scrolling down
            if (currentScrollTop > lastScrollTop && currentScrollTop > 50) {
                adminBar.style.transform = 'translateY(0)';
            }
            // Hide admin bar when scrolling up
            else if (currentScrollTop < lastScrollTop) {
                adminBar.style.transform = 'translateY(-100%)';
            }
            
            lastScrollTop = currentScrollTop;
        }

        clearTimeout(scrollTimeout);
        scrollTimeout = setTimeout(function() {
            isScrolling = false;
        }, 150);
    });
}); 