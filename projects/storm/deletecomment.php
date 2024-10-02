<?php
include('var_dump.php');

session_start();

$username = $_SESSION['username'];

if(!isset($_GET['id'])){echo "no id was set"; die();}
if(!isset($_GET['issueid'])){echo "no issue was set"; die();}
$id = $_GET['id'];
$issueid = $_GET['issueid'];
$sql = "DELETE FROM comments WHERE id = ?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: issueinfo.php?item=$issueid");
?>