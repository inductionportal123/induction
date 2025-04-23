<?php
include('connection/conn.php');
if (!isset($_SESSION)) {
	session_start();
}

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
		$user_gender = $rows['basic_gender'];
	}
	$que = "SELECT * FROM `post_apply` WHERE said = '" . $userid . "'";
	$ex = mysqli_query($conn, $que);
	$ro = mysqli_fetch_array($ex);
	$rowcount = mysqli_num_rows($ex);
	if ($rowcount == 1) {
		$post_data = "ok";
		$post_category_data = $ro['post_category'];
		$post_apply_data = $ro['post_apply'];
		$post_apply_data =  explode(',', $post_apply_data);
		$city_prefer_data = $ro['city_prefer'];
		$city_prefer_two_data = $ro['city_prefer_two'];
		$relax_schedule_caste_data = $ro['relax_schedule_caste'];
		$relax_retired_data = $ro['relax_retired'];
		$relax_retired_from_data = $ro['relax_retired_from'];
		$relax_retired_position_data = $ro['relax_retired_position'];
		$relax_retired_appoint_data = $ro['relax_retired_appoint'];
		$relax_retired_retired_data = $ro['relax_retired_retired'];
		$relax_diabled_data = $ro['relax_disable'];
		$relax_disabled_nature_data = $ro['relax_disabled_nature'];
		$relax_widow_data = $ro['relax_widow'];
		$relax_name_employ_data = $ro['relax_name_employ'];
		$relax_designation_data = $ro['relax_designation'];
		$relax_department_data = $ro['relax_department'];
		$relax_date_death_data = $ro['relax_date_death'];
		$gov_data = $ro['gov'];
		$gov_name_data = $ro['gov_name'];
		$gov_designation_data = $ro['gov_designation'];
		$gov_basic_pay_data = $ro['gov_basic_pay'];
		$gov_appoint_date_data = $ro['gov_appoint_date'];
		$gov_retire_date_data = $ro['gov_retire_date'];
		$gov_appoint_nature_data = $ro['gov_appoint_nature'];
	}
?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>FGEI (C/G) - Recruitment</title>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
		<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
		<link rel="stylesheet" href="css/styles.css">
		<link rel="stylesheet" href="css/per_info.css">
		
		
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

	<!-- <script>
$(document).ready(function(){
    $('.x').click(function() {
        $('.x').not(this).prop('checked', false);
    });
});
</script>
    <script>
$(document).ready(function(){
    $('.y').click(function() {
        $('.y').not(this).prop('checked', false);
    });
});
</script>
    <script>
$(document).ready(function(){
    $('.z').click(function() {
        $('.z').not(this).prop('checked', false);
    });
});
</script> -->

	<body>

		<div class="wrapper hover_collapse">
			<?php include('header.php'); ?>

			<div class="sidebar">
				<div class="sidebar_inner">
					<ul>
						<li>
							<img src="images/logo.png" width="70%" height="70%" style="margin:30px;">
						</li>
						<li>
							<a href="profile.php">
								<span class="icon"><i class="fas fa-user" title="profile"></i></span>
								<span class="text">Profile <br> پروفائل</span>
							</a>
						</li>
						<li>
							<a href="per_info.php" style="background: #292323;">
								<span class="icon"><i class="fas fa-edit" title="Personal Info"></i></span>
								<span class="text">Personal Info <br>   ذاتی معلومات</span>
							</a>
						</li>
						<li>
							<a href="resetpassword.php">
								<span class="icon"><i class="fas fa-key" title="Reset Password"></i></span>
								<span class="text">Reset Password <br>   پاس ورڈ ری سیٹ</span>
							</a>
						</li>


						<li>
							<a href="queryportal.php">
								<span class="icon"><i class="fas fa-comment" title="Query Portal"></i></span>
								<span class="text">Query Portal <br>   سوال پورٹل</span>
							</a>
						</li>
						<li>
							<a href="logout.php">
								<span class="icon"><i class="fas fa-sign-out-alt" title="Logout"></i></span>
								<span class="text">Logout <br>   لاگ آوٹ</span>
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
								<h2 class="heading">Registration Form </h2>
								<br>
								<!-- Nav pills -->
								<ul class="nav nav-pills" role="tablist">
									<li class="nav-item">
										<a class="nav-link" href="per_info.php">Personal Info <br> ذاتی معلومات</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" href="qualification.php">Qualification <br> قابلیت</a>
									</li>
									<li class="nav-item">
										<a class="nav-link  active" href="post_apply.php">Post Apply <br> پوسٹ اپلائی کریں۔</a>
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
									<form id="post_apply_form">
										<div class="row">
											<div class="col-sm-10 col-xs-10 col-md-10 col-lg-10">
												<h6><kbd>Post Information:  معلومات پوسٹ کریں۔</kbd></h6>
											</div>
											<div class="col-sm-2 col-xs-2 col-md-2 col-lg-2"><sub class="fieldrequired"> *</sub> <b>Mandatory Fields</b> </div>
										</div>



										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-6 col-lg-6">
												<h5><b>Post Applied For: <br>  </b><sub class="fieldrequired"> *</sub>
												</h5>
											</div>
										</div>

										<div class="row" id="posts">
											<div class=" col-sm-12 col-xs-12 col-md-12 col-lg-12">
												<?php
												$quali = "SELECT * FROM `qualification` WHERE `said` = '$userid'";
												$exequali = mysqli_query($conn, $quali);
												$dataquali = mysqli_fetch_array($exequali);
												$qualirow = mysqli_num_rows($exequali);
												if ($qualirow > 0) {

													echo "<h6><kbd>Category I: Teaching	(BPS 6-15) زمرہ I: تدریسی عملہ (BPS 06-15)</kbd></h6>";
										if($user_gender=='transgender')
										{
										    $newquery = "SELECT `pid`,`name`,`gender` FROM `posts` WHERE posts.cat = 3  AND posts.pid IN (SELECT post_details.pid FROM post_details WHERE post_details.req_deg = 'Primary' OR post_details.req_deg = 'Middle' OR post_details.req_deg = 'Matric' OR post_details.req_deg = 'Inter' OR post_details.req_deg = 'Bachelors' OR post_details.req_deg = 'Bachelors16' )  ";
										}
										else
										{
										    $newquery = "SELECT `pid`,`name`,`gender` FROM `posts` WHERE posts.cat = 3  AND posts.pid IN (SELECT post_details.pid FROM post_details WHERE post_details.req_deg = 'Primary' OR post_details.req_deg = 'Middle' OR post_details.req_deg = 'Matric' OR post_details.req_deg = 'Inter' OR post_details.req_deg = 'Bachelors' OR post_details.req_deg = 'Bachelors16' ) AND  (posts.gender = '$user_gender' OR posts.gender = 'both') ";
										}
													
													
													$newexe = mysqli_query($conn, $newquery);
													$rowscount = mysqli_num_rows($newexe);
													$i = 1;
													while ($rows = mysqli_fetch_array($newexe)) {
												?>
														<p style="width: 30%; display: inline-block;">
														
															<input class="x" id="x" type="checkbox" name="post_apply[]" value="<?php echo $rows['pid'] ?>" <?php if (isset($post_apply_data) && in_array($rows["pid"], $post_apply_data)) {  ?> checked <?php } ?>> <?php echo strtoupper($rows['name']) . " (<small>" . strtoupper($rows['gender']) . "</small>)" ?>
														</p>
													<?php
														$i++;
														if ($i % 3 == 1) {
															echo "<br>";
														}
													}
												} else {
													?>
													<h4 style="color:red">Please add <b>Qualifications</b> first.</h4>
												<?php
												}

												?>
											</div>

											<!-- START CODE ADDED -->

											<div class=" col-sm-12 col-xs-12 col-md-12 col-lg-12">

												<?php
												$quali = "SELECT * FROM `qualification` WHERE `said` = '$userid'";
												$exequali = mysqli_query($conn, $quali);
												$dataquali = mysqli_fetch_array($exequali);
												$qualirow = mysqli_num_rows($exequali);
												if ($qualirow > 0) {





													echo "<h6><kbd>Category II: Non-Teaching (BPS 6-15) زمرہ II: غیر تدریسی عملہ (BPS 06-15)</kbd>  </h6>";
										
												if($user_gender=='transgender')
										{
										    
													$newquery = "SELECT `pid`,`name`,`gender` FROM `posts` WHERE posts.cat = 1  AND posts.pid IN (SELECT post_details.pid FROM post_details WHERE post_details.req_deg = 'Primary' OR post_details.req_deg = 'Middle' OR post_details.req_deg = 'Matric' OR post_details.req_deg = 'Inter' OR post_details.req_deg = 'Bachelors' OR post_details.req_deg = 'Bachelors16' )  ";
													
										}
										else{
										    	$newquery = "SELECT `pid`,`name`,`gender` FROM `posts` WHERE posts.cat = 1  AND posts.pid IN (SELECT post_details.pid FROM post_details WHERE post_details.req_deg = 'Primary' OR post_details.req_deg = 'Middle' OR post_details.req_deg = 'Matric' OR post_details.req_deg = 'Inter' OR post_details.req_deg = 'Bachelors' OR post_details.req_deg = 'Bachelors16' ) AND (posts.gender = '$user_gender' OR posts.gender = 'both') ";
										}
													$newexe = mysqli_query($conn, $newquery);
													$rowscount = mysqli_num_rows($newexe);
													$i = 1;
													while ($rows = mysqli_fetch_array($newexe)) {
												?>
														<p style="width: 30%; display: inline-block;">
													
															<input class="y" id="PostID" type="checkbox" name="post_apply2[]" value="<?php echo $rows['pid'] ?>" <?php if (isset($post_apply_data) && in_array($rows["pid"], $post_apply_data)) {  ?> checked <?php } ?>> <?php echo strtoupper($rows['name']) . " (<small>" . strtoupper($rows['gender']) . "</small>)" ?>
														</p>
													<?php
														$i++;
														if ($i % 3 == 1) {
															echo "<br>";
														}
													}
												} else {
													?>
													<h4 style="color:red">Please add <b>Qualifications</b> first.</h4>
												<?php
												}

												?>
											</div>



											<!-- END CODE ADDED -->
<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
    <?php
    // Fetch user qualification
    $quali = "SELECT * FROM `qualification` WHERE `said` = '$userid'";
    $exequali = mysqli_query($conn, $quali);
    $qualirow = mysqli_num_rows($exequali);

    if ($qualirow > 0) {
        echo "<h6><kbd>Category III: Junior Staff (BPS 1-5) زمرہ II: غیر تدریسی عملہ (BPS 06-15)</kbd> </h6>";
        
        

        // Retrieve user's district
        $query_two = "SELECT `contact_district`, `female_applying`,`female_husband_district` FROM `per_info` WHERE `said` = $userid";
        $query_exe_two = mysqli_query($conn, $query_two);
        $query_row_two = mysqli_fetch_array($query_exe_two);
		
		if($query_row_two['female_applying']== '1')
		{   
			$user_district = $query_row_two['female_husband_district'];
		}
		else{
			$user_district = $query_row_two['contact_district'];
		}
        
		
		


        // Define a list of valid districts (column names in lowerstaff table)
        $valid_districts = [
            'mardan', 'kohat', 'hangu', 'peshawar', 'nowshera', 'attock', 'islamabad',
            'rawalpindi', 'haripur', 'abbottabad', 'jhelum', 'kotli', 'muzaffarabad',
            'mianwali', 'khushab', 'mandi_bahauddin', 'gujrat', 'gujranwala', 'sialkot',
            'lahore', 'jhang', 'multan', 'hyderabad', 'karachi', 'quetta'
        ];
        
if ($user_district == 'karachi north' || 
    $user_district == 'karachi west' || 
    $user_district == 'karachi east' || 
    $user_district == 'karachi central' || 
    $user_district == 'karachi south' || 
    $user_district == 'karachi malir' || 
    $user_district == 'karachi korangi' || 
    $user_district == 'karachi keamari') {
        
    $user_district = 'karachi';
}

        
        if($user_district=='mandi bahauddin')
        {
            $user_district='mandi_bahauddin';
        }
        if (in_array($user_district, $valid_districts)) {
            // Prepare and execute the SQL query to fetch posts that match the user's district
            		if($user_gender=='transgender')
										{
										    
										    $sql = "SELECT p.pid, p.name, p.gender, ls.lsid, ls.$user_district 
                    FROM posts p
                    JOIN lowerstaff ls ON p.pid = ls.pid
                    WHERE p.cat = 2 
                      AND p.pid IN (SELECT post_details.pid FROM post_details WHERE post_details.req_deg = 'Primary' OR post_details.req_deg = 'Middle' OR post_details.req_deg = 'Matric')
                      AND ls.$user_district > 0";
                      
										}
										
										else
										{
										    
										    $sql = "SELECT p.pid, p.name, p.gender, ls.lsid, ls.$user_district 
                    FROM posts p
                    JOIN lowerstaff ls ON p.pid = ls.pid
                    WHERE p.cat = 2 
                      AND p.pid IN (SELECT post_details.pid FROM post_details WHERE post_details.req_deg = 'Primary' OR post_details.req_deg = 'Middle' OR post_details.req_deg = 'Matric')
                      AND (p.gender = '$user_gender' OR p.gender = 'both')
                      AND ls.$user_district > 0";
										}
            
            
                      
                      
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<input class="z" type="checkbox" name="post_apply3[]" value="' . $row['pid'] . '"';
                    if (isset($post_apply_data) && in_array($row["pid"], $post_apply_data)) {
                        echo ' checked';
                    }
                    echo '> ' . strtoupper($row['name']) . ' (<small>' . strtoupper($row['gender']) . '</small>)</p>';
                }
            } else {
                // echo "No posts available for your district.";
            }
        } else {
            // echo "No posts available for your district.";
        }
   } else {
        echo '<h4 style="color:red">Please add <b>Qualifications</b> first.</h4>';
    }
    ?>
</div>



													    
													    
													    
													    
													    
													    
													    
													    
													 
													
											</div>

											<br />
										</div>

										<div class="row">
											<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
												<h6><kbd>Test City: ٹیسٹ سٹی</kbd></h6>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Test City Preferred I: <br> ٹیسٹ سٹی ترجیحی I</b><sub class="fieldrequired"> *</sub></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<select class="form-control" name="test_city" id="test_city" required>
													<option value="">Select City</option>


													<?php
													$nquery = "SELECT DISTINCT(district.id) , centes.district FROM district JOIN centes ON district.name = centes.district";
													$nexe = mysqli_query($conn, $nquery);
													$rocount = mysqli_num_rows($nexe);
													while ($ro = mysqli_fetch_array($nexe)) {
													?>
														<option value="<?php echo $ro['id'] ?>" <?php if (isset($city_prefer_data) && $city_prefer_data ==  str_replace(" ", "", $ro['id'])) { ?> Selected <?php } ?>> <?php echo strtoupper($ro['district']) ?> </option>

													<?php
													}
													?>
												</select>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Test City Preferred II <br> ٹیسٹ سٹی ترجیحی II</b>:<sub class="fieldrequired"> *</sub></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<select class="form-control" name="multy_city" id="multy_city" required>
													<option value="">Select City</option>
													<?php
													$newqu = "SELECT DISTINCT(district.id) , centes.district FROM district JOIN centes ON district.name = centes.district";
													$newe = mysqli_query($conn, $newqu);
													$scount = mysqli_num_rows($newe);
													while ($rs = mysqli_fetch_array($newe)) {
													?>
														<option value="<?php echo $rs['id'] ?>" <?php if (isset($city_prefer_two_data) && $city_prefer_two_data ==  str_replace(" ", "", $rs['id'])) { ?> Selected <?php } ?>> <?php echo strtoupper($rs['district']) ?> </option>
													<?php
													}
													?>
												</select>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
												<h6><kbd>Age Relaxation Claim:  عمر کی حد میں رعایت</kbd></h6>
											</div>
										</div>



										<div class="row">
											<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
												<h5>Scheduled Castes, Buddhist Community, Recognized Tribes of the Tribal Areas, Azad Kashmir, Gilgit Baltistan, AJK, Sindth (Rural), Balochistan Domiciled <br>درج فہرست ذاتیں، بدھسٹ کمیونٹی، قبائلی علاقوں کے تسلیم شدہ قبائل، آزاد کشمیر، گلگت بلتستان، آزاد جموں و کشمیر، سندھ (دیہی)، بلوچستان ڈومیسائل</h5>
											</div>

											<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
												<input type="checkbox" name="caste_age_relax" id="caste_age_relax" <?php if (isset($relax_schedule_caste_data) && $relax_schedule_caste_data == 1) { ?> checked <?php } ?>>
											</div>

											<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
												<h5>Released or Retired Officer Personnel of the Armed Forces of Pakistan: <br>پاکستان کی مسلح افواج کے رہائی یافتہ یا ریٹائرڈ آفیسر پرسنل</h5>
											</div>

											<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
												<input type="checkbox" name="retire_age_relax" id="retire_age_relax" <?php if (isset($relax_retired_data) && $relax_retired_data == 1) { ?> checked <?php } ?>>
											</div>
										</div>
										<script>
											$('#retire_age_relax').click(function(e) {
												if ($(this).prop('checked') == false) {
													$('#retired_armed_person').attr("disabled", "disabled");
													$('#retired_armed_position').attr("disabled", "disabled");
													$('#retired_armed_appoint').attr("disabled", "disabled");
													$('#retired_armed_retirement').attr("disabled", "disabled");
												} else {
													$('#retired_armed_person').removeAttr("disabled");
													$('#retired_armed_position').removeAttr("disabled");
													$('#retired_armed_appoint').removeAttr("disabled");
													$('#retired_armed_retirement').removeAttr("disabled");
												}
											});
										</script>
										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Retired From: <br>سے ریٹائر ہوئے۔</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<select class="form-control" name="retired_armed_person" id="retired_armed_person" <?php if (isset($relax_retired_data) && $relax_retired_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_retired_data)) { ?> disabled="disabled" <?php } ?> required>
													<option value="">Select Your Force.</option>
													<option value="army" <?php if (isset($relax_retired_from_data) && $relax_retired_from_data == "army") { ?> selected <?php } ?>>Army</option>
													<option value="navy" <?php if (isset($relax_retired_from_data) && $relax_retired_from_data == "navy") { ?> selected <?php } ?>>Navy</option>
													<option value="air" <?php if (isset($relax_retired_from_data) && $relax_retired_from_data == "air") { ?> selected <?php } ?>>Air Force</option>
													<!-- <option value="par" <?php if (isset($relax_retired_from_data) && $relax_retired_from_data == "par") { ?> selected <?php } ?>>Para Military Forces</option> -->
												</select>

											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Rank: <br> عہدہ</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
											
												
												<input type="text" class="form-control" name="retired_armed_position" id="retired_armed_position" value="<?php if (isset($relax_retired_position_data)) {
																																			echo $relax_retired_position_data;
																																		} ?>" <?php if (isset($relax_retired_position_data) && $relax_retired_position_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_retired_position_data)) { ?> disabled="disabled" <?php } ?> required>
												

											</div>
										</div>
										
										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Date of Appointment: <br> تقرری کی تاریخ</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="date" class="form-control" name="retired_armed_appoint" id="retired_armed_appoint" value="<?php if (isset($relax_retired_appoint_data)) {
																																							echo $relax_retired_appoint_data;
																																						} ?>" <?php if (isset($relax_retired_data) && $relax_retired_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_retired_data)) { ?> disabled="disabled" <?php } ?> required>
											</div>
										</div>

										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Date of Retirement: <br> ریٹائرمنٹ کی تاریخ</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="date" class="form-control" name="retired_armed_retirement" id="retired_armed_retirement" value="<?php if (isset($relax_retired_retired_data)) {
																																									echo $relax_retired_retired_data;
																																								} ?>" <?php if (isset($relax_retired_data) && $relax_retired_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_retired_data)) { ?> disabled="disabled" <?php } ?>>
											</div>
										</div>



										<div class="row">
											<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
												<h5>Disabled Person (Nature of Disability must be mentioned) <br> معذور شخص (معذوری کی نوعیت کا ذکر کرنا ضروری ہے)</h5>
											</div>

											<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
												<input type="checkbox" name="diabled_age_relax" id="diabled_age_relax" <?php if (isset($relax_diabled_data) && $relax_diabled_data == 1) { ?> checked <?php } ?>>
											</div>
										</div>

										<script>
											$('#diabled_age_relax').click(function(e) {
												if ($(this).prop('checked') == false) {


													$('#nature_diable').attr("disabled", "disabled");
												} else {
													$('#nature_diable').removeAttr("disabled");
												}
											});
										</script>

										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Nature of Disability: <br> معذوری کی نوعیت</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<select class="form-control" name="nature_diable" id="nature_diable" <?php if (isset($relax_diabled_data) && $relax_diabled_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_diabled_data)) { ?> disabled="disabled" <?php } ?>>
													<option value="">Select Your Disability.</option>

													<option value="Leg/Arm Paralyze" <?php if (isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Leg/Arm Paralyze") { ?> selected <?php } ?>>Leg/Arm Paralyze</option>
													<option value="Visual Defect" <?php if (isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Visual Defect") { ?> selected <?php } ?>>Visual Defect</option>
													<option value="Mental/Congnitive" <?php if (isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Mental/Congnitive") { ?> selected <?php } ?>>Mental/Congnitive</option>
													<option value="Deaf/Dumb" <?php if (isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Deaf/Dumb") { ?> selected <?php } ?>>Deaf/Dumb</option>
													<option value="Other" <?php if (isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Other") { ?> selected <?php } ?>>Other</option>
												</select>
											</div>
										</div>



										<div class="row">
											<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
												<h5>Widow/ Widower or Child of Govt Servant died during Service (on or after 01-07-2005) <br> بیوہ/ بیوہ یا سرکاری ملازم کا بچہ دورانِ سروس فوت ہو گیا (01-07-2005 کو یا اس کے بعد)</h5>
											</div>
											

											<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
												<input type="checkbox" name="widow_age_relax" id="widow_age_relax" <?php if (isset($relax_widow_data) && $relax_widow_data == 1) { ?> checked <?php } ?>>
											</div>

										</div>


										<script>
											$('#widow_age_relax').click(function(e) {
												if ($(this).prop('checked') == false) {
													$('#widow_husband_name').attr("disabled", "disabled");
													$('#widow_husband_designaiton').attr("disabled", "disabled");
													$('#widow_husband_department').attr("disabled", "disabled");
													$('#widow_husband_death').attr("disabled", "disabled");
												} else {
													$('#widow_husband_name').removeAttr("disabled");
													$('#widow_husband_designaiton').removeAttr("disabled");
													$('#widow_husband_department').removeAttr("disabled");
													$('#widow_husband_death').removeAttr("disabled");
												}
											});
										</script>



										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Name of Deceased Govt Employee:</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="text" class="form-control" name="widow_husband_name" id="widow_husband_name" value="<?php if (isset($relax_name_employ_data)) {
																																						echo $relax_name_employ_data;
																																					} ?>" <?php if (isset($relax_widow_data) && $relax_widow_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_widow_data)) { ?> disabled="disabled" <?php } ?>>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Designation and BPS:</b></h5>
											</div>
											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<!--<select class="form-control" name="widow_husband_designaiton" id="widow_husband_designaiton" <?php if (isset($relax_widow_data) && $relax_widow_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_widow_data)) { ?> disabled="disabled" <?php } ?>>-->
												<!--	<option value="">Select Your Designation</option>-->
												<!--	<option value="regular" <?php if  (isset($relax_designation_data) && $relax_designation_data == "regular") { ?> selected <?php } ?>>Regular</option>-->
												<!--	<option value="contract" <?php if (isset($relax_designation_data) && $relax_designation_data == "contract") { ?> selected <?php } ?>>Contract</option>-->
												<!--</select>-->
												
												
												<input type="text" class="form-control" name="widow_husband_designaiton" id="widow_husband_designaiton" value="<?php if (isset($relax_designation_data)) {
																																			echo $relax_designation_data;
																																		} ?>" <?php if (isset($relax_widow_data) && $relax_widow_data != 1) { ?>  <?php } elseif (!isset($relax_widow_data)) { ?> disabled="disabled" <?php } ?> required>
																																		
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Department:</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="text" class="form-control" name="widow_husband_department" id="widow_husband_department" value="<?php if (isset($relax_department_data)) {
																																									echo $relax_department_data;
																																								} ?>" <?php if (isset($relax_widow_data) && $relax_widow_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_widow_data)) { ?> disabled="disabled" <?php } ?>>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
												<h5><b>Date of Death:</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="date" class="form-control" name="widow_husband_death" id="widow_husband_death" value="<?php if (isset($relax_date_death_data)) {
																																						echo $relax_date_death_data;
																																					} ?>" <?php if (isset($relax_widow_data) && $relax_widow_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($relax_widow_data)) { ?> disabled="disabled" <?php } ?>>

											</div>
										</div>


										<div class="row">
											<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
												<h6><kbd>Government Employee (Currently Serving) (If Yes): <input type="checkbox" name="gov_emp" id="gov_emp" <?php if (isset($gov_data) && $gov_data == 1) { ?> checked <?php } ?>></kbd></h6>
											</div>
										</div>
										
											<!--<p style="color: red;">Only permanent government employees are eligible for this age relaxation</p>-->

										



										<script>
											$('#gov_emp').click(function(e) {
												if ($(this).prop('checked') == false) {


													$('#gov_dept_name').attr("disabled", "disabled");
													$('#gov_dept_desig').attr("disabled", "disabled");
													$('#gov_basic_scale').attr("disabled", "disabled");
													$('#gov_appoint').attr("disabled", "disabled");
													$('#gov_retire').attr("disabled", "disabled");
													$('#gov_nature').attr("disabled", "disabled");
												} else {
													$('#gov_dept_name').removeAttr("disabled");
													$('#gov_dept_name').attr("required");
													$('#gov_dept_desig').removeAttr("disabled");
													$('#gov_dept_desig').attr("required", "required");
													$('#gov_basic_scale').removeAttr("disabled");
													$('#gov_appoint').removeAttr("disabled");
													$('#gov_retire').attr("disabled", "disabled");
													$('#gov_nature').removeAttr("disabled");

												}
											});
										</script>



										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
												<h5><b>Dept Name: <br> محکمہ کا نام</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="text" class="form-control" name="gov_dept_name" id="gov_dept_name" value="<?php if (isset($gov_name_data)) {
																																			echo $gov_name_data;
																																		} ?>" <?php if (isset($gov_data) && $gov_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($gov_data)) { ?> disabled="disabled" <?php } ?> required>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
												<h5><b>Designation: <br> عہدہ</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="text" class="form-control" name="gov_dept_desig" id="gov_dept_desig" value="<?php if (isset($gov_designation_data)) {
																																				echo $gov_designation_data;
																																			} ?>" <?php if (isset($gov_data) && $gov_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($gov_data)) { ?> disabled="disabled" <?php } ?>>
											</div>
										</div>


										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
												<h5><b>Basic Pay Scale <br> بنیادی تنخواہ کا سکیل</b>:</h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="text" class="form-control" name="gov_basic_scale" id="gov_basic_scale" value="<?php if (isset($gov_basic_pay_data)) {
																																				echo $gov_basic_pay_data;
																																			} ?>" <?php if (isset($gov_data) && $gov_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($gov_data)) { ?> disabled="disabled" <?php } ?>>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
												<h5><b>Appointment Date: <br> تقرری کی تاریخ</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="date" class="form-control" name="gov_appoint" id="gov_appoint" value="<?php if (isset($gov_appoint_date_data)) {
																																		echo $gov_appoint_date_data;
																																	} ?>" <?php if (isset($gov_data) && $gov_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($gov_data)) { ?> disabled="disabled" <?php } ?>>
											</div>
										</div>
										<?php
										$date = "SELECT `end_date` FROM `registrationdate`";
										$exedate = mysqli_query($conn, $date);
										$datedate = mysqli_fetch_array($exedate);
										$regenddate = $datedate['end_date'];
										?>

										<div class="row">
											<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
												<h5><b>Till Registeration end date </b>:</h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<input type="text" class="form-control" name="gov_retire" id="gov_retire" value="<?php echo $regenddate; ?>" readonly>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
												<h5><b>Appointment Nature: <br> تقرری کی نوعیت</b></h5>
											</div>

											<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
												<select class="form-control" name="gov_nature" id="gov_nature" <?php if (isset($gov_data) && $gov_data != 1) { ?> disabled="disabled" <?php } elseif (!isset($gov_data)) { ?> disabled="disabled" <?php } ?>>
												    <option value="" <?php if (isset($gov_appoint_nature_data) && $gov_appoint_nature_data == "permanent") { ?> selected <?php } ?>>Select...</option>
												    
												    
													<option value="permanent" <?php if (isset($gov_appoint_nature_data) && $gov_appoint_nature_data == "permanent") { ?> selected <?php } ?>>Permanent</option>
													
													<option value="contract" <?php if (isset($gov_appoint_nature_data) && $gov_appoint_nature_data == "contract") { ?> selected <?php } ?>>Contract</option>
													
													
													
												</select>
											</div>
										</div>
										<br>
										<div class="row">
											<div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="left">
												<div id="response"></div>
											</div>
											<div class="col-sm-4 col-xs-4 col-md-4 col-lg-4" align="right">
												<?php
												if ($undertaking == 1) { ?>
													<p style="font-size: 16px; color: green; "><?php echo "Already Submitted"  ?></p>
													<input type="button" class="btn btn-lg btn-info" style="margin-bottom: 10px;border: none; outline: none;" name="post_submit" id="post_submit" value="Save & Next" disabled >
												<?php
												} else 
												{
												?>
													<input type="button" class="btn btn-lg btn-info" style="margin-bottom: 10px;border: none; outline: none;" name="post_submit" id="post_submit" value="Save & Next">
												<?php
												}

												?>

											</div>
										</div>
										<!--     <span id="spnError" class="error-message" style="display: none">Please select at-least one POST.</span>-->

									</form>
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>


		<script type="text/javascript">
			$(document).ready(function() {
				// var PostID = $("#PostID").val();
				// alert(PostID);

				//   		$("#post").on("change",function(){
				//   			$('#list').html('');
				// 				 $('#list').multiselect('rebuild');
				//   			var post = $("#post").val();
				//   			$.ajax({
				//   				url: "loadpost.php",
				//   				type: "POST",
				//   				data: {post_id:post},
				//   				success: function(data)
				//   				{
				//   					$('#list').html(data);
				//  					   $('#list').multiselect('rebuild');
				//   				}
				//   			});
				//   		});
				//   	});

				// $(document).ready(function() {
				// 		$('#list').html('');
				// 				$('#list').multiselect('rebuild');
				//   			var post = $("#post").val();
				//   			$.ajax({
				//   				url: "loadpost.php",
				//   				type: "POST",
				//   				data: {post_id:post},
				//   				success: function(data)
				//   				{
				//   					$('#list').html(data);
				//  					   $('#list').multiselect('rebuild');
				//   				}
				//   			});
				// });



				$("#post_submit,#post_submit_update").click(function() {

					var checked = $("#posts input[type=checkbox]:checked").length;
                


					var test_city = $("#test_city").val();
					var multy_city = $("#multy_city").val();
					var retired_armed_person = $("#retired_armed_person").val();
					var retired_armed_position = $("#retired_armed_position").val();
					var retired_armed_appoint = $("#retired_armed_appoint").val();
					var retired_armed_retirement = $("#retired_armed_retirement").val();
					var nature_diable = $("#nature_diable").val();
					var widow_husband_name = $("#widow_husband_name").val();
					var widow_husband_designaiton = $("#widow_husband_designaiton").val();
					var widow_husband_department = $("#widow_husband_department").val();
					var widow_husband_death = $("#widow_husband_death").val();
					var gov_dept_name = $("#gov_dept_name").val();
					var gov_dept_desig = $("#gov_dept_desig").val();
					var gov_basic_scale = $("#gov_basic_scale").val();
					var gov_appoint = $("#gov_appoint").val();
					var gov_retire = $("#gov_retire").val();
					var gov_nature = $("#gov_nature").val();

					if (checked == 0) {
						$('#response').fadeIn();
						$('#response').addClass('error-msg').html("Please Select atleast 1 Post.");
					} else if (test_city == "") {
						$('#response').fadeIn();
						$('#response').addClass('error-msg').html("Please choose Preffered City I");
					} else if (multy_city == "") {
						$('#response').fadeIn();
						$('#response').addClass('error-msg').html("Please choose Preffered City II");
					} else if (test_city == multy_city) {
						$('#response').slideDown();
						$('#response').addClass('error-msg').html("Preffered City I & II can't be same");
					} else if ($("#retire_age_relax").prop('checked') == true && (retired_armed_person == "" || retired_armed_position == "" || retired_armed_appoint == "" || retired_armed_retirement == "")) {

						$('#response').fadeIn();
						$('#response').addClass('error-msg').html("All Field Are Required (with the red star)");

					} else if ($("#diabled_age_relax").prop('checked') == true && nature_diable == "") {

						$('#response').fadeIn();
						$('#response').addClass('error-msg').html("All Field Are Required (with the red star)");

					} else if ($("#widow_age_relax").prop('checked') == true && (widow_husband_name == "" || widow_husband_designaiton == "" || widow_husband_department == "" || widow_husband_death == "")) {

						$('#response').fadeIn();
						$('#response').addClass('error-msg').html("All Field Are Required (with the red star)");

					} else if ($("#gov_emp").prop('checked') == true && (gov_dept_name == "" || gov_dept_desig == "" || gov_basic_scale == "" || gov_appoint == "" || gov_nature == "" || gov_retire == "")) {

						$('#response').fadeIn();
						$('#response').addClass('error-msg').html("All Field Are Required (with the red star)");

					} else {
						$.ajax({
							url: "postprocess.php",
							type: "POST",
							data: $('#post_apply_form').serialize(),
							success: function(data) {
						



								if (data == 0) {
									$('#response').fadeIn();
									$('#response').addClass('error-msg').html("Please first fill Personal Information tab");
								} else if (data == 2) {
									$('#response').fadeIn();
									$('#response').addClass('error-msg').html("There is no seat in this domicile");
								} else if (data == 1) {
									window.location.href = "challan.php";
								} else {
									$('#response').addClass('error-msg').html(data);

								}
							}
						});
					}
				});

				$('#list').multiselect({
					nonSelectedText: 'Select Post Category',
					buttonWidth: '292px',
				});
				//        $('#test_city').multiselect({
				//		  nonSelectedText: 'Select any two cities from below.',
				//		  buttonWidth:'292px',
				//		  });
				//		$('#multy_city').multiselect({
				//		  nonSelectedText: 'Select any two cities from below.',
				//		  buttonWidth:'292px',
				//		  })
				;

				document.getElementById('widow_age_relax').onchange = function() {
					document.getElementById('widow_husband_name').disabled = !this.checked;
					document.getElementById('widow_husband_designaiton').disabled = !this.checked;
					document.getElementById('widow_husband_department').disabled = !this.checked;
					document.getElementById('widow_husband_death').disabled = !this.checked;
				};

				document.getElementById('retire_age_relax').onchange = function() {
					document.getElementById('retired_armed_person').disabled = !this.checked;
					document.getElementById('retired_armed_position').disabled = !this.checked;
					document.getElementById('retired_armed_appoint').disabled = !this.checked;
					document.getElementById('retired_armed_retirement').disabled = !this.checked;
				};

				document.getElementById('diabled_age_relax').onchange = function() {
					document.getElementById('nature_diable').disabled = !this.checked;
				};

				document.getElementById('gov_emp').onchange = function() {
					document.getElementById('gov_dept_name').disabled = !this.checked;
					document.getElementById('gov_dept_desig').disabled = !this.checked;
					document.getElementById('gov_basic_scale').disabled = !this.checked;
					document.getElementById('gov_appoint').disabled = !this.checked;
					document.getElementById('gov_retire').disabled = !this.checked;
					document.getElementById('gov_nature').disabled = !this.checked;

				};

			});
		</script>

		<script>
			function showAdditionalInfo() {
				var genderSelect = document.getElementById("gender");
				var additionalInfoDiv = document.getElementById("additionalInfo");

				// Check if the selected option is "Female"
				if (genderSelect.value === "female") {
					additionalInfoDiv.style.display = "block"; // Show additional info
				} else {
					additionalInfoDiv.style.display = "none"; // Hide additional info
				}
			}
		</script>

	</body>

	</html>


<?php
} else {
	header("Location: index.php");
}
?>