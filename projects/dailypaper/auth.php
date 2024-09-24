<?php

include('var_dump.php');
include('functions.php');

if(!isset($_POST['user'])){echo "no user was set"; die();}
if(!isset($_POST['pass'])){echo "no password was set"; die();}

$username = $_POST['user'];
$password = $_POST['pass'];

$sql = "SELECT * FROM `users` WHERE `username` = ?";
$sql1 = "SELECT * FROM `users` WHERE `email` = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$endresult = $result->fetch_assoc();
$hashedpassword = $endresult['password'];
if (!$endresult){
    $stmt1 = $mysqli->prepare($sql1);
    $stmt1->bind_param("s", $username);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $endresult1 = $result1->fetch_assoc();
    $hashedpassword1 = $endresult1['password'];
    if (!$endresult1){
        header("Location: login.php?error=Username/Email or password incorrect");
        die();
    }
    if(password_verify($password, $hashedpassword1)){
        $username1 = GetUsernameByEmail($mysqli, $username);
        session_start();
        $_SESSION['username']=$username1;
        header("Location: profile.php");
        die(); 
    }
    else
    {
        header("Location: login.php?error=Username/Email or password incorrect");
        die();
    };  
} 



if(password_verify($password, $hashedpassword)){
    session_start();
    $_SESSION['username']=$username;
    header("Location: profile.php");
    die(); 
}
else
{
    header("Location: login.php?error=Username/Email or password incorrect1");
    die();
};


?>