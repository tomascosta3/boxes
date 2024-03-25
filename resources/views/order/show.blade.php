@extends('components.layouts.nav')

@section('title')
    Nueva orden
@endsection

@section('style')
    @parent

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>

    <link rel="stylesheet" href="{{ asset('css/equipments/photo_modal.css') }}">

    <link rel="stylesheet" href="{{ asset('css/orders/equipment.css') }}">
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
                        <form action="{{ route('new-order.store') }}" id="new-order-form" method="post">
                            @csrf

                            <div class="container">
                                <div class="box equipment-box mb-4 is-shadowless" id="equipment-box">
                                    <div class="in-border">
                                        <div class="columns is-flex is-justify-content-space-between">
                                            <div class="column">
                                                <p class="equipment-title">CLIENTE</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p id="last-name"><strong>Apellido: </strong>{{ $order->client->last_name }}</p>
                                    <p id="first-name"><strong>Nombre: </strong>{{ $order->client->first_name }}</p>
                                    <p id="phone-number"><strong>Teléfono: </strong>{{ $order->client->phone_number }}</p>
                                    <p id="email"><strong>Correo: </strong>{{ $order->client->email }}</p>
                                </div>
                            </div>


                            <div class="container">
                                <div class="box equipment-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                    <div class="in-border">
                                        <div class="columns is-flex is-justify-content-space-between">
                                            <div class="column">
                                                <p class="equipment-title">EQUIPO</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p id="type"><strong>Tipo: </strong>{{ $order->equipment->type->type }}</p>
                                    <p id="brand"><strong>Marca: </strong>{{ $order->equipment->brand->brand }}</p>
                                    <p id="model"><strong>Modelo: </strong>{{ $order->equipment->model->model }}</p>
                                    <p id="serial-number"><strong>N/S: </strong>{{ $order->equipment->serial_number }}</p>
                                </div>
                            </div>

                            <div class="container">
                                <div class="box equipment-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                    <div class="in-border">
                                        <div class="columns is-flex is-justify-content-space-between">
                                            <div class="column">
                                                <p class="equipment-title">ACCESORIOS</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p id="accessories">{{ $order->accessories }}</p>
                                </div>
                            </div>

                            <div class="container">
                                <div class="box equipment-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                    <div class="in-border">
                                        <div class="columns is-flex is-justify-content-space-between">
                                            <div class="column">
                                                <p class="equipment-title">FALLA DEL EQUIPO</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <p id="failure">{{ $order->failure }}</p>
                                </div>
                            </div>

                            <div class="level-item has-text-centered">
                                <div class="field is-grouped pt-3">
                                    <div class="control">
                                        <a href="{{ route('new-order') }}">
                                            <button type="button" class="button is-link is-light">Volver</button>
                                        </a>
                                    </div>
                                    <div class="control">
                                        <button class="button is-primary" type="button" id="printButton">
                                        <span class="icon is-small">
                                            <i class="bx bx-printer"></i>
                                        </span>
                                        <span>Imprimir</span>
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

@section('scripts')
    @parent

    <script src="{{ asset('js/orders/print.js') }}"></script>
@endsection