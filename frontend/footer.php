<link rel="stylesheet" type="text/css" href="footer.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<?php
    $email = "CGWeb@gmail.com";
    $facebook = "https://www.facebook.com/CGCoutour";
    $instagram = "https://www.instagram.com/CGCoutour";
    $whatsapp = "https://wa.me/+96112345678"; 
?>

<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h3>About Us</h3>
        <p>Dedicated to deliver the best to our customers</p>
      </div>
      <div class="col-md-4">
        <h3>Follow Us</h3>
        <ul class="social-icons">
          <li><a href="<?php echo $facebook ?>"><i class="fab fa-facebook-f"></i></a></li>
          <li><a href="<?php echo $instagram ?>"><i class="fab fa-instagram"></i></a></li>
          <li><a href="mailto:<?php echo $email ?>"><i class="far fa-envelope"></i></a></li>
          <li><a href="<?php echo $whatsapp ?>"><i class="fab fa-whatsapp"></i></a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h3>Address</h3>
        <p>Saloume<br>Mount Lebanon, Lebanon</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <hr>
        <p class="text-center">&copy; 2023 CG Coutour. All Rights Reserved.</p>
      </div>
    </div>
  </div>
</footer>
<style>
  footer {
    background-color: #f8f9fa;
    color: #6c757d;
    padding: 50px 0;
    text-align: center;
  }

  footer h3 {
    color: #343a40;
    font-size: 24px;
    margin-bottom: 20px;
  }
  
  footer p {
    margin: 0 0 10px;
    font-size: 14px;
  }
  
  .social-icons {
    list-style: none;
    margin: 0;
    padding: 0;
    text-align: center;
  }
  
  .social-icons li {
    display: inline-block;
    margin: 0 10px;
  }
  
  .social-icons a {
    display: block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    color: #fff;
    background-color: #343a40;
    border-radius: 50%;
    transition: background-color 0.3s ease;
  }
  
  .social-icons a:hover {
    background-color: #28a745;
  }
  
  hr {
    border-top: 1px solid #6c757d;
    margin: 30px 0;
  }
  
  .text-center {
    text-align: center;
  }
  
  .social-icons li a {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 40px;
    width: 40px;
    border-radius: 50%;
    background-color: #343a40;
    color: #ffffff;
    margin: 5px;
  }
  
  
  #footer a:hover {
    color: rgb(88, 102, 115);
  }


</style>