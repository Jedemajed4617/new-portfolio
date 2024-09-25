<?php
include('var_dump.php');


if(!isset($_POST['solution'])){echo "no user was set"; die();}
if(!isset($_GET['username'])){echo "no username was set"; die();}
if(!isset($_GET['issueid'])){echo "no issue was set"; die();}

$username = $_GET['username'];
$solution = $_POST['solution'];
$issueid = $_GET['issueid'];
$date = date("Y/m/d");


$sql = "INSERT INTO `comments` (username, solution, date, issueid) VALUES (?, ?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ssss", $username, $solution, $date, $issueid);
$stmt->execute();



// Sessie starten en doorsturen naar het dashboard
session_start();
$_SESSION['username']=$username;
header("Location: issueinfo.php?item=$issueid");
die(); 

?>