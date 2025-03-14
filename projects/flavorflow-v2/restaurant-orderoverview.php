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

if ($rank != "res_owner" || is_null($restaurant_id)) {
    header("location: profile.php");
    exit;
}

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
    <link rel="stylesheet" href="./css/admin-modal.css" />
    <link rel="stylesheet" href="./css/password-change.css" />
    <link rel="stylesheet" href="./css/login.css" />
    <script src="./js/functions.js" defer></script>
    <script src="./js/main.js" defer></script>
    <title>Flavorflow - De beste online bestel-app</title>
    <link rel="shortcut icon" href="./img/F-logo.png" type="image/x-icon" />
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

    <div class="moreinfocontainer">
        <div class="moreinfo">
            <header class="moreinfo-header">
                <h1>Gegevens bestelling</h1>
                <i class="fas fa-times close-moreinfo"></i>
            </header>
            <div class="moreinfo-content">
                <aside class="moreinfo-aside">
                    <figure class="moreinfo-figure">
                        <img src="./img/map.jpg" alt="">
                    </figure>
                </aside>
                <ul class="moreinfo-list">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="fullname" id="fullname" value="text" required>
                            <p class="label">Voornaam & Achternaam</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="user" id="user" value="text" required>
                            <p class="label">Gebruikersnaam</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="email" id="email" value="text" required>
                            <p class="label">E-mail</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="dateofbirth" id="dateofbirth" value="text" required>
                            <p class="label">Geboortedatum</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="orderid" id="orderid" value="text" required>
                            <p class="label">Order-ID</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="resname" id="resname" value="text" required>
                            <p class="label">Naam Restaurant</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="orderdate" id="orderdate" value="text" required>
                            <p class="label">Datum & tijd</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: green !important;" type="text" value="text" name="deliverystatus" id="deliverystatus" required>
                            <p class="label">Status bezorging</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="useradres" id="useradres" value="text" required>
                            <p class="label">Adres</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="paymethod" id="paymethod" value="text" required>
                            <p class="label">Betaalmethode</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="deliverynote" id="deliverynote" value="text" required>
                            <p class="label">Opmerking voor bezorger</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="foodnote" id="foodnote" value="text" required>
                            <p class="label">Opmerking voor eten</p>
                        </label>
                    </li>
                </ul>
            </div>
            <footer class="moreinfo-footer">
                <ul class="moreinfo-footerlist">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="bill" id="bill" value="text" required>
                            <p class="label">Download factuur</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="exportexcel" id="exportexcel" value="text" required>
                            <p class="label">Exporteer naar excel</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="priceincl" id="priceincl" value="text" required>
                            <p class="label">Prijs incl.</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="priceexcl" id="priceexcl" value="text" required>
                            <p class="label">Prijs excl.</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: orange;" type="text" name="paystatus" id="paystatus" value="text" required>
                            <p class="label">Status betaling</p>
                        </label>
                    </li>
                </ul>
            </footer>
        </div>
    </div>

    <!-- Website: -->

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
                    <h1>Welkom <p style="text-transform: capitalize;"><?php echo $fname; ?></p>
                    </h1>
                </header>
                <ul class="profile-list">
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
                            <i class="fas fa-user"></i>
                            <a href="./profile.php">Mijn Profiel</a>
                        </div>
                    </li>
                    <li class="profile-listitem">
                        <div class="profile-listitem-container">
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
                            <div class="profile-listitem-container active">
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
                            <div class="profile-listitem-container active">
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
            <span class="adminnotvisiblemsg">Pagina's niet beschikbaar voor telefoon! <small>Open de website op een tablet of pc of ga verder door de navigatie te klikken</small></span>
            <div class="profile-info admindisplaynoneby1000px">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Order overzicht</h1>
                        <p>Alle orders op een rij</p>
                    </div>
                    <ul class="order-filters">
                        <li class="searchbar">
                            <input type="text" name="search" id="search" placeholder="Zoeken naar orders" />
                            <i class="fas fa-search inputicon"></i>
                        </li>
                        <li class="refreshcontainer">
                            <button class="refresh"><i class="fas fa-refresh"></i></button>
                        </li>
                        <li class="order-filtercontainer">
                            <select class="order-filter" name="status-filter" id="status-filter">
                                <option class="order-filteritem" value="all">Alle</option>
                                <option class="order-filteritem" value="delivered">Afgeleverd</option>
                                <option class="order-filteritem" value="pending">Onderweg</option>
                                <option class="order-filteritem" value="cancelled">Geannuleerd</option>
                            </select>
                        </li>
                    </ul>
                </header>
                <ul class="res-info-headers">
                    <li class="res-info-header">
                        <b>ID</b>
                    </li>
                    <li class="res-info-header">
                        <b>Datum</b>
                    </li>
                    <li class="res-info-header">
                        <b>Naam</b>
                    </li>
                    <li class="res-info-header">
                        <b>Status</b>
                    </li>
                    <li class="res-info-header">
                        <b>Adres</b>
                    </li>
                    <li class="res-info-header">
                        <b>Bedrag</b>
                    </li>
                </ul>
                <ul class="profile-info-list">
                    <li class="res-info-listitem">
                        <p>#0006</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0005</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0004</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0003</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0002</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="res-info-listitem">
                        <p>#0001</p>
                        <p>22/02/2025 <small>Om 15:13</small></p>
                        <p>Jan</p>
                        <p>Afgeleverd</p>
                        <p>Kruistraat 14, Amsterdam</p>
                        <p>€ 37,98</p>
                        <a href="">Veranderen</a>
                    </li>
                </ul>
            </div>
        </section>
    </main>

    <main class="phone-profile">
        <header class="phone-profile-header">
            <i class="fas fa-chevron-left"></i>
            <h1>Mijn Profiel</h1>
            <i onclick="goBack();" class="fas fa-gear"></i>
        </header>
        <section class="phone-profile-info">
            <ul class="phone-profile-info-list">
                <li class="phone-profile-info-listitem">
                    <figure class="phone-profile-info-figure">
                        <img src="<?php echo $profileimg; ?>" alt="">
                        <div class="phone-profile-info-figureicon" onclick="openImgChanger();">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </figure>
                </li>
                <li class="phone-profile-info-listitem">
                    <b><?php echo $fullname; ?></b>
                    <p><?php echo $email; ?></p>
                    <button onclick="window.location.href = './editprofile.php'">Bewerk profiel</button>
                </li>
            </ul>
        </section>
        <ul class="phone-profile-navigation">
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-bag-shopping"></i>
                    <a href="./orders.php">Mijn Bestellingen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-bell"></i>
                    <a href="./notifications.php">Mijn Meldingen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-location-pin"></i>
                    <a href="./address.php">Mijn Adressen</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
            <li class="phone-profile-navigation-item">
                <div class="phone-profile-itemcontent">
                    <i class="fas fa-tags"></i>
                    <a href="./stamps.php">Stempelkaart</a>
                </div>
                <i class="fas fa-arrow-right"></i>
            </li>
        </ul>
        <br>
        <form class="navbar-logoutcontainer" action="./controllers/account_controller.php?type=logout" method="POST">
            <button class="navbar-logoutbutton" type="submit">Uitloggen</button>
        </form>
    </main>

    <div class="footer-container">
        <div class="footer-copyright" style="width: 100%;">
            <figure class="copyright-line"></figure>
            <p class="footer-copyrighttext">© 2025 Flavorflow. Alle rechten voorbehouden.</p>
        </div>
    </div>
</body>

</html>