<?php

include('connection/conn.php');

	$name = $_POST['fname'];
	$email = $_POST['mail'];
	$c_no = $_POST['cnic'];
	$p_no = $_POST['pass'];


			$query = "SELECT cnic FROM `acount_details` WHERE cnic = '".$c_no."'";
			$exe = mysqli_query($conn,$query);
			$rowcount = mysqli_num_rows($exe);
			if($rowcount == 1)
			{
				$conn->close();	
				echo 0;			
			}
			else
			{
				$query1 = "INSERT INTO `acount_details`(`name`, `email`, `cnic`, `password`) VALUES ('$name','$email','$c_no','$p_no')";
				$exe1 = mysqli_query($conn,$query1);
				$conn->close();
				echo 1;
			}



?>