// Ensure the DOM is fully loaded before executing the script.
document.addEventListener('DOMContentLoaded', function() {

    var openCreateEquipmentModalButton = document.getElementById('create-button');
    var closeCreateEquipmentModalButton = document.getElementById('closeCreateEquipmentModal');
    var cancelCreateEquipmentModalButton = document.getElementById('cancelCreateEquipmentModal');
    var createEquipmentModal = document.getElementById('createEquipmentModal');

    openCreateEquipmentModalButton.addEventListener('click', function () {
        createEquipmentModal.classList.add('is-active');
    });

    closeCreateEquipmentModalButton.addEventListener('click', function () {
        createEquipmentModal.classList.remove('is-active');
    });

    cancelCreateEquipmentModalButton.addEventListener('click', function () {
        createEquipmentModal.classList.remove('is-active');
    });


    // Obtener referencia al formulario y al botón de guardar
    var equipmentForm = document.getElementById('equipment-form');
    var saveEquipmentButton = document.getElementById('saveEquipmentButton');

    // Agregar un event listener al botón de guardar
    saveEquipmentButton.addEventListener('click', function (event) {
        // Prevenir el comportamiento predeterminado del formulario (recargar la página)
        event.preventDefault();

        // Obtener los datos del formulario
        var formData = new FormData(equipmentForm);

        // Realizar la solicitud AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', equipmentForm.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // Agregar token CSRF si es necesario
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // La solicitud se completó correctamente
                    console.log('Equipo creado exitosamente');
                    // Opcional: cerrar el modal o realizar otras acciones después de guardar
                } else {
                    // Ocurrió un error al guardar el equipo
                    console.error('Error al crear el equipo');
                    // Opcional: mostrar un mensaje de error al usuario
                }
            }
        };
        xhr.send(formData);

        setTimeout(function() {
            saveEquipmentButton.classList.add('is-loading');
        }, 2000);

        createEquipmentModal.classList.remove('is-active');
        saveEquipmentButton.classList.remove('is-loading');

        updateEquipment();
    });


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

    }
});