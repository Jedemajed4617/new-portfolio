<?php
include('var_dump.php');

session_start();


if(!isset($_GET['id'])){echo "no issue was set"; die();}
$id = $_GET['id'];
$sql = "DELETE FROM issues WHERE id = ?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
header("Location: issues.php");
?>