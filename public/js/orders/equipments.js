// Ensure the DOM is fully loaded before executing the script.
document.addEventListener('DOMContentLoaded', function() {

    // Get references to various elements in the DOM.
    var openCreateEquipmentModalButton = document.getElementById('create-button');
    var closeCreateEquipmentModalButton = document.getElementById('closeCreateEquipmentModal');
    var cancelCreateEquipmentModalButton = document.getElementById('cancelCreateEquipmentModal');
    var createEquipmentModal = document.getElementById('createEquipmentModal');

    // Event listeners for opening and closing the create equipment modal.
    openCreateEquipmentModalButton.addEventListener('click', function () {
        createEquipmentModal.classList.add('is-active');
    });

    closeCreateEquipmentModalButton.addEventListener('click', function () {
        createEquipmentModal.classList.remove('is-active');
    });

    cancelCreateEquipmentModalButton.addEventListener('click', function () {
        createEquipmentModal.classList.remove('is-active');
    });

    // Get references to elements in the DOM for the change equipment modal.
    var openChangeEquipmentModalButton = document.getElementById('change-button');
    var closeChangeEquipmentModalButton = document.getElementById('closeChangeEquipmentModal');
    var cancelChangeEquipmentModalButton = document.getElementById('cancelChangeEquipmentModal');
    var changeEquipmentModal = document.getElementById('changeEquipmentModal');

    // Event listeners for opening and closing the change equipment modal.
    openChangeEquipmentModalButton.addEventListener('click', function () {
        changeEquipmentModal.classList.add('is-active');
    });

    closeChangeEquipmentModalButton.addEventListener('click', function () {
        changeEquipmentModal.classList.remove('is-active');
    });

    cancelChangeEquipmentModalButton.addEventListener('click', function () {
        changeEquipmentModal.classList.remove('is-active');
    });

    // Get references to the equipment form and buttons.
    var equipmentForm = document.getElementById('equipment-form');
    var saveEquipmentButton = document.getElementById('saveEquipmentButton');
    var changeEquipmentButton = document.getElementById('changeEquipmentButton');

    // Event listener for saving equipment data.
    saveEquipmentButton.addEventListener('click', function (event) {
        // Prevent default form submission behavior.
        event.preventDefault();

        // Get form data.
        var formData = new FormData(equipmentForm);

        // Send AJAX request to save equipment data.
        var xhr = new XMLHttpRequest();
        xhr.open('POST', equipmentForm.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // Add CSRF token if needed.
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Equipo creado exitosamente');
                } else {
                    console.error('Error al crear el equipo');
                }
            }
        };
        xhr.send(formData);

        // Show loading state for 2 seconds.
        setTimeout(function() {
            saveEquipmentButton.classList.add('is-loading');
        }, 2000);

        // Hide the create equipment modal.
        createEquipmentModal.classList.remove('is-active');
        saveEquipmentButton.classList.remove('is-loading');

        // Update equipment information.
        updateEquipment();
    });


    // Update equipment information when the document is fully loaded.
    $(document).ready(function() {
        updateEquipment();
    });


    // Event listener for client dropdown change.
    document.getElementById('client-dropdown').addEventListener('change', function() {
        updateEquipment();
    });


    // Function to update equipment list.
    function updateEquipment() {
        var defaultClientId = $('#client-dropdown').val();
        $.ajax({
            url: '/equipments/get-by-client/' + defaultClientId,
            method: 'GET',
            success: function(response) {
                updateEquipmentInfo(response.equipments);
                updateEquipmentsList(response.equipments);
            },
            error: function(error) {
                console.error(error);
            }
        });
    }


    // Function to update the equipments list.
    function updateEquipmentsList(equipments) {
        populateEquipmentColumns(equipments);
    }

    // Function to update equipment information on form.
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


    // Function to create an equipment element.
    function createEquipmentElement(equipment, selected) {

        // Create a div element for the equipment.
        const box = document.createElement('div');

        // Add classes to the box based on selection status.
        if(selected) {
            box.classList.add('box', 'is-flex', 'selected');
        } else {
            box.classList.add('box', 'is-flex');
        }

        // Create a div element for columns.
        const columns = document.createElement('div');
        columns.classList.add('columns', 'is-vcentered');
    
        // Create a column for the image (left).
        const imageColumn = document.createElement('div');
        imageColumn.classList.add('image-column', 'column', 'is-3');
    
        // Mapping object for equipment types to image names.
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

        // Get lowercase equipment type.
        const equipmentType = equipment.type.type.toLowerCase();

        // Get image name based on type, or default to 'equipment'.
        const imageName = imageMapping[equipmentType] || 'equipment';

        // Create an img element for the equipment image.
        const pcImage = document.createElement('img');
        pcImage.src = `/images/icons/${imageName}.png`;
        pcImage.alt = `${equipmentType.charAt(0).toUpperCase() + equipmentType.slice(1)} Image`; // Capitaliza la primera letra de la palabra
        pcImage.classList.add('equipment-image');
        imageColumn.appendChild(pcImage);
    
        // Create a column for information (right).
        const infoColumn = document.createElement('div');
        infoColumn.classList.add('info-column', 'column');
    
        // HTML content for equipment information.
        const content = `
            <p class="is-size-6 brand">Marca: ${equipment.brand.brand}</p>
            <p class="is-size-6 model">Modelo: ${equipment.model.model}</p>
            <p class="is-size-6 serial-number">N/S: ${equipment.serial_number}</p>
        `;
        infoColumn.innerHTML = content;
    
        // Append columns to the box.
        box.appendChild(columns);
        columns.appendChild(imageColumn);
        columns.appendChild(infoColumn);

        // Add click event to change selection.
        box.addEventListener('click', function() {
            const selectedBoxes = document.querySelectorAll('.box.selected');
            selectedBoxes.forEach(function(selectedBox) {
                selectedBox.classList.remove('selected');
            });
            box.classList.add('selected');
        });
    
        return box;
    }

    // Function to populate equipment elements into columns.
    function populateEquipmentColumns(equipments) {
        // Get columns by their IDs.
        const columns = [
            document.getElementById('equipment-column-1'),
            document.getElementById('equipment-column-2'),
            document.getElementById('equipment-column-3')
        ];

        // Clear the content of columns.
        columns.forEach(column => {
            column.innerHTML = '';
        });

        // Iterate through equipments and add each to the corresponding column.
        equipments.forEach((equipment, index) => {
            const columnIndex = index % columns.length;
            const column = columns[columnIndex];
            const equipmentElement = createEquipmentElement(equipment, equipment == equipments[0]);
            column.appendChild(equipmentElement);
        });
    }

    // Event listener for the change equipment button.
    changeEquipmentButton.addEventListener('click', function (event) {
        // Find selected equipment.
        const selectedEquipment = document.querySelector('.box.selected');
    
        // Check if equipment is selected.
        if (selectedEquipment) {
            // Get serial number of selected equipment.
            var serialNumber = selectedEquipment.querySelector('.serial-number').textContent;
            serialNumber = serialNumber.replace('N/S:', '');
            serialNumber = serialNumber.replace(' ', '');

            // Make an AJAX request to get equipment associated with the serial number.
            $.ajax({
                url: '/equipments/get-by-serial-number/' + serialNumber.replace("N/S:%20", ""),
                method: 'GET',
                success: function(response) {
                    updateEquipmentInfo(response.equipment);
                },
                error: function(error) {
                    // Handle errors if necessary.
                    console.error(error);
                }
            });

        } else {
            console.log("No se ha seleccionado ningún equipo.");
        }

        // Close the change equipment modal.
        changeEquipmentModal.classList.remove('is-active');
    });
});