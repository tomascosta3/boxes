// Ensure the DOM is fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function() {
    
    // Event listener for the button that opens the modal
    document.getElementById('addTypeButton').addEventListener('click', function() {
        document.getElementById('addTypeModal').classList.add('is-active');
    });

    // Event listener for the button that closes the modal
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('addTypeModal').classList.remove('is-active');
    });

    // Event listener for the button that cancels and closes the modal
    document.getElementById('cancelModal').addEventListener('click', function() {
        document.getElementById('addTypeModal').classList.remove('is-active');
    });

    // Event listener for the button that saves the new type
    document.getElementById('saveTypeButton').addEventListener('click', function() {
        // Get the CSRF token from the meta tag
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Get the value from the input field
        var newType = document.getElementById('newType').value;

        // Make an AJAX request to save the new type
        $.ajax({
            url: '/types/save',
            method: 'POST',
            data: {type: newType},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Close the modal
                document.getElementById('addTypeModal').classList.remove('is-active');

                // Update the select with the updated types
                updateTypeSelect(response.types);  // Assuming the server returns the updated types
            },
            error: function(error) {
                // Handle errors if necessary
                console.error(error);
            }
        });
    });

    // Function to update the select with new types
    function updateTypeSelect(types) {
        var select = document.getElementById('type-dropdown');
        select.innerHTML = '';  // Clear existing options

        // Add new options
        types.forEach(function(type) {
            var option = document.createElement('option');
            option.value = type.id;
            option.text = type.type;
            select.appendChild(option);
        });
    }
});
