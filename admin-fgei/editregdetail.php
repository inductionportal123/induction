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
<?php

 $id = $_GET['id'];

 $query1 = "SELECT * FROM `region_details` WHERE `id` = '$id' ";   

$exe1 = mysqli_query($conn,$query1);
$rows1 = mysqli_fetch_array($exe1);
$rowcount1 = mysqli_num_rows($exe1);

if($rowcount1 == 1)
{
	$n = $rows1['region_name'];
	$c = $rows1['contact'];
	$a = $rows1['address'];
}	


?>
<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
			
			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;margin-bottom: 15px;">Region Details:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">

					<div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>Region Name:</label>
						</div>
						<div class="col-lg-8" align="left">
							<select class="form-control" name="region_name" required>
							
							
								<option value="<?php echo $n; ?>" selected><?php echo $n; ?></option>
							 
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
                    <div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>Region Contact:</label>
						</div>
						<div class="col-lg-8" align="left">
							<input type="text" class="form-control" name="contact" value="<?php echo $c; ?>">
						</div>
					</div>
                    <div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>Region Address:</label>
						</div>
						<div class="col-lg-8" align="left">
							<input type="text" class="form-control" name="address"  value="<?php echo $a; ?>">
						</div>
					</div>
                    <div class="row" style="margin-bottom: 20px;">
						<input type="submit" class="btn btn-block btn-lg btn-primary" name="update" value="Update">
					</div>
                
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update']))
        {
            $region_name = $_POST['region_name'];
            $region_contact = $_POST['contact'];
            $region_address = $_POST['address'];
            $sqlupdate = "UPDATE `region_details` SET `region_name`='$region_name',`contact`='$region_contact' , `address`='$region_address' WHERE id = '$id'";
            $exeupdate = mysqli_query($conn, $sqlupdate);
            header('location: region_Setting.php');
        }
      ?>
      
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