<?php 
include('C:\xampp\htdocs\ISDProject\db_connect.php');

$category_id = isset($_GET['category']) ? $_GET['category'] : '';
$subcat_id = isset($_GET['subcategory']) ? $_GET['subcategory'] : '';
$query = "SELECT subcatname, id FROM subcategories WHERE cat_id = $category_id";
$result = mysqli_query($conn, $query);
$subcatdisplay = '';

while($row = mysqli_fetch_assoc($result))
{
  $subcat_id = $row['id'];
  $subcatdisplay .= "<option value='$subcat_id'>".$row['subcatname']."</option>";

}

echo $subcatdisplay;
?>