<?php
include('var_dump.php');
include('functions.php');


$username = $_SESSION['username'];

$rank = GetRankByUsername($mysqli, $username);

if(!isset($_GET['issueid'])){echo "no issue was set"; die();}
$issueid = $_GET['issueid'];
$sql = "UPDATE issues SET solved = 1 WHERE id = ?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $issueid);
$stmt->execute();
if ($rank == "admin"){ 
    header("Location: dashboard.php?item=$issueid"); 
}else{ 
    header("Location: profile.php?item=$issueid"); 
}

?>