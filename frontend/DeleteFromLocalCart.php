<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_SESSION['cart_details'][$id])) {
      if ($_SESSION['cart_details'][$id]['quantity'] > 1) {
        $_SESSION['cart_details'][$id]['quantity'] -= 1;
      } else {
        unset($_SESSION['cart_details'][$id]);
      }
    }
  } else {
    unset($_SESSION['cart_details']);
  }
}
header ("location: Cart.php");
exit();
?>