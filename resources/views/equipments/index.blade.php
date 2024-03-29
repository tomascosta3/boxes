@extends('components.layouts.nav')

@section('title')
    Equipos
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

            <div class="columns is-vcentered is-centered">

                <div class="column is-9">
                    <div class="box secondary-background">
                        <div class="columns is-vcentered is-centered">
                            <div class="column p-0">
                                <p class="has-text-centered is-size-3">
                                    <strong>
                                        Equipos
                                    </strong>
                                </p>
                            </div>
                        </div>
            
                        {{-- Search form --}}
                        <div class="box is-shadowless p-3 mb-3 search">
                            <form action="#" method="get">
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
                                                        <option value="type"
                                                        @if (session('search_option') == "type")
                                                            selected
                                                        @endif
                                                        >Tipo</option>
                                                        <option value="brand"
                                                        @if (session('search_option') == "brand")
                                                            selected
                                                        @endif
                                                        >Marca</option>
                                                        <option value="model"
                                                        @if (session('search_option') == "model")
                                                            selected
                                                        @endif
                                                        >Modelo</option>
                                                        <option value="serial_number"
                                                        @if (session('search_option') == "serial_number")
                                                            selected
                                                        @endif
                                                        >Núm. Serie</option>
                                                        <option value="client"
                                                        @if (session('search_option') == "client")
                                                            selected
                                                        @endif
                                                        >Cliente</option>
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
                                        <a href="{{ route('equipments.create') }}">
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
                                <div class="column">
                                    <p>Tipo</p>
                                </div>
                                <div class="column">
                                    <p>Marca</p>
                                </div>
                                <div class="column">
                                    <p>Modelo</p>
                                </div>
                                <div class="column">
                                    <p>Núm. Serie</p>
                                </div>
                                <div class="column">
                                    <p>Cliente</p>
                                </div>
                            </div>
                        </div>

                        @if ($equipments->isEmpty())
                        <div class="box p-1 has-background-white is-shadowless">
                            <div class="columns is-vcentered">
                                <div class="column">
                                    <p class="has-text-centered">No hay equipos cargados</p>
                                </div>
                            </div>
                        </div>
                        @endif
            
                        {{-- Equipment list --}}
                        @foreach ($equipments as $equipment)
                        <a href="{{ route('equipments.show', ['id' => $equipment->id]) }}">
                            <div class="box p-1 mb-2 is-shadowless list-item">
                                <div class="columns is-vcentered">
                                    <div class="column">
                                        <p class="is-clipped">{{ $equipment->type->type }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">{{ $equipment->brand->brand }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">{{ $equipment->model->model }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">{{ $equipment->serial_number }}</p>
                                    </div>
                                    <div class="column">
                                        <p class="is-clipped">{{ "{$equipment->client->last_name} {$equipment->client->first_name}" }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach

                        {{ $equipments->links() }}
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>   

@endsection