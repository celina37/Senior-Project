
<?php 
include('db_connect.php');
session_start();

if(isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];
	$error = "";

	$query = mysqli_query($conn, "SELECT * FROM `users` WHERE email='$email'");

	if (mysqli_num_rows($query) == 0) {
		$error = "Login Failed. User not Found!";
		header('location:login_register.php?error=' . urlencode($error));
		exit;
	}

	$row = mysqli_fetch_array($query);

	if (!password_verify($password, $row['password'])) {
		$error = 'Incorrect email or password. Please try again.';
		header('location:login_register.php?error=' . urlencode($error));
		exit;
	}

	$_SESSION['id'] = $row['id'];
	if ($row['bAdmin'] == 1) {
		header('location:../ISDProject/backend/admin_dashboard.php');
		exit;
	} else {
		header('location:../ISDProject/frontend/index.php');
		exit;
	}
} else {
	$error = 'Incorrect email or password. Please try again.';
	header('location:login_register.php');
	exit;
}
?>