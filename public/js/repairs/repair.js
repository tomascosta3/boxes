document.addEventListener("DOMContentLoaded", function() {
    const sendButton = document.getElementById('send-button');
    sendButton.addEventListener('click', function() {
        const newMessage = document.getElementById('new-message').value;

        if (newMessage.trim() !== '') {
            // Enviar el mensaje al servidor
            sendMessage();
        }
    });

    function sendMessage() {
        // Get the CSRF token from the meta tag.
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Get the value from the input field.
        var newMessage = document.getElementById('new-message').value;
        var binnacle = document.getElementById('binnacle-id').value;

        
        $.ajax({
            url: '/save-message',
            method: 'POST',
            data: {message: newMessage, binnacle: binnacle},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                // Acciones a realizar en caso de éxito
                console.log('Mensaje enviado correctamente:', response);

                // Realizar alguna acción adicional si es necesario
            },
            error: function(error) {
                // Acciones a realizar en caso de error
                console.error('Error al enviar el mensaje:', error);
            }
        });
    }

    function actualizarMensajes(mensajes) {
        const messagesDiv = document.querySelector('.messages');
        messagesDiv.innerHTML = ''; // Limpiar los mensajes actuales
        mensajes.forEach(mensaje => {
            const mensajeHTML = `
                <div class="box p-2 is-shadowless message">
                    <p class="text-message">${mensaje.texto}</p>
                    <p class="text-username">${mensaje.usuario}</p>
                    <p class="text-date">${mensaje.fecha}</p>
                </div>`;
            messagesDiv.insertAdjacentHTML('beforeend', mensajeHTML);
        });
    }
});