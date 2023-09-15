<?php
include "db_connect.php";
session_start();  

$fname = $_POST['fname'];
$lname = $_POST['lname'];
$phone = $_POST['phone'];
$email = $_POST['remail'];
$password = $_POST['rpassword'];
$error = ""; // Initialize the error message

if (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z]).{5,}$/", $password))
{
    $error = "Password must be at least 5 characters, contain at least 1 digit, 1 special character, and 1 capital letter.";
    header('location:login_register.php?error=' . urlencode($error));
    exit;
}

// Check if the email is already taken
$qry = "SELECT * FROM users WHERE email = '$email'";
$result = mysqli_query($conn, $qry);

if (mysqli_num_rows($result) > 0)
{
    $error = "Email is already taken, please try another one.";
    header('location:login_register.php?error=' . urlencode($error));
    exit;
}

// Check if the phone number is already taken
$qry = "SELECT * FROM users WHERE phone = '$phone'";
$result = mysqli_query($conn, $qry);

if (mysqli_num_rows($result) > 0)
{
    $error = "Phone number is already taken, please try another one.";
    header('location:login_register.php?error=' . urlencode($error));
    exit;
}   

// If email and phone number are available, proceed with registration
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$qry = "INSERT INTO users (fname, lname, phone, email, password) VALUES ('$fname', '$lname', '$phone', '$email', '$hashed_password')";

mysqli_query($conn, $qry) or die(mysqli_error($conn));
$_SESSION['id'] = mysqli_insert_id($conn);

header('location:login_register.php');
exit;    
?>
