
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
    <div class=" alert alert-light alert-dismissible fade show p-3">
                      Forgot your password? <strong> No problem. </strong> Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
</div>


<?php if(isset($_GET['error'])) { ?>
  <p class="text-success pl-3 pr-3">
    <?php echo $_GET['error']; ?></p>
<?php } ?>
   <form method="post" action="password-reset-token.php">
   
<input type="email" id="email" name="email" placeholder=" " required>
<label class="pb-3" for="email">Email</label>
<div class="font-weight-bold text-right">
<button class="btn btn-dark align-center mb-3" type="submit" style="width:50%;" >EMAIL PASSWORD RESET LINK</button> </div>
</form>
</div>
</div>
</div>
</div>

   </body>
</html>