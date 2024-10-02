<?php
    include('functions.php');
    include('var_dump.php');
    
    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        die();
    }
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

    <section class="jeroen2">

        
    <div class="jeroen3">
        <h1 class="aboutheader">What is StormSpoofer</h1>
        
        <section class="aboutjaap">
        
        
        <p class="abouttext"> 
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        </p>

        </section>

        <h1 class="aboutheader">How it started</h1>

        <section class="aboutjaap">

        
        <p class="abouttext">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        </p>
        </section>

        <h1 class="aboutheader">About us</h1>

        <section class="aboutjaap">

        <p class="abouttext">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Blanditiis nobis hic quas quaerat corporis obcaecati facere consequuntur exercitationem? Laboriosam rerum expedita voluptatibus dolorum earum id eius maiores impedit, corrupti tenetur!
        </p>

        </section>

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