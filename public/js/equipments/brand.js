// Ensure the DOM is fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function() {
    
    // Event listener for the button that opens the modal
    document.getElementById('addBrandButton').addEventListener('click', function() {
        document.getElementById('addBrandModal').classList.add('is-active');
    });

    // Event listener for the button that closes the modal
    document.getElementById('closeBrandModal').addEventListener('click', function() {
        document.getElementById('addBrandModal').classList.remove('is-active');
    });

    // Event listener for the button that cancels and closes the modal
    document.getElementById('cancelBrandModal').addEventListener('click', function() {
        document.getElementById('addBrandModal').classList.remove('is-active');
    });
    
    // Wait for the document to be fully loaded
    $(document).ready(function() {
        // Get the value of the type selected by default in the dropdown
        var defaultTypeId = $('#type-dropdown').val();

        // Make an AJAX request to get the brands associated with the default type
        $.ajax({
            url: '/brands/get-by-type/' + defaultTypeId,
            method: 'GET',
            success: function(response) {
                // Update the brand dropdown with the obtained options
                updateBrandSelect(response.brands);
            },
            error: function(error) {
                // Handle errors if necessary
                console.error(error);
            }
        });
    });

    // Event listener for change in the type dropdown
    document.getElementById('type-dropdown').addEventListener('change', function() {
        // Get the selected value from the type dropdown
        var selectedTypeId = this.value;

        // Make an AJAX request to retrieve brands associated with the selected type
        $.ajax({
            url: '/brands/get-by-type/' + selectedTypeId,
            method: 'GET',
            success: function(response) {
                // Update the brand dropdown with the retrieved options
                updateBrandSelect(response.brands);
            },
            error: function(error) {
                // Handle errors if necessary
                console.error(error);
            }
        });
    });

    // Event listener for the button that saves the new Brand
    document.getElementById('saveBrandButton').addEventListener('click', function() {
        // Get the CSRF token from the meta tag
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Get the value from the input field
        var newBrand = document.getElementById('newBrand').value;

        // Get the selected value from the type dropdown
        var selectedTypeId = document.getElementById('type-dropdown').value;
        
        // Verify if selectedTypeId has a value.
        if (selectedTypeId !== '') {
            // Make an AJAX request to save the new brand
            $.ajax({
                url: '/brands/save',
                method: 'POST',
                data: {brand: newBrand, type_id: selectedTypeId},
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    // Close the modal
                    document.getElementById('addBrandModal').classList.remove('is-active');
                    
                    // Update the select with the updated brands
                    updateBrandSelect(response.brands);  // Assuming the server returns the updated brands
                },
                error: function(error) {
                    // Handle errors if necessary
                    console.error(error);
                }
            });
        } else {
            // When no type is selected.
            console.log('No se ha seleccionado ningún tipo');
        }

        // Clean new brand input.
        document.getElementById('newBrand').value = '';
    });

    // Function to update the select with new brands
    function updateBrandSelect(brands) {
        var select = document.getElementById('brand-dropdown');
        select.innerHTML = '';  // Clear existing options

        var brandsEmpty = !brands || brands.length == 0;

        if(!brandsEmpty) {
            // Add new options
            brands.forEach(function(brand) {
                var option = document.createElement('option');
                option.value = brand.id;
                option.text = brand.brand;
                select.appendChild(option);
            });
        }
        
        // Disable or enable the brand dropdown based on whether brands are empty
        $('#brand-dropdown').prop('disabled', brandsEmpty);
        // Disable or enable add model button.
        $('#addModelButton').prop('disabled', brandsEmpty);
    }
});
