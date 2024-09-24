<?php
require_once "../db_conn.php";

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'get_dishes':
            getDishesFromDB($mysqli);
            break;
        case 'remove_item':
            removeItemFromCart();
            break;
        case 'update_totalprice':
            updateTotalPrice();
            break;
        case 'add_to_cart':
            addToCart();
            break;
        case 'update_cart':
            updateCart();
            break;
        case 'add_dish':
            addDishToDB();
    }
}
function getDishesFromDB($mysqli){
    if (isset($_GET['category'])) {
        $category = $mysqli->real_escape_string($_GET['category']);

        $sql = "SELECT * FROM dishes WHERE category = '$category'";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            $html = '<ul class="homepage-category">';
            while ($row = $result->fetch_assoc()) {
                $html .= '<li class="homepage-categoryitem" onclick="handleCategoryItemClick(this)"';
                $html .= ' data-name="' . htmlspecialchars($row["name"]) . '"';
                $html .= ' data-price="' . htmlspecialchars($row["price"]) . '"';
                $html .= ' data-cents="' . htmlspecialchars($row["cents"]) . '">';
                $html .= '<div class="homepage-imgcontainer">';
                $html .= '<img class="homepage-itemimg" src="' . $row["filepath"] . '" alt="">';
                $html .= '</div>';
                $html .= '<div class="homepage-itemtitlecontainer">';
                $html .= '<p class="homepage-itemtitle">' . $row["name"] . '</p>';
                $html .= '</div>';
                $html .= '<div class="homepage-pricecontainer">';
                $html .= '<p class="homepage-price">€' . $row["price"] . ',</p>';
                $html .= '<small>' . $row["cents"] . '</small>';
                $html .= '</div>';
                $html .= '</li>';
            }
            $html .= '</ul>';
            echo $html;
        } else {
            echo "No dishes found for this category";
        }
    } else {
        echo "Error: Category parameter is missing";
    }

    $mysqli->close();
}

function removeItemFromCart(){
    session_start();
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['name'])) {
        if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $key => $item) {
                if ($item['name'] === $data['name']) {
                    unset($_SESSION['cart'][$key]);
                    return;
                }
            }
        }
        echo 'Item not found in cart';
    } else {
        echo 'Error: Invalid data';
    }
}

function updateTotalPrice(){
    session_start();

    $totalPrice = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $totalPrice += ($item['price'] + ($item['cents'] / 100)) * $item['quantity'];
        }
    }

    echo number_format($totalPrice, 2);
}

function addToCart(){
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['name']) && isset($data['price']) && isset($data['cents'])) {
        session_start();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['name'] === $data['name']) {
                $item['quantity'] = isset($item['quantity']) ? $item['quantity'] + 1 : 1;
                $found = true;
                break;
            }
        }
        if (!$found) {
            $_SESSION['cart'][] = [
                'name' => $data['name'],
                'price' => $data['price'],
                'cents' => $data['cents'],
                'quantity' => 1
            ];
        }

        echo 'Data added to session cart';
    } else {
        echo 'Error: Invalid data';
    }
}

function updateCart(){
    session_start();

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            echo '<div class="order-basket">';
            echo '<p class="order-amount">' . $item['quantity'] . 'x</p>';
            echo '<p class="order-title">' . $item['name'] . '</p>';
            echo '<p class="order-price">€' . $item['price'] . ',' . '<small>' . $item['cents'] . '</small></p>';
            echo '<button onclick="handleRemoveItem(this)" class="order-remove">X</button>';
            echo '</div>';
        }
    } else {
        echo '<p style="font-size: 1.4rem; text-align: center;">Your cart is empty...</p>';
    }
}

function addDishToDB(){
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all required fields are filled
        if (isset($_POST['title'], $_POST['category'], $_POST['price'], $_POST['cents'], $_FILES['image'])) {

            require_once "../db_conn.php";

            // Generate random image name
            $randomName = uniqid('productimg-') . '-' . uniqid() . '-' . uniqid();

            // Define file path
            $targetDirectory = "../productimg/";
            $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if ($check !== false) {
                // File is an image - do nothing
            } else {
                echo "File is not an image.";
                exit;
            }

            // Check if file already exists
            if (file_exists($targetFile)) {
                echo "Sorry, file already exists.";
                exit;
            }

            // Check file size (adjust as necessary)
            if ($_FILES["image"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                exit;
            }

            // Allow certain file formats (you can customize this)
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                exit;
            }

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetDirectory . $randomName . '.' . $imageFileType)) {
                // File uploaded successfully
                // Now insert data into database
                $title = $_POST['title'];
                $category = $_POST['category'];
                $price = $_POST['price'];
                $cents = $_POST['cents'];
                $ingredients = implode(', ', $_POST['ingredients']); // Convert ingredients array to string

                // SQL query to insert data into database
                $sql = "INSERT INTO your_table_name (name, filepath, category, price, cents, ingredients) VALUES ('$title', '$randomName.$imageFileType', '$category', '$price', '$cents', '$ingredients')";

                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                $conn->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "All fields are required.";
            exit;
        }
    } 
}