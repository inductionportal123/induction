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

    if (isset($_GET['id']))
     { 
        $sid=$_GET['id'];
        $postid = $_GET['postid'];
        $x='Pending';
        $querynew1 = "UPDATE `details` SET `d_status`='$x', `act_by`='$user' WHERE d_postid='$sid' and d_said='$postid'"; 
        $exe12 = mysqli_query($conn,$querynew1);
        // print_r($querynew1);
        header("Location: approvedemp.php");
        }

}







?>