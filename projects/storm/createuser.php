<?php
include('var_dump.php');

// Checken of alle gegevens zijn ingevuld
if(!isset($_POST['user'])){echo "no user was set"; die();}
if(!isset($_POST['pass'])){echo "no password was set"; die();}
if(!isset($_POST['pass2'])){echo "no repeat password was set"; die();}
if(!isset($_POST['rank'])){echo "no rank was set"; die();}

// Variable maken van de gegevens
$username = $_POST['user'];
$password = $_POST['pass'];
$password2 = $_POST['pass2'];
$rank = $_POST['rank'];

// Checken of Password en Password repeat hetzelfde zijn
if($password !== $password2){header("Location: register.php?error=Passwords do not match!"); die();};


// Checken of de gegevens niet te lang zijn
if(strlen($username) > 15){
    header("Location: register.php?error=Username is te lang!");
    die(); 
}
if(strlen($password) > 15){
    header("Location: register.php?error=Wachtwoord is te lang!");
    die(); 
}
if(strlen($rank) > 15){
    header("Location: register.php?error=Ongeldige rank!");
    die(); 
}

// Password hashen
$safepassword = password_hash($password, PASSWORD_BCRYPT);


// Checken of gebruiker al bestaat
$sql = "SELECT * FROM `users` WHERE `username` = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$endresult = $result->fetch_assoc();
if ($endresult){
    header("Location: register.php?error=Username bestaat al!");
    die();
} 


// Gebruiker aanmaken
$sql = "INSERT INTO `users` (username, password, rank) VALUES (?, ?, ?)";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $username, $safepassword, $rank);
$stmt->execute();



// Sessie starten en doorsturen naar het dashboard
session_start();
$_SESSION['username']=$username;
header("Location: dashboard.php");
die(); 

?>