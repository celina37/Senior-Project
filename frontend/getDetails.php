<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$pID = isset($_GET['pID']) ? $_GET['pID'] : '';
$colorId = isset($_GET['color']) ? str_replace('color-', '', $_GET['color']) : '';

echo "pID:: ".$pID;
echo "cID:: ".$colorId;


$sql = "SELECT products.pID AS pID, products.name AS product_name, products.price, product_images.mainimg_path, product_images.backimg_path, 
                multiimages.image_path AS multiimg_path, product_color.color, size.name AS size_name
        FROM products
            INNER JOIN product_color ON products.pID = product_color.product_id
            INNER JOIN product_images ON product_color.id = product_images.product_color_id
            INNER JOIN multiimages ON product_color.id = multiimages.product_color_id
            INNER JOIN product_sizes ON product_color.id = product_sizes.color_id AND products.pID = product_sizes.prod_id
            INNER JOIN size ON product_sizes.size_id = size.id
        WHERE products.pID = $pID AND product_sizes.quantityavailable > 0 AND product_sizes.quantity > 0 AND product_color.id = $colorId";

// if (isset($colorId))
//     $sql .= " AND product_color.id = $colorId ";

$result = $conn->query($sql);

$product_infos = array();
$available_sizes = array();
$available_colours = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pID = $row["pID"];
        $product_name = $row["product_name"];
        $price = $row["price"];
        $mainimg = $row["mainimg_path"];
        $backimg = $row["backimg_path"];
        $multiimg_path = $row["multiimg_path"];
        $color = $row["color"];
        $size = $row["size_name"];
    
        $found = false;
        foreach ($product_infos as &$product_info) {
            if ($product_info['product_name'] == $product_name && $product_info['price'] == $price) {
                $found = true;
                if ($multiimg_path) {
                    if (!in_array($multiimg_path, $product_info['multiimg_paths'])) {
                        $product_info['multiimg_paths'][] = $multiimg_path;
                    }
                }
                break;
            }
        }
        if (!$found) {
            $product_info = array(
                "pID" => $pID,
                "product_name" => $product_name,
                "price" => $price,
                "mainimg" => $mainimg,
                "backimg" => $backimg,
                "color" => $color,
                "size" => $size,
                "multiimg_paths" => array()
            );
            if ($multiimg_path) {
                $product_info['multiimg_paths'][] = $multiimg_path;
            }
            $product_infos[] = $product_info;
        }
        
        if (!in_array($size, $available_sizes)) {
            $available_sizes[] = $size;
        }
    }
}

if (count($product_infos) > 0) {
    foreach ($product_infos as $product_info) {
        echo "Product ID: " . $product_info['pID'] . "<br>";
        echo "Product Name: " . $product_info['product_name'] . "<br>";
        echo "Price: $" . $product_info['price'] . "<br>";
        echo "Main Image: " . $product_info['mainimg'] . "<br>";
        echo "Back Image: " . $product_info['backimg'] . "<br>";
        echo "Multi Image Paths: " . implode(', ', $product_info['multiimg_paths']) . "<br>";
        echo "Color: " . $product_info['color'] . "<br>";
        echo "Size: " . implode(', ', $available_sizes) . "<br>";
        echo "<br>";
    }
}

// All colors
$sql = "SELECT DISTINCT product_color.id AS color_id, product_color.color, product_images.mainimg_path
        FROM products
        INNER JOIN product_color ON products.pID = product_color.product_id
        INNER JOIN product_images ON product_color.id = product_images.product_color_id
        WHERE products.pID = $pID";

$result = $conn->query($sql);

$colors = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $color_id = $row['color_id'];
        $color = $row['color'];
        $mainimg = $row['mainimg_path'];

        $colors[] = array(
            'color_id' => $color_id,
            'color' => $color,
            'mainimg' => $mainimg
        );
    }
} else {
    echo "No colors found.";
}

foreach ($colors as $color) {
    echo "Color ID: " . $color['color_id'] . "<br>";
    echo "Color: " . $color['color'] . "<br>";
    echo "Main Image: " . $color['mainimg'] . "<br>";
}

// All Sizes
$size_options = array();
$sql = "SELECT DISTINCT size.id, size.name
        FROM size
        INNER JOIN product_sizes ON size.id = product_sizes.size_id
        INNER JOIN product_color ON product_sizes.color_id = product_color.id
        ORDER BY size.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $size_options[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
}

$_SESSION['product_infos'] = $product_infos;
$_SESSION['size_options'] = $size_options;
$_SESSION['available_sizes'] = $available_sizes;
$_SESSION['colors'] = $colors;

$conn->close();

header('location: details.php?pID='.$pID.'&color='.$colorId);
exit();

?>