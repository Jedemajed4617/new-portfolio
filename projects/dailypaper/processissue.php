<?php

include('var_dump.php');
include('functions.php');
session_start();
$username = $_SESSION['username'];


// Checken of alle gegevens zijn ingevuld
if(!isset($_POST['title'])){echo "no title was set"; die();}
if(!isset($_POST['description'])){echo "no description was set"; die();}

// Variable maken van de gegevens
$title = $_POST['title'];
$description = $_POST['description'];

$date = date("Y/m/d");
$solved = 0;

function CreateDBItemIssue($title, $description, $image, $mysqli, $username, $date, $solved){

  $sql = "INSERT INTO `issues` (username, title, description, image, date, solved) VALUES (?, ?, ?, ?, ?, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("ssssss", $username, $title, $description, $image, $date, $solved);
  $stmt->execute();
  header("Location: profile.php");
  die(); 
};

$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  $image = "uploads/default.png";
  CreateDBItemIssue($title, $description, $image, $mysqli, $username, $date, $solved);
} else{
  $imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
  $target_dir = "uploads/";
  $target_file = $target_dir . imageNameGen() . "." . $imageFileType;
  $uploadOk = 1;
}


if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 15000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $image = $target_file;
      CreateDBItemIssue($title, $description, $image, $mysqli, $username, $date, $solved);
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>