<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Include the database connection file
  include('C:/xampp/htdocs/ISDProject/db_connect.php');

  // Retrieve the form data
  $categoryName = $_POST["name"];
  $genderId = $_POST["gender"];

  // Prepare the SQL statement
  $stmt = $conn->prepare("INSERT INTO categories (categoryname, gender_id) VALUES (?, ?)");

  // Bind the parameters
  $stmt->bind_param("si", $categoryName, $genderId);

  // Execute the statement
  $stmt->execute();

  // Close the statement
  $stmt->close();

  // Close the database connection
  $conn->close();

  // Redirect or display a success message
  // Replace "redirect_page.php" with the page you want to redirect to or a success message
  header("Location: ../backend/category.php");
  exit();
}
?>
