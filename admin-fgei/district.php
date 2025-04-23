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
							<h3 style="color: green;margin-bottom: 15px;">District Name:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">

					<div class="row" style="margin-bottom: 20px;">
						<div class="col-lg-4" align="right">
							<label>Region Name:</label>
						</div>
						<div class="col-lg-8" align="left">
							<select class="form-control" name="reg" required/>
							
							
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
							<label>Province:</label>
						</div>
						<div class="col-lg-8" align="left">
							<select class="form-control" name="province" required>
							<?php
                                            
                                            $querys = "SELECT * FROM province";
                                            $datas = mysqli_query($conn,$querys);
                                            $rowcounts = mysqli_num_rows($datas);
                                            if($rowcounts>0)
                                            {
                                                while ($rowss = mysqli_fetch_array($datas))
                                                {
                                                    ?>
                                                    <option value="<?=$rowss['id']?>"><?= ucfirst($rowss['name'])?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
							</select>
						</div>
					</div>
                


					<div class="row">
						<div class="col-lg-4" align="right">
							<label>District Name:</label>
						</div>
						<div class="col-lg-8" align="left">
							<input type="text" name="dist" class="form-control" placeholder="Enter District Name:" required/>
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
            $province = strtolower($_POST['province']);
        	$distname = strtolower($_POST['dist']);
        	$regionname = strtolower($_POST['reg']);

        	$query = "INSERT INTO `district`(`province`,`name`,`region`) VALUES ('$province' ,'$distname','$regionname')";

        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header('Location:district.php?insert=success');

	
				}

        } 

        ?>

<?php


        	$query2 = "SELECT * FROM `district` ORDER BY id ASC ";

        	$exe2 = mysqli_query($conn,$query2);
			$rowcount2 = mysqli_num_rows($exe2);

			if ($rowcount2 > 0)
			{


?>

       <table class="table table-bordered" width="100%">
                          <tr>
                            <th style="text-align: center;">Region Name</th>
                              <!-- <th style="text-align: center;">Province</th> -->
                            <th style="text-align: center;">District Name</th>
                            <th style="text-align: center;">Action</th>
                           </tr>
       



<?php

 while ($rows = mysqli_fetch_array($exe2))
{
?>

                          <tr>
							<td style="text-align: center;"><?= strtoupper($rows['region']) ?></td>
                            <!-- <td style="text-align: center;"><?= strtoupper($rows['province']) ?></td> -->
							<td style="text-align: center;"><?= strtoupper($rows['name']) ?></td>
                            <td style="text-align: center;"><a href="deletedistrict.php?id=<?=$rows['id']?>" onclick="return confirm('Are you sure to delete?')">Delete</td>
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
  header("Location: index.php");
}

?>