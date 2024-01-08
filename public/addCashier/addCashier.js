document.addEventListener('DOMContentLoaded', function() {
    // Event listener to open the modal when the button is clicked
    document.getElementById('openModalButton').addEventListener('click', openModal);
    
    // var hasErrors = document.currentScript.getAttribute('data-errors') === 'true';
    
    function openModal() {
        // Display the modal only if there are no errors
            document.getElementById('myModal').style.display = 'block';
    }

    // Function to close the modal
    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    // Event listener to open the modal when the button is clicked
    document.getElementById('openModalButton').addEventListener('click', openModal);

    // Function to open the modal
    function openModal() {
        $('#myModal').show();
    }
});

// Function to close the modal
function closeModal() {
    $('#myModal').hide();
}
