<?php
session_start();

if (isset($_POST['productId']) && isset($_POST['size'])) {
  $productId = $_POST['productId'];
  $size = $_POST['size'];

  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
  }

  $_SESSION['cart'][$productId] = $size;

}
?>