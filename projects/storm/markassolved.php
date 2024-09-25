<?php
include('var_dump.php');
include('functions.php');

session_start();

$username = $_SESSION['username'];

if(!isset($_GET['issueid'])){echo "no issue was set"; die();}
$issueid = $_GET['issueid'];
$sql = "UPDATE issues SET solved = 1 WHERE id = ?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $issueid);
$stmt->execute();
header("Location: issueinfo.php?item=$issueid");
?>