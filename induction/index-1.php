<?php
include('connection/conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Welcome to FGEI (C/G) - Recruitment </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <link rel="stylesheet" href="css/loginstyles.css">

<style type="text/css">
   @media all and (min-width: 800px) {
    .deskContent {display:block;}
    .phoneContent {display:none;}
}

@media all and (max-width: 479px) {
    .deskContent {display:none;}
    .phoneContent {display:block;}
}
</style>


</head>
<body>

<div class="deskContent">


    <div class="wrapper hover_collapse">
        <div class="top_navbar">
            	<p>Federal Government Educational Institutions (C/G)</p>
        </div>
    </div>
<!-- --------------------------------------body working------------------------------------------ -->
    <div class="main_container" >
        <div class="container" >
            <div class="content">
                <?php
                    if(@$_GET['changepas'] == 'ok')
                    {
                ?>
                <h4 id="dis" style="color: green; text-align: center; margin-top: 5px;">
                    <b>You password has been changed successfully.</b>
                </h4>
                <h5 id="dis" style="color: green; text-align: center; margin-top: 5px;">
                    Please use your CNIC and PASSWORD to login below.
                </h5>
                <?php
                    }
                ?>
                
                <?php
                if(isset($_GET['success'])){
                    if($_GET['success'] == 'true')
                    {
                ?>
                <h4 id="dis" style="color: green; text-align: center; margin-top: 5px;">
                    <b>Registeration successful.</b>
                </h4>
                <h5 id="dis" style="color: green; text-align: center; margin-top: 5px;">
                    Please use your CNIC and PASSWORD to login below.
                </h5>
                <?php
                    }
                }
                ?>

                <div class="row" style="justify-content: center;">
                    <img src="images/logo.png" style="height: 135px; width: 135px;">
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <h2 class="row" style="justify-content: center;">WELCOME TO FGEI (C/G) ONLINE RECRUITMENT</h2>
                        <br><br>

                     <h3 class="row" style="justify-content: center;">APPLICATIONS SUBMISSION WILL BE STARTED FROM TOMORROW</h3>
                        
<!-- ------------------------------Personal info tab controller---------------------------------------------- -->
                       
                        <br>
                        <h3 class="row" style="justify-content: center;">THANKS FOR YOUR VISIT</h3>
                     
                        <br>
                        <br><br>
                        <br><br>
                        <br>
 <br>
                        <br>
<!-- ------------------------------Personal info tab controller ends---------------------------------------------- -->
                    </div>
                </div>
            </div>
            <!-- body Ends -->
        </div>
         </div>


</div> <!-- Desktop View Ends --> 

<div class="phoneContent">
     <div class="container" >
		<div class="content">
	<h4>For Effective application submission, please use Desktop/Laptop with latest Google Chrome browser<br/> FGEI(C/G)<h4>
	</div>
      	</div>
         	</div>





        
        <script src="script/jquery.inputmask.bundle.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
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
                                    $('#response').addClass('error-msg').html("Login Failed, Check your Cnic or Password");
                                }
                            }
                        });
                    }
                });
            });
        </script>
   
        </body>
    </html>