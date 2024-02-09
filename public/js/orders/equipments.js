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

    var openChangeEquipmentModalButton = document.getElementById('change-button');
    var closeChangeEquipmentModalButton = document.getElementById('closeChangeEquipmentModal');
    var cancelChangeEquipmentModalButton = document.getElementById('cancelChangeEquipmentModal');
    var changeEquipmentModal = document.getElementById('changeEquipmentModal');

    openChangeEquipmentModalButton.addEventListener('click', function () {
        changeEquipmentModal.classList.add('is-active');
    });

    closeChangeEquipmentModalButton.addEventListener('click', function () {
        changeEquipmentModal.classList.remove('is-active');
    });

    cancelChangeEquipmentModalButton.addEventListener('click', function () {
        changeEquipmentModal.classList.remove('is-active');
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
        populateEquipmentColumns(equipments);
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

    function createEquipmentElement(equipment) {
        const box = document.createElement('div');
        box.classList.add('box', 'is-flex');

        const columns = document.createElement('div');
        columns.classList.add('columns', 'is-vcentered');
    
        // Columna para la imagen (izquierda)
        const imageColumn = document.createElement('div');
        imageColumn.classList.add('image-column', 'column', 'is-3'); // Añade un margen derecho opcional
    
        // Objeto de mapeo de tipos de equipos a nombres de imágenes
        const imageMapping = {
            'pc/cpu': 'pc',
            'impresora': 'printer',
            'router': 'router',
            'switch': 'switch',
            'notebook': 'notebook',
            'cámara': 'camera',
            'camara': 'camera',
            'monitor': 'monitor',
            'proyector': 'projector',
            'ups': 'ups',
            'dvr': 'dvr',
            'nvr': 'dvr',
            'xvr': 'dvr',
        };

        const equipmentType = equipment.type.type.toLowerCase();
        const imageName = imageMapping[equipmentType] || 'equipment'; // Usar 'equipo' como imagen predeterminada si no se encuentra la clave

        const pcImage = document.createElement('img');
        pcImage.src = `/images/icons/${imageName}.png`;
        pcImage.alt = `${equipmentType.charAt(0).toUpperCase() + equipmentType.slice(1)} Image`; // Capitaliza la primera letra de la palabra
        pcImage.classList.add('equipment-image');
        imageColumn.appendChild(pcImage);
    
        // Columna para la información (derecha)
        const infoColumn = document.createElement('div');
        infoColumn.classList.add('info-column', 'column');
    
        const content = `
            <p class="is-size-6">Marca: ${equipment.brand.brand}</p>
            <p class="is-size-6">Modelo: ${equipment.model.model}</p>
            <p class="is-size-6">N/S: ${equipment.serial_number}</p>
        `;
        infoColumn.innerHTML = content;
    
        // Agrega las columnas al box
        box.appendChild(columns);
        columns.appendChild(imageColumn);
        columns.appendChild(infoColumn);
    
        return box;
    }

    // Función para agregar los elementos de equipo a las columnas
    function populateEquipmentColumns(equipments) {
        const columns = [
            document.getElementById('equipment-column-1'),
            document.getElementById('equipment-column-2'),
            document.getElementById('equipment-column-3')
        ];

        // Limpiar el contenido de las columnas
        columns.forEach(column => {
            column.innerHTML = ''; // Vaciar el contenido
        });

        // Itera sobre el array de equipos y agrega cada equipo a la columna correspondiente
        equipments.forEach((equipment, index) => {
            const columnIndex = index % columns.length; // Calcula el índice de la columna
            const column = columns[columnIndex];
            const equipmentElement = createEquipmentElement(equipment);
            column.appendChild(equipmentElement);
        });
    }
});