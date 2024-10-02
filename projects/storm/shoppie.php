<?php

session_start();
$connect = new mysqli("localhost", "root", "", "progweek5");
if (isset($_POST["add_to_cart"])) {
    if (isset($_SESSION["shopping_cart"])) {
        $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
        if (!in_array($_GET["id"], $item_array_id)) {
            $count = count($_SESSION["shopping_cart"]);
            $item_array = array(
                'item_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'item_price' => $_POST["hidden_price"]
            );
            $_SESSION["shopping_cart"][$count] = $item_array;
        } else {
            echo '<script>alert("Item Already Added")</script>';
            echo '<script>window.location="index.php"</script>';
        }
    } else {
        $item_array = array(
            'item_id' => $_GET["id"],
            'item_name' => $_POST["hidden_name"],
            'item_price' => $_POST["hidden_price"],
            'item_quantity' => $_POST["quantity"],
        );
        $_SESSION["shopping_cart"][0] = $item_array;
    }
}
if (isset($_GET["action"])) {
    if ($_GET["action"] == "delete") {
        foreach ($_SESSION["shopping_cart"] as $keys => $values) {
            if ($values["item_id"] == $_GET["id"]) {
                unset($_SESSION["shopping_cart"][$keys]);
                echo '<script>alert("Item Removed")</script>';
                echo '<script>window.location="shopcart.php"</script>';
            }
        }
    }
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="jquery-2.1.4.js"></script>
    <title>Storm Services</title>
</head>



<body style="background-image: none; background-color: #444;" class="pietje">

    <div class="container2">
        <div class="clear"></div>
        <h3 style="color: white; padding-top: 1rem;">Order Details</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="th40">Item Name</th>
                    <th class="th20">Price</th>
                    <th class="th15">Total</th>
                    <th class="th5">Action</th>
                </tr>
                <?php
                if (!empty($_SESSION["shopping_cart"])) {
                    $total = 0;
                    foreach ($_SESSION["shopping_cart"] as $keys => $values) {
                        ?>
                        <tr style="color: white;">
                            <td>
                                <?= $values["item_name"]; ?>
                            </td>
                            <td>$
                                <?= $values["item_price"]; ?>
                            </td>
                            <td>$
                                <?= number_format($values["item_price"], 2); ?>
                            </td>
                            <td>
                                <a href="shopcart.php?action=delete&id=<?= $values["item_id"]; ?>"><span
                                        class="text-danger">Remove</span></a>
                            </td>
                        </tr>
                        <?php
                        $total += $values["item_price"] * $values["item_id"];
                    }
                    ?>
                    <tr style="color: white;">
                        <td colspan="2">Total</td>
                        <td>$
                            <?= number_format($total, 2); ?>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </div>
    <br />

</body>

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


</html>