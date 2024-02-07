{{-- Create equipment modal --}}
<div class="modal" id="createEquipmentModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Crear nuevo equipo</p>
            <button class="delete" aria-label="close" id="closeCreateEquipmentModal"></button>
        </header>
        <section class="modal-card-body">
            <form action="{{ route('equipments.store') }}" id="equipment-form" method="post">
                @csrf

                <input type="hidden" name="client" id="client_id">

                <label class="label" for="type">Tipo</label>
                <div class="field is-grouped">
                    <div class="control is-expanded">
                        <div class="control has-icons-left">
                            <div class="select is-fullwidth">
                                <select name="type" id="type-dropdown">
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
                    <div class="control">
                        <button class="button is-link" id="addTypeButton" type="button">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
                @if ($errors->create->first('type'))
                    <small style="color: red">{{ $errors->create->first('type') }} </small>
                @endif

                <label class="label" for="brand">Marca</label>
                <div class="field is-grouped">
                    <div class="control is-expanded">
                        <div class="control has-icons-left">
                            <div class="select is-fullwidth">
                                <select name="brand" id="brand-dropdown">
                                    @if (isset($brands))
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->brand }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="icon is-small is-left">
                                    <i class="bx bx-desktop"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="control">
                        <button class="button is-link" id="addBrandButton" type="button">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
                @if ($errors->create->first('brand'))
                    <small style="color: red">{{ $errors->create->first('brand') }} </small>
                @endif

                <label class="label" for="model">Modelo</label>
                <div class="field is-grouped">
                    <div class="control is-expanded">
                        <div class="control has-icons-left">
                            <div class="select is-fullwidth">
                                <select name="model" id="model-dropdown">
                                    @if (isset($models))
                                        @foreach ($models as $model)
                                            <option value="{{ $model->id }}">{{ $model->model }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                </select>
                                <span class="icon is-small is-left">
                                    <i class="bx bx-desktop"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="control">
                        <button class="button is-link" id="addModelButton" type="button">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
                @if ($errors->create->first('model'))
                    <small class="mt-0" style="color: red">{{ $errors->create->first('model') }} </small>
                @endif

                <label class="label" for="serial_number">Número de serie</label>
                <div class="field is-grouped">
                    <div class="control is-expanded">
                        <div class="control has-icons-left has-icons-right">
                            <div class="is-fullwidth">
                                <input class="input" type="text" name="serial_number" id="serial_number" placeholder="Ingrese aquí el número de serie o genere uno">
                                <span class="icon is-small is-left">
                                    <i class="bx bx-barcode"></i>
                                </span>
                                <span class="icon is-small is-right">
                                    <i class='bx bx-error-circle'></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="control">
                        <button class="button is-link" id="generateSerialNumberButton" type="button">
                            Generar
                        </button>
                    </div>
                </div>
                @if ($errors->create->first('serial_number'))
                    <small style="color: red">{{ $errors->create->first('serial_number') }} </small>
                @endif

                <div class="field">
                    <label class="label" for="observations">Observaciones:</label>
                    <div class="control">
                        <textarea class="textarea" name="observations"></textarea>
                    </div>
                    <small>Este campo no es obligatorio</small>
                    @if ($errors->create->first('observations'))
                        <small style="color: red">{{ $errors->create->first('observations') }} </small>
                    @endif
                </div>
            </form>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelCreateEquipmentModal">Cancelar</button>
            <button class="button" type="button" id="addPhotoModal">Agregar fotos</button>
            <a href="#">
                <button class="button is-success" id="saveEquipmentButton">Guardar</button>
            </a>
        </footer>
    </div>
</div>