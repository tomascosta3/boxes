{{-- Client creation modal --}}
<div class="modal" id="createClientModal">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Nuevo cliente</p>
            <button class="delete" aria-label="close" id="closeClientModal"></button>
        </header>
        <section class="modal-card-body">
            <form action="{{ route('clients.store') }}" method="post">
                @csrf

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label" for="first_name">Nombre</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" type="text" name="first_name" id="first_name" placeholder="Escriba aquí el nombre del cliente...">
                                <span class="icon is-small is-left">
                                    <i class="bx bxs-id-card"></i>
                                </span>
                                <span class="icon is-small is-right">
                                    <i class='bx bx-error-circle'></i>
                                </span>
                            </div>
                            @if ($errors->create->first('first_name'))
                                <small style="color: red">{{ $errors->create->first('first_name') }} </small>
                            @endif
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label" for="last_name">Apellido</label>
                            <div class="control has-icons-left has-icons-right">
                                <input class="input" type="text" name="last_name" id="last_name" placeholder="Escriba aquí el apellido del cliente...">
                                <span class="icon is-small is-left">
                                    <i class="bx bxs-id-card"></i>
                                </span>
                                <span class="icon is-small is-right">
                                    <i class='bx bx-error-circle'></i>
                                </span>
                            </div>
                            @if ($errors->create->first('last_name'))
                                <small style="color: red">{{ $errors->create->first('last_name') }} </small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="phone_number">Teléfono de contacto</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="text" name="phone_number" id="phone_number" placeholder="xx xxxx-xxxxxx">
                        <span class="icon is-small is-left">
                            <i class="bx bx-phone"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class='bx bx-error-circle'></i>
                        </span>
                    </div>

                    @if ($errors->create->first('phone_number'))
                        <small style="color: red">{{ $errors->create->first('phone_number') }} </small>
                    @endif
                </div>

                <div class="field">
                    <label class="label" for="email">Correo electrónico</label>
                    <div class="control has-icons-left has-icons-right">
                        <input class="input" type="email" name="email" id="email" placeholder="correo@midominio.com">
                        <span class="icon is-small is-left">
                            <i class="bx bx-envelope"></i>
                        </span>
                        <span class="icon is-small is-right">
                            <i class='bx bx-error-circle'></i>
                        </span>
                    </div>
                    @if ($errors->create->first('email'))
                        <small style="color: red">{{ $errors->create->first('email') }} </small>
                    @endif
                </div>
               
                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label" for="address">Dirección</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="address" id="address" placeholder="Escriba aquí la dirección...">
                                <span class="icon is-small is-left">
                                    <i class="bx bx-home-alt"></i>
                                </span>
                            </div>
                            @if ($errors->create->first('address'))
                                <small style="color: red">{{ $errors->create->first('address') }} </small>
                            @endif
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label" for="locality">Localidad</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="locality" id="locality" placeholder="Escriba aquí la localidad del cliente...">
                                <span class="icon is-small is-left">
                                    <i class="bx bxs-city"></i>
                                </span>
                            </div>
                            @if ($errors->create->first('locality'))
                                <small style="color: red">{{ $errors->create->first('locality') }} </small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label" for="province">Provincia</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="province" id="province" placeholder="Escriba aquí la provincia...">
                                <span class="icon is-small is-left">
                                    <i class="bx bx-buildings"></i>
                                </span>
                            </div>
                            @if ($errors->create->first('province'))
                                <small style="color: red">{{ $errors->create->first('province') }} </small>
                            @endif
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label" for="postal_code">Código Postal</label>
                            <div class="control has-icons-left">
                                <input class="input" type="text" name="postal_code" id="postal_code" placeholder="Escriba aquí el código postal cliente...">
                                <span class="icon is-small is-left">
                                    <i class="bx bx-envelope-open"></i>
                                </span>
                            </div>
                            @if ($errors->create->first('postal_code'))
                                <small style="color: red">{{ $errors->create->first('postal_code') }} </small>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label" for="cuit">CUIT</label>
                    <div class="control has-icons-left">
                        <input class="input" type="text" name="cuit" id="cuit" placeholder="Escriba aquí el CUIT del cliente...">
                        <span class="icon is-small is-left">
                            <i class="bx bx-id-card"></i>
                        </span>
                    </div>
                    @if ($errors->create->first('cuit'))
                        <small style="color: red">{{ $errors->create->first('cuit') }} </small>
                    @endif
                </div>

                <label class="label">Tipo de cliente</label>
                <div class="columns is-vcentered has-text-centered">
                    <div class="column">
                        <div class="field">
                            <label class="checkbox" for="subscribed_client">
                                <input type="checkbox" name="subscribed_client" id="subscribed_client">
                                Cliente abonado
                            </label>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="checkbox" for="end_client">
                                <input type="checkbox" name="end_client" id="end_client" checked>
                                Cliente final
                            </label>
                        </div>
                    </div>
                </div>

            </form>
        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelClientModal">Cancelar</button>
            <a href="#">
                <button class="button is-success" id="saveClientButton">Crear</button>
            </a>
        </footer>
    </div>
</div>