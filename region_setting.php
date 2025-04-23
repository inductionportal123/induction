<?php
ob_start();
include('../connection/conn.php');

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['user_name'],$_SESSION['user_access']))
{
	$user = $_SESSION['user_name'];
  $userid = $_SESSION['user_access'];

	$arr = explode(' ',trim($user));
	$newuser  = ucfirst("$arr[0]");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - District</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
<?php 
      include('header.php');
      include('generalnav.php');
    ?>

<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
			
			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;margin-bottom: 15px;">District Name:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">

					<div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>Region Name:</label>
						</div>
						<div class="col-lg-8" align="left">
							<select class="form-control" name="reg" required>
							
							
								<option value="" selected>Select Your Region</option>
							 
							<?php

             				$newquery = "SELECT `name` FROM `region` ORDER BY id ASC;";
							$newdatas = mysqli_query($conn,$newquery);				
							$newrowct = mysqli_num_rows($newdatas);


							if($newrowct>0){

							while ($newrowss = mysqli_fetch_array($newdatas)){
							?>

							        <option value="<?=$newrowss['name']?>"><?= strtoupper($newrowss['name']) ?></option> 
							<?php
							}
							}
							?>
							</select>
						</div>
					</div>
                
                
                </form>
            </div>
        </div>
    </div>
    </div>

				

    
    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>


</body>
</html>



<?php
}

else{
  header("Location: index.php");
}

?>