<?php

include('var_dump.php');
include('functions.php');
session_start();
$username = $_SESSION['username'];


// Checken of alle gegevens zijn ingevuld
if(!isset($_POST['name'])){echo "no name was set"; die();}
if(!isset($_POST['price'])){echo "no price was set"; die();}

// Variable maken van de gegevens
$name = $_POST['name'];
$price = $_POST['price'];

$solved = 0;

function CreateDBItemProduct($name, $price, $image, $mysqli){
  $sql = "INSERT INTO `tbl_product` (name, price, image) VALUES (?, ?, ?)";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("sss", $name, $price, $image);
  $stmt->execute();
  header("Location: index.php");
  die(); 
};

$productname = imageNameGen();
$imageFileType = strtolower(pathinfo($_FILES["fileToUpload"]["name"],PATHINFO_EXTENSION));
$target_dir = "productimg/";
$target_file = $target_dir . $productname . "." . $imageFileType;
$uploadOk = 1; 
$target_name = $productname . "." . $imageFileType;


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

//htmlspecialchars( basename( $_FILES["fileToUpload"]["name"]))


} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      $image = $target_name;
      CreateDBItemProduct($name, $price, $image, $mysqli);
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

?>