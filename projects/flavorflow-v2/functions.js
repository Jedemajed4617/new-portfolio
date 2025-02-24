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

// Toggle filters on phone
document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.getElementById("open-filter");
    const menu = document.getElementById("restaurants-aside");
    const closeMenu = document.getElementById("close-filter");
    
    let isOpen = false;

    menuIcon.addEventListener("click", function () {
        isOpen = !isOpen;
        menu.style.display = isOpen ? 'block' : 'none';
        menu.style.transform = isOpen ? 'translateX(0)' : 'translateX(-100%)';
    });

    closeMenu.addEventListener("click", function () {
        isOpen = false;
        menu.style.display = 'none';
    });
});

// Slider function for pc and mobile
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".restaurant-sliderlist");
    const catSlider = document.querySelector(".category-list");

    let isDown = false;
    let startX;
    let scrollLeft;

    function handleMouseDown(e, element) {
        isDown = true;
        element.classList.add("active");
        startX = e.pageX - element.offsetLeft;
        scrollLeft = element.scrollLeft;
    }

    function handleMouseLeave(element) {
        isDown = false;
        element.classList.remove("active");
    }

    function handleMouseUp(element) {
        isDown = false;
        element.classList.remove("active");
    }

    function handleMouseMove(e, element) {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - element.offsetLeft;
        const walk = (x - startX) * 2; // Adjust drag speed
        element.scrollLeft = scrollLeft - walk;
    }

    function handleTouchStart(e, element) {
        startX = e.touches[0].clientX;
        scrollLeft = element.scrollLeft;
    }

    function handleTouchMove(e, element) {
        const x = e.touches[0].clientX;
        const walk = (x - startX) * 2;
        element.scrollLeft = scrollLeft - walk;
    }

    [slider, catSlider].forEach(element => {
        element.addEventListener("mousedown", (e) => handleMouseDown(e, element));
        element.addEventListener("mouseleave", () => handleMouseLeave(element));
        element.addEventListener("mouseup", () => handleMouseUp(element));
        element.addEventListener("mousemove", (e) => handleMouseMove(e, element));
        element.addEventListener("touchstart", (e) => handleTouchStart(e, element));
        element.addEventListener("touchmove", (e) => handleTouchMove(e, element));
    });
});

// Open cart function
function openCart() {
    const cart = document.querySelector('.cartcontainer');
    const closeCartButton = document.querySelector('.close-cart');

    cart.classList.add('open');
    document.body.style.overflow = 'hidden';

    closeCartButton.addEventListener('click', function () {
        cart.classList.remove('open');
        document.body.style.overflow = 'auto';
    });
}