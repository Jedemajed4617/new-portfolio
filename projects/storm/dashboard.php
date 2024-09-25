<?php

include('functions.php');
include('var_dump.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}
$username = $_SESSION['username'];

$rank = GetRankByUsername($mysqli, $username);

$amountissue = IssueAmount($mysqli);
$amountusers = userAmount($mysqli);
$amountproducts = productAmount($mysqli);
$amountsolved = solvedIssues($mysqli);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="./photo/StormLogo.png" type="image/x-icon">
    <script src="jquery-2.1.4.js"></script>
    <title>Storm Services</title>
</head>

<script type='text/javascript'>
    // Titel scroll animatie
    msg = document.title;
    msg = msg + "          ";
    position = 0;

    function scrolltitle() {
        document.title = msg.substring(position, msg.length) + msg.substring(0, position);
        position++;
        if (position > msg.length) position = 0
        window.setTimeout("scrolltitle()", 250);
    }
    scrolltitle();
</script>

<header>
    <div class="content typewriter noselect">
        <hgroup>
            <h1>Storm Services</h1>
            <p>
                <i>
                    For all your Fivem Unbans!
                </i>

            </p>
        </hgroup>
    </div>
</header>

<body class="pietje noselect">
    <section class="site">
        <nav>
            <a class="peetje13" href="index.php">Home</a>
            <a class="peetje13" href="about.php">About</a>
            <a class="peetje13" style="color: white;" href="shopcart.php">Cart</a>
            <?php
            if (!isset($_SESSION['username'])) {
                ?>
                <a class="peetje13" href="login.php">Login</a>
                <a class="peetje13" href="register.php">Register</a>
                <?php
            } else {
                ?>
                <a class="peetje13" href="issues.php">Issues</a>
                <a class="peetje13" href="logout.php">Logout</a>
                <a class="peetje13" href="dashboard.php">Profile</a>
                <?php
            }
            ?>
        </nav>
    </section>

    <section class="peetjehouder">
        <article class="peetje5">
            <b style="font-size: 1.5rem;">Ingelogd!</b>
            <br>
            <p><b>Rank:</b> <small>
                    <?php echo $rank ?>
                </small></p>
            <br>
            <p><b>Welkom: </b>
                <?php echo $username ?>
            </p>
        </article>
    </section>

    <section style="margin-top: 5rem;" class="peetjehouder">
        <article style="padding: 1.2rem;" class="peetje151">
            <p style="color: white;"><b style="font-size: 1.5rem;">Change profile picture :</b></p>
            <form action="changepfp.php" method="POST" enctype="multipart/form-data">
                <input style="width: 100%;" class="buy" type="file" id="filetoUpload1" name="filetoUpload1"
                    accept="image/png, image/jpeg">

                <input style="width: 100%;" class="buy" type="submit" value="Update">
            </form>

            <br>
            <br>
            <figure>
                <?php $pfp = GetPfpByUsername($mysqli, $username); ?> <img
                    style="width: 150px; height: 150px; border-radius: 50%;" src="./profiles/<?php echo $pfp; ?>"
                    alt="">
            </figure>
        </article>
    </section>

    <?php if ($rank == "admin") { ?>
        <center>
            <h1
                style="font-size: 2rem; color: white; padding: 1rem; margin-top: 4rem; background-color: #444; width: 300px; border-radius: 2rem; border: 2px solid white;">
                Dashboard :</h1>
        </center>
    <?php } ?>
    <section class="peetje14">

        <?php if ($rank == "admin") { ?>
            <article class="peetje15">
                <p>Aantal issues: </p>
                <h1 class="bignumber">
                    <?php echo $amountissue; ?>
                </h1>
            </article>
            <article class="peetje15">
                <p>Aantal verkocht: </p>
                <h1 class="bignumber">0</h1>
            </article>
            <article class="peetje15">
                <p>Aantal Producten in shop: </p>
                <h1 class="bignumber">
                    <?php echo $amountproducts; ?>
                </h1>
            </article>
            <article class="peetje15">
                <p>Aantal users geregistreerd: </p>
                <h1 class="bignumber">
                    <?php echo $amountusers; ?>
                </h1>
            </article>
        <?php } ?>
    </section>

    <?php if ($rank == "content-ma") { ?>
        <center>
            <h1
                style="font-size: 2rem; color: white; padding: 1rem; margin-top: 4rem; background-color: #444; width: 300px; border-radius: 2rem; border: 2px solid white;">
                Solved issues :</h1>
        </center>
    <?php } ?>

    <?php if ($rank == "content-ma") { ?>
        <section class="peetje14">
            <article class="peetje15">
                <p>Aantal opgeloste issues:</p>
                <h1 class="bignumber">
                    <?php echo $amountsolved; ?>
                </h1>
            </article>
        </section>

    <?php } ?>

    <?php if ($rank == "content-ma") { ?>
        <center>
            <h1
                style="font-size: 2rem; color: white; padding: 1rem; margin-top: 4rem; background-color: #444; width: 350px; border-radius: 2rem; border: 2px solid white;">
                Add product to shop :</h1>
        </center>
    <?php } ?>

    <section class="shopaddcontainer">
        <div id="frm" class="shopadd" style="text-align: center;">
            <h1 class="peetje2">Create product :</h1>
            <form name="f1" action="createproduct.php" method="POST" enctype="multipart/form-data">
                <p>
                    <br>
                    <label class="peetje2"> Title*: </label>
                    <br>
                    <input class="peetje3" type="text" required maxlength="32" id="user" name="name" />
                </p>
                <p>
                    <br>
                    <label class="peetje2"> Price*: </label>
                    <br>
                    <input type="number" class="peetje3" rows="1" cols="10" required maxlength="5" id="price"
                        name="price"></input>
                </p>
                <p>
                    <br>
                    <label class="peetje2"> Image of product*: </label>
                    <br>
                    <input required class="buy" type="file" id="fileToUpload" name="fileToUpload" accept="image/png, image/jpeg">
                </p>
                <p class="peetjesus">
                    <br>
                    <br>
                    <input class="buy" type="submit" id="btn" value="Create Item"/>
                </p>
            </form>
            <br>
            <p1 class="peetje10">
                <?php if (isset($_GET['error'])) {
                    echo $_GET['error'];
                } ?>
            </p1>
        </div>
    </section>


    <footer class="footer">
        <?php
        if (!isset($_SESSION['username'])) {
            ?>
            <ul class="footerNav">
                <li class="footerNavItem">
                    <a class="peetje13" href="index.php">Home</a>
                    <a class="peetje13" href="login.php">Login</a>
                    <a class="peetje13" href="register.php">Register</a>
                </li>
            </ul>
            <ul class="openHours noselect">
                <li class="openHoursTime2">all rights reserved</li> <!-- miss voor later iets toevoegen -->
                <li class="openHoursTime2">Ⓒ 2022 - Storm Services</li>
            </ul>
            <?php
        } else {
            ?>
            <ul class="footerNav">
                <li class="footerNavItem">
                    <a class="peetje13" href="issues.php">Issues</a>
                    <a class="peetje13" href="logout.php">Logout</a>
                    <a class="peetje13" href="dashboard.php">Profile</a>
                </li>
            </ul>
            <ul class="openHours noselect">
                <li class="openHoursTime2">all rights reserved</li> <!-- miss voor later iets toevoegen -->
                <li class="openHoursTime2">Ⓒ 2022 - Storm Services</li>
            </ul>
        <?php } ?>
    </footer>
</body>

</html>