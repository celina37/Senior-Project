<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$product_id = $_GET['product_id'];

$sql = "SELECT  products.name, 
                products.price,
                categories.id AS category_id,
                categories.categoryname,
                subcategories.id AS subcat_id, 
                subcategories.subcatname, 
                size.name AS Size,
                product_sizes.color_id,
                product_color.color,
                product_images.mainimg_path, 
                product_images.backimg_path,
                categories.gender_id,
                size.id AS size_id,
                product_color.id AS color_id,
                product_sizes.quantity
                FROM 
                products
                INNER JOIN categories ON products.category_id = categories.id
                INNER JOIN subcategories ON products.subcat_id = subcategories.id
                INNER JOIN product_sizes ON products.pID = product_sizes.prod_id
                INNER JOIN size ON product_sizes.size_id = size.id
                INNER JOIN product_color ON product_sizes.color_id = product_color.id
                INNER JOIN product_images ON product_color.id = product_images.product_color_id
                WHERE 
                products.pID = $product_id
                ORDER BY 
                size.id, product_color.color";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['product_id'] = $product_id;
    $_SESSION['product_name'] = $row["name"];
    $_SESSION['gender_id'] = $row["gender_id"];
    $_SESSION['product_price'] = $row["price"];
    $_SESSION['category_id'] = $row["category_id"];
    $_SESSION['category_name'] = $row["categoryname"];
    $_SESSION['subcat_id'] = $row["subcat_id"];
    $_SESSION['subcat_name'] = $row["subcatname"];
    $_SESSION['size_id'] = $row["Size"];
    $_SESSION['color'] = $row["color"];
    $_SESSION['color_id'] = $row["color_id"];
    $_SESSION['mainimg_path'] = $row["mainimg_path"];
    $_SESSION['backimg_path'] = $row["backimg_path"];    
} else {
    echo "No product found with ID $product_id";
}

$colors = array();
while ($row = mysqli_fetch_assoc($result)) {
    $color = array(
        'id' => $row['color_id'],
        'name' => $row['color']
    );
    if (!in_array($color, $colors)) {
        $colors[] = $color;
    }
}

//Submission 
// if (isset($_POST['submit'])) {
//     // Get the submitted data
//     $product_name = $_POST['product_name'];
//     $product_price = $_POST['product_price'];
//     $category_id = $_POST['category_id'];
//     $category_name = $_POST['category_name'];
//     $subcat_id = $_POST['subcat_id'];
//     $subcat_name = $_POST['subcat_name'];

    
//     // Update the product details
//     $sql = "UPDATE products SET name='$product_name', price='$product_price' WHERE pID=$product_id";
//     $result = mysqli_query($conn, $sql);

//     header("Location: $_SERVER[PHP_SELF]?product_id=$product_id");
// }

?>