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

 $query1 = "SELECT * FROM `posts` WHERE `pid` = '$id' ";   

$exe1 = mysqli_query($conn,$query1);
$rows1 = mysqli_fetch_array($exe1);
$rowcount1 = mysqli_num_rows($exe1);

if($rowcount1 == 1)
{
	$s = $rows1['name'];
	$f = $rows1['gender'];
	$a = $rows1['bps'];
    $abb = $rows1['abv'];
}	


?>

<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
		
			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Edit Post:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">


					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Name:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="post" class="form-control" <?php if(isset($s)){ ?> value="<?php  echo $s ?>" <?php } ?> required/>
						</div>
					</div>
                    <br>
                    <div class="row">
						<div class="col-lg-3" align="right">
							<label>Abbreviation:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="abb" class="form-control" <?php if(isset($s)){ ?> value="<?php  echo $abb ?>" <?php } ?> maxlength="3" required />
						</div>
					</div>


					<br>
					<div class="row">
												<div class="col-lg-3" align="right">
							<label>Gender:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input style="margin-right:2%" type="radio" name="gender" value="Male" <?php if(isset($f) && $f == "male"){  ?> checked <?php } ?> required/>Male
                            <input style="margin-left:5% ; margin-right:2%"  type="radio" value="Female" <?php if(isset($f) && $f == "female"){  ?> checked <?php } ?> name="gender" required/>Female
                            <input style="margin-left:5% ; margin-right:2%"  type="radio"  value="Both" <?php if(isset($f) && $f == "both"){  ?> checked  <?php } ?> name="gender"  required/>Both
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-lg-3" align="right">
							<label>BPS:</label>
						</div>
						<div class="col-lg-7" align="left">
				<div class="col-lg-6" align="left">
                            <select name="bps" class="form-control">
                             	<option value="15" <?php if(isset($a) && $a == "15"){  ?> selected  <?php } ?>>15</option>
								<option value="14" <?php if(isset($a) && $a == "14"){  ?> selected  <?php } ?>>14</option>
								<option value="13" <?php if(isset($a) && $a == "13"){  ?> selected  <?php } ?>>13</option>
								<option value="12" <?php if(isset($a) && $a == "12"){  ?> selected  <?php } ?>>12</option>
								<option value="11" <?php if(isset($a) && $a == "11"){  ?> selected  <?php } ?>>11</option>
								<option value="10" <?php if(isset($a) && $a == "10"){  ?> selected  <?php } ?>>10</option>
								<option value="9" <?php if(isset($a) && $a == "9"){  ?> selected  <?php } ?>>09</option>
								<option value="8" <?php if(isset($a) && $a == "8"){  ?> selected  <?php } ?>>08</option>
								<option value="7" <?php if(isset($a) && $a == "7"){  ?> selected  <?php } ?>>07</option>
								<option value="6" <?php if(isset($a) && $a == "6"){  ?> selected  <?php } ?>>06</option>
								<option value="5" <?php if(isset($a) && $a == "5"){  ?> selected  <?php } ?>>05</option>
								<option value="4" <?php if(isset($a) && $a == "4"){  ?> selected  <?php } ?>>04</option>
								<option value="3" <?php if(isset($a) && $a == "3"){  ?> selected  <?php } ?>>03</option>
								<option value="2" <?php if(isset($a) && $a == "2"){  ?> selected  <?php } ?>>02</option>
								<option value="1" <?php if(isset($a) && $a == "1"){  ?> selected  <?php } ?>>01</option>
                            </select>
						</div>
						</div>
					</div>


					<br>


					<div class="row">
						<div class="col-lg-12" align="center">
							
					<input type="submit" name="Save" value="UPDATE" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>




				</form>
				<hr>

			<!-- form request code -->
		<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            
        	$post1 = $_POST['post'];
        	$gen1 = strtolower($_POST['gender']);
        	$bps1 = $_POST['bps'];
            $abb = strtoupper($_POST['abb']);

        	$query = "UPDATE `posts` SET `name`='$post1',`gender`='$gen1',`bps`='$bps1', `abv`='$abb' WHERE `pid` = '$id'";
        	;

        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header("location:createpost.php"); 

	
				}

        } 

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