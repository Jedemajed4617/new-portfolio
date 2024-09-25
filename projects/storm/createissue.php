<?php
session_start();

include('functions.php');
include('var_dump.php');

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die();
}
$username = $_SESSION['username'];


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
            <a href="index.php">Home</a>
            <a href="about.php">About</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        </nav>
    </section>

    <section class="jeroen2">

        <div id="frm" class="form" style="text-align: center;">
            <h1 class="peetje2">Create issue :</h1>
            <form name="f1" action="processissue.php" method="POST" enctype="multipart/form-data">
                <p>
                    <br>
                    <label class="peetje2"> Title*: </label>
                    <br>
                    <input class="peetje3" type="text" required maxlength="32" id="user" name="title" />
                </p>
                <p>
                    <br>
                    <label class="peetje2"> Description*: </label>
                    <br>
                    <textarea class="peetje3" rows="10" cols="30" required maxlength="255" id="description" name="description"></textarea>
                </p>
                <p>
                    <br>
                    <label class="peetje2"> Screenshot of issue: </label>
                    <br>
                <input type="file" id="fileToUpload" name="fileToUpload" accept="image/png, image/jpeg">
                </p>
                <p class="peetjesus">
                    <br>
                    <br>    
                    <br>
                    <br>
                    <input class="peetje4" type="submit" id="btn" value="Create" />
                </p>
            </form>
            <br>
            <p1 class="peetje10"><?php if(isset($_GET['error'])){ echo $_GET['error'];}?></p1>
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
        <?php }?>
    </footer>
</body>

</html>