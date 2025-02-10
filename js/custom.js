// filepath: /C:/Users/patri/my-custom-theme/js/custom.js

// At the very top of custom.js
console.log('JavaScript loaded : 006');


document.addEventListener('DOMContentLoaded', function () {
    var menuToggle = document.getElementById('menu-toggle');
    var navMenu = document.querySelector('.nav-menu');

    menuToggle.addEventListener('click', function (event) {
        event.stopPropagation(); // Prevent click from bubbling to document
        navMenu.classList.toggle('active');
    });

    // Close menu when clicking outside
    document.addEventListener('click', function (event) {
        if (!navMenu.contains(event.target) && !menuToggle.contains(event.target)) {
            navMenu.classList.remove('active');
        }
    });
});