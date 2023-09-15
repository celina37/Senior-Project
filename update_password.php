<?php
require 'vendor/autoload.php';
include 'db_connect.php';

if (isset($_POST['reset'])) {
  $reset_token = $_POST['reset_token'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  // Validate the new password
  if (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z]).{5,}$/", $new_password)) {
    // Password does not meet requirements
    echo "Password must be at least 5 characters, contain at least 1 digit, 1 special character and 1 capital letter.";
    exit;
  }

  // Check if the new password and confirm password match
  if ($new_password !== $confirm_password) {
    echo "Passwords do not match.";
    exit;
  }

  // Hash the new password
  $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

  // Update the user's password in the database
  $stmt = $conn->prepare('UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE reset_token = ?');
  $stmt->bind_param('ss', $hashed_password, $reset_token);
  if ($stmt->execute()) {
    
    $error = "Password updated successfully.";
		header('location:login_register.php? error=' . urlencode($error));

  } else {
    echo "Error updating password.";
  }
}
?>
