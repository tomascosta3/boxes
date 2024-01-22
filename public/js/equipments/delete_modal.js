// This script handles the opening and closing of the delete equipment confirmation modal.

// Show the delete confirmation modal.
document.getElementById('openDeleteConfirmationModal').addEventListener('click', function() {
    // Add 'is-active' class to make the modal visible.
    document.getElementById('equipmentDeleteConfirmationModal').classList.add('is-active');
});

// Close the delete confirmation modal.
document.getElementById('closeModal').addEventListener('click', function() {
    // Remove 'is-active' class to hide the modal.
    document.getElementById('equipmentDeleteConfirmationModal').classList.remove('is-active');
});

// Cancel and close the delete confirmation modal.
document.getElementById('cancelModal').addEventListener('click', function() {
    // Remove 'is-active' class to hide the modal.
    document.getElementById('equipmentDeleteConfirmationModal').classList.remove('is-active');
});