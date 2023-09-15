<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('C:/xampp/htdocs/ISDProject/db_connect.php');

    // Check which form is submitted based on the form id
    if ($_POST['form_id'] === 'update-password-form') {
        $id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

        if (isset($id) && $id != 0 && $id != null) {
            $oldPassword = isset($_POST['old_password']) ? $_POST['old_password'] : '';
            $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            // Retrieve the hashed password from the database
            $query = "SELECT password FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $hashedPassword = $row['password'];

                // Verify if the old password matches the hashed password
                if (password_verify($oldPassword, $hashedPassword)) {
                    // Validate the new password and confirm password
                    if ($newPassword !== $confirmPassword) {
                        $message = "New password and confirm password do not match.";
                        if ($row['bAdmin'] == 1) {
                            header('Location: ../backend/editprofile.php?message=' . urlencode($message));
                        } else {
                            header('Location: ../frontend/editprofile.php?message=' . urlencode($message));
                        }
                        exit();
                    }

                    if (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z]).{5,}$/", $newPassword)) {
                        $message = "Password must be at least 5 characters, contain at least 1 digit, 1 special character, and 1 capital letter.";
                        if ($row['bAdmin'] == 1) {
                            header('Location: ../backend/editprofile.php?message=' . urlencode($message));
                        } else {
                            header('Location: ../frontend/editprofile.php?message=' . urlencode($message));
                        }
                        exit();
                    }

                    // Hash the new password
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the hashed password in the database
                    $updateQuery = "UPDATE users SET password = '$hashedNewPassword' WHERE id = '$id'";
                    if (mysqli_query($conn, $updateQuery)) {
                        $message = "Password updated successfully.";
                        if ($row['bAdmin'] == 1) {
                            header('Location: ../backend/editprofile.php?message=' . urlencode($message));
                        } else {
                            header('Location: ../frontend/editprofile.php?message=' . urlencode($message));
                        }
                        exit();
                    } else {
                        echo "Error updating password: " . mysqli_error($conn);
                    }
                } else {
                    $message = "Current password is incorrect.";
                    if ($row['bAdmin'] == 1) {
                        header('Location: ../backend/editprofile.php?message=' . urlencode($message));
                    } else {
                        header('Location: ../frontend/editprofile.php?message=' . urlencode($message));
                    }
                    exit();
                }
            } else {
                echo "Error retrieving user data: " . mysqli_error($conn);
            }
        }
    }
}
?>