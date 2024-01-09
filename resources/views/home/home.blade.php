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

    <h1>Webcam Photo Capture</h1>
    
    <!-- Botón para agregar foto -->
    <button id="add-photo-btn">Agregar Foto</button>

    <!-- Video element para mostrar la transmisión de la cámara -->
    <video id="camera-feed" width="640" height="480"></video>

    <!-- Botón para capturar una foto -->
    <button id="capture-btn">Capturar Foto</button>

    <!-- Elemento de lienzo para mostrar las fotos capturadas -->
    <canvas id="photo-canvas" width="640" height="480"></canvas>

    <!-- Campo de entrada para almacenar los datos de la imagen codificados en base64 -->
    <input type="hidden" id="photo-input" name="photo">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('camera-feed');
            const canvas = document.getElementById('photo-canvas');
            const photoInput = document.getElementById('photo-input');
            const captureBtn = document.getElementById('capture-btn');
            const addPhotoBtn = document.getElementById('add-photo-btn');
        
            // Función para iniciar la transmisión de la cámara
            function startCamera() {
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(function(stream) {
                            video.srcObject = stream;
                        })
                        .catch(function(error) {
                            console.error('Error accediendo a la cámara:', error.name, error.message);
                        });
                } else {
                    console.error('getUserMedia no es compatible en este navegador');
                }
            }
        
            // Agregar un evento de clic al botón "agregar foto" para iniciar la transmisión de la cámara
            addPhotoBtn.addEventListener('click', function() {
                startCamera();
            });
        
            // Agregar un evento de clic al botón "capturar foto"
            captureBtn.addEventListener('click', function() {
                if (video.srcObject) {
                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                    const imageData = canvas.toDataURL('image/png');
                    photoInput.value = imageData;
                } else {
                    console.error('Cámara no disponible o permiso denegado');
                }
            });
        });
    </script>

@endsection