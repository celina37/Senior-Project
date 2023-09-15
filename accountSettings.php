<?php include ('db_connect.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Account Settings</title>
</head>
<body>
	<form method="post" action="updateAccount.php">
		<label for="fname">First Name:</label>
		<input type="text" id="fname" name="fname" value="<?php echo $fname; ?>"><br><br>

		<label for="lname">Last Name:</label>
		<input type="text" id="lname" name="lname" value="<?php echo $lname; ?>"><br><br>

		<input type="submit" name="save" value="Save">
		<input type="button" name="back" value="Back" onclick="window.history.back();">
	</form>
</body>
</html>