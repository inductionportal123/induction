<?php
include('connection/conn.php');

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
 
  
  if(isset($_SESSION['u_name'],$_SESSION['u_id']))
{
     
	$user = $_SESSION['u_name'];
  $userid = $_SESSION['u_id'];

	$arr = explode(' ',trim($user));
	$newuser  = ucfirst("$arr[0]");




if($_POST['bank'] == 1)
{
      echo 'ali';
exit;
  $fees  = "SELECT * FROM bank_fee WHERE id = 1";
  $feesexe = mysqli_query($conn, $fees);
  $feedata = mysqli_fetch_array($feesexe);
  $bank_fee =   $feedata['fee'];
  $series = $feedata['series'];
  $series++;
    $sqlupdate = "UPDATE `bank_fee` SET `series`='$series' WHERE id= 1";
    $updateexe = mysqli_query($conn, $sqlupdate);
    $series=sprintF("%05d",$series);
    
    
  $bank_name = "National Bank of Pakistan";
  $bank_account = "4016152671";
    


$newquery = "SELECT * FROM per_info INNER JOIN post_apply
          ON per_info.said=post_apply.said where per_info.said = $userid";

			$newexe = mysqli_query($conn,$newquery);
			$newrow = mysqli_fetch_array($newexe);
			$newrowcount = mysqli_num_rows($newexe);


			if($newrowcount == 1) 
			{
				$x = $newrow['post_apply'];
				$emp_name = $newrow['basic_full_name'];
				$emp_father = $newrow['basic_father_name'];
                $cnic = $newrow['contact_cnic'];
                
			}
			if(isset($x))
			{
				$value = explode(",", $x);
				$result = strtolower("'" . implode ( "', '", $value ) . "'");
				$covalue  = count($value);
				$total = '';
        $posts = '';
				
				$querys = "SELECT fee_slot.slot,fee_slot.fee,posts.abv 
FROM `fee_slot` 
JOIN posts ON posts.pid = fee_slot.post_id 
WHERE `post_id` IN ($result)";
							$exes = mysqli_query($conn,$querys);

 while ($rows = mysqli_fetch_array($exes))
{
      $total = (int)($total) + (int)($rows['fee']);

      $posts .= $rows['abv'].',';

}


// $total = ($total) + ($bank_fee);

// convertion amount to words
function AmountInWords($amount)
{
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   // return $implode_to_Rupees;

   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}
 $get_amount = AmountInWords($total);

$getwords = json_encode(preg_replace('/\s\s+/', ' ', $get_amount));

$getst =  trim($getwords,'"');;




require_once('fpdi2/src/autoload.php');
require("fpdf/fpdf.php");
$pdf= new FPDF();
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage();


$pdf->setSourceFile('nbpslip.pdf'); 

$tplIdx = $pdf->importPage(1);

$pdf->useTemplate($tplIdx, 1, 13, 200);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(30, 28);
$pdf->Write(0, "Challan# ".$series);   

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(95, 28);
$pdf->Write(0, "Challan# ".$series);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(158, 28);
$pdf->Write(0, "Challan# ".$series);                
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(25, 71);
$pdf->Write(0, $emp_name);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(89, 71);
$pdf->Write(0, $emp_name);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(153, 71);
$pdf->Write(0, $emp_name);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(21, 75);
$pdf->Write(0, $emp_father);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(85, 75);
$pdf->Write(0, $emp_father);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(149, 75);
$pdf->Write(0, $emp_father);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(21, 81);
$pdf->Write(0, $cnic);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(85, 81);
$pdf->Write(0, $cnic);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(149, 81);
$pdf->Write(0, $cnic);

                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(9, 91);
$pdf->Write(0, $posts);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(72, 91);
$pdf->Write(0, $posts);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(138, 91);
$pdf->Write(0, $posts);                
                         
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(21, 97);
$pdf->Write(0, $total);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(85, 97);
$pdf->Write(0, $total);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(149, 97);
$pdf->Write(0, $total);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(8, 106);
$pdf->Write(0, $getst."Only");                
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(71, 106);
$pdf->Write(0, $getst."Only");
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(137, 106);
$pdf->Write(0, $getst."Only");
               
}

$pdf->output();
}
      
elseif($_POST['bank'] == 2)
{
   
  $fees  = "SELECT * FROM bank_fee WHERE id = 2";
  $feesexe = mysqli_query($conn, $fees);
  $feedata = mysqli_fetch_array($feesexe);
  $bank_fee =   $feedata['fee'];  
  $bank_name = "United Bank Limited";
  $bank_account = "000269686036";
    $series = $feedata['series'];
  $series++;
    

    
    $sqlupdate = "UPDATE `bank_fee` SET `series`='$series' WHERE id= 2";
    $updateexe = mysqli_query($conn, $sqlupdate);
    $series=sprintF("%05d",$series);
    


$newquery = "SELECT *
 FROM per_info INNER JOIN post_apply
          ON per_info.said=post_apply.said where per_info.said = $userid";

			$newexe = mysqli_query($conn,$newquery);
			$newrow = mysqli_fetch_array($newexe);
			$newrowcount = mysqli_num_rows($newexe);


			if($newrowcount == 1) 
			{
				$x = $newrow['post_apply'];
				$emp_name = $newrow['basic_full_name'];
				$emp_father = $newrow['basic_father_name'];
                $cnic = $newrow['contact_cnic'];
			}
			if(isset($x))
			{
				$value = explode(",", $x);
				$result = strtolower("'" . implode ( "', '", $value ) . "'");
				$covalue  = count($value);
				$total = '';
        $posts = '';
				
			
		
				$querys = "SELECT fee_slot.slot,fee_slot.fee,posts.abv 
FROM `fee_slot` 
JOIN posts ON posts.pid = fee_slot.post_id 
WHERE `post_id` IN ($result)";
							$exes = mysqli_query($conn,$querys);
	
 while ($rows = mysqli_fetch_array($exes))
{
      $total = (int)($total) + (int)($rows['fee']);

      $posts .= $rows['abv'].',';
      

}


$total = ($total) + ($bank_fee) ;

// echo is_numeric($total);
// break;

// convertion amount to words
function AmountInWords($amount)
{
    
   $amount_after_decimal = round($amount - ($num = floor($amount)), 2) * 100;
   // Check if there is any number after decimal
   $amt_hundred = null;
   $count_length = strlen($num);
   $x = 0;
   $string = array();
   $change_words = array(0 => '', 1 => 'One', 2 => 'Two',
     3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
     7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
     10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
     13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
     16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
     19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
     40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
     70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $here_digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $x < $count_length ) {
      $get_divider = ($x == 2) ? 10 : 100;
      $amount = floor($num % $get_divider);
      $num = floor($num / $get_divider);
      $x += $get_divider == 10 ? 1 : 2;
      if ($amount) {
       $add_plural = (($counter = count($string)) && $amount > 9) ? 's' : null;
       $amt_hundred = ($counter == 1 && $string[0]) ? ' and ' : null;
       $string [] = ($amount < 21) ? $change_words[$amount].' '. $here_digits[$counter]. $add_plural.' 
       '.$amt_hundred:$change_words[floor($amount / 10) * 10].' '.$change_words[$amount % 10]. ' 
       '.$here_digits[$counter].$add_plural.' '.$amt_hundred;
        }
   else $string[] = null;
   }
   $implode_to_Rupees = implode('', array_reverse($string));
   $get_paise = ($amount_after_decimal > 0) ? "And " . ($change_words[$amount_after_decimal / 10] . " 
   " . $change_words[$amount_after_decimal % 10]) . ' Paise' : '';
   // return $implode_to_Rupees;

   return ($implode_to_Rupees ? $implode_to_Rupees . 'Rupees ' : '') . $get_paise;
}
 $get_amount = AmountInWords($total);

$getwords = json_encode(preg_replace('/\s\s+/', ' ', $get_amount));

$getst =  trim($getwords,'"');;



require_once('fpdi2/src/autoload.php');
require("fpdf/fpdf.php");
$pdf= new FPDF();
$pdf = new \setasign\Fpdi\Fpdi();
$pdf->AddPage();


$pdf->setSourceFile('ublslip.pdf'); 

$tplIdx = $pdf->importPage(1);

$pdf->useTemplate($tplIdx, 1, 13, 200);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(30, 28);
$pdf->Write(0, "Challan# ".$series);   

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(95, 28);
$pdf->Write(0, "Challan# ".$series);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('8');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(158, 28);
$pdf->Write(0, "Challan# ".$series);                
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(25, 71);
$pdf->Write(0, $emp_name);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(89, 71);
$pdf->Write(0, $emp_name);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(153, 71);
$pdf->Write(0, $emp_name);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(21, 75);
$pdf->Write(0, $emp_father);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(85, 75);
$pdf->Write(0, $emp_father);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(149, 75);
$pdf->Write(0, $emp_father);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(21, 81);
$pdf->Write(0, $cnic);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(85, 81);
$pdf->Write(0, $cnic);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('9');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(149, 81);
$pdf->Write(0, $cnic);

                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(9, 91);
$pdf->Write(0, $posts);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(72, 91);
$pdf->Write(0, $posts);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(138, 91);
$pdf->Write(0, $posts);                
                         
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(21, 97);
$pdf->Write(0, $total);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(85, 97);
$pdf->Write(0, $total);
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(149, 97);
$pdf->Write(0, $total);

$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(8, 106);
$pdf->Write(0, $getst."Only");                
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(71, 106);
$pdf->Write(0, $getst."Only");
                
$pdf->SetFont('Helvetica');
$pdf->SetFontSize('7');
$pdf->SetTextColor(0,0,0);
$pdf->SetXY(137, 106);
$pdf->Write(0, $getst."Only");                
                
}

$pdf->output();
}      
      
else{
	echo "Record not found";
}

}

else{
  header("Location: index.php");
}

?>