<?php
require_once "../db_conn.php";

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        
        default:
            echo json_encode(array('success' => false, 'message' => 'Type bestaat niet.'));
            break;
    }
}else {
    echo json_encode(array('success' => false, 'message' => 'Type bestaat niet in URL.'));
}