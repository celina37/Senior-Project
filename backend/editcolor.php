<?php
include('C:\xampp\htdocs\ISDProject\backend\admin_navbar.php');
include('getProductToEdit.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Color</title>
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

<?php
if (isset($_SESSION['color_info'])) {
    $color_info = $_SESSION['color_info'];
    
    foreach ($color_info as $color) {
        foreach ($color['sizes'] as $size => $quantity) {
            if (!isset($sizes[$size])) {
                $sizes[$size] = $quantity;
            }
        }
    }
}

$size_options = array();
$sql = "SELECT DISTINCT size.id, size.name
        FROM size
        INNER JOIN product_sizes ON size.id = product_sizes.size_id
        INNER JOIN product_color ON product_sizes.color_id = product_color.id
        ORDER BY size.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $size_options[] = array(
            'id' => $row['id'],
            'name' => $row['name']
        );
    }
} else {
    $size_options = NULL;
}   
 
?>

<div class="container align-center">
  <h1 class="text-center">Edit Color: <?php echo $color['colorId']." - pID: ".$color['pID']; ?></h1>

<form method="POST" action="updatecolor.php?product_id=<?php echo $color['pID']?>&color=<?php echo $color['colorId'];?>" id="genderselectorchangeforcategory" enctype="multipart/form-data">
<!-- second row end -->
<br> <br>
<hr>
<h4 class="text-center"> Pick a Color, and specify each Size and Quantity, and its Images.</h4>
    <div id="variations">
        <div class="variation">
            <div class="form-row">
                <div class="form-group col-md-2 mr-2">
                    <label for="color">Color</label>
                    <input type="color" class="form-control" name="color" id="<?php echo $color['Color']; ?>" required style="background-color: <?php echo $color['Color']; ?>" <?php echo $color['Color']; ?> disabled>
                </div>
                <div class="form-group col-md-4 justify-content-center ml-5">
                    <label for="mainimg">Main Image</label>
                    <input type="file" value="../uploads/mainimg/<?php echo $color['mainimg_path']; ?>" class="form-control-file" name="mainimg" id="mainimg" accept="image/*" onchange="displaySelectedImage(event, 'mainimgImage')">
                    <?php if (!empty($color['mainimg_path'])) { ?>
                        <img id="mainimgImage" src="../uploads/mainimg/<?php echo $color['mainimg_path']; ?>" alt="Main Image" style="max-width: 200px; max-height: 200px;">
                    <?php } ?>
                    <br>
                </div>
                <div class="form-group col-md-4 justify-content-center">
                    <label for="backimg">Back Image</label>
                    <input type="file" value="../uploads/backimg/<?php echo $color['backimage_path']; ?>" class="form-control-file" name="backimg" id="backimg" accept="image/*" onchange="displaySelectedImage(event, 'backimgImage')">
                    <?php if (!empty($color['backimage_path'])) { ?>
                        <img id="backimgImage" src="../uploads/backimg/<?php echo $color['backimage_path']; ?>" alt="Back Image" style="max-width: 200px; max-height: 200px;">
                    <?php } ?>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-2">
                    <label for="subcategory">Size and Quantity</label>
                    <!-- This is MUCH better -->
                    <table>
                    <?php foreach ($size_options as $index => $size) { ?>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="hidden" name="sizes[<?php echo $index; ?>]" value="<?php echo $size['name']; ?>">
                                    <input class="form-check-input" type="checkbox" name="checkboxes[<?php echo $index; ?>]" value="<?php echo $size['name']; ?>" id="<?php echo $size['name']; ?>Checkbox" <?php echo isset($sizes[$size['name']]) ? 'checked' : ''; ?>>
                                    <label class="form-check-label" for="<?php echo $size['name']; ?>Checkbox">
                                        <?php echo $size['name']; ?>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="number" class="form-control" name="quantity[<?php echo $index; ?>]" id="<?php echo $size['name']; ?>Quantity" min="0" value="<?php echo isset($sizes[$size['name']]) ? $sizes[$size['name']] : '0'; ?>" <?php echo isset($sizes[$size['name']]) ? '' : 'disabled'; ?>>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </table>
                </div>
                <div class="col-md-4 ml-5">
                    <img id="mainimgImage" style="display:none;" width="250" height="350" />
                </div>
                <div class="col-md-4">
                    <img id="backimgImage" style="display:none;" width="250" height="350" />
                </div>
            </div>
<div class="row">
  <label for="multi">Description Images Choose File(s)</label>
  <input type="file" class="form-control-file" id="multi" name="multi[]" multiple onchange="displayImages(event)">
  <div class="d-flex flex-wrap" id="multiImageContainer" style="display:none;">
  <?php
  foreach ($color['MultiImagePath'] as $multiImagePath) {
    $multiImages = explode(',', $multiImagePath);
    foreach ($multiImages as $image) { ?>
      <div class="image-container">
        <img src="../uploads/descimg/<?php echo $image; ?>" alt="Description Image" class="img-thumbnail mx-2 my-2" style="max-width: 200px; max-height: 200px;">
        <div class="delete-button" onclick="deleteImage(this)">&#10006;</div>
        <input type="hidden" name="multi[]" value="<?php echo $image; ?>">
      </div>
  <?php  }
  }
  ?>


  </div>
</div>

<div style="text-align: right;">
                <button type="submit" class="btn btn-primary">Update This Color</button>
            </div>
        </div>
    </div>
</form>
  </div>

</body>

</html>
<script>
  function deleteImage(deleteButton) {
    var imageContainer = deleteButton.parentNode;
    imageContainer.parentNode.removeChild(imageContainer);
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

//Checkbox input enable/disable using jQuery (jQuery JavaScript Library)

// $(document).on("change", ".form-check-input", function() {
//   var inputField = $(this).closest("tr").find("input[type='number']");
//   if ($(this).is(":checked")) {
//     inputField.prop("disabled", false);
//   } else {
//     inputField.prop("disabled", true);
//   }
// });

// Nullification
const checkboxes = document.querySelectorAll('.form-check-input');
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const sizeName = this.value;
        const quantityInput = document.querySelector(`#${sizeName}Quantity`);
        if (!this.checked) {
            quantityInput.value = '';
        }
        quantityInput.disabled = !this.checked;
    });
});
</script>