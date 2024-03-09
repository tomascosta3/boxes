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
});