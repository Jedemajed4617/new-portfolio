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
            <a class="peetje13" href="login.php">Login</a>
            <a class="peetje13" href="register.php">Register</a>
        </nav>
    </section>

    <section class="jeroen2">

        <div id="frm" class="form">
            <h1 class="peetje2">Register :</h1>
            <form name="f1" action="createuser.php" method="POST">
                <p>
                    <br>
                    <label class="peetje2"> Username: </label>
                    <br>
                    <input class="peetje3" type="text" id="user" name="user" />
                </p>
                <p>
                    <br>
                    <label class="peetje2"> Password: </label>
                    <br>
                    <input class="peetje3" type="password" id="pass" name="pass" />
                </p>
                <p>
                    <br>
                    <label class="peetje2"> Repeat Password: </label>
                    <br>
                    <input class="peetje3" type="password" id="pass" name="pass2" />
                </p>
                <p>
                    <br>
                    <label class="peetje2">Rank (Als voorbeeld): </label>
                    <br>
                    <select name="rank" id="rank">
                    <option value="member">Member</option>
                    <option value="admin">Admin</option>
                    <option value="content-manager">Content manager</option>
                    </select>
                </p>
                <p class="peetjesus">
                    <br>
                    <br>
                    <br>
                    <br>
                    <input class="peetje4" type="submit" id="btn" value="Register" />
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