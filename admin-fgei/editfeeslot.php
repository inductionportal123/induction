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
	<title>Admin - Fee Slot</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
<?php 
      include('header.php');  
        include('postnav.php');
    ?>
<?php

 $id = $_GET['id'];

 $query1 = "SELECT * FROM `fee_slot` WHERE `id` = '$id' ";   

$exe1 = mysqli_query($conn,$query1);
$rows1 = mysqli_fetch_array($exe1);
$rowcount1 = mysqli_num_rows($exe1);

if($rowcount1 == 1)
{
	$s = $rows1['slot'];
	$f = $rows1['fee'];
	$a = $rows1['status'];
}	


?>


<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
		
			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Fee Slot:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">


					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Name of Post:</label>
						</div>
						<div class="col-lg-9" align="left">
							<select class="form-control" name="slot" required>
							
							
								<option value="" selected>Select Post</option>
							 
							<?php

             				$newquery = "SELECT * FROM `posts` ORDER BY gender DESC;";
							$newdatas = mysqli_query($conn,$newquery);				
							$newrowct = mysqli_num_rows($newdatas);


							if($newrowct>0){

							while ($newrowss = mysqli_fetch_array($newdatas)){
							?>

							        <option value="<?php echo $newrowss['pid']; ?>"><?php echo $newrowss['name']; echo ' (BPS-'. $newrowss['bps']; echo ') - '.ucfirst($newrowss['gender']);   ?></option> 
							<?php
							}
							}
							?>
							</select>
						</div>
					</div>



					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Fee:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="fee" class="form-control" <?php if(isset($f)){ ?> value="<?php  echo $f ?>" <?php } ?> required/>
						</div>
					</div>



					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Status:</label>
						</div>
						<div class="col-lg-9" align="left" > 
							<select class="form-control" name="sta" required/>
								<option value="active" <?php if(isset($a) && $a == "active"){  ?> selected  <?php } ?>>Active</option>
								<option value="deactive" <?php if(isset($a) && $a == "deactive"){  ?> selected  <?php } ?>>Deactive</option>
							</select>
						</div>
					</div>




					<br>


					<div class="row">
						<div class="col-lg-12" align="center">
					<?php if(isset($messg)){ echo $messg; } ?> 
							
					<input type="submit" name="submit" value="Update" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>




				</form>
				<hr>

			<!-- form request code -->
		<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	$slot_name = $_POST['slot'];
            
            $sql = "SELECT name FROM posts WHERE pid='$slot_name'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
  // output data of each row
        while($row = $result->fetch_assoc()) {
          
            
        	$slot_fee = $_POST['fee'];
        	$slot_status = strtolower($_POST['sta']);

        	$query = "UPDATE `fee_slot` SET `post_id`='$slot_name',`fee`='$slot_fee',`slot`='$row[name]', `status`='$slot_status' WHERE `id` = '$id'";
        	;

        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header('Location:feeslot.php?update=success');

	
				}

        }}} 

        ?>





			</div>
		</div>

		<div class="col-lg-3"></div>
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