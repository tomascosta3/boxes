// Ensure the DOM is fully loaded before executing the script.
document.addEventListener('DOMContentLoaded', function() {

    $(document).ready(function() {
        updateClientInForm();
    });

    document.getElementById('client-dropdown').addEventListener('change', function() {
        updateClientInForm();
    });

    function updateClientInForm() {
        var clientID = $('#client-dropdown').val();
        document.getElementById('client_id').value = clientID;
    }

    // Get references to various elements in the DOM.
    var openCreateClientModalButton = document.getElementById('addClientButton');
    var closeCreateClientModalButton = document.getElementById('closeClientModal');
    var cancelCreateClientModalButton = document.getElementById('cancelClientModal');
    var createClientModal = document.getElementById('createClientModal');

    // Event listeners for opening and closing the create Client modal.
    openCreateClientModalButton.addEventListener('click', function () {
        createClientModal.classList.add('is-active');
    });

    closeCreateClientModalButton.addEventListener('click', function () {
        createClientModal.classList.remove('is-active');
    });

    cancelCreateClientModalButton.addEventListener('click', function () {
        createClientModal.classList.remove('is-active');
    });

    // Get references to the client form and buttons.
    var clientForm = document.getElementById('client-form');
    var saveClientButton = document.getElementById('saveClientButton');

    // Event listener for saving client data.
    saveClientButton.addEventListener('click', function (event) {
        // Prevent default form submission behavior.
        event.preventDefault();

        // Get form data.
        var formData = new FormData(clientForm);

        // Send AJAX request to save equipment data.
        var xhr = new XMLHttpRequest();
        xhr.open('POST', clientForm.action, true);
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // Add CSRF token if needed.
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Cliente creado exitosamente');

                    // Parse response to get the generated client ID
                    var response = JSON.parse(xhr.responseText);
                    var clientId = response.client.id;

                    // Update client information.
                    updateClient(clientId);
                } else {
                    console.error('Error al crear el cliente');
                }
            }
        };
        xhr.send(formData);

        // Show loading state for 2 seconds.
        setTimeout(function() {
            saveClientButton.classList.add('is-loading');
        }, 2000);

        // Hide the create client modal.
        createClientModal.classList.remove('is-active');
        saveClientButton.classList.remove('is-loading');
    });


    // Function to update the client dropdown list.
    function updateClient(clientId) {
        // Fetch updated client data from the server.
        fetch('/clients/get-formatted')
            .then(response => response.json())
            .then(data => {
                // Update the dropdown with the obtained data.
                const clientDropdown = document.getElementById('client-dropdown');
                clientDropdown.innerHTML = ''; // Clear current dropdown options.
                
                // Iterate over the new data and create options for each client.
                data.clients.forEach(client => {
                    const option = document.createElement('option');
                    option.value = client.id;
                    option.textContent = `${client.last_name} ${client.first_name} - Tel: ${client.phone_number}`;
                    clientDropdown.appendChild(option);

                    // Set the selected option if client.id matches the provided clientId.
                    if (client.id === clientId) {
                        option.selected = true;
                    }
                });
                // Trigger a change event on the dropdown.
                clientDropdown.dispatchEvent(new Event('change'));
            })
            .catch(error => {
                console.error('Error fetching data from the server:', error);
            });
    }
});