<?php
require_once './db_conn.php';
session_start();

include('./functions/functions.php');

if (!isset($_SESSION["username"])) {
    $_SESSION['must_login'] = true;
    header("location: login.php");
    exit;
}

if ($_SESSION["offline"] === "1") {
    $_SESSION['account_offline'] = true;
    header("location: login.php");
    exit;
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$username = $_SESSION['username'];
$fullname = $_SESSION['fname'] . " " . $_SESSION['lname'];
$rank = $_SESSION['user_type'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$phone = $_SESSION['phone'];

$birthdate = isset($_SESSION['date_of_birth']) ? date("d/m/Y", strtotime($_SESSION['date_of_birth'])) : 'Niet ingesteld';
$gender = isset($_SESSION['gender']) ? ($_SESSION['gender'] == 'male' ? 'Man' : ($_SESSION['gender'] == 'female' ? 'Vrouw' : 'Niet ingesteld')) : 'Niet ingesteld';

$profileimg = isset($_SESSION['profile_img_src']) ? "./img/profileimg/" . $_SESSION['profile_img_src'] : './img/logo-res.jpg';

$restaurant_id = getRestaurantOwnerIDByUsername($mysqli, $username);
$restaurant_img_src = getRestaurantLogo($mysqli, $restaurant_id);
$restaurant_name = getRestaurantName($mysqli, $restaurant_id);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./css/index.css" />
    <link rel="stylesheet" href="./css/order.css" />
    <link rel="stylesheet" href="./css/profile.css" />
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
                <div onclick="goBack();" class="logo">
                    <i class="fas fa-chevron-left"></i>
                    <h1>Flavorflow.</h1>
                </div>
                <form class="navbar-logoutcontainer" action="./controllers/account_controller.php?type=logout" method="POST">
                    <button class="navbar-logoutbutton" type="submit">Uitloggen</button>
                </form>
            </nav>
            <div class="profile-imgcontainer">
                <?php if (empty($_SESSION['profile_img_src'])): ?>
                    <div class="profile-img">
                        <i class="fas fa-user profile-edit-icon"></i>
                        <i onclick="openPopup('profileimgcontainer', 'close-profileimg');" class="fas fa-camera edit-profile-button"></i>
                    </div>
                <?php else: ?>
                    <figure class="profile-img">
                        <img src="<?php echo $profileimg;; ?>" alt="Profile image">
                        <i onclick="openPopup('profileimgcontainer', 'close-profileimg');" class="fas fa-camera edit-profile-button"></i>
                    </figure>
                <?php endif; ?>
            </div>
        </div>
        <div class="navbar-underlinecontainer">
            <figure class="navbar-underline" style="width: 100%;"></figure>
        </div>
    </header>

    <div class="profileimgcontainer">
        <div class="profileimg">
            <header class="calenderheader">
                <i class="fas fa-times close-profileimg"></i>
            </header>
            <form onsubmit="return changeOrAddProfileImg(event);" class="gender-form">
                <h2>Verander uw profielfoto</h2>
                <?php if (!empty($_SESSION['profile_img_src'])): ?>
                    <img src="<?php echo $profileimg; ?>" alt="Profielfoto" style="max-width: 100%; height: auto; margin-bottom: 10px;">
                <?php endif; ?>
                <input type="file" name="profile_img" id="profile_img" accept="image/*" required>
                <button type="submit">Update</button>
            </form>
        </div>
    </div>

    <main class="profile">
        <aside class="profile-navigation">
            <div class="profile-container">
                <header class="profile-header">
                    <h1>Welkom <p style="text-transform: capitalize;"><?php echo $fname; ?></p></h1>
                </header>
                <ul class="profile-list">
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-user"></i>
                            <a href="./profile.php">Mijn Profiel</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container active">
                            <i class="fas fa-bag-shopping"></i>
                            <a href="./orders.php">Mijn Bestellingen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-bell"></i>
                            <a href="./notifications.php">Mijn Meldingen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-location-dot"></i>
                            <a href="./address.php">Mijn Adressen</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-tags"></i>
                            <a href="./stamps.php">Stempelkaart</a>
                        </div>
                    </li>
                </ul>
            </div>
            <!-- Alleen een restauranteigenaar kan dit zien: -->
            <?php
            if ($rank == "res_owner" && !is_null($restaurant_id)) {
            ?>
                <div class="profile-container admin">
                    <header class="profile-header">
                        <h1>Mijn Restaurant</h1>
                    </header>
                    <ul class="profile-list">
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-chart-line"></i>
                                <a href="./restaurant-orderoverview.php?id=<?php echo $restaurant_id; ?>">Order overzicht</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-list-ul"></i>
                                <a href="./restaurant-products.php?id=<?php echo $restaurant_id; ?>">Producten</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-gear"></i>
                                <a href="./restaurant-settings.php?id=<?php echo $restaurant_id; ?>">Instellingen</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
                echo "";
            }
            ?>
            <!-- Alleen een admin kan dit zien: -->
            <?php
            if ($rank == "admin") {
            ?>
                <div class="profile-container admin">
                    <header class="profile-header">
                        <h1>Mijn Dashboard</h1>
                    </header>
                    <ul class="profile-list">
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-chart-line"></i>
                                <a href="./adminorders.php">Alle orders</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container">
                                <i class="fas fa-list-ul"></i>
                                <a href="./adminrestaurants.php">Restaurants</a>
                            </div>
                        </li>
                    </ul>
                </div>
            <?php
            } else {
                echo "";
            }
            ?>
        </aside>
        <section class="profile-content">
            <div class="profile-info">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Mijn Bestellingen</h1>
                        <p>Deze informatie is alleen zichtbaar voor jou.</p>
                    </div>
                </header>
                <ul class="order-info-headers">
                    <li class="order-info-header">
                        <b>Ordernr</b>
                    </li>
                    <li class="order-info-header">
                        <b>Restaurant</b>
                    </li>
                    <li class="order-info-header">
                        <b>Categorie</b>
                    </li>
                    <li class="order-info-header">
                        <b>Status</b>
                    </li>
                    <li class="order-info-header">
                        <b>Prijs</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <li class="order-info-listitem">
                        <p>#0004</p>
                        <p>Eetcafe De Kwikkel</p>
                        <p>Pizza, Pasta</p>
                        <p>Onderweg</p>
                        <p>12.34</p>
                        <a href="">Meer info</a>
                    </li>
                    <li class="order-info-listitem">
                        <p>#0003</p>
                        <p>Bij Oost</p>
                        <p>Sushirolls</p>
                        <p>Afgeleverd</p>
                        <p>12.34</p>
                        <a href="">Meer info</a>
                    </li>
                    <li class="order-info-listitem">
                        <p>#0002</p>
                        <p>New York Pizza</p>
                        <p>Pizza</p>
                        <p>Afgeleverd</p>
                        <p>12.34</p>
                        <a href="">Meer info</a>
                    </li>
                    <li class="order-info-listitem">
                        <p>#0001</p>
                        <p>Rumours</p>
                        <p>Noodles, Biefstuk</p>
                        <p>Afgeleverd</p>
                        <p>12.34</p>
                        <a href="">Meer info</a>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <main class="phone-profile">
        <div class="phone-profile-headerbewerk">
            <i onclick="goBack();" class="fas fa-chevron-left"></i>
            <div class="phone-profile-contentcontainer">
                <div class="phone-profile-imagecontainer">
                    <figure class="phone-profile-image">
                        <img src="./img/person.jpg" alt="">
                    </figure>
                </div>
                <header class="phone-profile-headeredit">
                    <h1>Mijn Orders</h1>
                    <div class="phone-profile-headereditcontainer">
                        <select class="order-filter" style="height: 2.2rem !important; font-size: 1rem; padding: 0; gap: 0; width: 7rem;" name="status-filter" id="status-filter">
                            <option class="order-filteritem" value="all">Alle</option>
                            <option class="order-filteritem" value="delivered">Afgeleverd</option>
                            <option class="order-filteritem" value="pending">Onderweg</option>
                            <option class="order-filteritem" value="cancelled">Geannuleerd</option>
                        </select>
                    </div>
                </header>
                <ul class="phone-info-headers">
                    <li class="phone-info-header">
                        <b>ID</b>
                    </li>
                    <li class="phone-info-header">
                        <b>Categorie</b>
                    </li>
                    <li class="phone-info-header">
                        <b>Restaurant</b>
                    </li>
                    <li class="phone-info-header">
                        <b>Datum</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <li class="phone-info-listitem">
                        <p>Order</p>
                        <p>Eetcafe de Kwikkel</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>Reclame</p>
                        <p>Rumours</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>Reclame</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>#0003</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>#0002</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                    <li class="phone-info-listitem">
                        <p>#0001</p>
                        <p>New York pizza</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                    </li>
                </ul>
            </div>
        </div>
    </main>

    <div class="footer-container">
        <div class="footer-copyright" style="width: 100%;">
            <figure class="copyright-line"></figure>
            <p class="footer-copyrighttext">© 2025 Flavorflow. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>

</html>