@extends('components.layouts.nav')

@section('title')
    Usuario
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">

                {{-- Error or success message with document view --}}
                <div class="column is-6">    
                    @if (session('success') != null)
                        <div class="columns is-centered is-vcentered">
                            <div class="column is-10">
                                <div class="notification is-success">
                                    <p class="has-text-centered">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('problem') != null)
                        <div class="columns is-centered is-vcentered">
                            <div class="column is-11">
                                <div class="notification is-danger">
                                    <p class="has-text-centered">{{ session('problem') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="box has-background-light">
                        <form action="#" method="post">
                            @csrf

                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label" for="first_name">Nombre/s</label>
                                        <div class="control has-icons-left has-icons-right">
                                            <input class="input" type="text" name="first_name" id="first_name" placeholder="Escriba aquí el nombre del usuario..." value="{{ $client->first_name }}">
                                            <span class="icon is-small is-left">
                                                <i class="bx bxs-id-card"></i>
                                            </span>
                                            <span class="icon is-small is-right">
                                                <i class='bx bx-error-circle'></i>
                                            </span>
                                        </div>
                                        @if ($errors->edit->first('first_name'))
                                            <small style="color: red">{{ $errors->edit->first('first_name') }} </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label" for="last_name">Apellido/s</label>
                                        <div class="control has-icons-left has-icons-right">
                                            <input class="input" type="text" name="last_name" id="last_name" placeholder="Escriba aquí el apellido del usuario..." value="{{ $client->last_name }}">
                                            <span class="icon is-small is-left">
                                                <i class="bx bxs-id-card"></i>
                                            </span>
                                            <span class="icon is-small is-right">
                                                <i class='bx bx-error-circle'></i>
                                            </span>
                                        </div>
                                        @if ($errors->edit->first('last_name'))
                                            <small style="color: red">{{ $errors->edit->first('last_name') }} </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
    
                            <div class="field">
                                <label class="label" for="phone_number">Teléfono de contacto</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="text" name="phone_number" id="phone_number" placeholder="Escriba aquí el teléfono del usuario..." value="{{ $client->phone_number }}">
                                    <span class="icon is-small is-left">
                                        <i class="bx bx-phone"></i>
                                    </span>
                                </div>
                                @if ($errors->edit->first('phone_number'))
                                    <small style="color: red">{{ $errors->edit->first('phone_number') }} </small>
                                @endif
                            </div>
    
                            <div class="field">
                                <label class="label" for="email">Correo electrónico</label>
                                <div class="control has-icons-left has-icons-right">
                                    <input class="input" type="email" name="email" id="email" placeholder="correo@midominio.com" value="{{ $client->email }}">
                                    <span class="icon is-small is-left">
                                        <i class="bx bx-envelope"></i>
                                    </span>
                                    <span class="icon is-small is-right">
                                        <i class='bx bx-error-circle'></i>
                                    </span>
                                </div>
                                @if ($errors->edit->first('email'))
                                    <small style="color: red">{{ $errors->edit->first('email') }} </small>
                                @endif
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label" for="address">Dirección</label>
                                        <div class="control has-icons-left">
                                            <input class="input" type="text" name="address" id="address" placeholder="Escriba aquí la dirección..." value="{{ $client->address }}">
                                            <span class="icon is-small is-left">
                                                <i class="bx bx-home-alt"></i>
                                            </span>
                                        </div>
                                        @if ($errors->edit->first('address'))
                                            <small style="color: red">{{ $errors->edit->first('address') }} </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label" for="locality">Localidad</label>
                                        <div class="control has-icons-left">
                                            <input class="input" type="text" name="locality" id="locality" placeholder="Escriba aquí la localidad del cliente..." value="{{ $client->locality }}">
                                            <span class="icon is-small is-left">
                                                <i class="bx bxs-city"></i>
                                            </span>
                                        </div>
                                        @if ($errors->edit->first('locality'))
                                            <small style="color: red">{{ $errors->edit->first('locality') }} </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="field">
                                        <label class="label" for="province">Provincia</label>
                                        <div class="control has-icons-left">
                                            <input class="input" type="text" name="province" id="province" placeholder="Escriba aquí la provincia..." value="{{ $client->province }}">
                                            <span class="icon is-small is-left">
                                                <i class="bx bx-buildings"></i>
                                            </span>
                                        </div>
                                        @if ($errors->edit->first('province'))
                                            <small style="color: red">{{ $errors->edit->first('province') }} </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="label" for="postal_code">Código Postal</label>
                                        <div class="control has-icons-left">
                                            <input class="input" type="text" name="postal_code" id="postal_code" placeholder="Escriba aquí el código postal..." value="{{ $client->postal_code }}">
                                            <span class="icon is-small is-left">
                                                <i class="bx bx-envelope-open"></i>
                                            </span>
                                        </div>
                                        @if ($errors->edit->first('postal_code'))
                                            <small style="color: red">{{ $errors->edit->first('postal_code') }} </small>
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
                                @if ($errors->edit->first('cuit'))
                                    <small style="color: red">{{ $errors->edit->first('cuit') }} </small>
                                @endif
                            </div>

                            <label class="label">Tipo de cliente</label>
                            <div class="columns is-vcentered has-text-centered">
                                <div class="column">
                                    <div class="field">
                                        <label class="checkbox" for="subscribed_client">
                                            <input type="checkbox" name="subscribed_client" id="subscribed_client"
                                            @if ($client->subscribed_client)
                                                checked
                                            @endif
                                            >
                                            Cliente abonado
                                        </label>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="field">
                                        <label class="checkbox" for="end_client">
                                            <input type="checkbox" name="end_client" id="end_client"
                                            @if ($client->end_client)
                                                checked
                                            @endif
                                            >
                                            Cliente final
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('clients') }}">
                                            <button type="button" class="button is-info">
                                                <i class="bx bx-arrow-back"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <a href="#">
                                            <button type="button" class="button is-link is-danger">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-success">
                                            <i class="bx bx-save"></i>
                                        </button>
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
