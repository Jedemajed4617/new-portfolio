<?php
include('var_dump.php');
include('functions.php');

session_start();

$rank = GetRankByUsername($mysqli, $username);

if(!isset($_GET['id'])){echo "no issue was set"; die();}
$id = $_GET['id'];
$sql = "DELETE FROM issues WHERE id = ?;";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
if ($rank == "admin"){ header("Location: dashboard.php");}else{header("Location: profile.php");}
?>