@extends('components.layouts.nav')

@section('title')
    Clientes
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
                                        Clientes
                                    </strong>
                                </p>
                            </div>
                        </div>
            
                        {{-- Search form --}}
                        <div class="box is-shadowless p-3 mb-3 search">
                            <form action="{{ route('clients') }}" method="get">
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
                                        <a href="{{ route('clients.create') }}">
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
                                <div class="column is-3">
                                    <p>Nombre</p>
                                </div>
                                <div class="column is-2">
                                    <p>Teléfono</p>
                                </div>
                                <div class="column">
                                    <p>Correo electrónico</p>
                                </div>
                                <div class="column">
                                    <p>Tipo de cliente</p>
                                </div>
                            </div>
                        </div>

                        @if ($clients->isEmpty())
                        <div class="box p-1 has-background-white is-shadowless">
                            <div class="columns is-vcentered">
                                <div class="column">
                                    <p class="has-text-centered">No hay clientes cargados</p>
                                </div>
                            </div>
                        </div>
                        @endif
            
                        {{-- Clients list --}}
                        @foreach ($clients as $client)
                        <a href="{{ route('clients.show', ['id' => $client->id]) }}">
                            <div class="box p-1 mb-2 is-shadowless list-item">
                                <div class="columns is-vcentered">
                                    <div class="column is-3">
                                        <p class="is-clipped">{{ "{$client->last_name} {$client->first_name}"}}</p>
                                    </div>
                                    <div class="column is-2">
                                        <p class="is-clipped">{{ $client->phone_number }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">
                                            @if ($client->email)
                                                {{ $client->email }}
                                            @else
                                                No especificado
                                            @endif
                                        </p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">
                                            @if ($client->subscribed_client)
                                                Cliente abonado
                                            @else
                                                Cliente final
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