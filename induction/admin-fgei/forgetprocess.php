<?php


include('connection/conn.php');



			$mails = $_POST['email'];

			$query = "SELECT * FROM `acount_details` WHERE email = '".$mails."'";
			$exe = mysqli_query($conn,$query);
			$rowcount = mysqli_num_rows($exe);

			if($rowcount == 1)
{

				$row = mysqli_fetch_array($exe);

				$ids = $row['id'];


    require 'PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

$mail->CharSet = 'UTF-8';
$mail->Host = 'fgeirecruitment.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;
$mail->isHTML(true);

$mail->Username = 'no-reply@fgeirecruitment.com';
$mail->Password = 'Rec@#786+1';
$mail->setFrom('no-reply@fgeirecruitment.com');
$mail->addAddress($mails);


$mail->Subject = 'Password Reset';
$mail->Body    = '<!DOCTYPE html>
							<html lang="en">
							<head>
							<style>
								.button {
								  background-color: #4CAF50;
								  border: none;
								  color: white;
								  padding: 10px 22px;
								  text-align: center;
								  text-decoration: none;
								  display: inline-block;
								  font-size: 16px;
								  margin: 4px 2px;
								  cursor: pointer;
								}
								</style>
							</head>
							<body>
							  
							<div style="background-color:#F5F5F5; padding-top:30px; padding-bottom:60px">
							
							  <p style="text-align:center; font-family: Arial, Helvetica, sans-serif;">Thanks for your registration, Please click the link below to activate your account. </p> 


							      <div style="text-align:center">
							               <a href="https://fgeirecruitment.com/passwordchange.php?stu_id='.$ids.'"> <button class="button">Reset Password</button> </a>
							      </div>                                                         
                                							      
							      </div>
							</body>
							</html>';


						if($mail->send()){ 
						   	header("Location: forgetpassword.php?emails=true");
						}else{ 
						   echo 'Email sending failed.'; 
						}

}

else
{
	header("Location: forgetpassword.php?emails=false");

}

?>