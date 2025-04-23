<?php
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
	<title>Admin - Create Users</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
<?php 
      include('header.php');  
       
    ?>
   <div id="sidebar-collapse" class="col-sm-3 col-lg-3 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="image/logo.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo strtoupper($user) ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-navicon">&nbsp;</em> General Settings <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
                    <li class="active"><a href="admissiondate.php"><em class="fa fa-book">&nbsp;</em> Induction Settings</a></li>
					<li><a href="region.php"><em class="fa fa-globe">&nbsp;</em> Region Setting</a></li>
                    <li><a href="region_setting.php"><em class="fa fa-globe">&nbsp;</em> Region Details</a></li>
                    <li><a href="district.php"><em class="fa fa-map-marker">&nbsp;</em> District Setting</a></li>   <li><a href="bankfee.php"><em class="fa fa-credit-card">&nbsp;</em> Bank Charges</a></li>
                    <li><a href="centers.php"><em class="fa fa-university">&nbsp;</em> Centers</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-navicon">&nbsp;</em> Post Settings <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-2">
                    <li><a href="createpost.php"><em class="fa fa-laptop">&nbsp;</em> Posts</a></li>
                    <li><a href="category.php"><em class="fa fa-laptop">&nbsp;</em> Post Details</a></li>
					<li><a href="feeslot.php"><em class="fa fa-money">&nbsp;</em> Fee Slots</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-3">
				<em class="fa fa-navicon">&nbsp;</em> Quota Settings <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-3">
                    <li><a class="" href="nonteachingquota.php"><span class="fa fa-arrow-right">&nbsp;</span> Teaching/Non Teaching Staff</a></li>
					<li><a class="" href="lowerstaffquota.php"><span class="fa fa-arrow-right">&nbsp;</span> Lower Staff</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-4">
				<em class="fa fa-navicon">&nbsp;</em> Applications <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-4">
					<li><a class="" href="allapplication.php">
						<span class="fa fa-arrow-right">&nbsp;</span> All Applications
					</a></li>
					<li><a class="" href="approvedemp.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Approved Applications
					</a></li>
					<li><a class="" href="rejected.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Rejected Applications
					</a></li>
                    <li><a class="" href="pending.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Pending Applications
					</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a  data-toggle="collapse" href="#sub-item-5">
				<em class="fa fa-navicon">&nbsp;</em> Reports <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-5">
					<li><a href="summaryreport.php"><em class="fa fa-list-ol">&nbsp;</em> Report</a></li>
                    <li><a href="center_report.php"><em class="fa fa-list-ol">&nbsp;</em> Center Report</a></li>
				</ul>
			</li>
            <li><a href="centerallot.php"><em class="fa fa-university">&nbsp;</em> Center Allotment</a></li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-6">
				<em class="fa fa-navicon">&nbsp;</em> Test/Interview Scheduling<span data-toggle="collapse" href="#sub-item-6" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-6">
                    <li><a href="schedule.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Test Schedule</a></li>
                    <li><a href="interviewslots.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Interview Schedule</a></li>
				</ul>
			</li>
            <li><a href="importresult.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Selected Candidates</a></li>
            <li><a href="import_result.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Results</a></li>
            <li class="active"><a href="createusers.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Manage Users</a></li>
            <li><a href="passwordchange.php"><i class="fa fa-key" aria-hidden="true"></i>
 Change Password</a></li>
            <li><a href="query.php"><em class="fa fa-question-circle">&nbsp;</em> Queries</a></li>
            <li><a href="message.php"><em class="fa fa-question-circle">&nbsp;</em> Announcements</a></li>
            <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
   
   


<div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-3"></div>

		<div class="col-lg-6">
			<div id="ui">

				<div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Create Users:</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">
				<div class="row">
						<div class="col-lg-3" align="right">
							<label>Name:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="name1" class="form-control" placeholder="Enter Name:" required/>
						</div>
					</div>
<br>

        										
                    
					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Password:</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="password" name="pass1" class="form-control" placeholder="Enter Password:" required/>
						</div>
					</div>
						
					<br>
					<div class="row">
						<div class="col-lg-3" align="right">
							<label>Role:</label>
						</div>
						<div class="col-lg-6" align="left">
				<div class="col-lg-9" align="left">
                            <select name="role" class="form-control" required>
                           	  <option value="">Select Role</option>
                              <option value="Admin">Admin</option>
                              <option value="Editor">Editor</option>
                              <option value="Read Only">Read Only</option>
                              
                            </select>
						</div>
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
            $name1 = $_POST['name1'];
            $pass1 = $_POST['pass1'];
        	$role = $_POST['role'];

        	$query = "INSERT INTO `admin`(`name`,`pass`,`role`) VALUES ('$name1','$pass1','$role')";

        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}

        } 

        ?>

<?php


        	$query2 = "SELECT * FROM `admin` ORDER BY id ASC ";

        	$exe2 = mysqli_query($conn,$query2);
			$rowcount2 = mysqli_num_rows($exe2);

			if ($rowcount2 > 0)
			{


?>

       <table class="table table-bordered table-hover" width="100%">
                          <tr>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Changed On</th>
                            <th style="text-align: center;">IP</th>
                              <th style="text-align: center;">Role</th>
                              
                            <th style="text-align: center;">Action</th>
                           </tr>
       



<?php

 while ($rows = mysqli_fetch_array($exe2))
{
?>

                          <tr>
                            <td style="text-align: center;"><?php echo $rows['name']; ?></td>
                              
							<td style="text-align: center;"><?php echo $rows['timepc']; ?></td>

							<td style="text-align: center;"><?php echo $rows['ip']; ?></td>
                              
                              <td style="text-align: center;"><?php echo $rows['role']; ?></td>

                            <td style="text-align: center;"><a href="editusers.php?id=<?=$rows['id']?>">Edit</a> &iota; <a href="deleteusers.php?id=<?=$rows['id']?>" onclick="return confirm('Are you sure to delete?')">Delete</td>
                           </tr>

<?php
}
}
?>
 </table>


			</div>
		</div>

		<div class="col-lg-3" style="margin-top:60px"><a class="btn btn-primary" href="candpass.php" >Search Candidate</a></div>
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