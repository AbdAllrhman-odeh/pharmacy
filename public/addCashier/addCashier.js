document.addEventListener('DOMContentLoaded', function () {
    // Event listener to open the first modal when the button is clicked
    document.getElementById('openModalButton').addEventListener('click', openModal);
    // document.getElementById('openModalButton2').addEventListener('click', openModal2);

    // Function to open the first modal
    function openModal() {
        document.getElementById('myModal').style.display = 'block';
    }
    // function openModal2() {
    //     document.getElementById('myModal2').style.display = 'block';
    // }
    var buttons = document.getElementsByClassName('openModalButton2');

    for (var i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener('click', function () {
            // You need to pass the specific cashierId here
            openModal2(this.getAttribute('data-cashier-id'));
        });
    }

    // Function to open the second modal
    function openModal2(cashierId) {
        document.getElementById('myModal2_' + cashierId).style.display = 'block';
    }

    // Function to close the second modal
    function closeModal2(cashierId) {
        document.getElementById('myModal2_' + cashierId).style.display = 'none';
    }

});

// Close the first and the second modal
function closeModal() {
    $('#myModal').hide();
}
function closeModal2(cashierId) {
    document.getElementById('myModal2_' + cashierId).style.display = 'none';
}   

function openModal2(cashierId) {
    document.getElementById('myModal2_' + cashierId).style.display = 'block';
}



