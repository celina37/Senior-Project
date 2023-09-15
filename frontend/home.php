<?php
   include('C:\xampp\htdocs\ISDProject\resources.php');
   
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="/ISDProject/frontend/style.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
</head>

<body>

<nav id="first-navbar" class="navbar navbar-expand-lg bg-white pt-2 nav1bar">
  <div class="container-fluid" id="content">
   
    <a class="navbar-brand mx-auto d-flex justify-content-center w-100" href="#">
      <img src="/ISDProject/logoISDcropped.jpeg" width="130" height="60" class="" alt="">
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav flex-row">
        <li class="nav-item">
        <?php if (isset($_SESSION['id'])) { ?>
    <div class="dropdown">
        <button class="btn btn-link dropdown-toggle hide-arrow" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bi bi-person-fill"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="../frontend/editprofile.php">Account Settings</a>
            <a class="dropdown-item" href="../frontend/yourorders.php">Your Orders</a>

            <a class="dropdown-item" href="../logout.php">Logout</a>
        </div>
    </div>
<?php } else { ?>
    <a class="btn btn-link" href="/ISDProject/login_register.php">
        <i class="bi bi-person-fill"></i>
    </a>
<?php } ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="openCartModal()">
            <i class="bi bi-cart3"></i>
          </a>
        </li>
      </ul>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

   <nav id="second-navbar" class="navbar navbar-expand-lg navbar-light bg-white">
  <div class="container-fluid">
    <div class="navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item ml-auto">
          <a class="nav-link" href="\ISDProject\frontend\index.php">Go To Shop</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


<h1> Welcome To Our Shop</h1>
<div class="swiper-container">
    <div class="swiper-wrapper">
      <div class="swiper-slide"><img class="photo"src="\ISDProject\homeimgs\model.png"></div>
      <div class="swiper-slide"><img class="photo" src="\ISDProject\homeimgs\model2.png"></div>
      <div class="swiper-slide"><img class="photo" src="\ISDProject\homeimgs\model5.png"></div>
      <div class="swiper-slide"><img class="photo" src="\ISDProject\homeimgs\model4.png"></div>
      <div class="swiper-slide"><img class="photo" src="\ISDProject\homeimgs\model3.png"></div>
      <div class="swiper-slide"><img class="photo" src="\ISDProject\homeimgs\model6.png"></div>
      <div class="swiper-slide"><img class="photo" src="\ISDProject\homeimgs\model7.png"></div>
      <div class="swiper-slide"><img class="photo" src="\ISDProject\homeimgs\model8.png"></div>
    </div>
    <!-- Add Pagination -->
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next id"></div>
    <div class="swiper-button-prev id"></div>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>    
<script>
    var swiper = new Swiper('.swiper-container', 
    {
     effect: 'coverflow',
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: 'auto',
      coverflowEffect: {
        rotate: 20,
        stretch: 0,
        depth: 200,
        modifier: 1,
        slideShadows: true,
      },
      loop: true,
      autoplay: {
        delay: 1500,
        disableOnInteraction: false,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });
  </script>

  </div>


 
  </div>
  <hr>
  
<h2>About us</h2>
<div class="text-parag"> 
  <p>Get ready to discover the latest and stylish designs. Explore our sections to stay on top of the latest fashion; from statement pieces to timeless classic we have something for everyone. <a href="\ISDProject\frontend\index.php" style= "color:blueblack">Start Shopping</a> now with confidence knowing that you're getting the best products and service available!</p></div>
<hr>

<div class="image-with-text">
  <img class="my-image" src="\ISDProject\homeimgs\myimage.jpeg" alt="myimage">
  <div class="text-col">
    <h3>We believe that everybody is perfect just the way they are. We embrace diversity and understand that beauty comes in all shapes and sizes. That's why we offer a wide range of sizes in our clothing collection, ensuring that every customer can find their perfect fit. We want you to feel confident and comfortable while shopping with us, knowing that our clothing is designed to celebrate and enhance your unique style. So, go ahead and explore our collection with the assurance that we've got your size covered.</h3>

  </div>
</div></div> </div> 
<hr>

<?php
   include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>
        </body>



</html>

 <style>
  

 .photo{
  width:100%;

 }
 

 .my-image {
  float: left;
  width: 600px;
  height: 290px;
  padding-left: 50px;
}
#first-navbar .dropdown-menu {
  background-color: #808080;
  border: none;
  position: absolute;
  top: 100%;
  right: 0;
  transform: translateX(-100%);
  z-index: 9999;
  
}

#-navbar .dropdown-item {
  color: #000000;
  padding: 0px 0px;
 
}

#first-navbar .dropdown-item:hover {
  background-color: #f8f9fa;
  color: #000000;
}
   .text-parag p {
  padding-left: 100px;
  padding-right: 100px;
  font-family: 'Courier New', Courier, monospace;
  font-weight: bold;
  font-size: 17px;
}
.text-parag p::first-letter{
  font-size:3em ;
  color:#550A21 ;
}

#second-navbar {
    letter-spacing: 3px;
    font-family: Arial, Helvetica, sans-serif;
    text-transform: uppercase;
    font-size: 17px;
}
  
  #second-navbar-ul {
    display: flex;
    justify-content: center;
  }
  
  #second-navbar-ul li a {
    color: rgb(36, 48, 57); 
      padding: 10px;

  }
  #second-navbar-ul li a:hover {
    color: rgb(92, 118, 141);

  }
 
  body {
	margin: 0;
	padding: 0;
    color: black;
    justify-content: center;
  
}

.container {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
}
hr {
    border-top: 1px solid #6c757d;
    margin: 50px 0;
  }
.text-col {
  margin-left: 620px;

}
.text-col h3::first-letter{
  font-size:3em ;
  color:#550A21 ;
}
.text-col h3 {
  font-family: 'Courier New', Courier, monospace;
  font-weight: bold;
  font-size: 20px;
  margin-right: 100px;
}
h2 {
	text-align: center;
    font-family: 'Courier New', Courier, monospace ;
font-weight: bold; 
text-transform: uppercase;
}
  h1{
    text-align: center;
    font-family: 'Courier New', Courier, monospace ; 
color:#550A21;
font-weight: bold;

text-transform: uppercase;
}

.swiper-container 
{
  
   width: 100%;
    padding-top: 60px;
    padding-bottom: 80px;
     overflow: hidden;
}

.swiper-slide 
{
    background-position: center;
    background-size: cover;
    width: 300px;
    height: 300px;
  }
img
{
  -webkit-box-reflect: below 1px linear-gradient(transparent,transparent, #0005);
}
.id
{
    color: black;
}


  </style>
  
