<?php

   include('C:\xampp\htdocs\ISDProject\frontend\header.php');
   include('getorderdetails.php');
   
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>

</head>
<body>

<style>
 
.content {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    padding:300px;
}

.content h1 {
    width: 70%;
    text-align: center;
    font-size:50px;
font-style: italic;
}

.color-circle {
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 1px solid grey; /* Add border properties */
  display: flex;
  justify-content: center;
  align-items: center;
}

.gradient-custom {
/* fallback for old browsers */
background: #cd9cf2;

/* Chrome 10-25, Safari 5.1-6 */
background: -webkit-linear-gradient(to top left, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1));

/* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
background: linear-gradient(to top left, rgba(205, 156, 242, 1), rgba(246, 243, 255, 1))
}

</style>
<section class="h-100 gradient-custom">
  

<?php if (mysqli_num_rows($result) > 0){ ?>

<div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-lg-10 col-xl-8">
        <div class="card" style="border-radius: 10px;">
          <div class="card-header px-4 py-5">
            <h5 class="text-muted mb-0">Thanks for your Orders, <span style="color: #a8729a;"><?php echo $fname; ?></span>!</h5>
          </div>
        
          <?php foreach ($orders as $order) { ?>
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <p class="lead fw-normal mb-0" style="color: #a8729a;">Order Date</p>
            <p class="small text-muted mb-0">Made at: <b> <?php echo $order['order_date']; ?> </b></p>
        </div>

        <?php 
        $totalAmount = 0; // Variable to store the total amount

        foreach ($order['products'] as $product) {
            $subtotal = $product['price'] * $product['quantity']; // Calculate the subtotal for each product
    $totalAmount += $subtotal; // Add the subtotal to the total amount
            ?>
            <div class="card shadow-0 border mb-4">
                <div class="card-body">
                    <div class="col-md-12 text-center d-flex justify-content-center align-items-center">
                        <p class="text-muted mb-0"><b><?php echo $product['product_name']; ?></b></p>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <img src="../uploads/mainimg/<?php echo $product['mainimg_path']; ?>" class="img-fluid" alt="Phone">
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
                            <p class="text-muted mb-0"><?php echo $product['size_name']; ?></p>
                        </div>
                        <div class="col-md-2 text-center d-flex justify-content-center align-items-center">
    <p class="text-muted mb-0 small">$<?php echo $product['price']; ?></p>
</div>
<div class="col-md-2 text-center d-flex justify-content-center align-items-center">
    <div class="color-circle" style="background-color: <?php echo $product['color']; ?>"></div>
</div>
<div class="col-md-2 text-center d-flex justify-content-center align-items-center">
    <p class="text-muted mb-0 small">Qty: <?php echo $product['quantity']; ?></p>
</div>
<div class="col-md-2 text-center d-flex justify-content-center align-items-center">
    <p class="text-muted mb-0 small">$<?php echo $product['price'] * $product['quantity']; ?></p>
</div>

                    </div>
                </div>
            </div>
        <?php } ?>

        <div class="d-flex justify-content-between pt-2">
    <p class="fw-bold mb-0">Order Details</p>
    <p class="text-muted mb-0">
        <span class="fw-bold me-4">Total</span> $<?php echo $totalAmount; ?>
    </p>
</div>

<div class="d-flex justify-content-between mb-5">
    <p class="text-muted mb-0"></p>
    <?php if ($totalAmount > 100) {
        $deliveryCharge = 0;
        $totalPaid = $totalAmount;
    } else {
        $deliveryCharge = 5;
        $totalPaid = $totalAmount + $deliveryCharge;
    } ?>
    <p class="text-muted mb-0">
        <span class="fw-bold me-4">Delivery Charges</span>
        <?php if ($deliveryCharge > 0) {
            echo "$" . $deliveryCharge;
        } else {
            echo "Free";
        } ?>
    </p>
</div>
</div>

<div class="card-footer border-0 px-4 py-5" style="background-color: #a8729a; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
    <h5 class="d-flex align-items-center justify-content-end text-white text-uppercase mb-0">Total paid: <span class="h2 mb-0 ms-2">$<?php echo $totalPaid; ?></span></h5>
</div>
<?php } ?>


        </div>
      </div>
    </div>
  </div>
  <?php } else{ ?>



    <div class="content">
        <h1 class="text-muted" >You don't have any order, <a href="../frontend/index.php"> start shopping! </a></h1>
    </div>
    <?php } ?>



</section>
</body>
</html>
<?php
   include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>
