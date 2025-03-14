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
$user_id =  getUserIdByUsername($mysqli, $username); // idk wrm dit nodig is maar op een of andere reden pakt ie de user niet zonder deze functie

$fulladdress = getUserAddress($mysqli, $user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/restaurant.css">
    <link rel="stylesheet" href="./css/cart.css">
    <link rel="stylesheet" href="./css/order.css">
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon">
</head>

<body>
    <nav class="menu" id="menu">
        <div class="menu-container">
            <header class="menu-header">
                <h1>Flavorflow.</h1>
                <i class="fa-solid fa-xmark close-menu" id="close-menu"></i>
            </header>
            <div class="menu-content">
                <ul>
                    <li><a href="./index.php" class="menu-link">Home</a><i class="fas fa-arrow-right"></i></li>
                    <li><a href="./restaurants.php" class="menu-link">Restaurants</a><i class="fas fa-arrow-right"></i></li>
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
                <div onclick="window.location.href = './restaurant.php?id=<?php echo $restaurant_id; ?>'" class="logo">
                    <i class="fas fa-chevron-left"></i>
                    <h1>Flavorflow.</h1>
                </div>
                <ul class="nav-links">
                    <li><a href="./index.php">Home</a></li>
                    <li>|</li>
                    <li><a href="#">About</a></li>
                    <li>|</li>
                    <li><a href="./restaurants.php">Restaurants</a></li>
                    <li>|</li>
                    <li><a href="#">F.A.Q</a></li>
                </ul>
                <div class="account">
                    <figure>
                        <div class="restaurant-basket" onclick="openCart();">
                            <i class="fa-solid fa-basket-shopping"></i>
                        </div>
                    </figure>
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
                <img class="header-reslogo" src="./img/logo-res.jpg" alt="">
            </figure>
        </div>
    </header>

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

    <main class="ordercontainer">
        <form class="order" onsubmit="return saveOrderToCookie(event);">
            <div class="order-form">
                <header class="order-header">
                    <h1>Vul hier uw gegevens in.</h1>
                </header>
                <label class="order-names" for="">
                    <div class="order-name">
                        <input class="order-input" style="text-transform: capitalize;" type="text" name="fname" id="fname" placeholder="Jan" value="<?php echo isset($_SESSION['fname']) ? $fname : ''; ?>" required>
                        <p class="label">Voornaam</p>
                    </div>
                    <div class="order-name">
                        <input class="order-input" style="text-transform: capitalize;" type="text" name="lname" id="lname" placeholder="Jansen" value="<?php echo isset($_SESSION['lname']) ? $lname : ''; ?>" required>
                        <p class="label">Achternaam</p>
                    </div>
                </label>
                <label for="" class="order-email">
                    <input class="order-input" style="text-transform: lowercase;" type="text" name="email" id="email" placeholder="janjansen@voorbeeld.nl" value="<?php echo isset($_SESSION['email']) ? $email : ''; ?>" required>
                    <p class="label">E-mail</p>
                </label>
                <label for="" class="order-phone">
                    <input class="order-input valued-input" type="text" name="phone" id="phone" value="<?php echo isset($_SESSION['phone']) ? $phone : ''; ?>" required>
                    <p class="label">Telefoon</p>
                </label>
                <label for="" class="order-address">
                    <input class="order-input" type="text" id="searchBargoogle" placeholder="Zoek uw adres..." value="<?php echo isset($fulladdress) ? $fulladdress : ''; ?>" required>
                    <ul id="customDatalist" class="hidden"></ul>
                </label>
            </div>
            <input type="hidden" id="selectedDelivery" name="deliveryMethod" value="">
            <input type="hidden" name="restaurantId" id="restaurantId" value="<?php echo $restaurant_id; ?>">
            <div class="order-form">
                <label for="" class="order-delivery">
                    <div class="order-deliverycontainer" id="bezorgen">
                        <button class="order-deliverybutton">Bezorgen</button>
                        <i class="fas fa-circle-check check"></i>
                    </div>
                    <div class="order-seperator">
                        <figure class="line"></figure>
                        <p class="order-seperatortext">OF</p>
                        <figure class="line"></figure>
                    </div>
                    <div class="order-deliverycontainer" id="afhalen">
                        <button class="order-deliverybutton">Afhalen</button>
                        <i class="fas fa-circle-check check"></i>
                    </div>
                </label>
                <figure class="line"></figure>
                <div class="order-notecontainer">
                    <textarea class="order-note" name="ordernote" id="ordernote" rows="10" placeholder="Laat hier een bericht achter voor de bezorger"></textarea>
                    <p class="label">Opmerking voor bezorger</p>
                </div>
                <button type="submit" class="order-submit">Betaalmethode selecteren <p class="totalprice-order"> ( € 0,00)</p></a>
            </div>
        </form>
    </main>

    <div class="footer-container">
        <footer class="footer">
            <aside class="footer-aside">
                <header class="footer-aside-header">
                    <h1>Flavorflow.</h1>
                </header>
                <div class="footer-aside-content">
                    <ul class="footer-aside-list">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="restaurant.php">products</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="account.php">Account</a></li>
                        <li><a href="faq.php">F.A.Q</a></li>
                    </ul>
                    <ul class="footer-aside-list">
                        <li><a href="klantenservice.php">Klantenservice</a></li>
                        <li><a href="werkenbij.php">Werken bij</a></li>
                        <li><a href="algemenevoorwaarden.php">Algemene voorwaarden</a></li>
                        <li><a href="privacystatement.php">Privacy statement</a></li>
                        <li><a href="cookieverklaring.php">Cookieverklaring</a></li>
                    </ul>
                </div>
            </aside>
            <ul class="footer-links">
                <li class="footer-links-item">
                    <header class="footer-links-header">
                        <h1>Eten</h1>
                    </header>
                    <div class="footer-links-content">
                        <ul class="footer-links-sublist">
                            <li><a href="#">Eten</a></li>
                            <li><a href="#">Pizza</a></li>
                            <li><a href="#">Sushi</a></li>
                            <li><a href="#">Mexicaans</a></li>
                            <li><a href="#">Vegan</a></li>
                        </ul>
                        <ul class="footer-links-sublist">
                            <li><a href="#">Poke-bowl</a></li>
                            <li><a href="#">Roti</a></li>
                            <li><a href="#">Spare-ribs</a></li>
                            <li><a href="#">Thais</a></li>
                            <li><a href="#">Chinees</a></li>
                        </ul>
                        <ul class="footer-links-sublist">
                            <li><a href="#">Broodjes</a></li>
                            <li><a href="#">Grieks</a></li>
                            <li><a href="#">Vietnamees</a></li>
                            <li><a href="#">Argentijns</a></li>
                            <li><a href="#">Nederlands</a></li>
                        </ul>
                    </div>
                </li>
                <li class="footer-links-item">
                    <header class="footer-links-header">
                        <h1>Ontdek</h1>
                    </header>
                    <div class="footer-links-content">
                        <ul class="footer-links-sublist">
                            <li><a href="#">Utrecht</a></li>
                            <li><a href="#">Amsterdam</a></li>
                            <li><a href="#">Den-Haag</a></li>
                            <li><a href="#">Rotterdam</a></li>
                            <li><a href="#">Groningen</a></li>
                        </ul>
                        <ul class="footer-links-sublist">
                            <li><a href="#">Cadeaukaarten</a></li>
                            <li><a href="#">Spaaracties</a></li>
                            <li><a href="#">Bezorger worden</a></li>
                            <li><a href="#">Laatste trends</a></li>
                            <li><a href="#">Populair</a></li>
                        </ul>
                        <ul class="footer-links-sublist">
                            <li><a href="#">Ontbijt</a></li>
                            <li><a href="#">Tussendoor</a></li>
                            <li><a href="#">Lunch</a></li>
                            <li><a href="#">Diner</a></li>
                            <li><a href="#">Dessert</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </footer>
        <br>
        <div class="marketing-container">
            <ul class="footer-marketing">
                <li class="footer-marketing-input">
                    <header class="footer-marketing-input-header">
                        <h1>Stay Connected.</h1>
                        <p>Meld je aan samen met 7.000 anderen voor de laatste updates</p>
                    </header>
                    <div class="footer-marketing-input-container">
                        <input type="text" placeholder="Email" required>
                        <button><i class="fas fa-search"></i></button>
                    </div>
                </li>
                <li class="footer-marketing-socials">
                    <header class="footer-marketing-socials-header">
                        <h1>Of volg ons:</h1>
                    </header>
                    <div class="footer-socials-iconcontainer">
                        <a href=""><i class="fab fa-facebook socialicon"></i></a>
                        <a href=""><i class="fab fa-instagram socialicon"></i></a>
                        <a href=""><i class="fab fa-twitter socialicon"></i></a>
                        <a href=""><i class="fab fa-tiktok socialicon"></i></a>
                    </div>
                </li>
            </ul>
        </div>
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