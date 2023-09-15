<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

if(isset($_GET['id'])) {
    $subcat_id = $_GET['id'];

    mysqli_begin_transaction($conn);

    try {
     // Get the product_color_ids for the products with subcat_id = $subcat_id
$stmt = mysqli_prepare($conn, "SELECT id FROM product_color WHERE product_id IN (SELECT pID FROM products WHERE subcat_id = ?)");
mysqli_stmt_bind_param($stmt, "i", $subcat_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $product_color_id = $row['id'];

    // Delete product_images related to each product_color_id
    $stmt2 = mysqli_prepare($conn, "SELECT mainimg_path, backimg_path FROM product_images WHERE product_color_id = ?");
    mysqli_stmt_bind_param($stmt2, "i", $product_color_id);
    mysqli_stmt_execute($stmt2);
    $result2 = mysqli_stmt_get_result($stmt2);

    while ($row2 = mysqli_fetch_assoc($result2)) {
        // Delete main image
        $main_image_path = '../uploads/mainimg/' . $row2['mainimg_path'];
        if (file_exists($main_image_path)) {
            unlink($main_image_path);
        }

        // Delete back image
        $back_image_path = '../uploads/backimg/' . $row2['backimg_path'];
        if (file_exists($back_image_path)) {
            unlink($back_image_path);
        }
    }

    // Delete product_images related to each product_color_id
    $stmt3 = mysqli_prepare($conn, "DELETE FROM product_images WHERE product_color_id = ?");
    mysqli_stmt_bind_param($stmt3, "i", $product_color_id);
    mysqli_stmt_execute($stmt3);

    // Delete multiimages related to each product_color_id
    $stmt4 = mysqli_prepare($conn, "SELECT image_path FROM multiimages WHERE product_color_id = ?");
    mysqli_stmt_bind_param($stmt4, "i", $product_color_id);
    mysqli_stmt_execute($stmt4);
    $result4 = mysqli_stmt_get_result($stmt4);

    while ($row4 = mysqli_fetch_assoc($result4)) {
        // Delete description image
        $desc_image_path = '../uploads/descimg/' . $row4['image_path'];
        if (file_exists($desc_image_path)) {
            unlink($desc_image_path);
        }
    }

    // Delete multiimages related to each product_color_id
    $stmt5 = mysqli_prepare($conn, "DELETE FROM multiimages WHERE product_color_id = ?");
    mysqli_stmt_bind_param($stmt5, "i", $product_color_id);
    mysqli_stmt_execute($stmt5);

    // Delete product_sizes related to each product_color_id
    $stmt6 = mysqli_prepare($conn, "DELETE FROM product_sizes WHERE color_id = ?");
    mysqli_stmt_bind_param($stmt6, "i", $product_color_id);
    mysqli_stmt_execute($stmt6);
}


        // Delete product_color related to the products with subcat_id = $subcat_id
        $stmt = mysqli_prepare($conn, "DELETE FROM product_color WHERE product_id IN (SELECT pID FROM products WHERE subcat_id = ?)");
        mysqli_stmt_bind_param($stmt, "i", $subcat_id);
        mysqli_stmt_execute($stmt);

        // Delete products with subcat_id = $subcat_id
        $stmt = mysqli_prepare($conn, "DELETE FROM products WHERE subcat_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $subcat_id);
        mysqli_stmt_execute($stmt);

        // Delete subcategories with cat_id = $subcat_id
        $stmt = mysqli_prepare($conn, "DELETE FROM subcategories WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "i", $subcat_id);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);

        // Redirect to the previous page
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error deleting products, subcategory " . $e->getMessage();
    }
} else {
    echo "Oops! Something went wrong.";
}
?>
