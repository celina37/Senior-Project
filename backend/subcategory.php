<?php
  include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');

?>
<!DOCTYPE html>
<html>
<head>

<title> Add Subcategory </title>

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
      <th>Subcategory Name</th>

        <th>Category Name</th>
        <th  class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
$sql = "SELECT categories.*, subcategories.subcatname, subcategories.id AS subcat_id
        FROM categories
        JOIN subcategories ON categories.id = subcategories.cat_id
        WHERE categories.gender_id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $subcategory_id = $row['subcat_id'];
    $category_name = $row['categoryname'];
    $subcategory_name = $row['subcatname'];
    ?>
      <form method="get" action="deletesubcat.php">

    <tr>
      
      <td><?php echo $subcategory_name; ?></td>
      <td><?php echo $category_name; ?></td>
      <td style="text-align: center">
        <button type="submit" class="btn btn-link delete-button" name="id" value="<?php echo $subcategory_id; ?>">
          <i style="font-size:25px" class="bi bi-trash-fill"></i>
        </button>
      </td> 
    </tr>
  </form>
    <?php
  }
} else {
  echo "No categories found.";
}
?>

    </tbody>
  </table>
        
      </div>

      <div class="col-md-4">
      <table class="table table-striped">
      <h1 class="text-center" >Male</h1>

<thead>
  <tr>
  <th>Subcategory Name</th>

    <th>Category Name</th>
    <th class="text-center" >Action</th>
  </tr>
</thead>
<tbody>

<?php
// Male categories
$sql = "SELECT categories.*, subcategories.subcatname, subcategories.id AS subcat_id
FROM categories
JOIN subcategories ON categories.id = subcategories.cat_id
WHERE categories.gender_id = 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  foreach ($result as $name) {
    $subcategory_id = $name['subcat_id'];
    $category_name = $name['categoryname'];
    $subcategory_name = $name['subcatname'];
    ?>
      <form method="get" action="deletesubcat.php">

    <tr>
      <td><?php echo $subcategory_name; ?></td>
      <td><?php echo $category_name; ?></td>
      <td style="text-align: center">
        <button type="submit" class="btn btn-link delete-button" name="id" value="<?php echo $subcategory_id; ?>">
          <i style="font-size:25px" class="bi bi-trash-fill"></i>
        </button>
      </td>
    </tr>
  </form>
    <?php
  }
} else {
  echo "No male categories found.";
}
?>




</tbody>
  </table>
    </div>

    <div class="col-md-4">
    <h1 class="text-center" >Add Subcategory</h1>
<form method="post" action="addsubcategory.php" id="genderselectorchangeforcategory">
<div class="container p-5 mt-5" style="background-color:lightgrey">

<div class="form-group text-center">
    <div>
        <label for="gender" style="font-size:17px;">Gender</label>
    </div> 
    
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="female" value="1" required>
        <label class="form-check-label" for="female">Female</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="gender" id="male" value="0">
        <label class="form-check-label" for="male">Male</label>
      </div>
    </div>
    <div class="form-group ">
        <label for="category">Category</label>
        <select id="category" name="category" class="form-control" required>
            <option selected>Choose...</option>
            <?php if (isset($_SESSION['catdisplay'])) {echo $_SESSION['catdisplay'];} else { echo 'Error Message'; } ?>
        </select>
    </div>
    <div class="form-group">
  <label for="name" class="label-name" style="color: black;" >Name:</label>
  <input type="text" id="name" name="name" class="form-control" required>
</div>


<button type="submit" class="btn btn-primary mt-3">Add Subcategory</button>
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
      var confirmation = confirm("Deleting a subcategory will also delete its related products. Are you sure?");
      if (confirmation) {
        // Redirect to the delete script passing the item ID
        window.location.href = 'deletesubcat.php?id=' + itemId;
      }
    });
  });







  const form = document.getElementById('genderselectorchangeforcategory'); //form id genderselectorchangeforcategory
  const categorySelect = form.elements.category;
  const genderRadios = form.elements.gender;

  
  // change category based on gender selection
  genderRadios.forEach(radio => { //loop foreach
    radio.addEventListener('change', () => { //hayde kermel tchuf eza sar fi changes
      const genderValue = radio.value; // bta3ml const variable
      fetch(`getcat.php?gender=${genderValue}`) //we go into the getcat.php for stuff
        .then(response => response.text()) //bteb3t response mtl li fo2
        .then(data => { //callback kermel el previous then respond text to execute li bi albo
          categorySelect.innerHTML = data;
          const categoryId = categorySelect.value;
          fetchSubcategories(categoryId, genderValue); //bteb3t el 2, bass kermel ted8ayar el subcat
        });
    });
  });
</script>
