{{-- Type change modal --}}
<div class="modal" id="changeTypeModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Cambiar tipo de equipo</p>
            <button class="delete" aria-label="close" id="closeChangeTypeModal"></button>
        </header>
        <section class="modal-card-body">
            <div class="field">
                <div class="control has-icons-left">
                    <div class="select is-fullwidth">
                        <select name="type" id="changeTypeSelect">
                            @if (isset($types))
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type }}</option>
                                @endforeach
                            @endif
                        </select>
                        <span class="icon is-small is-left">
                            <i class="bx bx-desktop"></i>
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelChangeTypeModal">Cancelar</button>
            <a href="#">
                <button class="button is-success" id="saveChangeTypeButton">Guardar</button>
            </a>
        </footer>
    </div>
</div>