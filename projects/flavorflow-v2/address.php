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
$user_id =  getUserIdByUsername($mysqli, $username); // idk wrm dit nodig is maar op een of andere reden pakt ie de user niet zonder deze functie

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
                        <i onclick="openImgChanger();" class="fas fa-camera edit-profile-button"></i>
                    </div>
                <?php else: ?>
                    <figure class="profile-img">
                        <img src="<?php echo $profileimg;; ?>" alt="Profile image">
                        <i onclick="openImgChanger();" class="fas fa-camera edit-profile-button"></i>
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

    <div class="newaddresscontainer">
        <div class="newaddress popup">
            <header class="calenderheader">
                <i class="fas fa-times close-newaddress"></i>
            </header>
            <form onsubmit="return addNewAddressToUser(event);" class="gender-form" autocomplete="on">
                <h2>Voeg een nieuw adres toe</h2>
                <label for="province" class="order-phone seper">
                    <select class="order-input" name="province" id="province" required>
                        <option value="" disabled selected>Selecteer een provincie</option>
                        <option value="Drenthe">Drenthe</option>
                        <option value="Flevoland">Flevoland</option>
                        <option value="Friesland">Friesland</option>
                        <option value="Gelderland">Gelderland</option>
                        <option value="Groningen">Groningen</option>
                        <option value="Limburg">Limburg</option>
                        <option value="Noord-Brabant">Noord-Brabant</option>
                        <option value="Noord-Holland">Noord-Holland</option>
                        <option value="Overijssel">Overijssel</option>
                        <option value="Utrecht">Utrecht</option>
                        <option value="Zeeland">Zeeland</option>
                        <option value="Zuid-Holland">Zuid-Holland</option>
                    </select>
                    <p class="label">Provincie</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="city" id="city" autocomplete="address-level2" placeholder="Amsterdam" required>
                    <p class="label">Plaatsnaam</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="streetname" id="streetname" autocomplete="address-line1" placeholder="Kerkstraat" required>
                    <p class="label">Straatnaam</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="housenumber" id="housenumber" autocomplete="address-line2" placeholder="1" required>
                    <p class="label">Huisnummer</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="housenumberaddition" id="housenumberaddition" autocomplete="address-line3" placeholder="A">
                    <p class="label">Huisnummer toevoeging</p>
                </label>
                <label for="" class="order-phone seper">
                    <input class="order-input" type="text" name="postalcode" id="postalcode" autocomplete="postal-code" placeholder="1234 AB" required>
                    <p class="label">Postcode</p>
                </label>
                <label for="" class="order-phone seper">
                    <select class="order-input" name="addresstype" id="addresstype" required>
                        <option value="" disabled selected>Selecteer een type adress</option>
                        <option value="factuuradres" name="billaddress">Factuuradres</option>
                        <option value="bezorgadres" name="standardaddress">Bezorgadres</option>
                    </select>
                    <p class="label">Adrestype</p>
                </label>
                <input type="text" name="country" id="country" value="Nederland" hidden>
                <input type="text" name="userid" id="userid" value="<?php echo $user_id; ?>" hidden>
                <button type="submit">Toevoegen</button>
            </form>
        </div>
    </div>

    <div class="usernamecontainer">
        <div class="username popup">
            <header class="calenderheader">
                <i class="fas fa-times close-username"></i>
            </header>
            <form class="gender-form" onsubmit="return deleteAddress(event);">
                <h2 id="permdel">Weet je zeker dat je dit adres permanent wil verwijderen?</h2>
                <input type="text" name="addressid" id="addressid" value="" hidden>
                <button type="submit">Verwijder dit product</button>
            </form>
        </div>
    </div>

    <main class="profile">
        <aside class="profile-navigation">
            <div class="profile-container">
                <header class="profile-header">
                    <h1>Welkom <span style="text-transform: capitalize;"><?php echo $fname; ?></span></h1>
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
                        <div class="profile-listitem-container active">
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
                <div class="address-headerheading" style="padding-bottom: 0.5rem;">
                    <div class="address-headertext">
                        <h1>Mijn Adressen</h1>
                        <p>Bekijk of bewerk uw adresgegevens.</p>
                    </div>
                    <div class="address-headericon" onclick="openPopup('newaddresscontainer', 'close-newaddress');">
                        <i class="fas fa-circle-plus"></i>
                    </div>
                </div>
                <ul class="profile-info-list" style="border-top: 1px solid #939393;">
                    <div class="adres-container">
                        <header class="adres-header">
                            <h1>Alle bezorgadressen:</h1>
                        </header>
                        <div class="adres-deliverycontainer">
                            <?php
                            if ($user_id) {
                                $stmt = $mysqli->prepare("SELECT * FROM address WHERE user_id = ? AND address_type = 'bezorgadres'");
                                $stmt->execute([$user_id]);
                                $result = $stmt->get_result();
                                $addresses = $result->fetch_all(MYSQLI_ASSOC);

                                if (!empty($addresses)) {
                                    foreach ($addresses as $address) {
                            ?>
                                        <li class="adres-listitem">
                                            <div class="adres-listitem-header">
                                                <b>Bezorgadres:</b>
                                            </div>
                                            <div class="adres-listdata">
                                                <p><?php echo htmlspecialchars($address['street_name']) . " " . htmlspecialchars($address['street_number']) . ($address['street_number_addon'] ? " " . htmlspecialchars($address['street_number_addon']) : ""); ?></p>
                                                <p><?php echo htmlspecialchars($address['city']) . ", " . htmlspecialchars($address['province']); ?></p>
                                                <p style="text-transform: uppercase;"><?php echo htmlspecialchars($address['postal_code']); ?></p>
                                            </div>
                                            <button class="adres-listbutton" onclick="openDeleteAddress(<?php echo $address['address_id']; ?>);">
                                                Verwijder
                                            </button>
                                        </li>
                            <?php
                                    }
                                } else {
                                    echo "<p>Geen bezorgadressen gevonden.</p>";
                                }
                            } else {
                                echo "<p>Gebruiker niet ingelogd.</p>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="adres-container">
                        <header class="adres-header">
                            <h1>Alle factuuradressen:</h1>
                        </header>
                        <div class="adres-billcontainer">
                            <?php
                            if ($user_id) {
                                $stmt = $mysqli->prepare("SELECT * FROM address WHERE user_id = ? AND address_type = 'factuuradres'");
                                $stmt->execute([$user_id]);
                                $result = $stmt->get_result();
                                $addresses = $result->fetch_all(MYSQLI_ASSOC);

                                if (!empty($addresses)) {
                                    foreach ($addresses as $address) {
                            ?>
                                        <li class="adres-listitem">
                                            <div class="adres-listitem-header">
                                                <b>Factuuradres:</b>
                                            </div>
                                            <div class="adres-listdata">
                                                <p><?php echo htmlspecialchars($address['street_name']) . " " . htmlspecialchars($address['street_number']) . ($address['street_number_addon'] ? " " . htmlspecialchars($address['street_number_addon']) : ""); ?></p>
                                                <p><?php echo htmlspecialchars($address['city']) . ", " . htmlspecialchars($address['province']); ?></p>
                                                <p style="text-transform: uppercase;"><?php echo htmlspecialchars($address['postal_code']); ?></p>
                                            </div>
                                            <button class="adres-listbutton" onclick="openDeleteAddress(<?php echo $address['address_id']; ?>);">
                                                Verwijder
                                            </button>
                                        </li>
                            <?php
                                    }
                                } else {
                                    echo "<p>Geen factuuradressen gevonden.</p>";
                                }
                            } else {
                                echo "<p>Gebruiker niet ingelogd.</p>";
                            }
                            ?>
                        </div>
                    </div>
                </ul>
            </div>
        </section>
    </main>

    <main class="phone-profile">
        <div class="phone-profile-headerbewerk">
            <i onclick="window.location.href = './profile.php'" class="fas fa-chevron-left"></i>
            <div class="phone-profile-contentcontainer">
                <div class="phone-profile-imagecontainer">
                    <figure class="phone-profile-image">
                        <img src="./img/person.jpg" alt="">
                    </figure>
                </div>
                <header class="phone-profile-headeredit">
                    <h1>Bewerk adressen</h1>
                    <div class="address-headericon" onclick="openPopup('newaddresscontainer', 'close-newaddress');">
                        <i class="fas fa-circle-plus"></i>
                    </div>
                </header>
                <div id="message-container" class="message-container"></div>
                <div class="adres-container">
                    <header class="adres-header">
                        <h1>Alle bezorgadressen:</h1>
                    </header>
                    <div class="adres-deliverycontainer">
                        <li class="adres-listitem">
                            <div class="adres-listitem-header">
                                <b>Bezorgadres:</b>
                            </div>
                            <div class="adres-listdata">
                                <p><?php echo $streetname . " " .  $streetnumber . ($streetaddition ? "" . $streetaddition : ""); ?></p>
                                <p><?php echo $city . ", " . $province; ?></p>
                                <p style="text-transform: uppercase;"><?php echo $postalcode; ?></p>
                            </div>
                            <button class="adres-listbutton" onclick="delAddressPrompt();">Verwijder</button>
                        </li>
                        <li class="adres-listitem">
                            <div class="adres-listitem-header">
                                <b>Bezorgadres:</b>
                            </div>
                            <div class="adres-listdata">
                                <p><?php echo $streetname . " " .  $streetnumber . ($streetaddition ? "" . $streetaddition : ""); ?></p>
                                <p><?php echo $city . ", " . $province; ?></p>
                                <p style="text-transform: uppercase;"><?php echo $postalcode; ?></p>
                            </div>
                            <button class="adres-listbutton" onclick="delAddressPrompt();">Verwijder</button>
                        </li>
                        <li class="adres-listitem">
                            <div class="adres-listitem-header">
                                <b>Bezorgadres:</b>
                            </div>
                            <div class="adres-listdata">
                                <p><?php echo $streetname . " " .  $streetnumber . ($streetaddition ? "" . $streetaddition : ""); ?></p>
                                <p><?php echo $city . ", " . $province; ?></p>
                                <p style="text-transform: uppercase;"><?php echo $postalcode; ?></p>
                            </div>
                            <button class="adres-listbutton" onclick="delAddressPrompt();">Verwijder</button>
                        </li>
                    </div>
                </div>
                <div class="adres-container">
                    <header class="adres-header">
                        <h1>Alle factuuradressen:</h1>
                    </header>
                    <div class="adres-billcontainer">
                        <li class="adres-listitem">
                            <div class="adres-listitem-header">
                                <b>Factuuradres:</b>
                            </div>
                            <div class="adres-listdata">
                                <p><?php echo $streetname . " " .  $streetnumber . ($streetaddition ? "" . $streetaddition : ""); ?></p>
                                <p><?php echo $city . ", " . $province ?></p>
                                <p style="text-transform: uppercase;"><?php echo $postalcode; ?></p>
                            </div>
                            <button class="adres-listbutton" onclick="delAddressPrompt();">Verwijder</button>
                        </li>
                        <li class="adres-listitem">
                            <div class="adres-listitem-header">
                                <b>Factuuradres:</b>
                            </div>
                            <div class="adres-listdata">
                                <p><?php echo $streetname . " " .  $streetnumber . ($streetaddition ? "" . $streetaddition : ""); ?></p>
                                <p><?php echo $city . ", " . $province ?></p>
                                <p style="text-transform: uppercase;"><?php echo $postalcode; ?></p>
                            </div>
                            <button class="adres-listbutton" onclick="delAddressPrompt();">Verwijder</button>
                        </li>
                        <li class="adres-listitem">
                            <div class="adres-listitem-header">
                                <b>Factuuradres:</b>
                            </div>
                            <div class="adres-listdata">
                                <p><?php echo $streetname . " " .  $streetnumber . ($streetaddition ? "" . $streetaddition : ""); ?></p>
                                <p><?php echo $city . ", " . $province ?></p>
                                <p style="text-transform: uppercase;"><?php echo $postalcode; ?></p>
                            </div>
                            <button class="adres-listbutton" onclick="delAddressPrompt();">Verwijder</button>
                        </li>
                    </div>
                </div>
                <br>
                <br>
                <form class="navbar-logoutcontainer" action="./controllers/account_controller.php?type=logout" method="POST">
                    <button class="navbar-logoutbutton" type="submit">Uitloggen</button>
                </form>
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