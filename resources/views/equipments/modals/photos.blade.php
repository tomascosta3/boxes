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
                    <div id="photo-canvas-container"></div>


                    <div class="columns photos-container no-scrollbar">
                        <div class="column" id="photos-1">

                        </div>
                        <div class="column" id="photos-2">

                        </div>
                    </div>

                    <!-- Input field to store the base64-encoded image data -->
                    <input type="hidden" id="photo-input" name="photo">
                </div>
            </div>

        </section>
        <footer class="modal-card-foot is-justify-content-center">
            <button class="button" id="cancelPhotoModal">Cancelar</button>
            <button class="button is-success" id="savePhotos">Guardar fotos</button>
        </footer>
    </div>
</div>