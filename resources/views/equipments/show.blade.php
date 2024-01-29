@extends('components.layouts.nav')

@section('title')
    Equipo
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('css/equipments/equipment.css') }}">
@endsection

@section('main-content')

{{-- Delete confirmation modal --}}
@include('equipments.modals.delete')

@include('equipments.modals.create_type')
@include('equipments.modals.create_brand')
@include('equipments.modals.create_model')
@include('equipments.modals.photos')

<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">

                {{-- Error or success message --}}
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
                        <form action="{{ route('equipments.edit', ['id' => $equipment->id]) }}" method="post">
                            @csrf

                            <label class="label" for="type">Tipo</label>
                            <div class="field is-grouped">
                                <div class="control is-expanded">
                                    <div class="control has-icons-left">
                                        <div class="select is-fullwidth">
                                            <select name="type" id="type-dropdown">
                                                @if (isset($types))
                                                    @foreach ($types as $type)
                                                        <option value="{{ $type->id }}"
                                                            @if ($type->id == $equipment->type_id)
                                                                selected
                                                            @endif
                                                        >{{ $type->type }}</option>
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
                            @if ($errors->edit->first('type'))
                                <small style="color: red">{{ $errors->edit->first('type') }} </small>
                            @endif

                            <label class="label" for="brand">Marca</label>
                            <div class="field is-grouped">
                                <div class="control is-expanded">
                                    <div class="control has-icons-left">
                                        <div class="select is-fullwidth">
                                            <select name="brand" id="brand-dropdown">
                                                @if (isset($brands))
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}"
                                                            @if ($brand->id == $equipment->brand_id)
                                                                selected
                                                            @endif
                                                        >{{ $brand->brand }}</option>
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
                            @if ($errors->edit->first('brand'))
                                <small style="color: red">{{ $errors->edit->first('brand') }} </small>
                            @endif

                            <label class="label" for="model">Modelo</label>
                            <div class="field is-grouped">
                                <div class="control is-expanded">
                                    <div class="control has-icons-left">
                                        <div class="select is-fullwidth">
                                            <select name="model" id="model-dropdown">
                                                @if (isset($models))
                                                    @foreach ($models as $model)
                                                        <option value="{{ $model->id }}"
                                                            @if ($model->id == $equipment->model_id)
                                                                selected
                                                            @endif    
                                                        >{{ $model->model }}</option>
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
                            @if ($errors->edit->first('model'))
                                <small class="mt-0" style="color: red">{{ $errors->edit->first('model') }} </small>
                            @endif

                            <label class="label" for="serial_number">Número de serie</label>
                            <div class="field is-grouped">
                                <div class="control is-expanded">
                                    <div class="control has-icons-left has-icons-right">
                                        <div class="is-fullwidth">
                                            <input class="input" type="text" name="serial_number" id="serial_number" placeholder="Ingrese aquí el número de serie o genere uno" value="{{ $equipment->serial_number }}">
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
                            @if ($errors->edit->first('serial_number'))
                                <small style="color: red">{{ $errors->edit->first('serial_number') }} </small>
                            @endif

                            <label class="label" for="client">Cliente</label>
                            <div class="field is-grouped">
                                <div class="control is-expanded">
                                    <div class="control has-icons-left">
                                        <div class="select is-fullwidth">
                                            <select name="client" id="client-dropdown">
                                                @if (isset($clients))
                                                    @foreach ($clients as $client)
                                                        <option value="{{ $client->id }}"
                                                            @if ($client->id == $equipment->client_id)
                                                                selected
                                                            @endif    
                                                        >{{ $client->last_name . ' ' . $client->first_name }}</option>
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
                            @if ($errors->edit->first('client'))
                                <small style="color: red">{{ $errors->edit->first('client') }} </small>
                            @endif

                            <div class="field">
                                <label class="label" for="observations">Observaciones:</label>
                                <div class="control">
                                    <textarea class="textarea" name="observations">{{ $equipment->observations }}</textarea>
                                </div>
                                @if ($errors->edit->first('observations'))
                                    <small style="color: red">{{ $errors->edit->first('observations') }} </small>
                                @endif
                            </div>
    
                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('equipments') }}">
                                            <button type="button" class="button is-info">
                                                <i class="bx bx-arrow-back"></i>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button type="button" class="button is-danger" id="openDeleteConfirmationModal">
                                            <i class="bx bx-trash"></i>
                                        </button>
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

                @if ($equipment->active_images() && $equipment->active_images()->count() > 0)
                <div class="column photos-column no-scrollbar">
                    @foreach ($equipment->active_images() as $image)
                        <img src="{{ asset($image->path) }}" alt="Equipment Image">
                    @endforeach
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection

@section('current-view')
    <div id="current-view" data-view="show"></div>
@endsection

@section('scripts')
    @parent
    <script>
        var equipmentModelID = "{{ $equipment->model_id }}";
    </script>
    <script src="{{ asset('js/equipments/delete_modal.js') }}"></script>
    <script src="{{ asset('js/equipments/type.js') }}"></script>
    <script src="{{ asset('js/equipments/brand.js') }}"></script>
    <script src="{{ asset('js/equipments/model.js') }}"></script>
    <script src="{{ asset('js/equipments/serial_number.js') }}"></script>
@endsection