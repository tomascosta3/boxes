// Ensure the DOM is fully loaded before executing the script
document.addEventListener('DOMContentLoaded', function() {
    
    // Event listener for the button that opens the modal
    document.getElementById('addModelButton').addEventListener('click', function() {
        document.getElementById('addModelModal').classList.add('is-active');
    });

    // Event listener for the button that closes the modal
    document.getElementById('closeModelModal').addEventListener('click', function() {
        document.getElementById('addModelModal').classList.remove('is-active');
    });

    // Event listener for the button that cancels and closes the modal
    document.getElementById('cancelModelModal').addEventListener('click', function() {
        document.getElementById('addModelModal').classList.remove('is-active');
    });
});
