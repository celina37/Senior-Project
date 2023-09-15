<?php
session_start();
    include 'resources.php';
?>


<?php
if (isset($_POST['action']))
{
  if ($_POST['action'] == 'loginbt')
  {
      $title = 'Login';
      $header='Welcome back to your style haven!';
      $_SESSION['section'] = 'loginbt';
  }
  else if ($_POST['action'] == 'registerbt')
  {
      $title = 'Register';
      $header='Join our fashion community and start exploring!';
      $_SESSION['section'] = 'registerbt';
  }
}
else if (isset($_POST['action']))
{
  $title = '';
  $header = '';
  if (isset($_SESSION['section']))
  {
    $section = $_SESSION['section'];
    if ($section == 'loginbt')
    {
      $title = 'Login';
      $header = 'Welcome back to your style haven!';
    }
    else if ($section == 'registerbt')
    {
      $title = 'Register';
      $header = 'Join our fashion community and start exploring!';
    }
  }
} else {
  $title = 'Login';
  $header='Welcome back to your style haven!';
}


?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="styles.css">

</head>

<body>

<section class="h-100" style="background-color: #eee;">
  <div class="container h-100">
    <!-- make items centered inside the container -->
    <div class="row d-flex justify-content-center align-items-center h-100">
    
      <div class="col-xl-8">
        <div class="card text-black">
          
              <div class="card-body p-md-3 mx-md-2">

                <div class="text-center">

                
                  <img src="LogoISDWhite.jpeg"
                    style="width: 185px;" alt="logo">
                
               

                    <h4 class="mt-1 mb-5 pb-1 font-italic"><?php echo $header; ?></h4>
                </div>
      

<div class="container h-50">
    <div class="row d-flex justify-content-center align-items-center h-50">
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-10">
      <form method="POST" action="login_register.php">
        
               <div class="row no-gutters">
      <div class="col-6">
 
  <button class="btn btn-outline-secondary mb-5" type="submit" name="action" value="loginbt" style="width:95%;" >Login</button>
  
</div>
  <div class="col-6">
  <button class="btn btn-outline-secondary mb-5" type="submit" name="action" value="registerbt" style="width:95%;" >Register</button>

</div>

</div>
</form>


<?php if(isset($_GET['error'])) { ?>
  <div class="alert alert-warning alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <?php echo $_GET['error']; ?></div>
<?php } ?>
<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']))
{
  // $action = $_POST['action'];
  if ($_POST['action'] === 'loginbt')
  {
    include 'login.php';
    $_SESSION['section'] = 'loginbt';
  }
  else if ($_POST['action'] === 'registerbt')
  {
    include 'register.php';
    $_SESSION['section'] = 'registerbt';
  }
}
else if (isset($_SESSION['section']))
  {
    $section = $_SESSION['section'];
    if ($section == 'loginbt')
    {
      include 'login.php';
    }
    else if ($section == 'registerbt')
    {
      include 'register.php';
    }
  }
else{
 
  include 'login.php';
}

?>

        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>