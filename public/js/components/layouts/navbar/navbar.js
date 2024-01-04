// Get references to DOM elements
var toggleButton = document.getElementById('theme-toggle');
var logo = document.getElementById('logo');
var sunIcon = toggleButton.querySelector('.bx-sun');
var moonIcon = toggleButton.querySelector('.bx-moon');

// Event listener for theme toggle button
toggleButton.addEventListener('click', function() {
    var body = document.body;
    var lightLogo = logo.getAttribute('data-light');
    var darkLogo = logo.getAttribute('data-dark');

    // Check if dark mode is active
    if (body.classList.contains('dark-mode')) {
        // Switch to light mode
        body.classList.remove('dark-mode');
        sunIcon.style.display = 'inline-block';
        moonIcon.style.display = 'none';
        logo.src = lightLogo;
        localStorage.setItem('theme', 'light');
    } else {
        // Switch to dark mode
        body.classList.add('dark-mode');
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'inline-block';
        logo.src = darkLogo;
        localStorage.setItem('theme', 'dark');
    }
});

// Event listener when the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check the stored theme preference in local storage
    if (localStorage.getItem('theme') === 'dark') {
        // Set dark mode styles
        document.body.classList.add('dark-mode');
        sunIcon.style.display = 'none';
        moonIcon.style.display = 'inline-block';
        // Set the logo source to the dark mode version
        logo.src = logoSrc;
    } else {
        // Set light mode styles
        sunIcon.style.display = 'inline-block';
        moonIcon.style.display = 'none';
    }
});
