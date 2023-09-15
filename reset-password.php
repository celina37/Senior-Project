<?php 
require 'vendor/autoload.php';
include 'db_connect.php';

// Check if the reset token is in the URL
if (isset($_GET['token'])) {
  $reset_token = $_GET['token'];

  // Lookup the user's record by the reset token in the database
  $stmt = $conn->prepare('SELECT * FROM users WHERE reset_token = ?');
  $stmt->bind_param('s', $reset_token);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user) {
    // Check if the reset token has expired
    if ($user['reset_expires'] > time()) {
      // Render the password reset form
      ?>
      <?php
    include 'resources.php';
   
?>
<!doctype html>

<html>
<head>
    <title>Forget Password</title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>
   <body style="background-color: #eee;">
   
  
<div class="container h-50 mt-5">
   <div class="row d-flex justify-content-center align-items-center h-180">
    
    <div class="col-xl-8">
   <div class="card">
  
    <div class="card-body px-5">
    <div class="text-center">

                
<img src="LogoISDWhite.jpeg"
  style="width: 185px;" alt="logo">


</div>
<p class="bg-light p-3">For security purposes, password must be at least 5 characters ,contain at least 1 digit, 1 special character and 1 capital letter.</p>

<form method="post" action="update_password.php" onsubmit="return validatePassword()">
  <input type="hidden" name="reset_token" value="<?= $reset_token ?>">
  
  <input type="password" id="new_password" name="new_password" placeholder=" " required pattern="^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z]).{5,}$">
  <label class="pb-3" for="new_password">New Password:</label>
  <input type="password" id="confirm_password" name="confirm_password" placeholder=" " required>
  <label class="pb-3" for="confirm_password">Confirm Password:</label>
  
  <div class="text-center pt-1 mb-5 pb-1">
    <button class="btn btn-primary align-center mb-3" type="submit" id="secondary" style="width:50%;" value="reset" name="reset">Reset Password</button>
  </div>
</form>

<script>
function validatePassword() {
  var newPassword = document.getElementById("new_password").value;
  var confirmPassword = document.getElementById("confirm_password").value;
  if (newPassword != confirmPassword) {
    alert("Passwords do not match.");
    return false;
  }
  return true;
}
</script>

      <?php
    } else {
      echo "Invalid or expired reset token.";
    }
  } else {
    echo "Reset token not found in URL.";
  }
}
?> 
