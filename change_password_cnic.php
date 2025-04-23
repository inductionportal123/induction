<?php
    // Include database connection file
    include('connection/conn.php');

    // Check if CNIC is passed in the URL
    if(isset($_GET['cnic'])) {
        $cnic = $_GET['cnic'];
        
        // Check if form is submitted
        if(isset($_POST['submit'])) {
            // Get new password and confirmation password from the form
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Check if passwords match
            if($new_password === $confirm_password) {
                // Update password in the database
                $query = "UPDATE acount_details SET password = '$new_password' WHERE cnic = '$cnic'";
                $result = mysqli_query($conn, $query);

                if($result) {
                    // Password updated successfully
                    $success = "Password changed successfully.";
                } else {
                    // Failed to update password
                    $error = "Failed to change password. Please try again.";
                }
            } else {
                // Passwords do not match
                $error = "Passwords do not match. Please try again.";
            }
        }
    } else {
        // If CNIC is not passed in the URL, redirect to forget password page
        header("Location: forget_password.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 30px;
            color: #007bff;
            text-align: center;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <?php if(isset($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <?php if(isset($success)) { ?>
            <div class="alert alert-success" role="alert">
                <?php echo $success; ?> <br>
                <a href="login.php" class="btn btn-primary">Go to Home</a>
            </div>
        <?php } ?>
        <?php if(!isset($success)) { ?>
            <form method="post">
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block" name="submit">Change Password</button>
            </form>
        <?php } ?>
    </div>
</body>
</html>
