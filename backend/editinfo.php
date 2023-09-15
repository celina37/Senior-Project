<?php

include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');


include('getProductToEdit.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin - Edit Product</title>
</head>
<body>
<br>
<br>
<div class="container">
<form method="post" action="/ISDProject/backend/updateprodinfo.php" enctype="multipart/form-data">

<h4 class="text-center mb-5"> Edit Product Information </h4>
  <div class="form-row">
    <div class="form-group col-md-4">
        <label for="name">Name (Title)</label> | <label for="name">Product ID: <?php if (isset($_SESSION['product_id'])) {echo $_SESSION['product_id'];} ?></label> <!-- for debug -->
        <input type="text" class="form-control" name="name" id="name" required value="<?php if (isset($_SESSION['product_name'])) {echo $_SESSION['product_name'];} ?>">
    </div>
    <div class="form-group col-md-4 text-center">
    <div>
        <label for="gender" style="font-size:17px;">Gender</label>
    </div> 
    
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="gender" id="female" value="1" <?php if($_SESSION['gender_id'] == 1) echo 'checked'; ?> required>
      <label class="form-check-label" for="female">Female</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="gender" id="male" value="0" <?php if($_SESSION['gender_id'] == 0) echo 'checked'; ?>>
      <label class="form-check-label" for="male">Male</label>
    </div>
    </div>
    <div class="form-group col-md-4">
        <label for="category">Category</label>
        <select id="category" name="category" class="form-control" required>
            <option selected>Choose...</option>
            <?php if (isset($_SESSION['category_id'])) {echo '<option value="'.$_SESSION['category_id'].'" selected>'.$_SESSION['category_name'].'</option>';} ?>
        </select>
    </div>
</div>

</div>
<br>
<br>
<!-- second row -->
<div class="form-row  justify-content-center">
    <div class="form-group col-md-4 mr-2">
        <label for="subcategory">Sub-Category</label>
        <select id="subcategory" name="subcategory" class="form-control" required>
            <option selected>Choose...</option>
            <?php if (isset($_SESSION['subcat_name'])) {echo '<option value="'.$_SESSION['subcat_id'].'" selected>'.$_SESSION['subcat_name'].'</option>';} ?>
        </select>
    </div>
    <div class="form-group col-md-4  ml-2">
        <label for="price">Price $</label>
        <input type="number" class="form-control" name="price" id="price" required  min="1" value="<?php if (isset($_SESSION['product_price'])) {echo $_SESSION['product_price'];} ?>">
    </div>
</div>

<div class="row mt-5 d-flex justify-content-center">
  <div class="col-md-3">
    <button type="submit" id="update"  class="btn btn-primary btn-block">Update</button>
  </div>
</div>


</div>
</body>
</html>

<script>
const categorySelect = document.getElementById('category');
const subcategorySelect = document.getElementById('subcategory');
const genderRadios = document.querySelectorAll('input[name="gender"]');

const fetchSubcategories = (categoryId, genderValue) => { 
  if (categoryId !== 'Choose...' && genderValue !== '') { 
    fetch(`addsubcatphp.php?category=${categoryId}&gender=${genderValue}`) 
      .then(response => response.text())  
      .then(data => {
        subcategorySelect.innerHTML = data; 
      })
  } else {
    subcategorySelect.innerHTML = '<option selected>Choose...</option>';
  }
};

const fetchCategories = (genderValue) => { 
  fetch(`getcat.php?gender=${genderValue}`) 
    .then(response => response.text()) 
    .then(data => { 
      categorySelect.innerHTML = data;
      const categoryId = categorySelect.value;
      fetchSubcategories(categoryId, genderValue); 
    });
};

genderRadios.forEach(radio => { 
  radio.addEventListener('change', () => { 
    const genderValue = radio.value; 
    fetchCategories(genderValue);
  });
});

categorySelect.addEventListener('change', () => {
  const categoryId = categorySelect.value;
  const genderValue = document.querySelector('input[name="gender"]:checked')?.value || '';
  fetchSubcategories(categoryId, genderValue);
});

genderRadios.forEach(radio => { 
  radio.addEventListener('change', () => { 
    const genderValue = radio.value;
    const categoryId = categorySelect.value;
    fetchSubcategories(categoryId, genderValue);
  });
});
</script>