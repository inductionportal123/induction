<?php
	include('connection/conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Forget Password</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<link rel="stylesheet" href="css/loginstyles.css">
</head>
<body>
	
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

			          if (@$_GET['emails'] == 'false'){
			?>

			            <h3  style="color: green; text-align: center; margin-top: 5px;">Email does not Exists.</h3>
			            

			<?php 
			}
			          if (@$_GET['emails'] == 'true'){

			?>

			            <h3  style="color: green; text-align: center; margin-top: 5px;">Password reset link has been sent to your email.</h3>
			            

			<?php 
			}
			?>


			<div class="row" style="justify-content: center;">
				<img src="images/logo.png" style="height: 135px; width: 135px;">
			</div>
			<div class="row">
				<div class="col-sm-12 col-md-12 col-lg-12">

				  <h2 class="heading">Password Recovery</h2>
				  <br>
				  
				  


<!-- ------------------------------Personal info tab controller---------------------------------------------- -->
<div class="tab-content">
		<form action="forgetprocess.php" method="post">

			<div class="row" style="justify-content: center;"  >
					      	<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
					      		<h4><b>Email</b></h4>     		
					      	</div>

					     

					      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
					      		<input type="email"  class="form-control" name="email" id="email" required/>
					      	</div>
			</div>

		     <br>
			
	<div class="row" style="justify-content: center;" >
		<input type="submit" name="login_submit" value="Submit" class="btn btn-success btn-lg" style="width: 100px; margin-bottom: 5px;outline:none;">
			
		</div>
	</div>
	

</form>
<br>

			</div>
		</div> 		
</div>
<!-- body Ends -->
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

</body>
</html>