<?php
$servername = "localhost:8080";
$username = "root";
$password = "root";
$dbname = "flavorflow-v2";

// Create connection in mysqli
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection in mysqli
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}