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

// if(isset($_POST['agree']))
// {

// 		$query = "UPDATE `per_info` SET `undertaking`= 1 WHERE said = $userid ";
// 		$exe = mysqli_query($conn,$query);
// 			if(!$exe)
// 			{
// 			echo die(mysqli_error($conn));
// 			}
// 			else
// 			{
// 				header("Location: profile.php");
// 			}
// }


if (isset($_POST['agree'])) {
    $currentDateTime = date('Y-m-d H:i:s');
    $query = "UPDATE `per_info` SET `undertaking` = 1, `undertaking_date` = '$currentDateTime' WHERE said = $userid";
    
    $exe = mysqli_query($conn, $query);

    if (!$exe) {
        die(mysqli_error($conn));
    } else {
        header("Location: profile.php");
        exit(); 
    }
}



}
else{
  header("Location: index.php");
}
?>	