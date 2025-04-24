<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FGEI (C/G) - Recruitment Sign Up</title>

    <!-- Bootstrap & Google Fonts -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f7f7f7;
            padding: 50px 0;
        }
        .container {
            max-width: 500px;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            font-size: 26px;
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            height: 45px;
            padding-left: 15px;
        }
        .form-control:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }
        .btn-success {
            width: 100%;
            background-color: #28a745;
            border-color: #28a745;
            font-size: 16px;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-success:hover {
            background-color: #218838;
        }
        .error-msg, .process-msg {
            color: #d9534f;
            font-size: 14px;
            text-align: center;
            margin-top: 15px;
            display: none;
        }
        .form-group {
            margin-bottom: 20px;
        }
        @media (max-width: 576px) {
            .container {
                width: 90%;
                padding: 25px;
            }
            .container h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="text-center mb-4">
        <a href="index.php"><img src="images/logo.png" style="max-width: 180px;" alt="FGEI Logo"></a>
    </div>

    <h2>Sign Up</h2>

    <form id="submit_signup_form">
        <div class="form-group">
            <label for="fname">Full Name</label>
            <input type="text" class="form-control" name="fname" id="fname" placeholder="Full Name" required>
        </div>

        <div class="form-group">
            <label for="mail">Email</label>
            <input type="email" class="form-control" name="mail" id="mail" placeholder="Email" required>
        </div>

        <div class="form-group">
            <label for="cnic">CNIC</label>
            <input type="text" class="form-control" name="cnic" id="cnic" placeholder="CNIC" data-inputmask="'mask': '99999-9999999-9'" required>
        </div>

        <div class="form-group">
            <label for="c_cnic">Confirm CNIC</label>
            <input type="text" class="form-control" name="c_cnic" min="6" id="c_cnic" placeholder="Confirm CNIC" data-inputmask="'mask': '99999-9999999-9'" required>
        </div>

        <div class="form-group">
            <label for="pass">Password</label>
            <input type="password" class="form-control" name="pass" id="pass" placeholder="Password" required>
        </div>

        <div class="form-group">
            <label for="cpass">Confirm Password</label>
            <input type="password" class="form-control" name="cpass" id="cpass" placeholder="Confirm Password" required>
        </div>

        <button type="button" id="signup_submit" class="btn btn-success">Register</button>
        <p id="response" class="error-msg mt-3"></p>
    </form>
</div>

<script src="script/jquery.inputmask.bundle.js"></script>
<script>
    // Apply input mask only to CNIC fields
    $("#cnic, #c_cnic").inputmask();

    $(document).ready(function(){
        $("#signup_submit").click(function(){
            var cnic = $("#cnic").val().replace(/[^0-9]/g, "");
            var c_cnic = $("#c_cnic").val().replace(/[^0-9]/g, "");
            var fname = $("#fname").val().trim();
            var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            var email = $("#mail").val().trim();
            var password = $("#pass").val().replace(/\s/g, '');
            var confirm_password = $("#cpass").val().replace(/\s/g, '');

            if (cnic === "" || c_cnic === "" || fname === "" || email === "" || password === "" || confirm_password === "") {
                $('#response').fadeIn().html("All fields are required").addClass('error-msg');
            } else if (!emailReg.test(email)) {
                $('#response').fadeIn().html("Enter a valid email").addClass('error-msg');
            } else if (cnic.length !== 13 || c_cnic.length !== 13) {
                $('#response').fadeIn().html("CNIC must be 13 digits").addClass('error-msg');
            } else if (cnic !== c_cnic) {
                $('#response').fadeIn().html("CNIC does not match").addClass('error-msg');
            } else if (password !== confirm_password) {
                $('#response').fadeIn().html("Password mismatch").addClass('error-msg');
            } else {
                $.ajax({
                    url: "signup_process.php",
                    type: "POST",
                    data: $('#submit_signup_form').serialize(),
                    beforeSend: function() {
                        $('#response').fadeIn().html("Processing...").removeClass('error-msg').addClass('process-msg');
                    },
                    success: function(data) {
                        console.log("Server response: ", data); // Debug response
                        if (data == 1) {
                            window.location.href = "login.php?success=true";
                        } else if (data == 0) {
                            $('#response').fadeIn().html("CNIC already exists").removeClass('process-msg').addClass('error-msg');
                        } else if (data == 2) {
                            $('#response').fadeIn().html("Registration failed. Please try again.").removeClass('process-msg').addClass('error-msg');
                        } else if (data == 3) {
                            $('#response').fadeIn().html("All fields are required").removeClass('process-msg').addClass('error-msg');
                        } else if (data == 4) {
                            $('#response').fadeIn().html("Database error. Please contact support.").removeClass('process-msg').addClass('error-msg');
                        } else {
                            $('#response').fadeIn().html("Unknown error. Please try again.").removeClass('process-msg').addClass('error-msg');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("AJAX error: ", status, error); // Debug AJAX error
                        $('#response').fadeIn().html("Server error. Please try again.").removeClass('process-msg').addClass('error-msg');
                    }
                });
            }
        });
    });
</script>
</body>
</html>