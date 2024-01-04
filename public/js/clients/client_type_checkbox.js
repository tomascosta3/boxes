document.addEventListener('DOMContentLoaded', function() {
    // Get references to the "Subscribed Client" and "End Client" checkboxes.
    const subscribedClientCheckbox = document.getElementById('subscribed_client');
    const endClientCheckbox = document.getElementById('end_client');

    // Event listener for the "Subscribed Client" checkbox.
    subscribedClientCheckbox.addEventListener('change', function() {
        // If "Subscribed Client" is selected, uncheck "End Client".
        if (this.checked) {
            endClientCheckbox.checked = false;
        }
    });

    // Event listener for the "End Client" checkbox.
    endClientCheckbox.addEventListener('change', function() {
        // If "End Client" is selected, uncheck "Subscribed Client".
        if (this.checked) {
            subscribedClientCheckbox.checked = false;
        }
    });
});