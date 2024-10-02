<?php
$servername = "server64.web-hosting.com";
$username = "tgsoqmsy_jedemajed";
$password = "Fcmedemblik2006!";
$dbname = "tgsoqmsy_nvvn";

// Create connection in mysqli
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection in mysqli
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}