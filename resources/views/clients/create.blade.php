@extends('components.layouts.nav')

@section('title')
    Nuevo cliente
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">
            
            @if (session('success') != null)
            <div class="columns is-centered is-vcentered">
                <div class="column is-two-fifths">
                    <div class="notification is-success">
                        <p class="has-text-centered">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if (session('problem') != null)
            <div class="columns is-centered is-vcentered">
                <div class="column is-two-fifths">
                    <div class="notification is-danger">
                        <p class="has-text-centered">{{ session('problem') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <div class="columns is-centered is-vcentered">
                <div class="column is-5">
                    <div class="box user-create-scrollable">
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
                                <div class="control has-icons-left">
                                    <input class="input" type="email" name="email" id="email" placeholder="correo@midominio.com">
                                    <span class="icon is-small is-left">
                                        <i class="bx bx-envelope"></i>
                                    </span>
                                </div>
                                @if ($errors->create->first('email'))
                                    <small style="color: red">{{ $errors->create->first('email') }} </small>
                                @endif
                            </div>

                            {{-- <div class="field">
                                <label class="label" for="company">Organización</label>
                                <div class="control has-icons-left has-icons-right">
                                    <div class="select is-fullwidth">
                                        <select name="company" id="company-dropdown">
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->business_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="icon is-small is-left">
                                            <i class="bx bxs-business"></i>
                                        </span>
                                    </div>
                                </div>
                                @if ($errors->create->first('company'))
                                    <small style="color: red">{{ $errors->create->first('company') }} </small>
                                @endif
                           </div>                      --}}
                           
                           <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label" for="address">Dirección</label>
                                        <div class="control has-icons-left">
                                            <input class="input" type="text" name="address" id="address" placeholder="Escriba aquí la dirección...">
                                            <span class="icon is-small is-left">
                                                <i class="bx bxs-id-card"></i>
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
                                                <i class="bx bxs-id-card"></i>
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
                                                <i class="bx bxs-id-card"></i>
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
                                            <input class="input" type="text" name="postal_code" id="postal_code" placeholder="Escriba aquí la localidad del cliente...">
                                            <span class="icon is-small is-left">
                                                <i class="bx bxs-id-card"></i>
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
                                        <i class="bx bx-envelope"></i>
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

                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('clients') }}">
                                            <button type="button" class="button is-link is-light">Volver</button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-link">Crear cliente</button>
                                    </div>
                                </div>
                            </div>
                    
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @parent

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get references to the "Subscribed Client" and "End Client" checkboxes.
            const subscribedClientCheckbox = document.getElementById('subscribed_client');
            const endClientCheckbox = document.getElementById('end_client');
    
            // Event listener for the "Subscribed Client" checkbox.
            subscribedClientCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // If "Subscribed Client" is selected, uncheck "End Client".
                    endClientCheckbox.checked = false;
                }
            });
    
            // Event listener for the "End Client" checkbox.
            endClientCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    // If "End Client" is selected, uncheck "Subscribed Client".
                    subscribedClientCheckbox.checked = false;
                }
            });
        });
    </script>    
@endsection
