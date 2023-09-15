<?php
 include('C:\xampp\htdocs\ISDProject\db_connect.php');
?>


<!DOCTYPE html>
<html>
<head>
<?php
 include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');
?>
    <title>All Products</title>
    <?php 
      include ('getAllProducts.php'); 
    ?>

</head>

<body>
<style>
  .product-info {
    border: 1px solid darkred;
  }

  
input[type="radio"] {
  display: none;
} .center-aligned {
    text-align: center;
  }

  label.color-radio {
    display: inline-block;
    min-width: 22px;
    height: 22px;
    margin-right: 8px;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    font-size: 13px;
    text-overflow: ellipsis;
    border-radius: 50%;
    transition: all 150ms;
  }

  label.color-radio:hover {
    border: 2px solid rgb(92, 118, 141);
  }
  .color-circle {
  width: 20px;
  height: 20px;
  border-radius: 50%;
}

</style>









<div class="table-responsive">
<table class="table table-striped ">
  <thead class="thead-dark">
    <tr>
    <th scope="col">Name</th>
      <th scope="col">Gender</th>
      <th scope="col">Category</th>
      <th scope="col">Subcategory</th>
      <th scope="col">Price</th>
      <th class="center-aligned" scope="col">Color</th>
      <th class="center-aligned" scope="col">Delete Product</th>
    </tr>
  </thead>
  <tbody>


  <form method="get" action="DeleteProduct.php">  <?php foreach ($products as $product) { ?>
    <?php $Prod_ID = $product['Product ID']; ?>

  <tr>
  <th colspan="5" style="text-align: center; border: 1px solid darkred;"><a href="editinfo.php?product_id=<?php echo $product['Product ID']; ?>" style="color: darkred;">Edit Product Information</a></th>
  <th colspan="1" style="text-align: center; border: 1px solid darkred;">View color details
<br> <a href="addcolor.php?product_id=<?php echo $product['Product ID']; ?>" style="color: darkred;"> Add New Color</a>
</th>
  <th colspan="1" style="text-align: center; border: 1px solid darkred;"></th>

  
</tr>
 
    <tr>
          <th><?php echo $product['Product Name']; ?></th>
          <td><?php echo ($product['Gender ID'] == 1) ? 'Female' : 'Male'; ?></td>
          <td><?php echo $product['Category']; ?></td>
        <td><?php echo $product['Sub-category']; ?></td>
        <th>$<?php echo $product['Price']; ?></th>
          <td class="center-aligned">
          <div>
        <?php
        // Retrieve the colors for the specific product
        $sql = "SELECT DISTINCT product_color.color
                FROM products
                LEFT JOIN product_sizes ON products.pID = product_sizes.prod_id
                LEFT JOIN product_color ON product_sizes.color_id = product_color.id
                WHERE products.pID = {$product['Product ID']}";
                
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_assoc($result)) {
          $color = $row['color']; ?>
          <!-- <input type="radio" class="color-options" id="color-<?php //echo $color; ?>" name="color" onclick="openModal('<?php //echo $color; ?>', '<?php //echo $Prod_ID; ?>')" /> -->
          <label class="color-radio" style="background-color: <?php echo $color; ?>;" for="color-<?php echo $color; ?>" onclick="openModal('<?php echo $color; ?>', '<?php echo $product['Product ID'];; ?>')"></label>
        <?php } ?>
        
<!-- Modal Start -->
<div class="modal fade" id="colorModal" tabindex="-1" aria-labelledby="colorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- Modal content goes here from colourView.php -->
    </div>
  </div>
</div>
<!-- Modal End -->

</div>
      </td>
      <td style="text-align: center">
          <button type="submit" class="btn btn-link" name="product_id" value="<?php echo $product['Product ID']; ?>">
          <i style="font-size:25px" class="bi bi-trash-fill"></i> </button>
        
        
        </td>


    </tr>

    <?php } ?>


    
  </tbody>
</table>

<script>
function openModal(color, pID) {
  // alert(pID);
  $('#colorModal').modal('show');
  $.ajax({
    url: 'colourView.php',
    type: 'GET',
    data: { color: color, pID: pID },
    success: function (response) {
      $('#colorModal .modal-content').html(response);
    },
    error: function (xhr, status, error) {
      console.log('Error:', error);
    }
  });
}


</script>
</div>
</body>
</html>

<script>
function deleteProduct(product_id) {
    if(confirm("Delete the whole product?")) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                location.reload();
            }
        };
        xhttp.open("GET", "DeleteProduct.php?product_id=" + product_id, true);
        xhttp.send();
    }
}
</script>