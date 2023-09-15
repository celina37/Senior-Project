<?php
   include('C:\xampp\htdocs\ISDProject\frontend\header.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>

</head>
<style>.address-radio {
  display: none; /* Hide the radio button input */
}

.address-label {
  display: inline-block;
  padding: 8px;
  margin-top: 20px;
  background-color: #f0f0f0;
  border-radius: 1px;
  font-style: italic;
  line-height: 1.5;
}

.address-radio:checked + .address-label {
  border: 1px solid black;
}

.address-label:hover {
  background-color: #e0e0e0;
}

</style>
<div class="container mt-2 mb-4">
  <div class="row">
    <div class="col-8 bg-white"> <!-- Start of left container taking up 60% of the space -->
      <div class="container-left p-2">
        <h4 class="text-center mb-5">Add Address</h4>
      <form method="post" action="insertaddress.php">
        <div class="form-group row">
          <div class="col mb-3">
            <label for="city">City:</label>
            <input type="text" class="form-control italic-muted-placeholder" id="city" name="city" placeholder="ex  Bteghrine-Mount Lebanon" required>
          </div>
          <div class="col mb-3">
            <label for="street">Street:</label>
            <input type="text" class="form-control italic-muted-placeholder" id="street" name="street" placeholder="ex  street number 4" required>
          </div>
        </div>

        <div class="form-group row">
          <div class="col mb-3">
            <label for="building">Building:</label>
            <input type="text" class="form-control italic-muted-placeholder" id="building"  name="building" placeholder="ex  building no:23" required>
          </div>
          <div class="col mb-3">
            <label for="floor">Floor:</label>
            <input type="text" class="form-control italic-muted-placeholder" id="floor" name="floor" placeholder="ex  2nd Floor" required>
          </div>
        </div>
        <div class="d-flex justify-content-center align-items-center m-4">
  <button class="btn btn-dark" style="width: 200px;">Add Address</button>
</form>
  
</div>

      </div> <!-- End of container-left -->
    </div> <!-- End of left container -->
    <div class="col-4">
  <div class="container-right">
    <div class="card">
      <div class="card-body">
        <?php
        $sql = "SELECT * FROM address WHERE user_id = '$id'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
          // Fetch the contact number from the users table
          $userSql = "SELECT phone FROM users WHERE id = '$id'";
          $userResult = mysqli_query($conn, $userSql);
          $userRow = mysqli_fetch_assoc($userResult);
          $contactNumber = $userRow['phone'];
        ?>
          <p><b>Contact Number: <?= $contactNumber ?></b></p>
          <a href="editprofile.php" class="d-flex justify-content-center">Change it?</a>
          <hr>
          <h6>Please Select An Address</h6>

          <?php $i = 1; ?>
          <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <?php
            $address = $row['city'] . ', ' . $row['street'] . ', ' . $row['building'] . ', ' . $row['floor'];
            $radioId = "address-radio" . $i;
            ?>

            <input type="radio" class="address-radio" name="address-radio" id="<?= $radioId ?>">
            <label class="address-label" for="<?= $radioId ?>"><?= $address ?></label>

            <?php $i++; ?>
          <?php endwhile; ?>

          <div class="d-flex justify-content-center align-items-center m-4">
            <button class="btn btn-dark" style="width: 200px;" onclick="validateAddressSelection()">Make Order</button>
          </div>

          <script>
            function validateAddressSelection() {
              const selectedAddresses = document.querySelectorAll('input[name="address-radio"]:checked');
              if (selectedAddresses.length === 0) {
                alert("Please select an address before placing the order.");
                return false;
              }
              if (selectedAddresses.length > 1) {
                alert("Please select only one address.");
                return false;
              }
              window.location.href = "add_to_cart.php";
              return true;
            }
          </script>
        <?php } else { ?>
          <h6>Please Add An Address</h6>
          <p class="text-muted text-center mt-5 mb-5" style="font-style:italic">No address found</p>
          <div class="d-flex justify-content-center align-items-center m-4">
            <button class="btn btn-dark" style="width: 200px;" disabled>Make Order</button>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</div>



  </div> <!-- End of row -->
</div> <!-- End of container -->







</html>

<?php
   include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>
