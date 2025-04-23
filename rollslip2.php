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
  $arr = explode(' ',trim($user));
 $newuser  = ucfirst("$arr[0]");

        $postid = $_POST['postid'];
        $rollnum = $_POST['rollno'];
        $centerid = $_POST['centerid'];
      
      $postquery1 = "SELECT * FROM `posts` WHERE pid='$postid'";
      $postexe1 = mysqli_query($conn,$postquery1);
      $postrows1 = mysqli_fetch_array($postexe1);
      $postrowcount1 = mysqli_num_rows($postexe1);
      if($postrowcount1=1)
      {
            $postname = strtoupper($postrows1['name']);
            $postgender = strtoupper($postrows1['gender']);
            $postbps = strtoupper($postrows1['bps']);
      }
      
      
      
      $centerquery1 = "SELECT `center` FROM `centes` WHERE id='$centerid'";
      $centerexe1 = mysqli_query($conn,$centerquery1);
      $centerrows1 = mysqli_fetch_array($centerexe1);
      $centerrowcount1 = mysqli_num_rows($centerexe1);
      if($centerrowcount1=1)
      {
            $centername = strtoupper($centerrows1['center']);
      }
      
      
      
      $datequery = "SELECT `date_time` FROM `test_schedule` WHERE post_id='$postid'";
      $dateexe = mysqli_query($conn,$datequery);
      $daterows = mysqli_fetch_array($dateexe);
      $daterowcount = mysqli_num_rows($dateexe);
      if($daterowcount=1)
      {
           $date = $daterows['date_time'];
      }
      $dt = new DateTime($date);
      $datesep = $dt->format('d-M-Y');
      $timesep = $dt->format('H:i:sA');
      $day = $dt->format('D');
  
        $pic = "SELECT image FROM emp_document WHERE said='$userid'";
        $exepic = mysqli_query($conn, $pic);
        $picrow = mysqli_num_rows($exepic);
        if($picrow > 0)
        {
            $picdata = mysqli_fetch_array($exepic);
        }
      
      
      $query = "SELECT * FROM per_info WHERE said='$userid'";
$exe = mysqli_query($conn,$query);
$rows = mysqli_fetch_array($exe);
$rowcount = mysqli_num_rows($exe);

//$center = $rows['exam_center'];


if($rowcount=1)
{
        ob_start();
		$name = $rows['basic_full_name'];
		$fathername = $rows['basic_father_name'];
    $cnic = $rows['contact_cnic'];
    
		


require_once('fpdi2/src/autoload.php');
require("fpdf/fpdf.php");
$pdf= new FPDF();
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage();


$pdf->setSourceFile('slip.pdf'); 

$tplIdx = $pdf->importPage(1);

$pdf->useTemplate($tplIdx, 1, 13, 200);

    $target1 = $picdata['image'];
$ext = pathinfo($target1, PATHINFO_EXTENSION);
			
//echo $target1;
//echo ' - ';
//echo $ext; 

    //  if($ext == "jpg" ) {

//$pdf->Image($picdata['image'],140,78,40,37);
    				
	//		}
//			else{

		$pdf->SetFont('Helvetica');
		$pdf->SetFontSize('13');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY(148, 85);
		$pdf->Write(0, "Paste Your");

		$pdf->SetFont('Helvetica');
		$pdf->SetFontSize('13');
		$pdf->SetTextColor(0,0,0);
		$pdf->SetXY(148, 95);
		$pdf->Write(0, "Picture Here");

	//		}
    
    
    
    
$pdf->SetFont('Helvetica','B',12);
$pdf->SetFontSize('12');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(86, 153);
$pdf->Write(0, $rollnum);


$pdf->SetFont('Helvetica');
$pdf->SetFontSize('13');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(63, 98);
$pdf->Write(0, $name);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('13');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(63, 112);
$pdf->Write(0, $fathername);
    
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('13');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(62, 124);
$pdf->Write(0, $cnic); 

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('13');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(62, 134);
$pdf->Write(0, $postname." (".$postgender.") BPS-"."(".$postbps.")");      


$pdf->SetFont('Helvetica');
$pdf->SetFontSize('12');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(35, 174);
$pdf->Write(0, $datesep);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('12');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(60, 174);
$pdf->Write(0, "(".$day.")");    
    
    //Time 
    
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('12');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(125, 174);
$pdf->Write(0, $timesep);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('10');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(20, 193);
$pdf->Write(0, $centername);


$text1 = "5. Bring your own writing material along with Original Bank deposit slip and roll number slip.";

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('10');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(25, 235);
$pdf->Write(0, $text1);


$text2 = "6. No mobile phone or extra luggage will be allowed (No collection points available)";

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('10');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(25, 240);
$pdf->Write(0, $text2);


$text4 = "Please Observe COVID-19 SOPs strictly";

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('12');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(60, 250);
$pdf->Write(0, $text4);



$pdf->output();
ob_end_flush();
}
}

else{
  header("Location: index.php");
}
?>