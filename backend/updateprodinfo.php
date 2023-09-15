<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('C:/xampp/htdocs/ISDProject/db_connect.php');

    $product_id = $_SESSION['product_id'];
    
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        $query = "UPDATE products SET name = '$name' WHERE pID = '$product_id'";
        if (!mysqli_query($conn, $query)) {
            echo "<script>alert('Error updating name: " . mysqli_error($conn) . "');</script>";
            echo "<script>window.location.href = 'editinfo.php';</script>";
        }
    }

    if (isset($_POST['price'])) {
        $price = $_POST['price'];
        $query = "UPDATE products SET price = '$price' WHERE pID = '$product_id'";
        if (!mysqli_query($conn, $query)) {
            echo "<script>alert('Error updating price: " . mysqli_error($conn) . "');</script>";
            echo "<script>window.location.href = 'editinfo.php';</script>";
        }
    } else { echo "No Price";}

    if (isset($_POST['category'])) {
        $category_id = $_POST['category'];
        $query = "UPDATE products SET category_id = '$category_id' WHERE pID = '$product_id'";
        if (!mysqli_query($conn, $query)) {
            echo "<script>alert('Error updating category: " . mysqli_error($conn) . "');</script>";
            echo "<script>window.location.href = 'editinfo.php';</script>";
        }
    } else { echo "No category";}

    if (isset($_POST['subcategory'])) {
        $subcat_id = $_POST['subcategory'];
        $query = "UPDATE products SET subcat_id = '$subcat_id' WHERE pID = '$product_id'";
        if (!mysqli_query($conn, $query)) {
            echo "<script>alert('Error updating subcategory: " . mysqli_error($conn) . "');</script>";
            echo "<script>window.location.href = 'editinfo.php';</script>";
        }
    } else { echo "No subcategory";}

    echo "<script>alert('Product updated successfully.');</script>";
    echo "<script>window.location.href = 'allproducts.php';</script>";
}
