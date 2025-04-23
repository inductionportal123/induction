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


	$query = "SELECT * FROM post_apply INNER JOIN appstatus ON appstatus.s_candid=post_apply.said
INNER JOIN per_info ON per_info.said = post_apply.said INNER JOIN emp_document ON emp_document.said=post_apply.said
WHERE appstatus.s_status = 'Approved' AND post_apply.said='2'";






$exe = mysqli_query($conn,$query);
$rows = mysqli_fetch_array($exe);
$rowcount = mysqli_num_rows($exe);

//$center = $rows['exam_center'];


if($rowcount=1)
{
		$name = $rows['basic_full_name'];
		//$testdate = $rows['date'];
		//$grp = $rows['choice_group'];

		$fathername = $rows['basic_father_name'];
		$rollnogen = $rows['rollno'];
		


require_once('fpdi2/src/autoload.php');
require("fpdf/fpdf.php");
$pdf= new FPDF();
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage();


$pdf->setSourceFile('slip.pdf'); 

$tplIdx = $pdf->importPage(1);

$pdf->useTemplate($tplIdx, 1, 13, 200);

$pdf->SetFont('Helvetica','B',12);
$pdf->SetFontSize('12');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(90, 137);
$pdf->Write(0, $rollnogen);

// $target1 = $rows['image'];
////    <img src="data:image/jpeg;base64,'.base64_encode( stripslashes($rows[image]) ).'"/>
////        echo '<img src="data:Image/jpeg;base64,'.base64_encode( stripslashes($rows['image']) ).'"/>';
//
//$ext = pathinfo($target1, PATHINFO_EXTENSION);
//		$pdf->Image($rows['image'],145,75,38,38,$ext);
//
////		$pdf->SetFont('Helvetica');
////		$pdf->SetFontSize('13');
////		$pdf->SetTextColor(0,0,0);
////		$pdf->SetXY(148, 85);
////		$pdf->Write(0, "Place Your");
////
////		$pdf->SetFont('Helvetica');
////		$pdf->SetFontSize('13');
////		$pdf->SetTextColor(0,0,0);
////		$pdf->SetXY(148, 95);
////		$pdf->Write(0, "Picture Here");
//
//			







$current_year = date('Y');

$pdf->SetFont('Helvetica','B');
$pdf->SetFontSize('14');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(72, 97);
$pdf->Write(0, "CLASS XI- " . $current_year ." ENTRY");


$pdf->SetFont('Helvetica');
$pdf->SetFontSize('13');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(62, 108);
$pdf->Write(0, $name);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('13');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(62, 119);
$pdf->Write(0, $fathername);


$date = date("Y/m/d");
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('12');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(25, 159);
$pdf->Write(0, $date);


$pdf->SetFont('Helvetica');
$pdf->SetFontSize('11');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(60, 180);
$pdf->Write(0, "Exam Center Cadet College Hassan Abdal");

$pdf->output();
}
}
else{
  header("Location: index.php");
}
?>