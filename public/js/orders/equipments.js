// Ensure the DOM is fully loaded before executing the script.
document.addEventListener('DOMContentLoaded', function() {
    // Wait for the document to be fully loaded.
    $(document).ready(function() {
        updateEquipment();
    });


    document.getElementById('client-dropdown').addEventListener('change', function() {
        updateEquipment();
    });

    
    function updateEquipment() {
        // Get the value of the client selected by default in the dropdown.
        var defaultClientId = $('#client-dropdown').val();

        // Make an AJAX request to get the equipments associated with the default client.
        $.ajax({
            url: '/equipments/get-by-client/' + defaultClientId,
            method: 'GET',
            success: function(response) {

                updateEquipmentInfo(response.equipments);
                
                // Update the equipments modal with the obtained options.
                updateEquipmentsList(response.equipments);
            },
            error: function(error) {
                // Handle errors if necessary
                console.error(error);
            }
        });
    }


    // Function to update the equipments list.
    function updateEquipmentsList(equipments) {
        
    }

    // Function to update equipment info on form.
    function updateEquipmentInfo(equipments) {

        var changeButton = document.getElementById('change-button');
        var createButton = document.getElementById('create-button');
        var createButtonColumn = document.getElementById('create-button-column');

        // Verify if there are equipments.
        if (equipments.length > 0) {
            // Get first equipment.
            var firstEquipment = equipments[0];

            // Update <p> values.
            document.getElementById('type').innerHTML = `<strong>TIPO:</strong> ${firstEquipment.type.type}`;
            document.getElementById('brand').style.display = 'block';
            document.getElementById('brand').innerHTML = `<strong>MARCA:</strong> ${firstEquipment.brand.brand}`;
            document.getElementById('model').style.display = 'block';
            document.getElementById('model').innerHTML = `<strong>MODELO:</strong> ${firstEquipment.model.model}`;
            document.getElementById('serial-number').style.display = 'block';
            document.getElementById('serial-number').innerHTML = `<strong>N/S:</strong> ${firstEquipment.serial_number}`;

            changeButton.style.display = 'block';

            if(createButton.classList.contains('ml-6')) {
                createButton.classList.remove('ml-6');
            }

            if(createButtonColumn.classList.contains('ml-5')) {
                createButtonColumn.classList.remove('ml-5');
            }
        } else {

            document.getElementById('type').innerHTML = '<p class="has-text-centered">El cliente seleccionado no tiene ningún equipo</p>';
            document.getElementById('brand').style.display = 'none';
            document.getElementById('model').style.display = 'none';
            document.getElementById('serial-number').style.display = 'none';

            changeButton.style.display = 'none';
            createButton.classList.add('ml-6');
            createButtonColumn.classList.add('ml-5');
        }








        // // Suponiendo que 'equipments' contiene la respuesta del controlador con los equipos del cliente
        // if (equipments.length > 0) {
        //     // Si hay equipos, mostramos la información de los equipos
        //     document.getElementById('type').innerHTML = '<strong>TIPO:</strong> ' + equipments[0].type;
        //     document.getElementById('brand').innerHTML = '<strong>MARCA:</strong> ' + equipments[0].brand;
        //     document.getElementById('model').innerHTML = '<strong>MODELO:</strong> ' + equipments[0].model;
        //     document.getElementById('serial-number').innerHTML = '<strong>N/S:</strong> ' + equipments[0].serialNumber;
        // } else if (typeof $equipment === 'undefined' && typeof $client === 'undefined') {
        //     // Si no hay equipos ni cliente, mostramos el mensaje "Por favor, seleccione un cliente primero"
        //     document.getElementById('type').innerHTML = '<p class="has-text-centered">Por favor, seleccione un cliente primero</p>';
        // } else {
        //     // Si hay cliente pero no hay equipos, mostramos el mensaje "Por favor, seleccione un equipo"
        //     document.getElementById('type').innerHTML = '<p class="has-text-centered">Por favor, seleccione un equipo</p>';
        // }

    }
});