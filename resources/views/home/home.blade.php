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

    <div class="modal" id="photosModal">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title has-text-centered">Agregar fotos al equipo</p>
                <button class="delete" aria-label="close" id="closePhotosModal"></button>
            </header>
            <section class="modal-card-body">
                <!-- Video element to display the camera feed -->
                <video id="camera-feed" width="300" height="240" autoplay></video>

                <!-- Button to capture a photo -->
                <button id="capture-btn">Capture Photo</button>

                <!-- Canvas element to display captured photos -->
                <canvas id="photo-canvas" width="300" height="240"></canvas>

                <!-- Input field to store the base64-encoded image data -->
                <input type="hidden" id="photo-input" name="photo">
            </section>
            <footer class="modal-card-foot is-justify-content-center">
                <button class="button" id="cancelPhotoModal">Cancelar</button>
            </footer>
        </div>
    </div>

    <button class="button" type="button" id="addPhotoModal">Agregar fotos</button>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

        // Event listener for the button that opens the modal
        document.getElementById('addPhotoModal').addEventListener('click', function() {
            document.getElementById('photosModal').classList.add('is-active');
            cameraOn();
        });

        // Event listener for the button that closes the modal
        document.getElementById('closePhotosModal').addEventListener('click', function() {
            document.getElementById('photosModal').classList.remove('is-active');
            cameraOff();
        });

        // Event listener for the button that cancels and closes the modal
        document.getElementById('cancelPhotoModal').addEventListener('click', function() {
            document.getElementById('photosModal').classList.remove('is-active');
            cameraOff();
        });

        const video = document.getElementById('camera-feed');
        const canvas = document.getElementById('photo-canvas');
        const photoInput = document.getElementById('photo-input');
        const captureBtn = document.getElementById('capture-btn');
        var isPlaying = !!video.srcObject;

        // Event listener for the button that captures a photo
        captureBtn.addEventListener('click', function() {
            if (video.srcObject) {
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                const imageData = canvas.toDataURL('image/png');
                photoInput.value = imageData;
            } else {
                console.error('Camera not available or permission denied');
            }
        });

        // Function to turn on the camera
        function cameraOn() {
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices
                    .getUserMedia({
                        video: true
                    })
                    .then(function (stream) {
                        video.srcObject = stream;
                        video.play();
                    })
                    .then(() => {
                        isPlaying = true;
                    })
                    .catch(function(error) {
                        console.error('Error accessing camera:', error.name, error.message);
                    });
            }
        }

        // Function to turn off the camera
        function cameraOff() {
            const stream = video.srcObject;
            if (stream) {
                const tracks = stream.getTracks();

                tracks.forEach(function (track) {
                    track.stop();
                });

                video.srcObject = null;
                isPlaying = false;
            }
        }
        });

    </script>

@endsection