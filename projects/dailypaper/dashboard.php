<?php
include('functions.php');
include('var_dump.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    die();
}

$username = $_SESSION['username'];

$rank = GetRankByUsername($mysqli, $username);
$amountissue = IssueAmount($mysqli);
$amountusers = userAmount($mysqli);
$amountproducts = productAmount($mysqli);
$amountsolved = solvedIssues($mysqli);
$pfp = GetPfpByUsername($mysqli, $username);

if ($rank == "user"){
    header("Location: profile.php");
    die();
}else{
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
    <script src="./js/header.js" defer></script>
    <link rel="stylesheet" href="./css/dashboard.css">
    <script src="./js/active.js" defer></script>
    <title>Daily Paper - Dashboard Overview</title>
</head>

<body>
    <div class="home">
        <div class="wrapper">
            <div class="sidebar">
                <div class="profile">
                    <img style="cursor: pointer;" onclick="peetje()" src="./profiles/<?php echo $pfp; ?>"
                        style="padding: 0.5rem;" alt="profile_picture">
                    <h3>RANK:</h3>
                    <p>
                        <?php echo $rank ?>
                    </p>
                </div>
                <ul class="myDIV">
                    <li>
                        <a onclick="homepage()" id="home" class="items">
                            <span class="icon"><i class="fas fa-home"></i></span>
                            <span class="item">Home</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="" id="product" class="items">
                            <span class="icon"><i class="fas fa-desktop"></i></span>
                            <span class="item">Add products</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="" id="users" class="items">
                            <span class="icon"><i class="fas fa-user-friends"></i></span>
                            <span class="item">Users</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="" id="reviews" class="items">
                            <span class="icon"><i class="fas fa-chart-line"></i></span>
                            <span class="item">Reviews</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="" id="tickets" class="items">
                            <span class="icon"><i class="fas fa-database"></i></i></span>
                            <span class="item">Tickets</span>
                        </a>
                    </li>
                    <li>
                        <a onclick="" id="settings" class="items">
                            <span class="icon"><i class="fas fa-cog"></i></span>
                            <span class="item">Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <section class="homepage">
            <div class="homepageTitel">
                <h1>Welcome Back!</h1>
                <h1>
                    <?php echo $username ?>
                </h1>
            </div>
            <div class="homepageContent">
                <div class="InfoCards">
                    <h1>Amount of Products</h1>
                    <p>
                        <?php echo $amountproducts; ?>
                    </p>
                </div>
                <div class="InfoCards">
                    <h1>Amount of Tickets</h1>
                    <p>
                        <?php echo $amountissue; ?>
                    </p>
                </div>
                <div class="InfoCards">
                    <h1>Amount of Reviews</h1>
                    <p>0</p>
                </div>
                <div class="InfoCards">
                    <h1>Amount of Accounts</h1>
                    <p>
                        <?php echo $amountusers; ?>
                    </p>
                </div>
                <div class="InfoCards">
                    <h1>Amount of Sales</h1>
                    <p>0</p>
                </div>
                <div class="InfoCards">
                    <h1>Amount of Visitors</h1>
                    <p>
                        <?php $amountVisitors = trackVisitors();
                        echo $amountVisitors; ?>
                    </p>
                </div>
                <div class="InfoCards">
                    <h1>Amount of Collabs</h1>
                    <p>0</p>
                </div>
                <div class="InfoCards">
                    <h1>Amount of </h1>
                    <p>0</p>
                </div>
            </div>
        </section>

        <section class="ProductPage">
            <div class="ProductTitle">
                <h1>Upload a new product:</h1>
            </div>
            <div class="ProductInputContainer">
                <form name="f1" action="createproduct.php" method="POST" enctype="multipart/form-data">
                    <input required class="inputtext" type="text" placeholder="Name of product" id="user" name="name">
                    <input required class="inputtext" type="text" placeholder="Price of Product" id="price"
                        name="price">
                    <label style="color: white; font-size: 1.4rem;" for="">
                        <input style="margin-left: 2rem;" type="checkbox" name="sizes[]" value="XS"> XS
                        <input style="margin-left: 2rem;" type="checkbox" name="sizes[]" value="S"> S
                        <input style="margin-left: 2rem;" type="checkbox" name="sizes[]" value="M"> M<br>
                        <input style="margin-left: 2rem;" type="checkbox" name="sizes[]" value="L"> L
                        <input style="margin-left: 2rem;" type="checkbox" name="sizes[]" value="XL"> XL
                        <input style="margin-left: 2rem;" type="checkbox" name="sizes[]" value="XXL"> XXL
                    </label>
                    <label class="checkie">
                        <input required class="custom-file-input" type="file" src="" alt="PNG, GIF, JPEG or JPG only!"
                            id="fileToUpload" name="fileToUpload" accept="image/png, image/jpeg">
                    </label>
                    <input class="buttonC1 buttontje" id="btn" type="submit" value="Upload product">
                </form>
            </div>
        </section>

        <section class="UsersPage">
            <div class="ProductTitle">
                <h1>View all Users:</h1>
            </div>
            <div class="usertable">
                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Assuming you have a valid database connection ($mysqli) established
                        
                        // Fetch all users from the database
                        $sql = "SELECT * FROM users";
                        $result = $mysqli->query($sql);

                        // Check if any users exist
                        if ($result->num_rows > 0) {
                            // Loop through each user row and generate table rows dynamically
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $row['username']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['password']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['email']; ?>
                                    </td>
                                    <td>
                                        <?php echo $row['rank']; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            // If no users found, display a message
                            ?>
                        <tr>
                            <td colspan="4">No users found.</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="ReviewsPage">
            <div class="ProductTitle">
                <h1>All Reviews in one Place:</h1>
            </div>
            <div class="ReviewContent">
                <div class="ReviewCard">
                    <p class="usernameReview">Username:</p>
                    <p class="contentReview">Content:</p>
                    <p class="starsReview">Stars:</p>
                </div>
                <div class="ReviewCard">
                    <p class="usernameReview">Username:</p>
                    <p class="contentReview">Content:</p>
                    <p class="starsReview">Stars:</p>
                </div>
                <div class="ReviewCard">
                    <p class="usernameReview">Username:</p>
                    <p class="contentReview">Content:</p>
                    <p class="starsReview">Stars:</p>
                </div>
                <div class="ReviewCard">
                    <p class="usernameReview">Username:</p>
                    <p class="contentReview">Content:</p>
                    <p class="starsReview">Stars:</p>
                </div>
                <div class="ReviewCard">
                    <p class="usernameReview">Username:</p>
                    <p class="contentReview">Content:</p>
                    <p class="starsReview">Stars:</p>
                </div>
            </div>
        </section>

        <section class="TicketsPage">
            <div class="ProductTitle">
                <h1>Review Tickets:</h1>
            </div>
            <div class="flexieissue">
                <?php
                $issues = GetAllIssues($mysqli);
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
        </section>

        <section class="SettingsPage">
            <div class="ProductTitle">
                <h1>Change Settings:</h1>
            </div>
        </section>
    </div>

</body>

</html>
<?php }?>