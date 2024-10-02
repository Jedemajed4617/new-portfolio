<?php
session_start();

require_once("./db_conn.php");
include("./functions.php");

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    $username = null; // Set to a default value if the session is not active
}

$pfp = GetPfpById($mysqli, $username);
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
    <link
        href="https://fonts.googleapis.com/css2?family=Inclusive+Sans&family=Montserrat:ital,wght@0,300;0,400;1,200&display=swap"
        rel="stylesheet">
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
                </p>
            </figure>
        </div>
    </section>

    <section class="about-section">
        <div class="about-content">
            <h2>Over Ons</h2>
            <p>Welkom bij de Nederlandse Vereniging voor de Verenigde Naties (NVVN). Wij zijn een toegewijde gemeenschap
                van mensen die zich inzetten voor de idealen van de Verenigde Naties.</p>
            <p>Onze missie is om bij te dragen aan een vreedzame, rechtvaardige en duurzame wereld. Al meer dan zeventig
                jaar zijn wij betrokken bij internationale samenwerking en streven wij ernaar de VN-doelen te
                verspreiden en te ondersteunen.</p>
            <p>De NVVN is een platform voor dialoog, bewustwording en actie. Samen met onze partners en leden werken we
                aan vrede, veiligheid, mensenrechten, klimaatverandering en duurzame ontwikkeling.</p>
            <p>Wij geloven in de kracht van collectieve actie en de rol die elk individu kan spelen in het vormgeven van
                een betere toekomst. Sluit je bij ons aan, en samen kunnen we de wereld veranderen.</p>
        </div>
    </section>

    <section class="mission-section">
        <div class="mission-content">
            <h2>Onze Missie</h2>
            <p>Onze missie bij de NVVN is gericht op het bevorderen van de doelstellingen van de Verenigde Naties in
                Nederland en wereldwijd. We zijn vastbesloten om de volgende gebieden aan te pakken:</p>
            <ul>
                <li>* Vrede en veiligheid</li>
                <li>* Mensenrechten</li>
                <li>* Duurzame ontwikkeling</li>
                <li>* Klimaatverandering</li>
            </ul>
            <br>
            <p>Met educatie, bewustwording, en samenwerking streven we ernaar om een positieve impact te hebben op deze
                belangrijke mondiale kwesties.</p>
        </div>
    </section>

    <section class="activities-section">
        <div class="activities-content">
            <h2>Onze Activiteiten</h2>
            <p>Als NVVN zijn we actief betrokken bij een breed scala aan activiteiten om onze missie te bevorderen.
                Enkele van onze belangrijkste activiteiten omvatten:</p>
            <ul>
                <li>* Organisatie van evenementen en conferenties gericht op VN-doelen.</li>
                <li>* Educatieve programma's en workshops om bewustwording te vergroten.</li>
                <li>* Samenwerking met overheden, NGO's en andere organisaties voor gemeenschappelijke projecten.</li>
                <li>* Bevordering van jeugdparticipatie en betrokkenheid bij mondiale vraagstukken.</li>
            </ul>
            <br>
            <p>Samen werken we aan een betere toekomst voor de wereld en haar inwoners.</p>
        </div>
    </section>

    <section class="join-section">
        <div class="join-content">
            <h2>Sluit Je Bij Ons Aan</h2>
            <p>
                Wil je ook deel uitmaken van onze gemeenschap en bijdragen aan een betere wereld? Word lid van de NVVN en
                ontdek hoe jij je steentje kunt bijdragen aan internationale samenwerking en het bereiken van VN-doelen.
            </p>
            <p>
                Samen kunnen we een verschil maken. Doe met ons mee en draag bij aan een vreedzame, rechtvaardige en
                duurzame toekomst voor iedereen.
            </p>
            <div style="display: flex; gap: 2rem; align-items: center;">
                <p>Deze website is mede mogelijk gemaakt door: Swiftcode Studios</p>
                <img style="width: 3.5rem; height: 3.5rem; border-radius: 0.2rem;" src="./img/scs.webp" alt="hallo">
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