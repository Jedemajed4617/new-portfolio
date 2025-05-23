<?php
    session_start();

    require_once './db_conn.php';
    include('./functions/functions.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="./css/restaurants.css" />
    <link rel="stylesheet" href="./css/notification-error.css" />
    <link rel="stylesheet" href="./css/password-change.css" />
    <link rel="stylesheet" href="./css/login.css" />
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon" />
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
                <div class="logo">
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
                    <figure class="flag">
                        <img class="flag-img" src="./img/dutchflag.png" alt="Image of the dutch flag">
                    </figure>
                    <div class="account-icon">
                        <a class="icon-container" href="./login.php"><i class="fas fa-user icon"></i></a>
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
        </div>
        <div class="header-contentcontainer">
            <div class="header-content">
                <div class="header-inputsection">
                    <div class="header-inputsectionHeading">
                        <h1>Ontdek de mogelijkheden.</h1>
                        <p>Zoek hier uw adres en begin met bestellen.</p>
                    </div>
                    <div class="header-inputcontainer">
                        <input type="text" class="header-input" placeholder="Search for restaurants" required>
                        <button class="header-button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="header-linecontainer">
                    <figure class="middle-line"></figure>
                </div>
                <div class="header-imgsection">
                    <figure class="input-imgheading">
                        <img class="input-img" src="./img/hamburger-sketch.jpg" alt="foto input">
                    </figure>
                </div>
            </div>
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

    <div class="promise-container">
        <section class="promise-section">
            <header class="category-header">
                <h1 class="category-heading">Onze garanties</h1>
                <p class="category-subheading">Onze garanties voor jou op een rij.</p>
            </header>
            <ul class="promise-list">
                <li class="promise">
                    <figure class="promise-figure">
                        <i class="fas fa-clock promise-icon"></i>
                    </figure>
                    <figcaption class="promise-caption">
                        <p class="promise-text">24/7 Service</p>
                    </figcaption>
                </li>
                <li class="promise">
                    <figure class="promise-figure">
                        <i class="fas fa-shipping-fast promise-icon"></i>
                    </figure>
                    <figcaption class="promise-caption">
                        <p class="promise-text">Snelle bezorging</p>
                    </figcaption>
                </li>           
                <li class="promise">
                    <figure class="promise-figure">
                        <i class="fas fa-money-bill-wave promise-icon"></i>
                    </figure>
                    <figcaption class="promise-caption">
                        <p class="promise-text">Achteraf betalen</p>
                    </figcaption>
                </li>
                <li class="promise">
                    <figure class="promise-figure">
                        <i class="fas fa-lock promise-icon"></i>
                    </figure>
                    <figcaption class="promise-caption">
                        <p class="promise-text">Veilig betalen</p>
                    </figcaption>
                </li>
            </ul>
        </section>
    </div>

    <div class="footer-container">
        <br>
        <br>
        <div class="navbar-underlinecontainer">
            <figure class="navbar-underline"></figure>
        </div>
        <footer class="footer">
            <aside class="footer-aside">
                <header class="footer-aside-header">
                    <h1>Flavorflow.</h1>
                </header>
                <div class="footer-aside-content">
                    <ul class="footer-aside-list">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="restaurant.php">Restaurants</a></li>
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