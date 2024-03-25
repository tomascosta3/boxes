@extends('components.layouts.app')

@section('title')
    Orden de reparación {{ $order->number }}
@endsection

@section('style')
    @parent

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 0.7rem;
            margin: 0;
            padding: 0;
            background-color: white;
        }

        .container {
            width: 100%;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        
        .center-content {
            display: flex;
            justify-content: center;
        }

        .content-box {
            border: 1px solid #ccc;
            border-radius: 7px;
        }
    </style>
@endsection

@section('content')
<div class="columns">
    <div class="column is-5">

        <div class="container pb-0 pt-1 px-2">
            <p class="has-text-centered"><strong>ORDEN DE REPARACIÓN #{{ $order->number }}</strong></p>
            <div class="ml-1">
                <p>BIOS.INK</p>
                <p>Calle 26 N° 16, Mercedes, CP. 6600</p>
                <p>Tel: 2324-683467</p>
                <p>Fecha de ingreso: {{ $order->formatted_creation_date_time() }}</p>
                <p>Equipo recibido por: {{ $order->technician->last_name . ' ' . $order->technician->first_name }}</p>
            </div>
            <div class="content-box mb-2 py-1">
                <p class="has-text-centered"><strong>CLIENTE</strong></p>
                <p class="ml-3"><strong>Apellido: </strong>{{ $order->client->last_name }}</p>
                <p class="ml-3"><strong>Nombre: </strong>{{ $order->client->first_name }}</p>
                <p class="ml-3"><strong>Correo: </strong>{{ $order->client->email }}</p>
                <p class="ml-3"><strong>Teléfono: </strong>{{ $order->client->phone_number }}</p>
            </div>
        
            <div class="content-box mb-2 py-1">
                <p class="has-text-centered"><strong>EQUIPO</strong></p>
                <p class="ml-3"><strong>Tipo: </strong>{{ $order->equipment->type->type }}</p>
                <p class="ml-3"><strong>Marca: </strong>{{ $order->equipment->brand->brand }}</p>
                <p class="ml-3"><strong>Modelo: </strong>{{ $order->equipment->model->model }}</p>
                <p class="ml-3"><strong>N/S:</strong> {{ $order->equipment->serial_number }}</p>
            </div>
        
            <div class="content-box mb-2 py-1">
                <p class="has-text-centered"><strong>ACCESORIOS</strong></p>
                <p class="ml-3">{{ $order->accessories }}</p>
            </div>
        
            <div class="content-box py-1">
                <p class="has-text-centered"><strong>FALLA DEL EQUIPO</strong></p>
                <p class="ml-3">{{ $order->failure }}</p>
            </div>

            <p class="ml-1">Toda revisión cuenta con un costo fijo de $2500</p>
        
            <div class="columns mb-0">
                <div class="column is-10 is-offset-1">
                    <hr class="mb-0 mt-5">
                    <p class="has-text-centered">FIRMA</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection