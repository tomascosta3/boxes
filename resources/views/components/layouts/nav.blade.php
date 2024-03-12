@extends('components.layouts.app')

@section('style')
    @parent

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .input:active, .input:focus, .is-active.input, .is-active.textarea, .is-focused.input, .is-focused.textarea, .select select.is-active, .select select.is-focused, .select select:active, .select select:focus, .textarea:active, .textarea:focus {
            border-color: var(--dark-mode-sidebar-color);
            box-shadow: 0 0 0 0.125em var(--dark-mode-body-color);
        }

        #searchInput {
            width: 70%;
            border: none;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #error-message {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            height: 25%;
            width: 25%;
            background-color: #d8d3e6;
        }

        #button-container {
            display: flex;
            justify-content: flex-end;
        }

        .message-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 75%;
        }

        .message-box {
            min-width: 40%;
            max-width: 90%;
            min-height: 50%;
        }

        #closeErrorButton {
            width: 40%;
            border-radius: 20px;
            height: 2rem;
        }

        #closeErrorButton:focus {
            border: none;
        }
    </style>

@endsection

@section('content')
<div class="main-page">
    <div class="columns full-height">
        {{-- Column for vertical nav bar --}}
        <div class="column is-2 px-5 full-height border-right vertical-navbar" id="vertical-nav-bar">

            {{-- Image logo --}}
            <img id="logo" class="solidocs-logo centered" src="{{ asset('images/logo-solidocs.svg') }}"
            data-light="{{ asset('images/logo-solidocs.svg') }}"
            data-dark="{{ asset('images/solidocs-white-logo.png') }}"
            alt="SolidoCS-Logo">

            <hr class="centered">

            <a href="{{ route('home') }}">
                <div class="box p-2 mb-4 invisible-box {{ Str::startsWith(request()->route()->getName(), 'home') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-home-alt-2 nav-icon"></i>
                        <span class="pl-3">Inicio</span>
                    </div>
                </div>
            </a>

            <a href="#">
                <div id="searchBox" class="box p-2 mb-4 invisible-box {{ Str::startsWith(request()->route()->getName(), 'users') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-search-alt-2 nav-icon"></i>
                        <span class="pl-3">Buscar orden</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('new-order') }}">
                <div class="box p-2 mb-4 invisible-box {{ Str::startsWith(request()->route()->getName(), 'new-order') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-file-blank nav-icon"></i>
                        <span class="pl-3">Nueva orden</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('repairs') }}">
                <div class="box p-2 mb-4 invisible-box {{ Str::startsWith(request()->route()->getName(), 'repairs') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-spreadsheet nav-icon"></i>
                        <span class="pl-3">Reparaciones</span>
                    </div>
                </div>
            </a>

            <hr class="centered">

            <a href="{{ route('clients') }}">
                <div class="box p-2 mb-4 invisible-box {{ Str::startsWith(request()->route()->getName(), 'clients') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-group nav-icon"></i>
                        <span class="pl-3">Clientes</span>
                    </div>
                </div>
            </a>

            <a href="{{ route('equipments') }}">
                <div class="box p-2 mb-4 invisible-box {{ Str::startsWith(request()->route()->getName(), 'equipments') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-desktop nav-icon"></i>
                        <span class="pl-3">Equipos</span>
                    </div>
                </div>
            </a>

            <a href="#">
                <div class="box p-2 mb-4 invisible-box {{ Str::startsWith(request()->route()->getName(), 'calendars') ? 'active' : '' }}">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-package nav-icon"></i>
                        <span class="pl-3">Stock</span>
                    </div>
                </div>
            </a>

            <hr class="centered">

            <div class="box p-2 mb-4 invisible-box">
                <div class="pl-5 has-text-centered is-flex is-align-items-center">
                    <i class="bx bx-help-circle nav-icon"></i>
                    <span class="pl-3">Ayuda</span>
                </div>
            </div>

            <hr class="centered">

            <a href="{{ route('logout') }}">
                <div class="box p-2 mb-4 invisible-box">
                    <div class="pl-5 has-text-centered is-flex is-align-items-center">
                        <i class="bx bx-log-out nav-icon"></i>
                        <span class="pl-3">Salir</span>
                    </div>
                </div>
            </a>

        </div>

        {{-- Column for horizontal nav bar and main content --}}
        <div class="column is-10 px-0 principal-page">
            <div class="full-width">
                <div class="top-header">
                    
                    {{-- Horizontal nav bar --}}
                    <div class="top-nav-bar">
                        <div class="columns is-vcentered">

                            {{-- Organization --}}
                            <div class="column pt-1 pl-5 is-flex">
                                <div class="navbar-item is-align-items-center">
                                    <ul>
                                        <li>
                                            <p class="is-size-5 has-text-weight-bold">EMPRESA</p>
                                        </li>
                                        <li>
                                            <p>CUIT: EMPRESA</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="separator"></div>

                            {{-- User --}}
                            <div class="column is-4 pt-1 is-flex is-justify-content-center">
                                <div class="navbar-item is-align-items-center">
                                    <div class="columns is-vcentered">
                                        <div class="column is-2">
                                            <i class="bx bx-user-circle nav-icon user-icon"></i>
                                        </div>
                                        <div class="column is-10">
                                            <p>¡Hola! {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                                            <p>Perfil:
                                                @switch(Auth::user()->access_level)
                                                    @case(1) Cliente @break
                                                    @case(2) Técnico @break
                                                    @case(3) Ventas @break
                                                    @case(4) Administrador @break
                                                    @default Usuario
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="separator"></div>
                            
                            {{-- Notifications --}}
                            <div class="column is-1 pt-1">
                                <div class="navbar-item is-align-items-center is-justify-content-center has-text-centered is-flex is-align-items-center">
                                    <i class="bx bx-bell notification-icon"></i>
                                </div>
                            </div>

                            <div class="separator"></div>

                            {{-- Theme toggle button --}}
                            <div class="column is-1 pt-1">
                                <div class="navbar-item is-align-items-center is-justify-content-center has-text-centered is-flex is-align-items-center">
                                    <button id="theme-toggle" class="hidden-button">
                                        <i class="bx bx-sun notification-icon"></i>
                                        <i class="bx bx-moon notification-icon" style="display: none"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="separator"></div>

                            {{-- Logout button --}}
                            <div class="column is-1 pt-1">
                                <a href="{{ route('logout') }}">
                                    <div class="navbar-item has-text-centered is-flex is-align-items-center">
                                        <i class="bx bx-log-out nav-icon"></i>
                                        <span class="pl-3">Salir</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Contact channels --}}
                    <div class="channels">
                        <div class="columns is-vcentered m-0 max-height-allowed">
                            <div class="column is-2 py-0">
                                <p>Horarios de atención al cliente</p>
                            </div>
                            <div class="column py-0">
                                <ul>
                                    <li>🕘 Lunes a Viernes: 9:00 - 18:00 hs</li>
                                    <li>🕘 Sábados: 9:00 - 13:00 hs</li>
                                </ul>
                            </div>
                    
                            <div class="column py-0 is-flex is-justify-content-center is-justify-content-space-evenly is-align-items-center"> 
                                
                                <div class="column py-0">
                                    <a href="https://soporte.solidcloud.com.ar/" target="_blank" rel="noopener noreferrer">
                                        <div class="channel-link">
                                            <img class="channel-logo pr-2" src="{{ asset('images/zammad-logo.svg') }}" alt="Zammad-logo">
                                            <p>Realizar ticket</p>
                                        </div>
                                    </a>
                                </div>
                    
                                <div class="column py-0">
                                        <a href="https://wa.me/+542324683467" target="_blank" rel="noopener noreferrer">
                                        <div class="channel-link">
                                            <img class="channel-logo pr-2" src="{{ asset('images/whatsapp-logo.svg') }}" alt="WhatsApp-logo">
                                            <p>Mesa de ayuda</p>
                                        </div>
                                    </a>
                                </div>
                    
                                <div class="column py-0">
                                    <a href="https://wa.me/+542324696334" target="_blank" rel="noopener noreferrer">
                                        <div class="channel-link">
                                            <img class="channel-logo pr-5" src="{{ asset('images/whatsapp-logo.svg') }}" alt="WhatsApp-logo">
                                            <p>Ventas</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- Content --}}
                @yield('main-content')

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Define the logo source for dark mode --}}
    <script>
        var logoSrc = "{{ asset('images/solidocs-white-logo.png') }}"
    </script>

    {{-- Include the navbar functionality --}}
    <script src="{{ asset('js/components/layouts/navbar/navbar.js') }}"></script>
@endsection