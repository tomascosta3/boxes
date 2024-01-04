{{-- Delete confirmation modal --}}
<div class="modal" id="clientDeleteConfirmationModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Confirmación</p>
            <button class="delete" aria-label="close" id="closeModal"></button>
        </header>
        <section class="modal-card-body">
            <p class="has-text-centered">¿Estás seguro de que deseas eliminar este cliente?</p>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelModal">Cancelar</button>
            <a href="{{ route('clients.delete', ['id' => $client->id]) }}">
                <button class="button is-danger">Eliminar</button>
            </a>
        </footer>
    </div>
</div>