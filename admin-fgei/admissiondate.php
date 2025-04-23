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
	
	
		if ($user=='super-admin')
   		{
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - Inductions</title>
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

$query = "SELECT * FROM  `registrationdate` WHERE sid = '$userid'";
$exe = mysqli_query($conn,$query);
$row = mysqli_fetch_array($exe);
$rowcount = mysqli_num_rows($exe);

if($rowcount==1){
  $data = "ok";
  $sdate = $row['start_date'];
  $edate = $row['end_date'];
    $year = $row['year'];
    $post = $row['no_of_post'];
} 

?>



<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
			
			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;margin-bottom: 20px;">Induction Settings</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">
                    
					<div class="row">
						<div class="col-lg-5" align="right">
							<label>Year:</label>
						</div>
						<div class="col-lg-7" align="left">
                            <select name="year" class="form-control">
                              <option value="2020-2021">2020-2021</option>
                              <option value="2021-2022">2021-2022</option>
                              <option value="2022-2023">2022-2023</option>
                              <option value="2023-2024">2023-2024</option>
                              <option value="2024-2025">2024-2025</option>
                              <option value="2025-2026">2025-2026</option>
                              <option value="2026-2027">2026-2027</option>
                              <option value="2027-2028">2027-2028</option>
                              <option value="2028-2029">2028-2029</option>
                              <option value="2029-2030">2029-2030</option>
                              <option value="2030-2031">2030-2031</option>
                              <option value="2031-2032">2031-2032</option>
                                <option value="2033-2033">2032-2033</option>
                            </select>
                            
                            
<!--							<input type="text" name="year" class="form-control" placeholder="Select Start Date:" <?php if(isset($sdate)){ ?> value="<?php  echo $year ?>" <?php } ?> required/>-->
						</div>
					</div>

                    <div class="row" style="margin-top:20px" >
						<div class="col-lg-5" align="right">
							<label>Total Posts Announced:</label>
						</div>
						<div class="col-lg-7" align="left">
							<input type="text" name="no_of_post" class="form-control" placeholder="Enter number of posts" <?php if(isset($sdate)){ ?> value="<?php  echo $post ?>" <?php } ?> required/>
						</div>
					</div>
                    
					<div class="row">
						<div class="col-lg-5" align="right">
							<label>Induction Start Date:</label>
						</div>
						<div class="col-lg-7" align="left">
							<input type="text" name="start" class="form-control" placeholder="Select Start Date:" <?php if(isset($sdate)){ ?> value="<?php  echo $sdate ?>" <?php } ?> required/>
						</div>
					</div>


					<div class="row">
						<div class="col-lg-5" align="right">
							<label>Induction End Date:</label>
						</div>
						<div class="col-lg-7" align="left">
							<input type="text" name="end" class="form-control" placeholder="Select End Date:" <?php if(isset($edate)){ ?> value="<?php  echo $edate ?>" <?php } ?>  required/>
						</div>
					</div>


					<br>
						
			<?php if(!isset($data)) { ?>
							<div class="row">
								<div class="col-lg-12" align="center">
							<?php if(isset($messg)){ echo $messg; } ?> 

							<input type="submit" name="submit" value="Submit"  class="btn btn-lg btn-block btn-primary">
								</div>
							</div>
			<?php  } else { ?>
							<div class="row">
								<div class="col-lg-12" align="center">
							<?php if(isset($messg)){ echo $messg; } ?> 

							<input type="submit" name="update" value="Update"  class="btn btn-lg btn-block btn-primary">
								</div>
							</div>
			<?php } ?>



				</form>
				<hr>

			<!-- form request code -->
		<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	$s_date = $_POST['start'];
        	$e_date = $_POST['end'];
            $year1 = $_POST['year'];
            $post1= $_POST['no_of_post']; 


       if(isset($_POST['submit'])){

        	$query = "INSERT INTO `registrationdate`(`start_date`, `end_date`, `sid`) VALUES ('$s_date','$e_date','$userid')";
        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header('Location:admissiondate.php');

	
				}

		} elseif(isset($_POST['update'])) {
			$query = "UPDATE `registrationdate` SET `start_date`='$s_date',`end_date`='$e_date' ,`no_of_post`='$post1' ,`year`='$year1'   WHERE sid = '$userid'";
        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
                    ?>
						<script>window.location="admissiondate.php";</script>
<?php
	
				}
		}



        } 

        ?>



			</div>
		</div>

		<div class="col-lg-3"></div>
	</div>
</div>



<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<script>
  $(document).ready(function(){
    var date_input=$('input[name="start"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
      format: 'yyyy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,
    });
  });
   $(document).ready(function(){
    var date_input=$('input[name="end"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    date_input.datepicker({
      format: 'yyyy-mm-dd',
      container: container,
      todayHighlight: true,
      autoclose: true,
    });
  });
</script>

    
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
   echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access of this page</div>';

}

}

else{
  header("Location: index.php");
}

?>