@extends('components.layouts.nav')

@section('title')
    Reparaciones
@endsection

@section('main-content')
<div class="hero">
    <div class="hero-body is-flex justify-content-center">
        <div class="container">

            <div class="columns is-vcentered is-centered">

                <div class="column is-9">
                    <div class="box secondary-background">
                        <div class="columns is-vcentered is-centered">
                            <div class="column p-0">
                                <p class="has-text-centered is-size-3">
                                    <strong>
                                        Reparaciones
                                    </strong>
                                </p>
                            </div>
                        </div>
            
                        {{-- Search form --}}
                        <div class="box is-shadowless p-3 mb-3 search">
                            <form action="{{ route('repairs') }}" method="get">
                                @csrf
                                <div class="columns is-vcentered is-centered">
                                    <div class="column is-6">
                                        <div class="field has-addons">
                                            <div class="control has-icons-left is-expanded">
                                                <input class="input" type="text" name="search" placeholder="Buscar..." value="{{ session('filter') }}">
                                                <span class="icon is-small is-left">
                                                    <i class="bx bx-search"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-2">
                                        <div class="field">
                                            <div class="control">
                                                <div class="select">
                                                    <select name="search_option" id="search_option">
                                                        <option value="name"
                                                        @if (session('search_option') == "name")
                                                            selected
                                                        @endif
                                                        >Nombre</option>
                                                        <option value="phone_number"
                                                        @if (session('search_option') == "phone_number")
                                                            selected
                                                        @endif
                                                        >Teléfono</option>
                                                        <option value="email"
                                                        @if (session('search_option') == "email")
                                                            selected
                                                        @endif
                                                        >Correo</option>
                                                        <option value="company"
                                                        @if (session('search_option') == "company")
                                                            selected
                                                        @endif
                                                        >Empresa</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="column is-1">
                                        <button class="button is-link is-pulled-right" type="submit">
                                            <span class="icon">
                                                <i class="bx bx-search-alt-2"></i>
                                            </span>
                                        </button>
                                    </div>
                                    <div class="column is-1">
                                        <a href="#">
                                            <button class="button is-success is-pulled-right" type="button">
                                                <span class="icon">
                                                    <i class="bx bx-plus"></i>
                                                </span>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
            
                        <div class="box p-2 mb-2 is-shadowless categories">
                            <div class="columns is-vcentered">
                                <div class="column is-2">
                                    <p>Orden</p>
                                </div>
                                <div class="column is-2">
                                    <p>Tipo de equipo</p>
                                </div>
                                <div class="column is-3">
                                    <p>Cliente</p>
                                </div>
                                <div class="column is-2">
                                    <p>Estado</p>
                                </div>
                                <div class="column">
                                    <p>Técnico</p>
                                </div>
                            </div>
                        </div>

                        @if ($repairs->isEmpty())
                        <div class="box p-1 has-background-white is-shadowless">
                            <div class="columns is-vcentered">
                                <div class="column">
                                    <p class="has-text-centered">No hay reparaciones</p>
                                </div>
                            </div>
                        </div>
                        @endif
            
                        {{-- Repair list --}}
                        @foreach ($repairs as $repair)
                        <a href="#">
                            <div class="box p-1 mb-2 is-shadowless list-item">
                                <div class="columns is-vcentered">
                                    <div class="column is-2">
                                        <p class="is-clipped">{{ $repair->order->number }}</p>
                                    </div>
                                    <div class="column is-2">
                                        <p>{{ $repair->order->equipment->type->type }}</p>
                                    </div>
                                    <div class="column is-3">
                                        <p class="is-clipped">{{ $repair->order->client->last_name . ' ' . $repair->order->client->first_name }}</p>
                                    </div>
                                    <div class="column is-2">
                                        <p class="is-clipped">
                                            {{ $repair->get_spanish_status() }}
                                        </p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">
                                            @if ($repair->has_technician())
                                                {{ $repair->technician->last_name . ' ' . $repair->technician->first_name }}
                                            @else
                                                Ninguno
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>   

@endsection