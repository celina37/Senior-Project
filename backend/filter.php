<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');
$gender = isset($_GET['gender']) ? $_GET['gender'] : (isset($_SESSION['gender']) ? $_SESSION['gender'] : 1);
$subcat_id = isset($_GET['subcat_id']) ? $_GET['subcat_id'] : '';

$query_products = "SELECT * 
                FROM products
                INNER JOIN categories AS cat ON cat.id = products.category_id 
                WHERE cat.gender_id = ?";

$params = array($gender);

if (!empty($subcat_id)) {
    $query_products .= " AND products.subcat_id = ?";
    $params[] = $subcat_id;
}

$stmt = $conn->prepare($query_products);
$stmt->bind_param(str_repeat("s", count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();

$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

$category_query = "SELECT * FROM categories WHERE gender_id = ?";
$category_stmt = $conn->prepare($category_query);
$category_stmt->bind_param("i", $gender);
$category_stmt->execute();
$categories_result = $category_stmt->get_result();
$categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);

if (!empty($categories)) {
    $category_info = array();
    foreach ($categories as $category) {
        $category_id = $category['id'];
        $categoryname = $category['categoryname'];

        $query_subcategories = "SELECT subcategories.id, subcategories.subcatname 
                                FROM subcategories
                                WHERE subcategories.cat_id = ?";
        $subcategory_stmt = $conn->prepare($query_subcategories);
        $subcategory_stmt->bind_param("i", $category_id);
        $subcategory_stmt->execute();
        $subcategories_result = $subcategory_stmt->get_result();
        $subcategories = mysqli_fetch_all($subcategories_result, MYSQLI_ASSOC);

        if (!empty($subcategories)) {
            $subcategories_info = array();
            foreach ($subcategories as $subcategory) {
                $subcat_id = $subcategory['id'];
                $subcatname = $subcategory['subcatname'];
                $subcategories_info[] = array(
                    'id' => $subcat_id,
                    'subcatname' => $subcatname
                );
            }
            $category_info[] = array(
                'id' => $category_id,
                'name' => $categoryname,
                'subcategories' => $subcategories_info,
                'categoryname' => $categoryname
            );
        }
    }
    $_SESSION['category_info'] = $category_info;
}

if (!empty($products)) {
    $product_info = array();
    foreach ($products as $product) {
        $product_id = $product['pID'];

        $colors_query = "SELECT product_color.id AS colorId, color, mainimg_path, backimg_path 
                        FROM product_color 
                        INNER JOIN product_images ON product_color.id = product_images.product_color_id 
                        WHERE product_id = ?";
        $colors_stmt = $conn->prepare($colors_query);
        $colors_stmt->bind_param("i", $product_id);
        $colors_stmt->execute();
        $colors_result = $colors_stmt->get_result();
        $colors = mysqli_fetch_all($colors_result, MYSQLI_ASSOC);

        $sizes_query = "SELECT product_sizes.*, size.name AS size_name
                        FROM product_sizes
                        INNER JOIN size ON product_sizes.size_id = size.id
                        WHERE product_sizes.prod_id = ?";
        $sizes_stmt = $conn->prepare($sizes_query);
        $sizes_stmt->bind_param("i", $product_id);
        $sizes_stmt->execute();
        $sizes_result = $sizes_stmt->get_result();
        $sizes = mysqli_fetch_all($sizes_result, MYSQLI_ASSOC);

        $images_query = "SELECT * FROM product_images WHERE product_color_id = ?";
        $images_stmt = $conn->prepare($images_query);
        $images_stmt->bind_param("i", $product_id);
        $images_stmt->execute();
        $images_result = $images_stmt->get_result();
        $images = mysqli_fetch_all($images_result, MYSQLI_ASSOC);

        $product_info[] = array(
            'pID' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'colors' => $colors,
            'size_name' => $sizes,
            'images' => $images
        );
    }
    $_SESSION['product_info'] = $product_info;
}

$categoryQuery = "SELECT id, categoryname FROM categories WHERE gender_id = ?";
$categoryStmt = $conn->prepare($categoryQuery);
$categoryStmt->bind_param("i", $gender);
$categoryStmt->execute();
$categoryResult = $categoryStmt->get_result();
$categoryItems = array();
$subcategoryItems = array();

if ($categoryResult) {
    while ($categoryRow = mysqli_fetch_assoc($categoryResult)) {
        $categoryID = $categoryRow['id'];
        $categoryName = $categoryRow['categoryname'];

        $categoryItems[$categoryID] = array(
            'category_id' => $categoryID,
            'category_name' => $categoryName
        );
        
        $subcategoryQuery = "SELECT id, subcatname FROM subcategories WHERE cat_id = ?";
        $subcategoryStmt = $conn->prepare($subcategoryQuery);
        $subcategoryStmt->bind_param("i", $categoryID);
        $subcategoryStmt->execute();
        $subcategoryResult = $subcategoryStmt->get_result();
        
        if ($subcategoryResult) {
            while ($subcategoryRow = mysqli_fetch_assoc($subcategoryResult)) {
                $subcategoryID = $subcategoryRow['id'];
                $subcategoryName = $subcategoryRow['subcatname'];
                
                $subcategoryItems[$subcategoryID] = array(
                    'subcategory_id' => $subcategoryID,
                    'subcategory_name' => $subcategoryName,
                    'cat_id' => $categoryID
                );
            }
        }
    }
}

$_SESSION['categoryItems'] = $categoryItems;
$_SESSION['subcategoryItems'] = $subcategoryItems;
// idk why it works like this.. sending it back to self
$_SESSION['gender'] = $gender;

$num_rows = mysqli_num_rows($result);


?>