<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');
include('C:\xampp\htdocs\ISDProject\frontend\header.php');
// include('C:\xampp\htdocs\ISDProject\frontend\getcartdetails.php');
$cart_details = isset($_SESSION['cart_details']) ? $_SESSION['cart_details'] : array(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Cart</title>
  <style>
    /* Modal styles */
    .modal {
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.6);
      display: flex;
      justify-content: center;
      align-items: center;
    }

    /* Modal content styles */
    .modal-content {
      background-color: #fff;
      width: 400px;
      height: 400px;
      border-radius: 5px;
      padding: 20px;
      box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.3);
      position: relative;
    }

    .modal-close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 24px;
      font-weight: bold;
      color: #333;
      border: none;
      background-color: transparent;
      cursor: pointer;
    }

    .go-to-checkout {
      position: absolute;
      left: 50%;
      bottom: 10px;
      transform: translateX(-50%);
    }

    .go-to-checkout.disabled {
      opacity: 0.5;
      cursor: not-allowed;
    }
  </style>
</head>
<body>

<div class="container mt-2 mb-4">
  <div class="row">
    <div class="col-8 bg-white">
      <div class="container-left p-2">
        <div class="card p-2">
          <div class="card-body">
            <?php
              $Total_Price = 0;
              if(isset($_SESSION['cart_details']) && !empty($_SESSION['cart_details'])) {
                foreach($_SESSION['cart_details'] as $index => $cart_item) {
                  $Total_Price += $cart_item['price'] * $cart_item['quantity'];
                  $id = $index;
                  $quantity = $cart_item['quantity']; ?>
            <form id="delete-form-<?php echo $id; ?>" class="delete-form" method="POST" action="DeleteFromLocalCart.php">
              <input type="hidden" name="id" value="<?php echo $id; ?>">
              <button type="submit" class="float-right p-0 m-0 border-0 bg-transparent" style="outline: none;">
                <i class="bi bi-box-arrow-right" data-toggle="tooltip" style="font-size: 1.5rem;" data-placement="top" title="Remove"></i>
              </button>
            </form>
            <div class="row">
              <div class="col-3">
                <img src="../uploads/mainimg/<?php echo $cart_item['mainimg_path']; ?>" alt="<?php echo $cart_item['product_name']; ?>" width="50%">
              </div>
              <div class="col-9">
                <p class="card-text font-weight-bold"><?php echo $cart_item['product_name']; ?></p>
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <td>
                        <label class="color-radio" style="background-color: <?php echo $cart_item['color']; ?>; border-radius: 50%; display: inline-block; width: 20px; height: 20px;"></label>
                      </td>
                      <td>Size: <?php echo $cart_item['size_name']; ?></td>
                      <td>Price: $<?php echo $cart_item['price'] * $cart_item['quantity']; ?></td>
                      <td>Quantity: <?php echo $cart_item['quantity']; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <?php } $_SESSION['Total_Price'] = number_format($Total_Price, 2);} else { echo "Your cart is empty."; $disabled = "disabled";}
            ?>
          </div>
          <form id="clear-cart-form" action="DeleteFromLocalCart.php" method="POST">
            <!-- <button type="submit" id="clear-cart-button">Clear Cart</button> -->
          </form>
        </div>
      </div>
    </div>
    <div class="col-4">
      <div class="container-right">
        <div class="card">
          <div class="card-body">
          <h5 class="card-title">Order</h5>
<p class="card-text font-weight-bold text-right">$<?php echo number_format($Total_Price, 2); ?></p>

<?php
$deliveryCharges = 0.00;

if ($Total_Price > 100.00) {
    echo '<p class="card-text text-right">Delivery Charges: Free</p>';
} elseif ($Total_Price >= 80.00 && $Total_Price < 100.00) {
    $remaining = 100.00 - $Total_Price;
    $deliveryCharges = 5.00;
    echo '<p class="card-text text-muted text-right">Delivery Charges: $5</p>';
    echo '<p class="card-text text-success text-right">$' . number_format($remaining, 2) . ' left for free delivery!</p>';
} else { if($Total_Price>0.00 && $Total_Price<100.00){
    $deliveryCharges = 5.00;
    echo '<p class="card-text text-muted text-right">Delivery charges: $5</p>';
    
  }
}

$totalAmount = $Total_Price + $deliveryCharges;
?>
<hr>
<h5 class="card-title">Total</h5>
<p class="card-text font-weight-bold text-right">$<?php echo number_format($totalAmount, 2); ?></p>

          <?php if (isset($_SESSION['id'])) { $login_order = "address_order.php"; } else { $login_order = "../login_register.php"; } ?>
          <a href="<?php echo $login_order; ?>" class="btn btn-dark m-4 <?php if(isset($disabled)) echo $disabled; ?>" style="width: 150px;">Checkout</a>      </div>
    </div>
  </div>
</div>


<?php
include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>


<!-- Debug -->
<!-- <div>
  <label for="prodSizesIdInput">prodSizesId:</label>
  <input type="text" id="prodSizesIdInput" placeholder="Enter prodSizesId">
</div>
<div>
  <label for="pIDInput">pID:</label>
  <input type="text" id="pIDInput" placeholder="Enter pID">
</div>
<button id="saveDataButton">Save Data</button> -->

<script>
document.addEventListener('DOMContentLoaded', () => {
  var prodSizesIdInput = document.getElementById('prodSizesIdInput');
  var pIDInput = document.getElementById('pIDInput');
  var saveDataButton = document.getElementById('saveDataButton');
  saveDataButton.addEventListener("click", function() {
    var prodSizesId = prodSizesIdInput.value;
    var pID = pIDInput.value;
    
    prodSizesId = prodSizesId.split(",").map(item => item.trim()).join(" | ");
    pID = pID.split(",").map(item => item.trim()).join(" | ");
    var cartDataObj = {
      prodSizesId: prodSizesId,
      pID: pID
    };
    
    var cartDataJson = JSON.stringify(cartDataObj);
    localStorage.setItem('cartData', cartDataJson);
    
    window.location.href = 'cart.php';
  });
});

  window.addEventListener('load', function() {
    localStorage.clear();
  });

  // $(document).ready(function() {
  //   $('#clear-cart-button').click(function() {
  //     $.ajax({
  //       type: 'POST',
  //       url: 'DeleteFromLocalCart.php',
  //       success: function() {
  //         console.log('Cart cleared successfully.');
  //       },
  //       error: function() {
  //         console.log('Error clearing the cart.');
  //       }
  //     });
  //   });

  //   $('.delete-form').submit(function(e) {
  //     e.preventDefault();
  //     var form = $(this);
  //     var id = form.find('input[name="id"]').val();
      
  //     $.ajax({
  //       type: 'POST',
  //       url: 'DeleteFromLocalCart.php',
  //       data: { id: id },
  //       success: function() {
  //         console.log('Item deleted successfully.');
  //         // Perform any additional actions, such as updating the cart display or recalculating the total price
  //         // ...
  //       },
  //       error: function() {
  //         console.log('Error deleting the item.');
  //       }
  //     });
  //   });
  // });
</script>

<!-- // var clearCartButton = document.getElementById('clear-cart-button');
// clearCartButton.addEventListener('click', function() {
//   <?php //unset($_SESSION['cart_details']); ?>
//   alert('Cart cleared!');
// }); -->

</body>
</html>
<script>
// document.addEventListener('DOMContentLoaded', () => {
//   const deleteForms = document.querySelectorAll('.delete-form');
//   const modalContent = document.querySelector('.modal-content');

//   deleteForms.forEach(form => {
//     form.addEventListener('submit', event => {
//       event.preventDefault();
//       const itemId = form.querySelector('[name="id"]').value;
//       localStorage.removeItem('prodSizesId_' + itemId);

//       fetch(`DeleteFromLocalCart.php?id=${itemId}`, {
//         method: 'DELETE'
//       }).then(() => {
//         fetch('GetCartDetails.php')
//           .then(response => response.text())
//           .then(data => {
//             modalContent.innerHTML = data;
//           });
//       });
//     });
//   });
// });


if (!localStorage.getItem('cartDataLoaded')) {
  var cartData = localStorage.getItem('cartData');
  if (cartData) {
    var cartDataObj = JSON.parse(cartData);

    var userId = cartDataObj.userId;
    localStorage.setItem('userId', userId);
    var prodSizesId = cartDataObj.prodSizesId;
    if (prodSizesId) {
      var productId = prodSizesId.split(' | ')[0];
      localStorage.setItem('prodSizesId_' + productId, prodSizesId);
    }

    var pID = cartDataObj.pID;
    if (pID) {
      var productId = pID.split(' | ')[0];
      localStorage.setItem('product_ID' + productId, pID);
    }
    var xhr = new XMLHttpRequest();

    var url = 'getCartDetails.php?user_id=' + userId + '&product_sizes_id=' + prodSizesId;
    xhr.open('GET', url, true);

    // Set the callback function when the request is complete
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = xhr.responseText;
        console.log(response);
      }
    };
    xhr.send();

    localStorage.setItem('cartDataLoaded', 'true');
  }
}

var clearCartButton = document.getElementById('clear-cart-button');

clearCartButton.addEventListener('click', function() {
  localStorage.clear();
  window.location.href = 'cart.php';
});

</script>