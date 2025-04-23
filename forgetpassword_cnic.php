<?php
    include('connection/conn.php');

    // Initialize variables
    $error = '';

    // Check if CNIC is submitted
    if(isset($_POST['cnic'])) {
        $cnic = $_POST['cnic'];
        
        // Perform CNIC verification in your database
        $query = "SELECT * FROM acount_details WHERE cnic = '$cnic'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        
        if($row) {
            // CNIC matched, redirect to password change page
            header("Location: change_password_cnic.php?cnic=$cnic");
            exit();
        } else {
            // CNIC not found, display error message
            $error = "The provided CNIC does not exist in our records. Please try again or contact support.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Forget Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding-top: 50px;
        }
        .error-message {
            color: #ff0000;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Forget Password</h2>
        <?php if(!empty($error)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error; ?>
            </div>
        <?php } ?>
        <form method="post">
            <div class="form-group">
                <label for="cnic">Enter your CNIC:</label>
                <input type="text" class="form-control" id="cnic" name="cnic" placeholder="12345-6789012-3" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
        <div class="text-center mt-3">
            <p>Don't have an account? <a href="signup.php">Register here</a>.</p>
        </div>
    </div>
</body>
</html>
