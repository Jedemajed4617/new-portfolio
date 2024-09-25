<?php


include('var_dump.php');

session_start();

$username = $_SESSION['username'];

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

function GetPfpByUsername($mysqli, $username){
    $sql = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $endresult = $result->fetch_assoc();
    if($endresult['pfp'] == null){
        return "default.png";
    }
    else{
        return $endresult['pfp'];
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
    header("location: dashboard.php");
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

?>
