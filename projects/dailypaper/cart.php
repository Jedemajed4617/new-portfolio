<?php
session_start();

include('functions.php');
include('var_dump');

$pfp = GetPfpByUsername($mysqli, $username);

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}


// Retrieve the total price of the cart
$totalPrice = calculateTotalPrice($mysqli);

// Function to calculate the total price
function calculateTotalPrice($mysqli) {
    $totalPrice = 0;

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $productIds = array_keys($_SESSION['cart']);
        $productIdList = implode(',', $productIds);

        $query = "SELECT SUM(price) AS total_price FROM tbl_product WHERE id IN ($productIdList)";
        $result = $mysqli->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $totalPrice = $row['total_price'];
        }
    }

    return $totalPrice;
}

if (isset($_GET['action']) && $_GET['action'] === 'remove') {
    if (isset($_GET['productId'])) {
        $productId = $_GET['productId'];
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        header('Location: cart.php');
        exit();
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="//cdn.shopify.com/s/files/1/0617/1881/files/favicon.png?crop=center&amp;height=32&amp;v=1665650486&amp;width=32">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;0,900;1,100&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/shopcart.css">
    <script src="./js/header.js" defer></script>
    <title>Daily Paper - Daily Paper Worldwide</title>
</head>
<body>
    <section class="navie">
        <section class="navBar section">
            <section class="navBarLinks section">
                <section class="navBarLogo section">
                    <a class="navImgLogo" href="index.php"><img id="imgHeader" class="imgLogoHead" src="/img/PhoneLogo.webp" alt=""></a>
                    <a class="navLogoLink section" href="index.php">Daily Paper</a>
                </section>
                <section class="navBarLinkc section">
                    <a class="navBarLink hover-underline-animation section" href="productspage.php">Men</a>
                    <a class="navBarLink hover-underline-animation section" href="productspage.php">Women</a>
                    <a class="navBarLink hover-underline-animation section" href="productspage.php">Accessories</a>
                </section>
            </section>
        </section>
        <section class="navBarSection section">
            <input type="text" class="navBarSearch section" placeholder="Search">
            <button class="navBarUnite section">Unite</button>
            <a href="cart.php" class="navBarShop section"><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="#" class="navBarProfile section" onclick="<?php if(!isset($_SESSION['username'])) { echo 'window.location.href = \'login.php\';'; } else { echo 'window.location.href = \'profile.php\';'; } ?>"><?php if(!isset($_SESSION['username'])) { ?><i class="fa-regular fa-user"></i><?php } else{?> <img class="peetje17" src="./profiles/<?php echo $pfp; ?>" alt="" srcset=""><?php }?></a>
        </section>
    </section> 

    <section class="ContainerShopCart">
    <?php
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $productId => $size) {
                // Retrieve product details from the database based on the $productId
                $query = "SELECT * FROM tbl_product WHERE id = $productId";
                $result = $mysqli->query($query);

                $_SESSION['cart'][$productId] = $size;

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $productName = $row['name'];
                    $productImage = $row['image'];
                    // Other product details

                    // Display the product in the cart
                    echo '<ul class="ShopItem">';
                    echo '<div class="ShopImgCon">';
                    echo '<img class="ShopImg" src="./productimg/' . $productImage . '" alt="">';
                    echo '</div>';
                    echo '<div class="ShopCartPC">';
                    echo '<p class="ShopCartP">' . $productName . '</p>';
                    echo '</div>';
                    echo '<div class="figureC">';
                    echo '<p class="ShopCartP">' . $size . '</p>'; // Display the selected size
                    echo '</div>';
                    echo '<div class="peetje14">';
                    echo '<button class="peetje15" onclick="window.location.href=\'cart.php?action=remove&productId=' . $productId . '\'">Remove</button>'; // Add remove button with onclick event
                    echo '</div>';
                    echo '</ul>';
                } else {
                    unset($_SESSION['cart'][$productId]);
                    echo '<p>Product not found and removed from cart!</p>';
                }
            }
        } else {
            echo '<p style="font-size: 2rem;">No items in the cart</p>';
        }
        ?>
    </section>

    <section class="ShopcartPrice">
    <div class="ShopcartpriceC">
        <p class="ShopcartPriceP">Total Price:</p>
        <p class="ShopcartPriceP">€ <?php echo $totalPrice; ?></p> <!-- Display the total price -->
    </div>
    </section>

    <footer class="footer">
        <div>
            <ul>
                <p class="news">Newsletter</p>
                <li>Sign up to be the first to know about drops, special offers and more.</li>
                <li>I’m interested in:</li>
                <div class="check">
                    <div>
                        <input type="checkbox" name="" id="">
                        <p>Menswear</p>
                    </div>
                    <div>
                        <input type="checkbox" name="" id="">
                        <p>Womenswear</p>
                    </div>
                    <div>
                        <input type="checkbox" name="" id="">
                        <p>Both</p>
                    </div>
                </div>
                <div class="peetje1">
                    <input class="emailjaja" placeholder="Email adress" type="text">
                    <button class="subbiemittie" type="submit">Submit</button>
                </div>
                <div class="agree">
                    <input type="checkbox" name="" id="">
                    <p>I agree to the Privacy Policy</p>
                </div>
                
            </ul>
            <ul class="">
                <b>Daily Paper</b>
                <li style="padding-top: 1rem;"><a href="">UNITE</a></li>
                <li><a href="">Careers</a></li>
                <li><a href="">Stores</a></li>
                <li style="visibility: hidden;"><a href=""></a>q</li>
                <li style="visibility: hidden;"><a href=""></a>q</li>
                <li style="visibility: hidden;"><a href=""></a>q</li>
            </ul>
            <ul class="">
                <b>Get help</b>
                <li style="padding-top: 1rem;"><a href="">FAQ</a></li>
                <li><a href="">Shipping</a></li>
                <li><a href="">Returns</a></li>
                <li><a href="">Payments</a></li>
                <li><a href="">Contact us</a></li>
            </ul>
            <ul class="">
                <b>Legal</b>
                <li style="padding-top: 1rem;"><a href="">Terms of Service</a></li>
                <li><a href="">Privacy Policy</a></li>
                <li><a href="">Cookie Policy</a></li>
                <li><a href="">Disclaimer</a></li>
                <li><a href="">Warranty and Aeturns Agreement</a></li>
            </ul>
            <ul class="">
                <b>Social</b>
                <li style="padding-top: 1rem;"><a href="">Twitter</a></li>
                <li><a href="">Facebook</a></li>
                <li><a href="">Instagram</a></li>
                <li><a href="">Tiktok</a></li>
                <li><a href="">Youtube</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>