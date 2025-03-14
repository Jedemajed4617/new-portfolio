<?php
session_start();

require_once './db_conn.php';
include('./functions/functions.php');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $fullname = $_SESSION['fname'] . " " . $_SESSION['lname'];
    $rank = $_SESSION['user_type'];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $birthdate = $_SESSION['date_of_birth'];
    $phone = $_SESSION['phone'];
    $gender = $_SESSION['gender'];
}

if (isset($_GET['id'])) {
    $restaurant_id = intval($_GET['id']);
} else {
    die("Restaurant ID is missing.");
}
$restaurant_img_src = getRestaurantLogo($mysqli, $restaurant_id);
$restaurant_name = getRestaurantName($mysqli, $restaurant_id);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/restaurant.css">
    <link rel="stylesheet" href="./css/cart.css">
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon">
</head>

<body>
    <div id="message-container" class="message-container"></div>
    <nav class="menu" id="menu">
        <div class="menu-container">
            <header class="menu-header">
                <h1>Flavorflow.</h1>
                <i class="fa-solid fa-xmark close-menu" id="close-menu"></i>
            </header>
            <div class="menu-content">
                <ul>
                    <li><a href="./index.php" class="menu-link">Home</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="./products.php" class="menu-link">Restaurants</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="#" class="menu-link">About</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="#" class="menu-link">F.A.Q</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="#" class="menu-link">Klantenservice</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="#" class="menu-link">Algemene voorwaarden</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="#" class="menu-link">Privacybeleid</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="#" class="menu-link">Cookieverklaring</a><i class="fas fa-arrow-right"></i></li>
                </ul>
                <footer class="menu-footercontainer">
                    <ul class="menu-footer">
                        <?php
                        if (isset($_SESSION['username'])) {
                            echo "<li><a href='./account.php' class='menu-link'>Account</a><i class='fas fa-arrow-right'></i></li>";
                            echo "<li><a href='./logout.php' class='menu-link'>Logout</a><i class='fas fa-arrow-right'></i></li>";
                        } else {
                            echo "<li><a href='./login.php' class='menu-link'>Login</a><i class='fas fa-arrow-right'></i></li>";
                            echo "<li><a href='./register.php' class='menu-link'>Register</a><i class='fas fa-arrow-right'></i></li>";
                        }
                        ?>
                        <li><a href="#" class="menu-link">Nederlands</a><i class="fas fa-arrow-right"></i></li>
                    </ul>
                </footer>
            </div>
        </div>
    </nav>
    <header class="header">
        <div class="navbar-container">
            <nav class="navbar">
                <div onclick="goBack();" class="logo">
                    <i class="fas fa-chevron-left"></i>
                    <h1>Flavorflow.</h1>
                </div>
                <ul class="nav-links" style="display: none;">
                    <li><a href="./index.php">Home</a></li>
                    <li>|</li>
                    <li><a href="#">About</a></li>
                    <li>|</li>
                    <li><a href="./products.php">Restaurants</a></li>
                    <li>|</li>
                    <li><a href="#">F.A.Q</a></li>
                </ul>
                <div class="account">
                    <figure class="flag">
                        <img class="flag-img" src="./img/dutchflag.png" alt="Image of the dutch flag">
                    </figure>
                    <div class="account-icon">
                        <a class="icon-container" href="login.php"><i class="fas fa-user icon"></i></a>
                    </div>
                    <div class="account-bars" id="menu-icon">
                        <figure class="bar"></figure>
                        <figure class="bar"></figure>
                        <figure class="bar"></figure>
                    </div>
                </div>
            </nav>
        </div>
        <div class="navbar-underlinecontainer">
            <figure class="navbar-underline"></figure>
        </div>
        <div class="header-imgcontainer">
            <figure class="header-imgheading">
                <img class="header-img" src="./img/banner-food.webp" alt="foto header">
            </figure>
            <figure class="header-reslogocontainer">
                <img class="header-reslogo" src="<?php echo $restaurant_img_src; ?>" alt="logo restaurant">
            </figure>
        </div>
    </header>

    <div class="navbar-underlinecontainer">
        <figure class="navbar-underline"></figure>
    </div>

    <div class="category-container">
        <section class="category-section">
            <header class="category-header">
                <h1 class="category-heading">Meest bekeken categorieën: </h1>
                <p class="category-subheading">Bekijk ons meest bezochte categorieën: </p>
            </header>
            <ul class="category-list">
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="./img/productimg/grocery-basket.jpg" alt="">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">Boodschappen</p>
                    </figcaption>
                </li>
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="./img/productimg/burger.jpg" alt="">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">Burgers</p>
                    </figcaption>
                </li>
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="./img/productimg/snacks.jpg" alt="">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">Snacks</p>
                    </figcaption>
                </li>
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="./img/productimg/sushi.jpg" alt="">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">Sushi</p>
                    </figcaption>
                </li>
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="./img/productimg/friedchicken.avif" alt="">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">Kip</p>
                    </figcaption>
                </li>
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="./img/productimg/veggies.jpg" alt="">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">Vers</p>
                    </figcaption>
                </li>
                <li class="category">
                    <figure class="category-figure">
                        <img class="category-img" src="./img/productimg/doner.avif" alt="">
                    </figure>
                    <figcaption class="category-caption">
                        <p class="category-text">Döner</p>
                    </figcaption>
                </li>
            </ul>
            <div class="category-dots">
                <figure class="dot active"></figure>
                <figure class="dot"></figure>
                <figure class="dot"></figure>
            </div>
            <div class="category-linecontainer">
                <figure class="category-line"></figure>
            </div>
        </section>
    </div>
    <br>
    <br>
    <div class="navbar-underlinecontainer">
        <figure class="navbar-underline"></figure>
    </div>

    <div class="cartcontainer">
        <div class="cart">
            <header class="cart-title">
                <h1 style="user-select: none;">Flavorflow.</h1>
                <p style="color: lightgrey; font-size: 1.5rem; user-select: none;">Winkelwagen <?php echo $restaurant_name; ?></p>
            </header>
            <div class="cart-closecontainer">
                <i class="fas fa-xmark close-cart"></i>
            </div>
            <div class="cart-content">
                <ul class="cart-list">
                    <!-- Cart items will be added here dynamically by js -->
                </ul>
                <footer class="cart-footercontainer">
                    <div class="cart-footer">
                        <div class="cart-footercontainer">
                            <p>Subtotaal</p>
                            <p>€ 0,00</p>
                        </div>
                        <div class="cart-footercontainer">
                            <p>Bezorgkosten</p>
                            <p>€ 0,00</p>
                        </div>
                        <figure>
                            <!-- Seperator line -->
                        </figure>
                        <div class="cart-footercontainer">
                            <p>Totaal</p>
                            <p>€ 0,00</p>
                        </div>
                        <div class="cart-footerbutton">
                            <a href="./order.php?id=<?php echo $restaurant_id; ?>">Afrekenen <p>( € 0,00)</p></a>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    <div class="restaurant-container">
        <main class="restaurant">
            <section class="restaurant-heading">
                <div class="restaurant-headercontainer">
                    <div class="restaurant-header">
                        <h1><?php echo $restaurant_name; ?></h1>
                    </div>
                    <div class="restaurant-info">
                        <ul class="restaurant-infolist">
                            <li>
                                <i class="fas fa-star"></i>
                                <p>4,2 (23) reviews</p>
                            </li>
                            <li>
                                <i class="fas fa-bag-shopping"></i>
                                <p>Min. € 15,00</p>
                            </li>
                        </ul>
                        <ul class="restaurant-infolist">
                            <li>
                                <i class="fas fa-clock"></i>
                                <p>15-35 min. levertijd</p>
                            </li>
                            <li>
                                <i class="fas fa-truck"></i>
                                <p>€ 0,00 - € 3,50 bezorgkosten</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="restaurant-buttons">
                    <div class="product-search">
                        <input type="text" placeholder="Zoek naar gerechten">
                        <button><i class="fas fa-search"></i></button>
                    </div>
                    <div class="restaurant-basket" onclick="openCart();">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                </div>
            </section>
            <section class="restaurant-slider">
                <div class="restaurant-sliderheader">
                    <h1>Populair bij ons:</h1>
                </div>
                <div class="restaurant-slidercontainer">
                    <ul class="restaurant-sliderlist">
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/friedchicken.avif" alt="">
                            </figure>
                            <p>Crispy Chicken</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/pizza.jpg" alt="">
                            </figure>
                            <p>Pizza Margherita</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/burger.jpg" alt="">
                            </figure>
                            <p>Cheeseburger</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/sushiroll.jpeg" alt="">
                            </figure>
                            <p>Sushi Roll 6st.</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/berehap.png" alt="">
                            </figure>
                            <p>Berehap Pinda</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/patat.webp" alt="">
                            </figure>
                            <p>Patat 4p.</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/redbull.jpg" alt="">
                            </figure>
                            <p>Redbull 250ml</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/spareribs.jpeg" alt="">
                            </figure>
                            <p>Spare-ribs 750gr.</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/grill.webp" alt="">
                            </figure>
                            <p>Mixed Grill</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                        <li class="restaurant-slideritem">
                            <figure class="restaurant-sliderfigure">
                                <img src="./img/productimg/broodjedoner.jpg" alt="">
                            </figure>
                            <p>Broodje Doner</p>
                            <button><i class="fas fa-circle-plus"></i></button>
                        </li>
                    </ul>
                </div>
            </section>
            <ul class="products-itemlist">
                <?php
                $dishes = getDishesByRestaurantId($mysqli, $restaurant_id); // Fetch dishes from the database
                foreach ($dishes as $dish) {
                    // Retrieve dish details
                    $dish_name = $dish['dish_name'];
                    $dish_price = $dish['dish_price'];
                    $dish_img_src = !empty($dish['dish_img_src']) ? $dish['dish_img_src'] : './img/logo-res.jpg'; // Default image if not set

                    // Create HTML for each dish
                    echo "<li class='products-item'>";
                    echo "<figure class='products-imgcontainer'>";
                    echo "<img src='{$dish_img_src}' alt='{$dish_name}'>"; // Dish image
                    echo "</figure>";
                    echo "<div class='products-contentcontainer'>";
                    echo "<div class='products-content'>";
                    echo "<h1>{$dish_name}</h1>"; // Dish name
                    echo "<div class='products-rating'>";
                    echo "<p>Vanaf € {$dish_price}</p>"; // Dish price
                    echo "</div>";
                    echo "</div>";
                    echo "<div class='products-buttoncontainer'>";
                    echo "<a onclick='addToCart({$dish['dish_id']}, event, \"{$dish['dish_name']}\", \"{$dish['dish_price']}\", \"{$dish['dish_img_src']}\"); return false;' class='products-button'><i class='fas fa-circle-plus'></i></a>";
                    echo "</div>";
                    echo "</div>";
                    echo "</li>";
                }
                ?>
            </ul>
        </main>
    </div>

    <div class="footer-container">
        <br>
        <br>
        <div class="footer-copyright">
            <figure class="copyright-line"></figure>
            <p class="footer-copyrighttext">© 2025 Flavorflow. Alle rechten voorbehouden.</p>
        </div>
    </div>
    <script>
        function openCart() {
            const cart = document.querySelector(".cartcontainer");
            const closeCartButton = document.querySelector(".close-cart");

            cart.classList.add("open");
            document.body.style.overflow = "hidden";

            closeCartButton.addEventListener("click", function() {
                cart.classList.remove("open");
                document.body.style.overflow = "auto";
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
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
                item.id == itemId ? {
                    ...item,
                    quantity: newQuantity
                } : item
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
            const checkoutButtonPrice = document.querySelector(".cart-footerbutton p"); //checkout button price

            cartList.innerHTML = "";

            if (!cartData || cartData.length === 0) {
                cartList.innerHTML = "<p>Winkelwagen leeg.</p>";
                subtotalElement.textContent = "€ 0.00";
                totalElement.textContent = "€ 0.00";
                checkoutButtonPrice.textContent = "(€ 0.00)";
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
                cartList.appendChild(cartItem);

                // Calculate subtotal
                subtotal += item.price * (item.quantity || 1);
            });

            const deliveryCost = 0; // Placeholder for delivery cost (to be added later)
            const total = subtotal + deliveryCost;

            subtotalElement.textContent = "€ " + subtotal.toFixed(2);
            totalElement.textContent = "€ " + total.toFixed(2);
            checkoutButtonPrice.textContent = "(€ " + total.toFixed(2) + ")";

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
    </script>
</body>

</html>