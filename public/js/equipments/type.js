// Ensure the DOM is fully loaded before executing the script.
document.addEventListener('DOMContentLoaded', function() {
    // Event listener for the button that opens the modal.
    document.getElementById('addTypeButton').addEventListener('click', function() {
        document.getElementById('addTypeModal').classList.add('is-active');
    });

    // Event listener for the button that closes the modal.
    document.getElementById('closeTypeModal').addEventListener('click', function() {
        document.getElementById('addTypeModal').classList.remove('is-active');
    });

    // Event listener for the button that cancels and closes the modal.
    document.getElementById('cancelTypeModal').addEventListener('click', function() {
        document.getElementById('addTypeModal').classList.remove('is-active');
    });


    // When the document is ready, execute the following code.
    $(document).ready(function() {
        // Get the HTML element for the 'type-dropdown' select.
        var selectTypeDropdown = document.getElementById('type-dropdown');

        // Check if the 'type-dropdown' select is empty (has no options).
        var typesEmpty = selectTypeDropdown.options.length === 0;

        // Disable or enable the 'type-dropdown' select based on whether it's empty or not.
        $('#type-dropdown').prop('disabled', typesEmpty);

        // Disable the 'addBrandButton' button if the 'type-dropdown' select is empty.
        $('#addBrandButton').prop('disabled', typesEmpty);
    });


    // Event listener for the button that saves the new type.
    document.getElementById('saveTypeButton').addEventListener('click', function() {
        // Get the CSRF token from the meta tag.
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Get the value from the input field.
        var newType = document.getElementById('newType').value;

        // Make an AJAX request to save the new type.
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

                // Update the select with the updated types.
                updateTypeSelect(response.types);  // Assuming the server returns the updated types.

                // Generate change event to trigger brands update.
                generateTypeChangeEvent();
            },
            error: function(error) {
                // Handle errors if necessary
                console.error(error);
            }
        });
        // Clean new type input.
        document.getElementById('newType').value = '';
    });

    // Function to update the select with new types.
    function updateTypeSelect(types) {
        var select = document.getElementById('type-dropdown');
        select.innerHTML = '';  // Clear existing options.

        var typesEmpty = !types || types.length == 0;

        if(!typesEmpty) {
            // Add new options.
            types.forEach(function(type) {
                var option = document.createElement('option');
                option.value = type.id;
                option.text = type.type;
                select.appendChild(option);
            });
        }

        // Disable or enable the 'type-dropdown' select based on whether it's empty or not.
        $('#type-dropdown').prop('disabled', typesEmpty);

        // Disable the 'addBrandButton' button if the 'type-dropdown' select is empty.
        $('#addBrandButton').prop('disabled', typesEmpty);
    }


    /**
     * Function to generate and trigger a 'change' event on the type dropdown.
     * This function is designed to simulate a user-initiated change on the type dropdown.
     */
    function generateTypeChangeEvent() {
        // Get the type dropdown element.
        var typeDropdown = document.getElementById('type-dropdown');
    
        // Get the current value of the type dropdown.
        var typeValue = typeDropdown.value;
    
        // Create a new 'change' event.
        var changeEvent = new Event('change');
    
        // Set the value and trigger the 'change' event.
        typeDropdown.value = typeValue;
        typeDropdown.dispatchEvent(changeEvent);
    }
});
