<?php
session_start();

require_once("db_conn.php");
include("./functions/functions.php");

if (!isset($_SESSION["username"])) {
    $_SESSION['mustlogin'] = true;
    header("location: admin_login.php");
}

$username = $_SESSION['username'];

$email = GetEmailByUsername($mysqli, $username);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorflow - Order now</title>
    <link rel="stylesheet" href="css/main.css">
    <script src="js/adminPanel.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/profile.css">
</head>

<body>
    <nav class="nav-container">
        <div class="nav-category">
            <p style="opacity: 0;">ADMIN PANEL</p>
        </div>
        <div class="nav-imgcontainer">
            <a class="nav-img" href="home.php">FlavorFlow</a>
            <a class="admin" href="./admin_login.php">.</a>
            <small style="padding-left: 0.5rem; font-size: 1.2rem;">ADMIN PANEL</small>
        </div>
        <div class="nav-category">
            <p style="opacity: 0;">ADMIN PANEL</p>
        </div>
    </nav>

    <div class="panelcontainer">
        <ul class="panelitemcontainer">
            <li class="panelnavitem"><a href="#start" class="panelnavtext hover-underline-animation">Start</a></li>
            <li class="panelnavitem"><a href="#user-info" class="panelnavtext hover-underline-animation">User Info</a>
            </li>
            <li class="panelnavitem"><a href="#dishes" class="panelnavtext hover-underline-animation">Dishes</a></li>
            <li class="panelnavitem"><a href="#discounts" class="panelnavtext hover-underline-animation">Discounts</a>
            </li>
            <li class="panelnavitem"><a href="#dashboard" class="panelnavtext hover-underline-animation">Dashboard</a>
            </li>
        </ul>
    </div>

    <div class="web-content2">
        <div class="homepage-content panel-content" id="start">
            <div class="homepage-container">
                <div class="homepage-welcome">
                    <p>Welcome,
                        <?php echo $username; ?>
                    </p>
                </div>
            </div>
        </div>
        <div class="profile-content panel-content" id="user-info">
            <div>
                <h2>Profile info:</h2>
                <p>Username: <span class="profile-username">
                        <?php echo $username; ?>
                    </span></p>
                <p>E-mail:
                    <span class="profile-email">
                        <?php echo $email; ?>
                    </span>
                </p>
            </div>
            <br>
            <div class="changepsw">
                <h2>Change Password</h2>
                <p style="color: green;">
                    <?php if (isset($_SESSION['pw_succes']) && $_SESSION['pw_succes']) {
                        echo "Password successfully changed!";
                        unset($_SESSION['pw_succes']);
                    } ?>
                </p>
                <p style="color: red;">
                    <?php if (isset($_SESSION['pw_failed']) && $_SESSION['pw_failed']) {
                        echo "Passwords do not match or the old password is incorrect!";
                        unset($_SESSION['pw_failed']);
                    } ?>
                </p>
                <p style="color: red;">
                    <?php if (isset($_SESSION['pw_failed2']) && $_SESSION['pw_failed2']) {
                        echo "The old password is the same as the new password!";
                        unset($_SESSION['pw_failed2']);
                    } ?>
                </p>
                <form id="password-change-form" action="controllers/account_controller.php?type=change_password"
                    method="POST">
                    <label for="old-password">Old password:</label>
                    <input type="password" id="old-password" name="old-password" placeholder="Enter your old password."
                        required>

                    <label for="new-password">New password:</label>
                    <input type="password" id="new-password" name="new-password" placeholder="Enter a new password."
                        required>

                    <label for="confirm-password">Repeat new password:</label>
                    <input type="password" id="confirm-password" name="confirm-password"
                        placeholder="Re-enter the new password." required>

                    <button type="submit" class="password-change-button">Change password</button>
                </form>
            </div>
            <br>
            <div class="changeusr">
                <h2>Change username</h2>
                <p style="color: green;">
                    <?php if (isset($_SESSION['username_success']) && $_SESSION['username_success']) {
                        echo "Username successfully changed.";
                        unset($_SESSION['username_success']);
                    } ?>
                </p>
                <p style="color: red;">
                    <?php if (isset($_SESSION['username_failed']) && $_SESSION['username_failed']) {
                        echo "An error occurred, please try again. If this issue persists, contact us!";
                        unset($_SESSION['username_failed']);
                    } ?>
                </p>
                <p style="color: red;">
                    <?php if (isset($_SESSION['not_allowed']) && $_SESSION['not_allowed']) {
                        echo "Username is not allowed!";
                        unset($_SESSION['not_allowed']);
                    } ?>
                </p>
                <p style="color: red;">
                    <?php if (isset($_SESSION['username_failed_same']) && $_SESSION['username_failed_same']) {
                        echo "The new username was the same as the old!";
                        unset($_SESSION['username_failed_same']);
                    } ?>
                </p>
                <form id="username-change-form" action="controllers/account_controller.php?type=change_username"
                    method="POST">
                    <label for="new-username">New username:</label>
                    <input type="text" id="new-username" name="new-username" placeholder="Enter a new username."
                        required>
                    <button type="submit" class="password-change-button">Change username</button>
                </form>
            </div>
            <br>
            <div class="changemail">
                <h2>Change e-mailadress</h2>
                <p style="color: green;">
                    <?php if (isset($_SESSION['email_success']) && $_SESSION['email_success']) {
                        echo "E-mail successfully changed.";
                        unset($_SESSION['email_success']);
                    } ?>
                </p>
                <p style="color: red;">
                    <?php if (isset($_SESSION['email_failed']) && $_SESSION['email_failed']) {
                        echo "An error occurred, please try again. If this issue persists, contact us!";
                        unset($_SESSION['email_failed']);
                    } ?>
                </p>
                <p style="color: red;">
                    <?php if (isset($_SESSION['email_failed_same']) && $_SESSION['email_failed_same']) {
                        echo "The new email was the same as the old!";
                        unset($_SESSION['email_failed_same']);
                    } ?>
                </p>
                <form id="email-change-form" action="controllers/account_controller.php?type=change_email"
                    method="POST">
                    <label for="new-email">New e-mail adress:</label>
                    <input type="email" id="new-email" name="new-email" placeholder="Enter a new email." required>
                    <button type="submit" class="password-change-button">Change e-mailadress</button>
                </form>
            </div>
        </div>
        <div class="dishes_container panel-content" id="dishes">
            <ul class="dishes_subcontainer">
                <form class="dishes_formcontainer" method="POST"
                    action="controllers/account_controller.php?type=add_dish">
                    <h1 class="dishes_maintitle">Add dishes to your website:</h1>
                    <div class="dishes_inputcontainer">
                        <div class="dishes_inputtitlecontainer">
                            <p class="dishes_inputtitle">Give your dish an image:</p>
                        </div>
                        <div class="dishes_fileinputcontainer">
                            <input class="dishes_fileinput" type="file" name="image" id="image">
                        </div>
                    </div>
                    <div class="dishes_inputcontainer">
                        <div class="dishes_inputtitlecontainer">
                            <p class="dishes_inputtitle">Give your dish a title:</p>
                        </div>
                        <div class="dishes_catitlecontainer">
                            <input class="dishes_catitleinput" type="text" name="title"
                                placeholder="Enter a title for your dish.">
                        </div>
                    </div>
                    <div class="dishes_inputcontainer">
                        <div class="dishes_inputtitlecontainer">
                            <p class="dishes_inputtitle">Add or use an existing category:</p>
                        </div>
                        <div class="dishes_catitlecontainer">
                            <input class="dishes_catitleinput" type="text" name="category"
                                placeholder="Enter a new or an existing category.">
                        </div>
                    </div>
                    <div class="dishes_inputcontainer">
                        <div class="dishes_inputtitlecontainer">
                            <p class="dishes_inputtitle">Enter a price for your dish:</p>
                        </div>
                        <div class="dishes_pricecontainer">
                            <input class="dishes_inputprice" type="text" name="price" placeholder="Price.">
                            <input class="dishes_inputcents" type="text" name="cents" placeholder="Cents.">
                        </div>
                    </div>
                    <div class="dishes_inputcontainer">
                        <div class="dishes_inputtitlecontainer">
                            <p class="dishes_inputtitle">Add ingredients to your dish:</p>
                        </div>
                        <div class="dishes_ingredientcontainer">
                            <input class="dishes_inputingredient" type="text" placeholder="Ingredient.">
                            <button type="button" class="dishes_addingredient" onclick="addIngredient()">+</button>
                        </div>
                    </div>
                    <div class="dishes_submitcontainer">
                        <button class="dishes_submit" type="submit">Submit your dish</button>
                    </div>
                </form>
            </ul>
        </div>
        <div class="panel-content" id="discounts">
            <p>discounts</p>
        </div>
        <div class="panel-content" id="dashboard">
            <p>dashboard</p>
        </div>
    </div>
    <div class="logout__container" style="padding: 1rem;">
        <div class="logout__buttonContainer">
            <button class="logout__button">
                <a class="logout__buttonText" href="controllers/account_controller.php?type=logout">Logout</a>
            </button>
        </div>
    </div>

    <div class="powered-container">
        <p class="powered-text">Powered by: Flavorflow.app</p>
    </div>

</body>

</html>