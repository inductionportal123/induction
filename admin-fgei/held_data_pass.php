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

$stu_id = $_POST['stu_id'];
$post_id = $_POST['post_id'];
$feed = $_POST['mesg_info'];
$revert=$_POST['option'];
$x = 'Rejected';


     $querynew = "UPDATE `details` SET `d_status`='$x',`d_feedback`='$feed',  `revert`='$revert', `act_by`='$user' WHERE d_said='$stu_id' AND d_postid='$post_id'"; 
    $exe12 = mysqli_query($conn,$querynew);
    echo 1;


?>