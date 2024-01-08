// Event listener for the button that saves the new Model.
document.getElementById('generateSerialNumberButton').addEventListener('click', function() {
    // Make an AJAX request to generate new serial number.
    $.ajax({
        url: '/equipments/serial-number',
        method: 'GET',
        success: function(response) {
            // Update serial number input.
            serialNumberInput = document.getElementById('serial_number');
            serialNumberInput.value = response.serialNumber;
        },
        error: function(error) {
            // Handle errors if necessary.
            console.error(error);
        }
    });
});