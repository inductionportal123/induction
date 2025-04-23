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
	<title>Admin - Centers</title>
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


?>



<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
			<div id="ui">
				


				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;margin-bottom: 15px;">Test Centers Setting</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">

					<div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>District Name:</label>
						</div>
						<div class="col-lg-8" align="left">
							<select class="form-control" name="dis" required/>
							
							
								<option value="" selected>Select Your District</option>
							 
							<?php

             				$newquery = "SELECT `name` FROM `district` ORDER BY id ASC;";
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


					<div class="row">
						<div class="col-lg-4" align="right">
							<label>Center Name:</label>
						</div>
						<div class="col-lg-8" align="left">
							<input type="text" name="cent" class="form-control" placeholder="Enter Center Name:" required/>
						</div>
					</div>
                    					<br>

                	<div class="row">
						<div class="col-lg-4" align="right">
							<label>Total Seats:</label>
						</div>
						<div class="col-lg-8" align="left">
							<input type="number" name="seat" class="form-control" min="0" max="99999" placeholder="Enter Total Seats" required/>
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
        	$center_name = strtolower($_POST['cent']);
        	$district_name = strtolower($_POST['dis']);
			$seat = strtolower($_POST['seat']);

        	$query = "INSERT INTO `centes`(`district`, `center`,`seat`)VALUES ('$district_name ','$center_name',$seat)";

        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header('Location:centers.php?insert=success');

	
				}

        } 

        ?>

<?php


        	$query2 = "SELECT * FROM `centes` ORDER BY id ASC ";

        	$exe2 = mysqli_query($conn,$query2);
			$rowcount2 = mysqli_num_rows($exe2);

			if ($rowcount2 > 0)
			{


?>

       <table class="table table-bordered" width="100%">
                          <tr>
                            <th style="text-align: center;">District Name</th>
                            <th style="text-align: center;">Center Name</th>
                            <th style="text-align: center;">Total Seats</th>
                              <th style="text-align: center;">Action</th>
                           </tr>
       



<?php

        if (isset($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
        } else {
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;

        $total_pages_sql = "SELECT COUNT(*) FROM `centes`";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM `centes` LIMIT $offset, $no_of_records_per_page";
        $res_data = mysqli_query($conn,$sql);
        while($rows = mysqli_fetch_array($res_data)){
?>
                          <tr>
							<td style="text-align: center;"><?= strtoupper($rows['district']) ?></td>

							<td style="text-align: center;"><?= strtoupper($rows['center']) ?></td>
                			<td style="text-align: center;"><?= strtoupper($rows['seat']) ?></td>
                            <td style="text-align: center;"><a href="deletecenter.php?id=<?=$rows['id']?>" onclick="return confirm('Are you sure to delete?')">Delete</td>
                           </tr>
                          
      

<?php
}
}
?>
 </table>
		<ul class="pagination">
        <li><a href="?pageno=1">First</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>	


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