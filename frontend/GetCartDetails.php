<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

$product_sizes_id = isset($_GET['product_sizes_id']) ? $_GET['product_sizes_id'] : '';
$product_sizes_ids = explode(" | ", $product_sizes_id);

$cart_details = isset($_SESSION['cart_details']) ? $_SESSION['cart_details'] : array(); // Initialize as an array or use the existing cart details from the session

foreach ($product_sizes_ids as $product_sizes_id) {
    $sql = "SELECT  products.name AS product_name,
                    products.pID AS pID,
                    products.price,
                    product_color.color,
                    size.name AS size_name,
                    product_images.mainimg_path,
                    product_sizes.id AS produdcts_sizes_id,
                    COUNT(*) AS quantity
                FROM products
                JOIN product_sizes ON products.pID = product_sizes.prod_id
                JOIN size ON product_sizes.size_id = size.id
                JOIN product_color ON product_sizes.color_id = product_color.id
                JOIN product_images ON product_color.id = product_images.product_color_id
                JOIN users ON products.pID = users.id
                WHERE product_sizes.id = '$product_sizes_id' 
                GROUP BY products.pID, product_color.id, size.id;";

    // echo $sql;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $product_name = $row['product_name'];
            $price = $row['price'];
            $color = $row['color'];
            $quantity = $row['quantity'];
            $size_name = $row['size_name'];
            $mainimg_path = $row['mainimg_path'];
            $produdcts_sizes_id = $row['produdcts_sizes_id'];

            $exists = false;
            foreach ($cart_details as &$item) {
                if ($item['product_name'] == $product_name && $item['color'] == $color && $item['size_name'] == $size_name) {
                    $item['quantity'] += $quantity;
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $cart_details[] = array(
                    'product_name' => $product_name,  
                    'price' => $price,
                    'color' => $color,
                    'quantity' => $quantity,
                    'size_name' => $size_name,
                    'mainimg_path' => $mainimg_path,
                    'produdcts_sizes_id' => $produdcts_sizes_id
                );
            }
        }
    }
}

$_SESSION['cart_details'] = $cart_details;

$conn->close();
?>  