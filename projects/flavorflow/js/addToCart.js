// loadDishes
var previousCategoryButton = null;

function loadDishes(categoryButton, category) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("dishes-container").innerHTML = this.responseText;

            // Reset styles for the previously selected category button
            if (previousCategoryButton) {
                previousCategoryButton.style.backgroundColor = "";
                previousCategoryButton.style.color = "";
            }

            // Apply styles for the selected category button
            categoryButton.style.backgroundColor = "#0075b7";
            categoryButton.style.color = "white";

            // Update the reference to the currently selected category button
            previousCategoryButton = categoryButton;
        }
    };
    xmlhttp.open("GET", "controllers/product_controller.php?type=get_dishes&category=" + category, true);
    xmlhttp.send();
}

// Error handling:
function animateErrorMessage(message) {
    const errorMsg = document.querySelector('.errormsg');
    const errorMsgHeading = document.querySelector('.errormsgheading');

    errorMsgHeading.innerHTML = message;
    errorMsg.style.top = '2%';

    setTimeout(function () {
        errorMsg.style.top = '-100px';
    }, 3000);
}

function displayItemAdded() {
    animateErrorMessage(" successfully added to the cart!");
}

// Add to cart
function handleCategoryItemClick(element) {
    var name = element.getAttribute('data-name');
    var price = element.getAttribute('data-price');
    var cents = element.getAttribute('data-cents');

    // Create an object to hold the data
    var data = {
        name: name,
        price: price,
        cents: cents
    };

    // Send the data to the PHP script using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'controllers/product_controller.php?type=add_to_cart', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            updateCart(name);
        }
    };
    xhr.send(JSON.stringify(data));
}

function updateCart(name) {
    // Fetch the updated cart data using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'controllers/product_controller.php?type=update_cart', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Update the cart container with the new content
            document.getElementById('cart-container').innerHTML = xhr.responseText;
            animateErrorMessage(name + " successfully added to the cart!");
            updateTotalPrice()
        }
    };
    xhr.send();
}

// Remove items
function handleRemoveItem(button) {
    const itemName = button.parentNode.querySelector('.order-title').textContent;
    const itemContainer = button.parentNode; // Get the parent container of the item
    removeItemFromCart(itemName, itemContainer);
}

function removeItemFromCart(itemName, itemContainer) {
    // Send AJAX request to remove_item.php
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'controllers/product_controller.php?type=remove_item', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                itemContainer.remove();
                updateTotalPrice();
                animateErrorMessage(itemName + " successfully removed from the cart!");
            } else {
                console.error('Error removing item from cart');
            }
        }
    };
    const data = JSON.stringify({ name: itemName });
    xhr.send(data);
}

function updateTotalPrice() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'controllers/product_controller.php?type=update_totalprice', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const totalPriceElement = document.getElementById('total-price');
            if (totalPriceElement) {
                totalPriceElement.textContent = 'Total Price: €' + xhr.responseText;
            }
        }
    };
    xhr.send();
} 

function displayFood() {
    if (document.querySelector) {
        const startpagePhone = document.querySelector(".startpage-phone");
        const sidenavContainer = document.querySelector(".homepage-sidenavcontainer");
        const mealsContainer = document.querySelector(".homepage-mealscontent");

        if (startpagePhone && sidenavContainer) {
            startpagePhone.style.display = "none";
            sidenavContainer.style.display = "flex";
            mealsContainer.style.display = "flex";
        } else {
            console.error("One or more elements not found in the DOM.");
        }
    } else {
        console.error("querySelector is not supported by the browser.");
    }
}