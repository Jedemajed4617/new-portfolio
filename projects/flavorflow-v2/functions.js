document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.getElementById("menu-icon");
    const menu = document.getElementById("menu");
    const menuContainer = document.getElementById("menu-container");
    const closeMenu = document.getElementById("close-menu");
    
    let isOpen = false;

    menuIcon.addEventListener("click", function () {
        isOpen = !isOpen;
        menu.classList.toggle("open", isOpen);
        document.body.style.overflow = isOpen ? "hidden" : "auto";
    });

    closeMenu.addEventListener("click", function () {
        isOpen = false;
        menu.classList.remove("open");
        document.body.style.overflow = "auto";
    });

    document.addEventListener("click", function (event) {
        if (!menuContainer.contains(event.target) && event.target !== menuIcon) {
            isOpen = false; 
            dropdownOpen = false;
            menu.classList.remove("open");
            dropdownMenu.classList.remove("open");
            document.body.style.overflow = "auto";
        }
    });
});

// Dropdown filter
function toggleDropdown() {
    const dropdownMenu = document.querySelector('.dropdown-menu');
    const filterButtonActive = document.querySelector('.filter-button-active');
    const filterButton = document.querySelector('.filter-button');
    const closeMenuAfterLinkClick = document.querySelector('.dropdown-links');
    
    dropdownMenu.classList.toggle('show');
    
    if (dropdownMenu.classList.contains('show')) {
        filterButtonActive.style.borderBottomRightRadius = '0';
        filterButton.style.borderBottomLeftRadius = '0';
    } else {
        filterButtonActive.style.borderBottomRightRadius = '';
        filterButton.style.borderBottomLeftRadius = '';
    }

    closeMenuAfterLinkClick.addEventListener("click", function () {
        filterButtonActive.style.borderBottomRightRadius = '';
        filterButton.style.borderBottomLeftRadius = '';
        dropdownMenu.classList.remove('show');
    })
}

// Input handling button
document.querySelectorAll('.restaurants-aside-list button').forEach(button => {
    button.addEventListener('click', function (e) {
        if (e.target.tagName !== 'INPUT') {
            const checkbox = this.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
        }
    });
});