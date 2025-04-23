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
	<title>Admin - Reports</title>
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
<!--
					<li><a class="" href="pending.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Pending Applications
					</a></li>
-->
<!--
					<li><a class="" href="overage.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Over_Age Applications
					</a></li>
-->
				</ul>
			</li>

<li><a href="query.php"><em class="fa fa-question-circle">&nbsp;</em> Queries</a></li>
                    <li class="active"><a href="report.php"><em class="fa fa-list-ol">&nbsp;</em> Report</a></li>
            <li><a href="centerallot.php"><em class="fa fa-university">&nbsp;</em> Center Allotment</a></li>
<li><a href="schedule.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Test Schedule</a></li>
            <li><a href="interviewslots.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Interview Schedule</a></li>
            <li><a href="importresult.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Import Result</a></li>
			<li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    
    <div class="row">
        <div class="col-lg-12" align="center">
            <h3 style="color: green;margin-bottom: 20px;">Reports</h3>
        </div>
    </div>
    
    <form class="form-group" action="" method="POST">
        <div class="row">
            <div class="col-lg-5" align="right">
				<label>Filter By:</label>
            </div>
            <div class="col-lg-3" align="left">
                <select name="filter" class="form-control">
                    <option value="region">Region</option>
                    <option value="district">District</option>
                    <option value="centes">Center</option>
                </select>
            </div>
            <div class="col-lg-3" align="right" style=" border:px solid black ">
                <input type="submit" name="submit1" value="Show Results" class="btn btn-lg btn-block btn-primary">
            </div>
        </div>
    </form>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['submit1']) )
    {
        $filter = $_POST['filter'];
    ?>
    
    <form class="form-group" action="" method="post">
        <div class="row">
            <div class="col-lg-5" align="right">
                <label>Select :</label>
            </div>
            <div class="col-lg-3" align="left" >
                <select class="form-control" name="district" required>
                    <option value="" selected>Select Post</option>
                    <?php
                        $newquery = "SELECT * FROM `$filter` ";
                        $newdatas = mysqli_query($conn,$newquery);
                        $newrowct = mysqli_num_rows($newdatas);
                        while ($newrowss = mysqli_fetch_array($newdatas)){
                    ?>
                    <option value="<?php $newrowss['id']; ?>"><?php echo $newrowss['name'] ?></option>
                    <?php
        }
                    ?>
                </select>
            </div>
            <div class="col-lg-3" align="right" style=" border:px solid black ">
                <input type="submit" name="submit2" value="Show Records" class="btn btn-lg btn-block btn-primary">
            </div>
        </div>
    </form>
    <?php
  }
    ?>
    
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