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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/restaurants.css">
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
            <ul class="category-list" id="category-list"></ul>
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

    <div class="restaurants-container">
        <main class="restaurants">
            <header class="restaurants-header">
                <div class="restaurants-header-container">
                    <div class="restaurants-header-iconcontainer">
                        <i class="fas fa-list" id="open-filter"></i>
                    </div>
                    <h1>9 Beschikbaar</h1>
                </div>
                <div class="restaurants-search">
                    <input type="text" placeholder="Zoeken" required>
                    <button><i class="fas fa-search"></i></button>
                </div>
                <div class="filter-container">
                    <button class="filter-button">Beste match</button>
                    <button class="filter-button-active" onclick="toggleDropdown()">
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-links" href="#">Option 1</a>
                        <a class="dropdown-links" href="#">Option 2</a>
                        <a class="dropdown-links" href="#">Option 3</a>
                    </div>
                </div>                
            </header>
            <div class="restaurant-content">
                <aside class="restaurants-aside" id="restaurants-aside">
                    <ul class="restaurants-aside-list">
                        <button><p>Nu geopend</p><input class="input-slider" type="checkbox" name="" id=""></button>
                        <button><p>Nieuw</p><input class="input-slider" type="checkbox" name="" id=""></button>
                        <button><p>Gratis bezorging</p><input class="input-slider" type="checkbox" name="" id=""></button>
                    </ul>
                    <div class="restaurants-aside-filter">
                        <header class="restaurants-aside-header">
                            <h1>Min. bestelbedrag</h1>
                        </header>
                        <ul class="restaurants-aside-list">
                            <button><input class="restaurant-inputs" type="checkbox" id="all"><p>Toon alles (9)</p></button>
                            <button><input class="restaurant-inputs" type="checkbox" id="less10"><p>€ 10,00 of minder (2)</p></button>
                            <button><input class="restaurant-inputs" type="checkbox" id="less15"><p>€ 15,00 of minder (5)</p></button>
                            <button><input class="restaurant-inputs" type="checkbox" id="less25"><p>€ 25,00 of minder (3)</p></button>
                        </ul>
                    </div>
                    <div class="restaurants-aside-filter">
                        <header class="restaurants-aside-header">
                            <h1>Dieetwens</h1>
                        </header>
                        <ul class="restaurants-aside-list">
                            <button><input type="checkbox" id="all"><p>Halal</p></button>
                            <button><input type="checkbox" id="less10"><p>Vegan</p></button>
                            <button><input type="checkbox" id="less15"><p>Vegatarisch</p></button>
                            <button><input type="checkbox" id="less25"><p>Lactose-vrij</p></button>
                            <button><input type="checkbox" id="less25"><p>Noten-vrij</p></button>
                        </ul>
                    </div>
                    <div class="restaurants-aside-filter">
                        <header class="restaurants-aside-header">
                            <h1>Andere</h1>
                        </header>
                        <ul class="restaurants-aside-list">
                            <button><input type="checkbox" id="all"><p>Aanbieding</p></button>
                            <button><input type="checkbox" id="less10"><p>Stempelkaart</p></button>
                        </ul>
                    </div>
                </aside>
                <section class="restaurants-section">
                    <ul class="restaurants-list">
                        <?php
                            $query = "SELECT restaurant_id, restaurant_name, restaurant_logo_src FROM restaurants";
                            $result = mysqli_query($mysqli, $query);

                            while ($row = mysqli_fetch_assoc($result)) {
                                $logo_src = $row['restaurant_logo_src'] ? $row['restaurant_logo_src'] : './img/logo-res.jpg';
                                echo '<li class="restaurants-item">';
                                echo '    <figure class="restaurants-imgcontainer">';
                                echo '        <img src="' . $logo_src . '" alt="">';
                                echo '    </figure>';
                                echo '    <div class="restaurants-contentcontainer">';
                                echo '        <div class="restaurants-content">';
                                echo '            <h1>' . $row['restaurant_name'] . '</h1>';
                                echo '            <div class="restaurants-rating">';
                                echo '                <i class="fas fa-star"></i>';
                                echo '                <p>4,2 (23) reviews</p>';
                                echo '            </div>';
                                echo '            <div class="restaurants-deliverytime">';
                                echo '                <i class="fas fa-clock"></i>';
                                echo '                <p>15-35m gem. levertijd</p>';
                                echo '            </div>';
                                echo '        </div>';
                                echo '        <div class="restaurants-buttoncontainer">';
                                echo '            <a href="./restaurant.php?id=' . $row['restaurant_id'] . '" class="restaurants-button"><i class="fas fa-chevron-right"></i></a>';
                                echo '        </div>';
                                echo '    </div>';
                                echo '</li>';
                            }
                        ?>
                    </ul>
                </section>
            </div>
        </main>
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