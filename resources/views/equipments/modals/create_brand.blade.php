{{-- Brand creation modal --}}
<div class="modal" id="addBrandModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Nueva marca de equipo</p>
            <button class="delete" aria-label="close" id="closeBrandModal"></button>
        </header>
        <section class="modal-card-body">
            <div class="field">
                <div class="control">
                    <input class="input" type="text" id="newBrand" placeholder="Ingrese la nueva marca de equipo">
                </div>
            </div>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelBrandModal">Cancelar</button>
            <a href="#">
                <button class="button is-success" id="saveBrandButton">Guardar</button>
            </a>
        </footer>
    </div>
</div>