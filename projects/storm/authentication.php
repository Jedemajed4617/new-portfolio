<?php

include('var_dump.php');

if(!isset($_POST['user'])){echo "no user was set"; die();}
if(!isset($_POST['pass'])){echo "no password was set"; die();}

$username = $_POST['user'];
$password = $_POST['pass'];

$sql = "SELECT * FROM `users` WHERE `username` = ?";


$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$endresult = $result->fetch_assoc();
$hashedpassword = $endresult['password'];
if (!$endresult){
    header("Location: login.php?error=Username or password incorrect");
    die();
} 



if(password_verify($password, $hashedpassword)){
    session_start();
    $_SESSION['username']=$username;
    header("Location: dashboard.php");
    die(); 
}
else
{
    header("Location: login.php?error=Username or password incorrect");
    die();
};


?>