<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $product_id = $_GET['product_id'];
    $colorId = $_GET['color'];

    if (isset($_POST['sizes']) && isset($_POST['quantity'])) {
        $sizes = $_POST['sizes'];
        $quantities = $_POST['quantity'];
        $sizeNames = implode("','", $sizes);

        // Get all sizes for the product and color
        $getAllSizesQuery = "SELECT id, name FROM size";
        $sizesResult = $conn->query($getAllSizesQuery);

        $existingSizes = array();
        while ($row = mysqli_fetch_assoc($sizesResult)) {
            $existingSizes[$row['name']] = $row['id'];
        }

        foreach ($sizes as $index => $size) {
            $quantity = isset($quantities[$index]) ? $quantities[$index] : 0;

            if ($quantity == 0 || !isset($_POST['checkboxes'][$index])) {
                // Remove the size
                $sizeId = isset($existingSizes[$size]) ? $existingSizes[$size] : null;
                if ($sizeId) {
                    $updateQuery = "UPDATE product_sizes SET quantity = 0 WHERE prod_id = $product_id AND size_id = $sizeId AND color_id = $colorId";
                    $conn->query($updateQuery);
                }
            } else {
                // Get sizes available for the product_sizes
                $checkSizeQuery = "SELECT size_id FROM product_sizes WHERE prod_id = $product_id AND size_id = (SELECT id FROM size WHERE name = '$size') AND color_id = $colorId";
                $stmt = $conn->query($checkSizeQuery);
                $existingSize = mysqli_fetch_assoc($stmt);

                if (!$existingSize) {
                    // Size does not exist, insert the new size with its quantity
                    $insertSizeQuery = "INSERT INTO product_sizes (quantity, quantityavailable, prod_id, size_id, color_id) VALUES ($quantity, $quantity, $product_id, (SELECT id FROM size WHERE name = '$size'), $colorId)";
                    $conn->query($insertSizeQuery);
                } else {
                    // Size already exists, update
                    $sizeId = $existingSize['size_id'];

                    $updateQuery = "UPDATE product_sizes SET quantity = $quantity, quantityavailable = $quantity WHERE prod_id = $product_id AND size_id = $sizeId AND color_id = $colorId";
                    $conn->query($updateQuery);
                }
            }
        }

        // Update the mainimg and backimg
        if (isset($_FILES['mainimg']['tmp_name']) && !empty($_FILES['mainimg']['tmp_name'])) {
            $mainimg = $_FILES['mainimg']['name'];
            // Set temp vars
            $mainimgTmpPath = $_FILES['mainimg']['tmp_name'];
            // For location set
            $mainimgPath = '../uploads/mainimg/' . $mainimg;
            // Check if the mainimg already exists in the database
            $selectExistingMainImgQuery = "SELECT mainimg_path FROM product_images WHERE product_color_id = $colorId";
            $existingMainImgResult = $conn->query($selectExistingMainImgQuery);
            $existingMainImg = mysqli_fetch_assoc($existingMainImgResult)['mainimg_path'];
            if ($existingMainImg) {
                $existingMainImgPath = '../uploads/mainimg/' . $existingMainImg;
                // Delete the image
                if (file_exists($existingMainImgPath)) {
                    unlink($existingMainImgPath);
                }
            }
            // get the img and file path and store them
            move_uploaded_file($mainimgTmpPath, $mainimgPath);
            // update
            $updateImagesQuery = "UPDATE product_images SET mainimg_path = '$mainimg' WHERE product_color_id = $colorId";
            $conn->query($updateImagesQuery);
        }

        if (isset($_FILES['backimg']['tmp_name']) && !empty($_FILES['backimg']['tmp_name'])) {
            $backimg = $_FILES['backimg']['name'];
            // Set temp vars
            $backimgTmpPath = $_FILES['backimg']['tmp_name'];
            // For location set
            $backimgPath = '../uploads/backimg/' . $backimg;
            // Check if the backimg already exists in the database
            $selectExistingBackImgQuery = "SELECT backimg_path FROM product_images WHERE product_color_id = $colorId";
            $existingBackImgResult = $conn->query($selectExistingBackImgQuery);
            $existingBackImg = mysqli_fetch_assoc($existingBackImgResult)['backimg_path'];
            if ($existingBackImg) {
                $existingBackImgPath = '../uploads/backimg/' . $existingBackImg;
                if (file_exists($existingBackImgPath)) {
                    unlink($existingBackImgPath);
                }
            }
            // get the img and file path and store them
            move_uploaded_file($backimgTmpPath, $backimgPath);
            // update
            $updateImagesQuery = "UPDATE product_images SET backimg_path = '$backimg' WHERE product_color_id = $colorId";
            $conn->query($updateImagesQuery);
        }





        // Check if the multiimage array is not empty
        if (isset($_FILES['multi']['name']) && !empty($_FILES['multi']['name']) && !empty(array_filter($_FILES['multi']['name'], 'strlen'))) {

            // foreach ($_FILES['multi']['name'] as $name) {
            //     echo "Image: ".$name."<br>";
            // }

            // Retrieve existing images from the database
            $selectExistingImagesQuery = "SELECT image_path FROM multiimages WHERE product_color_id = $colorId";
            $existingImagesResult = $conn->query($selectExistingImagesQuery);

            $existingImages = array();
            while ($row = mysqli_fetch_assoc($existingImagesResult)) {
                $existingImages[] = $row['image_path'];
            }

            // Delete all existing images for the product color
            $deleteImagesQuery = "DELETE FROM multiimages WHERE product_color_id = $colorId";
            $conn->query($deleteImagesQuery);

            // Insert new images and update existing ones
            $multiimage_paths = $_FILES['multi']['name'];
            $multiimage_temps = $_FILES['multi']['tmp_name'];

            foreach ($multiimage_paths as $index => $multiimage_path) {
                $multiimage_temp = $multiimage_temps[$index];
                $imageFilePath = "../uploads/descimg/" . $multiimage_path;

                // Check if the image exists in both array and database
                if (in_array($multiimage_path, $existingImages)) {
                    // Insert the existing image back to the database
                    $insertMultiImageQuery = "INSERT INTO multiimages (product_color_id, image_path) VALUES ($colorId, '$multiimage_path')";
                    $conn->query($insertMultiImageQuery);
                } else {
                    // Move and insert the new image
                    move_uploaded_file($multiimage_temp, $imageFilePath);
                    $insertMultiImageQuery = "INSERT INTO multiimages (product_color_id, image_path) VALUES ($colorId, '$multiimage_path')";
                    $conn->query($insertMultiImageQuery);
                }
            }

            // Delete images that are not present in the new array
            $deleteImagesQuery = "DELETE FROM multiimages WHERE product_color_id = $colorId AND image_path NOT IN ('" . implode("','", $multiimage_paths) . "')";
            $conn->query($deleteImagesQuery);

            // Delete images that exist in the database but not in the new array
            foreach ($existingImages as $existingImage) {
                if (!in_array($existingImage, $multiimage_paths)) {
                    $imageFilePath = "../uploads/descimg/" . $existingImage;
                    if (file_exists($imageFilePath)) {
                        unlink($imageFilePath); // Delete the image file from the folder
                    }
                }
            }
        }


    }
    header("Location: AllProducts.php");
    exit;
}
?>