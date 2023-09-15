<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$sql = "SELECT
          `order`.id,
          `order`.order_date,
          products.name AS product_name,
          products.price AS price,
          size.name AS size_name,
          product_color.color,
          product_images.mainimg_path,
          order_details.quantity
        FROM
          `order`
          JOIN order_details ON `order`.id = order_details.order_id
          JOIN product_sizes ON order_details.prod_size_id = product_sizes.id
          JOIN products ON product_sizes.prod_id = products.pID
          JOIN size ON product_sizes.size_id = size.id
          JOIN product_color ON product_sizes.color_id = product_color.id
          JOIN product_images ON product_color.id = product_images.product_color_id
        WHERE
          `order`.user_id = $id
          ORDER BY order_date DESC";

$result = mysqli_query($conn, $sql);
$orders = array();

if (mysqli_num_rows($result) > 0) {
  // Iterate over the retrieved rows
  while ($row = mysqli_fetch_assoc($result)) {
    $orderId = $row['id'];
    if (!isset($orders[$orderId])) {
      $orders[$orderId] = array(
        'id' => $orderId,
        'order_date' => $row['order_date'],
        'products' => array()
      );
    }

    $product = array(
      'product_name' => $row['product_name'],
      'price' => $row['price'],
      'size_name' => $row['size_name'],
      'color' => $row['color'],
      'mainimg_path' => $row['mainimg_path'],
      'quantity' => $row['quantity']
    );

    $orders[$orderId]['products'][] = $product;
  }
} else {
  
}

// Don't forget to close the database connection
mysqli_close($conn);
?>
