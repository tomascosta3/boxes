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
    
    <!-- Video element to display the camera feed -->
    <video id="camera-feed" width="640" height="480" autoplay></video>

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

            captureBtn.addEventListener('click', function() {
                if (video.srcObject) {
                    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                    const imageData = canvas.toDataURL('image/png');
                    photoInput.value = imageData;
                } else {
                    console.error('Camera not available or permission denied');
                }
            });
        });

    </script>

@endsection