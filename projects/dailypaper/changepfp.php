<?php
session_start();
include('functions.php');
include('var_dump');

if (!isset($_SESSION['username'])) {
    echo "User is not logged in.";
    die();
}

$username = $_SESSION['username'];

$imageFileType = strtolower(pathinfo($_FILES["filetoUpload1"]["name"], PATHINFO_EXTENSION));
$target_dir = "profiles/";
$generated = imageNameGen();
$target_file = $target_dir . $generated . "." . $imageFileType;
$target_name = $generated . "." . $imageFileType;
$uploadOk = 1;

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["filetoUpload1"]["tmp_name"]);
    if ($check !== false) {
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
if ($_FILES["filetoUpload1"]["size"] > 15000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "jfif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["filetoUpload1"]["tmp_name"], $target_file)) {
        $image = $target_name;
        $stmt = $mysqli->prepare("UPDATE users SET pfp = ? WHERE username = ?");
        $stmt->bind_param("ss", $image, $username);
        $stmt->execute();
        $stmt->close();
        echo "Profile picture updated successfully.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>