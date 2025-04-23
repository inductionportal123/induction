<?php
include('../connection/conn.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['user_name'],$_SESSION['user_access'])){
	$user = $_SESSION['user_name'];
  $userid = $_SESSION['user_access'];

	$arr = explode(' ',trim($user));
	$newuser  = ucfirst("$arr[0]");
  }

$pending = 'Null';
if(isset($_POST['pending'])){
    $pending = "ok";
}

$pagenum = $_POST['submit1'];
$q = $_POST['id'];
$pid = $_POST['pid'];
$rej = "UPDATE `details` SET `d_status`='Rejected' , `act_by`='$user' WHERE `d_postid` = '$pid' AND `d_said` = '$q'";
$exerej = mysqli_query($conn, $rej);

if($pending == "ok"){
    if($pagenum == 1){
        header('location: pending.php?post2='.$pid.'&submit1=Show+Applications');
    }
    else if($pagenum > 1)
    {
        header('location: pending.php?post2='.$pid.'&submit1=Show+Applications&pageno='.$pagenum);
    }
	
}
else{


if($pagenum == 1){
        header('location: allapplication.php?post2='.$pid.'&submit1=Show+Applications');
    }
    else if($pagenum > 1)
    {
        header('location: allapplication.php?post2='.$pid.'&submit1=Show+Applications&pageno='.$pagenum);
    }
}
?>