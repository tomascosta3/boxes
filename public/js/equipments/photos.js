document.addEventListener('DOMContentLoaded', function() {

    // Event listener for the button that opens the modal.
    document.getElementById('addPhotoModal').addEventListener('click', function() {
        document.getElementById('photosModal').classList.add('is-active');
        cameraOn();
    });


    // Event listener for the button that closes the modal.
    document.getElementById('closePhotosModal').addEventListener('click', function() {
        document.getElementById('photosModal').classList.remove('is-active');
        cameraOff();
    });


    // Event listener for the button that cancels and closes the modal.
    document.getElementById('cancelPhotoModal').addEventListener('click', function() {
        document.getElementById('photosModal').classList.remove('is-active');
        cameraOff();
    });


    const video = document.getElementById('camera-feed');
    const photoInput = document.getElementById('photo-input');
    const captureBtn = document.getElementById('capture-btn');
    const equipmentForm = document.getElementById('equipment-form');
    const capturedPhotos = new Set();
    var isPlaying = !!video.srcObject;

    var photoCounter = 1;

    
    // Event listener for the button that captures a photo.
    captureBtn.addEventListener('click', function() {
        html2canvas($('#camera-feed')[0], {
            onrendered: function(canvas) {
                if (video.srcObject) {
                    // Create a new container for each photo.
                    const photoContainer = document.createElement('div');
                    photoContainer.classList.add('photo-container');

                    // Get the corresponding container (alternating between photos-1 and photos-2).
                    const containerId = `photos-${photoCounter % 2 + 1}`;
                    const container = document.getElementById(containerId);

                    // Append the new container to the column.
                    container.appendChild(photoContainer);

                    // Create a new canvas element.
                    const newCanvas = document.createElement('canvas');
                    newCanvas.classList.add('photo');

                    // Create a close button.
                    const closeButton = document.createElement('button');
                    closeButton.classList.add('delete', 'is-small', 'is-pulled-right', 'is-pulled-top');
                    closeButton.addEventListener('click', function() {
                        // Remove the corresponding canvas and container.
                        photoContainer.remove();

                        // Remove the captured photo from the set.
                        capturedPhotos.delete(newImage.src);

                        // Reorganize the remaining photos.
                        organizePhotos();

                        // Update the input with the remaining photos.
                        updatePhotoInput();
                    });

                    // Append the new canvas and close button to the container.
                    photoContainer.appendChild(newCanvas);
                    photoContainer.appendChild(closeButton);

                    // Check if the original canvas element exists.
                    if (canvas) {
                        newCanvas.width = canvas.width;
                        newCanvas.height = canvas.height;
                    }

                    // Increment the counter.
                    photoCounter++;

                    // Draw the captured image on the new canvas.
                    newCanvas.getContext('2d').drawImage(video, 0, 0, newCanvas.width, newCanvas.height);

                    // Add the captured photo to the set.
                    capturedPhotos.add(newCanvas.toDataURL('image/png'));
        
                    // Reorganize the photos after capturing a new one.
                    organizePhotos();

                } else {
                    console.error('Camera not available or permission denied');
                }
            }
        });
    });


    // Function to reorganize photos.
    function organizePhotos() {
        const photoContainers = document.querySelectorAll('.photo-container');
        const container1 = document.getElementById('photos-1');
        const container2 = document.getElementById('photos-2');

        photoContainers.forEach((container) => {
            // Skip if the container is already in the correct column.
            if (container.parentElement === container1 || container.parentElement === container2) {
                return;
            }

            // Determine the container with fewer photos.
            const targetContainer = container1.children.length <= container2.children.length ? container1 : container2;

            // Move the container to the target column.
            targetContainer.appendChild(container);
        });
    }


    // Function to turn on the camera.
    function cameraOn() {
        // Check if the mediaDevices API is supported and getUserMedia method is available.
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Request access to the user's camera.
            navigator.mediaDevices
                .getUserMedia({
                    video: true
                })
                .then(function (stream) {
                    // Set the camera stream as the source for the video element and start playing.
                    video.srcObject = stream;
                    video.play();
                })
                .then(() => {
                    // Set the flag to indicate that the camera is currently on.
                    isPlaying = true;
                })
                .catch(function(error) {
                    // Handle errors when accessing the camera.
                    console.error('Error accessing camera:', error.name, error.message);
                });
        }
    }


    // Function to turn off the camera.
    function cameraOff() {
        // Get the current stream from the video element.
        const stream = video.srcObject;

        // Check if there is a stream.
        if (stream) {
            // Get all tracks from the stream and stop each one.
            const tracks = stream.getTracks();
            tracks.forEach(function (track) {
                track.stop();
            });

            // Set the video source object to null, effectively turning off the camera.
            video.srcObject = null;

            // Set the flag to indicate that the camera is currently off.
            isPlaying = false;
        }
    }


    // Function to update the input with the captured photos.
    function updatePhotoInput() {
        // Set the value of the input to a comma-separated string of captured photos.
        photoInput.value = Array.from(capturedPhotos).join(',');

        // Convert the capturedPhotos Set to an array for iteration.
        var photos = Array.from(capturedPhotos);

        // Iterate over each captured photo.
        photos.forEach(function(imageData, index) {
            // Create a new Image element.
            var img = new Image();

            // Set the source attribute of the Image element with the image data.
            img.src = imageData;

            // Set the Image element to be hidden.
            img.hidden = true;

            // Append the Image element to the equipmentForm.
            equipmentForm.appendChild(img);

            // Create a hidden input field in the form for each captured photo.
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'images[]';  // Use brackets to indicate it is an array in the form.
            input.value = imageData;

            // Append the hidden input field to the equipmentForm.
            equipmentForm.appendChild(input);
        });
    }



    // Event listener for the button that saves the photos in the form.
    document.getElementById('savePhotos').addEventListener('click', function() {
        // Call the function to update the photo input in the form.
        updatePhotoInput();

        // Remove the 'is-active' class from the 'photosModal' element to hide the modal.
        document.getElementById('photosModal').classList.remove('is-active');

        // Turn off the camera.
        cameraOff();
    });
});