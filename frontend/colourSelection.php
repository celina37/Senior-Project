<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$image_id = $_GET['image_id'];
$color_id = $_GET['color_id'];
$pID = $_GET['pID'];
$sizeId = $_GET['sizeId'];

if (isset($_GET['image_id']) && isset($_GET['color_id']) && isset($_GET['pID']) ) {

    $sql = "SELECT product_sizes.id AS product_sizes_id, 
                    product_sizes.color_id, 
                    size.name AS size_name, 
                    product_color.id AS color_id, 
                    product_images.mainimg_path AS mainimg_path, 
                    product_images.backimg_path, 
                    product_sizes.quantity AS quantity,
                    GROUP_CONCAT(multiimages.image_path) AS multiimg_paths
                FROM product_sizes
                INNER JOIN product_color ON product_sizes.color_id = product_color.id
                INNER JOIN size ON product_sizes.size_id = size.id
                INNER JOIN product_images ON product_color.id = product_images.product_color_id
                LEFT JOIN multiimages ON product_color.id = multiimages.product_color_id
                WHERE product_color.id = '$color_id' 
                AND product_sizes.quantityavailable > 0
                AND product_sizes.prod_id = '$pID'
                GROUP BY product_sizes.id";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sizes = array();

    while ($row = $result->fetch_assoc()) {
        $product_sizes_id = $row['product_sizes_id'];
        $_SESSION['product_sizes_id'] = $product_sizes_id;
        $_SESSION['mainimg_path'] = $row['mainimg_path'];
        $_SESSION['backimg_path'] = $row['backimg_path'];
        $sizes[] = $row['size_name'];
        $_SESSION['multiimg_paths'] = explode(",", $row['multiimg_paths']);
        }

        $_SESSION['sizes'] = $sizes;
        $_SESSION['colour_id'] = $color_id;

        $response = array(
        'mainimg_path' => $_SESSION['mainimg_path'],
        'backimg_path' => $_SESSION['backimg_path'],
        'sizes' => $sizes,
        'multiimg_paths' => $_SESSION['multiimg_paths']
        );
    }
}

// if (isset($_GET['pID']) && isset($_GET['color_id']) && isset($_GET['sizeId']))
// {
//     // get the product_sizes_id
//     $sql = "SELECT product_sizes.id AS product_sizes_id
//                 FROM product_sizes 
//                 INNER JOIN product_color ON product_sizes.color_id = product_color.id
//                 WHERE product_sizes.prod_id = '$pID'
//                 AND product_sizes.size_id = '$sizeId'
//                 AND product_color.id = '$color_id'";

//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         $row = $result->fetch_assoc();
//         $product_sizes_id = $row['product_sizes_id'];
//         $_SESSION['product_sizes_id'] = $product_sizes_id;
//     } else {
//         echo "unexpected Error";
//         $_SESSION['product_sizes_id'] = 10;

//     }
// }
$conn->close();
?>