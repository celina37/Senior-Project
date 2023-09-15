<?php
 include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');

?>
<!DOCTYPE html>
<html>
<head>

<title> Add Category </title>
  </head>
  <body>
  <style>
  .form-check-input[type="radio"] {
    width: 15px;
    height: 15px;
  }
</style>
  <div class="container-fluid p-5">
    <div class="row">
      <div class="col-md-4">
      <table class="table table-striped">

      <h1 class="text-center" >Female</h1>

    <thead>
      <tr>
        <th>Category Name</th>
        <th  class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php


// Retrieve the categories with gender_id = 1 (Female)
$sql = "SELECT * FROM categories WHERE gender_id = 1";
$result = $conn->query($sql);
?>
 

 <?php foreach ($result as $name) : ?>
  <form method="get" action="deletecat.php">
    <tr>
      <td><?php echo $name['categoryname']; ?></td>
      <td style="text-align: center">
      <button type="submit" class="btn btn-link delete-button" name="id" value="<?php echo $name['id']; ?>">
  <i style="font-size:25px" class="bi bi-trash-fill"></i>
</button>

      </td>
    </tr>
  </form>
<?php endforeach; ?>
    </tbody>
  </table>
        
      </div>

      <div class="col-md-4">
      <table class="table table-striped">
      <h1 class="text-center" >Male</h1>

<thead>
  <tr>
    <th>Category Name</th>
    <th class="text-center" >Action</th>
  </tr>
</thead>
<tbody>
<?php


$sql = "SELECT * FROM categories WHERE gender_id = 0";
$result = $conn->query($sql);
?>

<?php foreach ($result as $name) : ?>
  <form method="get" action="deletecat.php">
    <tr>
      <td><?php echo $name['categoryname']; ?></td>
      <td style="text-align: center">
      <button type="submit" class="btn btn-link delete-button" name="id" value="<?php echo $name['id']; ?>">
  <i style="font-size:25px" class="bi bi-trash-fill"></i>
</button>

      </td>
    </tr>
  </form>
<?php endforeach; ?>

</tbody>
  </table>
    </div>

    <div class="col-md-4">
    <h1 class="text-center" >Add Category</h1>
<form method="post" action="addcategory.php">
<div class="container p-5 mt-5" style="background-color:lightgrey">
    <div class="form-group">
  <label for="name" class="label-name" style="color: black;" >Name:</label>
  <input type="text" id="name" name="name" class="form-control" required>
</div><div class="form-group-inline" id="gender-group">
  <label class="form-check-inline" style="color: black;">
    <input class="form-check-input" type="radio" name="gender" value="0" required> Male
  </label>

  <label class="form-check-inline" style="color: black;">
    <input class="form-check-input" type="radio" name="gender" value="1"> Female
  </label>
</div>

<button type="submit" class="btn btn-primary mt-3">Add Category</button>
</form>
</div>
</div>

</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.delete-button').click(function() {
      var itemId = $(this).data('item-id');
      var confirmation = confirm("Deleting a category will also delete its subcategories and products. Are you sure?");
      if (confirmation) {
        // Redirect to the delete script passing the item ID
        window.location.href = 'deletecat.php?id=' + itemId;
      }
    });
  });
</script>

