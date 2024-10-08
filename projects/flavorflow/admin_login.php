<?php
require_once("db_conn.php");

session_start();

if (isset($_SESSION["id"])) {
    header("location: panel.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorflow - Order now</title>
    <link rel="stylesheet" href="./css/main.css">
    <script src="./js/main.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
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

    <div class="web-content">
        <div class="login__formcontainer">
            <p class="errormsg1" style="color: red;">
                <?php
                    if (isset($_SESSION['login_failed']) && $_SESSION['login_failed']) {
                        echo "Username or password not recognized!";
                        session_destroy();
                    }
                ?>
            </p>
            <?php
                if (isset($_SESSION['user_succes'])) {
                    echo "<p class='errormsg1' style='color:green'>" . $_SESSION['user_succes'] . "</p>";
                    session_destroy();
                }
                
                if (isset($_SESSION['user_failed'])) {
                    echo "<p class='errormsg1' style='color:red'>" . $_SESSION['user_failed'] . "</p>";
                    session_destroy();
                }
            ?>
            <form class="login__form" action="controllers/account_controller.php?type=login" method="POST">
                <label class="login__usercontainer" for="usernameOrEmail">
                    <p>Username / Email:</p>
                    <input style="text-transform: capitalize;" id="usernameOrEmail" class="login__input" type="text"
                        name="usernameOrEmail" required>
                </label>
                <label class="login__passcontainer" for="password">
                    <p>Password:</p>
                    <input id="password" class="login__input" type="password" name="password" required>
                </label>
                <div class="login__buttoncontainer" for="button">
                    <button id="button" class="login__button" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
    <!-- TEMP CREATE USER -->
    <form action="controllers/account_controller.php?type=create_user" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Create User</button>
    </form>

    <div class="powered-container">
        <p class="powered-text">Powered by: Flavorflow.app</p>
    </div>

    <footer class="footer-container2"></footer>
</body>

</html>