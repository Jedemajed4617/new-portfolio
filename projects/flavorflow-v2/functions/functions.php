<?php

$username = isset($_SESSION['username']) ? $_SESSION['username'] : null;

function GetEmailByUsername($mysqli, $username){
    require_once '../db_conn.php';
    $sql = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Database error: failed to prepare statement'));
        return null;
    }

    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        echo json_encode(array('status' => 'error', 'message' => 'Database error: failed to execute statement'));
        return null;
    }

    $result = $stmt->get_result();
    if ($result === false) {
        echo json_encode(array('status' => 'error', 'message' => 'Database error: failed to get result'));
        return null;
    }

    if ($endresult = $result->fetch_assoc()) {
        if ($endresult['email'] == null) {
            echo json_encode(array('status' => 'error', 'message' => 'Gebruiker niet gevonden'));
            return null;
        } else {
            return $endresult['email'];
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Gebruiker niet gevonden'));
        return null;
    }
}


function UpdatePasswordByUsername($mysqli, $username, $oldPassword, $newPassword) {
    require_once '../db_conn.php';
    $sql = "SELECT password FROM `users` WHERE `username` = ?";
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
                $updateSql = "UPDATE `users` SET `password` = ? WHERE `username` = ?";
                $updateStmt = $mysqli->prepare($updateSql);
                
                if ($updateStmt) {
                    $mysqli->begin_transaction();
                    $updateStmt->bind_param("ss", $hashedNewPassword, $username);
                    if ($updateStmt->execute()) {
                        $mysqli->commit();
                        $updateStmt->close();
                        $stmt->close();
                        $result->free();
                        return true; 
                    } else {
                        $mysqli->rollback();
                    }
                    $updateStmt->close();
                }
            }
        }
        $stmt->close();
        $result->free();
    }

    return false; 
}

function deleteInactiveAccounts($mysqli) {
    $sixMonthsAgo = date('Y-m-d H:i:s', strtotime('-6 months'));

    $sql = "DELETE FROM users WHERE last_login IS NOT NULL AND last_login < ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $sixMonthsAgo);
    
    if ($stmt->execute()) {
        // Optional: Log the number of deleted accounts
        error_log("Inactive accounts deleted.");
    } else {
        error_log("Error deleting inactive accounts: " . $stmt->error);
    }

    $stmt->close();
}

function getRestaurantLogo($mysqli, $restaurant_id) {
    $query = "SELECT restaurant_logo_src FROM restaurants WHERE restaurant_id = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        // Handle error
        die('Prepare failed: ' . $mysqli->error);
    }

    $stmt->bind_param("s", $restaurant_id);
    $stmt->execute();
    $restaurant_img_src = '';
    $stmt->bind_result($restaurant_img_src);
    $stmt->fetch();
    $stmt->close();

    return !empty($restaurant_img_src) ? $restaurant_img_src : './img/logo-res.jpg';
}

function getRestaurantName($mysqli, $restaurant_id) {
    $query = "SELECT restaurant_name FROM restaurants WHERE restaurant_id = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $restaurant_name = '';
    $stmt->bind_param("i", $restaurant_id); // Changed "s" to "i" for integer
    $stmt->execute();
    $stmt->bind_result($restaurant_name);

    if ($stmt->fetch()) {
        $stmt->close();
        return $restaurant_name; 
    } else {
        $stmt->close();
        return null; // Return null if no restaurant found
    }
}

function getRestaurantOwnerIDByUsername($mysqli, $username) {
    $query = "SELECT restaurant_id FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $restaurant_id = '';
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($restaurant_id);

    if ($stmt->fetch()) {
        $stmt->close();
        return $restaurant_id; 
    } else {
        $stmt->close();
        return null; // Return null if no restaurant found
    }
}

function getDishesByRestaurantId($mysqli, $restaurant_id) {
    $query = "SELECT d.*, c.category_name 
              FROM dishes d 
              LEFT JOIN category c ON d.category_id = c.category_id 
              WHERE d.restaurant_id = ?"; 
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $stmt->bind_param("i", $restaurant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $dishes = [];

    while ($row = $result->fetch_assoc()) {
        $dishes[] = $row;
    }

    $stmt->close();
    return $dishes;
}

function checkForProductImg($mysqli, $dish_id) {
    $query = "SELECT dish_img_src FROM dishes WHERE dish_id = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $stmt->bind_param("i", $dish_id);
    $stmt->execute();
    $dish_img_src = '';
    $stmt->bind_result($dish_img_src);

    if ($stmt->fetch()) {
        $stmt->close();
        return $dish_img_src;
    } else {
        $stmt->close();
        return null; // Return null if no product found
    }
}

function getUserIdByUsername($mysqli, $username){
    $query = "SELECT user_id FROM users WHERE username = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $user_id = '';
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);

    if ($stmt->fetch()) {
        $stmt->close();
        return $user_id; 
    } else {
        $stmt->close();
        return null; // Return null if no user found
    }
}


function getUserAddress($mysqli, $user_id){
    $query = "SELECT street_name, CONCAT(street_number, IFNULL(street_number_addon, '')) AS street_number, postal_code, city, country FROM address WHERE user_id = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $stmt->bind_param("s", $user_id);

    $street_name = '';
    $street_number = '';
    $postal_code = '';
    $city = '';
    $country = '';

    // Bind the results to variables
    $stmt->bind_result($street_name, $street_number, $postal_code, $city, $country);

    $address = '';

    // Check if there's any result and fetch
    if ($stmt->execute() && $stmt->fetch()) {
        $address = $street_name . " " . $street_number . ", ". $postal_code . " " . $city . ", " . $country;
    } else {
        $address = null;
    }
    $stmt->close();

    return $address;
}

function getActiveAddressId($mysqli){
    require_once '../db_conn.php';
    $user_id = getUserIdByUsername($mysqli, $_SESSION['username']);
    $query = "SELECT address_id FROM address WHERE user_id = ? AND active = 0";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        die('Prepare failed: ' . $mysqli->error);
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $address_id = '';
    $stmt->bind_result($address_id);

    if ($stmt->fetch()) {
        $stmt->close();
        return $address_id; 
    } else {
        $stmt->close();
        return null; // Return null if no address found
    }
}
