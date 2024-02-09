@extends('components.layouts.nav')

@section('title')
    Nuevo equipo
@endsection

@section('style')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('css/equipments/photo_modal.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
@endsection

@section('main-content')

@include('equipments.modals.create_type')
@include('equipments.modals.create_brand')
@include('equipments.modals.create_model')
@include('equipments.modals.photos')

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
                        <form action="{{ route('equipments.store') }}" id="equipment-form" method="post">
                            @csrf

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
                            </div>
                            @if ($errors->create->first('client'))
                                <small style="color: red">{{ $errors->create->first('client') }} </small>
                            @endif

                            <div class="field">
                                <label class="label" for="observations">Observaciones:</label>
                                <div class="control">
                                    <textarea class="textarea" name="observations"></textarea>
                                </div>
                                <small>Este campo no es obligatorio</small>
                                @if ($errors->create->first('observations'))
                                    <br>
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
    <script src="{{ asset('js/equipments/type.js') }}"></script>
    <script src="{{ asset('js/equipments/brand.js') }}"></script>
    <script src="{{ asset('js/equipments/model.js') }}"></script>
    <script src="{{ asset('js/equipments/serial_number.js') }}"></script>
    <script src="{{ asset('js/equipments/photos.js') }}"></script>
@endsection