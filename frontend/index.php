<?php
   include('C:\xampp\htdocs\ISDProject\frontend\header.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>Products</title>

<style>
.product-item {
  width: 15.7rem;
  height: 18.8rem;
  position: relative;
}

.product-item .main-image {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1;
  transition: opacity 0.5s ease;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-item .hover-image {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 2;
  opacity: 0;
  transition: opacity 0.5s ease;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.product-item .add-to-cart-container {
  position: absolute;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 3;
  opacity: 0;
  transition: opacity 0.5s ease;
}

.product-item:hover .main-image {
  opacity: 0;
}

.product-item:hover .hover-image {
  opacity: 1;
}

.product-item:hover .add-to-cart-container {
  opacity: 1;
}

.add-to-cart-btn-modal {
  background-color: #fff;
  color: #000;
  border: none;
  border-radius: 0;
  padding: 8px 16px;
  font-size: 13px;
  font-weight: bold;
  text-transform: uppercase;
  cursor: pointer;
}





label.color-radio {
  min-width: 22px;
  height: 22px;
  float: left;
  margin-right: 8px;
  text-align: center;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  font-size: 13px;
  text-overflow: ellipsis;
  border-radius: 50%;
  transition: all 150ms;
}

label.color-radio:hover,
input[name="color"]:checked + label.color-radio {
  border: 2px solid rgb(92, 118, 141);
}



/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

.details .product-brand {
  text-transform: capitalize;
  font-size: 15px;
}

.product-price {
  font-weight: 700;
  font-size: 30px;
  color: orange;
}

.product-actual-price {
  font-size: 30px;
  opacity: 0.5;
  text-decoration: line-through;
  margin: 0 20px;
  font-weight: 300;
}

.product-discount {
  color: #ff7d7d;
  font-size: 20px;
}

.product-sub-heading {
  font-size: 15px;
  font-weight: bold;
}


/* Sizes */
input[type="radio"] {
  opacity: 0;
  width: 0;
  height: 0;
  position: absolute;
  pointer-events: none;
}

label.size-radio-btn {
  display: inline-block;
  border-radius: 20px;
  border: 2px solid lightgray;
  padding: 6px 10px;
  margin-right: 10px;
  cursor: pointer;
  width: 70px;
  text-transform: uppercase;
  text-align: center;
  font-size: 14px;
}

label.size-radio-btn:hover:not(.disabled) {
  border-color: #444;
}

input[type="radio"]:checked + label.size-radio-btn {
  border-color: black;
}

input[type="radio"]:not(:checked) + label.size-radio-btn {
  color: black;
}

label.size-radio-btn:hover:not(.disabled),
input[type="radio"]:not(:checked) + label.size-radio-btn:hover:not(.disabled) {
  border-color: #222;
}

.size-radio-btn.disabled {
  cursor: not-allowed;
  color: gray;
  opacity: 0.5;
  transition: opacity 0.3s ease;
}

/* Cart */
.cart-btn {
  background-color: black;
  color: white;
  font-family: 'Your Special Font', sans-serif;
  font-size: 14px;
  padding: 8px 15px;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
  text-transform: uppercase;
  width: 300px;
  font-weight: bold;
}

.cart-btn:hover {
  background-color: #333;
}

</style>

</head>
<body>


<!-- Products -->
<div class="container mt-5 mb-5">
  <div class="row">
    <?php
    if (!empty($_SESSION['product_info']) && $num_rows > 0) {
      foreach ($_SESSION['product_info'] as $product) {
        if (isset($product['pID'])) {
          ?>
          <div class="col-3">
            <div class="product-container">
              <section class="product-item">
                <div class="product-image">
                  <!-- get the images foreach -->
                  <a href="../frontend/getDetails.php?pID=<?php echo $product['pID']; ?>&color=" id="chosen-color-">
                    <img class="main-image" src="../uploads/mainimg/<?php echo $product['images'][0]['mainimg_path']; ?>" alt="Main Image" style="width:100%">
                    <img class="hover-image" src="../uploads/backimg/<?php echo $product['images'][0]['backimg_path']; ?>" alt="Back Image">
                    <!-- Get pID to send it to the Modal -->
                  </a>
                  <div class="add-to-cart-container">
                    <button class="add-to-cart-btn-modal" data-pid="<?php echo $product['pID']; ?>" data-colorid="<?php echo $colorId; ?>">Add to Cart</button>
                  </div>
                </div>
              </section>
              <p class="text-muted mt-1" style="font-size:15px; display: block; margin: 0;"><?php echo $product['name']; ?></p>
              <p style="display: block; margin-top: 3px;font-family: Poppins 20px;">$<?php echo $product['price']; ?></p>
              <div class="color-options mt-1">
                <?php $firstColor = true; ?>
                <?php foreach ($product['colors'] as $color) { ?>
                  <?php $colorId = $color['colorId']; ?>
                  <input type="radio" id="color-<?php echo $colorId; ?>" name="color-<?php echo $product['pID']; ?>" value="<?php echo $colorId; ?>" data-mainimg="<?php echo $color['mainimg_path']; ?>" data-backimg="<?php echo $color['backimg_path']; ?>" data-color="<?php echo $colorId; ?>" <?php if ($firstColor) { echo 'checked'; $firstColor = false; } ?> />
                  <label class="color-radio" style="background-color: <?php echo $color['color']; ?>;" for="color-<?php echo $colorId; ?>"></label>
                <?php } ?>
               <span id="chosen-color-" style="visibility: hidden;">
              </div>
            </div>
          </div>
    <?php } } } ?>
  </div>
</div>


<script>
const productContainers = document.querySelectorAll('.product-container');

productContainers.forEach(productContainer => {
  const colorInputs = productContainer.querySelectorAll('input[type="radio"]');
  const chosenColorSpan = productContainer.querySelector('span[id^="chosen-color-"]');
  const mainImage = productContainer.querySelector('.main-image');
  const hoverImage = productContainer.querySelector('.hover-image');
  const chosenColorLink = productContainer.querySelector('a[id^="chosen-color-"]');

  colorInputs.forEach(colorInput => {
    colorInput.addEventListener('change', () => {
      mainImage.src = '../uploads/mainimg/' + colorInput.dataset.mainimg;
      hoverImage.src = '../uploads/backimg/' + colorInput.dataset.backimg;
      chosenColorSpan.textContent = colorInput.dataset.color;

      const chosenColorId = colorInput.id.replace('chosen-color-', '');
      let href = chosenColorLink.getAttribute('href');
      const [baseUrl, existingParams] = href.split('&color=');
      href = `${baseUrl}&color=${chosenColorId}`;

      if (existingParams) {
        href += `&${existingParams}`;
      }
      chosenColorLink.setAttribute('href', href);
    });

    if (colorInput.checked) {
      mainImage.src = '../uploads/mainimg/' + colorInput.dataset.mainimg;
      hoverImage.src = '../uploads/backimg/' + colorInput.dataset.backimg;
      chosenColorSpan.textContent = colorInput.dataset.color;

      const chosenColorId = colorInput.id.replace('chosen-color-', '');
      let href = chosenColorLink.getAttribute('href');
      const [baseUrl, existingParams] = href.split('&color=');
      href = `${baseUrl}&color=${chosenColorId}`;

      if (existingParams) {
        href += `&${existingParams}`;
      }
      chosenColorLink.setAttribute('href', href);
    }
  });
});
</script>





<!-- Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <section class="mt-4 mr-4">
      <div class="details"> <!-- displays the modal -->
      </div>
    </section>
  </div>
</div>




<script>

//modal
// Get the modal
var modal = document.getElementById("myModal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on a button, open the modal and fetch the product details
var addToCartBtns = document.querySelectorAll(".add-to-cart-btn-modal");

// When the user clicks on a button, open the modal and fetch the product details
addToCartBtns.forEach(function(btn) {
  btn.addEventListener("click", function() {
    var pID = this.getAttribute("data-pid");
    var colorInput = document.querySelector('input[name="color-' + pID + '"]:checked');
    var colorID = colorInput ? colorInput.getAttribute("data-color") : null;
    
    if (colorID) {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.querySelector("#myModal .details").innerHTML = this.responseText;
        }
      };

      xhttp.open("GET", "getModalDetails.php?pID=" + pID + "&colorID=" + colorID, true);
      xhttp.send();
      modal.style.display = "block";
      // alert("Colour ID: " + colorID);
      // alert("pID: " + pID);
    } else {
      alert("Please select a color before adding to cart");
    }
  });
});

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
};

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};




//image
const productItems = document.querySelectorAll('.product-item');

productItems.forEach(productItem => {
  const mainImage = productItem.querySelector('.main-image');
  const hoverImage = productItem.querySelector('.hover-image');

  mainImage.addEventListener('mouseover', () => {
    mainImage.style.opacity = '0';
    hoverImage.style.opacity = '1';
  });

  mainImage.addEventListener('mouseout', () => {
    mainImage.style.opacity = '1';
    hoverImage.style.opacity = '0';
  });
});

</script>
</body>
</html><?php
   include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>