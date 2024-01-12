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

    captureBtn.addEventListener('click', function() {
        if (video.srcObject) {
            // Create new canvas element.
            const newCanvas = document.createElement('canvas');
            newCanvas.classList.add('photo');

            // Verify if original canvas element exists.
            if (canvas) {
                newCanvas.width = canvas.width;
                newCanvas.height = canvas.height;
            }

            // Add the new canvas container.
            document.getElementById('photo-canvas-container').appendChild(newCanvas);

            // Draw image in the new canvas.
            newCanvas.getContext('2d').drawImage(video, 0, 0, newCanvas.width, newCanvas.height);

            // Get image data and assign them to hidden input.
            const imageData = newCanvas.toDataURL('image/png');
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