@extends('components.layouts.nav')

@section('title')
    Nueva orden
@endsection

@section('style')
<style>
    /* Personaliza el estilo del box */
    .equipment-box {
        border: 1px solid var(--dark-mode-sidebar-color);
    }

    .equipment-box .in-border {
        position: absolute;
        top: -12px;
    }

    .equipment-box .equipment-title {
        background-color: #fff;
        padding: 0 1em;
        margin-right: 12em;
    }

    .equipment-button {
        border: 1px solid var(--dark-mode-sidebar-color);
    }
</style>
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
                        <form action="#" id="new-order-form" method="post">
                            @csrf

                            <label class="label" for="client">Cliente</label>
                            <div class="field is-grouped">
                                <div class="control is-expanded">
                                    <div class="control has-icons-left">
                                        <div class="select is-fullwidth">
                                            <select name="client" id="client-dropdown">
                                                @if (isset($clients))
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}">{{ $client->last_name . ' ' . $client->first_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="icon is-small is-left">
                                                <i class="bx bx-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="control">
                                    <button class="button is-link" id="addClientButton" type="button">
                                        <i class="bx bx-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @if ($errors->create->first('client'))
                                <small style="color: red">{{ $errors->create->first('client') }} </small>
                            @endif

                            <div class="container">
                                <div class="box equipment-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                    <div class="in-border">
                                        <div class="columns is-flex is-justify-content-space-between">
                                            <div class="column">
                                                <p class="equipment-title">EQUIPO</p>
                                            </div>
                                            <div class="column">
                                                <button class="button equipment-button is-small" id="change-button" type="button">
                                                    Cambiar
                                                </button>
                                            </div>
                                            <div class="column" id="create-button-column">
                                                <button class="button equipment-button is-small" id="create-button" type="button">
                                                    Crear
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p id="type"><strong>TIPO:</strong></p>
                                    <p id="brand"><strong>MARCA:</strong></p>
                                    <p id="model"><strong>MODELO:</strong></p>
                                    <p id="serial-number"><strong>N/S:</strong></p>
                                </div>
                            </div>

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

                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('equipments') }}">
                                            <button type="button" class="button is-link is-light">Volver</button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button class="button" type="button" id="addPhotoModal">Agregar fotos</button>
                                    </div>
                                    <div class="control">
                                        <button type="submit" class="button is-link">Crear equipo</button>
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
    <script src="{{ asset('js/orders/equipments.js') }}"></script>
@endsection