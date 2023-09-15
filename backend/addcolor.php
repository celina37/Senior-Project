<?php

include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');

  include('getProductToEdit.php');

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Color</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function() {
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
  });});

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
</script>
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
 <h1 class="text-center"> Add Color</h1>
 <form method="post" action="/ISDProject/backend/insertcolor.php" id="genderselectorchangeforcategory" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

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
    <input type="file" class="form-control-file" name="mainimg" id="mainimg" accept="image/*" onchange="displaySelectedImage(event, 'mainimgImage')" required>
   <br>
</div>
    
<div class="form-group col-md-4 justify-content-center">
    <label for="backimg">Back Image</label>
    <input type="file" class="form-control-file" name="backimg" id="backimg" accept="image/*" onchange="displaySelectedImage(event, 'backimgImage')" required>
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
    <input type="file" class="form-control-file" id="multi" name="multi[]" multiple onchange="displayImages(event)" required>
    <div class="d-flex flex-wrap" id="multiImageContainer" style="display:none;"></div>
</div>

<div style="text-align: right;">
  <button type="submit" class="btn btn-primary">Add This Color</button>
</div>

</form>
</container>

</body>

</html>
<script>



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



  

//Checkbox input enable/disable using jQuery (jQuery JavaScript Library)

$(document).on("change", ".form-check-input", function() {
  var inputField = $(this).closest("tr").find("input[type='number']");
  if ($(this).is(":checked")) {
    inputField.prop("disabled", false);
  } else {
    inputField.prop("disabled", true);
  }
});



</script>