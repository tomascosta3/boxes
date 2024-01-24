{{-- Type creation modal --}}
<div class="modal" id="addTypeModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Nuevo tipo de equipo</p>
            <button class="delete" aria-label="close" id="closeTypeModal"></button>
        </header>
        <section class="modal-card-body">
            <div class="field">
                <div class="control">
                    <input class="input" type="text" id="newType" placeholder="Ingrese el nuevo tipo de equipo">
                </div>
            </div>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelTypeModal">Cancelar</button>
            <a href="#">
                <button class="button is-success" id="saveTypeButton">Guardar</button>
            </a>
        </footer>
    </div>
</div>