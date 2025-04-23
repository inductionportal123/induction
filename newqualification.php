<?php

$undertaking = '';
include('connection/conn.php');
if (!isset($_SESSION)) {
session_start();
}


    // Set the session timeout period (in seconds)
$timeout = 3 * 60; // 15 minutes

// Check if the session has timed out
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    // If session has expired, destroy the session and redirect to the login page
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();


if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
$user = $_SESSION['u_name'];
$userid = $_SESSION['u_id'];

$query = "SELECT * FROM `per_info` WHERE said = '" . $userid . "'";
$exes = mysqli_query($conn, $query);
$rows = mysqli_fetch_array($exes);
$rowcounts = mysqli_num_rows($exes);
if ($rowcounts == 1) {
$undertaking = $rows['undertaking'];
}


$que = "SELECT * FROM `qualification` WHERE said = '" . $userid . "'";
$ex = mysqli_query($conn, $que);
$ro = mysqli_fetch_array($ex);
$rowcount = mysqli_num_rows($ex);

if ($rowcount == 1) {
$datast = "ok";


$primary_title = $ro['primary_title'];
$primary_specialization = $ro['primary_specialization'];
$primary_result_date = $ro['primary_result_date'];
$primary_obtained_marks = $ro['primary_obtained_marks'];
$primary_total_marks = $ro['primary_total_marks'];
$primary_percent = $ro['primary_percent'];
$primary_board = $ro['primary_board'];


$middle_title = $ro['middle_title'];
$middle_specialization = $ro['middle_specialization'];
$middle_result_date = $ro['middle_result_date'];
$middle_obtained_marks = $ro['middle_obtained_marks'];
$middle_total_marks = $ro['middle_total_marks'];
$middle_percent = $ro['middle_percent'];
$middle_board = $ro['middle_board'];



$matric_title = $ro['matric_title'];
$matric_specialization = $ro['matric_specialization'];
$matric_result_date = $ro['matric_result_date'];
$matric_obtained_marks = $ro['matric_obtained_marks'];
$matric_total_marks = $ro['matric_total_marks'];
$matric_percent = $ro['matric_percent'];
$matric_board = $ro['matric_board'];


$inter_title = $ro['inter_title'];
$inter_specialization = $ro['inter_specialization'];
$inter_result_date = $ro['inter_result_date'];
$inter_obtained_marks = $ro['inter_obtained_marks'];
$inter_total_marks = $ro['inter_total_marks'];
$inter_percent = $ro['inter_percent'];
$inter_board = $ro['inter_board'];

$bs_title = $ro['bs_title'];
$bs_specialization = $ro['bs_specialization'];
$bs_result_date = $ro['bs_result_date'];
$bs_obtained_marks = $ro['bs_obtained_marks'];
$bs_total_marks = $ro['bs_total_marks'];
$bs_percent = $ro['bs_percent'];
$bs_board = $ro['bs_board'];


$bs16_title = $ro['bs16_title'];
$bs16_specialization = $ro['bs16_specialization'];
$bs16_result_date = $ro['bs16_result_date'];
$bs16_obtained_marks = $ro['bs16_obtained_marks'];
$bs16_total_marks = $ro['bs16_total_marks'];
$bs16_percent = $ro['bs16_percent'];
$bs16_board = $ro['bs16_board'];

$ms_title = $ro['ms_title'];
$ms_specialization = $ro['ms_specialization'];
$ms_result_date = $ro['ms_result_date'];
$ms_obtained_marks = $ro['ms_obtained_marks'];
$ms_total_marks = $ro['ms_total_marks'];
$ms_percent = $ro['ms_percent'];
$ms_board = $ro['ms_board'];

$diploma_title = $ro['diploma_title'];
$diploma_specialization = $ro['diploma_specialization'];
$diploma_result = $ro['diploma_result'];
$diploma_obtained_marks = $ro['diploma_obtained_marks'];
$diploma_total_marks = $ro['diploma_total_marks'];
$diploma_percent = $ro['diploma_percent'];
$diploma_board = $ro['diploma_board'];

$profes_certificate = $ro['profes_certificate'];
$profes_result_date = $ro['profes_result_date'];
$profes_obtained_marks = $ro['profes_obtained_marks'];
$profes_total_marks = $ro['profes_total_marks'];
$profes_board = $ro['profes_board'];

$profes_certificate_two = $ro['profes_certificate_two'];
$profes_result_date_two = $ro['profes_result_date_two'];
$profes_obtained_marks_two = $ro['profes_obtained_marks_two'];
$profes_total_marks_two = $ro['profes_total_marks_two'];
$profes_board_two = $ro['profes_board_two'];

$profes_certificate_three = $ro['profes_certificate_three'];
$profes_result_date_three = $ro['profes_result_date_three'];
$profes_obtained_marks_three = $ro['profes_obtained_marks_three'];
$profes_total_marks_three = $ro['profes_total_marks_three'];
$profes_board_three = $ro['profes_board_three'];

$employ_organization = $ro['employ_organization'];
$employ_job_title = $ro['employ_job_title'];
$employ_from_date = $ro['employ_from_date'];
$employ_to_date = $ro['employ_to_date'];


$employ_organization_two = $ro['employ_organization_two'];
$employ_job_title_two = $ro['employ_job_title_two'];
$employ_from_date_two = $ro['employ_from_date_two'];
$employ_to_date_two = $ro['employ_to_date_two'];


$employ_organizatin_three = $ro['employ_organizatin_three'];
$employ_job_title_three = $ro['employ_job_title_three'];
$employ_from_date_three = $ro['employ_from_date_three'];
$employ_to_date_three = $ro['employ_to_date_three'];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<title>CCH Recruitment</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">


<!-- -------------------added by Hanzala css ----------  -->
<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/per_info.css">
		<link rel="stylesheet" href="css/Qualification.css">
		
		
		
		
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.7/js/tether.min.js"></script>


   <script>
        let timeout;

        // Set timeout period (in milliseconds, e.g., 15 minutes)
        const timeoutPeriod = 3 * 60 * 1000; // 15 minutes

        // Reset the timeout whenever there's user activity
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logout, timeoutPeriod);
        }

        // Logout function to redirect to the logout page
        function logout() {
            window.location.href = "logout.php";  // Redirect to logout page after timeout
        }

        // Start the timer initially
        resetTimer();
    </script>




</head>


     <!-- -------------- added this extra start  -------- -->
    <script>
        function closeNav() {
            document.getElementById("mysidebar").style.width = "0"

        }

        function openNav() {
            document.getElementById("mysidebar").style.width = "250px";
            
        }
    </script>
    <!-- -------------- added this extra start  -------- -->
    


<style>
		@media only screen and (max-width: 320px) {
		

			.container {
				padding-right: 0px;
				padding-left: 0px;



			}

			.sidebar {
				width: 0;
				position: fixed;
				z-index: 1;
				top: 0;
				left: 0;

				overflow-x: hidden;
				transition: 0.5s;
			}



			.sidebar a:hover {
				color: #f1f1f1;
			}

			.sidebar .closebtn {
				position: absolute;
				top: 0;
				right: 25px;
				font-size: 36px;
				margin-left: 50px;
			}

			.main_container .content {
				width: 100% !important;
			}


			.form-control {
				width: 100% !important;
			}

			.nav {
				width: 130%;
				margin: -25px;
				display: block;
			}

			kbd {
				background: #2d353c;
				padding: 0px 4px;
			}

			#acadid small {
				font-size: smaller;
				display: block;
				font-size: 7px;
			}

			#acadid th {
				font-size: 11px;
			}

			.col-xs-8 {
				width: 18.666667%;
			}



			.nav-pills>li {
				float: none;
				margin: 3px;
			}

			.tab-content {
				margin-left: -25px;

				width: 128%;
			}

			.heading {
				padding-top: 0 !important;
				font-size: 14px !important;
			}

			.nav-pills>li+li {
				margin-left: 0;
				font-size: 10px;
				width: auto;
			}

			b,
			strong {
				font-size: 10px;
			}

			textarea.form-control {
				height: 13vh;
			}

			.main_container {
				margin-top: 60px !important;
				margin-left: 0px !important;
				padding: 25px !important;
				width: 100% !important;
			}

			.nav-pills>li+li {
				margin-left: 0;
				font-size: 14px;
			}

			input#basic_info_form_btn {
				margin-left: -94px;
			}

			.top_navbar h3 {
				font-size: 9px;
			}

			.tab-content h6 {
				letter-spacing: 0px;
			}

			.col-xs-2 {
				margin-left: -33px;
			}
		}
	</style>
	
	

<body >

<div class="wrapper hover_collapse">
<?php include('header.php'); ?>
<div class="sidebar" id="mysidebar">
<div class="sidebar_inner">
<ul>
    
    
    
                            
                            
<li>
<img src="images/logo.png" width="70%" height="70%" style="margin:30px;">
</li>
<li>
<a href="profile.php">
<span class="icon"><i class="fas fa-user" title="profile"></i></span>
<span class="text">Profile</span>
</a>
</li>
<li>
<a href="per_info.php" style="background: #292323;">
<span class="icon"><i class="fas fa-edit" title="Personal Info"></i></span>
<span class="text">Personal Info</span>
</a>
</li>
<li>
<a href="resetpassword.php">
<span class="icon"><i class="fas fa-key" title="Reset Password"></i></span>
<span class="text">Reset Password</span>
</a>
</li>


<li>
<a href="queryportal.php">
<span class="icon"><i class="fas fa-comment" title="Query Portal"></i></span>
<span class="text">Query Portal</span>
</a>
</li>
<li>
<a href="logout.php">
<span class="icon"><i class="fas fa-sign-out-alt" title="Logout"></i></span>
<span class="text">Logout</span>
</a>
</li>
</ul>
</div>
</div>




    
    
    
    



<!-- --------------------------------------body working------------------------------------------ -->
<div class="main_container">
<div class="container">
<div class="content">
<div class="row">
<div class="col-sm-12 col-md-12 col-lg-12">
    
    
     <!-- -------------- added this extra start  -------- -->
                        <li class="closebtn"> <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                        <li>
                            <!-- -------------- added this extra end  -------- -->
                            
                            
    

    
<h2 class="heading">Registration Form</h2>
<br>
<!-- Nav pills -->
<ul class="nav nav-pills" role="tablist">
<li class="nav-item">
<a class="nav-link" href="per_info.php">Personal Info <br> ذاتی معلومات</a>
</li>
<li class="nav-item">
<a class="nav-link active" href="qualification.php">Qualification <br> قابلیت</a>
</li>
<li class="nav-item">
<a class="nav-link  " href="post_apply.php">Post Apply <br> پوسٹ اپلائی کریں۔</a>
</li>
<li class="nav-item">
<a class="nav-link" href="challan.php">Challan Form <br> چالان فارم</a>
</li>
<li class="nav-item">
<a class="nav-link" href="documents.php">Upload Documents <br> دستاویزات اپ لوڈ کریں۔</a>
</li>
<li class="nav-item">
<a class="nav-link" href="undertaking.php">Undertaking <br> انڈرٹیکنگ</a>
</li>
</ul>

<!-- Tab panes -->


<div class="tab-content container">
<br>
<form id="qualification_form">

<div class="row">
<div class="col-sm-10 col-xs-10 col-md-10 col-lg-10">
<h6><kbd>Academic Information:</kbd></h6>
</div>
<div class="col-sm-2 col-xs-2 col-md-2 col-lg-2"><sub class="fieldrequired"> *</sub> <b>Mandatory Fields</b> </div>
</div>


<div class="row">
<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
<table class="table table-responsive" id="acadid">
<thead>
<tr>
	<th>Level<small>Certificate/Degree</small></th>
	<th>Certificate/Degree<small>Choose from list or type</small></th>
	<th>Specialization<small>Choose from list or type</small></th>
	<!-- <th>Result<small>Declaration Date</small></th> -->
	<!-- <th>Obtained<small>Marks / CGPA</small></th> -->
	<th>Grade / CGPA <br><small></small></th>
	<!-- <th>Percentage<small>Write only Digit</small></th> -->
	<th>Board<small>University / Institute</small></th>
</tr>
</thead>

<tbody>


<!-- Primary Sections -->

<!--End  Primary Sections -->


<!-- End Middel Sections -->
<!-- matric Sections -->



<!-- End Matric Sections -->






<!-- BAchler 16 -->

<tr>
	<th scope="row">Bachelors(Hons)/Masters <small>(16 Years) <br> بیچلر (آنرز) / ماسٹر (16 سال)</small>
	</th>
	<td>


		<select name="bs16_title" id="Qualification_id" class="form-control">
			<option value="">--Select--</option>



			<?php


$querys = "SELECT * FROM qualification_category WHERE type = 'Bachelors16'";
$datas = mysqli_query($conn, $querys);
$rowcounts = mysqli_num_rows($datas);
if ($rowcounts > 0) {
	while ($rowss = mysqli_fetch_array($datas)) {
		// Check if the option ID matches the selected option in the per_info table
		$selected = ($rowss['id'] == $bs16_title) ? 'selected' : '';
?>
		<option value="<?= $rowss['id'] ?>" <?= $selected ?>><?= ucfirst($rowss['Qualification_category']) ?></option>
<?php
	}
}
 ?>

		</select>
	</td>
	
	
	<td><input type="text" name="bs16_specialization" value="<?php if (isset($bs16_specialization) && ($bs16_specialization != "NULL"))
 { echo $bs16_specialization; } ?>" id="inter_spec" class="form-control"></td>


	<!-- <td><input type="date" name="bs16_result_date" value="<?php if (isset($bs16_result_date) && ($bs_result_date != "NULL")) {
																	echo $bs16_result_date;
																} ?>" id="bs_result" class="form-control"></td> -->
	<!-- <td><input type="text" name="bs16_obtained_marks" value="<?php if (isset($bs16_obtained_marks) && ($bs16_obtained_marks != "NULL")) {
																		echo $bs16_obtained_marks;
																	} ?>" id="bs_obtained" class="form-control"></td> -->
	<td><input type="text" name="bs16_total_marks" value="<?php if (isset($bs16_total_marks) && ($bs16_total_marks != "NULL")) {
																echo $bs16_total_marks;
															} ?>" id="bs_total" class="form-control"></td>
	<!-- <td><input type="text" name="bs16_percent" value="<?php if (isset($bs16_percent) && ($bs16_percent != "NULL")) {
																echo $bs16_percent;
															} ?>" id="bs_percent" class="form-control"></td> -->
	<td><input type="text" name="bs16_board" value="<?php if (isset($bs16_board) && ($bs16_board != "NULL")) {
														echo $bs16_board;
													} ?>" id="bs_board" class="form-control"></td>

</tr>














<tr>
	<th scope="row">MS / M.Phill <small>(18 Years) <br> ایم ایس / ایم فل (18 سال)</small></th>
	<td>

	
		
		<select name="ms_title" id="Qualification_id" class="form-control">
			<option value="">--Select--</option>



			<?php


$querys = "SELECT * FROM qualification_category WHERE type = 'MS'";
$datas = mysqli_query($conn, $querys);
$rowcounts = mysqli_num_rows($datas);
if ($rowcounts > 0) {
	while ($rowss = mysqli_fetch_array($datas)) {
		// Check if the option ID matches the selected option in the per_info table
		$selected = ($rowss['id'] == $ms_title) ? 'selected' : '';
?>
		<option value="<?= $rowss['id'] ?>" <?= $selected ?>><?= ucfirst($rowss['Qualification_category']) ?></option>
<?php
	}
}
 ?>

		</select>
		
		
		



	</td>
	
	
	<td><input type="text" name="ms_spec" value="<?php if (isset($ms_specialization) && ($ms_specialization != "NULL"))
 { echo $ms_specialization; } ?>" id="ms_spec" class="form-control"></td>

 

	<!-- <td><input type="date" name="ms_result" value="<?php if (isset($ms_result_date) && ($ms_result_date != "NULL")) {
															echo $ms_result_date;
														} ?>" id="ms_result" class="form-control"></td> -->

	<!-- <td><input type="text" name="ms_obtained" value="<?php if (isset($ms_obtained_marks) && ($ms_obtained_marks != "NULL")) {
																echo $ms_obtained_marks;
															} ?>" id="ms_obtained" class="form-control"></td> -->

	<td><input type="text" name="ms_total" value="<?php if (isset($ms_total_marks) && ($ms_total_marks != "NULL")) {
														echo $ms_total_marks;
													} ?>" id="ms_total" class="form-control"></td>

	<!-- <td><input type="text" name="ms_percent" value="<?php if (isset($ms_percent) && ($ms_percent != "NULL")) {
																echo $ms_percent;
															} ?>" id="ms_percent" class="form-control"></td> -->

	<td><input type="text" name="ms_board" value="<?php if (isset($ms_board) && ($ms_board != "NULL")) {
														echo $ms_board;
													} ?>" id="ms_board" class="form-control"></td>

</tr>






<tr>
	<th>PHD <small> <br>PHD </small>

	</th>
	
	
	<td>
    <select name="Primary_title" id="Primary_id" onchange="prov()" class="form-control">
        <option value="">--Select--</option>

        <?php
        $querys = "SELECT * FROM qualification_category WHERE type = 'phd'";
		$datas = mysqli_query($conn, $querys);
		$rowcounts = mysqli_num_rows($datas);
		if ($rowcounts > 0) {
			while ($rowss = mysqli_fetch_array($datas)) {
				// Check if the option ID matches the selected option in the per_info table
				$selected = ($rowss['id'] == $primary_title) ? 'selected' : '';
		?>
				<option value="<?= $rowss['id'] ?>" <?= $selected ?>><?= ucfirst($rowss['Qualification_category']) ?></option>
		<?php
			}
		}

		 ?>
    </select>
</td>



<td><input type="text" name="Primary_specialization" value="<?php if (isset($primary_specialization) && ($primary_specialization != "NULL"))
 { echo $primary_specialization; } ?>" id="Primary_specialization" class="form-control"></td>



	<!-- <td><input type="date" name="primary_result_date" value="<?php if (isset($primary_result_date) && ($primary_result_date != "NULL")) {
																		echo $matric_result_date;
																	} ?>" id="matric_result" class="form-control"></td>

<td><input type="text" name="primary_obtained_marks" value="<?php if (isset($primary_obtained_marks) && ($primary_obtained_marks != "NULL")) {
		echo $primary_obtained_marks;
	} ?>" id="matric_obtained" class="form-control"></td> -->

	<td><input type="text" name="primary_total_marks" value="<?php if (isset($primary_total_marks) && ($primary_total_marks != "NULL")) {
																	echo $primary_total_marks;
																} ?>" id="matric_total" class="form-control"></td>

	<!-- <td><input type="text" name="primary_percent" value="<?php if (isset($primary_percent) && ($primary_percent != "NULL")) {
																	echo $primary_percent;
																} ?>" id="matric_percent" class="form-control"></td> -->

	<td><input type="text" name="primary_board" value="<?php if (isset($primary_board) && ($primary_board != "NULL")) {
															echo $primary_board;
														} ?>" id="matric_total" id="matric_board" class="form-control"></td>
</tr>





</tbody>
</table>
</div>
</div>



<div class="row">
<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
<h6><kbd>professional Qualification: پیشہ ورانہ اہلیت</kbd></h6>
</div>
</div>


<div class="row">
<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
<table class="table table-responsive" id="profid">
<thead>
<tr>
	<th>Sr.#</th>
	<th>Certificate/Diploma</th>
	<!-- <th>Result Declaration Date</th> -->
	<th>Obtained Marks</th>
	<th>Total Marks</th>
	<th>Board University</th>
</tr>
</thead>

<tbody>
    
<tr>
	<th>01</th>
	<td><input type="text" name="dip_name_one" value="<?php if (isset($profes_certificate)  && ($diploma_title != "NULL")) {
															echo $profes_certificate;
														} ?>" id="dip_name_one" class="form-control"></td>

	<!-- <td><input type="date" name="dip_result_one" value="<?php if (isset($profes_result_date)  && ($profes_result_date != "NULL")) {
																	echo $profes_result_date;
																} ?>" id="dip_result_one" class="form-control"></td> -->

	<td><input type="text" name="dip_obt_one" value="<?php if (isset($profes_obtained_marks)  && ($profes_obtained_marks != "NULL")) {
															echo $profes_obtained_marks;
														} ?>" id="dip_obt_one" class="form-control"></td>

	<td><input type="text" name="dip_total_one" value="<?php if (isset($profes_total_marks)  && ($profes_total_marks != "NULL")) {
															echo $profes_total_marks;
														} ?>" id="dip_total_one" class="form-control"></td>

	<td><input type="text" name="dip_board_one" value="<?php if (isset($profes_board)  && ($profes_board != "NULL")) {
															echo $profes_board;
														} ?>" id="dip_board_one" class="form-control"></td>
</tr>
<tr>
	<th scope="row">02</th>
	<td><input type="text" name="dip_name_two" value="<?php if (isset($profes_certificate_two)  && ($profes_certificate_two != "NULL")) {
															echo $profes_certificate_two;
														} ?>" id="dip_name_two" class="form-control"></td>

	<!-- <td><input type="date" name="dip_result_two" value="<?php if (isset($profes_result_date_two)  && ($profes_result_date_two != "NULL")) {
																	echo $profes_result_date_two;
																} ?>" id="dip_result_two" class="form-control"></td> -->

	<td><input type="text" name="dip_obt_two" value="<?php if (isset($profes_obtained_marks_two)  && ($profes_obtained_marks_two != "NULL")) {
															echo $profes_obtained_marks_two;
														} ?>" id="dip_obt_two" class="form-control"></td>

	<td><input type="text" name="dip_total_two" value="<?php if (isset($profes_total_marks_two)  && ($profes_total_marks_two != "NULL")) {
															echo $profes_total_marks_two;
														} ?>" id="dip_total_two" class="form-control"></td>

	<td><input type="text" name="dip_board_two" value="<?php if (isset($profes_board_two)  && ($profes_board_two != "NULL")) {
															echo $profes_board_two;
														} ?>" id="dip_board_two" class="form-control"></td>

</tr>
<tr>
	<th scope="row">03</th>
	<td><input type="text" name="dip_name_three" value="<?php if (isset($profes_certificate_three)  && ($profes_certificate_three != "NULL")) {
															echo $profes_certificate_three;
														} ?>" id="dip_name_three" class="form-control"></td>

	<!-- <td><input type="date" name="dip_result_three" value="<?php if (isset($profes_result_date_three)  && ($profes_result_date_three != "NULL")) {
																	echo $profes_result_date_three;
																} ?>" id="dip_result_three" class="form-control"></td> -->

	<td><input type="text" name="dip_obt_three" value="<?php if (isset($profes_obtained_marks_three)  && ($profes_obtained_marks_three != "NULL")) {
															echo $profes_obtained_marks_three;
														} ?>" id="dip_obt_three" class="form-control"></td>

	<td><input type="text" name="dip_total_three" value="<?php if (isset($profes_total_marks_three)  && ($profes_total_marks_three != "NULL")) {
																echo $profes_total_marks_three;
															} ?>" id="dip_total_three" class="form-control"></td>

	<td><input type="text" name="dip_board_three" value="<?php if (isset($profes_board_three)  && ($profes_board_three != "NULL")) {
																echo $profes_board_three;
															} ?>" id="dip_board_three" class="form-control"></td>

</tr>




</tbody>
</table>
</div>
</div>

<br>
<!-- <div class="row">
<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
<h6><kbd>employment record (if Any):</kbd></h6>
</div>
</div>

<div class="row">
<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
<table class="table table-responsive" id="profid" width="100%">
<thead>
<tr>
<th>Sr. #</th>
<th width="30%">Organitzation / Employer Name</th>
<th width="20%">Job Title</th>
<th>From Date </th>
<th>To Date</th>
</tr>
</thead>

<tbody>
<tr>
<th>01</th>
<td><input type="text" name="emp_name_one" value="<?php if (isset($employ_organization) && ($employ_organization != "NULL")) {
echo $employ_organization;
} ?>" id="emp_name_one" class="form-control"></td>

<td><input type="text" name="job_title_one" value="<?php if (isset($employ_job_title) && ($employ_job_title != "NULL")) {
echo $employ_job_title;
} ?>" id="job_title_one" class="form-control"></td>

<td><input type="date" name="from_date_one" value="<?php if (isset($employ_from_date) && ($employ_from_date != "NULL")) {
echo $employ_from_date;
} ?>" id="from_date_one" class="form-control"></td>

<td><input type="date" name="to_date_one" value="<?php if (isset($employ_to_date) && ($employ_to_date != "NULL")) {
echo $employ_to_date;
} ?>" id="to_date_one" class="form-control"></td>
</tr>
<tr>
<th scope="row">02</th>
<td><input type="text" name="emp_name_two" value="<?php if (isset($employ_organization_two) && ($employ_organization_two != "NULL")) {
echo $employ_organization_two;
} ?>" id="emp_name_two" class="form-control"></td>

<td><input type="text" name="job_title_two" value="<?php if (isset($employ_job_title_two) && ($employ_job_title_two != "NULL")) {
echo $employ_job_title_two;
} ?>" id="job_title_two" class="form-control"></td>

<td><input type="date" name="from_date_two" value="<?php if (isset($employ_from_date_two) && ($employ_from_date_two != "NULL")) {
echo $employ_from_date_two;
} ?>" id="from_date_two" class="form-control"></td>

<td><input type="date" name="to_date_two" value="<?php if (isset($employ_to_date_two) && ($employ_to_date_two != "NULL")) {
echo $employ_to_date_two;
} ?>" id="to_date_two" class="form-control"></td>

</tr>
<tr>
<th scope="row">03</th>
<td><input type="text" name="emp_name_three" value="<?php if (isset($employ_organizatin_three) && ($employ_organizatin_three != "NULL")) {
echo $employ_organizatin_three;
} ?>" id="emp_name_three" class="form-control"></td>

<td><input type="text" name="job_title_three" value="<?php if (isset($employ_job_title_three) && ($employ_job_title_three != "NULL")) {
	echo $employ_job_title_three;
} ?>" id="job_title_three" class="form-control"></td>

<td><input type="date" name="from_date_three" value="<?php if (isset($employ_from_date_three) && ($employ_from_date_three != "NULL")) {
	echo $employ_from_date_three;
} ?>" id="from_date_three" class="form-control"></td>

<td><input type="date" name="to_date_three" value="<?php if (isset($employ_to_date_three) && ($employ_to_date_three != "NULL")) {
echo $employ_to_date_three;
} ?>" id="to_date_three" class="form-control"></td>

</tr>
<tr style="display:none">
<th scope="row">04</th>
<td><input type="text" name="emp_name_four" value="<?php if (isset($employ_organizatin_four) && ($employ_organizatin_four != "NULL")) {
echo $employ_organizatin_four;
} ?>" id="emp_name_four" class="form-control"></td>

<td><input type="text" name="job_title_four" value="<?php if (isset($employ_job_title_four) && ($employ_job_title_four != "NULL")) {
echo $employ_job_title_four;
} ?>" id="job_title_four" class="form-control"></td>

<td><input type="date" name="from_date_four" value="<?php if (isset($employ_from_date_four) && ($employ_from_date_four != "NULL")) {
echo $employ_from_date_four;
} ?>" id="from_date_four" class="form-control"></td>

<td><input type="date" name="to_date_four" value="<?php if (isset($employ_to_date_four) && ($employ_to_date_four != "NULL")) {
echo $employ_to_date_four;
} ?>" id="to_date_four" class="form-control"></td>

</tr>


</tbody>
</table>
</div>
</div> -->
<div class="row">
<div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="left">
<div id="response"></div>
</div>
<div class="col-sm-4 col-xs-4 col-md-4 col-lg-4" align="right">
<?php
if ($undertaking == 1) { ?>
<p style="font-size: 16px; color: green; "><?php echo "Already Submitted"  ?></p>
<input type="button" class="btn btn-lg btn-info" style="margin-bottom: 10px;border: none; outline: none;" name="qual_btn" id="qual_btn" value="Save & Next" disabled>
<?php
} else {
?>
<input type="button" class="btn btn-lg btn-info" style="margin-bottom: 10px;border: none; outline: none;" name="qual_btn" id="qual_btn" value="Save & Next">
<?php
}
?>

</div>
</div>
</form>
</div>

</div>
</div>
</div>
</div>
</div>
</div>

<script src="script/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function() {
$("#qual_btn,#qual_btn_update").click(function() {


$.ajax({
url: "qualification_process.php",
type: "POST",
data: $('#qualification_form').serialize(),
beforesend: function() {

$('#response').fadeIn();
$('#response').removeClass('error-msg').addClass('process-msg').html("Processing....");
},
success: function(data) {
if (data == 1) {
window.location.replace("post_apply.php");
//  						window.location.href = "post_apply.php";  					
} else {
$('#response').fadeIn();
$('#response').addClass('error-msg').html(data);
}
}
});


});
});
</script>


<script>
$(document).ready(function() {
$("#Qualification_id").on('change', function() {
var countryid = $(this).val();

$.ajax({
method: "POST",
url: "admin-fgei/ajaxData.php",
data: {
id: countryid
},
dataType: "html",
success: function(data) {

$("#state").html(data);

$("#city").html(data);

}
});
});




// MS 

$("#ms_title").on('change', function() {
var ms_title = $(this).val();

$.ajax({
method: "POST",
url: "admin-fgei/ajaxData.php",
data: {
ms_title_id: ms_title
},
dataType: "html",
success: function(data) {

$("#ms_title_Spec").html(data);

$("#ms_title_SpecName").html(data);

}
});
});



// Intermediate

$("#Intermediate_id").on('change', function() {
var Intermediate_id = $(this).val();

$.ajax({
method: "POST",
url: "admin-fgei/ajaxData.php",
data: {
Intermediate: Intermediate_id
},
dataType: "html",
success: function(data) {

$("#Intermediate_Spec").html(data);

$("#Intermediate_title_SpecName").html(data);

}
});
});


// Metric

$("#matric_id").on('change', function() {
var matric_id = $(this).val();

$.ajax({
method: "POST",
url: "admin-fgei/ajaxData.php",
data: {
matric: matric_id
},
dataType: "html",
success: function(data) {

$("#matric_Spec").html(data);

$("#Matric_title_SpecName").html(data);

}
});
});



// Middle

$("#Middle_id").on('change', function() {
var Middle_id = $(this).val();

$.ajax({
method: "POST",
url: "admin-fgei/ajaxData.php",
data: {
Middle: Middle_id
},
dataType: "html",
success: function(data) {

$("#Middle_Spec").html(data);

$("#Middle_title_SpecName").html(data);

}
});
});



// // Primary

// $("#Primary_id").on('change', function() {
// var Primary_id = $(this).val();

// $.ajax({
// method: "POST",
// url: "admin-fgei/ajaxData.php",
// data: {
// Primary: Primary_id
// },
// dataType: "html",
// success: function(data) {

// $("#Primary_Spec").html(data);

// $("#Primary_title_SpecName").html(data);

// }
// });
// });



// BS14

$("#bs_id").on('change', function() {
var bs_id = $(this).val();

$.ajax({
method: "POST",
url: "admin-fgei/ajaxData.php",
data: {
bs: bs_id
},
dataType: "html",
success: function(data) {

$("#BS_Spec").html(data);

$("#BS_title_SpecName").html(data);

}
});
});

});
</script>


<script>

// Define the function prov
prov();

function prov() {
    var Primary_id = $("#Primary_id").val(); // Get the value of the Primary_id dropdown

    // Perform AJAX request
    $.ajax({
        method: "POST",
        url: "admin-fgei/ajaxData.php",
        data: {
            Primary: Primary_id
        },
        dataType: "html",
        success: function(data) {
            // Update the HTML of the Primary_title_SpecName dropdown with the received data
            $("#Primary_title_SpecName").html(data);
        },
        error: function(xhr, status, error) {
            // Handle any errors that occur during the AJAX request
            console.error(xhr.responseText);
        }
    });
}

// Call the prov function when the Primary_id dropdown changes
$(document).ready(function() {
    $("#Primary_id").on('change', prov);
});

</script>





</body>

</html>


<?php
} else {
header("Location: index.php");
}


mysqli_close($conn);
?>