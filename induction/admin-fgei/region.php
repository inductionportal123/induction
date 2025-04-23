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
	<title>Admin - Region</title>
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



<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Regions:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">


					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Name:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="rg" class="form-control" placeholder="Enter Region Name:" required/>
						</div>
					</div>



					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Status:</label>
						</div>
						<div class="col-lg-9" align="left" > 
							<select class="form-control" name="sta" required/>
								<option value="active">Active</option>
								<option value="deactive">Deactive</option>
							</select>
						</div>
					</div>




					<br>


					<div class="row">
						<div class="col-lg-12" align="center">
					<?php if(isset($messg)){ echo $messg; } ?> 
							
					<input type="submit" name="submit" value="Save" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>
				</form>
				<hr>

			<!-- form request code -->
		<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
      
        	$slot_rg = $_POST['rg'];
        	$slot_status = strtolower($_POST['sta']);

        	$query = "INSERT INTO `region`(`name`, `status`) VALUES ('$slot_rg','$slot_status')";

        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header('Location:region.php?insert=success');

	
				}

        } 

        ?>

<?php


        	$query2 = "SELECT * FROM `region` ORDER BY id ASC ";

        	$exe2 = mysqli_query($conn,$query2);
			$rowcount2 = mysqli_num_rows($exe2);

			if ($rowcount2 > 0)
			{


?>

       <table class="table table-bordered" width="100%">
                          <tr>
                            <th style="text-align: center;">Region Name</th>
                            <th style="text-align: center;">Status</th>
                            <th style="text-align: center;">Action</th>
                           </tr>
       



<?php

 while ($rows = mysqli_fetch_array($exe2))
{
?>

                          <tr>

							<td style="text-align: center;"><?= strtoupper($rows['name']) ?></td>
							<td style="text-align: center;"><?= ucfirst($rows['status']) ?></td>
                            <td style="text-align: center;"><a href="editregion.php?id=<?=$rows['id']?>">Edit</a> &iota; <a href="deleteregion.php?id=<?=$rows['id']?>" onclick="return confirm('Are you sure to delete?')">Delete</td>
                           </tr>

<?php
}
}
?>
 </table>


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
   echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access of this page</div>';

}
}

else{
  header("Location: index.php");
}

?> 