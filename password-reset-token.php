<?php use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
include 'db_connect.php';
// Check if the form was submitted with a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the email address from the form submission
  $email = $_POST['email'];

 
  $query = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'");

  if (mysqli_num_rows($query) == 0) {
  
   $error = "User not found. Please try again.";
      header('location:forget-password.php? error=' . urlencode($error));
      exit;
  }


  // Generate a random password reset token
  $reset_token = bin2hex(random_bytes(32));
// Set the reset expiration time to 1 hour from now
$reset_expires = strtotime('+1 hour');

// Store the reset token and expiration time in the user's record in the database
$update_query = "UPDATE users SET reset_token = '$reset_token', reset_expires = '$reset_expires' WHERE email = '$email'";
mysqli_query($conn, $update_query);

  // Send an email to the user with a link to reset their password
  $mail = new PHPMailer();
  $mail->isSMTP();
  $mail->Host = 'sandbox.smtp.mailtrap.io';
  $mail->SMTPAuth = true;
  $mail->Username = '740bc31ba4b5eb'; // Replace with your email address
  $mail->Password = '1b26edd7f37751'; // Replace with your email password
  $mail->SMTPSecure = 'tls';
  $mail->Port = 2525;
  $mail->setFrom('cgcouture@team.lb');
  $mail->addAddress($email);
  $mail->Subject = 'Password Reset Request';
  $mail->isHTML(true);
  $mail->Body = '<div style="background-color: #f2f2f2; padding: 30px; font-family: Arial, sans-serif; font-size: 16px;">
                    <p>Hello,</p>
                    <p>You have requested to reset your password. To do so, please click on the following button:</p>
                    <p><a href="http://localhost:8080/ISDProject/reset-password.php?token='.$reset_token.'" style="background-color: #5f9ea0; color: white; padding: 14px 25px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-bottom: 30px;">Reset Password</a></p>
                    <p>This link will expire in 1 hour.</p>
                    <p>Best regards,<br>CG Team</p>
                 </div>';
    if (!$mail->send()) {
    echo "Error sending email: " . $mail->ErrorInfo;
  } else {
    $error = "The reset link has been sent to $email.";
		header('location:forget-password.php? error=' . urlencode($error));
   
    

  }
}
