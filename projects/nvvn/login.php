<?php
require_once("db_conn.php");

session_start();

if (isset($_SESSION["id"])) {
    header("location: profile.php");
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usernameOrEmail = $_POST['usernameOrEmail'];
    $password = $_POST['password'];

    $sql = "SELECT id, username, password FROM accounts WHERE (username = ? OR email = ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);

    if ($stmt->execute()) {
        $stmt->bind_result($id, $username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) { 
            session_destroy();
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["id"] = $id;
            header("location: profile.php");
        } else {
            echo "Login failed. Please check your username (or email) and password.";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <title>NVVN - Nederlandse Vereniging voor de Verenigde Naties</title>
    <link rel="stylesheet" href="./css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans&family=Montserrat:ital,wght@0,300;0,400;1,200&display=swap" rel="stylesheet">
    <script src="./js/index.js" defer></script>
    <link rel="icon" type="image/x-icon" href="./img/un-favicon.webp">
</head>

<body>

    <header class="header__container">
        <nav class="header__navbar">
            <div class="header__mobileNav">
                <div class="header__phoneNavButton">
                    <button id="openPhoneNav" aria-label="Toggle Mobile Navigation">&#9776;</button>
                </div>
                <ul class="header__phoneNav" aria-label="Mobile Navigation Menu">
                    <li><a href="./index.php">Home</a></li>
                    <li><a href="./about.php">Over ons</a></li>
                    <li><a href="./sdg.php">SDG's</a></li>
                    <li><a href="./info.php">Informatie</a></li>
                    <?php
                    if (isset($_SESSION["id"])) {
                        ?>
                        <li><a href="./profile.php">Profile</a></li>
                        <?php
                    }
                    if (!isset($_SESSION["id"])) {
                        ?>
                        <li><a href="./login.php">Login</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="./logout.php">Logout</a></li>
                        <?php
                    }
                    ?>
                    <li class="header__closeButton"><button id="closePhoneNav"
                            aria-label="Close Mobile Navigation">&#10006;</button></li>
                </ul>
            </div>

            <ul class="header__navItems">
                <a class="header__imgContainer" href="./index.php"><i style="font-size: 2rem;"
                        class="fa-solid fa-house home"></i></a>
            </ul>

            <ul class="header__navItems">
                <li class="header__navLinks"><a href="./sdg.php" class="header__navLinkItem">SDG's</a></li>
                <li class="header__navLinks"><a href="./info.php" class="header__navLinkItem">Informatie</a></li>
                <li class="header__navLinks"><a href="./about.php" class="header__navLinkItem">Over Ons</a></li>
            </ul>

            <ul class="header__navItems">
                <li class="header__navLogin"><a
                        href="<?php if (isset($_SESSION["id"])) {
                            echo "./profile.php";
                        } else {
                            echo "./login.php";
                        } ?>"
                        aria-label="Login">
                        <?php if (!isset($_SESSION['username'])) { ?><i
                                class="fa-regular fa-user animation__profile"></i>
                        <?php } else { ?> 
                            <img class="peetje17" src="./pfp/<?php echo $pfp; ?>" alt="" srcset="">
                        <?php } ?>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <section class="slogan__container">
        <div class="slogan__imgContainer">
            <figure class="slogan__img">
                <p class="slogan__imgCaption">
                    VN Forum is het digitale tijdschrift van de Nederlandse Vereniging voor de Verenigde Naties (NVVN).
                    Doelstelling is het vergroten van kennis over de werking en invloed van de Verenigde Naties.
                </p>
            </figure>
        </div>
    </section>

    <section class="login__container">
        <div class="login__formcontainer">
            <p style="text-align: center; padding-top: 1rem;"><?php if (isset($_SESSION['account_succes']) && $_SESSION['account_succes']) { echo "Account successfully created!"; session_destroy();  } ?></p>
            <form class="login__form" action="login.php" method="POST">
                <label class="login__usercontainer" for="usernameOrEmail">
                    <p>Username / Email:</p>
                    <input id="usernameOrEmail" class="login__input" type="text" name="usernameOrEmail" required>
                </label>
                <label class="login__passcontainer" for="password">
                    <p>Password:</p>
                    <input id="password" class="login__input" type="password" name="password" required>
                </label>
                <div class="login__registercontainer">
                    <p>Don't have an account?</p>
                    <a style="text-decoration: underline;" href="./register.php"> Register here.</a>
                </div>
                <label class="login__buttoncontainer" for="button">
                    <button id="button" class="login__button" type="submit">Login</button>
                </label>
            </form>
        </div>
    </section>

    <footer id="contact" class="footer__container">
        <div class="footer__content">
            <ul class="footer__list">
                <form class="footer__listForm" method="post" action="">
                    <p class="footer__listFormTitle">Neem contact met ons op!</p>
                    <input class="footer__listFormEmail" type="email" name="" id="" placeholder="Uw Email">
                    <input class="footer__listFormNaam" type="text" placeholder="Uw Naam">
                    <textarea class="footer__listFormOpmerking" name="" id="" cols="30" rows="4"
                        placeholder=" Uw Vraag/opmerking"></textarea>
                    <button class="footer__listFormButton" type="submit">Verstuur</button>
                </form>
            </ul>
            <ul class="footer__list">
                <li class="footer__listLinks"><a href="./index.php" class="footer__listLinkA">Home</a></li>
                <li class="footer__listLinks"><a href="./about.php" class="footer__listLinkA">Over Ons</a></li>
                <li class="footer__listLinks"><a href="./sdg.php" class="footer__listLinkA">SDG's</a></li>
                <li class="footer__listLinks"><a href="./info.php" class="footer__listLinkA">Informatie</a></li>
                <?php
                if (!isset($_SESSION["id"])) {
                    ?>
                    <li class="footer__listLinks"><a href="./login.php" class="footer__listLinkA">Login</a></li>
                    <?php
                } else {
                    ?>
                    <li class="footer__listLinks"><a href="./logout.php" class="footer__listLinkA">Logout</a></li>
                    <?php
                }
                ?>
            </ul>
            <ul class="footer__list socials">
                <li class="footer__listSocials">
                    <a target="_blank" href="https://www.facebook.com/UNANetherlands"><i
                            class="fa-brands fa-facebook"></i>
                        <p>Facebook</p>
                    </a>
                    <a target="_blank" href="https://www.instagram.com/nederlandse_vereniging_vn/"><i
                            class="fa-brands fa-instagram"></i>
                        <p>Instagram</p>
                    </a>
                    <a target="_blank"
                        href="https://podcasts.apple.com/nl/podcast/de-vn-podcast/id1647809707?l=en%20"><i
                            class="fa-solid fa-podcast"></i>
                        <p>Apple Podcast</p>
                    </a>
                    <a target="_blank" href="https://open.spotify.com/show/5Sgn01M9cgJJygGyPT9prc"><i
                            class="fa-brands fa-spotify"></i>
                        <p>Spotify</p>
                    </a>
                </li>
                <li class="footer__listSocials">
                    <a target="_blank" href="https://twitter.com/UNANL"><i class="fa-brands fa-x-twitter"></i>
                        <p>Twitter</p>
                    </a>
                    <a target="_blank"
                        href="https://www.linkedin.com/company/nederlandse-vereniging-voor-de-verenigde-naties"><i
                            class="fa-brands fa-linkedin"></i>
                        <p>LinkedIn</p>
                    </a>
                    <a target="_blank" href="mailto:info@nvvn.nl"><i class="fa-regular fa-envelope"></i>
                        <p>Email</p>
                    </a>
                    <a target="_blank" href="https://tiktok.com/@nvvn_nl"><i class="fa-brands fa-tiktok"></i>
                        <p>Tiktok</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="footer__copyright">
            <ul>
                <b>Copyright © 2023 - Swift Code Studios</b>
            </ul>
        </div>
    </footer>
</body>

</html>