<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

if(isset($_POST['colorId'], $_POST['pID'])) {
    $colorId = $_POST['colorId'];
    $pID = $_POST['pID'];

    mysqli_begin_transaction($conn);
    try {
        // Check if the product contains only one color
        $stmtCountColors = mysqli_prepare($conn, "SELECT COUNT(DISTINCT color_id) AS num_colors FROM product_sizes WHERE prod_id = ?");
        mysqli_stmt_bind_param($stmtCountColors, "i", $pID);
        mysqli_stmt_execute($stmtCountColors);
        $resultCountColors = mysqli_stmt_get_result($stmtCountColors);
        $rowCountColors = mysqli_fetch_assoc($resultCountColors);
        $numColors = $rowCountColors['num_colors'];

        if ($numColors <= 1) {
            // Display alert message and don't delete the color
            echo "<script>alert('Only one color exists for this product. You should delete the whole product.')</script>";
            echo "<script>window.location.href = 'allproducts.php'</script>";
       
        } else {
        $stmt = mysqli_prepare($conn, "DELETE FROM product_sizes WHERE color_id = ? AND prod_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $colorId, $pID);
        mysqli_stmt_execute($stmt);

        $stmt = mysqli_prepare($conn, "SELECT id FROM product_color WHERE id = ? AND product_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $colorId, $pID);
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
        }

        $stmt = mysqli_prepare($conn, "DELETE FROM product_color WHERE id = ? AND product_id = ?");
        mysqli_stmt_bind_param($stmt, "ii", $colorId, $pID);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);

        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } }catch (Exception $e) {
        mysqli_rollback($conn);
        echo "Error deleting color: " . $e->getMessage();
    }
} else {
    echo "Oops!! something went wrong";
}
?>
