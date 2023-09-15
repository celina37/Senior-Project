
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('C:/xampp/htdocs/ISDProject/db_connect.php');

    // Check which form is submitted based on the form id
    if ($_POST['formm_id'] === 'update-profile-form') {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

        if (isset($id) && $id != 0 && $id != null) {
            $fname = isset($_POST['fname']) ? $_POST['fname'] : '';
            $lname = isset($_POST['lname']) ? $_POST['lname'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $phone = isset($_POST['phone']) ? $_POST['phone'] : '';

            $error = "";

            // Fetch the user's row from the database
            $sql = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);

            // Check if the email is already taken by other users
            $emailQuery = "SELECT id FROM users WHERE email = '$email' AND id != '$id'";
            $emailResult = mysqli_query($conn, $emailQuery);
            if (mysqli_num_rows($emailResult) > 0) {
                $error = "Email is already taken.";
                if ($row['bAdmin'] == 1) {
                    header('Location: ../backend/editprofile.php?error=' . urlencode($error));
                } else {
                    header('Location: ../frontend/editprofile.php?error=' . urlencode($error));
                }
                exit();
            }

            // Check if the first name or last name contains spaces
            if (strpos($fname, ' ') !== false || strpos($lname, ' ') !== false) {
                $error = "First Name and Last Name cannot contain space.";
                if ($row['bAdmin'] == 1) {
                    header('Location: ../backend/editprofile.php?error=' . urlencode($error));
                } else {
                    header('Location: ../frontend/editprofile.php?error=' . urlencode($error));
                }
                exit();
            }

            // Check if the phone number is already taken by other users
            $phoneQuery = "SELECT id FROM users WHERE phone = '$phone' AND id != '$id'";
            $phoneResult = mysqli_query($conn, $phoneQuery);
            if (mysqli_num_rows($phoneResult) > 0) {
                $error = "Phone number is already taken.";
                if ($row['bAdmin'] == 1) {
                    header('Location: ../backend/editprofile.php?error=' . urlencode($error));
                } else {
                    header('Location: ../frontend/editprofile.php?error=' . urlencode($error));
                }
                exit();
            }

            // Update the user's profile in the database
            $sql = "UPDATE users SET fname = '$fname', lname = '$lname', email = '$email', phone = '$phone' WHERE id = '$id'";

            if (mysqli_query($conn, $sql)) {
                $error = "Profile updated successfully.";
                if ($row['bAdmin'] == 1) {
                    header('Location: ../backend/editprofile.php?error=' . urlencode($error));
                } else {
                    header('Location: ../frontend/editprofile.php?error=' . urlencode($error));
                }
                exit();
            } else {
                echo "Error updating profile: " . mysqli_error($conn);
            }

            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    }
}
?>