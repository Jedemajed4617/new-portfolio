<?php

include('functions.php');
include('var_dump');

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$pfp = GetPfpByUsername($mysqli, $username);

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
    <script src="./js/main.js" defer></script>
    <link rel="icon" type="image/png" href="//cdn.shopify.com/s/files/1/0617/1881/files/favicon.png?crop=center&amp;height=32&amp;v=1665650486&amp;width=32">
    <title>Daily Paper - Daily Paper Worldwide</title>
</head>

<body>

    <nav class="nav">
        <section class="topText">
            <a href="" class="topTextHeader">New in: Daily Paper x Fatboy</a>
            <div class="topTextOptions">
                <a href="" class="topTextCountry">Worldwide</a>
                <a href="" class="topTextLang">English</a>
            </div>
        </section>
    </nav>

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
                <div class="navBarSectie">
                    <input type="text" class="navBarSearch section" placeholder="Search">
                    <button class="navBarUnite section">Unite</button>
                    <a href="cart.php" class="navBarShop section"><i class="fa-solid fa-cart-shopping"></i></a>
                    <a href="#" class="navBarProfile section" onclick="<?php if(!isset($_SESSION['username'])) { echo 'window.location.href = \'login.php\';'; } else { echo 'window.location.href = \'profile.php\';'; } ?>"><?php if(!isset($_SESSION['username'])) { ?><i class="fa-regular fa-user peetje20"></i><?php } else{?> <img class="peetje17" src="./profiles/<?php echo $pfp; ?>" alt="" srcset=""><?php }?></a>
                </div>
            </section>
    </section>
    <section class="imgcon">
        <p class="imgCaptionTitle">Collaboration</p>
        <h1 class="imgCaption">Daily Paper <small>x</small> Fatboy</h1>
        <button class="imgCaptionButton"><a href="productspage.php">Shop Now</a></button>
    </section>

    <div class="plaatjeC">
        <div class="imgPlaatjeC">
            <img src="./img/DP-handbag.webp" alt="" srcset="">
        </div>
        <div class="plaatjePC">
            <h1>Check out our all handbags</h1>
            <p>New collection now in, check out all our handbags with a discount of 15% for your first order!</p>
            <button><a href="productspage.php">Shop Now</a></button>
        </div>
    </div>

    <div class="product-box">
        <div class="feat">
            <p>Featured Items:</p>
        </div>
        <div class="arrowbtn second_arrow">
            <button class="left"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="right"><i class="fa-solid fa-chevron-right"></i></button>
        </div>
        <div class="slide-product">
            <!-- All sliding Div will appear here -->
        </div>
    </div>

    <section class="InfoC">
        <ul class="infoCC">
            <div class="infoContentCaption">
                <h1>Full Sets Available Now!</h1>
                <button><a href="productspage.php">SHOP NOW</a></button>
            </div>
        </ul>
    </section>

    <div class="divie">
        <h1>Sign Up For VIP!</h1>
        <ul class="stepsContainer">
            <li class="stepsItem">
                <h1 class="stepsItemHeading">Step 1:</h1>
                <p class="stepsItemP">Create an account with us and <b>verify</b> your email.</p>
            </li>
            <li class="stepsItem">
                <h1 class="stepsItemHeading">Step 2:</h1>
                <p class="stepsItemP">Log in and navigate to <br> <b>Settings</b> > <b>Account</b> > <b>Member</b> and sign up.</p>
            </li>
            <li class="stepsItem">
                <h1 class="stepsItemHeading">Step 3:</h1>
                <p class="stepsItemP">Then select your payment method (Once payment has been recieved you'll get an email)</p>
            </li>
            <li class="stepsItem">
                <h1 class="stepsItemHeading">Step 4:</h1>
                <p class="stepsItemP">Enjoy the benefits, wan't to know what they are? Press the button below!</p>
            </li>
        </ul>
        <div>
            <button>More info</button>
        </div> 
    </div>

    <script src="./js/slider.js"></script>

    <div class="containerFoto">
        <div class="containerItem1 zoom-effect">
            <p class="containerP1">Mannenmode</p>
            <button class="containerB1"><a href="https://zylva.nl/pages/mannenmode">Press Here</a></button>
        </div>
        <div class="containerItem2 zoom-effect">
            <p class="containerP1">Vrouwenmode</p>
            <button class="containerB1"><a href="https://zylva.nl/pages/vrouwenmode">Press Here</a></button>
        </div>
    </div>
    <div class="containerFoto">
        <div class="containerItem3 zoom-effect">
            <p class="containerP1">Summer '24</p>
            <button class="containerB1"><a href="https://zylva.nl/pages/summer">Press Here</a></button>
        </div>
        <div class="containerItem4 zoom-effect">
            <p class="containerP1">New In</p>
            <button class="containerB1"><a href="https://zylva.nl/pages/nieuw-binnen">Press Here</a></button>
        </div>
    </div>

    <div class="plaatjeC">
        <div class="plaatjePC">
            <h1>Check out our glasses</h1>
            <p>New collection now in, check out all our glasses with a discount of 10% for your first order!</p>
            <button><a href="productspage.php">Shop Now</a></button>
        </div>
        <div class="imgPlaatjeC">
            <img src="./img/sunglasses.webp" alt="" srcset="">
        </div>
    </div>

    <section class="section section3">
        <button class="arrow"><</button>
        <ul class="reviews">
            <li class="review">
                <figure class="quote">&#10077;</figure>
                <section class="stars">&#9733; &#9733; &#9733;</section>
                <p>
                    1. I love Daily paper, it is the best clothing brand in the game!
                </p>
            </li>
            <li class="review">
                <figure class="quote">&#10077;</figure>
                <section class="stars">&#9733; &#9733; &#9733; &#9733;</section>
                <p>
                    2. My delivery was supposed to come within 5 days, I already got mine within
                    2 days! Great service!
                </p>
            </li>
            <li class="review">
                <figure class="quote">&#10077;</figure>
                <section class="stars">&#9733;&#9733;&#9733;</section>
                <p>
                    3. I am a website devloper and the website looks so nice and it just works!
                </p>
            </li>
            <li class="review">
                <figure class="quote">&#10077;</figure>
                <section class="stars">&#9733;&#9733;&#9733;&#9733;&#9733;</section>
                <p>
                    4. The new summer collection is really good!
                </p>
            </li>
            <li class="review">
                <figure class="quote">&#10077;</figure>
                <section class="stars">&#9733;&#9733;</section>
                <p>
                    5. I bought a fatboy x dailypaper collab and it just arrived, it so comfy!
                </p>
            </li>
            <li class="review">
                <figure class="quote">&#10077;</figure>
                <section class="stars">&#9733;&#9733;&#9733;</section>
                <p>
                    6. The new summer collection makes me so happy, the clothin quality is Great
                    and all the clothing i bought fits!
                </p>
            </li>
        </ul>
        <button class="arrow">></button>
    </section>

    <section class="ViewmoreCon">
        <ul class="ViewmoreTextCon">
            <p class="ViewmoreText">View more reviews or write your own!</p>
            <div class="ViewmoreButton1">
                <button class="ViewmoreButton"><a href="reviews.php">Click Here</a></button>
            </div>
        </ul>
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