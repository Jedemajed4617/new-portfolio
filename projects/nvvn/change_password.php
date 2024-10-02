<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once("db_conn.php");

    // Validate the data received from the form
    $username = $_SESSION['username']; // You need to get the ingelogde user's username
    $oldPassword = $_POST['old-password'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    // Perform additional validation if needed
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['pw_failed'] = true;
        header("location: profile.php");
        exit();
    }

    if ($newPassword !== $confirmPassword) {
        // Handle password mismatch or display an error message
        $_SESSION['pw_failed'] = true;
        header("location: profile.php");
        exit();
    }

    // Check if the old password matches the one stored in the database
    $sql = "SELECT `password` FROM accounts WHERE username = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userProfile = $result->fetch_assoc();
            $storedPassword = $userProfile['password']; // Retrieve the stored password

            if (password_verify($oldPassword, $storedPassword)) {
                // Hash and update the new password
                $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $updateSql = "UPDATE accounts SET password = ? WHERE username = ?";
                $updateStmt = $mysqli->prepare($updateSql);

                if ($updateStmt) {
                    $updateStmt->bind_param("ss", $hashedNewPassword, $username);
                    if ($updateStmt->execute()) {
                        // Password updated successfully
                        $_SESSION['pw_succes'] = true;
                        header("location: profile.php");
                        exit();
                    } else {
                        // Handle the database update error
                        $_SESSION['pw_failed'] = true;
                        header("location: profile.php");
                        exit();
                    }
                }
            } else {
                // Handle incorrect old password or password mismatch and display an error message
                $_SESSION['pw_failed'] = true;
                header("location: profile.php");
                exit();
            }
        } else {
            // Handle user not found error
            $_SESSION['pw_failed'] = true;
            header("location: profile.php");
            exit();
        }
        $stmt->close();
    } else {
        // Handle the database query error
        $_SESSION['pw_failed'] = true;
        header("location: profile.php");
        exit();
    }
    // Close the database connection (if not using a persistent connection)
    $mysqli->close();
} else {
    // Handle non-POST requests or display an error message
    $_SESSION['pw_failed'] = true;
    header("location: profile.php");
    exit();
}
?>