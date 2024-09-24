<?php
require_once("db_conn.php");
include("./functions/functions.php");

session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- oncontextmenu="return false" -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorflow - Order now</title>
    <link rel="stylesheet" href="./css/main.css">
    <script src="./js/main.js"></script>
    <script src="./js/addToCart.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDxh3OVtp5e10zqzdz3W23reZ99rsxZCmU&libraries=places"></script>
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
</head>

<div class="errormsg">
    <p class="errormsgheading"></p>
</div>

<div class="checkzip">
    <div class="checkzipcontainer">
        <div class="checkzipcontainer2">
            <div class="checkzipimgcontainer"></div>
            <form id="checkZipForm" class="checkzipform">
                <div class="checkzipheadingcontainer">
                    <h1>FlavowFlow.</h1>
                    <p>Check if your adress is available for delivery!</p>
                </div>
                <div class="checkzipinputs">
                    <div class="checkzipinputcontainer">
                        <p>Zip-code:</p>
                        <input placeholder="Zip-code" id="zipCodeInput" class="checkzipinput" type="text">
                    </div>
                    <div class="checkzipinputcontainer">
                        <p>Street Number:</p>
                        <input placeholder="Street number" id="streetNumberInput" class="checkzipinput " type="text">
                    </div>
                </div>
                <div class="checkzipbuttoncontainer">
                    <div class="checkzipbuttoncontainer2">
                        <button id="checkAvailabilityButton" class="checkzipbutton" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<body>
    <nav class="nav-container">
        <div class="nav-category">
            <p>Categorys:</p>
        </div>
        <div class="nav-imgcontainer">
            <a class="nav-img" href="home.php">FlavorFlow</a>
            <a class="admin" href="./admin_login.php">.</a>
        </div>
        <div class="nav-category">
            <p>Order summary:</p>
        </div>
    </nav>

    <div class="web-content">
        <div class="homepage-sidenavcontainer">
            <ul class="homepage-sidenav">
                <?php
                // Fetch distinct categories from the dishes table
                $sql = "SELECT DISTINCT category FROM dishes";
                $result = $mysqli->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<li class="homepage-navitems"><button onclick="loadDishes(this, \'' . $row["category"] . '\')">' . $row["category"] . '</button></li>';
                    }
                } else {
                    echo "0 categories found";
                }
                ?>
            </ul>
        </div>
        <div class="homepage-mealscontent">
            <ul id="dishes-container" class="homepage-mealscontainer">
                <p style="text-align: center; font-size: 2rem;">Press any category to start ordering.</p>
            </ul>
        </div>
        <div class="order-container">
            <ul class="order-summarycontainer">
                <li id="cart-container" class="order-summary">
                    <?php
                    // Initialize $totalPrice variable
                    $totalPrice = 0;

                    // Check if the cart session variable is set
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        // Loop through each item in the cart
                        foreach ($_SESSION['cart'] as $item) {
                            // Add the price of each item to the total price
                            $totalPrice += ($item['price'] + ($item['cents'] / 100)) * $item['quantity'];
                            echo '<div class="order-basket">';
                            echo '<p class="order-amount">' . $item['quantity'] . 'x</p>';
                            echo '<p class="order-title">' . $item['name'] . '</p>';
                            echo '<p class="order-price">€' . $item['price'] . ',' . '<small>' . $item['cents'] . '</small></p>';
                            echo '<button onclick="handleRemoveItem(this)" class="order-remove">X</button>';
                            echo '</div>';
                        }
                    } else {
                        // If the cart is empty, display a message
                        echo '<p style="font-size: 1.4rem; text-align: center;">Your cart is empty...</p>';
                    }
                    ?>
                </li>
                <li class="order-button">
                    <p id="total-price" class="order-buttontext">
                        Total Price: €
                        <?php echo number_format($totalPrice, 2) ?>
                    </p>
                    <button>Checkout</button>
                </li>
            </ul>
        </div>
        <div class="startpage-phone">
            <div class="startpage-headingcontainer">
                <p class="startpage-heading">What would you like to order?</p>
            </div>
            <div class="order-categoriescontainer">
                <div class="order-category">
                    <p class="order-categoryheading">Food:</p>
                    <button onclick="displayFood()" id="foodButton" class="order-categorybutton" type="button" value="food">
                        <i class="fa-solid fa-burger order-categoryicon"></i>
                    </button>
                </div>
                <div class="order-category">
                    <p class="order-categoryheading">Drinks:</p>
                    <button onclick="displayDrinks()" id="drinksButton" class="order-categorybutton" type="button" value="drinks">
                        <i class="fa-solid fa-champagne-glasses order-categoryicon"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer-container">
        <ul class="footer-itemcontainer">
            <li class="footer-item">
                <a class="footer-itemlink" href="home.php">
                    <i class="fa-solid fa-house footer-itemicon"></i>
                    <p class="footer-itemtext">Start</p>
                </a>
            </li>
            <li class="footer-item">
                <a class="footer-itemlink" onclick="displayFood()">
                    <i class="fa-solid fa-burger footer-itemicon"></i>
                    <p class="footer-itemtext">Food</p>
                </a>
            </li>
            <li class="footer-item">
                <a class="footer-itemlink" href="">
                    <i class="fa-solid fa-champagne-glasses footer-itemicon"></i>
                    <p class="footer-itemtext">Drinks</p>
                </a>
            </li>
            <li class="footer-item">
                <a class="footer-itemlink" href="orderpage.php">
                    <i class="fa-solid fa-basket-shopping footer-itemicon"></i>
                    <p class="footer-itemtext">Order</p>
                </a>
            </li>
            <li class="footer-item">
                <a class="footer-itemlink" href="profile.php">
                    <i class="fa-solid fa-user footer-itemicon"></i>
                    <p class="footer-itemtext">Account</p>
                </a>
            </li>
        </ul>
    </footer>
    <div class="powered-container">
        <p class="powered-text">Powered by: Flavorflow.app</p>
    </div>
</body>

</html>