<?php

include('var_dump.php');
include('functions.php');

if (isset($_SESSION['username'])) {
    header('index.php');
    $username = $_SESSION['username'];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stars = $_POST['stars'];

    // Call the createReview function to insert the review into the database
    createReview($title, $content, $stars, $mysqli);
}

$sql = "SELECT title, content, stars FROM reviews";
$result = $mysqli->query($sql);
$reviews = $result->fetch_all(MYSQLI_ASSOC);

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
    <link rel="stylesheet" href="./css/productspage.css">
    <script src="./js/header.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"> </script>
    <script src="./js/active.js"></script>
    <link rel="stylesheet" href="./css/register.css">
    <title>Daily Paper - Daily Paper Worldwide</title>
</head>

<body>
    <section class="navie">
        <section class="navBar section">
            <section class="navBarLinks section">
                <section class="navBarLogo section">
                    <a class="navImgLogo" href="index.php"><img id="imgHeader" class="imgLogoHead"
                            src="/img/PhoneLogo.webp" alt=""></a>
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
            <a href="#" class="navBarProfile section" onclick="<?php if (!isset($_SESSION['username'])) {
                echo 'window.location.href = \'login.php\';';
            } else {
                echo 'window.location.href = \'profile.php\';';
            } ?>"><i class="fa-regular fa-user peetje20"></i></a>
        </section>
    </section>

    <section class="RegisterContent">
        <div class="createReview">
            <form class="createReviewForm" action="" method="post">
                <p>Title:</p>
                <input type="text" name="title" id="">
                <p>Content:</p>
                <input type="text" name="content" id="">
                <p>Stars:</p>
                <input type="number" name="stars" id="" min="1" max="5">
                <input type="submit" name="submit" value="Create Review">
            </form>
        </div>
        <div class="reviews">
            <?php foreach ($reviews as $review): ?>
                <li class="review">
                    <figure class="quote" style="font-size: 2rem; justify-content: center; width: 100%; font-weight: bold;" ><?php echo $review['title']; ?> :</figure>
                    <p>
                        <?php echo $review['content']; ?>
                    </p>
                    <section class="stars">
                        <?php for ($i = 0; $i < $review['stars']; $i++): ?>
                            &#9733;
                        <?php endfor; ?>
                    </section>
                </li>
            <?php endforeach; ?>
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