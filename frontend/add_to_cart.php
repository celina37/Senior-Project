<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

if (isset($_SESSION['id']) && isset($_SESSION['cart_details'])) {
    $cart_details = $_SESSION['cart_details'];
    $user_id = $_SESSION['id'];
    $totalamount = $_SESSION['Total_Price'];
    $order_date = date('Y-m-d H:i:s');
    
    $sql = "INSERT INTO `order` (`user_id`, `totalamount`, `order_date`)
            VALUES ('$user_id', '$totalamount', '$order_date')";
    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);

        foreach ($cart_details as $index => $cart_item) {
            $produdcts_sizes_id = $cart_item['product_sizes_id'];
            $quantity = $cart_item['quantity'];

            $sql = "INSERT INTO `order_details` (`order_id`, `prod_size_id`, `quantity`)
                    VALUES ('$order_id', '$produdcts_sizes_id', '$quantity')";

            if (!mysqli_query($conn, $sql)) {
                echo "Error inserting order details: " . mysqli_error($conn);
            }

            $sql = "UPDATE product_sizes SET quantityavailable = quantityavailable - $quantity, quantitysold = quantitysold + $quantity
            WHERE id = $produdcts_sizes_id";

        
            if (!mysqli_query($conn, $sql)) {
                echo "Error updating quantity available: " . mysqli_error($conn);
            }
        }
    
        echo "Order placed successfully.";
        unset($_SESSION['cart_details']);
        header("Location: yourorders.php"); // Redirect to yourorders.php
        exit(); // Ensure the script stops executing after the redirect
    } else {
        echo "Error inserting order: " . mysqli_error($conn);
    }
}
?>
