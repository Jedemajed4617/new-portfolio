<?php

include('functions.php');
include('var_dump');
$pfp = GetPfpByUsername($mysqli, $username);

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

if(isset($_GET['item'])){
    $id = $_GET['item'];
}
else{
    // header("Location: profile.php");
    die();
}

$rank = GetRankByUser($username, $mysqli);

$issues = GetAllIssues($mysqli);
$issue = GetIssueById($mysqli, $id);
$comments = GetCommentsByIssueID($mysqli, $issue['id']);
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
    <title>Daily Paper - Daily Paper Worldwide</title>
</head>
<body>
    <section class="issuecontainer">
        <article class="issuecontainer1">
            <div class="issuecontainer2">
                <center class="peetje61">
                    <?php if ($rank == "admin"){ ?>
                    <a class="peetje60" href="deleteissue.php?id=<?php echo $issue['id']?>" class="">Delete</a>
                    <?php } ?>
                    <a class="peetje60" href="markassolved.php?issueid=<?php echo $issue['id']?>" class="">Mark as solved</a>
                    <a class="peetje60" href="<?php if ($rank == "admin"){ ?> dashboard.php <?php }else{ ?>profile.php <?php } ?>" class="">Close</a>
                </center>
                <h1 class="peetje59">Title: <p><?php echo $issue['title']?></p></h1>
                <h1 class="peetje59">Created by: <p><?php echo $issue['username']?></p></h1>
                <h1 class="peetje57">Description: </h1>
                <p class="peetje58"><?php echo $issue['description']?></p>
                <img id="fully" width="100" class="imgissue" src="./<?php echo $issue['image']?>">
                <p class="imgp" onclick="toggleFullScreen('fully')">Full screen</p>
                <form class="issueplacecommentform" name="f1" action="placecomment.php?username=<?php echo $username;?>&issueid=<?php echo $issue['id']?>" method="POST" enctype="multipart/form-data">
                    <p>
                        <h1 class="peetje99">Comment yourself: </h1>
                        <textarea class="peetje89" rows="5" cols="50" required placeholder="Place a comment" id="description" name="solution"></textarea>
                    </p>
                    <p class="buttonissuec">
                        <input class="" type="submit" id="btn" value="Place">
                    </p>
                </form>
                <h1 class="peetje55">Solutions / Comments: </h1>
                <?php
                while ($row = $comments->fetch_assoc()) {
                $pfp = GetPfpByUsername($mysqli, $row['username']);
                ?>
                <div class="commentbox">
                    <div class="commentProfile">
                        <img width="50px" height="50px" src="./profiles/<?php echo $pfp;?>">
                        <p1> <?php echo $row['username']?> | <?php echo GetRankByUsername($mysqli, $row['username'])?>: </p1>
                    </div>
                    <div class="comments">
                        <p><?php echo $row['solution']?></p>
                        <?php if ($rank == "admin"){ ?>
                        <a style="color: red; font-size: 2.2rem;" href="deletecomment.php?id=<?php echo $row['id']?>&issueid=<?php echo $issue['id']?>">✖</a>
                        <?php } ?>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </article>
    </section>   
</body>