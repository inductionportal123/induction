<?php
	include('connection/conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>FGEI (C/G) - Recruitment Sign up</title>

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
	<div class="container" style="background-color:white ; margin-left:-5%">
		<div class="col-lg-4" style="text-align:right">
			<div class="row" style="justify-content: center; margin-top:120px" >
				<img src="images/logo.png" style="height: 200px; width: 200px;">
			</div>
        </div>
        <div class="col-lg-8" >
            <form id="submit_signup_form">
                <div class="row">
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
<!--                        <h2 class="heading">Sign Up</h2>-->
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3" style="margin-bottom:15px">
                        <h2 class="heading">Sign Up</h2>
                    </div>
                </div>
                <div class="row" style="text-align:right">
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3" >
                        <h5><b>Full Name:</b></h5>
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                        <input type="text"  class="form-control" name="fname" id="fname">
                    </div>
                </div>
                
                <br>
                
                <div class="row" style="text-align:right">
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
                        <h5><b>Email:</b></h5>	
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                        <input type="email"  class="form-control" name="mail" id="mail">
                    </div>
                </div>
                
                <br>
                
                <div class="row" style="text-align:right">
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
                        <h5><b>CNIC:</b>:</h5>
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                        <input type="text"  class="form-control" name="cnic" id="cnic" data-inputmask="'mask': '99999-9999999-9'" placeholder="(Format xxxxx-xxxxxxx-x)">
                    </div>
                </div>
                
                <br>
                
                <div class="row" style="text-align:right">
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
                        <h5><b>Confirm CNIC:</b></h5>
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                        <input type="text"  class="form-control" name="c_cnic" id="c_cnic" data-inputmask="'mask': '99999-9999999-9'" placeholder="(Format xxxxx-xxxxxxx-x)">
                    </div>
                </div>
                
                <br>
                
                <div class="row" style="text-align:right">
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
                        <h5><b>Password:</b></h5>
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                        <input type="password"  class="form-control" name="pass" id="pass">
                    </div>
                </div>
                
                <br>
                
                <div class="row" style="text-align:right">
                    <div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
                        <h5><b>Confirm Password:</b></h5>
                    </div>
                    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                        <input type="password"  class="form-control" name="cpass" id="cpass">
                    </div>
                </div>
            </form>
            <div class="row" style="text-align:center" >
                <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4"></div>
                <input type="button" id="signup_submit" name="signup_submit" value="Register" class="btn btn-success btn-md" style="width: 100px; margin-bottom: 10px;outline:none; margin-top:10px">
            </div>
            <div class="row" style="text-align:center" >
                <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4"></div>
                <p id="response" style="margin-left: -2%;"></p>
            </div>
        </div>
    </div>
			  
<!-- ------------------------------Personal info tab controller---------------------------------------------- -->
<div class="tab-content">
<!--
    <div class="row" style="justify-content: center;">
        <p id="response" style="margin-top: 8px;"></p>
    </div>
-->
    <br>
    <p style="text-align: center; color: black;">Copyright &copy; 2021. FGEI (C/G) All rights reserved.</p>
    <br>
    </div>
<!-- ------------------------------Personal info tab controller ends---------------------------------------------- -->
		</div>

</div> <!-- Desktop View Ends --> 

<div class="phoneContent">
     <div class="container" >
    <div class="content">
  <h4>For Effective application submission, please use Desktop/Laptop with latest Google Chrome browser<br/> FGEI(C/G)<h4>
  </div>
        </div>
          </div>

	
<!-- body Ends -->


 	<script src="script/jquery.inputmask.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script>
  $(":input").inputmask();

  $(document).ready(function(){
  	$("#signup_submit").click(function(){
  		var cnic = $("#cnic").val().replace(/[^a-zA-Z0-9 ]/g, "");
  		var c_cnic = $("#c_cnic").val().replace(/[^a-zA-Z0-9 ]/g, "");
  		var fname = $("#fname");
  		var emailReg = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  		var email = $("#mail").val();
  		var password = $("#pass").val().replace(/\s/g, '');
  		var confirm_password = $("#cpass").val().replace(/\s/g, '');

  		if(cnic == "" || c_cnic == "" || fname == "" || email == "" || password == "" || confirm_password == "")
  		{
  			$('#response').fadeIn();
  			$('#response').addClass('error-msg').html("All Field Are Required");
  		}
        else if(!emailReg.test(email)){
            $('#response').slideDown();
  			$('#response').addClass('error-msg').html("Enter a valid Email address");
        }
  		else if(cnic.length != 13 || c_cnic.length != 13)
  		{
  			$('#response').slideDown();
  			$('#response').addClass('error-msg').html("Check your CNIC Format");
  		}
        else if(cnic != c_cnic)
  		{
  			$('#response').slideDown();
  			$('#response').addClass('error-msg').html("CNIC Does not match");
  		}
  		else if(password != confirm_password)
  		{
  			$('#response').slideDown();
  			$('#response').addClass('error-msg').html("PASSWORD Does not match");
  		}
  		else
  		{
  			$.ajax({
  				url: "signup_process.php",
  				type: "POST",
  				data: $('#submit_signup_form').serialize(),
  				beforesend: function()
				{
					$('#response').fadeIn();
					$('#response').removeClass('error-msg').addClass('process-msg').html("Loading....");
				},
  				success : function(data){
  					if(data == 1)
  					{
  						window.location.href = "index.php?success=true";
  					}
  					else
  					{
  						$('#response').fadeIn();
  						$('#response').addClass('error-msg').html("CNIC already exist.");
  					}

  				}
  			});
  		}

  	});	
  });
</script>
    </div>
</body>
</html>