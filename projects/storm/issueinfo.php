<?php

include('functions.php');
include('var_dump.php');

if(!isset($_SESSION['username'])){
    header("Location: login.php");
    die();
}
$username = $_SESSION['username'];

if(isset($_GET['item'])){
    $id = $_GET['item'];
}
else{
    header("Location: issues.php");
    die();
}
$issue = GetIssueById($mysqli, $id);

$comments = GetCommentsByIssueID($mysqli, $issue['id']);

$rank = GetRankByUsername($mysqli, $username);


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

    <section class="peetje14">
        <article class="peetje16">
            <div class="noflex">
                <?php
            if($issue['username'] == $username || $rank == "content-ma"){
                ?>
                <center>
                    <a href="markassolved.php?issueid=<?php echo $issue['id']?>" class="buy">Mark as solved</a>
                    <a href="deleteissue.php?id=<?php echo $issue['id']?>" class="buy">Delete</a>
                    <a href="issues.php" class="closeissue buy">Close</a>
                </center>
            <?php
            }
            ?>
            <h1>Title: <?php echo $issue['title']?></h1>
            <h1>Created by: <?php echo $issue['username']?></h1>
            <h1>Description: </h1>
            <p><?php echo $issue['description']?></p>
            <br>
            <br>
            <center><img src="./<?php echo $issue['image']?>" alt="Storm Spoofer buy card" style="max-width: 900px; max-height: 900px;"></center>
            <br>
            <br>
            <br>
            <form name="f1" action="placecomment.php?username=<?php echo $username;?>&issueid=<?php echo $issue['id']?>" method="POST" enctype="multipart/form-data">
                <p>
                    <br>
                    <h1>Comment yourself: </h1>
                    <br>
                    <center><textarea class="peetje3" rows="2" cols="150" required placeholder="Place a comment" id="description" name="solution"></textarea></center>
                </p>
                <p class="peetjesus">
                    <br>
                    <br>    
                    <br>
                    <br>
                    <input class="peetje4" type="submit" id="btn" value="Place" />
                </p>
            </form>
            <h1>Solutions / Comments: </h1>
            <?php
        while ($row = $comments->fetch_assoc()) {
            $pfp = GetPfpByUsername($mysqli, $row['username']);
            ?>
            <div class="commentbox">
            <img width="50px" height="50px" src="./profiles/<?php echo $pfp;?>">
            <p1 style="margin: 4px; width: 90rem;"> <?php echo $row['username']?> | <?php echo GetRankByUsername($mysqli, $row['username'])?>: <?php echo $row['solution']?></p1>
            <br>
            <br>
            <?php
            if($row['username'] == $username || $rank == "admin"){
            ?>
            <a style="text-decoration: none; color: red;" href="deletecomment.php?id=<?php echo $row['id']?>&issueid=<?php echo $issue['id']?>">✖</a>
            <?php
            }
            ?>
            </div>
            <?php
        }
            ?>
            </div>
        </article>
    </section>

    <footer class="footer">

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