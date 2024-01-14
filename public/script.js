document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('sidebar');
    const menuBar = document.querySelector('#content nav .bx.bx-menu');
    const searchButton = document.querySelector('#content nav form .form-input button');
    const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
    const searchForm = document.querySelector('#content nav form');
    const switchMode = document.getElementById('switch-mode');
    var flag=0;
    function toggleSidebar() 
    {
        sidebar.classList.toggle('hide');
    }


    

    if (menuBar) {
        menuBar.addEventListener('click', toggleSidebar);
    }
    sidebar.addEventListener('click', toggleSidebar)

    if (searchButton) {
        searchButton.addEventListener('click', function (e) {
            if (window.innerWidth < 576) {
                e.preventDefault();
                searchForm.classList.toggle('show');
                searchButtonIcon.classList.toggle('bx-search');
                searchButtonIcon.classList.toggle('bx-x');
            }
        });
    }

    if (switchMode) {
        switchMode.addEventListener('change', function () {
            document.body.classList.toggle('dark', this.checked);
        });
    }

    function checkWindowWidth() {
        if (window.innerWidth < 800) {
            sidebar.classList.add('hide');
        } else {
            sidebar.classList.remove('hide');
        }
    }

    // Initial check when the page loads
    checkWindowWidth();

    // Add an event listener to continuously check on window resize
    window.addEventListener('resize', function () {
        checkWindowWidth();
    });

});
