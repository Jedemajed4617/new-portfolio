<?php
include('db_conn.php');

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

function imageNameGen() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*';
    $namee = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $namee[] = $alphabet[$n];
    }
    return implode($namee);
}
function GetPfpById($mysqli, $username) {
    $sql = "SELECT * FROM `accounts` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== null && $endresult = $result->fetch_assoc()) {
        if ($endresult['pfp'] == null) {
            return "default.webp";
        } else {
            return $endresult['pfp'];
        }
    } else {
        return "default.webp"; 
    }
}
function UpdatePfp($mysqli, $username, $image){
    $sql = "UPDATE accounts SET pfp=? WHERE username=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $image, $username);
    $stmt->execute();
    header("location: profile.php");
}

function GetEmailByUsername($mysqli, $username){
    $sql = "SELECT * FROM `accounts` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result !== null && $endresult = $result->fetch_assoc()) {
        if ($endresult['email'] == null) {
            return "Not found/unknown";
        } else {
            return $endresult['email'];
        }
    } else {
        return "Not found/unknown"; 
    }
}

function UpdatePasswordByUsername($mysqli, $username, $oldPassword, $newPassword) {
    $sql = "SELECT password FROM `accounts` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $userProfile = $result->fetch_assoc();
            $storedPassword = $userProfile['password'];

            if (password_verify($oldPassword, $storedPassword)) {
                $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $updateSql = "UPDATE `accounts` SET `password` = ? WHERE `username` = ?";
                $updateStmt = $mysqli->prepare($updateSql);
                
                if ($updateStmt) {
                    $updateStmt->bind_param("ss", $hashedNewPassword, $username);
                    if ($updateStmt->execute()) {
                        $updateStmt->close();
                        return true; 
                    }
                }
            }
        }
    }

    return false; 
}

?>