<?php
session_start();

include('var_dump');
include('functions.php');

$pfp = GetPfpByUsername($mysqli, $username);

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}


if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    $query = "SELECT * FROM tbl_product WHERE id = $productId";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $product = $result->fetch_object();
        $productName = $product->name;
        $productDescription = $product->description;
        $productPrice = $product->price;
        $productImage = $product->image;

        // Get available sizes for the product
        $sizes = explode(',', $product->sizes); // Split the comma-separated string into an array

    } else {
        header("Location: productspage.php");
        die();
    }
} else {
    header("Location: productspage.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;0,900;1,100&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <script src="./js/header.js" defer></script>
    <link rel="stylesheet" href="./css/product.css">
    <link rel="icon" type="image/png" href="//cdn.shopify.com/s/files/1/0617/1881/files/favicon.png?crop=center&amp;height=32&amp;v=1665650486&amp;width=32">
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
    

    <section class="containerProduct">
        <div class="containerImg">
            <img class="imgcon1" src="./productimg/<?php echo $productImage; ?>" alt="">
        </div>
        <div class="containerPinfo">
            <h1><?php echo $productName; ?></h1>
            <p class="containerInfo"><?php echo $productDescription; ?></p>
            <p class="fay">Sizes:</p>
            <div class="hoi">
                <?php foreach ($sizes as $size): ?>
                <div>
                    <input type="checkbox" name="size" value="<?php echo $size; ?>" id="<?php echo $size; ?>">
                    <label for="<?php echo $size; ?>"><?php echo $size; ?></label>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="finn">
                <p class="containerPrice">€<?php echo $productPrice; ?></p>
                <button onclick="addToCart(<?php echo $productId; ?>); PopUp();">Add to Cart</button>
            </div>
        </div>
    </section>

    <div id="snackbar">Product added to cart!</div>
    
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