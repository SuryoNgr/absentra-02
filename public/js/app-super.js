
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    }

    // Buka otomatis jika route aktif
    document.addEventListener('DOMContentLoaded', function () {
        const activeDropdowns = document.querySelectorAll('.menu-item.has-dropdown.active');
        activeDropdowns.forEach(item => {
            const id = item.getAttribute('onclick').match(/'([^']+)'/)[1];
            const submenu = document.getElementById(id);
            if (submenu) submenu.style.display = 'block';
        });
    });


    function toggleDropdownNavbar() {
        const menu = document.getElementById('dropdown-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    document.addEventListener('click', function (e) {
        const avatar = document.querySelector('.user-avatar');
        const menu = document.getElementById('dropdown-menu');

        if (!avatar.contains(e.target)) {
            menu.style.display = 'none';
        }
    });






