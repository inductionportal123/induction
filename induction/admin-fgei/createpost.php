<?php
include('../connection/conn.php');

$professional_degree_required = '';
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
	
	if ($user=='super-admin' || $user=='aoi-3')
   		{
	
	
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - Create Posts</title>
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



<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
			<div id="ui">

				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Create Posts:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">

                    <div class="row">
						<div class="col-lg-3" align="right">
							<label>Category:</label>
						</div>
						
				<div class="col-lg-6" align="left">
                            <select name="cat" class="form-control" style="width: 156% ; margin-bottom:10px">
                              <option value="1">NonTeaching Staff (BPS 6-15)</option>
							  <option value="3">Teaching Staff (BPS 6-17)</option>
                                <option value="2">Class IV (BPS 1-5)</option>
                            </select>
						</div>
						
					</div>
                    
					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Name:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="post1" class="form-control" placeholder="Enter Post Name:" required/>
						</div>
					</div>
<br>
                    <div class="row">
						<div class="col-lg-3" align="right">
							<label>Abbreviation:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="abb" class="form-control" placeholder="Enter Post Abbreviation:"  maxlength="3" required/>
						</div>
					</div>
					<br>
                    
					<div class="row">
												<div class="col-lg-3" align="right">
							<label>Gender:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input style="margin-right:2%" type="radio" name="gender" value="Male" required/>Male
                            <input style="margin-left:5% ; margin-right:2%"  type="radio" value="Female" name="gender" required/>Female
                            <input style="margin-left:5% ; margin-right:2%"  type="radio"  value="Both"  name="gender"  required/>Both
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
							<option value="17">17</option>
							<option value="16">16</option>
                              <option value="15">15</option>
                              <option value="14">14</option>
                              <option value="13">13</option>
                              <option value="12">12</option>
                              <option value="11">11</option>
                              <option value="10">10</option>
                              <option value="9">09</option>
                              <option value="8">08</option>
                              <option value="7">07</option>
                              <option value="6">06</option>
                              <option value="5">05</option>
                              <option value="4">04</option>
                                <option value="3">03</option>
                                <option value="2">02</option>
                                <option value="1">01</option>
                            </select>
						</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Is Professional Qualification Required::</label>
						</div>
						<div class="col-lg-7" align="left">
				<div class="col-lg-6" align="left">
                            <input type="checkbox" name='professional_degree_required'  value="1">
						</div>
						</div>
					</div>
					<div></div>


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
            $abb = strtoupper($_POST['abb']);
            $cat = $_POST['cat'];
        	$p_name = $_POST['post1'];
        	$p_bps = strtolower($_POST['bps']);
        	$p_gender = strtolower($_POST['gender']);


			@$professional_degree_required = strtolower($_POST['professional_degree_required']);

			 if(empty($professional_degree_required)){
				$query = "INSERT INTO posts(cat,name,abv, gender, bps) VALUES ('$cat','$p_name','$abb','$p_gender','$p_bps')";
				$exe = mysqli_query($conn,$query);
			 }
			 else{
        	$query = "INSERT INTO posts(cat,name,abv, gender, bps,professional_degree_required) VALUES ('$cat','$p_name','$abb','$p_gender','$p_bps','$professional_degree_required')";
			$exe = mysqli_query($conn,$query);
			 }
        		if(!$exe)
				{
						die(mysqli_error($conn));
				}

        } 

        ?>

<?php


        	$query2 = "SELECT * FROM `posts` ORDER BY pid ASC ";

        	$exe2 = mysqli_query($conn,$query2);
			$rowcount2 = mysqli_num_rows($exe2);

			if ($rowcount2 > 0)
			{


?>

       <table class="table table-bordered table-hover" width="100%">
                          <tr>
                            <th style="text-align: center;">Category</th>
                            <th style="text-align: center;">Posts</th>
                              <th style="text-align: center;">Abv</th>  
                            <th style="text-align: center;">Action</th>
                           </tr>
       



<?php

 while ($rows = mysqli_fetch_array($exe2))
{
?>

                          <tr>
             <td style="text-align: center;">
			 <?php if($rows['cat'] == 1){echo "NonTeaching";}
			 elseif($rows['cat'] == 3){echo "Teaching";}
			 
			 else{echo "Class-IV";}


                            ?>
							
						
						
						
						
						</td>

                              
							<td style="text-align: center;"><?php echo $rows['name']; echo ' (BPS-'. $rows['bps']; echo ') - '.ucfirst($rows['gender']);   ?></td>
                              
                              <td style="text-align: center;"><?php echo $rows['abv']; ?></td>


                            <td style="text-align: center;"><a href="editposts.php?id=<?=$rows['pid']?>">Edit</a> &iota; <a href="deleteposts.php?id=<?=$rows['pid']?>" onclick="return confirm('Are you sure to delete?')">Delete</td>
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