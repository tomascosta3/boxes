document.addEventListener("DOMContentLoaded", function() {
    // Print button.
    document.getElementById('printButton').addEventListener('click', function() {
        // Get the order number from the current URL.
        var orderNumber = window.location.pathname.split('/').pop(); // Get the last segment of the URL
    
        // Create an iframe.
        var iframe = document.createElement('iframe');
    
        // Hide the iframe.
        iframe.style.display = 'none';
    
        // Set the URL of the view you want to print.
        iframe.src = '/orders/' + orderNumber + '/print';
    
        // Add the iframe to the document body.
        document.body.appendChild(iframe);
    
        // Print the content of the iframe.
        iframe.contentWindow.print();
        
        // Remove the iframe after printing.
        setTimeout(function() {
            document.body.removeChild(iframe);
        }, 1000); // Wait time to ensure printing is completed.
    });
});