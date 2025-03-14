<?php
require_once '../db_conn.php';
require_once '../functions/functions.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'processorder':
            processOrderToDB(mysqli: $mysqli);
            break;
        default:
            echo json_encode(array('success' => false, 'message' => 'Type bestaat niet.'));
            break;
    }
} else {
    echo json_encode(array('success' => false, 'message' => 'Type bestaat niet in URL.'));
}

function processOrderToDB($mysqli) {
    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        session_start();
        require_once "../db_conn.php";

        $data = json_decode(file_get_contents('php://input'), true);
        error_log(print_r($data, true)); // Keep this for debugging

        // Extract order details directly from the decoded $data
        $user_id = $_SESSION['user_id'] ?? "";
        $restaurant_id = $data['orderData']['restaurantId'] ?? "";
        $order_note = $data['orderData']['ordernote'] ?? "";
        $food_note = $data['orderData']['foodnote'] ?? "";
        $address = $data['orderData']['address'] ?? ""; // Corrected line
        $cart = isset($data['cart']) ? $data['cart'] : [];

        $address_id = getActiveAddressId($mysqli) ?? "";
        $offline = 0;
        $order_date = date('Y-m-d H:i:s');

        // Validate required fields
        if (!$address) {
            echo json_encode(['success' => false, 'message' => 'Adres ontbreekt.']);
            exit;
        }
        if (!$restaurant_id) {
            echo json_encode(['success' => false, 'message' => 'Restaurant ID ontbreekt.']);
            exit;
        }
        if (!is_array($cart) || count($cart) === 0) {
            echo json_encode(['success' => false, 'message' => 'Winkelwagen is leeg of ongeldig.']);
            exit;
        }

        // Insert into orders table
        $stmt = $mysqli->prepare("
            INSERT INTO orders (restaurant_id, user_id, address_id, address, order_date, order_delivery_note, order_food_note, offline) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("iiissssi", $restaurant_id, $user_id, $address_id, $address, $order_date, $order_note, $food_note, $offline);

        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Fout bij het opslaan van de bestelling.']);
            exit;
        }

        $order_id = $stmt->insert_id;
        $stmt->close();

        // Insert order items
        $stmt = $mysqli->prepare("
            INSERT INTO order_dishes (order_id, dish_id, quantity, price) VALUES (?, ?, ?, ?)
        ");

        foreach ($cart as $item) {
            $dish_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $stmt->bind_param("iiid", $order_id, $dish_id, $quantity, $price);
            $stmt->execute();
        }

        $stmt->close();
        $mysqli->close();

        echo json_encode(['success' => true, 'message' => 'Bestelling succesvol geplaatst!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ongeldige aanvraag.']);
    }
}