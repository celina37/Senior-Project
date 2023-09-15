<?php
include ('db_connect.php');

if (isset($_POST['save'])) {
    $new_fname = $_POST['fname'];
    $new_lname = $_POST['lname'];
    $id = $_SESSION['id'];

    $sql = "UPDATE users SET fname='$new_fname', lname='$new_lname' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['fname'] = $new_fname;
        $_SESSION['lname'] = $new_lname;
        header("Location: accountSettings.php");
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

if(isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
    header("Location: accountSettings.php");
}

mysqli_close($conn);
?>
