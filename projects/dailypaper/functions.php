<?php
include('var_dump.php');

session_start();

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

function imageNameGen() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $namee = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $namee[] = $alphabet[$n];
    }
    return implode($namee);
}

function GetRankByUser($username, $mysqli){
    $sql = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult['rank'];

};

function GetAllIssues($mysqli){
    $sql = "SELECT * FROM `issues`";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function GetIssueById($mysqli, $id){
    $sql = "SELECT * FROM `issues` WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult;
}

function GetCommentsByIssueID($mysqli, $issueid){
    $sql = "SELECT * FROM `comments` WHERE issueid = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $issueid);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

function GetPfpByUsername($mysqli, $username) {
    $sql = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== null && $endresult = $result->fetch_assoc()) {
        if ($endresult['pfp'] == null) {
            return "default.png";
        } else {
            return $endresult['pfp'];
        }
    } else {
        return "default.png"; // Return a default value when no results are found
    }
}

function GetRankByUsername($mysqli, $username){
    $sql = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult['rank'];
}

function UpdatePfp($mysqli, $username, $image){
    $sql = "UPDATE users SET pfp=? WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $image, $username);
    $stmt->execute();
    header("location: profile.php");
}

function IssueAmount($mysqli){
    $sql = "SELECT COUNT(*) as issues FROM issues;";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult['issues'];
}

function userAmount($mysqli){
    $sql = "SELECT COUNT(*) as users FROM users;";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult['users'];
}

function productAmount($mysqli){
    $sql = "SELECT COUNT(*) as tbl_product FROM tbl_product;";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult['tbl_product'];    
}

function solvedIssues($mysqli){
    $sql = "SELECT COUNT(*) as solved FROM issues WHERE solved = 1;";
    $stmt = $mysqli->prepare($sql);
    $stmt->execute(); 
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult['solved'];   
}

function GetUsernameByEmail($mysqli, $email){
    $sql = "SELECT * FROM `users` WHERE `email` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    return $endresult['username'];   
}

// track visitor count: 
function trackVisitors() {
    $file = 'visitors.txt';
  
    if (file_exists($file)) {
        $count = file_get_contents($file);
        $count++;
        file_put_contents($file, $count);
    } else {
        $count = 1;
        file_put_contents($file, $count);
    }
  
    return $count;
}

function createReview($title, $content, $stars, $mysqli) {
    // Validate stars value
    if ($stars < 1 || $stars > 5) {
        header("Location: reviews.php?error=InvalidStars");
        die();
    }

    // Prepare and execute the INSERT query
    $sql = "INSERT INTO reviews (title, content, stars) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $stars);
    $stmt->execute();

    // Redirect to prevent form resubmission
    header("Location: reviews.php");
    die();
}

?>