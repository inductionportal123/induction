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
$city_prefer = $_POST['city_prefer'];
$x = 'Approved';
$series = 0;

 $query = "SELECT `series`,`abv` FROM `posts` WHERE pid=$post_id";
    $data = mysqli_query($conn,$query);
    $row = mysqli_fetch_array($data);
    if($row['series'] == '')
    {
    	$series = 1;
    }
    else{
    	 $series=$row['series']+1;
    }
    $series=sprintF("%05d",$series);
    $abb = $row['abv'];
    $roll=$abb.'-'.$series;

     $querynew = "UPDATE `details` SET `d_rollno`='$roll',`d_status`='$x', `act_by`='$user' WHERE d_said='$stu_id' AND d_postid='$post_id'"; 
    $exe12 = mysqli_query($conn,$querynew);

    $query13 = "UPDATE `posts` SET `series` = $series WHERE `posts`.`pid` = $post_id";
    $run13 = mysqli_query($conn,$query13);
    echo 1;


?>
