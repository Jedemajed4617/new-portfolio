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

$_SESSION['restaurant_id'] = $restaurant_id;

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
        <div class="usernamecontainer">
            <div class="username popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-username"></i>
                </header>
                <form class="gender-form" onsubmit="return deleteDish(event);">
                    <h2 id="permdel">test text tyfus</h2>
                    <button type="submit">Verwijder dit product</button>
                </form>
            </div>
        </div>
        <div class="statuscontainer">
            <div class="status popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-status"></i>
                </header>
                <form class="gender-form" onsubmit="return changeDishStatus(event);">
                    <h2>Verander de status van het gerecht</h2>
                    <div class="status-checkbox">
                        <input type="radio" name="status" id="status_active" value="0"> Actief
                    </div>
                    <div class="status-checkbox">
                        <input type="radio" name="status" id="status_non_active" value="1"> Non-actief
                    </div>
                    <button type="submit">Verander status</button>
                </form>
            </div>
        </div>
        <div class="productimagecontainer">
            <div class="productimage popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-productimage"></i>
                </header>
                <form class="gender-form" onsubmit="return changeProductImage(event);">
                    <h2>Verander de afbeelding van het product</h2>
                    <input type="file" name="product_image_change" id="product_image_change">
                    <button type="submit">Verander Afbeelding</button>
                </form>
            </div>
        </div>
        <div class="moreinfo">
            <header class="moreinfo-header">
                <h1>Product Gegevens</h1>
                <i class="fas fa-times close-moreinfo"></i>
            </header>
            <div class="moreinfo-content">
                <aside class="moreinfo-aside">
                    <figure class="moreinfo-figure">
                        <!-- Product img + bewerken -->
                        <img id="show_dish_img" src="" alt="Product img">
                        <div class="moreinfo-figureicon">
                            <i class="fas fa-camera" onclick="openPopup('productimagecontainer', 'close-productimage');"></i>
                        </div>
                    </figure>
                </aside>
                <ul class="moreinfo-list">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_name" id="show_dish_name" value="" required>
                            <p class="label">Naam gerecht</p>
                            <i onclick="changeDishName();" class="fas fa-save profile-icon"></i>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_id" id="show_dish_id" value="" required>
                            <p class="label">Dish ID</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_category" id="show_dish_category" value="" required>
                            <p class="label">Categorie</p>
                            <i onclick="changeProductCategory();" class="fas fa-save profile-icon"></i>
                            <ul id="categorielist" class="hidden"></ul>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_restaurant_name" id="show_restaurant_name" value="<?php echo $restaurant_name; ?>" required>
                            <p class="label">Restaurant naam</p>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_created_by" id="show_created_by" value="" required>
                            <p class="label">Aangemaakt door</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_discount" id="show_discount" value="" required>
                            <p class="label">Afgeprijsd</p>
                            <i onclick="" class="fas fa-save profile-icon"></i>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_when_created" id="show_when_created" value="" required>
                            <p class="label">Aangemaakt op</p>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" style="color: green !important;" type="text" value="" name="show_status" id="show_status" required>
                            <p class="label">Status</p>
                            <i onclick="openPopup('statuscontainer', 'close-status');" class="fas fa-pen profile-icon"></i>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_desc" id="show_dish_desc" value="" required>
                            <p class="label">Beschrijving</p>
                            <i onclick="changeDishDesc();" class="fas fa-save profile-icon"></i>
                        </label>
                    </li>
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_toppings" id="show_dish_toppings" value="" required>
                            <p class="label">Toppings</p>
                        </label>
                    </li>
                </ul>
            </div>
            <footer class="moreinfo-footer">
                <ul class="moreinfo-footerlist">
                    <li class="moreinfo-listitem">
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_price" id="show_dish_price" value="" placeholder="like this: 12.34" required>
                            <p class="label">Prijs incl.</p>
                            <i onclick="changeDishPrice();" class="fas fa-save profile-icon"></i>
                        </label>
                        <label for="" class="order-phone">
                            <input class="order-input" type="text" name="show_dish_pricevat" id="show_dish_pricevat" style="user-select: none; cursor: not-allowed;" value="" required disabled>
                            <p class="label">Prijs excl.</p>
                        </label>
                        <div class="order-phone">
                            <div class="login-makeaccount" style="padding-top: 0 !important;">
                                <button onclick="openDeleteDish();">Verwijder product</button>
                            </div>
                        </div>
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
                            <div class="profile-listitem-container">
                                <i class="fas fa-chart-line"></i>
                                <a href="./restaurant-orderoverview.php?id=<?php echo $restaurant_id; ?>">Order overzicht</a>
                            </div>
                        </li>
                        <li class="profile-listitem">
                            <div class="profile-listitem-container active">
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

        <div class="addproductcontainer">
            <div class="addproduct  popup">
                <header class="calenderheader">
                    <i class="fas fa-times close-addproduct"></i>
                </header>
                <form onsubmit="return addProduct(event);" class="gender-form">
                    <h2>Maak een nieuw product aan</h2>

                    <label for="" class="order-phone seper">
                        <input class="order-input" type="text" name="dish_name" id="dish_name" placeholder="Max 55 karakters" required>
                        <p class="label">Productnaam</p>
                    </label>
                    <label for="" class="order-phone seper">
                        <input class="order-input" type="text" name="dish_price" id="dish_price" placeholder="Zoals dit: 12.34" required>
                        <p class="label">Prijs</p>
                    </label>
                    <label for="" class="order-phone seper">
                        <input class="order-input" type="text" name="dish_desc" id="dish_desc" placeholder="Max 255 karakters" required>
                        <p class="label">Beschrijving</p>
                    </label>
                    <label for="dish_img" class="order-phone seper">
                        <input class="order-input" type="file" name="dish_img" id="dish_img" accept="image/*" style="padding: 1rem;" required>
                        <p class="label">Product afbeelding</p>
                    </label>
                    <label for="" class="order-address">
                        <input class="order-input" type="text" id="searchBar" name="dish_category" placeholder="Zoek naar een categorie (max 1 per product)" required>
                        <p class="label">Categorie</p>
                        <ul id="productcategorielist" class="hidden"></ul>
                    </label>
                    <!-- add toppings later, now i dont know how to do this -->
                    <input type="text" name="restaurant_id" id="restaurant_id" value="<?php echo $restaurant_id; ?>" hidden>
                    <input type="text" name="fullname" id="fullname" value="<?php echo $fullname; ?>" hidden>
                    <button type="submit">Opslaan</button>
                </form>
            </div>
        </div>

        <section class="profile-content">
            <span class="adminnotvisiblemsg">Pagina's niet beschikbaar voor telefoon! <small>Open de website op een tablet of pc of ga verder door de navigatie te klikken</small></span>
            <div class="profile-info admindisplaynoneby1000px">
                <header class="profile-headercontainer">
                    <div class="profile-headerheading">
                        <h1>Producten overzicht</h1>
                        <p>Alle producten op een rij</p>
                    </div>
                    <ul class="order-filters">
                        <li class="searchbar">
                            <input type="text" name="search" id="search" placeholder="Zoeken naar producten" />
                            <i class="fas fa-search inputicon"></i>
                        </li>
                        <li class="refreshcontainer">
                            <button onclick="refresh();" class="refresh"><i class="fas fa-refresh"></i></button>
                        </li>
                        <li class="refreshcontainer">
                            <button onclick="openPopup('addproductcontainer', 'close-addproduct');" class="refresh"><i class="fas fa-plus"></i></button>
                        </li>
                        <li class="order-filtercontainer">
                            <select class="order-filter" name="status-filter" id="status-filter">
                                <option class="order-filteritem" value="all">Alle</option>
                                <option class="order-filteritem" value="active">Actief</option>
                                <option class="order-filteritem" value="notactive">Non-actief</option>
                            </select>
                        </li>
                    </ul>
                </header>
                <ul class="product-info-headers">
                    <li class="product-info-header">
                        <b>Product ID</b>
                    </li>
                    <li class="product-info-header">
                        <b>Categorie</b>
                    </li>
                    <li class="product-info-header">
                        <b>Naam</b>
                    </li>
                    <li class="product-info-header">
                        <b>Prijs</b>
                    </li>
                    <li class="product-info-header">
                        <b>Orders</b>
                    </li>
                    <li class="product-info-header">
                        <b>Afgeprijsd</b>
                    </li>
                    <li class="product-info-header">
                        <b>Datum</b>
                    </li>
                    <li class="product-info-header">
                        <b>Status</b>
                    </li>
                </ul>
                <ul class="profile-info-list" id="dishes-list">
                    <?php
                    $dishes = getDishesByRestaurantId($mysqli, $restaurant_id);
                    foreach ($dishes as $dish) {
                        $order_amount = is_null($dish['order_amount']) ? "0" : $dish['order_amount'];
                        $active_discount = !empty($dish['active_discount']) ? $dish['active_discount'] : "Nee";
                        $dish_img_src = !empty($dish['dish_img_src']) ? $dish['dish_img_src'] : './img/logo-res.jpg';
                        echo "<li class='product-info-listitem'>";
                        echo "<p>#{$dish['dish_id']}</p>";
                        echo "<p>{$dish['category_name']}</p>";
                        echo "<p>{$dish['dish_name']}</p>";
                        echo "<p>{$dish['dish_price']}</p>";
                        echo "<p>{$order_amount}</p>";
                        echo "<p>{$active_discount}</p>";
                        $created_at = explode(' ', $dish['created_at']);
                        echo "<p>{$created_at[0]}<small>om {$created_at[1]}</small></p>";
                        echo "<p>" . ($dish['offline'] == 0 ? 'Actief' : 'Non-actief') . "</p>";
                        echo "<a href='' class='change-dish-del' 
                            data-id='{$dish['dish_id']}' 
                            data-name='{$dish['dish_name']}' 
                            data-price='{$dish['dish_price']}' 
                            data-category='{$dish['category_name']}' 
                            data-created='{$dish['created_at']}'
                            data-discount='{$active_discount}'
                            data-created-by='{$dish['created_by']}' 
                            data-status='" . ($dish['offline'] == 0 ? 'Actief' : 'Non-actief') . "' 
                            data-description='{$dish['dish_desc']}' 
                            data-pimage='{$dish_img_src}'
                            data-delstatus='{$dish['offline']}'
                            >Veranderen</a>";
                        echo "</li>";
                    }
                    ?>
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