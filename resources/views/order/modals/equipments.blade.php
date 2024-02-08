{{-- Equipments list modal --}}
<div class="modal" id="changeEquipmentModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Seleccionar equipo</p>
            <button class="delete" aria-label="close" id="closeChangeEquipmentModal"></button>
        </header>
        <section class="modal-card-body">
            <div class="columns">
                <div class="column" id="equipment-column-1"></div>
                <div class="column" id="equipment-column-2"></div>
                <div class="column" id="equipment-column-3"></div>
            </div>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelChangeEquipmentModal">Cancelar</button>
            <button class="button is-success" id="changeEquipmentButton">Cambiar</button>
        </footer>
    </div>
</div>