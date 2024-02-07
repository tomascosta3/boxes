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
});