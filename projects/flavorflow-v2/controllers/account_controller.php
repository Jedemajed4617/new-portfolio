<?php
require_once '../db_conn.php';
require_once '../functions/functions.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'login':
            Login(mysqli: $mysqli);
            break;
        case 'register':
            Register(mysqli: $mysqli);
            break;
        case 'logout':
            Logout();
            break;
        case 'changepassword':
            ChangePassword(mysqli: $mysqli);
            break;
        case 'delete_account':
            DeleteAccount(mysqli: $mysqli);
            break;
        case 'setorchangebirthdate':
            SetOrChangeBirthdate(mysqli: $mysqli);
            break;
        case 'setorchangegender':
            SetOrChangeGender(mysqli: $mysqli);
            break;
        case 'changefname':
            ChangeFirstName(mysqli: $mysqli);
            break;
        case 'changelname':
            ChangeLastName(mysqli: $mysqli);
            break;
        case 'changeusername':
            ChangeUsername(mysqli: $mysqli);
            break;
        case 'changeemail':
            ChangeEmail(mysqli: $mysqli);
            break;
        case 'changephone':
            ChangePhone(mysqli: $mysqli);
            break;
        case 'changeoraddprofileimg':
            ChangeOrAddProfileImg(mysqli: $mysqli);
            break;
        case 'addaddress':
            addUserAdress(mysqli: $mysqli);
            break;
        case 'deleteaddress':
            deleteSelectedAddress(mysqli: $mysqli);
            break;
        default:
            echo json_encode(array('success' => false, 'message' => 'Type bestaat niet.'));
            break;
    }
}else {
    echo json_encode(array('success' => false, 'message' => 'Type bestaat niet in URL.'));
}

// User handling
function Logout(){
    session_start(); // Start the session
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    header("location: ../index.php"); // Redirect to the index page
    exit; // Exit the script
}

function Login($mysqli) {
    session_start();

    require_once "../functions/functions.php";

    // Cleanup inactive accounts before login
    deleteInactiveAccounts($mysqli);

    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['login_failed_empty'] = true;
        header("Location: ../login.php");
        exit;
    }

    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            session_regenerate_id(true); // Regenerate session ID for security

            // Update last login timestamp
            $updateQuery = "UPDATE users SET last_login = NOW() WHERE email = ?";
            $updateStmt = $mysqli->prepare($updateQuery);
            $updateStmt->bind_param("s", $email);
            $updateStmt->execute();
            $updateStmt->close();

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['user_type'] = $row['user_type'];
            $_SESSION['fname'] = $row['fname'];
            $_SESSION['lname'] = $row['lname'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['date_of_birth'] = $row['date_of_birth'];
            $_SESSION['gender'] = $row['gender'];
            $_SESSION['offline'] = $row['offline'];
            $_SESSION['profile_img_src'] = $row['profile_img_src'];

            $_SESSION['user_login_success'] = true;
            header("Location: ../profile.php");
            exit;
        } else {
            $_SESSION['user_failed_mismatch'] = true;
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['user_failed_notfound'] = true;
        header("Location: ../login.php");
        exit;
    }
}

function Register($mysqli){
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_type = "gebruiker";
        $fname = htmlspecialchars($_POST['fname']);
        $lname = htmlspecialchars($_POST['lname']);
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];
        $pswrepeat = $_POST['pswrepeat'];
        $username = htmlspecialchars($_POST['username']);
        $phone = htmlspecialchars($_POST['phone']);

        if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($pswrepeat) || empty($username) || empty($phone)) {
            $_SESSION['register_failed_empty'] = true;
            header("Location: ../register.php");
            exit;
        }

        if (strlen($password) < 8) {
            $_SESSION['register_failed_length'] = true;
            header("Location: ../register.php");
            exit;
        }

        if (substr($phone, 0, 5) !== '+3106') {
            $_SESSION['register_failed_phone'] = true;
            header("Location: ../register.php");
            exit;
        }

        if ($password !== $pswrepeat) {
            $_SESSION['register_failed_mismatch'] = true;
            header("Location: ../register.php");
            exit;
        }

        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $stmt->close(); // Close previous statement

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $offline = 0; // False
            $eu_date = date("d/m/Y");
            $eu_time = date("H:i:s"); 
            $created_at = $eu_date .  " om " . $eu_time; // Current timestamp

            $query = "INSERT INTO users (user_type, fname, lname, email, password, username, phone, offline, created_at) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param("sssssssis", $user_type, $fname, $lname, $email, $hashed_password, $username, $phone, $offline, $created_at);

            if ($stmt->execute()) {
                session_regenerate_id(true);

                $query = "SELECT * FROM users WHERE email = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_type'] = $row['user_type'];
                $_SESSION['fname'] = $row['fname'];
                $_SESSION['lname'] = $row['lname'];
                $_SESSION['phone'] = $row['phone'];
                $_SESSION['date_of_birth'] = $row['date_of_birth'];
                $_SESSION['gender'] = $row['gender'];
                $_SESSION['offline'] = $row['offline'];
                
                $_SESSION['register_success'] = true;
                header("Location: ../profile.php");
                exit;
            } else {
                $_SESSION['register_failed'] = true;
                header("Location: ../register.php");
                exit;
            }

            $stmt->close();
        } else {
            $_SESSION['register_failed_exist'] = true;
            header("Location: ../register.php");
            exit;
        }
    } else {
        $_SESSION['register_failed'] = true;
        header("Location: ../register.php");
        exit;
    }
}

function SetOrChangeBirthdate($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $newdateOfBirth = trim($_POST['birthdate']); // Comes in as YYYY-MM-DD

        if (empty($newdateOfBirth)) {
            echo json_encode(array('success' => false, 'message' => 'Veld is leeg.'));
            exit;
        }

        // Store YYYY-MM-DD in DB (this is correct for MySQL)
        $sql = "UPDATE users SET date_of_birth = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $newdateOfBirth, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                // Successful update
                $_SESSION['date_of_birth'] = $newdateOfBirth;
                echo json_encode(array('success' => true, 'message' => 'Geboortedatum succesvol gewijzigd.'));
                exit;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Geboortedatum wijzigen mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function SetOrChangeGender($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $gender = trim($_POST['gender']);

        if ($gender !== 'male' && $gender !== 'female') {
            echo json_encode(array('success' => false, 'message' => 'Ongeldig geslacht.'));
            exit;
        }

        // Store gender in DB
        $sql = "UPDATE users SET gender = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $gender, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                $_SESSION['gender'] = $gender;
                echo json_encode(array('success' => true, 'message' => 'Geslacht succesvol gewijzigd.'));
                exit;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Geslacht wijzigen mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function ChangeFirstName($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            // Handle the session error
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $newFirstName = trim($_POST['fname']);

        if (empty($newFirstName)) {
            // Handle empty fields
            echo json_encode(array('success' => false, 'message' => 'Veld is leeg.'));
            exit;
        }

        $sql = "UPDATE users SET fname = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $newFirstName, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                // Successful update
                $_SESSION['fname'] = $newFirstName;
                echo json_encode(array('success' => true, 'message' => 'Naam geupdate.'));
                exit;
            } else {
                // Database query error
                echo json_encode(array('success' => false, 'message' => 'Naam updaten mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            // Database query error
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        // Handle non-POST requests
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function ChangeLastName($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            // Handle the session error
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $newLastName = trim($_POST['lname']);

        if (empty($newLastName)) {
            // Handle empty fields
            echo json_encode(array('success' => false, 'message' => 'Veld is leeg.'));
            exit;
        }

        $sql = "UPDATE users SET lname = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $newLastName, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                // Successful update
                $_SESSION['lname'] = $newLastName;
                echo json_encode(array('success' => true, 'message' => 'Achternaam geupdate.'));
                exit;
            } else {
                // Database query error
                echo json_encode(array('success' => false, 'message' => 'Achternaam updaten mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            // Database query error
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        // Handle non-POST requests
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function ChangeUsername($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        require_once "../db_conn.php";

        $prohibitedWords = array('homo', 'neger', 'klootzak', 'lesbi', 'nigger', 'cunt', 'n3g3r', 'kanker', 'kankerhomo', 'kankerlaaier', 'kankerlijer', 'aidshoofd', 'aids', 'cancer', 'kankerkind', 'kankerjoch', 'kankerzooi', 'ginger', 'jarrie');

        if (!isset($_SESSION['username'])) {
            // Handle the session error
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $newUsername = trim($_POST['username']);

        if (empty($newUsername)) {
            // Handle empty fields
            echo json_encode(array('success' => false, 'message' => 'Veld is leeg.'));
            exit;
        }

        foreach ($prohibitedWords as $word) {
            if (stripos($newUsername, $word) !== false) {
                echo json_encode(array('success' => false, 'message' => 'Gebruikersnaam bevat een verboden woord.'));
                exit;
            }
        }

        // Store first name in DB
        $sql = "UPDATE users SET username = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $newUsername, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                // Successful update
                $_SESSION['username'] = $newUsername;
                echo json_encode(array('success' => true, 'message' => 'Gebruikersnaam geupdate.'));
                exit;
            } else {
                // Database query error
                echo json_encode(array('success' => false, 'message' => 'Gebruikersnaam updaten mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            // Database query error
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        // Handle non-POST requests
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function ChangeEmail($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        require_once "../db_conn.php";

        $prohibitedWords = array('homo', 'neger', 'klootzak', 'lesbi', 'nigger', 'cunt', 'n3g3r', 'kanker', 'kankerhomo', 'kankerlaaier', 'kankerlijer', 'aidshoofd', 'aids', 'cancer', 'kankerkind', 'kankerjoch', 'kankerzooi', 'ginger', 'jarrie');

        if (!isset($_SESSION['username'])) {
            // Handle the session error
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $newEmail = trim($_POST['email']);

        if (empty($newEmail)) {
            // Handle empty fields
            echo json_encode(array('success' => false, 'message' => 'Veld is leeg.'));
            exit;
        }

        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('success' => false, 'message' => 'Ongeldig emailadres.'));
            exit;
        }

        foreach ($prohibitedWords as $word) {
            if (stripos($newEmail, $word) !== false) {
                // Handle prohibited words
                echo json_encode(array('success' => false, 'message' => 'Email bevat een verboden woord.'));
                exit;
            }
        }

        // Store first name in DB
        $sql = "UPDATE users SET email = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $newEmail, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                // Successful update
                $_SESSION['email'] = $newEmail;
                echo json_encode(array('success' => true, 'message' => 'Email geupdate.'));
                exit;
            } else {
                // Database query error
                echo json_encode(array('success' => false, 'message' => 'Email updaten mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            // Database query error
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        // Handle non-POST requests
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function ChangePhone($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        session_start();
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            // Handle the session error
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $newPhone = trim($_POST['phone']);

        if (empty($newPhone)) {
            // Handle empty fields
            echo json_encode(array('success' => false, 'message' => 'Veld is leeg.'));
            exit;
        }

        if ($newPhone === $_SESSION['phone']) {
            // Handle same phone number
            echo json_encode(array('success' => false, 'message' => 'Telefoonnummer is hetzelfde, niks veranderd.'));
            exit;
        }

        if (strlen($newPhone) <= 10 || strlen($newPhone) >= 15) {
            // Handle incorrect phone number length
            echo json_encode(array('success' => false, 'message' => 'Telefoonnummer is te kort / te lang.'));
            exit;
        }

        if (substr($newPhone, 0, 6) !== '+31 06') {
            echo json_encode(array('success' => false, 'message' => 'Telefoonnummer moet beginnen met +31 06'));
            exit;
        }

        // Store first name in DB
        $sql = "UPDATE users SET phone = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $newPhone, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                // Successful update
                $_SESSION['phone'] = $newPhone;
                echo json_encode(array('success' => true, 'message' => 'Telefoonnummer geupdate.'));
                exit;
            } else {
                // Database query error
                echo json_encode(array('success' => false, 'message' => 'Telefoonnummer updaten mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            // Database query error
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        // Handle non-POST requests
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function ChangePassword($mysqli) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        $oldPassword = trim($_POST['old-psw']);
        $newPassword = trim($_POST['new-psw']);
        $confirmPassword = trim($_POST['confirm-new-psw']);

        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo json_encode(array('success' => false, 'message' => 'Vul alle velden in.'));
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            echo json_encode(array('success' => false, 'message' => 'Nieuw wachtwoord en herhaling komen niet overeen.'));
            exit;
        }

        if (strlen($newPassword) < 8) {
            echo json_encode(array('success' => false, 'message' => 'Wachtwoord moet minstens 8 tekens lang zijn.'));
            exit;
        }

        // Fetch current password hash from DB
        $sql = "SELECT password FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($hashedPassword);
            if ($stmt->fetch()) {
                // Verify old password
                if (!password_verify($oldPassword, $hashedPassword)) {
                    echo json_encode(array('success' => false, 'message' => 'Oude wachtwoord is onjuist.'));
                    exit;
                }
            } else {
                echo json_encode(array('success' => false, 'message' => 'Gebruiker niet gevonden.'));
                exit;
            }
            $stmt->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        // Hash new password
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update password in DB
        $sql = "UPDATE users SET password = ? WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("ss", $newHashedPassword, $username);
            if ($stmt->execute()) {
                session_regenerate_id(true);
                echo json_encode(array('success' => true, 'message' => 'Wachtwoord succesvol gewijzigd.'));
                exit;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Wachtwoord updaten mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
        exit;
    }
}

function DeleteAccount($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];

        $sql = "UPDATE users SET offline = 1 WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $username);
            if ($stmt->execute()) {
                session_unset();
                session_destroy();
                echo json_encode(array('success' => true, 'message' => 'Account succesvol gedeactiveerd.'));
                header("Location: ../index.php");
                exit;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Account deactiveren mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    }
}

function ChangeOrAddProfileImg($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        ob_start(); // Prevents unwanted output before JSON response

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        if (!file_exists("../db_conn.php")) {
            echo json_encode(array('success' => false, 'message' => 'Database bestand niet gevonden.'));
            exit;
        }
        require_once "../db_conn.php";

        if (!isset($_SESSION['username'])) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $username = $_SESSION['username'];
        if (!isset($_FILES['profileimg'])) { // Fix $_FILES key
            echo json_encode(array('success' => false, 'message' => 'Geen afbeelding ontvangen.'));
            exit;
        }

        $profileImg = $_FILES['profileimg']; // Fixed key

        if ($profileImg['error'] !== 0) {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan met de afbeelding.'));
            exit;
        }

        $allowedExtensions = array('jpg', 'jpeg', 'png', 'webp');
        $extension = strtolower(pathinfo($profileImg['name'], PATHINFO_EXTENSION)); // Case-insensitive

        if (!in_array($extension, $allowedExtensions)) {
            echo json_encode(array('success' => false, 'message' => 'Ongeldig bestandstype.'));
            exit;
        }

        $maxFileSize = 5 * 1024 * 1024; // 5 MB
        if ($profileImg['size'] > $maxFileSize) {
            echo json_encode(array('success' => false, 'message' => 'Bestand is te groot.'));
            exit;
        }

        $newFileName = uniqid('', true) . '.webp';
        $destination = '../img/profileimg/' . $newFileName;

        // Convert image to webp
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($profileImg['tmp_name']);
                break;
            case 'png':
                $image = imagecreatefrompng($profileImg['tmp_name']);
                break;
            case 'webp':
                $image = imagecreatefromwebp($profileImg['tmp_name']);
                break;
            default:
                echo json_encode(array('success' => false, 'message' => 'Ongeldig bestandstype.'));
                exit;
        }

        if (imagewebp($image, $destination, 80)) {
            imagedestroy($image);

            // Delete previous profile image
            $sql = "SELECT profile_img_src FROM users WHERE username = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $stmt->bind_result($oldFileName);
                if ($stmt->fetch() && $oldFileName) {
                    $oldFilePath = '../img/profileimg/' . $oldFileName;
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }
                $stmt->close();
            }

            // Update profile image in DB
            $sql = "UPDATE users SET profile_img_src = ? WHERE username = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ss", $newFileName, $username);
                if ($stmt->execute()) {
                    session_regenerate_id(true);
                    $_SESSION['profile_img_src'] = $newFileName; // Fixed session key
                    ob_end_clean(); // Prevents accidental output
                    echo json_encode(array('success' => true, 'message' => 'Profielfoto succesvol geüpdatet.'));
                    exit;
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Profielfoto updaten mislukt.'));
                    exit;
                }
                $stmt->close();
            } else {
                echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
                exit;
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan met het converteren van de afbeelding.'));
            exit;
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Ongeldige aanvraag. (2)'));
        exit;
    }
}

function addUserAdress($mysqli) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json');
        session_start();
        require_once "../db_conn.php";

        $username = $_SESSION['username'];

        if (!isset($username)) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd. (1)'));
            exit;
        }

        $user_id =  getUserIdByUsername($mysqli, $username); // idk wrm dit nodig is maar op een of andere reden pakt ie de user niet zonder deze functie;
        $created_at = date("d/m/Y H:i:s");
        $active = 0;
        $offline = 0;

        $country = trim($_POST['country']);
        $province = trim($_POST['province']);
        $city = trim($_POST['city']);
        $streetname = trim($_POST['streetname']); 
        $housenumber = trim($_POST['housenumber']);
        $housenumberaddition = trim($_POST['housenumberaddition']);
        $postalcode = trim($_POST['postalcode']);
        $addresstype = trim($_POST['addresstype']);

        if (empty($user_id)) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd. (2)'));
            exit;
        }

        if (empty($housenumberaddition)) {
            $housenumberaddition = "";
        }

        if (empty($streetname) || empty($housenumber) || empty($postalcode) || empty($city) || empty($country) || empty($addresstype) || empty($province) || empty($user_id)) {
            echo json_encode(array('success' => false, 'message' => 'Vul alle velden in.'));
            exit;
        }

        if (strlen($postalcode) >= 7) {
            echo json_encode(array('success' => false, 'message' => 'Ongeldige postcode.'));
            exit;
        }

        if (strlen($housenumber) > 5) {
            echo json_encode(array('success' => false, 'message' => 'Ongeldig huisnummer.'));
            exit;
        }

        if (!is_numeric($housenumber)) {
            echo json_encode(array('success' => false, 'message' => 'Ongeldig huisnummer.'));
            exit;
        }

        if (strlen($housenumberaddition) > 5) {
            echo json_encode(array('success' => false, 'message' => 'Ongeldig huisnummer toevoeging.'));
            exit;
        }

        if (preg_match('/\d/', $streetname)) {
            echo json_encode(array('success' => false, 'message' => 'Straatnaam mag geen cijfers bevatten.'));
            exit;
        }

        // Check the number of addresses for the user
        $sql = "SELECT COUNT(*) FROM address WHERE user_id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->bind_result($addressCount);
            $stmt->fetch();
            $stmt->close();

            if ($addressCount >= 10) {
                echo json_encode(array('success' => false, 'message' => 'U heeft uw limiet aan adressen bereikt. (Max. 10)'));
                exit;
            }

            // Insert new address
            $sql = "INSERT INTO address (user_id, address_type, country, province, city, street_name, street_number, street_number_addon, postal_code, created_at, active, offline) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("issssssissii", $user_id, $addresstype, $country, $province, $city, $streetname, $housenumber, $housenumberaddition, $postalcode, $created_at, $active, $offline);
                if ($stmt->execute()) {
                    echo json_encode(array('success' => true, 'message' => 'Adres succesvol toegevoegd.'));
                    exit;
                } else {
                    echo json_encode(array('success' => false, 'message' => 'Adres toevoegen mislukt.'));
                    exit;
                }
                $stmt->close();
            } else {
                // Database query error
                echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
                exit;
            }
        } else {
            // Database query error
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (2)'));
            exit;
        }

        $mysqli->close();
    } else {
        // Handle non-POST requests
        echo json_encode(array('success' => false, 'message' => 'Ongeldige aanvraag.'));
        exit;
    }
}

function deleteSelectedAddress($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../db_conn.php";

        $username = $_SESSION['username'];

        if (!isset($username)) {
            echo json_encode(array('success' => false, 'message' => 'User is niet ingelogd.'));
            exit;
        }

        $address_id = $_POST['address_id'];

        if (empty($address_id)) {
            echo json_encode(array('success' => false, 'message' => 'Ongeldige aanvraag.'));
            exit;
        }

        // Delete address
        $sql = "DELETE FROM address WHERE address_id = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("i", $address_id);
            if ($stmt->execute()) {
                echo json_encode(array('success' => true, 'message' => 'Adres succesvol verwijderd.'));
                exit;
            } else {
                echo json_encode(array('success' => false, 'message' => 'Adres verwijderen mislukt.'));
                exit;
            }
            $stmt->close();
        } else {
            echo json_encode(array('success' => false, 'message' => 'Er is iets misgegaan. (1)'));
            exit;
        }

        $mysqli->close();
    } else {
        // Handle non-POST requests
        echo json_encode(array('success' => false, 'message' => 'Ongeldige aanvraag.'));
        exit;
    }
}