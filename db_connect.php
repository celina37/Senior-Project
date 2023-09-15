<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once('C:\xampp\htdocs\ISDProject\resources.php');

$conn = mysqli_connect("localhost", "root", "", "isdproject");

if (!$conn)
{
    die("Connection failed: " . mysqli_connect_error());
}

$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

if (isset($id) && $id != 0 && $id != null)
{
    $fname = isset($_SESSION['fname']) ? $_SESSION['fname'] : '';
    $lname = isset($_SESSION['lname']) ? $_SESSION['lname'] : '';

    $sql = "SELECT * FROM users WHERE id = '$id'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1)
    {
        $row = mysqli_fetch_assoc($result);
        $id = $row['id'];
        $fname = $row['fname'];
        $lname = $row['lname'];
        $email = $row['email'];
        $phone = $row['phone'];
    }
} else {
    $fname = "Guest";
}



?>