{{-- Model creation modal --}}
<div class="modal" id="addModelModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Nuevo modelo de equipo</p>
            <button class="delete" aria-label="close" id="closeModelModal"></button>
        </header>
        <section class="modal-card-body">
            <div class="field">
                <div class="control">
                    <input class="input" type="text" id="newModel" placeholder="Ingrese el nuevo modelo de equipo">
                </div>
            </div>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelModelModal">Cancelar</button>
            <a href="#">
                <button class="button is-success" id="saveModelButton">Guardar</button>
            </a>
        </footer>
    </div>
</div>