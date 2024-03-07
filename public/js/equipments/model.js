// Ensure the DOM is fully loaded before executing the script.
document.addEventListener('DOMContentLoaded', function() {
    // Event listener for the button that opens the modal.
    document.getElementById('addModelButton').addEventListener('click', function() {
        // Show the modal.
        document.getElementById('addModelModal').classList.add('is-active');

        // Focus on the newModelInput when the modal opens.
        var newModelInput = document.getElementById('newModel');
        newModelInput.focus();
    });

    // Event listener for detecting Enter key press in the newModelInput.
    document.getElementById('newModel').addEventListener('keydown', function(event) {
        // Check if the Enter key (keyCode 13) is pressed.
        if (event.keyCode === 13) {
            // Prevent the default action of the Enter key (form submission).
            event.preventDefault();
            
            // Simulate a click on the saveModelButton when Enter is pressed.
            document.getElementById('saveModelButton').click();
        }
    });

    // Event listener for the button that closes the modal.
    document.getElementById('closeModelModal').addEventListener('click', function() {
        document.getElementById('addModelModal').classList.remove('is-active');
    });


    // Event listener for the button that cancels and closes the modal.
    document.getElementById('cancelModelModal').addEventListener('click', function() {
        document.getElementById('addModelModal').classList.remove('is-active');
    });


    // Wait for the document to be fully loaded.
    $(document).ready(function() {
        // Get the value of the brand selected by default in the dropdown.
        var defaultBrandId = $('#brand-dropdown').val();

        // Make an AJAX request to get the models associated with the default brand.
        $.ajax({
            url: '/models/get-by-brand/' + defaultBrandId,
            method: 'GET',
            success: function(response) {
                // Update the model dropdown with the obtained options.
                updateModelSelect(response.models);
            },
            error: function(error) {
                // Handle errors if necessary.
                console.error(error);
            }
        });
    });


    // Event listener for change in the brand dropdown.
    document.getElementById('brand-dropdown').addEventListener('change', function() {
        // Get the selected value from the brand dropdown.
        var selectedBrandId = this.value;

        // Make an AJAX request to retrieve models associated with the selected brand.
        $.ajax({
            url: '/models/get-by-brand/' + selectedBrandId,
            method: 'GET',
            success: function(response) {
                // Update the model dropdown with the retrieved options.
                updateModelSelect(response.models);
            },
            error: function(error) {
                // Update model dropdown with null to empty it.
                updateModelSelect(null);

                // Handle errors if necessary.
                console.error(error);
            }
        });
    });


    // Event listener for the button that saves the new Model.
    document.getElementById('saveModelButton').addEventListener('click', function() {
        // Get the CSRF token from the meta tag.
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Get the value from the input field.
        var newModel = document.getElementById('newModel').value;

        // Get the selected value from the brand dropdown.
        var selectedBrandId = document.getElementById('brand-dropdown').value;
        
        // Verify if selectedBrandId has a value.
        if (selectedBrandId !== '') {
            // Make an AJAX request to save the new model.
            $.ajax({
                url: '/models/save',
                method: 'POST',
                data: {model: newModel, brand_id: selectedBrandId},
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Close the modal
                    document.getElementById('addModelModal').classList.remove('is-active');
                    
                    // Update the select with the updated models.
                    updateModelSelect(response.models);  // Assuming the server returns the updated models.
                },
                error: function(error) {
                    // Handle errors if necessary.
                    console.error(error);
                }
            });
        } else {
            // When no type is selected.
            console.log('No se ha seleccionado ningún modelo');
        }

        // Clean new model input.
        document.getElementById('newModel').value = '';
    });


    // Function to update the select with new models.
    function updateModelSelect(models) {
        var select = document.getElementById('model-dropdown');
        select.innerHTML = '';  // Clear existing options.

        var modelsEmpty = !models || models.length == 0;

        // Get the model ID from view.
        var equipmentModelID = window.equipmentModelID;

        if(!modelsEmpty) {
            // Add new options.
            models.forEach(function(model) {
                var option = document.createElement('option');
                option.value = model.id;
                option.text = model.model;

                // If model ID exists, show model as selected.
                if(equipmentModelID && equipmentModelID == model.id) {
                    option.selected = true;
                }

                select.appendChild(option);
            });
        } 

        // Disable or enable the model dropdown based on whether models are empty.
        $('#model-dropdown').prop('disabled', modelsEmpty);
    }
});
