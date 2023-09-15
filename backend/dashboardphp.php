<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$sql = "SELECT products.name, 
        products.price,
        categories.categoryname,
        subcategories.subcatname, 
        size.name AS Size,
        product_sizes.color_id,
        product_color.color,
        product_images.mainimg_path, 
        product_images.backimg_path,
        categories.gender_id,
        size.id AS size_id,
        product_color.id AS color_id,
        product_sizes.quantity,
        product_sizes.quantitysold,
        product_sizes.quantityavailable
        FROM products
        INNER JOIN categories ON products.category_id = categories.id
        INNER JOIN subcategories ON products.subcat_id = subcategories.id
        INNER JOIN product_sizes ON products.pID = product_sizes.prod_id
        INNER JOIN size ON product_sizes.size_id = size.id
        INNER JOIN product_color ON product_sizes.color_id = product_color.id
        INNER JOIN product_images ON product_color.id = product_images.product_color_id
        ORDER BY size.id, product_color.color";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $products = array();
    $soldOutProducts = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $product = array(
            'name' => $row["name"],
            'price' => $row["price"],
            'categoryname' => $row["categoryname"],
            'subcatname' => $row["subcatname"],
            'Size' => $row["Size"],
            'color_id' => $row["color_id"],
            'color' => $row["color"],
            'mainimg_path' => $row["mainimg_path"],
            'backimg_path' => $row["backimg_path"],
            'gender_id' => $row["gender_id"],
            'size_id' => $row["size_id"],
            'quantity' => $row["quantity"],
            'quantitysold' => $row["quantitysold"],
            'quantityavailable' => $row["quantityavailable"]
        );

        $products[] = $product;

        if ($row["quantityavailable"] == 0) {
            $soldOutProducts[] = $product;
        } elseif ($row["quantitysold"] > 0) { 
            $soldProducts[] = $product;
        }
    }
}
?>
