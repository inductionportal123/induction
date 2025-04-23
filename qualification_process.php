<?php
ini_set('display_errors', 0); 
include('connection/conn.php');
if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
	$user = $_SESSION['u_name'];
	$userid = $_SESSION['u_id'];

	// ------------------------------qualitfication------------------------

	if ($_POST['primary_title'] == "") {
		$Primary_title = NULL;
	} else {
		$Primary_title = $_POST['primary_title'];
	}
	
	if ($_POST['primary_specialization'] == "") {
		$Primary_specialization = NULL;
	} else {
		$Primary_specialization = $_POST['primary_specialization'];
	}

	if ($_POST['primary_total_marks'] == "") {
		$primary_total_marks = NULL;
	} else {
		$primary_total_marks = $_POST['primary_total_marks'];
	}
	
	if ($_POST['primary_board'] == "") {
		$primary_board = NULL;
	} else {
		$primary_board = $_POST['primary_board'];
	}
	// End of primary section


	if ($_POST['bs_title'] == "") {
		$bs_title = NULL;
	} else {
		$bs_title = $_POST['bs_title'];
	}

	if ($_POST['bs_specialization'] == "") {
		$bs_spec = NULL;
	} else {
		$bs_spec = $_POST['bs_specialization'];
	}

	if ($_POST['bs_total_marks'] == "") {
		$bs_total = NULL;
	} else {
		$bs_total = $_POST['bs_total_marks'];
	}

	if ($_POST['bs_board'] == "") {
		$bs_board = NULL;
	} else {
		$bs_board = $_POST['bs_board'];
	}

	// Middle Section
	if ($_POST['bs16_title'] == "") {
		$bs16_title = NULL;
	} else {
		$bs16_title = $_POST['bs16_title'];
	}
	
	if ($_POST['bs16_specialization'] == "") {
		$bs16_specialization = NULL;
	} else {
		$bs16_specialization = $_POST['bs16_specialization'];
	}

	if ($_POST['bs16_total_marks'] == "") {
		$bs16_total_marks = NULL;
	} else {
		$bs16_total_marks = $_POST['bs16_total_marks'];
	}
	
	if ($_POST['bs16_board'] == "") {
		$bs16_board = NULL;
	} else {
		$bs16_board = $_POST['bs16_board'];
	}
	// End Middle Section

	// ----------------------bs ends-------------------

	if ($_POST['ms_title'] == "") {
		$ms_title = NULL;
	} else {
		$ms_title = $_POST['ms_title'];
	}

	if ($_POST['ms_specialization'] == "") {
		$ms_spec = NULL;
	} else {
		$ms_spec = $_POST['ms_specialization'];
	}

	if ($_POST['ms_total_marks'] == "") {
		$ms_total = NULL;
	} else {
		$ms_total = $_POST['ms_total_marks'];
	}

	if ($_POST['ms_board'] == "") {
		$ms_board = NULL;
	} else {
		$ms_board = $_POST['ms_board'];
	}
	// ----------------------------ms ends------------------

	if ($_POST['dip_name_one'] == "") {
		$dip_name_one = NULL;
	} else {
		$dip_name_one = $_POST['dip_name_one'];
	}

	if ($_POST['dip_obt_one'] == "") {
		$dip_obt_one = NULL;
	} else {
		$dip_obt_one = $_POST['dip_obt_one'];
	}

	if ($_POST['dip_total_one'] == "") {
		$dip_total_one = NULL;
	} else {
		$dip_total_one = $_POST['dip_total_one'];
	}

	if ($_POST['dip_board_one'] == "") {
		$dip_board_one = NULL;
	} else {
		$dip_board_one = $_POST['dip_board_one'];
	}
	// ---------------dip one ends----------------------------

	if ($_POST['dip_name_two'] == "") {
		$dip_name_two = NULL;
	} else {
		$dip_name_two = $_POST['dip_name_two'];
	}

	if ($_POST['dip_obt_two'] == "") {
		$dip_obt_two = NULL;
	} else {
		$dip_obt_two = $_POST['dip_obt_two'];
	}

	if ($_POST['dip_total_two'] == "") {
		$dip_total_two = NULL;
	} else {
		$dip_total_two = $_POST['dip_total_two'];
	}

	if ($_POST['dip_board_two'] == "") {
		$dip_board_two = NULL;
	} else {
		$dip_board_two = $_POST['dip_board_two'];
	}
	//------------dip two ends----------

	if ($_POST['dip_name_three'] == "") {
		$dip_name_three = NULL;
	} else {
		$dip_name_three = $_POST['dip_name_three'];
	}

	if ($_POST['dip_obt_three'] == "") {
		$dip_obt_three = NULL;
	} else {
		$dip_obt_three = $_POST['dip_obt_three'];
	}

	if ($_POST['dip_total_three'] == "") {
		$dip_total_three = NULL;
	} else {
		$dip_total_three = $_POST['dip_total_three'];
	}

	if ($_POST['dip_board_three'] == "") {
		$dip_board_three = NULL;
	} else {
		$dip_board_three = $_POST['dip_board_three'];
	}
	//----------dip three ends-----------
   
	$que = "SELECT * FROM `qualification` WHERE said = '" . $userid . "'";
	$ex = mysqli_query($conn, $que);
	$ro = mysqli_fetch_array($ex);
	$rowcount = mysqli_num_rows($ex);

	// Function to prepare SQL value
	function prepSqlValue($value) {
		if ($value === NULL) {
			return "NULL";
		} else {
			return "'" . mysqli_real_escape_string($GLOBALS['conn'], $value) . "'";
		}
	}

	if ($rowcount == 1) {
		$query = "UPDATE `qualification` SET 
		`primary_title`=" . prepSqlValue($Primary_title) . ",
		`primary_specialization`=" . prepSqlValue($Primary_specialization) . ",
		`primary_total_marks`=" . prepSqlValue($primary_total_marks) . ",
		`primary_board`=" . prepSqlValue($primary_board) . ",

		`middle_title`=" . prepSqlValue($Middle_title) . ",
		`middle_specialization`=" . prepSqlValue($Middle_specialization) . ",
		`middle_total_marks`=" . prepSqlValue($middle_total_marks) . ",
		`middle_board`=" . prepSqlValue($middle_board) . ",

		`matric_title`=" . prepSqlValue($matric_title) . ",
		`matric_specialization`=" . prepSqlValue($matric_spec) . ",
		`matric_total_marks`=" . prepSqlValue($matric_total) . ",
		`matric_board`=" . prepSqlValue($matric_board) . ",

		`inter_title`=" . prepSqlValue($inter_title) . ", 
		`inter_specialization`=" . prepSqlValue($inter_spec) . ",
		`inter_total_marks`=" . prepSqlValue($inter_total) . ",
		`inter_board`=" . prepSqlValue($inter_board) . ",

		`bs_title`=" . prepSqlValue($bs_title) . ",
		`bs_specialization`=" . prepSqlValue($bs_spec) . ",
		`bs_total_marks`=" . prepSqlValue($bs_total) . ",
		`bs_board`=" . prepSqlValue($bs_board) . ",

		`bs16_title`=" . prepSqlValue($bs16_title) . ",
		`bs16_specialization`=" . prepSqlValue($bs16_specialization) . ",
		`bs16_total_marks`=" . prepSqlValue($bs16_total_marks) . ",
		`bs16_board`=" . prepSqlValue($bs16_board) . ",

		`ms_title`=" . prepSqlValue($ms_title) . ",
		`ms_specialization`=" . prepSqlValue($ms_spec) . ",
		`ms_total_marks`=" . prepSqlValue($ms_total) . ",
		`ms_board`=" . prepSqlValue($ms_board) . ",

		`profes_certificate`=" . prepSqlValue($dip_name_one) . ",
		`profes_obtained_marks`=" . prepSqlValue($dip_obt_one) . ",
		`profes_total_marks`=" . prepSqlValue($dip_total_one) . ",
		`profes_board`=" . prepSqlValue($dip_board_one) . ",

		`profes_certificate_two`=" . prepSqlValue($dip_name_two) . ",
		`profes_obtained_marks_two`=" . prepSqlValue($dip_obt_two) . ",
		`profes_total_marks_two`=" . prepSqlValue($dip_total_two) . ",
		`profes_board_two`=" . prepSqlValue($dip_board_two) . ",

		`profes_certificate_three`=" . prepSqlValue($dip_name_three) . ",
		`profes_obtained_marks_three`=" . prepSqlValue($dip_obt_three) . ",
		`profes_total_marks_three`=" . prepSqlValue($dip_total_three) . ",
		`profes_board_three`=" . prepSqlValue($dip_board_three) . "
	   
		WHERE `said` = '$userid'";
		$exe = mysqli_query($conn, $query);
		if (!$exe) {
			echo die(mysqli_error($conn));
		} else {
			echo 1;
			//exit();
		}
	} else {
		$query = "INSERT INTO `qualification`(
			`primary_title`, `primary_specialization`, `primary_total_marks`, `primary_board`,
			`middle_title`, `middle_specialization`, `middle_total_marks`, `middle_board`,
			`matric_title`, `matric_specialization`, `matric_total_marks`, `matric_board`, 
			`inter_title`, `inter_specialization`, `inter_total_marks`, `inter_board`, 
			`bs_title`, `bs_specialization`, `bs_total_marks`, `bs_board`,
			`bs16_title`, `bs16_specialization`, `bs16_total_marks`, `bs16_board`,
			`ms_title`, `ms_specialization`, `ms_total_marks`, `ms_board`, 
			`profes_certificate`, `profes_obtained_marks`, `profes_total_marks`, `profes_board`, 
			`profes_certificate_two`, `profes_obtained_marks_two`, `profes_total_marks_two`, `profes_board_two`, 
			`profes_certificate_three`, `profes_obtained_marks_three`, `profes_total_marks_three`, `profes_board_three`, 
			`said`
		) VALUES (
			" . prepSqlValue($Primary_title) . ", " . prepSqlValue($Primary_specialization) . ", " . prepSqlValue($primary_total_marks) . ", " . prepSqlValue($primary_board) . ", 
			" . prepSqlValue($Middle_title) . ", " . prepSqlValue($Middle_specialization) . ", " . prepSqlValue($middle_total_marks) . ", " . prepSqlValue($middle_board) . ",
			" . prepSqlValue($matric_title) . ", " . prepSqlValue($matric_spec) . ", " . prepSqlValue($matric_total) . ", " . prepSqlValue($matric_board) . ", 
			" . prepSqlValue($inter_title) . ", " . prepSqlValue($inter_spec) . ", " . prepSqlValue($inter_total) . ", " . prepSqlValue($inter_board) . ", 
			" . prepSqlValue($bs_title) . ", " . prepSqlValue($bs_spec) . ", " . prepSqlValue($bs_total) . ", " . prepSqlValue($bs_board) . ",
			" . prepSqlValue($bs16_title) . ", " . prepSqlValue($bs16_specialization) . ", " . prepSqlValue($bs16_total_marks) . ", " . prepSqlValue($bs16_board) . ",
			" . prepSqlValue($ms_title) . ", " . prepSqlValue($ms_spec) . ", " . prepSqlValue($ms_total) . ", " . prepSqlValue($ms_board) . ", 
			" . prepSqlValue($dip_name_one) . ", " . prepSqlValue($dip_obt_one) . ", " . prepSqlValue($dip_total_one) . ", " . prepSqlValue($dip_board_one) . ", 
			" . prepSqlValue($dip_name_two) . ", " . prepSqlValue($dip_obt_two) . ", " . prepSqlValue($dip_total_two) . ", " . prepSqlValue($dip_board_two) . ", 
			" . prepSqlValue($dip_name_three) . ", " . prepSqlValue($dip_obt_three) . ", " . prepSqlValue($dip_total_three) . ", " . prepSqlValue($dip_board_three) . ", 
			'$userid'
		)";
				
		$exe = mysqli_query($conn, $query);
		if (!$exe) {
			echo die(mysqli_error($conn));
		} else {
			echo 1;
			//exit();
		}
	}
} else {
	header("Location: index.php");
}