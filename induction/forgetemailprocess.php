<?php
	include('connection/conn.php');

			$cnicf = $_POST['cnic'];

			
			$query = "SELECT email FROM `acount_details` WHERE cnic = '".$cnicf."'";
			$exe = mysqli_query($conn,$query);
			$rowcount = mysqli_num_rows($exe);

			if($rowcount == 1){

				$row = mysqli_fetch_array($exe);

				$mycnic = $row['email'];
}


$newstring = substr($mycnic, -16);


?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Forget Email</title>

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

			
			<div class="row" style="justify-content: center;">
				<img src="images/logo.png" style="height: 135px; width: 135px;">
			</div>
			<div class="row" style="justify-content: center;">
				<div class="col-sm-12 col-md-12 col-lg-12">

				  <h2 class="heading">Email Recovery</h2>
				 
				  <br/>


<!-- ------------------------------Personal info tab controller---------------------------------------------- -->
<div class="tab-content">
<?php 
if(isset($mycnic))
{
?>	

			<div class="row" style="justify-content: center;"  >
				     		<h4><b>Your Email hint is shown below:</b></h4> 	      	
			</div>

			<div class="row" style="justify-content: center;"  >
					      			      
					      	<div>
					      		
					      		<?php
                                   
					      		 echo '******'.$newstring;
					      		 ?>
</div></div>



<?php
}
else
{
?>
		<div class="row" style="justify-content: center;"  >
		 
					      			
<h4>No record Found Reason: (Wrong CNIC Provided)</h4>					      		
					   	</div>
			</div>


<?php
}
?>			

		     <br>
	  <div class="row" style="justify-content: center;" >
                                <h4>Go back to Login page <b><a href="." style="text-decoration: none;">click here</a></b></h4>
                            </div>
	</div>
	


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
