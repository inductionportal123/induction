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
	<title>Admin - Bank Fee</title>
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

      	 if (@$_GET['insert'] == 'success')
          {
          						$messg = "Record Enter Successfully";
          }
         if (@$_GET['update'] == 'success')
          {
          						$messg = "Record Update Successfully";
          }


?>

<?php

$id = $_GET['id'];
       
      $fee = "SELECT * FROM bank_fee WHERE id = '$id'";
      $exefee = mysqli_query($conn, $fee);
      $datafee = mysqli_fetch_array($exefee);
      $bank_name = $datafee['name'];
      $bank_fee = $datafee['fee'];
      
?>


<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">

			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Edit Fees:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">


					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Bank Name:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" class="form-control" value="<?php echo $bank_name ?>" readonly>
						</div>
					</div>



					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Bank Charges:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="fee" class="form-control" placeholder="Enter Fee:" value="<?php echo $bank_fee ?>" required/>
						</div>
					</div>
                    
                    <br>
                    
                    <div class="row">
						<div class="col-lg-12" align="center">
					       <?php if(isset($messg)){ echo $messg; } ?>
                            <input type="submit" name="submit" value="Update" class="btn btn-lg btn-block btn-primary" >
						</div>
					</div>
                
                </form>
				<hr>

			<!-- form request code -->
		<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	$bank_fee = $_POST['fee'];

        	$query = "UPDATE `bank_fee` SET `fee`='$bank_fee' WHERE `id`='$id'";

        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header('Location:bankfee.php?update=success');

	
				}

        } 

        ?>

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