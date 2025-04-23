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
                    <div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>Region Contact:</label>
						</div>
						<div class="col-lg-8" align="left">
							<input type="text" class="form-control" name="contact">
						</div>
					</div>
                    <div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>Region Address:</label>
						</div>
						<div class="col-lg-8" align="left">
							<input type="text" class="form-control" name="address">
						</div>
					</div>
                    <div class="row" style="margin-bottom: 20px;">
						<input type="submit" class="btn btn-block btn-lg btn-primary" name="submit">
					</div>
                
                </form>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit']))
        {
            $region_name = $_POST['region_name'];
            $region_contact = $_POST['contact'];
            $region_address = $_POST['address'];
            $sqlinsert = "INSERT INTO `region_details`(`region_name`, `contact`, `address`) VALUES ('$region_name','$region_contact','$region_address')";
            $exeinsert = mysqli_query($conn, $sqlinsert);
        }
      
      $sqlshow = "SELECT * FROM `region_details`";
      $exeshow = mysqli_query($conn, $sqlshow);
      $exerows = mysqli_num_rows($exeshow);
      if($exerows > 0)
      {?>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3" align="right" float="right">
        <table class="table table-hover table-bordered">
            <tr>
                <th>Name</th>
                <th>Contact</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
        <?php
          while($datashow = mysqli_fetch_array($exeshow))
                {?>
                   <tr>
                       <td><?php echo $datashow['region_name']; ?></td>
                       <td><?php echo $datashow['contact']; ?></td>
                       <td><?php echo $datashow['address']; ?></td>
                       <td style="text-align: center;"><a href="editregdetail.php?id=<?=$datashow['id']?>">Edit</a> &iota; <a href="deleteregdetail.php?id=<?=$datashow['id']?>" onclick="return confirm('Are you sure to delete?')">Delete</td>
                    </tr>
            
                <?php
                }
                ?>
    </table>
            </div>
            </div>
        <?php
      }

    ?>
    </div>

				
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, 'region_setting.php' );
    }
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