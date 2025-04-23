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
    
    $postname = $_POST['postname'];
    $slotid = $_POST['slotid'];
    
    $query = "SELECT * FROM per_info WHERE said='$userid'";
    $exe = mysqli_query($conn,$query);
    $rows = mysqli_fetch_array($exe);
    $name = $rows['basic_full_name'];
    $fathername = $rows['basic_father_name'];
    $cnic = $rows['contact_cnic'];
    
    
    $datequery = "SELECT `date_time`, `region` FROM `interview_slots` WHERE id='$slotid'";
    $dateexe = mysqli_query($conn,$datequery);
    $daterows = mysqli_fetch_array($dateexe);
    $daterowcount = mysqli_num_rows($dateexe);
    if($daterowcount=1)
    {
        $date = $daterows['date_time'];
        $reg = $daterows['region'];
    }
    
    $adress ="SELECT `contact`, `address` FROM `region_details` WHERE `region_name` = '$reg'";
    $exeaddress = mysqli_query($conn, $adress);
    $dataaddress = mysqli_fetch_array($exeaddress);
    $con = $dataaddress['contact'];
    $ad = $dataaddress['address'];
    
    $dt = new DateTime($date);
    $datesep = $dt->format('d-M-Y');
    $timesep = $dt->format('H:i:sA');
    $day = $dt->format('D');
    
    ob_start();
    
    require_once('fpdi2/src/autoload.php');
    require("fpdf/fpdf.php");
    $pdf= new FPDF();
    $pdf = new \setasign\Fpdi\Fpdi();
    $pdf->AddPage();
    $pdf->setSourceFile('letter.pdf');
    $tplIdx = $pdf->importPage(1);
    $pdf->useTemplate($tplIdx, 1, 13, 200);
    
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('11');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(55, 45);
    $pdf->Write(0, $name);
    
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('11');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(126, 45);
    $pdf->Write(0, $fathername);
    
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('11');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(123, 62);
    $pdf->Write(0, $postname);

    
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('11');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(125, 72);
    $pdf->Write(0, $datesep);
    
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('11');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(80, 72);
    $pdf->Write(0, $timesep);
    
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('11');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(42, 80);
    $pdf->Write(0, $ad);
    
    $pdf->SetFont('Helvetica');
    $pdf->SetFontSize('11');
    $pdf->SetTextColor(0,0,0);
    $pdf->SetXY(42, 90);
    $pdf->Write(0, "Ph# ".$con);


$pdf->output();
ob_end_flush();
}

else{
  header("Location: index.php");
}
?>