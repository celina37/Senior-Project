<?php
  
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('C:/xampp/htdocs/ISDProject/db_connect.php');


    $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';
    $city = $_POST['city'];
    $street = $_POST['street'];
    $building = $_POST['building'];
    $floor = $_POST['floor'];
    
    $sql = "INSERT INTO address (user_id, city, street, building, floor) VALUES ('$id', '$city', '$street', '$building', '$floor')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: ../frontend/address_order.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    
    mysqli_close($conn);
   }


?>