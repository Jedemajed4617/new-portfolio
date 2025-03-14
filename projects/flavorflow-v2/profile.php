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
        <div class="profileimg popup">
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
                        <div class="profile-listitem-container active">
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
            <div class="calendercontainer">
                <div class="calender popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-calender"></i>
                    </header>
                    <form action="./controllers/account_controller.php?type=setorchangebirthdate" method="POST" class="birthdate-form">
                        <h2>Selecteer jouw geboortedatum</h2>

                        <input type="date" name="birthdate" id="birthdate" required>

                        <button type="submit">Save Birthdate</button>
                    </form>
                </div>
            </div>
            <div class="gendercontainer">
                <div class="gender popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-gender"></i>
                    </header>
                    <form onsubmit="return changeGender(event);" class="gender-form">
                        <h2>Selecteer jouw geslacht</h2>

                        <label>
                            <input type="radio" name="gender" value="male" required> Man
                        </label>

                        <label>
                            <input type="radio" name="gender" value="female" required> Vrouw
                        </label>

                        <button type="submit">Opslaan</button>
                    </form>
                </div>
            </div>
            <div class="fullnamecontainer">
                <div class="fullname popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-fullname"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw voor of achternaam</h2>
                        <label for="" class="order-phone seper">
                            <input style="text-transform: capitalize;" class="order-input" type="text" name="fname" id="fname" value="<?php echo $fname; ?>" required>
                            <p class="label">Voornaam</p>
                            <i onclick="changeFirstname();" class="fas fa-save profile-icon"></i>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="text-transform: capitalize;" type="text" name="lname" id="lname" value="<?php echo $lname; ?>" required>
                            <p class="label">Achternaam</p>
                            <i onclick="changeLastname();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="passwordcontainer">
                <div class="password popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-password"></i>
                    </header>
                    <form onsubmit="return changePassword(event);" class="gender-form" autocomplete="on">
                        <h2>Verander uw wachtwoord</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="password" name="old-psw" id="old-psw" autocomplete="current-password" required>
                            <p class="label">Oude wachtwoord</p>
                        </label>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="password" name="new-psw" id="new-psw" autocomplete="new-password" required>
                            <p class="label">Nieuw wachtwoord</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="password" name="confirm-new-psw" id="confirm-new-psw" autocomplete="new-password" required>
                            <p class="label">Herhaal nieuwe wachtwoord</p>
                        </label>
                        <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>" autocomplete="username">
                        <button type="submit">Verander wachtwoord</button>
                    </form>
                </div>
            </div>
            <div class="usernamecontainer">
                <div class="username popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-username"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw voor of achternaam</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="text" name="username" id="username" value="<?php echo $username; ?>" required>
                            <p class="label">Gebruikersnaam</p>
                            <i onclick="changeUsername();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="emailcontainer">
                <div class="email popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-email"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw e-mail</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="text" name="email" id="email" value="<?php echo $email; ?>" required>
                            <p class="label">E-mail</p>
                            <i onclick="changeEmail();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="phonecontainer">
                <div class="phone popup">
                    <header class="calenderheader">
                        <i class="fas fa-times close-phone"></i>
                    </header>
                    <form onsubmit="return changeName(event);" class="gender-form">
                        <h2>Verander uw telefoonnummer</h2>
                        <label for="" class="order-phone seper">
                            <input class="order-input" type="text" name="phone" id="phone" value="<?php echo $phone; ?>" required>
                            <p class="label">Telefoonnummer</p>
                            <i onclick="changePhone();" class="fas fa-save profile-icon"></i>
                        </label>
                    </form>
                </div>
            </div>
            <div class="profile-info">
                <div class="profile-headerheading">
                    <h1>Mijn Profiel</h1>
                    <p>Bekijk of bewerk uw gegevens.</p>
                </div>
                <ul class="profile-info-list">
                    <li class="profile-info-listitem">
                        <h3>Volledige naam</h3>
                        <p style="text-transform: capitalize;"><?php echo $fullname; ?></p>
                        <a onclick="openPopup('fullnamecontainer', 'close-fullname');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Gebruikersnaam</h3>
                        <p><?php echo $username; ?></p>
                        <a onclick="openPopup('usernamecontainer', 'close-username');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>E-mailadres</h3>
                        <p><?php echo $email; ?></p>
                        <a onclick="openPopup('emailcontainer', 'close-email');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Wachtwoord</h3>
                        <p>********</p>
                        <a onclick="openPopup('passwordcontainer', 'close-password');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Geboortedatum</h3>
                        <p><?php echo $birthdate; ?></p>
                        <a onclick="openPopup('calendercontainer', 'close-calender');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Telefoonnummer</h3>
                        <p><?php echo $phone; ?></p>
                        <a onclick="openPopup('phonecontainer', 'close-phone');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Geslacht</h3>
                        <p><?php echo $gender; ?></p>
                        <a onclick="openPopup('gendercontainer', 'close-gender');">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Bezorgadres</h3>
                        <p><?php echo !empty($standardaddress) ? $standardaddress : 'Geen adres gevonden'; ?></p>
                        <a href="./address.php">Veranderen</a>
                    </li>
                </ul>
            </div>
            <div class="profile-settings">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Talen & Datums</h1>
                        <p>Kies welke taal of datumformaat u wilt gebruiken.</p>
                    </div>
                </header>
                <ul class="profile-info-list">
                    <li class="profile-info-listitem">
                        <h3>Taal</h3>
                        <p>Nederlands</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Datum formaat</h3>
                        <p>DD/MM/YYYY</p>
                        <a href="">Veranderen</a>
                    </li>
                    <li class="profile-info-listitem">
                        <h3>Automatische tijdzone</h3>
                        <input class="input-slider" type="checkbox" name="" id="" checked>
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