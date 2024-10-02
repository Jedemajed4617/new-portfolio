<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$connect = new mysqli("localhost", "root", "", "progweek5");

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
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
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



    <section class="jeroen">

        <?php
            $query = "select * from tbl_product order by id";
            $result = $connect->query($query);
            if ($result->num_rows > 0) {
                while ($product = $result->fetch_object()) { ?>
                    <form method="post" action="shopcart.php?action=add&id=<?= $product->id; ?>">
                        <article class="card kaartje1">

                            <div class="imgBox">
                                <img alt="Imagem" src="./productimg/<?= $product->image; ?>" class="mouse">
                            </div>

                            <div class="contentBox">
                                <h3><?= $product->name; ?></h3>
                                <h2 class="price">€<?= $product->price; ?></h2>

                                <input type="hidden" name="hidden_name" value="<?= $product->name; ?>" />
                                <input type="hidden" name="hidden_price" value="<?= $product->price; ?>" />
                                <input type="submit" name="add_to_cart" class="buy" value="Add to Cart" />
                            </div>

                        </article>
                    </form>
                    <?php
            }
        }
        ?>

        <?php
        if ($result->num_rows > 0) {
            while ($product = $result->fetch_object()) { ?>
                <div class="col-md-4">
                    <form method="post" action="shopcart.php?action=add&id=<?= $product->id; ?>">
                        <div class="div-inner-form">
                            <img alt="Imagem" src="./images/<?= $product->image; ?>"
                                class="img-responsive center-block" /><br />
                            <h4 class="text-info">
                                <?= $product->name; ?>
                            </h4>
                            <h4 class="text-danger">$
                                <?= $product->price; ?>
                            </h4>
                            <input aria-label="Quantidade" type="number" name="quantity" value="1" class="form-control" />
                            <input type="hidden" name="hidden_name" value="<?= $product->name; ?>" />
                            <input type="hidden" name="hidden_price" value="<?= $product->price; ?>" />
                            <input type="submit" name="add_to_cart" class="btn btn-success add_to_cart" value="Add to Cart" />
                        </div>
                    </form>
                </div>
                <?php
            }
        }
        ?>

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