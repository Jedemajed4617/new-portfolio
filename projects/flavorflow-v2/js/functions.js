// navmenu phone
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

    // Check if menuContainer exists before adding the event listener to prevent errors
    if (menuContainer) {
        document.addEventListener("click", function (event) {
            if (!menuContainer.contains(event.target) && event.target !== menuIcon) {
                isOpen = false;
                menu.classList.remove("open");
                document.body.style.overflow = "auto";
            }
        });
    }
});

// Dropdown filter function
function toggleDropdown() {
    const dropdownMenu = document.querySelector(".dropdown-menu");
    const filterButtonActive = document.querySelector(".filter-button-active");
    const filterButton = document.querySelector(".filter-button");
    const closeMenuAfterLinkClick = document.querySelector(".dropdown-links");

    dropdownMenu.classList.toggle("show");

    if (dropdownMenu.classList.contains("show")) {
        filterButtonActive.style.borderBottomRightRadius = "0";
        filterButton.style.borderBottomLeftRadius = "0";
    } else {
        filterButtonActive.style.borderBottomRightRadius = "";
        filterButton.style.borderBottomLeftRadius = "";
    }

    closeMenuAfterLinkClick.addEventListener("click", function () {
        filterButtonActive.style.borderBottomRightRadius = "";
        filterButton.style.borderBottomLeftRadius = "";
        dropdownMenu.classList.remove("show");
    });
}

// Input handling button
document.querySelectorAll(".restaurants-aside-list button").forEach((button) => {
    button.addEventListener("click", function (e) {
        if (e.target.tagName !== "INPUT") {
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

    // Check if the elements exist before adding event listeners to prevent errors
    if (menuIcon) {
        menuIcon.addEventListener("click", function () {
            isOpen = !isOpen;
            if (menu) {
                menu.style.display = isOpen ? "block" : "none";
                menu.style.transform = isOpen ? "translateX(0)" : "translateX(-100%)";
            }
        });
    }

    if (closeMenu) {
        closeMenu.addEventListener("click", function () {
            isOpen = false;
            if (menu) {
                menu.style.display = "none";
            }
        });
    }
});


document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".restaurant-sliderlist");
    const catSlider = document.querySelector(".category-list");

    let isDown = false;
    let startX;
    let scrollLeft;

    function handleMouseDown(e, element) {
        if (window.innerWidth <= 1000) return;
        isDown = true;
        element.classList.add("active");
        startX = e.pageX - element.offsetLeft;
        scrollLeft = element.scrollLeft;
    }

    function handleMouseLeave(element) {
        if (window.innerWidth <= 1000) return;
        isDown = false;
        element.classList.remove("active");
    }

    function handleMouseUp(element) {
        if (window.innerWidth <= 1000) return;
        isDown = false;
        element.classList.remove("active");
    }

    function handleMouseMove(e, element) {
        if (window.innerWidth <= 1000 || !isDown) return;
        e.preventDefault();
        const x = e.pageX - element.offsetLeft;
        const walk = (x - startX) * 2; // Adjust drag speed
        element.scrollLeft = scrollLeft - walk;
    }

    function handleTouchStart(e, element) {
        if (window.innerWidth <= 1000) return;
        startX = e.touches[0].clientX;
        scrollLeft = element.scrollLeft;
    }

    function handleTouchMove(e, element) {
        if (window.innerWidth <= 1000) return;
        const x = e.touches[0].clientX;
        const walk = (x - startX) * 2;
        element.scrollLeft = scrollLeft - walk;
    }

    function addEventListeners(element) {
        if (!element) return;
        element.addEventListener("mousedown", (e) => handleMouseDown(e, element));
        element.addEventListener("mouseleave", () => handleMouseLeave(element));
        element.addEventListener("mouseup", () => handleMouseUp(element));
        element.addEventListener("mousemove", (e) => handleMouseMove(e, element));
        element.addEventListener("touchstart", (e) => handleTouchStart(e, element));
        element.addEventListener("touchmove", (e) => handleTouchMove(e, element));
    }

    // Attach event listeners
    addEventListeners(slider);
    addEventListeners(catSlider);
});


// Open cart function
function openCart() {
    const cart = document.querySelector(".cartcontainer");
    const closeCartButton = document.querySelector(".close-cart");

    cart.classList.add("open");
    document.body.style.overflow = "hidden";

    closeCartButton.addEventListener("click", function () {
        cart.classList.remove("open");
        document.body.style.overflow = "auto";
    });
}

// Go back function
function goBack() {
    if (window.history.length > 1) {
        window.location.href = "./index.html"; 
    } else {
        window.location.href = "./index.html"; 
    }
}

// payment page redirect
document.addEventListener("DOMContentLoaded", function () {
    const go = document.querySelector(".order-submit");

    // Check if the element exists before adding the event listener to prevent errors
    if (go) {
        go.addEventListener("click", function () {
            window.location.href = "./payment.html";
        });
    }
});

// select payment method
document.addEventListener("DOMContentLoaded", function () {
    const pay = document.querySelector(".payment-button");

    // Check if the element exists before adding the event listener to prevent errors
    if (pay) {
        pay.addEventListener("click", function () {
            window.location.href = "./profile.html";
        });
    }
});


// Temp. fix for ordering
function orderPage() {
    const cart = document.querySelector(".cartcontainer");
    cart.classList.remove("open");
    document.body.style.overflow = "auto";
    window.location.href = "./order.html";  
}

// Cart note modal open and close
document.addEventListener("DOMContentLoaded", function () {
    const note = document.querySelector(".cart-notecontainer");
    const openButton = document.querySelector(".cart-note");
    const closeButtons = document.querySelectorAll(".closenote, .close");

    // Check if the elements exist before proceeding
    if (note && openButton && closeButtons.length > 0) {
        function toggleNote() {
            note.classList.toggle("open");
        }

        function closeNote() {
            note.classList.remove("open");
        }

        openButton.addEventListener("click", toggleNote);

        closeButtons.forEach((button) => {
            button.addEventListener("click", closeNote);
        });
    } else {
        console.warn("Elements not found: .cart-notecontainer, .cart-note, or .closenote/.close");
    }
});


// Search dropdown orderpage
var heroes = [
    "Koningstraat 1, 1234AB, Amsterdam",
    "Prinsengracht 2, 5678CD, Amsterdam",
    "Herengracht 3, 9101EF, Amsterdam",
    "Keizersgracht 4, 1121GH, Amsterdam",
    "Damrak 5, 3141IJ, Amsterdam",
    "Rokin 6, 5161KL, Amsterdam",
    "Leidseplein 7, 7181MN, Amsterdam",
    "Museumplein 8, 9201OP, Amsterdam",
    "Vondelpark 9, 1221QR, Amsterdam",
    "Rembrandtplein 10, 3241ST, Amsterdam",
    "Nieuwmarkt 11, 5261UV, Amsterdam",
    "Waterlooplein 12, 7281WX, Amsterdam", 
];

document.addEventListener("DOMContentLoaded", function () {
    const searchBar = document.getElementById("searchBar");
    const dataList = document.getElementById("customDatalist");

    // Check if the elements exist before proceeding
    if (searchBar && dataList) {
        function updateDatalist() {
            const query = searchBar.value.toLowerCase();
            dataList.innerHTML = ""; // Clear old results

            if (query) {
                let filteredHeroes = heroes.filter(hero => hero.toLowerCase().includes(query));

                // Prioritize results that start with the search query
                filteredHeroes.sort((a, b) => {
                    const aLower = a.toLowerCase();
                    const bLower = b.toLowerCase();

                    const aStarts = aLower.startsWith(query);
                    const bStarts = bLower.startsWith(query);

                    if (aStarts && !bStarts) return -1;
                    if (!aStarts && bStarts) return 1;
                    return aLower.localeCompare(bLower); // Default sorting if both start or contain
                });

                if (filteredHeroes.length) {
                    dataList.classList.remove("hidden");
                    filteredHeroes.forEach(hero => {
                        const li = document.createElement("li");
                        li.textContent = hero;
                        li.addEventListener("click", function () {
                            searchBar.value = hero;
                            dataList.classList.add("hidden");
                        });
                        dataList.appendChild(li);
                    });
                } else {
                    // Show "No results found"
                    const noResults = document.createElement("li");
                    noResults.textContent = "Geen resultaten gevonden";
                    noResults.classList.add("no-results");
                    dataList.appendChild(noResults);
                    dataList.classList.remove("hidden");
                }
            } else {
                dataList.classList.add("hidden");
            }
        }

        searchBar.addEventListener("input", updateDatalist);
        document.addEventListener("click", (e) => {
            if (!searchBar.contains(e.target) && !dataList.contains(e.target)) {
                dataList.classList.add("hidden");
            }
        });
    } else {
        console.warn("Elements not found: #searchBar or #customDatalist");
    }
});


// Order delivery toggle
// Order delivery toggle
const bezorgenButton = document.getElementById('bezorgen');
const afhalenButton = document.getElementById('afhalen');

// Function to handle selecting/deselecting buttons
function toggleSelection(selected) {
    // Check if buttons exist before trying to modify them
    if (bezorgenButton && afhalenButton) {
        if (selected === 'bezorgen') {
            bezorgenButton.classList.add('enabled');
            bezorgenButton.classList.remove('disabled');
            afhalenButton.classList.add('disabled');
            afhalenButton.classList.remove('enabled');
        } else if (selected === 'afhalen') {
            afhalenButton.classList.add('enabled');
            afhalenButton.classList.remove('disabled');
            bezorgenButton.classList.add('disabled');
            bezorgenButton.classList.remove('enabled');
        }
    } else {
        console.warn("Buttons not found: 'bezorgen' or 'afhalen'");
    }
}

// Initialize the default selection (Bezorgen selected, Afhalen disabled)
toggleSelection('bezorgen');

// Add event listeners to buttons, if they exist to prevent errors
if (bezorgenButton) {
    bezorgenButton.addEventListener('click', () => toggleSelection('bezorgen'));
}

if (afhalenButton) {
    afhalenButton.addEventListener('click', () => toggleSelection('afhalen'));
}

// Prevent default value deletion inputs
const valuedInput = document.querySelector('.valued-input');

// Check if the element exists before proceeding
if (valuedInput) {
    const defaultValue = valuedInput.value;

    // Listen for the keydown event to prevent deleting
    valuedInput.addEventListener('keydown', function(event) {
        // Check if the key pressed is one that would delete (Backspace, Delete, or any other ways to remove characters)
        if (event.key === 'Backspace' || event.key === 'Delete') {
            if (valuedInput.value === defaultValue) {
                event.preventDefault(); // Prevent the keydown event if the input value is the default value
            }
        }
    });
} else {
    console.warn("Element '.valued-input' not found.");
}


// payment method selection coloring function
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.paymentmethod');
    const paymentButton = document.querySelector('.payment-button');

    function updatePaymentButtonState() {
        const selectedMethod = document.querySelector('.paymentmethod.selected');
        if (selectedMethod) {
            paymentButton.classList.add('active');
            paymentButton.disabled = false;
            paymentButton.style.pointerEvents = 'auto';
        } else {
            paymentButton.classList.remove('active');
            paymentButton.disabled = true;
            paymentButton.style.pointerEvents = 'none';
        }
    }

    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Check if the clicked method is already selected
            if (this.classList.contains('selected')) {
                // If already selected, unselect it
                this.classList.remove('selected');
                this.querySelector('.payment-content i').classList.remove('selected');
                this.querySelector('.payment-iconcontainer i').classList.remove('selected');
                this.querySelector('.payment-content h1').classList.remove('selected');
                this.querySelector('.payment-content i').style.display = 'none';
            } else {
                // Otherwise, select it and unselect others
                paymentMethods.forEach(item => {
                    item.classList.remove('selected');
                    item.querySelector('.payment-content i').classList.remove('selected');
                    item.querySelector('.payment-iconcontainer i').classList.remove('selected');
                    item.querySelector('.payment-content h1').classList.remove('selected');
                    item.querySelector('.payment-content i').style.display = 'none';
                });

                this.classList.add('selected');
                this.querySelector('.payment-content i').classList.add('selected');
                this.querySelector('.payment-iconcontainer i').classList.add('selected');
                this.querySelector('.payment-content h1').classList.add('selected');
                this.querySelector('.payment-content i').style.display = 'block';
            }

            updatePaymentButtonState();
        });
    });

    // Set button to disabled on page load
    updatePaymentButtonState();
});

// Modal open and close for admin dashboard
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.querySelector(".moreinfocontainer");
    const openButton = document.querySelector(".admin-info-listitem > a") || document.querySelector(".restaurants-info-listitem a");
    const closeButtons = document.querySelectorAll(".close-moreinfo");

    if (!modal) {
        console.error("Error: Modal container (.moreinfocontainer) not found.");
        return;
    }

    if (!openButton) {
        console.error("Error: Open button (.admin-info-listitem > a or .restaurants-info-listitem > a) not found.");
        return;
    }

    if (closeButtons.length === 0) {
        console.error("Error: Close buttons (.close-moreinfo) not found.");
        return;
    }

    function toggleModal(event) {
        event.preventDefault();
        modal.classList.toggle("open");
        document.body.style.overflowX = "hidden"
        console.log("Modal toggled:", modal.classList.contains("open"));
    }

    function closeModal() {
        modal.classList.remove("open");
        document.body.style.overflow = "auto";
        console.log("Modal closed.");
    }

    openButton.addEventListener("click", toggleModal);

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    // Close modal when clicking outside
    document.addEventListener("click", function (event) {
        if (modal.classList.contains("open") && !modal.contains(event.target) && !openButton.contains(event.target)) {
            closeModal();
        }
    });

    // Close modal on Escape key press
    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modal.classList.contains("open")) {
            closeModal();
        }
    });

    console.log("Modal script initialized successfully.");
});


// Select all function inputs
document.querySelector('.products-info-header > input').addEventListener('change', function() {
    const allInputs = document.querySelectorAll('.products-info-listitem > input');

    allInputs.forEach(input => {
      input.checked = this.checked;
    });
  });