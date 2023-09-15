<?php
 include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');
 include('dashboardphp.php');
?>
    
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

</head>

<body>
    <style>
        .custom-card {

  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
.custom-table {
        border-radius: 10px; 
        overflow: hidden; 
    }

    .custom-table thead th {
        color:#463c74; 
        vertical-align: middle;

    }

    .custom-table tbody tr:nth-of-type(odd) {
        background-color: #f8f9fa; 
    }

    .custom-table tbody tr:nth-of-type(even) {
        background-color: #e9ecef;
    }
    .custom-table tbody td {
        vertical-align: middle; 
    }
.custom-card .bi {
  font-size: 2.5rem;
}

        </style>
<div class="container"><div class="row">
  <div class="col-md-4">
    <div class="card p-2 custom-card" style="background-color: pink;">
      <div class="card-body">
        <i class="bi bi-cart-check float-right"></i>
        <h6 class="card-subtitle mb-2 pb-3 text-muted">Total Orders</h6>
        <?php
          // Execute the SQL query to count the orders
          $query = "SELECT COUNT(id) AS total_orders FROM `order`";
          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $totalOrders = $row['total_orders'];
            echo '<h5 class="card-title">' . $totalOrders . '</h5>';
          } else {
            echo '<h5 class="card-title">0</h5>'; // If no orders found, display 0
          }
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card p-2 custom-card" style="background-color: rgba(160, 94, 255, 0.5);">
      <div class="card-body">
        <i class="bi bi-box-seam float-right"></i>
        <h6 class="card-subtitle mb-2 pb-3 text-muted">Total Quantity Purchased</h6>
        <?php
          // Execute the SQL query to calculate the total quantity purchased
          $query = "SELECT SUM(quantity) AS total_quantity_purchased FROM order_details";
          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $totalQuantityPurchased = $row['total_quantity_purchased'];
            echo '<h5 class="card-title">' . $totalQuantityPurchased . '</h5>';
          } else {
            echo '<h5 class="card-title">0</h5>'; // If no records found, display 0
          }
        ?>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card p-2 custom-card" style="background-color: rgba(144, 238, 144, 0.5);">
      <div class="card-body">
        <i class="bi bi-graph-up-arrow float-right"></i>
        <h6 class="card-subtitle mb-2 pb-3 text-muted">Total Sales</h6>
        <?php
          // Execute the SQL query to calculate the total sales
          $query = "SELECT SUM(totalamount) AS total_sales FROM `order`";
          $result = mysqli_query($conn, $query);

          if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $totalSales = $row['total_sales'];
            echo '<h5 class="card-title">$' . $totalSales . '</h5>';
          } else {
            echo '<h5 class="card-title">$0</h5>'; // If no records found, display $0
          }
        ?>
      </div>
    </div>
  </div>
</div>

<!-- end row -->


<div class="row mt-5">
<div class="col-lg-8 col-md-6 col-sm-3">
<table class="table table-condensed text-center table-striped custom-table">
    <thead>
        <tr class="table-success">
            <th>Product</th>
            <th>Name</th>
            <th>Size</th>
            <th>Quantity Sold</th>
            <th>Quantity Available</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if (empty($soldProducts)) {
            echo '<h4>Never Give up!</h4>';
        } else {
            foreach ($soldProducts as $product) {
                $product_name = $product['name'];
                $size_name = $product['Size'];
                $quantity_sold = $product['quantitysold'];
                $quantity_available = $product['quantityavailable'];
                $mainimg_path = $product['mainimg_path'];
        ?>
                <tr>
                    <td><img src="../uploads/mainimg/<?php echo $mainimg_path; ?>" style="max-width:80px; height:70px;"></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $size_name; ?></td>
                    <td><?php echo $quantity_sold; ?></td>
                    <td><?php echo $quantity_available; ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>






    </div>
    <div class="col-md-4">
  <div class="d-flex flex-column">
    <?php
    // Display the sold-out products
    if (!empty($soldOutProducts)) {
      foreach ($soldOutProducts as $product) {
        $product_name = $product['name'];
        $size_name = $product['Size'];
        $color = $product['color'];
        $mainimg_path = $product['mainimg_path'];
        ?>
        <div class="alert alert-warning p-3 d-flex align-items-center" role="alert">
          <div class="mr-3">
            <img src="../uploads/mainimg/<?php echo $mainimg_path; ?>" class="img-fluid" style="max-width:80px; height:70px;" alt="Product Image">
          </div>
          <div>
            <b><?php echo $product_name; ?></b> is SOLD OUT at <b>Size <?php echo $size_name; ?></b>!
          </div>
        </div>
        <?php
      }
    }
    ?>
  </div>
</div>




    </div>




</div>

</body>

</html>
