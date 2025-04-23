<?php
session_start();
include('connection/conn.php');


$cnics = $_POST['login_cnic'];
$pass = $_POST['login_password'];


$query = "SELECT * FROM `acount_details` WHERE `cnic` = '".$cnics."' and `password` = '".$pass."'  ";


$exe = mysqli_query($conn,$query);
$rows = mysqli_fetch_array($exe);
$rowcount = mysqli_num_rows($exe);



if ($rowcount == 1)
{

				$_SESSION['u_name'] = $rows['name'];
				$_SESSION['u_id'] = $rows['id'];
				echo 1;
}


else
{
				echo 0;	
}

?>