// Ensure the DOM is fully loaded before executing the script.
document.addEventListener('DOMContentLoaded', function() {

    // Event listener for the button that opens the modal.
    document.getElementById('changeTypeButton').addEventListener('click', function() {
        document.getElementById('changeTypeModal').classList.add('is-active');
    });

    // Event listener for the button that closes the modal.
    document.getElementById('closeChangeTypeModal').addEventListener('click', function() {
        document.getElementById('changeTypeModal').classList.remove('is-active');
    });

    // Event listener for the button that cancels and closes the modal.
    document.getElementById('cancelChangeTypeModal').addEventListener('click', function() {
        document.getElementById('changeTypeModal').classList.remove('is-active');
    });

    // Event listener for the button that saves and closes the modal.
    document.getElementById('saveChangeTypeButton').addEventListener('click', function() {
        // Get selected value.
        var selectedType = document.getElementById('changeTypeSelect').value;

        // Get selected value text.
        var selectedTypeText = document.getElementById('changeTypeSelect').options[document.getElementById('changeTypeSelect').selectedIndex].text;

        // Update input value with selected type.
        document.getElementById('type').value = selectedTypeText;

        // Update input value with selected type ID.
        document.getElementById('selectedTypeId').value = selectedType;

        document.getElementById('changeTypeModal').classList.remove('is-active');
    });
});

// function updateBrand() {
//     // Obtener el valor seleccionado del select
//     var selectedBrand = document.getElementById('newBrandSelect').value;

//     // Actualizar el valor del input con la nueva marca seleccionada
//     document.getElementById('brand').value = selectedBrand;

//     // Cerrar el modal
//     $('#brandModal').modal('hide');
// }