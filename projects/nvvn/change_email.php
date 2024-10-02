<?php
session_start();

require_once("functions.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validatie van de invoer
    $newEmail = $_POST['new-email'];

    if (empty($newEmail)) {
        $_SESSION['email_failed'] = true;
        header("location: profile.php");
        exit;
    } 

    require_once("db_conn.php");

    $email = GetEmailByUsername($mysqli, $username);

    // Query om de gebruikersnaam bij te werken
    $sql = "UPDATE accounts SET email = ? WHERE email = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("ss", $newEmail, $email);

        if ($stmt->execute()) {
            $_SESSION['email_success'] = true;
            $_SESSION['email'] = $newEmail; // Werk de gebruikersnaam in de sessie bij
        } else {
            $_SESSION['email_failed'] = true;
        }

        $stmt->close();
    }

    $mysqli->close();
    header("location: profile.php");
} else {
    header("location: profile.php");
}

?>