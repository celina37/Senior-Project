<?php
   include('C:\xampp\htdocs\ISDProject\frontend\header.php');
   
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>

</head>

<body>
<style>
  #my-row .col-md-4 {
    order: -1; /* move the column to the beginning of the row */
  }

  #my-row .col-md-2 {
    order: 1; /* move the column to the end of the row */
  }

  .product-details {
    position: relative;
    height: 100%;
    margin-top: 0;
    margin-bottom: 0;
  }

  .thumbnails {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 10px;
    margin-right: 20px;
    margin-left:100px;

  }

  .thumbnails img,.color-images img {
    width: 50px;
    height: 70px;
    margin-bottom: 10px;
    margin-left:10px;

    border: 1px solid #ccc;
    cursor: pointer;
  }

  .thumbnails img:hover {
    border-color: #000;
  }

  .thumbnails img.active {
    border-color: #000;
  }

  @media (max-width: 767px) {
    .row {
      flex-direction: column;
      align-items: center;
    }
    
    .col-md-2 {
      width: 100%;
    }
    
    .col-md-4 {
      width: 100%;
      max-width: 80%; 
    }
    
    .thumbnails {
      flex-direction: row;
      justify-content: center;
      margin-top: 0;
      margin-right: 0;
    }
    
    .thumbnails img, .color-images img {
      width: 50px;
      height: 70px;
      margin-left:10px;
      margin-bottom: 0;
    }
  }


  .details .product-brand{
      text-transform: capitalize;
      font-size:15px;
  }

  .product-price{
      font-weight: 700;
      font-size: 30px;
    color:orange;
  }

  .product-actual-price{
      font-size: 30px;
      opacity: 0.5;
      text-decoration: line-through;
      margin: 0 20px;
      font-weight: 300;
  }

  .product-discount{
      color: #ff7d7d;
      font-size: 20px;
  }

  .product-sub-heading{
      font-size: 15px;

      font-weight: bold;
  }

  input[type="radio"] {
          display: none;
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

  /* to remove the outline on hover */
  label.size-radio-btn:hover:not(.disabled),
  input[type="radio"]:not(:checked) + label.size-radio-btn:hover:not(.disabled) {
      border-color: #222;
  }

  .size-radio-btn.disabled {
      cursor: not-allowed;
      color: gray;
      opacity: 0.5; /* Add opacity for fade effect */
      transition: opacity 0.3s ease; /* Add transition for smooth fading */
  }


  .image-slider {
    position: relative;
    max-width: 700px;
    margin: auto;
  }

  .slider-buttons {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    z-index: 1;
  }

  #prev-btn,
  #next-btn {
    padding: 5px 10px;
    margin:10px;
    border: none;
    background-color: white;
    cursor: pointer;
    border-radius: 20px;
  }

  #prev-btn i,
  #next-btn i {
      color: black;
  }

  .image-slider img {
    display: block;
    max-width: 100%;
    height: auto;
  }
  .cart-btn {
    background-color: black;
    color: white;
    font-family: 'Your Special Font', sans-serif;
    font-size: 16px;
    padding: 10px 20px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    text-transform: uppercase;
  width:300px;
  font-weight:bold;
  }

  .cart-btn:hover {
    background-color: #333;
  }

  /* Color options styles */
  .colourSelect-options {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
  }

  .colourSelect-options label {
    border: 1px solid #ddd;
    padding: 10px 15px;
    font-size: 16px;
    margin-right: 10px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
  }

  .colourSelect-options label:hover {
    background-color: #ddd;
  }

  .colourSelect-options input[type="radio"] {
    display: none;
  }

  .colourSelect-options input[type="radio"]:checked + label {
    background-color: #ddd;
  }
</style>


<?php
$product_infos = isset($_SESSION['product_infos']) ? $_SESSION['product_infos'] : array();
$size_options = isset($_SESSION['size_options']) ? $_SESSION['size_options'] : array();
$available_sizes = isset($_SESSION['available_sizes']) ? $_SESSION['available_sizes'] : array();
$colors = isset($_SESSION['colors']) ? $_SESSION['colors'] : array();
$colorID = isset($_GET['color']) ? $_GET['color'] : '';
// include('getDetails.php');
?>

<hr class="mr-5 ml-5" style="border:1px solid darkgray;">
<div class="row mt-3 mb-3">
    <div class="col-md-8">
        <!-- Images -->
        <div class="row">
            <div class="col-md-2">
                <div class="thumbnails">
                    <!-- Main -->
                    <img src="../uploads/mainimg/<?php echo $product_infos[0]['mainimg']; ?>" alt="Main Image" active>
                    <img src="../uploads/backimg/<?php echo $product_infos[0]['backimg']; ?>" alt="Back Image">
                    <!-- MultiImg -->
                    <?php
                    if (is_array($product_infos[0]['multiimg_paths'])) {
                        foreach ($product_infos[0]['multiimg_paths'] as $multiimage) {
                            echo '<img src="../uploads/descimg/' . $multiimage . '" alt="Desc Image">';
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-6">
                <section class="product-details">
                    <div class="image-slider">
                        <!-- this will display image -->
                        <img id="main-image" src="" alt="">
                        <div class="slider-buttons">
                            <button id="prev-btn"><i class="bi bi-chevron-left"></i></button>
                            <button id="next-btn"><i class="bi bi-chevron-right"></i></button>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <section class="mt-4 mr-4">
            <!-- Details -->
            <div class="details">
                <h2 class="product-brand mb-3"><?php echo $product_infos[0]['product_name']; ?></h2>
                <span class="product-price mb-3"><?php echo $product_infos[0]['price']; ?>$ </span>
           
                <hr class="mb-2" style="border:1px dotted lightgray;">

                <!-- Color -->
                <p class="product-sub-heading mt-5">Color:</p>
                <div class="color-images">
                    <form action="getDetails.php" method="GET">
                        <?php foreach ($colors as $color) { ?>
                            <input type="radio" id="color-<?php echo $color['color']; ?>" name="color" value="<?php echo $color['color_id']; ?>" onchange="this.form.submit()">
                            <label for="color-<?php echo $color['color']; ?>">
                                <img src="../uploads/mainimg/<?php echo $color['mainimg']; ?>" alt="Main Image">
                            </label>
                        <?php } ?>
                        <input type="hidden" name="pID" value="<?php echo $product_infos[0]['pID']; ?>">
                    </form>
                </div>
                
                <!-- Sizes -->
                <p class="product-sub-heading mt-5">Size:</p>
                <?php foreach ($size_options as $option) { ?>
    <?php
 $disabled = !in_array($option['name'], $available_sizes); 
      $isChecked = isset($_GET['size']) && $_GET['size'] == $option['id'];
    ?>
    <input type="radio" id="size-radio-<?php echo $option['id']; ?>" name="size" value="<?php echo $option['id']; ?>" <?php if ($disabled) echo 'disabled'; ?> <?php if ($isChecked) echo 'checked'; ?> onclick="document.getElementById('size').value = this.value;">
    <label class="size-radio-btn <?php if ($disabled) echo 'disabled'; ?>" for="size-radio-<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
    

    <?php } ?>
                <!-- Send values to add cart -->
                <form class="cart-form" method="post" action="localstorage.php">
                  <!-- <input type="" name="user_id" value="<?php //echo $product_infos[0]['user_id']; ?>"><br> -->
                  <input type="hidden" name="prod_id" value="<?php echo $product_infos[0]['pID']; ?>"><br>
                  <input type="hidden" name="color_id" value="<?php echo $colorID ?>"><br>
                  <input type="hidden" name="size" id="size" value="<?php echo isset($_GET['size']) ? $_GET['size'] : ''; ?>">
                  <button type="submit" class="btn cart-btn" name="add_to_cart">Add to Cart</button>
                </form>
              </div>
            </section>
          </div>
        </div>
        <hr class="mr-4 ml-4" style="border:1px solid darkgray;">
        
<!-- Keep this for Image displayification -->
<input type="hidden" name="image_id" id="colorId">


</body>
</html>

<?php
   include('C:\xampp\htdocs\ISDProject\frontend\footer.php');
?>
<script>

let color_id = localStorage.getItem('color_id');
document.getElementById('colorId').value = color_id;

const productImages = document.querySelectorAll(".thumbnails img"); // selecting all image thumbs
const productImageSlide = document.querySelector(".image-slider img"); // selecting image slider element

let activeImageSlide = 0; // default slider image

productImages.forEach((item, i) => { // looping through each image thumb
  item.addEventListener('click', () => { // adding click event to each image thumbnail
    productImages[activeImageSlide].classList.remove('active'); // removing active class from current image thumb
    item.classList.add('active'); // adding active class to the current or clicked image thumb
    productImageSlide.src = item.src; // updating the main image with the clicked image thumb
    activeImageSlide = i; // updating the image slider variable to track current thumb
  })
    
  item.addEventListener('mouseover', () => { // adding mouseover event to each image thumbnail
    productImages[activeImageSlide].classList.remove('active'); // removing active class from current image thumb
    item.classList.add('active'); // adding active class to the current or hovered image thumb
        productImageSlide.src = item.src; // updating the main image with the hovered image thumb
        activeImageSlide = i; // updating the image slider variable to track current thumb
    })
})

const images = document.querySelectorAll(".thumbnails img");
const mainImage = document.querySelector("#main-image");
const prevButton = document.querySelector("#prev-btn");
const nextButton = document.querySelector("#next-btn");
let currentImageIndex = 0;

// Show the first image
mainImage.src = images[currentImageIndex].src;

// Handle prev button click
prevButton.addEventListener("click", () => {
  currentImageIndex--;
  if (currentImageIndex < 0) {
    currentImageIndex = images.length - 1;
  }
  mainImage.src = images[currentImageIndex].src;
});

// Handle next button click
nextButton.addEventListener("click", () => {
  currentImageIndex++;
  if (currentImageIndex >= images.length) {
    currentImageIndex = 0;
  }
  mainImage.src = images[currentImageIndex].src;
});


</script>