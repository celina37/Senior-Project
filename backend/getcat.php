<?php


include('C:\xampp\htdocs\ISDProject\db_connect.php');

$category_id = isset($_POST['category']) ? $_POST['category'] : '';
$gender_id = isset($_GET['gender']) ? $_GET['gender'] : '';
$query = "SELECT categoryname, id FROM categories WHERE gender_id = $gender_id";
$result = mysqli_query($conn, $query);
$catdisplay = '';

while($row = mysqli_fetch_assoc($result))
{
  $category_id = $row['id'];
  $catdisplay .= "<option value='$category_id'>".$row['categoryname']."</option>";

 
}

$_SESSION['catdisplay'] = $catdisplay;

echo $catdisplay;


?>
