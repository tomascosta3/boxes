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

    <!-- Agrega un botón con un ID, por ejemplo, 'agregar-foto-btn' -->
    <button id="agregar-foto-btn">Agregar Camara</button>

    <!-- Button to capture a photo -->
    <button id="capture-btn">Capture Photo</button>

    <!-- Canvas element to display captured photos -->
    <canvas id="photo-canvas" width="640" height="480"></canvas>

    <!-- Input field to store the base64-encoded image data -->
    <input type="hidden" id="photo-input" name="photo">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('camera-feed');
            const canvas = document.getElementById('photo-canvas');
            const photoInput = document.getElementById('photo-input');
            const captureBtn = document.getElementById('capture-btn');
            const cameraBtn = document.getElementById('camera-btn');

            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(function(stream) {
                        video.srcObject = stream;
                    })
                    .catch(function(error) {
                        console.error('Error accessing camera:', error.name, error.message);
                    });
            } else {
                console.error('getUserMedia is not supported on this browser');
            }

            cameraBtn.addEventListener('click', function() {
                video.autoplay = true;
            });

            captureBtn.addEventListener('click', function() {
                if (video.srcObject) {
                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                    const imageData = canvas.toDataURL('image/png');
                    photoInput.value = imageData;
                } else {
                    console.error('Camera not available or permission denied');
                }
            });

            // Manejador de clic en el botón
            document.getElementById('agregar-foto-btn').addEventListener('click', function() {
                // Crear el elemento de video
                var video = document.createElement('video');
                video.id = 'camera-feed';
                video.width = 640;
                video.height = 480;

                // Agregar el atributo autoplay
                video.setAttribute('autoplay', '');

                // Agregar el video al cuerpo del documento (o a otro elemento según tu estructura)
                document.body.appendChild(video);

                // Obtener el stream y asignarlo al video
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(function(stream) {
                            video.srcObject = stream;
                        })
                        .catch(function(error) {
                            console.error('Error accessing camera:', error.name, error.message);
                        });
                } else {
                    console.error('getUserMedia is not supported on this browser');
                }
            });
        });

    </script>

@endsection