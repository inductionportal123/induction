<?php
include('../connection/conn.php');
if(isset($_POST["employee_id"])){
	$output = '';
	$query = "SELECT * FROM `per_info` WHERE said = '".$_POST['employee_id']."' ";
	$result = mysqli_query($conn,$query);
	$output .= '
		<div class="table-responsive">
			<table class="table table-bordered table-striped">
	';

	while ($row = mysqli_fetch_array($result)) {

		if(isset($row["feedback"])){
		$output .= '
			<tr>
				<td colspan=2> <h3 style="text-align: center; color: green">'.$row["feedback"].'</h3></td>
			</tr>

		';
}


		$output .= '
		
			<tr>
				<td><label>Name</label></td>
				<td>'.$row["can_name"].'</td>
			</tr>
			<tr>
				<td><label>Father Name</label></td>
				<td>'.$row["father_name"].'</td>
			</tr>
			<tr>
				<td><label>CNIC</label></td>
				<td>'.$row["em_cnic"].'</td>
			</tr>
			<tr>
				<td><label>Gender</label></td>
				<td>'.$row["gender"].'</td>
			</tr>
			<tr>
				<td><label>Post Apply</label></td>
				<td>'.strtoupper($row["post_apply"]).'</td>
			</tr>
			<tr>
				<td><label>Domicile</label></td>
				<td>'.$row["domicile"].'</td>
			</tr>
			<tr>
				<td><label>Qualification</label></td>
				<td>'.$row["qualification"].'</td>
			</tr>
			<tr>
				<td><label>Date Of Birth</label></td>
				<td>'.$row["dob"].'</td>
			</tr>
			<tr>
				<td><label>Caste</label></td>
				<td>'.$row["schedule_caste"].'</td>
			</tr>
			<tr>
				<td><label>Retired Officer</label></td>
				<td>'.$row["retired_officer"].'</td>
			</tr>
			<tr>
				<td><label>Disabled</label></td>
				<td>'.$row["disabled"].'</td>
			</tr>
			<tr>
				<td><label>Widow</label></td>
				<td>'.$row["widow"].'</td>
			</tr>
			<tr>
				<td><label>Government Servant</label></td>
				<td>'.$row["gov_servant"].'</td>
			</tr>
			<tr>
				<td><label>Government Employee</label></td>
				<td>'.$row["gov_emply"].'</td>
			</tr>
			<tr>
				<td><label>Department Name</label></td>
				<td>'.$row["name_dept"].'</td>
			</tr>
			<tr>
				<td><label>Designation</label></td>
				<td>'.$row["designation"].'</td>
			</tr>
			<tr>
				<td><label>Pay Scale</label></td>
				<td>'.$row["pay_scale"].'</td>
			</tr>

			<tr>
				<td><label>Appointment Date</label></td>
				<td>'.$row["date_appoint"].'</td>
			</tr>

			<tr>
				<td><label>Appointment Nature</label></td>
				<td>'.$row["nature_appiont"].'</td>
			</tr>


			<tr>
				<td><label>PTCL No</label></td>
				<td>'.$row["ptcl"].'</td>
			</tr>


			<tr>
				<td><label>Mobile</label></td>
				<td>'.$row["mobile"].'</td>
			</tr>
			<tr>
				<td><label>Alternate Contact</label></td>
				<td>'.$row["alternate_contant"].'</td>
			</tr>
			<tr>
				<td><label>Postal Address</label></td>
				<td>'.$row["postal_address"].'</td>
			</tr>
			<tr>
				<td><label>Permanent Address</label></td>
				<td>'.$row["per_address"].'</td>
			</tr>

		';
	}

	$output .= "</table></div>";
	echo $output;
}
?>