<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php'); 

// Set product_sizes_id selected on size selected
$sizeId = $_GET['sizeId'];
$color_id = $_GET['color_id'];
$pID = $_GET['pID'];

if (isset($_GET['pID']) && isset($_GET['color_id']) && isset($_GET['sizeId']))
{
    // get the product_sizes_id
    $sql = "SELECT product_sizes.id AS product_sizes_id
                FROM product_sizes 
                INNER JOIN product_color ON product_sizes.color_id = product_color.id
                WHERE product_sizes.prod_id = '$pID'
                AND product_sizes.size_id = '$sizeId'
                AND product_color.id = '$color_id'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product_sizes_id = $row['product_sizes_id'];
        $_SESSION['product_sizes_id'] = $product_sizes_id;
    } else {
        echo "unexpected Error";
        $_SESSION['product_sizes_id'] = 9;

    }
}

$_SESSION['sizeId'] = $sizeId;
$_SESSION['pID'] = $pID;


$conn->close();
?>