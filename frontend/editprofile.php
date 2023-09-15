<?php
    include('C:\xampp\htdocs\ISDProject\frontend\header.php');
    include('C:\xampp\htdocs\ISDProject\db_connect.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
</head>

<style>
@import url("https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap");
body {
	background: #e5eaea;
	font-family: "Roboto", sans-serif;
}

.shadow {
	box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1) !important;
}

.profile-tab-nav {
	min-width: 250px;
}

.tab-content {
	flex: 1;
}

.form-group {
	margin-bottom: 1.5rem;
}

.nav-pills a.nav-link {
	padding: 15px 20px;
	border-bottom: 1px solid #ddd;
	border-radius: 0;
	color: #333;
}
.nav-pills a.nav-link i {
	width: 20px;
}
    </style>
<body>
    <section class="py-5 my-5">
        <div class="container">
            <div class="bg-white shadow rounded-lg d-block d-sm-flex">
                <div class="profile-tab-nav border-right">
                    <div class="p-4">
                    <h4 class="text-center"> <?php echo $fname . " " . $lname; ?></h4>
                    
                    
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            
                        
                        <a class="nav-link active" id="account-tab" data-toggle="pill" href="#account" role="tab" aria-controls="account" aria-selected="false">
                             <i class="fa fa-home text-center ar-1"></i> Account
                            </a>
                            <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="fa fa-key text-center ar-1"></i> Password
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-content p-4 p-md-5" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
        <h3 class="mb-4">Edit Profile Settings</h3>

        <?php if (isset($_GET['error'])) { ?>
            <div class="alert alert-warning alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>
        <form action="updateprofile.php" method="POST" id="update-profile-form">
        <input type="hidden" name="formm_id" value="update-profile-form"> 
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>"  required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" pattern="[+]{1}[0-9]{3}[0-9]{2}[0-9]{3}[0-9]{3}" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary mr-2">Update</button>
                <input type="button" name="back" value="Back" onclick="history.back();" class="btn btn-light">
              
            </div>
        </form>
   
                    </div>
                    <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                        <h3 class="mb-4">Change Password Settings</h3>

                        <?php if (isset($_GET['message'])) { ?>
            <div class="alert alert-warning alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <?php echo $_GET['message']; ?>
            </div>
        <?php } ?>
                        <form id="update-password-form" action="updatepassword.php" method="POST">
                        <input type="hidden" name="form_id" value="update-password-form">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Old Password</label>
                <input type="password" class="form-control" name="old_password" id="old-password-input">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" name="new_password" id="new-password-input">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm-password-input">
            </div>
        </div>
    </div>
    <button class="btn btn-primary mb-2 mr-2">Change Password</button>
    <input type="button" name="back" value="Back" onclick="history.back();" class="btn btn-light mb-2 ">
</form>
<a class="text-info" href="../forget-password.php">Forgot password?</a>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  
  
  
  
  
  <?php
   include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>


</body>
</html>





