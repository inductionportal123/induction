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


$oldpass = $_POST['oldpass'];
$newpass = $_POST['newpass'];
$confirmpass = $_POST['confirmpass'];

$query = "SELECT `password` FROM `acount_details` WHERE `password` = '$oldpass'";
$exe = mysqli_query($conn,$query);
$count = mysqli_num_rows($exe);
$rows = mysqli_fetch_array($exe);

if($count == 1)
{
	$querys = "UPDATE `acount_details` SET `password`='$newpass' WHERE `id` = '$userid'";
	$exes = mysqli_query($conn,$querys);
  if(!$exes)
  {
    echo "Error in query";
    exit();
  }
  else
  {
    echo 1;
    exit();
  }

}
else
{
	echo "Please enter correct old password";
}

}
else{
  header("Location: index.php");
}


?>