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
    <link rel="stylesheet" href="./css/payment.css">
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
                <div onclick="window.location.href = './order.php?id=<?php echo $restaurant_id; ?>'" class="logo">
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

    <main class="paymentcontainer">
        <header class="payment-header">
            <h1>Betaalmethode</h1>
            <p>Selecteer een betaalmethode om door te gaan</p>
        </header>
        <ul class="payment-list">
            <div class="payment-methods">
                <li class="paymentmethod" data-method="iDeal">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-brands fa-ideal"></i>
                    </div>
                    <div class="payment-content">
                        <h1>IDEAL</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
                <li class="paymentmethod" data-method="PayPal">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-brands fa-paypal"></i>
                    </div>
                    <div class="payment-content">
                        <h1>PayPal</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
            </div>
            <div class="payment-methods">
                <li class="paymentmethod" data-method="Creditcard">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <div class="payment-content">
                        <h1>Creditcard</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
                <li class="paymentmethod" data-method="Contant">
                    <div class="payment-iconcontainer">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <div class="payment-content">
                        <h1>Contant</h1>
                        <i class="fas fa-circle-check"></i>
                    </div>
                </li>
            </div>
        </ul>
        <footer class="payment-buttoncontainer">
            <p>Betaal veilig via ons platform <i class="fas fa-circle-check"></i></p>
            <button class="payment-button">Verdergaan</button>
        </footer>
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
</body>
</html>