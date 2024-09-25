<?php
require_once "../db_conn.php";

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'login':
            Login(mysqli: $mysqli);
            break;
        case 'logout':
            Logout();
            break;
        case 'change_email':
            changeEmail(mysqli: $mysqli);
            break;
        case 'change_username':
            changeUsername(mysqli: $mysqli);
            break;
        case 'change_password':
            changePassword(mysqli: $mysqli);
            break;
        case 'create_user':
            createUser($mysqli, $username, $email, $plainpassword);
            break;
    }
}
function changeEmail($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../functions/functions.php";
        require_once "../db_conn.php";

        $newEmail = htmlspecialchars($_POST['new-email']);

        if (empty($newEmail)) {
            $_SESSION['email_failed'] = true;
            header("location: ../panel.php");
            exit;
        }

        $username = $_SESSION['username'];
        $email = GetEmailByUsername($mysqli, $username);

        if ($newEmail !== $email) {
            $sql = "UPDATE users SET email = ? WHERE email = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ss", $newEmail, $email);

                if ($stmt->execute()) {
                    $_SESSION['email_success'] = true;
                    $_SESSION['email'] = $newEmail; 
                } else {
                    $_SESSION['email_failed'] = true;
                }

                $stmt->close();
            }
        } else {
            // Display an error message if the new email is the same as the old one
            $_SESSION['email_failed_same'] = true;
        }

        $mysqli->close();
        header("location: ../panel.php");
    } else {
        header("location: ../panel.php");
    }
}

function logOut(){
    session_start();
    session_destroy();
    header("location: ../home.php");
}

function Login($mysqli): void {
    require_once "../db_conn.php";

    // Ensure the session is started
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Use trim to avoid spaces and potential input issues
        $usernameOrEmail = trim($_POST['usernameOrEmail']);
        $password = trim($_POST['password']);

        // Prepare the SQL statement
        $sql = "SELECT id, username, password FROM users WHERE (username = ? OR email = ?)";
        $stmt = $mysqli->prepare($sql);
        
        if ($stmt === false) {
            die("MySQL prepare failed: " . htmlspecialchars($mysqli->error));
        }

        $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);

        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $username, $hashedPassword);
                $stmt->fetch();

                // Verify the password against the hashed password
                if ($hashedPassword !== null && password_verify(password: $password, hash: $hashedPassword)) {
                    $_SESSION["username"] = $username;
                    $_SESSION["id"] = $id;
                    header("Location: ../panel.php");
                    exit(); // Make sure to exit after header redirection
                } else {
                    $_SESSION["login_failed"] = true; // Invalid password
                    header("location: ../admin_login.php");
                    exit();
                }
            } else {
                $_SESSION["login_failed"] = true; // No user found
                header("location: ../admin_login.php");
                exit();
            }
        } else {
            // Log the error message
            error_log(message: "SQL Error: " . $stmt->error);
            echo "Error executing query: " . htmlspecialchars(string: $stmt->error);
        }

        $stmt->close();
    }
}

function changeUsername($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        $newUsername = htmlspecialchars($_POST['new-username']);

        $prohibitedWords = array('homo', 'neger', 'klootzak', 'lesbi', 'nigger', 'cunt', 'n3g3r', 'kanker', 'kankerhomo', 'kankerlaaier', 'kankerlijer', 'aidshoofd', 'aids', 'cancer', 'kankerkind', 'kankerjoch', 'kankerzooi', 'ginger', 'jarrie');

        foreach ($prohibitedWords as $word) {
            if (stripos($newUsername, $word) !== false) {
                $_SESSION['not_allowed'] = true;
                header("location: ../panel.php");
                exit;
            }
        }

        if (empty($newUsername)) {
            $_SESSION['username_failed'] = true;
            header("location: ../panel.php");
            exit;
        }

        require_once "../db_conn.php";

        $username = $_SESSION['username'];

        if ($newUsername !== $username) {
            $sql = "UPDATE users SET username = ? WHERE username = ?";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param("ss", $newUsername, $username);

                if ($stmt->execute()) {
                    $_SESSION['username_success'] = true;
                    $_SESSION['username'] = $newUsername;
                } else {
                    $_SESSION['username_failed'] = true;
                }

                $stmt->close();
            }
        } else {
            $_SESSION['username_failed_same'] = true;
        }

        $mysqli->close();
        header("location: ../panel.php");
    } else {
        header("location: ../panel.php");
    }
}

function changePassword($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../db_conn.php";

        $username = $_SESSION['username'];
        $oldPassword = htmlspecialchars($_POST['old-password']);
        $newPassword = htmlspecialchars($_POST['new-password']);
        $confirmPassword = htmlspecialchars($_POST['confirm-password']);

        if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['pw_failed'] = true;
            header("location: ../panel.php");
            exit();
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['pw_failed'] = true;
            header("location: ../panel.php");
            exit();
        }

        $sql = "SELECT `password` FROM users WHERE username = ?";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $userProfile = $result->fetch_assoc();
                $storedPassword = $userProfile['password']; 

                if (password_verify($oldPassword, $storedPassword)) {
                    if (password_verify($newPassword, $storedPassword)) {
                        $_SESSION['pw_failed2'] = true;
                        header("location: ../panel.php");
                        exit();
                    }

                    $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                    $updateSql = "UPDATE users SET password = ? WHERE username = ?";
                    $updateStmt = $mysqli->prepare($updateSql);

                    if ($updateStmt) {
                        $updateStmt->bind_param("ss", $hashedNewPassword, $username);
                        if ($updateStmt->execute()) {
                            $_SESSION['pw_succes'] = true;
                            header("location: ../panel.php");
                            exit();
                        } else {
                            $_SESSION['pw_failed'] = true;
                            header("location: ../panel.php");
                            exit();
                        }
                    }
                } else {
                    // Handle incorrect old password or password mismatch and display an error message
                    $_SESSION['pw_failed'] = true;
                    header("location: ../panel.php");
                    exit();
                }
            } else {
                // Handle user not found error
                $_SESSION['pw_failed'] = true;
                header("location: ../panel.php");
                exit();
            }
            $stmt->close();
        } else {
            // Handle the database query error
            $_SESSION['pw_failed'] = true;
            header("location: ../panel.php");
            exit();
        }
        // Close the database connection (if not using a persistent connection)
        $mysqli->close();
    } else {
        // Handle non-POST requests or display an error message
        $_SESSION['pw_failed'] = true;
        header("location: ../panel.php");
        exit();
    }
}

function createUser($mysqli, $username, $email, $plainPassword) {
    // Hash the password using password_hash()
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Prepare the SQL query to insert the new user
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    
    // Prepare the statement
    $stmt = $mysqli->prepare($sql);
    
    if ($stmt === false) {
        die("MySQL prepare failed: " . htmlspecialchars($mysqli->error));
    }

    // Bind the parameters to the SQL query
    $stmt->bind_param("sss", $username, $email, $hashedPassword);

    // Execute the query
    if ($stmt->execute()) {
        echo "User created successfully!";
    } else {
        echo "Error creating user: " . htmlspecialchars($stmt->error);
    }

    // Close the statement
    $stmt->close();
}