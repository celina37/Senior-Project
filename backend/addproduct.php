<?php
 include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
<style>
    /* Make radio buttons bigger */
    input[type="radio"] {
        transform: scale(1.5);
        margin-right: 11px;
    }
        /* Add space between radio button and label text */
        .form-check-inline {
        margin-right: 41px;
        margin-top:5px;
    }
    .form-check-input[type="checkbox"] {
  width: 1.2em;
  height: 1.2em;
 
}
table {
  border-collapse: separate;
  border-spacing: 11px;
}
.table td {
  padding: 1.5rem;
}

#color {
  height: 40px;
  
}
   
</style>
    <div class="container">
 <h1 class="text-center"> Add Product</h1>


 <form method="post" action="/ISDProject/backend/insertproduct.php" id="genderselectorchangeforcategory" enctype="multipart/form-data">

<br>
<br>
  <div class="form-row">
    <div class="form-group col-md-4">
        <label for="name">Name (Title)</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>
    <div class="form-group col-md-4 text-center">
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
    <div class="form-group col-md-4">
        <label for="category">Category</label>
        <select id="category" name="category" class="form-control" required>
            <option selected>Choose...</option>
            <?php if (isset($_SESSION['catdisplay'])) {echo $_SESSION['catdisplay'];} else { echo 'Error Message'; } ?>
        </select>
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
        <?php if (isset($_SESSION['subcatdisplay'])) {echo $_SESSION['subcatdisplay'];} else { echo 'Error Message'; } ?>
        </select>
    </div>
    <div class="form-group col-md-4  ml-2">
    <label for="price">Price $</label>
        <input type="number" class="form-control" name="price" id="price" required  min="0.01" step="0.01">
</div>





</div>
   <!-- second row end -->
   <br> <br>
   <hr> 
   <h4 class="text-center"> Pick a Color, and specify each Size and Quantity, and it's Images.</h4> 
   <div id="variations">
    <div class="variation">
   <div class="form-row">
   <div class="form-group col-md-2 mr-2">
    <label for="color">Color</label>
        <input type="color" class="form-control" name="color" id="color" required>
</div>


<div class="form-group col-md-4 justify-content-center  ml-5">
    <label for="mainimg">Main Image</label>
    <input type="file" class="form-control-file" name="mainimg" id="mainimg" accept="image/*" onchange="displayImage(event)" required>
    <br>
</div>
    
<div class="form-group col-md-4 justify-content-center">
    <label for="backimg">Back Image</label>
    <input type="file" class="form-control-file" name="backimg" id="backimg" accept="image/*" onchange="displayImage(event)" required>
    <br>
</div>

</div>


<div class="row">
<div class="form-group col-md-2">
    <label for="subcategory">Size and Quantity</label>
    <table>
        <tr>
            <td>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sizes[0]" value="1" id="xsCheckbox">
                    <label class="form-check-label" for="xsCheckbox">
                      XS
                    </label>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" name="quantity[0]" id="xsQuantity" min="1" disabled>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sizes[1]" value="2" id="sCheckbox">
                    <label class="form-check-label" for="sCheckbox">
                      S
                    </label>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" name="quantity[1]" id="sQuantity" min="1" disabled>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sizes[2]" value="3" id="mCheckbox">
                    <label class="form-check-label" for="mCheckbox">
                      M
                    </label>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" name="quantity[2]" id="mQuantity" min="1" disabled>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sizes[3]" value="4" id="lCheckbox">
                    <label class="form-check-label" for="lCheckbox">
                      L
                    </label>
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="number" class="form-control" name="quantity[3]" id="lQuantity" min="1" disabled>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sizes[4]" value="5" id="xlCheckbox">
                    <label class="form-check-label" for="xlCheckbox">
                      XL
                    </label>
              </div>
          </td>
          <td>
            <div class="form-group">
              <input type="number" class="form-control" name="quantity[4]" id="xlQuantity" min="1" disabled>
            </div>
          </td>
        </tr>
      </table>

</div>


<div class="col-md-4 ml-5">
  <img id="mainimgImage" style="display:none;" width="250" height="350"/>
</div>

<div class="col-md-4">
  <img id="backimgImage" style="display:none;" width="250" height="350"/>
</div>

</div>

<div class="row">
    <label for="multi">Description Images Choose File(s)</label>
    <input type="file" class="form-control-file" id="multi" name="multi[]" multiple onchange="displayImages(event)">
    <div class="d-flex flex-wrap" id="multiImageContainer" style="display:none;"></div>
</div>

</div>

<div class="row mt-5 d-flex justify-content-center">
  <div class="col-md-3">
    <button type="submit" id="upload-button"  class="btn btn-primary btn-block">Upload This Product</button>
  </div>
  <!-- <div class="col-md-3">
  <button type="submit" id="add-color-button" class="btn btn-warning btn-block" disabled>Add New Colors For This Product</button>
  </div> -->
  <!-- <div class="col-md-3">
    <button type="submit" id="insertnew-button" class="btn btn-success btn-block">Add New Product</button>
  </div> -->
</div>

</form>
</container>

</body>

</html>
<script>

 $(function() {
  $('form').submit(function(event) {
    // Check if at least one checkbox is checked
    var atLeastOneChecked = false;
    $('input[type=checkbox]').each(function() {
      if ($(this).is(':checked')) {
        atLeastOneChecked = true;
        // Check if the quantity input field is also filled in
        var quantityInput = $(this).closest('tr').find('input[type=number]');
        if (quantityInput.val() === '') {
          event.preventDefault();
          alert('Please specify a quantity for the selected size option');
        }
      }
    });
    if (!atLeastOneChecked) {
      event.preventDefault();
      alert('Please select at least one size option');
    }
  });
});

function displayImage(event) {
  console.log("displayImage() called");
  var selectedFiles = event.target.files;
  var inputId = event.target.id;
  var inputName = event.target.name;
  var container = document.getElementById(inputId + "Image");
  if (selectedFiles.length === 1) {
    // Display main or back image
    var selectedFile = selectedFiles[0];
    var imageElement = document.getElementById(inputId + "Image");
    var reader = new FileReader();
    reader.onload = function() {
      imageElement.src = reader.result;
      imageElement.style.display = "block";
    }
    reader.readAsDataURL(selectedFile);
  } else {
    // Display multiple images
    container.style.display = "flex";
    container.innerHTML = ""; // clear previous images
    for (var i = 0; i < selectedFiles.length; i++) {
      var reader = new FileReader();
      var img = document.createElement("img");
      img.width = 250;
      img.height = 350;
      reader.onload = (function(image) {
        return function(e) {
          image.src = e.target.result;
        }
      })(img);
      reader.readAsDataURL(selectedFiles[i]);
      container.appendChild(img);
    }
  }
}


function displaySelectedImage(event, imgId) {
  var input = event.target;
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var img = document.getElementById(imgId);
      img.src = e.target.result;
      img.style.display = "block";
    }
    reader.readAsDataURL(input.files[0]);
  }
}



function displayImages(event) {
  console.log("displayImages() called");
  var files = event.target.files;
  var container = document.getElementById("multiImageContainer");
  container.style.display = "flex";
  container.style.flexWrap = "wrap";
  container.innerHTML = "";
  for (var i = 0; i < files.length; i++) {
    var file = files[i];
    var reader = new FileReader();
    reader.onload = (function(theFile, index) {
      return function(event) {
        var img = document.createElement("img");
        img.src = event.target.result;
        img.style.width = "200px";
        img.style.height = "200px";
        img.style.margin = "10px";
        container.appendChild(img);

     

        
      };
    })(file, i);
    reader.readAsDataURL(file);
  }
  document.getElementById("multi").files = files;
}




    // AJAX dawa 8asil
  const form = document.getElementById('genderselectorchangeforcategory'); //form id genderselectorchangeforcategory
  const categorySelect = form.elements.category;
  const subcategorySelect = form.elements.subcategory;
  const genderRadios = form.elements.gender;

  // to change subcat from cat selected
  const fetchSubcategories = (categoryId, genderValue) => { //function name that accepts 2 parameters
    if (categoryId !== 'Choose...') { //eza manna Choose... option
      fetch(`addsubcatphp.php?category=${categoryId}&gender=${genderValue}`) //mneb3at 3a addsubcatphp.php el values
        .then(response => response.text()) //bteb3at response  
        .then(data => {
          subcategorySelect.innerHTML = data; //mneb3t el value hek, it's like an update ya3ne
        })
    }
  };

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

  // change subcat based on category selection
  categorySelect.addEventListener('change', () => {
    const categoryId = categorySelect.value;
    const genderValue = form.querySelector('input[name="gender"]:checked').value;
    fetchSubcategories(categoryId, genderValue);
  });

//Checkbox input enable/disable using jQuery (jQuery JavaScript Library)

$(document).on("change", ".form-check-input", function() {
  var inputField = $(this).closest("tr").find("input[type='number']");
  if ($(this).is(":checked")) {
    inputField.prop("disabled", false);
  } else {
    inputField.prop("disabled", true);
  }
});



// $(function() {
//   // Disable the "Add New Colors" button by default
//   $('#add-color-button').prop('disabled', true);
  
//   // Add event listener to the form submit event
//   $('#genderselectorchangeforcategory').submit(function(event) {
//     // Enable the "Add New Colors" button when the form is submitted
//     $('#add-color-button').prop('disabled', false);
//   });
// });


</script>