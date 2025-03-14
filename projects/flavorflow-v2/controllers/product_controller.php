<?php
require_once "../db_conn.php";
include '../functions/functions.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'addProduct':
            addProductToDatabase(mysqli: $mysqli);
            break;
        case 'deletedish':
            deleteDishFromDatabase(mysqli: $mysqli);
            break;
        case 'changedishname':
            changeDishName(mysqli: $mysqli);
            break;
        case 'getallproducts':
            getAllProducts(mysqli: $mysqli);
            break;
        case 'changedishdesc':
            changeDishDesc(mysqli: $mysqli);
            break;
        case 'changeproductcategory':
            changeProductCategory(mysqli: $mysqli);
            break;
        case 'changedishstatus':
            changeDishStatus(mysqli: $mysqli);
            break;
        case 'changedishprice':
            changeDishPrice(mysqli: $mysqli);
            break;
        case 'changeproductimage':
            changeProductImage(mysqli: $mysqli);
            break;
        default:
            echo json_encode(array('success' => false, 'message' => 'Type bestaat niet.'));
            break;
    }
}else {
    echo json_encode(array('success' => false, 'message' => 'Type bestaat niet in URL.'));
}

function getAllProducts($mysqli){
    $query = "SELECT * FROM dishes WHERE status = 1 AND restaurant_id = ?";
    $result = $mysqli->query($query);
    $products = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    echo json_encode($products);
}

function addProductToDatabase($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_name = $_POST['dish_name'];
        $dish_price = $_POST['dish_price'];
        $dish_desc = $_POST['dish_desc'];
        $dish_category = $_POST['dish_category'];
        $restaurant_id = $_POST['restaurant_id'];
        $restaurant_name = getRestaurantName($mysqli, $restaurant_id);

        // Sanitize and create folder name
        $sanitized_restaurant_name = preg_replace('/\s+/', '', strtolower($restaurant_name));
        $restaurant_folder = "../img/productimg/{$sanitized_restaurant_name}_productimg";

        // Check if folder exists, if not create it
        if (!is_dir($restaurant_folder)) {
            mkdir($restaurant_folder, 0777, true);
        }

        $dish_img_src = null;
        if (isset($_FILES['dish_img']) && $_FILES['dish_img']['error'] === UPLOAD_ERR_OK) {
            if ($_FILES['dish_img']['size'] > 4 * 1024 * 1024) {
                echo json_encode(['error' => 'File size exceeds the maximum limit of 4MB.']);
                exit;
            }

            $file_name = "product_img_resid-" . $restaurant_id . "_";
            $unique_name = $file_name . uniqid() . "." . pathinfo($_FILES['dish_img']['name'], PATHINFO_EXTENSION);
            $dish_img_src = $restaurant_folder . "/" . $unique_name;

            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (in_array($_FILES['dish_img']['type'], $allowed_types)) {
                if (move_uploaded_file($_FILES['dish_img']['tmp_name'], $dish_img_src)) {
                    // Image successfully moved
                } else {
                    echo json_encode(['error' => 'Failed to move uploaded file.']);
                    exit;
                }
            } else {
                echo json_encode(['error' => 'Invalid file type. Allowed types: JPEG, PNG, JPG, WEBP.']);
                exit;
            }
        } else if (isset($_FILES['dish_img']) && $_FILES['dish_img']['error'] !== UPLOAD_ERR_NO_FILE) {
            echo json_encode(['error' => 'File upload error: ' . $_FILES['dish_img']['error']]);
            exit;
        } else {
            $dish_img_src = null;
        }

        // Check if category exists
        $stmt = $mysqli->prepare("SELECT category_id FROM category WHERE category_name = ? AND restaurant_id = ?");
        $stmt->bind_param("si", $dish_category, $restaurant_id);
        $stmt->execute();
        $stmt->store_result();

        $category_id = null;
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($category_id);
            $stmt->fetch();
        } else {
            $created_at = date('Y-m-d H:i:s');
            $offline = 0;

            $stmt = $mysqli->prepare("INSERT INTO category (restaurant_id, category_name, offline, created_at) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isis", $restaurant_id, $dish_category, $offline, $created_at);
            if ($stmt->execute()) {
                $category_id = $stmt->insert_id;
            } else {
                echo json_encode(["success" => false, "message" => "Categorie toevoegen mislukt"]);
                return;
            }
        }
        $stmt->close();

        // Insert into dishes
        $created_at = date('Y-m-d H:i:s');
        $offline = 0;
        $created_by = $_POST['fullname'];

        $stmt = $mysqli->prepare("INSERT INTO dishes (restaurant_id, category_id, dish_name, dish_price, dish_desc, dish_img_src, created_by, created_at, offline) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisdssssi", $restaurant_id, $category_id, $dish_name, $dish_price, $dish_desc, $dish_img_src, $created_by, $created_at, $offline);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Product toegevoegd"]);
        } else {
            echo json_encode(["success" => false, "message" => "Product toevoegen mislukt"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request method"]);
    }
}

function changeDishName($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_id = $_POST['dish_id'];
        $dish_name = htmlspecialchars(trim($_POST['dish_name']));

        if (!is_numeric($dish_id)) {
            echo json_encode(array("success" => false, "message" => "Ongeldig product-ID."));
            return;
        }

        $stmt = $mysqli->prepare("UPDATE dishes SET dish_name = ? WHERE dish_id = ?");
        $stmt->bind_param("si", $dish_name, $dish_id);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Productnaam gewijzigd"));
        } else {
            echo json_encode(array("success" => false, "message" => "Productnaam wijzigen mislukt: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Ongeldige aanvraagmethode."));
    }
}

function changeDishDesc($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_id = $_POST['dish_id'];
        $dish_desc = htmlspecialchars(trim($_POST['dish_desc']));

        if (!is_numeric($dish_id)) {
            echo json_encode(array("success" => false, "message" => "Ongeldig product-ID."));
            return;
        }

        $stmt = $mysqli->prepare("UPDATE dishes SET dish_desc = ? WHERE dish_id = ?");
        $stmt->bind_param("si", $dish_desc, $dish_id);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Beschrijving gewijzigd"));
        } else {
            echo json_encode(array("success" => false, "message" => "Beschrijving wijzigen mislukt: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Ongeldige aanvraagmethode."));
    }
}

function deleteDishFromDatabase($mysqli) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_id = $_POST['dish_id'];

        if (!is_numeric($dish_id)) {
            echo json_encode(["success" => false, "message" => "Ongeldig gerecht-ID."]);
            return;
        }

        // Check the current status of the dish
        $stmt = $mysqli->prepare("SELECT offline FROM dishes WHERE dish_id = ?");
        $stmt->bind_param("i", $dish_id);
        $stmt->execute();
        
        // Initialize the variable properly
        $offline = null;
        $stmt->bind_result($offline);
        $stmt->fetch();
        $stmt->close();

        if ($offline === null) {
            echo json_encode(["success" => false, "message" => "Gerecht niet gevonden."]);
            return;
        }

        if ($offline == 0) {
            // If the dish is active, set it to offline (1)
            $stmt = $mysqli->prepare("UPDATE dishes SET offline = 1 WHERE dish_id = ?");
            $stmt->bind_param("i", $dish_id);
            $action = "Gerecht gedeactiveerd";
        } else {
            // If the dish is already offline, delete it
            $stmt = $mysqli->prepare("DELETE FROM dishes WHERE dish_id = ?");
            $stmt->bind_param("i", $dish_id);
            $action = "Gerecht permanent verwijderd";
        }

        // Execute the statement and close it properly
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => $action]);
        } else {
            echo json_encode(["success" => false, "message" => "Actie mislukt: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Ongeldige aanvraagmethode."]);
    }
}

function changeProductCategory($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_id = $_POST['dish_id'];
        $dish_category = $_POST['dish_category'];
        session_start();
        if (!isset($_SESSION['username'])) {
            echo json_encode(array("success" => false, "message" => "Gebruiker niet ingelogd."));
            return;
        }
        $username = $_SESSION['username'];
        $restaurant_id = getRestaurantOwnerIDByUsername($mysqli, $username);

        $stmt = $mysqli->prepare("SELECT category_id FROM category WHERE category_name = ? AND restaurant_id = ?");
        $stmt->bind_param("si", $dish_category, $restaurant_id);
        $stmt->execute();
        $stmt->store_result();

        $category_id = null;

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($category_id);
            $stmt->fetch();
        } else {
            $created_at = date('Y-m-d H:i:s');
            $offline = 0;

            $stmt = $mysqli->prepare("INSERT INTO category (restaurant_id, category_name, offline, created_at) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isis", $restaurant_id, $dish_category, $offline, $created_at);
            if ($stmt->execute()) {
                $category_id = $stmt->insert_id;
            } else {
                echo json_encode(array("success" => false, "message" => "Categorie toevoegen mislukt"));
                return;
            }
        }
        $stmt->close();

        $stmt = $mysqli->prepare("UPDATE dishes SET category_id = ? WHERE dish_id = ?");
        $stmt->bind_param("ii", $category_id, $dish_id);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Categorie gewijzigd"));
        } else {
            echo json_encode(array("success" => false, "message" => "Categorie wijzigen mislukt: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Ongeldige aanvraagmethode."));
    }
}

function changeDishStatus($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_id = $_POST['dish_id'];
        $status = $_POST['status'];

        if (!is_numeric($dish_id)) {
            echo json_encode(array("success" => false, "message" => "Ongeldig gerecht-ID." . $dish_id));
            return;
        }

        $stmt = $mysqli->prepare("UPDATE dishes SET offline = ? WHERE dish_id = ?");
        $stmt->bind_param("ii", $status, $dish_id);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Status gewijzigd"));
        } else {
            echo json_encode(array("success" => false, "message" => "Status wijzigen mislukt: " . $stmt->error)); // Include error
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Ongeldige aanvraagmethode."));
    }
}

function changeDishPrice($mysqli){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $dish_id = $_POST['dish_id'];
        $dish_price = $_POST['dish_price'];

        if (!is_numeric($dish_id)) {
            echo json_encode(array("success" => false, "message" => "Ongeldig gerecht-ID." . $dish_id));
            return;
        }

        if (!is_numeric($dish_price) || !preg_match('/^\d+(\.\d{1,2})?$/', $dish_price)) {
            echo json_encode(array("success" => false, "message" => "Ongeldige prijs. Alleen getallen met maximaal twee decimalen zijn toegestaan."));
            return;
        }

        $stmt = $mysqli->prepare("UPDATE dishes SET dish_price = ? WHERE dish_id = ?");
        $stmt->bind_param("di", $dish_price, $dish_id);

        if ($stmt->execute()) {
            echo json_encode(array("success" => true, "message" => "Prijs gewijzigd"));
        } else {
            echo json_encode(array("success" => false, "message" => "Prijs wijzigen mislukt: " . $stmt->error));
        }

        $stmt->close();
    } else {
        echo json_encode(array("success" => false, "message" => "Ongeldige aanvraagmethode."));
    }
}

function changeProductImage($mysqli) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode(["success" => false, "message" => "Ongeldige aanvraagmethode."]);
        exit;
    }

    session_start();

    if (!isset($_SESSION['username'])) {
        echo json_encode(["success" => false, "message" => "Gebruiker niet ingelogd."]);
        exit;
    }

    if (!isset($_POST['dish_id'])) {
        echo json_encode(["success" => false, "message" => "Missing parameters."]);
        exit;
    }

    $dish_id = $_POST['dish_id'];
    $username = $_SESSION['username'];
    $old_product_img = checkForProductImg($mysqli, $dish_id);
    $restaurant_id = getRestaurantOwnerIDByUsername($mysqli, $username);
    $restaurant_name = getRestaurantName($mysqli, $restaurant_id);

    $sanitized_restaurant_name = preg_replace('/\s+/', '', strtolower($restaurant_name));
    $restaurant_folder = "../img/productimg/{$sanitized_restaurant_name}_productimg";

    if (!is_dir($restaurant_folder)) {
        mkdir($restaurant_folder, 0777, true);
    }

    if (!isset($_FILES['productimg']) || $_FILES['productimg']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(["success" => false, "message" => "Geen afbeelding geüpload of er is een fout opgetreden."]);
        exit;
    }

    if ($_FILES['productimg']['size'] > 4 * 1024 * 1024) {
        echo json_encode(['success' => false, 'message' => 'File size exceeds 4MB.']);
        exit;
    }

    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
    if (!in_array($_FILES['productimg']['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type.']);
        exit;
    }

    $file_extension = pathinfo($_FILES['productimg']['name'], PATHINFO_EXTENSION);
    $file_name = "product_img_resid-" . $restaurant_id . "_";
    $unique_name = $file_name . uniqid() . "." . $file_extension;
    $dish_img_src = $restaurant_folder . "/" . $unique_name;

    if (!move_uploaded_file($_FILES['productimg']['tmp_name'], $dish_img_src)) {
        echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file.']);
        exit;
    }

    $stmt = $mysqli->prepare("UPDATE dishes SET dish_img_src = ? WHERE dish_id = ?");
    $stmt->bind_param("si", $dish_img_src, $dish_id);

    if ($stmt->execute()) {
        if ($old_product_img && file_exists($old_product_img)) {
            unlink($old_product_img);
        }
        echo json_encode(["success" => true, "message" => "Afbeelding gewijzigd"]);
    } else {
        echo json_encode(["success" => false, "message" => "Afbeelding wijzigen mislukt: " . $stmt->error]);
    }

    $stmt->close();
    exit;
}