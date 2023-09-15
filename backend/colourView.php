<!-- get ProductName, Color, Quantity for each size(), mainimg_path, backimg_path, multiimg() -->
<?php
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$color = isset($_GET['color']) ? $_GET['color'] : '';
$pID = isset($_GET['pID']) ? $_GET['pID'] : '';

$sql = "SELECT products.pID AS pID, 
        products.name AS ProductName,
        product_color.color AS Color,
        product_color.id AS ColorId,
        product_sizes.quantity AS Quantity,
        size.name AS Size,
        size.id AS SizeId,
        product_images.mainimg_path AS MainImagePath,
        product_images.backimg_path AS BackImagePath,
        multiimages.image_path AS MultiImagePath
        FROM products
        INNER JOIN product_color ON products.pID = product_color.product_id
        INNER JOIN product_sizes ON products.pID = product_sizes.prod_id AND product_color.id = product_sizes.color_id
        INNER JOIN product_images ON product_color.id = product_images.product_color_id
        INNER JOIN size ON product_sizes.size_id = size.id
        LEFT JOIN (
            SELECT product_color_id, GROUP_CONCAT(image_path) AS image_path
            FROM multiimages
            GROUP BY product_color_id
        ) multiimages ON product_color.id = multiimages.product_color_id
        WHERE product_color.color = '$color' AND products.pID = $pID AND product_sizes.quantity > 0
        ORDER BY SizeId;";

$result = mysqli_query($conn, $sql);

if ($result->num_rows > 0) {
  $color_info = array();
  $mainimg_path = '';
  $backimage_path = '';
  $multiimages = array();
  $sizes = array();
  $index = 0;

  while ($row = $result->fetch_assoc()) {
      $pID = $row['pID'];
      $ProductName = $row['ProductName'];
      $mainimg_path = $row['MainImagePath'];
      $backimage_path = $row['BackImagePath'];
      $multiimages = explode(',', $row['MultiImagePath']);
      $sizes[$row['Size']] = $row['Quantity'];
      $Color = $row['Color'];
      $colorId = $row['ColorId'];

      if (!isset($color_info[$index])) {
          $color_info[$index] = array(
              'pID' => $pID,
              'ProductName' => $ProductName,
              'Color' => $Color,
              'colorId' => $colorId,
              'mainimg_path' => $mainimg_path,
              'backimage_path' => $backimage_path,
              'MultiImagePath' => array(),
              'sizes' => $sizes
          );
      }

      if ($row['MultiImagePath']) {
          $color_info[$index]['MultiImagePath'][] = $row['MultiImagePath'];
      }

      $index++;
  }

  $_SESSION['color_info'] = $color_info;
}

?>



<div class="modal-header">
  <h5 class="modal-title" id="colorModalLabel">Color Details - <?php echo $ProductName; ?></h5>
  <div class="color-circle" id="selectedColorCircle" style="background-color: <?php echo $_GET['color']; ?>; border: 1px solid black;"></div>
  <div>Color ID: <?php echo isset($colorId) ? $colorId : ''; ?></div>
</div>

  <div class="modal-body">
    <input type="radio" id="selectedColorRadio" name="selectedColor" style="display: none;" />
    <label for="selectedColorRadio" id="selectedColorLabel"></label>
    <div class="row">
      <div class="col-3">
        <table class="table table-bordered">
          <caption>This is the original quantity</caption>
          <thead>
            <tr>
              <th scope="col">Size</th>
              <th scope="col">Quantity</th>
            </tr>
          </thead>
          <tbody class="center-aligned">
            <?php foreach ($sizes as $size => $quantity) { ?>
                <tr>
                    <th scope="row"><?php echo $size; ?></th>
                    <td><?php echo $quantity; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
      </div>
      <div class="col-4">
        <h3> Main Image</h3>
        <br>
        <img class="main-image" src="../uploads/mainimg/<?php echo $mainimg_path?>" style="width:150px;height:180px;">
      </div>
      <div class="col-4">
        <h3> Back Image </h3>
        <br>
        <img class="back-image" src="../uploads/backimg/<?php echo $backimage_path?>" style="width:150px;height:180px;">
      </div>
    </div>
    <div class="row">
      <div class="col-3">
        <h3> Description Images </h3>
      </div>
      <!-- <div class="col-2">  -->
      <div class="row-2"> 
        <?php foreach ($multiimages as $image) { ?>
          <img class='multi-image' src='../uploads/descimg/<?php echo $image ?>' style='width:120px;height:150px;'>
        <?php } ?>
      </div>
    </div>
  </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-primary" onclick="editColor('<?php echo $pID; ?>', '<?php echo $colorId; ?>')">Edit</button>
  <form method="post" action="deletecolor.php">
  <input type="hidden" name="pID" value="<?php echo $pID; ?>">
  <input type="hidden" name="colorId" value="<?php echo $colorId; ?>">
  <button type="submit" class="btn btn-danger">Delete This Color</button>
</form>

        </div>
<script>
function editColor(pID, colorId) {
  window.location.href = 'editcolor.php?product_id=' + pID + '&color_id=' + colorId + '&color=' + encodeURIComponent('<?php echo $Color; ?>') + '&ProductName=' + encodeURIComponent('<?php echo $ProductName; ?>');
}
</script>