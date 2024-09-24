<?php
include('functions.php');
include('var_dump.php');


if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$rank = GetRankByUsername($mysqli, $username);
$username = $_SESSION['username'];

$pfp = GetPfpByUsername($mysqli, $username);

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

<body>
    <section class="navie">
        <section class="navBar section">
            <section class="navBarLinks section">
                <section class="navBarLogo section">
                    <a class="navImgLogo" href="index.php"><img id="imgHeader" class="imgLogoHead"
                            src="./img/PhoneLogo.webp" alt=""></a>
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
            } ?>">
                <?php if (!isset($_SESSION['username'])) { ?><i class="fa-regular fa-user"></i>
                <?php } else { ?> <img class="peetje17" src="./profiles/<?php echo $pfp; ?>" alt="" srcset="">
                <?php } ?>
            </a>
        </section>
    </section>

    <section class="ProfileContent">
        <div class="ProfileInfo">
            <div class="ProfileInfoP">
                <p>Welcome: <b>
                        <?php echo $username ?>
                    </b></p>
                <p style="padding-top: 1.5rem;">What would you like to do?</p>
            </div>
        </div>
        <div class="changepfp">
            <article class="changePFPcontainer">
                <b>Change profile picture :</b>
                <form class="formpfp" action="changepfp.php" method="POST" enctype="multipart/form-data">
                    <input class="custom-file-input" type="file" id="filetoUpload1" name="filetoUpload1"
                        accept="image/png, image/jpeg">
                    <label class="inputflexie" for="">
                        <input class="inputtext" type="submit" value="Update Image">
                    </label>
                </form>
                <figure class="flexie">
                    <?php $pfp = GetPfpByUsername($mysqli, $username); ?> <img
                        style="width: 150px; height: 150px; border-radius: 50%;" src="./profiles/<?php echo $pfp; ?>"
                        alt="">
                </figure>
            </article>
            <div id="frm" class="formpeetje19" style="text-align: center;">
                <h1 class="peetjetitle">Create Support Ticket:</h1>
                <form name="f1" action="processissue.php" method="POST" enctype="multipart/form-data">
                    <p class="peetje19">
                        <label class="peetjelabel">
                            <p class="loetje2">Title of Ticket:</p>
                            <input class="inputpeetje1" type="text" required maxlength="32" id="user" name="title">
                        </label>
                    </p>
                    <p class="peetje19">
                        <label class="peetjelabel">
                            <p class="loetje2">Description of Ticket:</p>
                            <textarea class="inputpeetje1" rows="10" cols="30" required maxlength="255" id="description"
                                name="description"></textarea>
                        </label>
                    </p>
                    <p class="peetje19">
                        <label class="peetjelabel">
                            <p class="loetje2">Screenshot of Ticket:</p>
                            <input class="ticketscreen custom-file-input1" type="file" id="fileToUpload"
                                name="fileToUpload" accept="image/png, image/jpeg">
                        </label>
                    </p>
                    <p class="peetje19">
                        <input class="createbutton" type="submit" id="btn" value="Create">
                    </p>
                </form>
                <p class="">
                    <?php if (isset($_GET['error'])) {
                        echo $_GET['error'];
                    } ?>
                </p>
            </div>
        </div>
        <div class="loetje">
            <div class="ProductTitle" style="width: 100%; height: auto;">
                <h1 style="text-align: center; font-size: 3rem; padding-top: 5rem;">View Tickets:</h1>
            </div>
            <div class="flexieissue">
                <?php
                $username = $_SESSION['username'];
                $sql = "SELECT * FROM issues WHERE username = ? AND solved = 0";
                $stmt = $mysqli->prepare($sql);
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $issues = $stmt->get_result();

                while ($row = $issues->fetch_assoc()) {
                    ?>
                    <article class="issuecon">
                        <div class="imgconissue">
                            <img src="./<?php echo $row['image'] ?>" class="mouse">
                        </div>
                        <div class="contentBox">
                            <h3 class="h3kikkerinjeknie">Title:
                                <?php echo $row['title'] ?>
                            </h3>
                            <h2 class="issuetf">Status:
                                <?php if ($row['solved'] == "1") {
                                    echo "SOLVED";
                                } else {
                                    echo "OPEN";
                                } ?>
                            </h2>
                            <div class="issuebutton">
                                <a href="issue.php?item=<?php echo $row['id'] ?>" class="openissue">Open Ticket</a>
                            </div>
                        </div>
                    </article>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="ProfileLogout">
            <form class="peetje12" action="logout.php" method="POST">
                <button class="peetje13" type="submit">Logout</button>
            </form>
            <?php if ($rank == "admin") { ?>
                <form class="peetje14" action="dashboard.php" method="POST">
                    <button type="submit">Dashboard</button>
                </form>
            <?php } ?>
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