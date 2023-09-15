<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('C:/xampp/htdocs/ISDProject/db_connect.php');

    $name = $_POST['name'];
    $category_id = $_POST['category'];

    $stmt = mysqli_prepare($conn, "INSERT INTO subcategories (subcatname, cat_id) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "si", $name, $category_id);
    mysqli_stmt_execute($stmt);

    // Check if the insertion was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo "Error inserting subcategory.";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
