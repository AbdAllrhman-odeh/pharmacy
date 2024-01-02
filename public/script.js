document.addEventListener('DOMContentLoaded', function() {

	// TOGGLE SIDEBAR
    const sidebar = document.getElementById('sidebar');
    const menuBar = document.querySelector('#content nav .bx.bx-menu');

    if (menuBar) {
        menuBar.addEventListener('click', function () {
            sidebar.classList.toggle('hide');
        });
    }

    const searchButton = document.querySelector('#content nav form .form-input button');
    const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
    const searchForm = document.querySelector('#content nav form');

    if (searchButton) {
        searchButton.addEventListener('click', function (e) {
            if (window.innerWidth < 576) {
                e.preventDefault();
                searchForm.classList.toggle('show');
                if (searchForm.classList.contains('show')) {
                    searchButtonIcon.classList.replace('bx-search', 'bx-x');
                } else {
                    searchButtonIcon.classList.replace('bx-x', 'bx-search');
                }
            }
        });
    }

    if (window.innerWidth < 768) {
        sidebar.classList.add('hide');
    } else if (window.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }

    window.addEventListener('resize', function () {
        if (this.innerWidth > 576) {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
            searchForm.classList.remove('show');
        }
    });

    const switchMode = document.getElementById('switch-mode');

    if (switchMode) {
        switchMode.addEventListener('change', function () {
            if (this.checked) {
                document.body.classList.add('dark');
            } else {
                document.body.classList.remove('dark');
            }
        });
    }

    function checkWindowWidth() {
        var sidebarElement = document.getElementById('sidebar');
        // Check if the screen width is less than 800px
        if (window.innerWidth < 800) {
            sidebarElement.classList.add('hide');
        } else {
            sidebarElement.classList.remove('hide');
        }
    }

    // Initial check when the page loads
    checkWindowWidth();

    // Add an event listener to continuously check on window resize
    window.onresize = function () {
        checkWindowWidth();
    };


});
