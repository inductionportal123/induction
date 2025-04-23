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
}
$pending = 'Null';
if(isset($_POST['pending']))
{
    $pending = "ok";
}
$q = $_POST['id'];
$pid = $_POST['pid'];
$rej = "UPDATE `details` SET `d_status`='Doubted' , `act_by`='$user' WHERE `d_postid` = '$pid' AND `d_said` = '$q'";   
$exerej = mysqli_query($conn, $rej);
mysqli_close($conn);

if($pending == "ok")
{
    header("location: pending.php?post2=$pid&submit1=Show+Applications");
}
else
{
    header("Location: allapplication.php?post2=$pid&submit1=Show+Applications");
}
?>