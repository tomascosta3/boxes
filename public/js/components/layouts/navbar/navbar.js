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

    const searchBox = document.getElementById('searchBox');

    searchBox.addEventListener('click', function(event){

        // Stop event propagation to prevent click from bubbling up to the document.
        event.stopPropagation();

        // Replace the content of the search box with an input field and a button.
        searchBox.innerHTML = `
            <div class="pl-5 has-text-centered is-flex is-align-items-center">
                <i class="bx bx-search-alt-2 nav-icon"></i>
                <input type="text" id="searchInput" class="input is-small ml-2" placeholder="Escribe aquí...">
                <button id="searchButton" class="button is-small">></button>
            </div>
        `;

        // Focus on the input field when the search box is clicked.
        document.getElementById('searchInput').focus();

        // Add an event listener to the search button
        document.getElementById('searchButton').addEventListener('click', function() {
            // Get the value from the input field
            const searchTerm = document.getElementById('searchInput').value;

            // Perform your search logic here, such as making an AJAX request to your controller
            // Example:
            // fetch('/search/' + searchTerm)
            //     .then(response => response.json())
            //     .then(data => {
            //         // Handle the search results
            //     })
            //     .catch(error => {
            //         console.error('Error:', error);
            //     });
            console.log('Search term:', searchTerm);
        });

        // Add an event listener for the Enter key to trigger the search
        document.getElementById('searchInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                document.getElementById('searchButton').click();
            }
        });
    });

    // Event listener for the document
    document.addEventListener('click', function(event) {
        // Check if the click occurred outside the search box
        if (!searchBox.contains(event.target)) {
            // Restore the original content of the search box
            restoreSearchBoxContent();
        }
    });

    // Restore the original content of the search box
    function restoreSearchBoxContent() {
        searchBox.innerHTML = `
            <div class="pl-5 has-text-centered is-flex is-align-items-center">
                <i class="bx bx-search-alt-2 nav-icon"></i>
                <span class="pl-3">Buscar orden</span>
            </div>
        `;
    }
});
