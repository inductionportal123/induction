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
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - Applications</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
<?php include('header.php');  ?>
<div id="sidebar-collapse" class="col-sm-3 col-lg-3 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="image/logo.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo $user ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
			<li><a href="admissiondate.php"><em class="fa fa-book">&nbsp;</em> Induction Settings</a></li>
			<li><a href="region.php"><em class="fa fa-globe">&nbsp;</em> Region Setting</a></li>
			<li><a href="district.php"><em class="fa fa-map-marker">&nbsp;</em> District Setting</a></li>
			<li><a href="centers.php"><em class="fa fa-university">&nbsp;</em> Centers</a></li>
            <li><a href="feeslot.php"><em class="fa fa-money">&nbsp;</em> Fee Slots</a></li>
            <li><a href="bankfee.php"><em class="fa fa-credit-card">&nbsp;</em> Bank Charges</a></li>
            <li><a href="createpost.php"><em class="fa fa-laptop">&nbsp;</em> Posts</a></li>
            <li><a href="category.php"><em class="fa fa-laptop">&nbsp;</em> Post Details</a></li>

			<li class="parent ">
                <a data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-navicon">&nbsp;</em> Quota <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
<!--
					<li><a class="" href="teachingquota.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Teaching/Non Teaching Staff
					</a></li>
-->
					<li><a class="" href="nonteachingquota.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Teaching/Non Teaching Staff
					</a></li>
					<li><a class="" href="lowerstaffquota.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Lower Staff
					</a></li>
				</ul>
			</li>
						<li class="parent ">
                <a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-dashboard">&nbsp;</em> Applications <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-2">
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
					<li><a class="" href="overage.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Over_Age Applications
					</a></li>
				</ul>
			</li>
<li><a href="query.php"><em class="fa fa-question-circle">&nbsp;</em> Queries</a></li>

			<li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div id="newtab">
		<h2>Recruitment Applications</h2>
		<div class="col-md-1"></div>
		<div class="col-md-2">
			<a href="allapplication.php" >
                <figure><img src="image/full.png" width="120px" height="110px"><figcaption>All Applications</figcaption>
              </figure></a>
		</div>
		<div class="col-md-2">
			<a href="approvedemp.php">
                <figure><img src="image/approve.png" width="120px" height="110px"><figcaption>Approved Applications</figcaption>
              </figure></a>
		</div>
		<div class="col-md-2">
			<a href="#">
                <figure><img src="image/reject.png" width="120px" height="110px"><figcaption>Rejected Applications</figcaption>
              </figure></a>
		</div>
		<div class="col-md-2">
			<a href="#">
                <figure><img src="image/pending.png" width="120px" height="110px"><figcaption>Pending Applications</figcaption>
              </figure></a>
		</div>
		<div class="col-md-2">
			<a href="overage.php">
                <figure><img src="image/pending.png" width="120px" height="110px"><figcaption>Over_Age Applications</figcaption>
              </figure></a>
		</div>
		<div class="col-md-1"></div>

	</div>
	</div>
    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
<!-- 	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script> -->
</body>
</html>

<?php
mysqli_close($conn);

}

else{
  header("Location: index.php");
}

?>