
<?php
   include('C:\xampp\htdocs\ISDProject\frontend\header.php');
   
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gift Card</title>

</head>

<body>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-4 p-3">
      <div id="demo" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ul class="carousel-indicators">
          <li data-target="#demo" data-slide-to="0" class="active"></li>
          <li data-target="#demo" data-slide-to="1"></li>
        </ul>

        <!-- The slideshow -->
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="/ISDProject/frontgift.png" alt="Front Card" class="d-block w-100">
          </div>
          <div class="carousel-item">
            <img src="/ISDProject/backgift.png" alt="Back Card" class="d-block w-100">
          </div>
        </div>

        <!-- Left and right controls -->
        <a class="carousel-control-prev" href="#demo" data-slide="prev">
          <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#demo" data-slide="next">
          <span class="carousel-control-next-icon"></span>
        </a>
      </div>
    </div>

    <div class="col-md-4 p-3">
      <h4>To:</h4>
      <input type="text" class="form-control mb-3" placeholder="Enter recipient's name">

      <h4>Message:</h4>
      <textarea class="form-control mb-3" placeholder="Enter your message here"></textarea>
      <h4>Budget:</h4>
      <div class="price-group">
        <button class="price-btn">$10</button>
        <button class="price-btn">$25</button>
        <button class="price-btn">$50</button>
        <button class="price-btn">$100</button>
        
      </div>
      <button class="btn btn-primary btn-lg btn-block mt-3">
  Add to Cart<i class="fa fa-shopping-cart mr-2"></i>
</button>
      
    </div>
  </div>
</div>

<style>
 
  .carousel {
    height: 100%;
  }

  .carousel-inner {
    height: 100%;
  }

  .carousel-item {
    height: 100%;
  }

  .carousel-item img {
    height: 100%;
    object-fit: cover;
  }

  .col-md-4 {
    height: 100%;
    padding: 0;
  }
  button.btn:hover {
    background-color: #3e8e41;
  }
  
  .price-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    margin-top: 20px;
  }
  
  button.price-btn {
    padding: 10px 20px;
    background-color: #fff;
    border: 2px solid #4CAF50;
    border-radius: 25px;
    color: #4CAF50;
    font-weight: bold;
    margin-right: 10px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  button.price-btn:hover {
    background-color: #4CAF50;
    color: #fff;
  }
  button.btn {
    padding: 10px 20px;
    background-color: #4CAF50;
    border: none;
    border-radius: 5px;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;}
</style>

</body>
</html>

<?php
   include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>