{{-- Add photos modal --}}
<div class="modal" id="photosModal">
    <div class="modal-background"></div>
    <div class="modal-card large-modal">
        <header class="modal-card-head">
            <p class="modal-card-title has-text-centered">Agregar fotos al equipo</p>
            <button class="delete" aria-label="close" id="closePhotosModal"></button>
        </header>
        <section class="modal-card-body">

            <div class="columns">
                <div class="column">
                    <!-- Video element to display the camera feed -->
                    <video class="video-camera" id="camera-feed" autoplay></video>

                    <div class="has-text-centered">
                        <!-- Button to capture a photo -->
                        <button class="button" id="capture-btn">Sacar foto</button>
                    </div>
                </div>
                <div class="column">
                    <div class="photo-container has-text-centered no-scrollbar" id="photo-canvas-container"></div>
                    <!-- Input field to store the base64-encoded image data -->
                    <input type="hidden" id="photo-input" name="photo">
                </div>
            </div>

        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelPhotoModal">Cancelar</button>
        </footer>
    </div>
</div>