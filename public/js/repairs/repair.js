document.addEventListener("DOMContentLoaded", function() {
    // Add event listener for send button click.
    const sendButton = document.getElementById('send-button');
    sendButton.addEventListener('click', function() {
        // Get the new message from the input field.
        const newMessage = document.getElementById('new-message').value;

        // Check if the message is not empty.
        if (newMessage.trim() !== '') {
            // Send the message to the server.
            sendMessage();
        }
    });

    // Wait for the document to be fully loaded.
    $(document).ready(function() {
        // Update the messages when the document is ready.
        updateMessages();
    });

    // Function to send a new message to the server.
    function sendMessage() {
        // Get the CSRF token from the meta tag.
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Get the value from the input field and binnacle ID.
        var newMessage = document.getElementById('new-message').value;
        var binnacle = document.getElementById('binnacle-id').value;

        // Make an AJAX request to save the new message.
        $.ajax({
            url: '/save-message',
            method: 'POST',
            data: {message: newMessage, binnacle: binnacle},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Update the messages list after sending the message.
                updateMessages();
            },
            error: function(error) {
                // Handle errors if necessary.
                console.error('Error sending message: ', error);
            }
        });
    }

    // Function to update the messages list.
    function updateMessages() {
        // Get the ID of the binnacle.
        var binnacle = document.getElementById('binnacle-id').value;

        // Make an AJAX request to get the messages associated with the binnacle.
        $.ajax({
            url: '/get-messages/' + binnacle,
            method: 'GET',
            success: function(response) {
                // Update the messages list with the obtained data.
                updateMessagesList(response.messages);
            },
            error: function(error) {
                // Handle errors if necessary.
                console.error('Error updating messages: ', error);
            }
        });
    }

    // Function to update the messages list HTML.
    function updateMessagesList(messages) {
        const messagesDiv = document.querySelector('.messages');
        messagesDiv.innerHTML = ''; // Clear the messages.
        messages.forEach(message => {
            // Get the message date and convert it to a Date object.
            const messageDate = new Date(message.created_at);

            // Get the date in dd-mm-yyyy format.
            const day = messageDate.getDate().toString().padStart(2, '0');
            const month = (messageDate.getMonth() + 1).toString().padStart(2, '0'); // Adding 1 because getMonth returns zero-based month.
            const year = messageDate.getFullYear().toString();
            const date = `${day}/${month}/${year}`;

            // Get the time in hh:mm:ss format.
            const hours = messageDate.getHours().toString().padStart(2, '0');
            const minutes = messageDate.getMinutes().toString().padStart(2, '0');
            const seconds = messageDate.getSeconds().toString().padStart(2, '0');
            const time = `${hours}:${minutes}:${seconds}`;

            // Build the HTML for the message.
            const messageHTML = `
                <div class="box p-2 mb-2 is-shadowless message">
                    <p class="text-message">${message.message}</p>
                    <p class="text-username">${message.user.last_name} ${message.user.first_name} -</p>
                    <p class="text-date">${date} ${time}</p>
                </div>`;
            messagesDiv.insertAdjacentHTML('beforeend', messageHTML);
        });
    }
});
