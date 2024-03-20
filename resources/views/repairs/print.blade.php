@extends('components.layouts.app')

@section('title')
    Reparación
@endsection

@section('style')
    @parent

    <style>
        body {
            font-family: Arial, sans-serif;
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
<div class="container">
    <div class="columns is-vcentered">
        <div class="column">
            <h5 class="title is-5">Informe de la Reparación #{{ $repair->order->number }}</h5>
        </div>
        <div class="column has-text-right">
            <p class="mb-0">Fecha: {{ now()->format('d/m/Y H:i') }}hs</p>
        </div>
    </div>
    <div class="columns mb-0">
        <div class="column is-6">
            <div class="content-box py-1">
                <p class="has-text-centered"><strong>CLIENTE</strong></p>
                <p class="ml-3"><strong>Apellido: </strong>{{ $repair->order->client->last_name }}</p>
                <p class="ml-3"><strong>Nombre: </strong>{{ $repair->order->client->first_name }}</p>
                <p class="ml-3"><strong>Correo: </strong>{{ $repair->order->client->email }}</p>
                <p class="ml-3"><strong>Teléfono: </strong>{{ $repair->order->client->phone_number }}</p>
            </div>
        </div>
        <div class="column is-6">
            <div class="content-box py-1">
                <p class="has-text-centered"><strong>EQUIPO</strong></p>
                <p class="ml-3"><strong>Tipo: </strong>{{ $repair->order->equipment->type->type }}</p>
                <p class="ml-3"><strong>Marca: </strong>{{ $repair->order->equipment->brand->brand }}</p>
                <p class="ml-3"><strong>Modelo: </strong>{{ $repair->order->equipment->model->model }}</p>
                <p class="ml-3"><strong>N/S:</strong> {{ $repair->order->equipment->serial_number }}</p>
            </div>
        </div>
    </div>

    <div class="content-box mb-4 py-1">
        <p class="has-text-centered"><strong>FALLA DEL EQUIPO</strong></p>
        <p class="ml-3">{{ $repair->order->failure }}</p>
    </div>
    
    <div class="content-box mb-4 py-1">
        <p class="has-text-centered"><strong>INFORME TÉCNICO</strong></p>
        <p class="ml-3">{{ $repair->conclusion }}</p>
    </div>

    <div class="columns">
        <div class="column">
            <hr class="mb-0 mt-6">
            <p class="has-text-centered">Firma y aclaración del técnico</p>
        </div>
        <div class="column">
            <hr class="mb-0 mt-6">
            <p class="has-text-centered">Firma y aclaración del cliente</p>
        </div>
    </div>
</div>
@endsection