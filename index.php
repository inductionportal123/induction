<?php
include('connection/conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>sdfsdfsdfsdfsdf</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="stylesheet" href="css/loginstyles.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f7fb;
            padding-top: 50px;
        }
        .center-div {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100px; /* You can adjust this as per your requirement */
    text-align: center;
}

        .top_navbar {
            background-color: #0066cc;
            color: white;
            padding: 20px;
            text-align: center;
            font-weight: bold;
        }

        .main_container {
            max-width: 480px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .main_container h2 {
            font-weight: 600;
            font-size: 1.75rem;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-control {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 1rem;
            border: 1px solid #ddd;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: #0066cc;
            box-shadow: 0 0 8px rgba(0, 102, 204, 0.2);
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            width: 100%;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }

        .btn:hover {
            background-color: #218838;
        }

        .alert {
            font-size: 1rem;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #e8f4f8;
            border: 1px solid #bee3f8;
            color: #007bff;
        }

        .alert-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 0.9rem;
        }

        .footer a {
            color: #0066cc;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        .logo-container img {
            height: 130px;
            width: 130px;
            margin-bottom: 20px;
        }

        .text-center p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <!--<div class="top_navbar">-->
    <!--    <p>Federal Government Educational Institutions (C/G)</p>-->
    <!--</div>-->

    <div class="main_container">
        
        <?php
        if (@$_GET['changepas'] == 'ok') {
        ?>
            <div class="alert alert-info">
                <b>Your password has been changed successfully.</b> Please use your CNIC and PASSWORD to log in below.
            </div>
        <?php
        }

        if (isset($_GET['success'])) {
            if ($_GET['success'] == 'true') {
        ?>
            <div class="alert alert-info">
                <b>Registration successful.</b> Please use your CNIC and PASSWORD to log in below.
            </div>
        <?php
            }
        }
        ?>
        
      


        <div class="logo-container text-center">
            <a href="index.php"><img src="images/logo.png" class="img-fluid"></a>
        </div>
          <div class="center-div">
    <p>Federal Government Educational Institutions (C/G)</p>
</div>

        <h2>ONLINE RECRUITMENT LOGIN</h2>

        <form id="login-submit-form" method="post">
            <div class="form-group">
                <label for="login_cnic"><b>CNIC</b></label>
                <input type="text" class="form-control" name="login_cnic" id="login_cnic" data-inputmask="'mask': '99999-9999999-9'" placeholder="(Format xxxxx-xxxxxxx-x)">
            </div>

            <div class="form-group">
                <label for="login_password"><b>Password</b></label>
                <input type="password" class="form-control" name="login_password" id="login_password">
            </div>

            <button type="button" id="login_submit" name="login_submit" class="btn">Log In</button>
        </form>

        <div id="response" class="text-center"></div>

        <div class="text-center">
            <h4>Don't have an account? <b><a href="signup.php">Sign Up</a></b></h4>
        </div>

        <div class="text-center">
            <p>Forgot Password? <b><a href="forgetpassword_cnic.php">Click here</a></b></p>
        </div>

        <!--<div class="text-center">-->
        <!--    <p>Forgot Email Address? <b><a href="forgetemail.php">Click here</a></b></p>-->
        <!--</div>-->

        <div class="text-center">
            <a href="index.php" class="">Home Page</a>
        </div>

        <div class="footer">
            <p><b>In case of any query, please contact: 051-4252080</b></p>
            <p>&copy; 2024 FGEI (C/G). All rights reserved.</p>
        </div>
    </div>
</div>

<script src="script/jquery.inputmask.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"></script>
<script>
    $(":input").inputmask();
    $(document).ready(function(){
        $("#login_submit").click(function(){
            var cnic = $("#login_cnic").val().replace(/[^a-zA-Z0-9 ]/g, "");
            var password = $("#login_password").val();
            if(cnic == "" || password == "")
            {
                $('#response').fadeIn();
                $('#response').addClass('error-msg').html("All Field Are Required");
            }
            else if(cnic.length != 13)
            {
                $('#response').fadeIn();
                $('#response').addClass('error-msg').html("Check Your CNIC Format");
            }
            else
            {
                $.ajax({
                    url: "login_process.php",
                    type: "POST",
                    data: $('#login-submit-form').serialize(),
                    beforesend: function()
                    {
                        $('#response').fadeIn();
                        $('#response').removeClass('error-msg').addClass('process-msg').html("Loading....");
                    },
                    success : function(data){
                        if(data == 1)
                        {
                            window.location.href = "profile.php";
                        }
                        else
                        {
                            $('#response').fadeIn();
                            $('#response').addClass('error-msg').html("Login Failed, Check your CNIC or Password,Due to not updated profile data within due time. ");
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>
