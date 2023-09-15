
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('C:/xampp/htdocs/ISDProject/db_connect.php');

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = $_POST['category'];
    $subcat_id = $_POST['subcategory'];
   
    $color = $_POST['color'];
    $sizes = $_POST['sizes'];
    $quantities = $_POST['quantity'];

    // main image
    if (isset($_FILES["mainimg"])) {
        $mainimg = $_FILES["mainimg"]["name"];
        $tempmain = $_FILES["mainimg"]["tmp_name"];
        $folder = "C:/xampp/htdocs/ISDProject/uploads/mainimg/" . $mainimg;

        if (move_uploaded_file($tempmain, $folder)) {
            // echo "<script>alert('Image uploaded successfully!');</script>";
        } else {
            // echo "<script>alert('Failed to upload image!');</script>";
        }
    } else {
        // echo "<script>alert('No main image uploaded!');</script>";
        $mainimg = null;
    }

    // back image
    if (isset($_FILES["backimg"])) {
        $backimg = $_FILES["backimg"]["name"];
        $tempback = $_FILES["backimg"]["tmp_name"];
        $folder = "C:/xampp/htdocs/ISDProject/uploads/backimg/" . $backimg;

        if (move_uploaded_file($tempback, $folder)) {
            // echo "<script>alert('Back Image uploaded successfully!');</script>";
        } else {
            // echo "<script>alert('Failed to upload back image!');</script>";
        }
    } else {
        // echo "<script>alert('No back image uploaded!');</script>";
        $backimg = null;
    }

    $query = "INSERT INTO products (category_id, name, price, subcat_id) 
              VALUES ('$category_id', '$name', '$price', '$subcat_id')";
    mysqli_query($conn, $query);
    $product_id = mysqli_insert_id($conn);
    $query = "INSERT INTO product_color (product_id, color) 
    VALUES ('$product_id', '$color')";
    if (mysqli_query($conn, $query)) {
        // echo "<script>alert('Record inserted successfully');</script>";
    } else {
        // echo "<script>alert('Error inserting record: " . mysqli_error($conn) . "');</script>";
        // echo "<script>alert('Query: " . $query . "');</script>";
    }
    $product_color_id = mysqli_insert_id($conn);
 
    $query = "INSERT INTO product_images (product_color_id,mainimg_path,backimg_path) 
    VALUES ('$product_color_id', '$mainimg','$backimg')";
    if (mysqli_query($conn, $query)) {
        // echo "<script>alert('Record inserted successfully');</script>";
    } else {
        // echo "<script>alert('Error inserting record: " . mysqli_error($conn) . "');</script>";
        // echo "<script>alert('Query: " . $query . "');</script>";
    }

    $extension=array('jpeg','jpg','png','gif');
    if (isset($_FILES['multi']['tmp_name']) && is_array($_FILES['multi']['tmp_name'])) {
        foreach ($_FILES['multi']['tmp_name'] as $key => $value) {
		$filename=$_FILES['multi']['name'][$key];
		$filename_tmp=$_FILES['multi']['tmp_name'][$key];
		$ext=pathinfo($filename, PATHINFO_EXTENSION);

		if (in_array($ext,$extension)) {
			$finalimg = '';
			if(!file_exists('C:/xampp/htdocs/ISDProject/uploads/descimg/'.$filename)) {
				move_uploaded_file($filename_tmp, 'C:/xampp/htdocs/ISDProject/uploads/descimg/'.$filename);
				$finalimg=$filename;
			} else {
				$filename=str_replace('.','-',basename($filename,$ext));
				$newfilename=$filename.time().".".$ext;
				move_uploaded_file($filename_tmp, 'C:/xampp/htdocs/ISDProject/uploads/descimg/'.$newfilename);
				$finalimg=$newfilename;
			}
			$insertqry="INSERT INTO `multiimages`(`product_color_id`, `image_path`) VALUES ('$product_color_id','$finalimg')";
			if (mysqli_query($conn, $insertqry)) {
				// echo "insertrdddd";
			} else {
				// echo "Error: " . mysqli_error($con);
			}
		} else {
			// echo "Invalid file type";
		}
	}
}


   // ...

   foreach ($sizes as $index => $size_id) {
    $quantity = $quantities[$index];
  
    $query = "INSERT INTO product_sizes (quantity, quantityavailable, prod_id, size_id, color_id) 
              VALUES ('$quantity', '$quantity', '$product_id', '$size_id', '$product_color_id')";
    if (mysqli_query($conn, $query)) {
        // echo "Record inserted successfully<br>";
    }
 else {
        // echo "Error inserting record: " . mysqli_error($conn) . "<br>";
        // echo "Query: " . $query . "<br>";
    }   
    $product_sizes_id = mysqli_insert_id($conn);
}

mysqli_close($conn);

echo "<script>window.location.href = 'allproducts.php';</script>";

}
?>
