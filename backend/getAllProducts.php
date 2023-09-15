<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');
$searchSQL = $_GET['search'] ?? '';

$sql = "SELECT 
            products.pID AS 'Product ID',
            products.name AS 'Product Name',
            products.Price AS 'Price',
            categories.gender_id AS 'Gender ID',
            categories_1.categoryname AS 'Category',
            subcategories.subcatname AS 'Sub-category',
            product_images.mainimg_path AS 'Main Image',
            product_images.backimg_path AS 'Back Image',

            GROUP_CONCAT(DISTINCT size.name ORDER BY size.id) AS 'Sizes',
            product_color.id As 'Color Id',
            product_color.color AS 'Color',
            product_sizes.quantity AS 'Quantity',
            FLOOR(products.Price * product_sizes.quantity * 100) / 100 AS 'Total Price'
        FROM products
            LEFT JOIN categories ON products.category_id = categories.id
            LEFT JOIN subcategories ON products.subcat_id = subcategories.id
            LEFT JOIN categories AS categories_1 ON categories_1.id = subcategories.cat_id
            LEFT JOIN product_sizes ON products.pID = product_sizes.prod_id
            LEFT JOIN size ON product_sizes.size_id = size.id
            LEFT JOIN product_color ON product_sizes.color_id = product_color.id
            LEFT JOIN product_images ON product_images.id = product_color.product_id
            GROUP BY products.pID";
 
if (!empty($searchSQL)) {
    $searchSQL = mysqli_real_escape_string($conn, $searchSQL);
    $sql .= " HAVING products.name LIKE '%{$searchSQL}%'"; //after GROUP BY
}

$result = mysqli_query($conn, $sql);
$products = array();
        $color_images = array();

while ($row = mysqli_fetch_assoc($result)) {
    $mainImagePath = '../uploads/mainimg/' . $row['Main Image'];
    $backImagePath = '../uploads/backimg/' . $row['Back Image'];
    $product_id = $row['Product ID'];
    $colorid=$row['Color Id'];

    if (!isset($products[$product_id])) {
        $products[$product_id] = array(
            'Product ID' => $product_id,
            'Product Name' => $row['Product Name'],
            'Gender ID' => $row['Gender ID'],
            'Category' => $row['Category'],
            'Sub-category' => $row['Sub-category'],
            'Price' => $row['Price'],
            'Total Price' => 0,
            'Colors' => array() // Initialize an empty array for colors
        );
    }
    
    if (!isset($products[$product_id]['Colors'][$colorid])) {
        $products[$product_id]['Colors'][$colorid] = array(
            'Main Image' => $mainImagePath,
            'Back Image' => $backImagePath
        );
    }
    

    $size = $row['Sizes'];
    $color = $row['Color'];
    $price = $row['Price'];
    $quantity = $row['Quantity'];
    $total_price = $row['Total Price'] ;

   

    $products[$product_id]['Total Price'] += $total_price;
}



?>