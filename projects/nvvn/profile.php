<?php
require_once("db_conn.php");
include("functions.php");

session_start();

if (!isset($_SESSION["id"])) {
    header("location: login.php");
}

$username = $_SESSION['username'];

$pfp = GetPfpById($mysqli, $username);

$email = GetEmailByUsername($mysqli, $username);

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

    <section class="profile">
        <div style="width: 100%; height: auto;">
            <div
                style="display: flex; justify-content: center; align-items: center; padding: 2rem; flex-direction: column;">
                <h1>Welkom terug,
                    <?php echo $username; ?>
                </h1>
                <p>Wat wilt u vandaag doen?</p>
            </div>
        </div>
        <section class="profile-section">
            <div class="profile-content">
                <div>
                    <h2>Profielgegevens</h2>
                    <p>Gebruikersnaam: <span class="profile-username">
                            <?php echo $username; ?>
                        </span></p>
                    <p>E-mail:
                        <span class="profile-email">
                            <?php echo $email; ?>
                        </span>
                    </p>
                </div>
                <br>
                <div>
                    <h2>Wachtwoord wijzigen</h2>
                    <p style="color: green;">
                        <?php if (isset($_SESSION['pw_succes']) && $_SESSION['pw_succes']) {
                            echo "Wachtwoord successvol veranderd.";
                            unset($_SESSION['pw_succes']);
                        } ?>
                    </p>
                    <p style="color: red;">
                        <?php if (isset($_SESSION['pw_failed']) && $_SESSION['pw_failed']) {
                            echo "Wachtwoorden komen niet overeen of oud wachtwoord is fout!";
                            unset($_SESSION['pw_failed']);
                        } ?>
                    </p>
                    <form id="password-change-form" action="../change_password.php" method="POST">
                        <label for="old-password">Oud wachtwoord:</label>
                        <input type="password" id="old-password" name="old-password" required>

                        <label for="new-password">Nieuw wachtwoord:</label>
                        <input type="password" id="new-password" name="new-password" required>

                        <label for="confirm-password">Herhaal nieuw wachtwoord:</label>
                        <input type="password" id="confirm-password" name="confirm-password" required>

                        <button type="submit" class="password-change-button">Wachtwoord wijzigen</button>
                    </form>
                </div>
                <br>
                <div>
                    <h2>Gebruikersnaam wijzigen</h2>
                    <p style="color: green;">
                        <?php if (isset($_SESSION['username_success']) && $_SESSION['username_success']) {
                            echo "Gebruikersnaam successvol veranderd.";
                            unset($_SESSION['username_success']);
                        } ?>
                    </p>
                    <p style="color: red;">
                        <?php if (isset($_SESSION['username_failed']) && $_SESSION['username_failed']) {
                            echo "Er is een fout opgetreden, probeer opnieuw. Blijft dit gebeuren? Neem contact met ons op!";
                            unset($_SESSION['username_failed']);
                        } ?>
                    </p>
                    <p style="color: red;">
                        <?php if (isset($_SESSION['not_allowed']) && $_SESSION['not_allowed']) {
                            echo "Deze gebruikersnaam is niet toegestaan!";
                            unset($_SESSION['not_allowed']);
                        } ?>
                    </p>
                    <form id="username-change-form" action="../change_username.php" method="POST">
                        <label for="new-username">Nieuwe gebruikersnaam:</label>
                        <input type="text" id="new-username" name="new-username" required>
                        <button type="submit" class="password-change-button">Gebruikersnaam wijzigen</button>
                    </form>
                </div>
                <br>
                <div>
                    <h2>E-mailadres wijzigen</h2>
                    <p style="color: green;">
                        <?php if (isset($_SESSION['email_success']) && $_SESSION['email_success']) {
                            echo "Email successvol veranderd.";
                            unset($_SESSION['email_success']);
                        } ?>
                    </p>
                    <p style="color: red;">
                        <?php if (isset($_SESSION['email_failed']) && $_SESSION['email_failed']) {
                            echo "Er is een fout opgetreden, probeer opnieuw. Blijft dit gebeuren? Neem contact met ons op!";
                            unset($_SESSION['email_failed']);
                        } ?>
                    </p>
                    <form id="email-change-form" action="../change_email.php" method="POST">
                        <label for="new-email">Nieuw e-mailadres:</label>
                        <input type="email" id="new-email" name="new-email" required>
                        <button type="submit" class="password-change-button">E-mailadres wijzigen</button>
                    </form>
                </div>
            </div>
            <article class="changePFPcontainer">
                <b class="title">Profielfoto wijzigen:</b>
                <form class="formpfp" action="changepfp.php" method="POST" enctype="multipart/form-data">
                    <input class="custom-file-input" type="file" id="filetoUpload1" name="filetoUpload1"
                        accept="image/png, image/jpeg">
                    <label class="inputflexie" style="cursor:pointer;" for="filetoUpload1">Kies bestand +</label>
                    <input class="submit-button" type="submit" value="Update Afbeelding">
                </form>
                <figure class="flexie">
                    <img class="pfp-image" src="./pfp/<?php echo $pfp; ?>" alt="">
                </figure>
                <p class="success-message">
                    <?php if (isset($_SESSION['pfp_success']) && $_SESSION['pfp_success']) {
                        echo "Profielfoto succesvol gewijzigd!";
                        unset($_SESSION['pfp_success']);
                    } ?>
                </p>
            </article>
        </section>
        <div class="logout__container">
            <div class="logout__buttonContainer">
                <button class="logout__button"><a class="logout__buttonText" href="./logout.php">Uitloggen</a></button>
            </div>
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