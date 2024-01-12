@extends('components.layouts.nav')

@section('title')
    Inicio
@endsection

@section('main-content')

    @if (session('problem') != null)

        <div class="columns is-centered is-vcentered">
            <div class="column is-11">
                <div class="notification is-danger">
                    <p class="has-text-centered">{{ session('problem') }}</p>
                </div>
            </div>
        </div>

    @endif

@endsection