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
                <input type="text" id="searchInput" name="orderNumber" class="input is-small ml-2" placeholder="Escribe aquí...">
                <button id="searchButton" class="button is-small ml-1" style="display: none;">></button>
            </div>
        `;

        // Focus on the input field when the search box is clicked.
        document.getElementById('searchInput').focus();

        // Add an event listener to the search button.
        document.getElementById('searchButton').addEventListener('click', function() {
            // Get the value from the input field.
            const searchedOrder = document.getElementById('searchInput').value;

            // Send a POST request to the server with the search term.
            fetch('/repairs/quick-search', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ searchedOrder: searchedOrder })
            })
            .then(response => response.json())
            .then(data => {
                // Check if the search was successful.
                if (data.repairs.length !== 0) {
                    // If the order exists, redirect to another route.
                    window.location.href = '/repairs/' + data.repairs[0].id;
                } else {
                    // If the order does not exist, show a message in the middle of the screen.
                    showErrorModal(searchedOrder);

                    var closeErrorButton = document.getElementById('closeErrorButton');

                    // Add an event listener to the element with the ID 'closeErrorButton'.
                    closeErrorButton.addEventListener('click', function() {
                        var overlay = document.getElementById('overlay');
                        
                        // Remove the overlay element from its parent node, effectively removing it from the DOM.
                        overlay.parentNode.removeChild(overlay);
                    });

                    // Event listener for the document.
                    document.addEventListener('click', function(event) {
                        // Error message div.
                        var errorMessage = document.getElementById('error-message');
                        
                        if(errorMessage) {
                            // Check if the click occurred outside the error box.
                            if (!errorMessage.contains(event.target)) {                        
                                closeErrorButton.click();
                            }
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // Add an event listener for the Enter key to trigger the search.
        document.getElementById('searchInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                // Trigger the click event on the search button.
                document.getElementById('searchButton').click();

                // Restore the original content of the search box.
                restoreSearchBoxContent();
            }
        });
    });

    // Event listener for the document.
    document.addEventListener('click', function(event) {
        // Check if the click occurred outside the search box.
        if (!searchBox.contains(event.target)) {
            // Restore the original content of the search box.
            restoreSearchBoxContent();
        }
    });

    // Restore the original content of the search box.
    function restoreSearchBoxContent() {
        searchBox.innerHTML = `
            <div class="pl-5 has-text-centered is-flex is-align-items-center">
                <i class="bx bx-search-alt-2 nav-icon"></i>
                <span class="pl-3">Buscar orden</span>
            </div>
        `;
    }

    // Function to show error modal.
    function showErrorModal(searchedOrder) {
        // Create overlay div and error message.
        var overlay = document.createElement('div');
        overlay.id = 'overlay';

        var errorMessage = document.createElement('div');
        errorMessage.id = 'error-message';
        errorMessage.class = 'box';
        errorMessage.innerHTML = `
            <div class="message-container">
                <div class="box message-box">
                    <p class="has-text-centered">
                        La orden ingresada "${searchedOrder}" no existe
                    </p>
                    <p class="has-text-centered">
                        En caso de algún error contacte a soporte
                    </p>
                </div>
            </div>
            <button 
                class="button" 
                type="button" 
                id="closeErrorButton"
            >Cerrar</button>
        `;
        
        // Append error message to overlay.
        overlay.appendChild(errorMessage);
        
        // Append overlay to the body of the page.
        document.body.appendChild(overlay);
    }
});
