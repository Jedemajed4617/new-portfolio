<?php

include('functions.php');
$pfp = GetPfpByUsername($mysqli, $username);

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

include('var_dump');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png"
        href="//cdn.shopify.com/s/files/1/0617/1881/files/favicon.png?crop=center&amp;height=32&amp;v=1665650486&amp;width=32">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,400;0,900;1,100&display=swap"
        rel="stylesheet">
    <script src="https://kit.fontawesome.com/5a883bd754.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/productspage.css">
    <script src="./js/header.js"></script>
    <title>Daily Paper - Daily Paper Worldwide</title>
</head>

<body onload="setCheckboxStates()">
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
            <a href="#" class="navBarProfile section" onclick="<?php if(!isset($_SESSION['username'])) { echo 'window.location.href = \'login.php\';'; } else { echo 'window.location.href = \'profile.php\';'; } ?>"><?php if(!isset($_SESSION['username'])) { ?><i class="fa-regular fa-user"></i><?php } else{?> <img class="peetje17" src="./profiles/<?php echo $pfp; ?>" alt="" srcset=""><?php }?></a>
        </section>
    </section>

    <section class="container">
        <div class="ContainerFilter">
            <div class="FiltersPhone">
                <div class="FilterPrijs">
                    <label for="touch"><span>price</span></label>
                    <input type="checkbox" id="touch">
                    <ul class="slide">
                        <li><a href="#">Low to High</a></li>
                        <li class="peetje6"><a href="#">High to Low</a></li>
                    </ul>
                </div>
                <div class="FilterPrijs1">
                    <label for="touch1"><span>Sort</span></label>
                    <input type="checkbox" id="touch1">
                    <ul class="slide1" id="sizeFilter">
                        <li><input class="klaasie8" type="checkbox" name="size" value="XS" onclick="applyFilters()">XS</li>
                        <li><input class="klaasie8" type="checkbox" name="size" value="S" onclick="applyFilters()">S</li>
                        <li><input class="klaasie8" type="checkbox" name="size" value="M" onclick="applyFilters()">M</li>
                        <li><input class="klaasie8" type="checkbox" name="size" value="L" onclick="applyFilters()">L</li>
                        <li><input class="klaasie8" type="checkbox" name="size" value="XL" onclick="applyFilters()">XL</li>
                        <li><input class="klaasie8" type="checkbox" name="size" value="XXL" onclick="applyFilters()">XXL</li>
                    </ul>
                </div>
                <div class="FilterPrijs1">
                    <label for="touch2"><span>Other</span></label>
                    <input type="checkbox" id="touch2">
                    <ul class="slide2">
                        <li><a href="#">Summer '23</a></li>
                        <li><a href="#">Collabs</a></li>
                        <li class="peetje6"><a href="#">On Sale</a></li>
                    </ul>
                </div>
            </div>
            <ul class="ContainerFilters">
                <p class="ContainerFiltersP">Sort</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="" id="">Newest arrivals</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="" id="">Price ascending</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="" id="">Price descending</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="" id="">Best sellers</p>
            </ul>
            <ul id="sizeFilter" class="ContainerFilters">
                <p class="ContainerFiltersP">Sizes</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="size" value="XS" onclick="applyFilters()">XS</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="size" value="S" onclick="applyFilters()">S</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="size" value="M" onclick="applyFilters()">M</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="size" value="L" onclick="applyFilters()">L</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="size" value="XL" onclick="applyFilters()">XL</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="size" value="XXL" onclick="applyFilters()">XXL</p>
                <button id="resetSizeFilterButton" onclick="resetSizeFilter()">Reset Size Filter(s)</button>
            </ul>
            <ul class="ContainerFilters">
                <p class="ContainerFiltersP">Other</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="" id="">Summer '23</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="" id="">Collabs</p>
                <p class="ContainerFilterIP"><input class="peetje5" type="checkbox" name="" id="">On Sale</p>
            </ul>
        </div>
        <section class="ContainerProducts">
            <?php
            $selectedSizes = isset($_GET['sizes']) ? $_GET['sizes'] : [];

            $sort = $_GET['sort'] ?? 'asc';
            $query = "SELECT * FROM tbl_product";

            if (!empty($selectedSizes)) {
                $sizeConditions = array_map(function ($size) {
                    return "FIND_IN_SET('$size', sizes)";
                }, $selectedSizes);
                $sizesCondition = implode(' OR ', $sizeConditions);
                $query .= " WHERE $sizesCondition";
            }

            $query .= " ORDER BY price $sort";
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                while ($product = $result->fetch_object()) {
                    $productURL = "product.php?id=" . $product->id;
                    ?>
                    <ul class="ProductCardContainer">
                        <div class="imgContainer">
                            <img class="ProductImg" src="./productimg/<?= $product->image; ?>" alt="">
                        </div>
                        <div class="ProductTextContainer">
                            <h1>
                                <?php echo $product->name; ?>
                            </h1>
                            <p>€
                                <?php echo $product->price; ?>
                            </p>
                            <div class="peetje7">
                                <a class="button" href="<?php echo $productURL; ?>">View</a>
                            </div>
                        </div>
                    </ul>
                    <?php
                }
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </section>
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