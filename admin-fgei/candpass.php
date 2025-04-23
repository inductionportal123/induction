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
							<h3 style="color: green;">Search Candidate</h3>
						</div>
				</div>


				<form class="form-group" action=" " method="post">
				<div class="row">
						<div class="col-lg-3" align="right">
							<label>Enter CNIC</label>
						</div>
						<div class="col-lg-9" align="left">
							<input type="text" name="cnic" class="form-control" placeholder="xxxxx-xxxxxxx-x" required/>
						</div>
					</div>
                    <br>
					<div class="row">
						<div class="col-lg-12" align="right">
                            <input type="submit" name="submit" value="Search" class="btn  btn-primary">
						</div>
					</div>
                </form>
                <hr>
            </div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        
        $cnic = $_POST['cnic'];
        $details = "SELECT * FROM per_info JOIN acount_details ON acount_details.cnic=per_info.contact_cnic WHERE per_info.contact_cnic='$cnic' AND acount_details.cnic='$cnic'";
        $exedetails = mysqli_query($conn, $details);
        $detrows = mysqli_num_rows($exedetails);
        if($detrows > 0)
        {
        while($rows = mysqli_fetch_array($exedetails))
        {
    ?>
            <div class="row col-lg-offset-4" >
                <h3 style="padding-left:13px ; font-family:Optima, sans-serif ; font-stretch: ultra-expanded"><b>Candidate Details</b></h3>
            </div>
            
    <div class="row col-lg-offset-4" >
        <div class="col-lg-5">
            <label>Name </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["basic_full_name"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>Father Name </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["basic_father_name"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>Date of Birth </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["basic_dob"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>Contact Landline </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["contact_phone_no"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>Contact Mobile </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["contact_mobile"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>CNIC </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["contact_cnic"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4 col-lg-offset-4">
        <div class="col-lg-5">
            <label>Email </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["contact_email"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>City </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["contact_city"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>Postal Address </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["contact_postal_address"];?>
        </div>
    </div>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>Permanent Address </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["contact_per_address"];?>
        </div>
    </div>
    <hr>
    <div class="row col-lg-offset-4">
        <div class="col-lg-5">
            <label>Password </label>
        </div>
        <div class="col-lg-5">
            <?php echo $rows["password"];?>
        </div>
    </div>
    <?php
        }
        }
        else{
            ?>
            <div class="row col-lg-offset-4">
            <h5>Record Not Found</h5>
    </div>
        <?php
        }
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