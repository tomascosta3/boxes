@extends('components.layouts.nav')

@section('title')
    Reparación
@endsection

@section('style')
    <style>
        .text-username {
            display: inline;
            font-size: 0.8rem;
        }

        .text-date {
            display: inline;
            font-size: 0.8rem;
        }

        .item-box {
            border: 1px solid #b5b5b5;
        }

        .item-box .in-border {
            position: absolute;
            top: -12px;
        }

        .item-box .item-title {
            background-color: #fff;
            padding: 0 1em;
            margin-right: 12em;
            border-radius: 10px;
            border: 1px solid #b5b5b5;
        }

        .header-box {
            background-color: var(--dark-mode-sidebar-color);
        }

        .header-box p {
            color: var(--dark-mode-text-color);
        }

        .send-button {
            width: 50px;
        }
    </style>
@endsection

@section('main-content')

<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            {{-- Error or success message with document view --}}
            @if (session('success') != null)
                <div class="columns is-centered is-vcentered">
                    <div class="column is-6">
                        <div class="notification is-success">
                            <p class="has-text-centered">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('problem') != null)
                <div class="columns is-centered is-vcentered">
                    <div class="column is-6">
                        <div class="notification is-danger">
                            <p class="has-text-centered">{{ session('problem') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="columns is-vcentered is-centered">
                <div class="column is-12">    

                    <div class="box has-background-light">
                        <form action="#" method="post">
                            @csrf

                            <div class="box is-shadowless mb-3 p-2 header-box">
                                <div class="columns">
                                    <div class="column has">
                                        <p class="has-text-centered">N° de orden: {{ $repair->order->number }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="has-text-centered">Fecha de ingreso: {{ $repair->order->created_at }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="has-text-centered">Técnico asignado: 
                                            @if ($repair->technician_id == null)
                                                Ninguno
                                            @else
                                                {{ $repair->technician->last_name . ' ' . $repair->technician->first_name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <div class="container">
                                        <div class="box item-box mt-5 mb-4 is-shadowless" id="client-box">
                                            <div class="in-border">
                                                <div class="columns is-flex is-justify-content-space-between">
                                                    <div class="column">
                                                        <p class="item-title">CLIENTE</p>
                                                    </div>
                                                </div>
                                            </div>
                                                    
                                            <p id="last-name"><strong>Apellido: </strong>{{ $repair->order->client->last_name }}</p>
                                            <p id="first-name"><strong>Nombre: </strong>{{ $repair->order->client->first_name }}</p>
                                            <p id="phone-number"><strong>Teléfono: </strong>{{ $repair->order->client->phone_number }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="container">
                                        <div class="box item-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                            <div class="in-border">
                                                <div class="columns is-flex is-justify-content-space-between">
                                                    <div class="column">
                                                        <p class="item-title">EQUIPO</p>
                                                    </div>
                                                </div>
                                            </div>
        
                                            <p id="type"><strong>Tipo: </strong>{{ $repair->order->equipment->type->type }}</p>
                                            <p id="brand"><strong>Marca: </strong>{{ $repair->order->equipment->brand->brand }}</p>
                                            <p id="model"><strong>Modelo: </strong>{{ $repair->order->equipment->model->model }}</p>
                                            <p id="serial-number"><strong>N/S: </strong>{{ $repair->order->equipment->serial_number }}</p>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="box item-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                            <div class="in-border">
                                                <div class="columns is-flex is-justify-content-space-between">
                                                    <div class="column">
                                                        <p class="item-title">ACCESORIOS</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <p>{{ $repair->order->accessories }}</p>
                                        </div>
                                    </div>

                                    <div class="container">
                                        <div class="box item-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                            <div class="in-border">
                                                <div class="columns is-flex is-justify-content-space-between">
                                                    <div class="column">
                                                        <p class="item-title">FALLA DEL EQUIPO</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <p>{{ $repair->order->failure }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="container">
                                        <div class="box item-box mt-5 mb-4 is-shadowless" id="equipment-box">
                                            <div class="in-border">
                                                <div class="columns is-flex is-justify-content-space-between">
                                                    <div class="column">
                                                        <p class="item-title">BITÁCORA</p>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="box mb-1 is-shadowless messages">
                                                @foreach ($repair->binnacles as $binnacle)
                                                    @foreach ($binnacle->messages as $message)
                                                    <div class="box p-2 is-shadowless message">
                                                        <p class="text-message">aaaaaaaaaaaaaa</p>
                                                        <p class="text-username">aaaaaaaa</p>
                                                        <p class="text-date">aaaaa</p>
                                                    </div>
                                                    @endforeach
                                                @endforeach
                                            </div>
                                            <div class="new-message">
                                                <textarea name="new-message" id="new-message" class="textarea"></textarea>
                                            </div>
                                            <div class="message-buttons is-flex is-justify-content-flex-end mt-2">
                                                <button class="button send-button">Enviar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="columns">
                                aca va información de entrega, cambio de estado, cambio de técnico, informe técnico
                                en caso que se tenga que brindar al cliente
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
@endsection
