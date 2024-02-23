$(document).ready(function() {
    // When the status filter select value changes.
    $('#status_filter').change(function() {
        // Get the selected value.
        var selectedStatus = $(this).val();

        // Filter the displayed repairs on the page based on the selected status.
        $('.list-item').each(function() {
            var repairStatus = $(this).find('.repair-status').text().trim();

            // Show or hide the repair depending on the status.
            if (selectedStatus === 'all' || translate_status(repairStatus) === selectedStatus) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});

// Get the English translation of the repair status.
function translate_status(repairStatus) {
    switch (repairStatus) {
        case 'Sin revisar':
            return 'without checking';
        case 'En progreso':
            return 'in progress';
        case 'Completado':
            return 'completed';
        case 'Entregado':
            return 'delivered';
        case 'En espera':
            return 'waiting';
        default:
            // If no translation is available, return '-'.
            return '-';
    }
}
