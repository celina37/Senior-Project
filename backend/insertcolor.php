<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('C:/xampp/htdocs/ISDProject/db_connect.php');

    // Retrieve the product ID from the hidden input field
    $product_id = $_POST['product_id'];

    $color = $_POST['color'];
    $sizes = $_POST['sizes'];
    $quantities = $_POST['quantity'];

    // Check if the color already exists for the product
    $query = "SELECT * FROM product_color WHERE product_id = '$product_id' AND color = '$color'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Color already exists for this product!');</script>";
    } else {
        // Color doesn't exist, proceed with inserting the color into the database
        $query = "INSERT INTO product_color (product_id, color) 
                  VALUES ('$product_id', '$color')";
        if (mysqli_query($conn, $query)) {
            // Color inserted successfully, continue with the remaining code
            $product_color_id = mysqli_insert_id($conn);

            // Insert product images
            $mainimg = $_FILES["mainimg"]["name"];
            $backimg = $_FILES["backimg"]["name"];

            $mainimg_folder = "C:/xampp/htdocs/ISDProject/uploads/mainimg/" . $mainimg;
            $backimg_folder = "C:/xampp/htdocs/ISDProject/uploads/backimg/" . $backimg;

            if (file_exists($mainimg_folder)) {
                echo "<script>alert('Main image already exists!');</script>";
            } else {
                move_uploaded_file($_FILES["mainimg"]["tmp_name"], $mainimg_folder);
            }

            if (file_exists($backimg_folder)) {
                echo "<script>alert('Back image already exists!');</script>";
            } else {
                move_uploaded_file($_FILES["backimg"]["tmp_name"], $backimg_folder);
            }

            $insert_images_query = "INSERT INTO product_images (product_color_id, mainimg_path, backimg_path) 
                                    VALUES ('$product_color_id', '$mainimg', '$backimg')";
            if (!mysqli_query($conn, $insert_images_query)) {
                echo "<script>alert('Error inserting product images: " . mysqli_error($conn) . "');</script>";
            }

            // Insert multi images
            $extension = array('jpeg', 'jpg', 'png', 'gif');
            if (isset($_FILES['multi']['tmp_name']) && is_array($_FILES['multi']['tmp_name'])) {
                foreach ($_FILES['multi']['tmp_name'] as $key => $value) {
                    $filename = $_FILES['multi']['name'][$key];
                    $filename_tmp = $_FILES['multi']['tmp_name'][$key];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    
                    if (in_array($ext, $extension)) {
                        $finalimg = '';
    
                        $folder = 'C:/xampp/htdocs/ISDProject/uploads/descimg/' . $filename;
                        if (file_exists($folder)) {
                            echo "<script>alert('Multi image $filename already exists!');</script>";
                        } else {
                            if (!file_exists($folder)) {
                                move_uploaded_file($filename_tmp, $folder);
                                $finalimg = $filename;
                            } else {
                                $filename = str_replace('.', '-', basename($filename, $ext));
                                $newfilename = $filename . time() . "." . $ext;
                                move_uploaded_file($filename_tmp, 'C:/xampp/htdocs/ISDProject/uploads/descimg/' . $newfilename);
                                $finalimg = $newfilename;
                            }
    
                            $insert_multi_image_query = "INSERT INTO multiimages (product_color_id, image_path) 
                                                         VALUES ('$product_color_id', '$finalimg')";
                            if (!mysqli_query($conn, $insert_multi_image_query)) {
                                echo "<script>alert('Error inserting multi image: " . mysqli_error($conn) . "');</script>";
                            }
                        }
                    } else {
                        echo "<script>alert('Invalid file type');</script>";
                    }
                }
            }

            // Insert product sizes
            foreach ($sizes as $index => $size_id) {
                $quantity = $quantities[$index];
  
                $insert_size_query = "INSERT INTO product_sizes (quantity,quantityavailable, prod_id, size_id, color_id) 
                VALUES ('$quantity','$quantity', '$product_id', '$size_id', '$product_color_id')";
                if (!mysqli_query($conn, $insert_size_query)) {
                    echo "<script>alert('Error inserting product size: " . mysqli_error($conn) . "');</script>";
                }
            }

            mysqli_close($conn);

            echo "<script>window.location.href = 'allproducts.php';</script>";
        } else {
            echo "<script>alert('Error inserting color: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>
