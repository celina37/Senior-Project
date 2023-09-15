<?php
  include('C:\xampp\htdocs\ISDProject\frontend\header.php');
?>

<?php 

    if(isset($_SESSION['prdct_display']))
    {
        echo $_SESSION['prdct_display']; 
    }
    else
    {
      echo 'Nothing prdct_display'; 
    }
    unset($_SESSION['prdct_display']);
?>

<?php
  include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>
