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

    var photoCounter = 1;

    // Event listener for the button that captures a photo
    captureBtn.addEventListener('click', function() {
        if (video.srcObject) {
            // Create a new container for each photo
            const photoContainer = document.createElement('div');
            photoContainer.classList.add('photo-container');

            // Create a new canvas element
            const newCanvas = document.createElement('canvas');
            newCanvas.classList.add('photo');

            // Create a close button
            const closeButton = document.createElement('button');
            closeButton.classList.add('delete', 'is-small', 'is-pulled-right', 'is-pulled-top');
            closeButton.addEventListener('click', function() {
                // Remove the corresponding canvas and container
                photoContainer.remove();

                // Reorganize the remaining photos
                organizePhotos();
            });

            // Append the new canvas and close button to the container
            photoContainer.appendChild(newCanvas);
            photoContainer.appendChild(closeButton);

            // Check if the original canvas element exists
            if (canvas) {
                newCanvas.width = canvas.width;
                newCanvas.height = canvas.height;
            }

            // Get the corresponding container (alternating between photos-1 and photos-2)
            const containerId = `photos-${photoCounter % 2 + 1}`;
            const container = document.getElementById(containerId);

            // Increment the counter
            photoCounter++;

            // Append the new container to the column
            container.appendChild(photoContainer);

            // Draw the captured image on the new canvas
            newCanvas.getContext('2d').drawImage(video, 0, 0, newCanvas.width, newCanvas.height);

            // Get the image data and set it to the hidden input field
            const imageData = newCanvas.toDataURL('image/png');
            photoInput.value = imageData;

            // Reorganize the photos after capturing a new one
            organizePhotos();
        } else {
            console.error('Camera not available or permission denied');
        }
    });

    // Function to reorganize photos
    function organizePhotos() {
        const photoContainers = document.querySelectorAll('.photo-container');
        const container1 = document.getElementById('photos-1');
        const container2 = document.getElementById('photos-2');

        photoContainers.forEach((container) => {
            // Skip if the container is already in the correct column
            if (container.parentElement === container1 || container.parentElement === container2) {
                return;
            }

            // Determine the container with fewer photos
            const targetContainer = container1.children.length <= container2.children.length ? container1 : container2;
            console.log(targetContainer);
            // Move the container to the target column
            targetContainer.appendChild(container);
        });
    }


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