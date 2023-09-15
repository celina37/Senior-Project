<?php
session_start();
include('C:\xampp\htdocs\ISDProject\db_connect.php');
$sizeId = isset($_POST['size']) ? $_POST['size'] : '';
$colorId = isset($_POST['color_id']) ? $_POST['color_id'] : '';
$prod_id = isset($_POST['prod_id']) ? $_POST['prod_id'] : '';

$sql = "SELECT id
FROM product_sizes
WHERE color_id = $colorId AND prod_id = $prod_id AND size_id = '$sizeId';";
echo $sql;
$result = mysqli_query($conn, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $product_sizes_id = $row['id'];
} else {
    $product_sizes_id = '';
}

$cart_details = isset($_SESSION['cart_details']) ? $_SESSION['cart_details'] : array();

$sql = "SELECT  products.name AS product_name,
              products.pID AS pID,
              products.price,
              product_color.color,
              size.name AS size_name,
              product_images.mainimg_path,
              product_sizes.id AS product_sizes_id,
              product_sizes.quantityavailable AS quantityavailable,
              COUNT(*) AS quantity
        FROM products
              JOIN product_sizes ON products.pID = product_sizes.prod_id
              JOIN size ON product_sizes.size_id = size.id
              JOIN product_color ON product_sizes.color_id = product_color.id
              JOIN product_images ON product_color.id = product_images.product_color_id
              WHERE product_sizes.id = $product_sizes_id
              GROUP BY products.pID, product_color.id, size.id;";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $ItemExists = -1;
    while ($row = $result->fetch_assoc()) {
        $newItem = array(
            'product_name' => $row['product_name'],
            'price' => $row['price'],
            'color' => $row['color'],
            'quantity' => $row['quantity'],
            'size_name' => $row['size_name'],
            'mainimg_path' => $row['mainimg_path'],
            'product_sizes_id' => $row['product_sizes_id'],
            'quantityavailable' => $row['quantityavailable'],
            'pID' => $row['pID']
        );

        
        

        foreach ($cart_details as $index => $item) {
            if ($item['product_sizes_id'] == $newItem['product_sizes_id']) {
                $ItemExists = $index;
                break;
            }
        }
        if ($ItemExists !== -1) {
            $cart_details[$ItemExists]['quantity'] += $newItem['quantity'];
        } else {
            $cart_details[] = $newItem;
        }
    }
}

$_SESSION['cart_details'] = $cart_details;

$conn->close();
$previousPage = $_SERVER['HTTP_REFERER'];
header("Location: $previousPage");
exit();
?>
