<?php
session_start();
include "db_conn.php";

?>
<!DOCTYPE html>
<html lang="en">
<!-- oncontextmenu="return false" -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flavorflow - Order now</title>
    <link rel="stylesheet" href="./css/main.css">
    <script src="./js/deliveryORpickup.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="language-container" style="position: fixed;">
        <div class="dropdown">
            <button onclick="dropDownButton()" class="dropbtn">Language <span class="arrow">&#129171;</span></button>
            <div id="myDropdown" class="dropdown-content">
                <a href="#" onclick="">ENGLISH</a>
                <a href="#" onclick="">NEDERLANDS</a>
                <a href="#" onclick="">DEUTSCH</a>
                <a href="#" onclick="">ESPAÑOL</a>
            </div>
        </div>
    </div>
    <div class="orderoption">
        <div class="orderoptioncontainer">
            <div class="orderoptioncontainer2">
                <div class="orderoptionimgcontainer"></div>
                <form class="orderoptionform">
                    <div class="orderoptionheadingcontainer">
                        <h1>FlavowFlow.</h1>
                        <p>
                            How would you like to proceed?
                        </p>
                    </div>
                    <div class="orderoptions">
                        <div class="orderoptioninputcontainer">
                            <p>
                                Pickup
                            </p>
                            <button id="pickupButton" class="orderoptionbutton" type="button" value="pickup">
                                <i class="fa-solid fa-person-walking-arrow-right orderoptionicon"></i>
                            </button>
                        </div>
                        <div class="orderoptioninputcontainer">
                            <p>
                                Delivery
                            </p>
                            <button id="deliveryButton" class="orderoptionbutton" type="button" value="delivery">
                                <i class="fa-solid fa-truck orderoptionicon"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>