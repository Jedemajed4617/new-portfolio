// error msg custom
function showCustomMessage(message, isSuccess = true) {
    const messageContainer = document.getElementById("message-container");

    // Set the message text and background color based on success or failure
    messageContainer.textContent = message;
    messageContainer.style.backgroundColor = isSuccess ? "#1ca210c2" : "rgba(162, 28, 16, 0.8)"; // Green for success, Red for error

    // Add the class to show the message
    messageContainer.classList.add("show-message");

    // Remove the show-message class after 2 seconds to start fading out
    setTimeout(() => {
        messageContainer.classList.add("fade-out");
    }, 1500);

    // Remove the message from the DOM after the fade-out animation is done (3 seconds total)
    setTimeout(() => {
        messageContainer.classList.remove("show-message", "fade-out");
    }, 1500);
}

// Animdation cards inladen
document.querySelectorAll('.adres-listitem').forEach((item, index) => {
    item.style.setProperty('--index', index + 1);
});

// refresh page
function refresh(){
    location.reload();
}

// Search dropdown orderpage with google api
document.addEventListener("DOMContentLoaded", function () {
    const searchBar = document.getElementById("searchBargoogle");
    const dataList = document.getElementById("customDatalist");

    if (searchBar && dataList) {
        searchBar.addEventListener("input", function () {
            let query = searchBar.value;

            if (query.length > 2) { // Only fetch when there's enough input
                fetch(`./functions/get_address_suggestions.php?query=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log("API Response Data:", data); // Log the entire API response

                        if (dataList){
                            dataList.innerHTML = ""; // Clear the previous suggestions and if not exist do nothing
                        }

                        if (data.predictions && data.predictions.length > 0) {
                            data.predictions.forEach(prediction => {
                                console.log("Prediction Description:", prediction.description); // Log each prediction description
                                const li = document.createElement("li");
                                li.textContent = prediction.description;
                                li.addEventListener("click", function () {
                                    searchBar.value = prediction.description;
                                    dataList.classList.add("hidden");
                                });
                                dataList.appendChild(li);
                            });
                            dataList.classList.remove("hidden");
                        } else {
                            const noResults = document.createElement("li");
                            noResults.textContent = "Geen resultaten gevonden";
                            noResults.classList.add("no-results");
                            dataList.appendChild(noResults);
                            dataList.classList.remove("hidden");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching address suggestions:", error);
                    });
            } else {
                dataList.classList.add("hidden"); // Hide list if query is too short
            }
        });

        // Hide the data list when clicking outside
        document.addEventListener("click", (e) => {
            if (!searchBar.contains(e.target) && !dataList.contains(e.target)) {
                dataList.classList.add("hidden");
            }
        });

        // Hide the datalist when the user presses enter.
        searchBar.addEventListener("keydown", function(event){
            if(event.key === "Enter"){
                dataList.classList.add("hidden");
            }
        });
    } else {
        console.warn("Elements not found: #searchBar or #customDatalist");
    }
});

// search dropdown categories
document.addEventListener("DOMContentLoaded", function () {
    function updateCategoryListSearchBar() {
        const query = this.value.toLowerCase();
        const categoryList = document.getElementById("productcategorielist");
        if (categoryList) {
            categoryList.innerHTML = "";
        }

        console.log("SearchBar input value: ", query);

        if (query) {
            // Fetch categories from the API
            fetch("../functions/api.php?function=getCategoriesFromDatabase")
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Fetched data:", data); // Debugging: log the fetched data
                    
                    if (data.error) {
                        console.error("PHP Error:", data.error);
                        if (data.debug) {
                            console.log("PHP Debug:", data.debug);
                        }

                        // Display error message if categories cannot be fetched
                        const errorLi = document.createElement("li");
                        errorLi.textContent = "Er is een fout opgetreden bij het ophalen van de categorieën.";
                        errorLi.classList.add("error-message");
                        categoryList.appendChild(errorLi);
                        categoryList.classList.remove("hidden");
                    } else {
                        if (data.debug) {
                            console.log("PHP Debug:", data.debug);
                        }

                        // Ensure data.categories is an array
                        if (!data.categories || !Array.isArray(data.categories)) {
                            console.error("Invalid categories data:", data.categories);
                            const errorLi = document.createElement("li");
                            errorLi.textContent = "Ongeldige categoriegegevens ontvangen.";
                            errorLi.classList.add("error-message");
                            categoryList.appendChild(errorLi);
                            categoryList.classList.remove("hidden");
                            return;
                        }

                        // Filter categories based on query input
                        let filteredCategories = data.categories.filter((category) =>
                            category.category_name.toLowerCase().includes(query)
                        );

                        // Sort categories by whether they start with the query or contain it
                        filteredCategories.sort((a, b) => {
                            const aLower = a.category_name.toLowerCase();
                            const bLower = b.category_name.toLowerCase();

                            const aStarts = aLower.startsWith(query);
                            const bStarts = bLower.startsWith(query);

                            if (aStarts && !bStarts) return -1;
                            if (!aStarts && bStarts) return 1;
                            return aLower.localeCompare(bLower);
                        });

                        // Show filtered categories or show no results message
                        if (filteredCategories.length) {
                            categoryList.classList.remove("hidden");
                            filteredCategories.forEach((category) => {
                                const li = document.createElement("li");
                                li.textContent = category.category_name;
                                li.addEventListener("click", function () {
                                    searchBar.value = category.category_name; // Set selected category to the input value
                                    categoryList.classList.add("hidden");
                                });
                                categoryList.appendChild(li);
                            });
                        } else {
                            const noResults = document.createElement("li");
                            noResults.textContent = "Geen resultaten gevonden, wilt u deze categorie toevoegen? Laat hem dan staan in het veld.";
                            noResults.classList.add("no-results");
                            categoryList.appendChild(noResults);
                            categoryList.classList.remove("hidden");
                        }
                    }
                })
                .catch((error) => {
                    console.error("Error fetching categories:", error);
                    // Display a network error message
                    const errorLi = document.createElement("li");
                    errorLi.textContent = "Er is een netwerkfout opgetreden.";
                    errorLi.classList.add("error-message");
                    categoryList.appendChild(errorLi);
                    categoryList.classList.remove("hidden");
                });
        } else {
            categoryList.classList.add("hidden");
        }
    }

    // Function to update the category list for "show_dish_category"
    function updateCategoryListShowDish() {
        const query = this.value.toLowerCase(); // `this` will refer to the input that triggered the event
        const categoryList = document.getElementById("categorielist"); // Get the list for show_dish_category
        categoryList.innerHTML = ""; // Clear previous results

        console.log("Show Dish input value: ", query); // Debugging: log the query input

        if (query) {
            // Fetch categories from the API
            fetch("../functions/api.php?function=getCategoriesFromDatabase")
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Fetched data:", data); // Debugging: log the fetched data
                    
                    if (data.error) {
                        console.error("PHP Error:", data.error);
                        if (data.debug) {
                            console.log("PHP Debug:", data.debug);
                        }

                        // Display error message if categories cannot be fetched
                        const errorLi = document.createElement("li");
                        errorLi.textContent = "Er is een fout opgetreden bij het ophalen van de categorieën.";
                        errorLi.classList.add("error-message");
                        categoryList.appendChild(errorLi);
                        categoryList.classList.remove("hidden");
                    } else {
                        if (data.debug) {
                            console.log("PHP Debug:", data.debug);
                        }

                        // Ensure data.categories is an array
                        if (!data.categories || !Array.isArray(data.categories)) {
                            console.error("Invalid categories data:", data.categories);
                            const errorLi = document.createElement("li");
                            errorLi.textContent = "Ongeldige categoriegegevens ontvangen.";
                            errorLi.classList.add("error-message");
                            categoryList.appendChild(errorLi);
                            categoryList.classList.remove("hidden");
                            return;
                        }

                        // Filter categories based on query input
                        let filteredCategories = data.categories.filter((category) =>
                            category.category_name.toLowerCase().includes(query)
                        );

                        // Sort categories by whether they start with the query or contain it
                        filteredCategories.sort((a, b) => {
                            const aLower = a.category_name.toLowerCase();
                            const bLower = b.category_name.toLowerCase();

                            const aStarts = aLower.startsWith(query);
                            const bStarts = bLower.startsWith(query);

                            if (aStarts && !bStarts) return -1;
                            if (!aStarts && bStarts) return 1;
                            return aLower.localeCompare(bLower);
                        });

                        // Show filtered categories or show no results message
                        if (filteredCategories.length) {
                            categoryList.classList.remove("hidden");
                            filteredCategories.forEach((category) => {
                                const li = document.createElement("li");
                                li.textContent = category.category_name;
                                li.addEventListener("click", function () {
                                    this.value = category.category_name; // Set selected category to the input value
                                    categoryList.classList.add("hidden");
                                });
                                categoryList.appendChild(li);
                            });
                        } else {
                            const noResults = document.createElement("li");
                            noResults.textContent = "Geen resultaten gevonden, wilt u deze categorie toevoegen? Laat hem dan staan in het veld.";
                            noResults.classList.add("no-results");
                            categoryList.appendChild(noResults);
                            categoryList.classList.remove("hidden");
                        }
                    }
                })
                .catch((error) => {
                    console.error("Error fetching categories:", error);
                    // Display a network error message
                    const errorLi = document.createElement("li");
                    errorLi.textContent = "Er is een netwerkfout opgetreden.";
                    errorLi.classList.add("error-message");
                    categoryList.appendChild(errorLi);
                    categoryList.classList.remove("hidden");
                });
        } else {
            categoryList.classList.add("hidden");
        }
    }

    // Get the search bars
    const searchBar = document.getElementById("searchBar");
    const showDishCategory = document.getElementById("show_dish_category");

    // Add event listeners to the search bars
    if (searchBar) {
        searchBar.addEventListener("input", updateCategoryListSearchBar);
    }
    if (showDishCategory) {
        showDishCategory.addEventListener("input", updateCategoryListShowDish);
    }

    // Close the category list when clicking outside
    document.addEventListener("click", (e) => {
        if (searchBar && showDishCategory && !searchBar.contains(e.target) && !showDishCategory.contains(e.target)) {
            document.getElementById("productcategorielist").classList.add("hidden");
            document.getElementById("categorielist").classList.add("hidden");
        }
    });
});

// Modal open and close for admin dashboard
document.addEventListener("DOMContentLoaded", function () {
    const modal = document.querySelector(".moreinfocontainer");
    const openButtons = document.querySelectorAll(".product-info-listitem > a");
    const closeButtons = document.querySelectorAll(".close-moreinfo");

    if (!modal) {
        console.warn("Error: Modal container (.moreinfocontainer) not found.");
        return;
    }

    if (openButtons.length === 0) {
        console.warn("Error: Open buttons (.product-info-listitem > a) not found.");
        return;
    }

    if (closeButtons.length === 0) {
        console.warn("Error: Close buttons (.close-moreinfo) not found.");
        return;
    }

    function toggleModal(event) {
        // Get the clicked dish's data
        const dishId = this.dataset.id;
        const dishName = this.dataset.name;
        const dishPrice = this.dataset.price;
        const dishCategory = this.dataset.category;
        const dishCreated = this.dataset.created;
        const dishDiscount = this.dataset.discount;
        const dishCreatedBy = this.dataset.createdBy;
        const dishStatus = this.dataset.status;
        const dishDescription = this.dataset.description;
        const dishPriceVat = (this.dataset.price * 0.79).toFixed(2);
        const dishImage = this.dataset.pimage;

        // Populate the modal with the dish data
        document.getElementById("show_dish_id").value = "#" + dishId; // Product ID
        document.getElementById("show_dish_name").value = dishName; // Product name
        document.getElementById("show_dish_price").value = "€ " + dishPrice; // Product price (including VAT)
        document.getElementById("show_dish_category").value = dishCategory; // Product category
        document.getElementById("show_when_created").value = dishCreated; // Created at
        document.getElementById("show_created_by").value = dishCreatedBy; // Created by
        document.getElementById("show_discount").value = dishDiscount; // Discount
        document.getElementById("show_status").value = dishStatus; // Status
        document.getElementById("show_dish_desc").value = dishDescription; // Description
        document.getElementById("show_dish_pricevat").value = "€ " + dishPriceVat; // Price excluding VAT
        document.getElementById("show_dish_img").src = dishImage; 

        event.preventDefault();
        // Open the modal
        modal.classList.toggle("open");
        document.body.style.overflowX = "hidden";
    }

    function closeModal() {
        modal.classList.remove("open");
        document.body.style.overflow = "auto";
    }

    openButtons.forEach((button) => {
        button.addEventListener("click", toggleModal);
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", closeModal);
    });

    document.addEventListener("click", function (event) {
        if (modal.classList.contains("open") && !modal.contains(event.target) && !Array.from(openButtons).some(button => button.contains(event.target))) {
            closeModal();
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape" && modal.classList.contains("open")) {
            closeModal();
        }
    });
});

// Select all function inputs
document.addEventListener("DOMContentLoaded", function () {
    const headerCheckbox = document.querySelector(".products-info-header > input");

    if (!headerCheckbox) return;

    headerCheckbox.addEventListener("change", function () {
        const allInputs = document.querySelectorAll(".products-info-listitem > input");

        allInputs.forEach((input) => {
            input.checked = this.checked;
        });
    });
});

// load categories from json dynamically
document.addEventListener("DOMContentLoaded", () => {
    fetch("./js/categories.json")
        .then((response) => {
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.statusText}`);
            }
            return response.json();
        })
        .then((categories) => {
            const categoryList = document.getElementById("category-list");
            if (!categoryList) {
                console.warn("Category list not found");
                return;
            }
            categoryList.innerHTML = categories
                .map(
                    (category) => `
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="${category.image}" alt="${category.name}">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">${category.name}</p>
                    </figcaption>
                </li>
            `
                )
                .join("");
        })
        .catch((error) => {
            console.error("Error loading categories:", error);
            const categoryList = document.getElementById("category-list");
            if (categoryList) {
                categoryList.innerHTML = '<li class="error">Failed to load categories. Please try again later.</li>';
            }
        });
});


// Declare buttons before using them
const bezorgenButton = document.getElementById("bezorgen");
const afhalenButton = document.getElementById("afhalen");

// Default selection
toggleSelection("bezorgen");

function toggleSelection(selected) {
    if (bezorgenButton && afhalenButton) {
        // Set the value of the hidden input based on selection
        const selectedInput = document.getElementById("selectedDelivery");

        if (selected === "bezorgen") {
            bezorgenButton.classList.add("enabled");
            bezorgenButton.classList.remove("disabled");
            afhalenButton.classList.add("disabled");
            afhalenButton.classList.remove("enabled");

            selectedInput.value = "bezorgen"; // Store selected option
        } else if (selected === "afhalen") {
            afhalenButton.classList.add("enabled");
            afhalenButton.classList.remove("disabled");
            bezorgenButton.classList.add("disabled");
            bezorgenButton.classList.remove("enabled");

            selectedInput.value = "afhalen"; // Store selected option
        }
    } else {
        console.warn("Buttons not found: 'bezorgen' or 'afhalen'");
    }
}

// Add event listeners (no need to declare variables again)
if (bezorgenButton) {
    bezorgenButton.addEventListener("click", () => toggleSelection("bezorgen"));
}

if (afhalenButton) {
    afhalenButton.addEventListener("click", () => toggleSelection("afhalen"));
}


// navmenu phone
document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.getElementById("menu-icon");
    const menu = document.getElementById("menu");
    const menuContainer = document.getElementById("menu-container");
    const closeMenu = document.getElementById("close-menu");

    let isOpen = false;

    if (menuIcon && menu) {
        menuIcon.addEventListener("click", function () {
            isOpen = !isOpen;
            menu.classList.toggle("open", isOpen);
            document.body.style.overflow = isOpen ? "hidden" : "auto";
        });
    }

    if (closeMenu && menu) {
        closeMenu.addEventListener("click", function () {
            isOpen = false;
            menu.classList.remove("open");
            document.body.style.overflow = "auto";
        });
    }

    if (menuContainer && menuIcon && menu) {
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
        element.addEventListener("touchstart", (e) => handleTouchStart(e, element), { passive: true });
        element.addEventListener("touchmove", (e) => handleTouchMove(e, element), { passive: true });
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
        window.location.href = "../index.php";
    } else {
        window.location.href = "../index.php";
    }
}


// Check if the element exists before proceeding
document.addEventListener("DOMContentLoaded", function () {
    const valuedInput = document.querySelector(".valued-input");
    if (valuedInput) {
        const defaultValue = valuedInput.value;

        // Listen for the keydown event to prevent deleting
        valuedInput.addEventListener("keydown", function (event) {
            // Check if the key pressed is one that would delete (Backspace, Delete, or any other ways to remove characters)
            if (event.key === "Backspace" || event.key === "Delete") {
                if (valuedInput.value === defaultValue) {
                    event.preventDefault(); // Prevent the keydown event if the input value is the default value
                }
            }
        });
    } else {
        console.warn("Element '.valued-input' not found.");
    }
});

// payment method selection coloring function
document.addEventListener("DOMContentLoaded", function () {
    const paymentMethods = document.querySelectorAll(".paymentmethod");
    const paymentButton = document.querySelector(".payment-button");

    function updatePaymentButtonState() {
        if (!paymentButton) return; // Ensure paymentButton exists

        const selectedMethod = document.querySelector(".paymentmethod.selected");
        if (selectedMethod) {
            paymentButton.classList.add("active");
            paymentButton.disabled = false;
            paymentButton.style.pointerEvents = "auto";
        } else {
            paymentButton.classList.remove("active");
            paymentButton.disabled = true;
            paymentButton.style.pointerEvents = "none";
        }
    }

    function savePaymentMethodToCookie(method) {
        // Save the selected payment method to a cookie
        try {
            document.cookie = `selectedPaymentMethod=${method}; path=/; max-age=31536000`; // 1 year expiry
            console.log("Payment method saved to cookie:", method);
        } catch (error) {
            console.error("Error saving payment method to cookie:", error);
        }
    }

    paymentMethods.forEach((method) => {
        method.addEventListener("click", function () {
            if (this.classList.contains("selected")) {
                this.classList.remove("selected");

                const paymentIcon = this.querySelector(".payment-content i");
                const paymentText = this.querySelector(".payment-content h1");
                const paymentContainerIcon = this.querySelector(".payment-iconcontainer i");

                if (paymentIcon) {
                    paymentIcon.classList.remove("selected");
                    paymentIcon.style.display = "none";
                }
                if (paymentText) paymentText.classList.remove("selected");
                if (paymentContainerIcon) paymentContainerIcon.classList.remove("selected");
            } else {
                paymentMethods.forEach((item) => {
                    item.classList.remove("selected");

                    const paymentIcon = item.querySelector(".payment-content i");
                    const paymentText = item.querySelector(".payment-content h1");
                    const paymentContainerIcon = item.querySelector(".payment-iconcontainer i");

                    if (paymentIcon) {
                        paymentIcon.classList.remove("selected");
                        paymentIcon.style.display = "none";
                    }
                    if (paymentText) paymentText.classList.remove("selected");
                    if (paymentContainerIcon) paymentContainerIcon.classList.remove("selected");
                });

                this.classList.add("selected");

                const paymentIcon = this.querySelector(".payment-content i");
                const paymentText = this.querySelector(".payment-content h1");
                const paymentContainerIcon = this.querySelector(".payment-iconcontainer i");

                if (paymentIcon) {
                    paymentIcon.classList.add("selected");
                    paymentIcon.style.display = "block";
                }
                if (paymentText) paymentText.classList.add("selected");
                if (paymentContainerIcon) paymentContainerIcon.classList.add("selected");
            }

            updatePaymentButtonState();
        });
    });

    if (paymentButton) {
        paymentButton.addEventListener("click", function () {
            const selectedMethod = document.querySelector(".paymentmethod.selected");
            if (selectedMethod) {
                try {
                    // Save the selected payment method to the cookie
                    const methodName = selectedMethod.dataset.method; // assuming you use data-method for payment method identifier
                    savePaymentMethodToCookie(methodName);
                    
                    // Save the order to the database
                    saveOrderToDatabase();
                } catch (error) {
                    console.error("Error processing payment:", error);
                }
            } else {
                console.error("No payment method selected");
            }
        });

        updatePaymentButtonState(); // Initialize button state only if it exists
    }
});


// new function for all popups
function openPopup(containerClass, closeButtonClass, extraCallback = null) {
    const container = document.querySelector(`.${containerClass}`);
    const popup = container?.querySelector(".popup"); // Assuming `.popup` is inside each container
    const closeButton = document.querySelector(`.${closeButtonClass}`);

    if (!container || !closeButton) return;

    container.style.display = "flex"; // Ensure container is visible

    setTimeout(() => {
        popup?.classList.add("open");
    }, 10);

    closeButton.addEventListener("click", function () {
        popup?.classList.remove("open");

        setTimeout(() => {
            container.style.display = "none";
        }, 300); // Matches CSS transition duration
    });

    // If an extra function needs to run when opening the popup
    if (extraCallback) extraCallback();
}
// apart voor popup zodat je in andere fucnties alleen de close aan kan roepen
function closePopup(containerClass, closeButtonClass) {
    const container = document.querySelector(`.${containerClass}`);
    const popup = container?.querySelector(".popup");

    if (!container) return;

    popup?.classList.remove("open");

    setTimeout(() => {
        container.style.display = "none";
    }, 300); // Matches CSS transition duration
}

// Usage for different popups:
function openDeleteDish() {
    const dishStatus = document.getElementById("show_status").value;
    openPopup("usernamecontainer", "close-username", () => permDeleteDishShowText(dishStatus));
}

function openDeleteAddress(addressId) {
    if (!addressId) {
        showCustomMessage("Geen adres geselecteerd.", false);
        return;
    }

    document.getElementById("addressid").value = addressId; // Set hidden input value

    openPopup("usernamecontainer", "close-username");
}

// Veranderen van gegevens
function changeFirstname() {
    const fname = document.querySelector('[name="fname"]').value;
    const calender = document.querySelector(".fullnamecontainer");

    if (fname.trim() !== "") {
        const formData = new FormData();
        formData.append("fname", fname);

        fetch("./controllers/account_controller.php?type=changefname", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json()) 
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true); 
                    calender.classList.remove("open");
                } else {
                    showCustomMessage(data.message, false); 
                    calender.classList.remove("open");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage(data.message, false);
                calender.classList.remove("open");
            });
    } else {
        showCustomMessage(data.message, false);
        calender.classList.remove("open");
    }
}

function changeLastname() {
    const lname = document.querySelector('[name="lname"]').value;
    const calender = document.querySelector(".fullnamecontainer");

    if (lname.trim() !== "") {
        const formData = new FormData();
        formData.append("lname", lname);

        fetch("./controllers/account_controller.php?type=changelname", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json()) 
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true); 
                    calender.classList.remove("open");
                } else {
                    showCustomMessage(data.message, false); 
                    calender.classList.remove("open");
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage(data.message, false);
                calender.classList.remove("open");
            });
    } else {
        showCustomMessage(data.message, false);
        calender.classList.remove("open");
    }
}

function changeUsername() {
    const username = document.querySelector('[name="username"]').value;
    const calender = document.querySelector(".usernamecontainer");

    if (username.trim() !== "") {
        const formData = new FormData();
        formData.append("username", username);

        fetch("./controllers/account_controller.php?type=changeusername", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true); 
                    calender.classList.remove("open");
                } else {
                    showCustomMessage(data.message, false); 
                    calender.classList.remove("open");
                }
            })
            .catch((error) => {
                console.error("Fout bij verzenden bozo:", error);
                showCustomMessage(data.message, false);
                calender.classList.remove("open");
            });
    } else {
        console.error("Fout bij verzenden bozo:", data.message);
        showCustomMessage(data.message, false);
        calender.classList.remove("open");
    }
}

function changeEmail() {
    const email = document.querySelector('[name="email"]').value;
    const calender = document.querySelector(".emailcontainer");

    if (email.trim() !== "") {
        const formData = new FormData();
        formData.append("email", email);

        fetch("./controllers/account_controller.php?type=changeemail", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json()) 
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true); 
                    calender.classList.remove("open");
                } else {
                    console.error("Fout bij verzenden bozo:", data.message);
                    showCustomMessage(data.message, false); 
                    calender.classList.remove("open");
                }
            })
            .catch((error) => {
                console.error("Fout bij verzenden bozo:", error);
                showCustomMessage(data.message, false);
                calender.classList.remove("open");
            });
    } else {
        console.error("Fout bij verzenden bozo:", data.message);
        showCustomMessage(data.message, false);
        calender.classList.remove("open");
    }
}

function changePhone() {
    const phone = document.querySelector('[name="phone"]').value;
    const calender = document.querySelector(".phonecontainer");

    if (phone.trim() !== "") {
        const formData = new FormData();
        formData.append("phone", phone);

        fetch("./controllers/account_controller.php?type=changephone", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json()) 
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true); 
                    calander.classList.remove("open");
                } else {
                    console.error("Fout bij verzenden:", data.message);
                    showCustomMessage(data.message, false); 
                    calender.classList.remove("open");
                }
            })
            .catch((error) => {
                console.error("Fout bij verzenden:", error);
                showCustomMessage(data.message, false);
                calender.classList.remove("open");
            });
    } else {
        console.error("Fout bij verzenden:", data.message);
        showCustomMessage(data.message, false);
        calender.classList.remove("open");
    }
}

function changePassword(event) {
    event.preventDefault(); 
    const calander = document.querySelector(".passwordcontainer");
    const oldPassword = document.getElementById("old-psw").value;
    const newPassword = document.getElementById("new-psw").value;
    const confirmNewPassword = document.getElementById("confirm-new-psw").value;

    const formData = new FormData();
    formData.append("old-psw", oldPassword);
    formData.append("new-psw", newPassword);
    formData.append("confirm-new-psw", confirmNewPassword);

    fetch("./controllers/account_controller.php?type=changepassword", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) 
        .then((data) => {
            if (data.success) {
                showCustomMessage(data.message, true);
                document.querySelector(".gender-form").reset(); 
                calander.classList.remove("open"); 
            } else {
                console.error("Fout bij verzenden bozo:", data.message);
                showCustomMessage(data.message, false); 
                calander.classList.remove("open"); 
            }
        })
        .catch((error) => {
            console.error("Fout bij verzenden:", error);
            showCustomMessage(data.message, false);
            calander.classList.remove("open"); 
        });
}

function changeGender(event) {
    event.preventDefault(); 
    const calender = document.querySelector(".gendercontainer");
    const gender = document.querySelector('input[name="gender"]:checked').value;

    const formData = new FormData();
    formData.append("gender", gender);

    fetch("./controllers/account_controller.php?type=setorchangegender", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) 
        .then((data) => {
            if (data.success) {
                showCustomMessage(data.message, true);
                document.querySelector(".gender-form").reset(); 
                calender.classList.remove("open"); 
            } else {
                console.error("Fout bij verzenden:", data.message);
                showCustomMessage(data.message, false); 
                calender.classList.remove("open"); 
            }
        })
        .catch((error) => {
            console.error("Fout bij verzenden:", error);
            showCustomMessage(data.message, false);
            calender.classList.remove("open"); 
        });
}

function changeBirthdate(event) {
    event.preventDefault(); 
    const calender = document.querySelector(".calendercontainer");
    const birthdate = document.getElementById("birthdate").value;

    const formData = new FormData();
    formData.append("birthdate", birthdate);

    fetch("./controllers/account_controller.php?type=setorchangebirthdate", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showCustomMessage(data.message, true);
                document.querySelector(".birthdate-form").reset(); 
                calender.classList.remove("open"); 
            } else {
                console.error("Fout bij verzenden:", data.message);
                showCustomMessage(data.message, false); 
                calender.classList.remove("open"); 
            }
        })
        .catch((error) => {
            console.error("Fout bij verzenden:", error);
            showCustomMessage(data.message, false);
            calender.classList.remove("open"); 
        });
}

function changeOrAddProfileImg(event) {
    event.preventDefault(); 
    const formData = new FormData();
    const fileInput = document.querySelector("#profile_img"); 
    const calender = document.querySelector(".profileimgcontainer");

    if (!fileInput.files.length) {
        showCustomMessage("Selecteer een afbeelding.", false);
        return false;
    }

    formData.append("profileimg", fileInput.files[0]);

    fetch("./controllers/account_controller.php?type=changeoraddprofileimg", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) 
        .then((data) => {
            if (data.success) {
                showCustomMessage(data.message, true); 
                calender.classList.remove("open");
                setTimeout(() => location.reload(), 1000); 
            } else {
                showCustomMessage(data.message, false); 
                calender.classList.remove("open");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is iets misgegaan.", false);
            calender.classList.remove("open");
        });

    calender.classList.remove("open");
    return false; 
}

// All product handling functions
function permDeleteDishShowText($dish_status) {
    const deleteDishText = document.getElementById("permdel");
    const dishStatus = $dish_status;

    if (dishStatus === "Actief") {
        deleteDishText.textContent = "Weet u zeker dat u dit product wilt de-activeren?";
    } else {
        deleteDishText.textContent = "Weet u zeker dat u dit product permanent wilt verwijderen?";
    }
}

function deleteDish(event) {
    event.preventDefault();
    const dishInput = document.getElementById("show_dish_id");

    if (!dishInput) {
        console.error("Element #show_dish_id not found!");
        return;
    }

    let dishId = dishInput.value.trim(); 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    const formData = new FormData();
    formData.append("dish_id", dishId);

    fetch("../controllers/product_controller.php?type=deletedish", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showCustomMessage(data.message, true);
                setTimeout(() => location.reload(), 2000);
            } else {
                showCustomMessage(data.message, false);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is een fout opgetreden.", false);
        });
}

function addProduct(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData();
    const addproduct = document.querySelector(".addproductcontainer");

    formData.append("dish_name", document.querySelector('[name="dish_name"]').value);
    formData.append("dish_price", document.querySelector('[name="dish_price"]').value);
    formData.append("dish_desc", document.querySelector('[name="dish_desc"]').value);
    formData.append("dish_category", document.querySelector('[name="dish_category"]').value);
    formData.append("restaurant_id", document.querySelector('[name="restaurant_id"]').value);
    formData.append("fullname", document.querySelector('[name="fullname"]').value);

    const fileInput = document.querySelector('[name="dish_img"]');
    if (fileInput.files.length > 0) {
        formData.append("dish_img", fileInput.files[0]);
    }

    fetch("./controllers/product_controller.php?type=addProduct", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) 
        .then((data) => {
            if (data.success) {
                addproduct.classList.remove("open");
                window.location.reload(setTimeout(2000));
                showCustomMessage(data.message, true);
            } else {
                showCustomMessage(data.message, false); 
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is een fout opgetreden.", false);
        });
}

function changeDishName() {
    const dishname = document.querySelector('[name="show_dish_name"]').value;
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishname.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_name", dishname); 
        formData.append("dish_id", dishId); 

        fetch("./controllers/product_controller.php?type=changedishname", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_name"]').value = dishname;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false); 
            });
    } else {
        showCustomMessage("Vul alstublieft een productnaam in.", false);
    }
}

function changeDishDesc() {
    const dishdesc = document.querySelector('[name="show_dish_desc"]').value;
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishdesc.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_desc", dishdesc); 
        formData.append("dish_id", dishId); 

        fetch("./controllers/product_controller.php?type=changedishdesc", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_desc"]').value = dishdesc;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false); 
            });
    } else {
        showCustomMessage("Vul alstublieft een beschrijving in.", false);
    }
}

function changeProductCategory() {
    const dishCategory = document.querySelector('[name="show_dish_category"]').value;
    let dishId = document.getElementById("show_dish_id").value;

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishCategory.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_category", dishCategory);
        formData.append("dish_id", dishId);

        fetch("./controllers/product_controller.php?type=changeproductcategory", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_category"]').value = dishCategory;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false);
            });
    } else {
        showCustomMessage("Vul alstublieft een productcategorie in.", false);
    }
}

function changeDishStatus(event) {
    event.preventDefault();
    const status = document.querySelector('input[name="status"]:checked');
    let dishId = document.getElementById("show_dish_id").value;
    const showNewStatus = document.getElementById("show_status");
    const statuscontainer = document.querySelector(".statuscontainer");

    if (!status) {
        showCustomMessage("Kies een status voor het gerecht.", false);
        return;
    }

    const statusValue = status.value;

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    const formData = new FormData();
    formData.append("status", statusValue); 
    formData.append("dish_id", dishId); 

    // Perform the fetch request
    fetch("./controllers/product_controller.php?type=changedishstatus", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                showCustomMessage(data.message, true);
                statuscontainer.classList.remove("open");
                showNewStatus.value = statusValue;
            } else {
                showCustomMessage(data.message, false);
                calander.classList.remove("open");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is een fout opgetreden.", false); 
            calander.classList.remove("open");
        });
}

function changeDishPrice() {
    let dishprice = document.querySelector('[name="show_dish_price"]').value;
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return;
    }

    if (dishprice.startsWith("€")) {
        dishprice = dishprice.substring(1).trim();
    }

    if (dishprice.trim() !== "") {
        const formData = new FormData();
        formData.append("dish_price", dishprice); 
        formData.append("dish_id", dishId); 

        fetch("./controllers/product_controller.php?type=changedishprice", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    showCustomMessage(data.message, true);
                    document.querySelector('[name="show_dish_price"]').value = dishprice;
                } else {
                    showCustomMessage(data.message, false);
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                showCustomMessage("Er is een fout opgetreden.", false); 
            });
    } else {
        showCustomMessage("Vul alstublieft een prijs in.", false);
    }
}

function changeProductImage(event) {
    event.preventDefault();

    const formData = new FormData();
    const fileInput = document.querySelector('[name="product_image_change"]'); 
    const calender = document.querySelector(".productimagecontainer");
    let dishId = document.getElementById("show_dish_id").value; 

    if (dishId.startsWith("#")) {
        dishId = dishId.substring(1);
    }

    if (dishId.trim() === "") {
        showCustomMessage("Product niet gevonden", false);
        return false;
    }

    if (!fileInput.files.length) {
        showCustomMessage("Geen afbeelding gevonden.", false);
        return false;
    }

    formData.append("productimg", fileInput.files[0]);
    formData.append("dish_id", dishId); 

    fetch("./controllers/product_controller.php?type=changeproductimage", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json()) 
        .then((data) => {
            if (data.success) {
                calender.classList.remove("open");
                showCustomMessage(data.message, true); 
                document.getElementById("show_dish_img").src = URL.createObjectURL(fileInput.files[0]);
            } else {
                showCustomMessage(data.message, false);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is iets misgegaan.", false);
        });

    calender.classList.remove("open");
    return false; 
}

function addNewAddressToUser(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData();

    formData.append("country", document.querySelector('[name="country"]').value);
    formData.append("province", document.querySelector('[name="province"]').value);
    formData.append("city", document.querySelector('[name="city"]').value);
    formData.append("streetname", document.querySelector('[name="streetname"]').value);
    formData.append("housenumber", document.querySelector('[name="housenumber"]').value);
    formData.append("housenumberaddition", document.querySelector('[name="housenumberaddition"]').value);
    formData.append("postalcode", document.querySelector('[name="postalcode"]').value);
    formData.append("addresstype", document.querySelector('[name="addresstype"]').value);

    fetch("./controllers/account_controller.php?type=addaddress", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                closePopup('newaddresscontainer', 'close-newaddress');
                showCustomMessage(data.message, true);
                form.reset();
                setTimeout(() => location.reload(), 2000);
            } else {
                showCustomMessage(data.message, false);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            showCustomMessage("Er is een fout opgetreden.", false);
        });
}

function deleteAddress(event) {
    event.preventDefault();

    const addressId = document.getElementById("addressid").value;

    if (!addressId) {
        alert("Geen adres geselecteerd.");
        return;
    }

    fetch("./controllers/account_controller.php?type=deleteaddress", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `address_id=${encodeURIComponent(addressId)}`,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showCustomMessage(data.message, true);

                setTimeout(() => location.reload(), 2000);
            } else {
                showCustomMessage(data.message, false);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            showCustomMessage("Er is een fout opgetreden.", false);
        });

    closePopup("usernamecontainer", "close-username"); 
}

// Filters functionality
document.addEventListener("DOMContentLoaded", function () {
    const filterSelect = document.getElementById("status-filter");
    const dishesList = document.getElementById("dishes-list");
    if (dishesList) {
        const noItemsMessage = document.createElement("p");
        noItemsMessage.textContent = "Geen items gevonden";
        noItemsMessage.style.display = "none";
        dishesList.appendChild(noItemsMessage);

        filterSelect.addEventListener("change", function () {
            const listItems = dishesList.querySelectorAll(".product-info-listitem");
            const selectedValue = filterSelect.value;
            let itemsFound = false;

            listItems.forEach((item) => {
                const statusText = item.querySelector("p:nth-child(8)").textContent.trim(); // Get status text (Actief/Non-actief)
                if (selectedValue === "all" || 
                    (selectedValue === "active" && statusText === "Actief") ||
                    (selectedValue === "notactive" && statusText === "Non-actief")) {
                    item.style.display = "grid"; // Show matching items
                    itemsFound = true;
                } else {
                    item.style.display = "none"; // Hide non-matching items
                }
            });

            noItemsMessage.style.display = itemsFound ? "none" : "block";
        });
    }
});


// Add to cart functionality:
document.addEventListener("DOMContentLoaded", function () {
    renderCart(); // pagina laad dan cart rendered
});

function addToCart(dishId, event, dishName, dishPrice, dishImgSrc) {
    event.preventDefault();

    let cart = getCartFromCookies();

    // Check if the item already exists in the cart
    const existingItem = cart.find(item => item.id === dishId);

    if (existingItem) {
        // Item exists, increment quantity
        existingItem.quantity = (existingItem.quantity || 1) + 1; // Increment or initialize to 1
    } else {
        // Item doesn't exist, add it to the cart
        const dish = {
            id: dishId,
            name: dishName,
            price: dishPrice,
            imgSrc: dishImgSrc,
            quantity: 1 // Initialize quantity to 1
        };
        cart.push(dish);
    }

    setCartToCookies(cart);
    showCustomMessage("Toegevoegd aan de winkelwagen.", true);
    console.log("Cart Cookie Value: ", getCartFromCookies());
}

// Helper function to get the cart from cookies
function getCartFromCookies() {
    let cart = [];
    // Get all cookies
    let cookies = document.cookie.split(";");

    // Loop through cookies to find the cart cookie
    for (let i = 0; i < cookies.length; i++) {
        let cookie = cookies[i].trim();
        if (cookie.startsWith("cart=")) {
            // Parse the cookie value (assumed to be a JSON string)
            cart = JSON.parse(cookie.substring("cart=".length));
            break;
        }
    }

    return cart;
}

// Helper function to set the cart in cookies
function setCartToCookies(cart) {
    let cartString = JSON.stringify(cart);

    // Set the cart cookie with an expiration of 30 days
    let expirationDate = new Date();
    expirationDate.setTime(expirationDate.getTime() + (30 * 24 * 60 * 60 * 1000)); // met 30 dagen verloopt
    document.cookie = "cart=" + cartString + "; expires=" + expirationDate.toUTCString() + "; path=/";

    renderCart(); // Refresh the UI dynamically
}

// Function to update cart quantity
function updateCartQuantity(event) {
    const itemId = event.target.getAttribute("data-id");
    let newQuantity = parseInt(event.target.value);
    
    let cart = getCartFromCookies();
    cart = cart.map(item => 
        item.id == itemId ? { ...item, quantity: newQuantity } : item
    );

    setCartToCookies(cart); // Update cookies and UI
}

// Function to remove item from cart dynamically
function removeFromCart(event) {
    const itemId = event.target.getAttribute("data-id");

    let cart = getCartFromCookies();
    cart = cart.filter(item => item.id != itemId);

    setCartToCookies(cart); // Update cookies and UI
    showCustomMessage("Item verwijderd uit de winkelwagen.", false);
}

// showing the cart items from cookies
function renderCart() {
    const cartList = document.querySelector(".cart-list");
    let cartData = getCartFromCookies();
    const subtotalElement = document.querySelector(".cart-footercontainer:nth-child(1) p:nth-child(2)"); // Subtotal element
    const totalElement = document.querySelector(".cart-footercontainer:nth-child(4) p:nth-child(2), .totalprice-order"); // Total element
    const checkoutButtonPrice = document.querySelector(".cart-footerbutton p"); // Checkout button price

    if (cartList) { 
        cartList.innerHTML = "";
    }

    if (!cartData || cartData.length === 0) {
        // Check if elements exist before trying to update textContent
        if (subtotalElement) subtotalElement.textContent = "€ 0.00";
        if (totalElement) totalElement.textContent = "€ 0.00";
        if (checkoutButtonPrice) checkoutButtonPrice.textContent = "(€ 0.00)";
        
        if (cartList) cartList.innerHTML = "<p>Winkelwagen leeg.</p>";
        return;
    }

    let subtotal = 0;

    cartData.forEach(item => {
        const cartItem = document.createElement("li");
        cartItem.classList.add("cart-item");
        cartItem.innerHTML = `
            <div class="cart-itemcontainer">
                <div class="cart-itemdelete">
                    <i class="fas fa-xmark delete-item" data-id="${item.id}"></i>
                </div>
                <figure class="cart-itemfigure">
                    <img src="${item.imgSrc}" alt="${item.name}">
                </figure>
            </div>
            <div class="cart-itemcontent">
                <h1>${item.name}</h1>
                <p>€ ${parseFloat(item.price).toFixed(2)}</p>
            </div>
            <ul class="cart-extras">
                <li>Kaassaus</li>
            </ul>
            <div class="cart-notebutton">
                <button class="cart-note">Opmerking</button>
            </div>
            <div class="cart-itembuttons">
                <input type="number" class="cart-quantity" value="${item.quantity || 1}" min="1" data-id="${item.id}">
            </div>
        `;
        
        if (cartList) {
            cartList.appendChild(cartItem);
        }

        // Calculate subtotal
        subtotal += item.price * (item.quantity || 1);
    });

    const deliveryCost = 0; // Placeholder for delivery cost (to be added later)
    const total = subtotal + deliveryCost;

    // Check if elements exist before setting text content
    if (subtotalElement) subtotalElement.textContent = "€ " + subtotal.toFixed(2);
    if (totalElement) totalElement.textContent = "€ " + total.toFixed(2);
    if (checkoutButtonPrice) checkoutButtonPrice.textContent = "(€ " + total.toFixed(2) + ")";

    const totalPriceElements = document.querySelectorAll(".totalprice-order");
    totalPriceElements.forEach(element => {
        element.textContent = `(€ ${total.toFixed(2)})`;
    });

    document.querySelectorAll(".cart-quantity").forEach(input => {
        input.addEventListener("change", updateCartQuantity);
    });

    document.querySelectorAll(".delete-item").forEach(button => {
        button.addEventListener("click", removeFromCart);
    });
}


// Cookie handling for ordering flow
function saveOrderToCookie(event) {
    event.preventDefault(); 

    const fname = document.getElementById("fname").value;
    const lname = document.getElementById("lname").value;
    const email = document.getElementById("email").value;
    const phone = document.getElementById("phone").value;
    const address = document.getElementById("searchBargoogle").value;
    const ordernote = document.getElementById("ordernote").value;
    const deliveryMethod = document.getElementById("selectedDelivery").value;
    const restaurantId = document.getElementById("restaurantId").value;

    if (!fname || !lname || !email || !phone || !address || !deliveryMethod) {
        showCustomMessage("Niet alle velden zijn ingevuld.", false);
        return false; 
    }

    const orderData = {
        fname: fname,
        lname: lname,
        email: email,
        phone: phone,
        address: address,
        ordernote: ordernote,
        deliveryMethod: deliveryMethod,
        restaurantId: restaurantId
    };

    document.cookie = `orderData=${JSON.stringify(orderData)}; max-age=${7 * 24 * 60 * 60}; path=/`;

    window.location.href = `./payment.php?id=${restaurantId}`;
    return true; 
}

// helper voor het ophalen van een cookienaam
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// dunction to save the order to the database
function saveOrderToDatabase() {
    // Retrieve data from cookies or other sources
    const orderData = getCookie("orderData");
    const selectedPaymentMethod = getCookie("selectedPaymentMethod");
    const cartData = getCartFromCookies(); // Assuming this function fetches the cart data

    // Check if necessary data exists
    if (!orderData || !selectedPaymentMethod || !cartData) {
        showCustomMessage("Orderdata ontbreekt.", false); // Show an error if no data is available
        return;
    }

    // Prepare the order data for sending
    const orderPayload = {
        orderData: JSON.parse(orderData),
        selectedPaymentMethod: selectedPaymentMethod,
        cart: cartData
    };

    console.log(orderPayload); // debuglog payload

    // Make the POST request to process the order
    fetch('./controllers/order_controller.php?type=processorder', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(orderPayload) 
    })
    .then(response => response.json()) // Parse the JSON response
    .then(data => {
        if (data.success) {
            // If the order is processed successfully
            showCustomMessage("Bestelling succesvol geplaatst!", true); // GREEN message
            // Clear the cookies
            document.cookie = "orderData=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "selectedPaymentMethod=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            document.cookie = "cart=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
            setTimeout(() => {
                window.location.href = "./orders.php";
            }, 2000); 
        } else {
            // Handle the error, showing the message from backend
            showCustomMessage(data.message || "Er is een fout opgetreden.", false); // RED message
        }
    })
    .catch(error => {
        console.error("Error:", error);
        showCustomMessage("Er is een probleem met het plaatsen van de bestelling.", false); // RED message for any other errors
    });
}
