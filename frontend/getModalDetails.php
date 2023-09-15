<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$pID = isset($_GET['pID']) ? $_GET['pID'] : '';
$colorId = isset($_GET['colorID']) ? $_GET['colorID'] : '';
$sizeId = isset($_GET['sizeId']) ? $_GET['sizeId'] : '';

// echo "Product ID: " . $pID . "<br>";
// echo "Color ID: " . $colorId . "<br>";
// echo "Size ID: " . $sizeId . "<br>";

if (isset($_GET['pID']) && isset($_GET['colorID'])) {
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
    }
    $_SESSION['size_options'] = $size_options;

    $sql = "SELECT products.price AS Price, products.name AS product_name, product_sizes.size_id, size.name AS size_name, product_sizes.quantityavailable,product_sizes.quantity
        FROM products
        INNER JOIN product_color ON products.pID = product_color.product_id
        INNER JOIN product_sizes ON products.pID = product_sizes.prod_id AND product_color.id = product_sizes.color_id
        INNER JOIN size ON product_sizes.size_id = size.id
        WHERE products.pID = $pID AND product_color.id = $colorId AND product_sizes.quantityavailable >= 1 AND product_sizes.quantity !=0";


    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sizes = array();

        while ($row = $result->fetch_assoc()) {
            $sizes[] = $row['size_name'];
            $_SESSION['product_price'] = $row['Price'];
            $_SESSION['product_name'] = $row['product_name'];
            $_SESSION['quantity_available'] = $row['quantityavailable']; // Store the initial quantity available in a session variable

        }
        $_SESSION['sizes'] = $sizes;
    }
}




?>

<head>
    <style>
     
    .size-radio-btn {
        margin-right: 10px; /* Adjust the margin as per your preference */
    }

    .cart-form {
        margin-top: -100px; }


    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 9999; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* Enable scroll if needed */
        background-color: rgba(0,0,0,0.5); /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 30%; /* Could be more or less, depending on screen size */
        text-align: center;
    }
    </style>
</head>

<!-- Send values to add cart -->
<h2 class="product-brand mb-3"><?php echo $_SESSION['product_name']; ?></h2>
<span class="product-price mb-3"><?php echo $_SESSION['product_price']; ?>$</span>

<hr class="mb-2" style="border:1px dotted lightgray;">

<!-- Sizes -->
<!-- Sizes -->
<p class="product-sub-heading mt-5">Size:</p>
<?php foreach ($size_options as $option) { ?>
    <?php
    $disabled = !in_array($option['name'], $_SESSION['sizes']);
    $isChecked = isset($_GET['size']) && $_GET['size'] == $option['id'];
    ?>
    <input type="radio" id="size-radio-<?php echo $option['id']; ?>" name="size" value="<?php echo $option['id']; ?>" <?php if ($disabled) echo 'disabled'; ?> <?php if ($isChecked) echo 'checked'; ?> onclick="document.getElementById('size').value = this.value;">
    <label class="size-radio-btn <?php if ($disabled) echo 'disabled'; ?>" for="size-radio-<?php echo $option['id']; ?>"><?php echo $option['name']; ?></label>
<?php } ?>


<!-- Send values to add cart -->
<form class="cart-form" method="post" action="localstorage.php">
    <input type="hidden" name="user_id" value="<?php echo $id; ?>"><br>
    <input type="hidden" name="prod_id" value="<?php echo $pID; ?>"><br>
    <input type="hidden" name="color_id" id="colorId" value="<?php echo isset($_GET['colorID']) ? $_GET['colorID'] : ''; ?>"><br>
    <input type="hidden" name="size" id="size" value="<?php echo isset($_GET['size']) ? $_GET['size'] : ''; ?>"><br>
 
    <button class="btn cart-btn mt-5">Add to cart</button>
</form>