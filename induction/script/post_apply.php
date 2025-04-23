<?php
include('connection/conn.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['u_name'], $_SESSION['u_id']))
{
  $user = $_SESSION['u_name'];
  $userid = $_SESSION['u_id'];


		$que = "SELECT * FROM `post_apply` WHERE said = '".$userid."'";
		$ex = mysqli_query($conn,$que);
		$ro = mysqli_fetch_array($ex);
		$rowcount = mysqli_num_rows($ex);

		if($rowcount==1){
		    $post_data = "ok";
		    $post_category_data = $ro['post_category'];
		    $post_apply_data = $ro['post_apply'];
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
	<title>Side Navigation bar Using HTML and CSS</title>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> 

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
	
<div class="wrapper hover_collapse">
	<div class="top_navbar">
		<div class="logo"></div>
		<div class="menu">
			<div class="hamburger">
				<h3 style="margin-top: 8px;">FEDERAL GOVERNMENT EDUCATIONAL INSTITUTES (C/G)</h3>
			</div>
			<div class="profile_wrap">
				<div class="profile" style="font-size: 16px">
					<span class="icon">
						<i class="fas fa-user"></i>
					</span>
					<span class="name"><?php echo strtoupper($user); ?></span>
				</div>
			</div>
		</div>
	</div>

	<div class="sidebar">
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
				<a href="per_info.php"  style="background: #292323;">
					<span class="icon"><i class="fas fa-edit" title="Personal Info"></i></span>
					<span class="text">Personal Info</span>
				</a>
			</li>
			<li>
				<a href="#">
					<span class="icon"><i class="fas fa-key" title="Reset Password"></i></span>
					<span class="text">Reset Password</span>
				</a>
			</li>


			<li>
				<a href="#">
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
				  <h2 class="heading">Registration Form</h2>
				  <br>
						  <!-- Nav pills -->
						  <ul class="nav nav-pills" role="tablist">
								    <li class="nav-item">
								      <a class="nav-link" href="per_info.php">Personal Info</a>
								    </li>
								     <li class="nav-item">
								      <a class="nav-link"  href="qualification.php">Qualification</a>
								    </li>
								    <li class="nav-item">
								      <a class="nav-link  active" href="post_apply.php">Post Apply</a>
								    </li>
								    <li class="nav-item">
								      <a class="nav-link"  href="challan.php">Challan Form</a>
								    </li>
								    <li class="nav-item">
								      <a class="nav-link"  href="documents.php">Upload Documents</a>
								    </li>
								    <li class="nav-item">
								      <a class="nav-link"  href="undertaking.php">Undertaking</a>
								    </li>
						  </ul>

						  <!-- Tab panes -->
<div class="tab-content container">
<br>
<form id="post_apply_form">
	<div class="row">
      		<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
      			<h6><kbd>post information:</kbd></h6>
      		</div>
	</div>

	<div class="row">
      	<div class="col-sm-4 col-xs-4 col-md-3 col-lg-3">
      		<h5><b>Post Category:</b><sub class="fieldrequired"> *</sub></h5> 
      	</div>

      	<div class="col-sm-8 col-xs-8 col-md-4 col-lg-4">
      		<select id="post" class="form-control" name="post" required/>
      		<option value="">Select Category.</option>
      			<option value="1"  <?php if(isset($post_category_data) && $post_category_data == 1){?> selected <?php } ?>>Teaching/Non-Teaching Staff (BPS-6 <small>to</small> 15) Male</option>
      			<option value="2" <?php if(isset($post_category_data) && $post_category_data == 2){?> selected <?php } ?>>Teaching/Non-Teaching Staff (BPS-6 <small>to</small> 15) Female</option>
      			<option value="3" <?php if(isset($post_category_data) && $post_category_data == 3){?> selected <?php } ?>>Class IV (BPS-1 <small>to</small> 5) Male</option>
      			<option value="4" <?php if(isset($post_category_data) && $post_category_data == 4){?> selected <?php } ?>>Class IV (BPS-1 <small>to</small> 5) Female</option>
      			<br>
      		</select>
      	</div>
    </div>


	<div class="row">
      	<div class="col-sm-6 col-xs-6 col-md-6 col-lg-6">
      		<h5><b>Post Applied For:</b><sub class="fieldrequired"> *</sub>
      		<br/>	<small> <b>(You can apply for multiple posts by selecting more than one option)</b></small></h5> 
      	</div>
	</div>

<div class="row">
      	<div class="col-md-offset-3 col-lg-offset-3 col-sm-6 col-xs-6 col-md-6 col-lg-6">
      		<select id="list" class="form-control" multiple name="post_apply[ ]" required/>

      		</select>
      	</div>
</div>

<div class="row">
      		<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
      			<h6><kbd>Test City:</kbd></h6>
      		</div>
	</div>
	     
    <div class="row">
      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
      		<h5><b>Test City Preferred I:</b><sub class="fieldrequired"> *</sub></h5> 
      	</div>

      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
      		<select  class="form-control" name="test_city" id="test_city" required/>
      			<option value="">Select City.</option>
      			<option value="1" <?php if(isset($city_prefer_data) && $city_prefer_data == 1){?> selected <?php } ?>>Karachi</option>
      			<option value="2" <?php if(isset($city_prefer_data) && $city_prefer_data == 2){?> selected <?php } ?>>Islamabad</option>
      			<option value="3" <?php if(isset($city_prefer_data) && $city_prefer_data == 3){?> selected <?php } ?>>Rawalpindi</option>
      			<br>
      		</select>
      	</div>
    </div>
    
    <div class="row">
      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
      		<h5><b>Test City Preferred II</b>:<sub class="fieldrequired"> *</sub></h5> 							      		
      	</div>

      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
      		<p style="margin-bottom: 0px;">Select any two cities from below.</p>					      		
      		<select id="multy_city"  class="form-control" multiple name="multy_city[ ]" required/>
      			<option value="1">Karachi</option>
      			<option value="2">Islamabad</option>
      			<option value="3">Rwp</option>     		
      		</select>
      	</div>
 	</div>



  	<div class="row">
      		<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
      			<h6><kbd>Age Relaxation Claim:</kbd></h6>
      		</div>
	</div>



	      <div class="row">
		      	<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
		      		<h5>Scheduled Castes, Buddhist Community, Recognized Tribes of the Tribal Areas, Azad Kashmir, Gilgit Baltistan, AJK, Sindth (Rural), Balochistan Domiciled</h5>
		      	</div>

		      	<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
		      		<input type="checkbox" name="caste_age_relax" id="caste_age_relax" <?php if(isset($relax_schedule_caste_data) && $relax_schedule_caste_data == 1){?> checked <?php } ?>>
		      	</div>

		      	<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
		      		<h5>Released or Retired Officer Personnel of the Armed Forces of Pakistan:</h5>								      		
		      	</div>

		      	<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
		      		<input type="checkbox" name="retire_age_relax" id="retire_age_relax" <?php if(isset($relax_retired_data) && $relax_retired_data == 1){?> checked <?php } ?>>		      		
		      	</div>

	      </div>

		  <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Retired From:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<select class="form-control" name="retired_armed_person" id="retired_armed_person" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      			<option value="">Select Your Force.</option>
		      			<option value="army" <?php if(isset($relax_retired_from_data) && $relax_retired_from_data == "army"){?> selected <?php } ?>>Army</option>
		      			<option value="navy" <?php if(isset($relax_retired_from_data) && $relax_retired_from_data == "navy"){?> selected <?php } ?>>Navy</option>
		      			<option value="air" <?php if(isset($relax_retired_from_data) && $relax_retired_from_data == "air"){?> selected <?php } ?>>Air Force</option>
		      		</select>					      		
		      								      		
		      	</div>
		  </div>
		  <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Position:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<select class="form-control" name="retired_armed_position" id="retired_armed_position" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      			<option value="">Select Your Position.</option>
		      			<option value="30" <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 30){?> selected <?php } ?>>LNak</option>
		      			<option value="31"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 31){?> selected <?php } ?>>Naik</option>
		      			<option value="32"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 32){?> selected <?php } ?>>Hav</option>
		      			<option value="33"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 33){?> selected <?php } ?>>N/Sub</option>
		      			<option value="34"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 34){?> selected <?php } ?>>Sub</option>
		      			<option value="35"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 35){?> selected <?php } ?>>SM</option>
		      			<option value="36"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 36){?> selected <?php } ?>>Hon-lt</option>
		      			<option value="37"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 37){?> selected <?php } ?>>Hon-capt</option>
		      			<option value="38"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 38){?> selected <?php } ?>>ASI</option>
		      			<option value="39"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 39){?> selected <?php } ?>>SI</option>
		      			<option value="40"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 40){?> selected <?php } ?>>Inspector</option>
		      			<option value="41"  <?php if(isset($relax_retired_position_data) && $relax_retired_position_data == 41){?> selected <?php } ?>>DSP</option>
		      		</select>					      		
		      								      		
		      	</div>
		  </div>
		  <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Date of Appointment:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="date" class="form-control" name="retired_armed_appoint" id="retired_armed_appoint" value="<?php if(isset($relax_retired_appoint_data)){ echo $relax_retired_appoint_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>						      		
		      	</div>
		  </div>

		  <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Date of Retirement:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="date" class="form-control" name="retired_armed_retirement" id="retired_armed_retirement" value="<?php if(isset($relax_retired_retired_data)){ echo $relax_retired_retired_data; } ?>"  <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>						      		
		      	</div>
		  </div>



	      <div class="row">
		      	<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
		      		<h5>Disabled Person (Nature of Disability must be mentioned)</h5>
		      	</div>

		      	<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
		      		<input type="checkbox" name="diabled_age_relax" id="diabled_age_relax" <?php if(isset($relax_diabled_data) && $relax_diabled_data == 1){?> checked <?php } ?>> 
		      	</div>
		  </div>


		    <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Nature of Disability:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<select class="form-control" name="nature_diable" id="nature_diable" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      			<option value="">Select Your disability.</option>

		      			<option value="physical" <?php if(isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "physical"){?> selected <?php } ?>>Physical</option>
		      			<option value="cognitive" <?php if(isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "cognitive"){?> selected <?php } ?>>Cognitive</option>
		      			<option value="mental" <?php if(isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "mental"){?> selected <?php } ?>>Mental</option>
		      			<option value="sensory" <?php if(isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "sensory"){?> selected <?php } ?>>Sensory</option>
		      		</select>					      								      		
		      	</div>
		  </div>



		  <div class="row">
		      	<div class="col-sm-10 col-xs-10 col-md-8 col-lg-8">
		      		<h5>Widow/ Widower or Child of Govt Servant died during Service (on or after 01-07-2005)</h5>								      		
		      	</div>

		      	<div class="col-sm-2 col-xs-2 col-md-4 col-lg-4">
		      		<input type="checkbox" name="widow_age_relax" id="widow_age_relax" <?php if(isset($relax_widow_data) && $relax_widow_data == 1){?> checked <?php } ?>>		      		
		      	</div>

	      </div>


	    <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Widow Husband Name:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="text" class="form-control" name="widow_husband_name" id="widow_husband_name" value="<?php if(isset($relax_name_employ_data)){ echo $relax_name_employ_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>						      		
		      	</div>
		  </div>
		  <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Designation:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<select class="form-control" name="widow_husband_designaiton" id="widow_husband_designaiton" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      			<option value="regular"   <?php if(isset($relax_designation_data) && $relax_designation_data == "regular"){?> selected <?php } ?>>Regular</option>
		      			<option value="contract"   <?php if(isset($relax_designation_data) && $relax_designation_data == "contract"){?> selected <?php } ?>>Contract</option>
		      		</select>						      		
		      	</div>
		  </div>
		  <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Department:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4" >
		      		<input type="text" class="form-control" name="widow_husband_department" id="widow_husband_department" value="<?php if(isset($relax_department_data)){ echo $relax_department_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>					      		
		      	</div>
		  </div>
		  


		  <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-3 col-lg-3">
		      		<h5><b>Date of Death:</b></h5> 							      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="date" class="form-control" name="widow_husband_death" id="widow_husband_death" value="<?php if(isset($relax_date_death_data)){ echo $relax_date_death_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>						      		
		      								      		
		      	</div>
		  </div>


  	<div class="row">
      		<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
      			<h6><kbd>Government Employee (If Yes): <input type="checkbox" name="gov_emp" id="gov_emp" <?php if(isset($gov_data) && $gov_data == 1){?> checked <?php } ?>></kbd></h6>
      		</div>
	</div>

	      <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
		      		<h5><b>Dept Name:</b></h5>     		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="text"  class="form-control" name="gov_dept_name" id="gov_dept_name"  value="<?php if(isset($gov_name_data)){ echo $gov_name_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
		      		<h5><b>Designation:</b></h5>								      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="text"  class="form-control" name="gov_dept_desig" id="gov_dept_desig" value="<?php if(isset($gov_designation_data)){ echo $gov_designation_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>					      		
		      	</div>
	      </div>


	    <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
		      		<h5><b>Basic Pay Scale:</b>:</h5>
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="text"  class="form-control" name="gov_basic_scale" id="gov_basic_scale" value="<?php if(isset($gov_basic_pay_data)){ echo $gov_basic_pay_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
		      		<h5><b>Appointment Date:</b></h5>								      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="date"  class="form-control" name="gov_appoint" id="gov_appoint" value="<?php if(isset($gov_appoint_date_data)){ echo $gov_appoint_date_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>					      		
		      	</div>
	    </div>


	    <div class="row">
		      	<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
		      		<h5><b>Retirement Date:</b>:</h5>
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<input type="date"  class="form-control" name="gov_retire" id="gov_retire" value="<?php if(isset($gov_retire_date_data)){ echo $gov_retire_date_data; } ?>" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
		      		<h5><b>Appointment Nature:</b></h5>								      		
		      	</div>

		      	<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
		      		<select class="form-control" name="gov_nature" id="gov_nature" <?php  if(!isset($post_data)){?> disabled="disabled"  <?php } ?>>
		      			<option value="">Select Your Appointment Nature.</option>
		      			<option value="permanent" <?php if(isset($gov_appoint_nature_data) && $gov_appoint_nature_data == "permanent"){?> selected <?php } ?>>Permanent</option>
		      			<option value="contract" <?php if(isset($gov_appoint_nature_data) && $gov_appoint_nature_data == "contract"){?> selected <?php } ?>>Contract</option>
		      		</select>				      		
		      	</div>
	    </div>
	    <br>
	    <div class="row">
	    	<div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="left">
	     		<div id="response"></div>
	     	</div>
	      	<div class="col-sm-4 col-xs-4 col-md-4 col-lg-4" align="right">
	      		<?php if(isset($post_data)){ ?>
	      		<input type="button" class="btn btn-lg btn-info" name="post_submit_update" value="Update & Next" id="post_submit_update" style="margin-bottom: 10px; outline: none;">
	      		<?php } else { ?>
	      			<input type="button" class="btn btn-lg btn-info" value="Save & Next" name="post_submit" id="post_submit" style="margin-bottom: 10px; outline: none;">
	      		<?php } ?>
	      	</div>
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

<script type="text/javascript">
	$(document).ready(function(){

    		$("#post").on("change",function(){
    			$('#list').html('');
  				 $('#list').multiselect('rebuild');
    			var post = $("#post").val();
    			$.ajax({
    				url: "loadpost.php",
    				type: "POST",
    				data: {post_id:post},
    				success: function(data)
    				{
    					$('#list').html(data);
   					   $('#list').multiselect('rebuild');
    				}
    			});
    		});
    	});

		$("#post_submit,#post_submit_update").click(function()
		{
  			var post =  $("#post").val();
  			var post_apply =  $("#list").val();
  			var test_city =  $("#test_city").val();
  			var multy_city =  $("#multy_city").val();
  			if(post == "" || post_apply == "" || test_city == "" || multy_city == "")
  			{
  				$('#response').fadeIn();
  				$('#response').addClass('error-msg').html("All Field Are Required (with the red star)");
  			}
  			else{
  				$.ajax({
    				url: "postprocess.php",
    				type: "POST",
    				data: $('#post_apply_form').serialize(),
    				success: function(data)
    				{
    					if(data == 0)
    					{
    						$('#response').fadeIn();
  							$('#response').addClass('error-msg').html("Please first fill Personal Information tab");
    					}
    					else
    					{
    						window.location.href = "challan.php"; 
    					// 	$('#response').fadeIn();
  							// $('#response').addClass('error-msg').html(data);
    					}	
    				}
    			});
    		// $('#response').html($('#post_apply_form').serialize());
  			}
		});

		$('#list').multiselect({
		  nonSelectedText: 'Select Post Category',
		  buttonWidth:'292px',
		  });
		$('#multy_city').multiselect({
		  nonSelectedText: 'Select any two cities from below.',
		  buttonWidth:'292px',
		  });

	document.getElementById('widow_age_relax').onchange = function() {
    document.getElementById('widow_husband_name').disabled = !this.checked;
    document.getElementById('widow_husband_designaiton').disabled = !this.checked;
    document.getElementById('widow_husband_department').disabled = !this.checked;
    document.getElementById('widow_husband_death').disabled = !this.checked;
};

document.getElementById('retire_age_relax').onchange = function() 
{
    document.getElementById('retired_armed_person').disabled = !this.checked;
    document.getElementById('retired_armed_position').disabled = !this.checked;
    document.getElementById('retired_armed_appoint').disabled = !this.checked;
    document.getElementById('retired_armed_retirement').disabled = !this.checked;
};

document.getElementById('diabled_age_relax').onchange = function() 
{
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
</script>

</body>
</html>


<?php
}
else{
  header("Location: index.php");
}
?>	