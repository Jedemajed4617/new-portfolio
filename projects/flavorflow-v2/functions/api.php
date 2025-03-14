<?php

include './functions.php';
require_once '../db_conn.php';

function getCategoriesFromDatabase($mysqli) {
    header('Content-Type: application/json');

    // Debug: Log that the function is being called
    error_log("getCategoriesFromDatabase function called");

    // Get the restaurant_id from the session
    session_start(); // Start the session
    $restaurant_id = $_SESSION['restaurant_id'] ?? null; // Fetch restaurant_id from session

    if ($restaurant_id === null) {
        echo json_encode(array('status' => 'error', 'message' => 'Restaurant ID is missing'));
        return;
    }

    // Prepare the SQL query to fetch categories for the specific restaurant_id
    $query = "SELECT category_id, category_name FROM category WHERE restaurant_id = ?";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        error_log("Database error: failed to prepare statement");
        echo json_encode(array('status' => 'error', 'message' => 'Database error: failed to prepare statement'));
        return;
    }

    // Bind the restaurant_id parameter to the query
    $stmt->bind_param("i", $restaurant_id);

    if (!$stmt->execute()) {
        error_log("Database error: failed to execute statement");
        echo json_encode(array('status' => 'error', 'message' => 'Database error: failed to execute statement'));
        return;
    }

    $result = $stmt->get_result();
    if ($result === false) {
        error_log("Database error: failed to get result");
        echo json_encode(array('status' => 'error', 'message' => 'Database error: failed to get result'));
        return;
    }

    $categories = array();
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    $stmt->close();

    // Debug: Log the fetched categories
    error_log("Fetched categories: " . print_r($categories, true));

    // Always return the categories array, even if it's empty
    echo json_encode(array('status' => 'success', 'categories' => $categories));
}

if (isset($_GET['function'])) {
    if ($_GET['function'] === "getCategoriesFromDatabase") {
        getCategoriesFromDatabase($mysqli);
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid function"]);
        exit;
    }
} else {
    echo json_encode(["status" => "error", "message" => "Function parameter missing"]);
    exit;
}

$mysqli->close();