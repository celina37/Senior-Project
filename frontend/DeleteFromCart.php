<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM cart WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location: Cart.php');
        http_response_code(204);
        exit;
    } else {
        echo 'Error deleting item: ' . $conn->error;
    } 
}

$conn->close();
?>
