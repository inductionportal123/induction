<?php
ob_start();
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
if(isset($_POST['submit1']))
{
    $pagenum = $_POST['submit1'];
    $x = "Approved";
    $newquery = "SELECT series, abv FROM `posts` where pid=$pid";
    $newdatas = mysqli_query($conn,$newquery);
    $newrowct = mysqli_num_rows($newdatas);
    if($newrowct>0)
    {
        while ($newrowss = mysqli_fetch_array($newdatas))
        {
            $series=$newrowss['series'];
            $abb = $newrowss['abv'];
        }
    }
    $series=$series+1;
    $series=sprintF("%04d",$series);
    $roll=$abb.'-'.$series;
    $query12 = "UPDATE `details` SET `d_rollno`='$roll',`d_status`='$x', `act_by`='$user' WHERE d_said='$q' AND d_postid='$pid'"; 
    $exe12 = mysqli_query($conn,$query12);
    $query13 = "UPDATE `posts` SET `series` = $series WHERE `posts`.`pid` = $pid";
    $run13 = mysqli_query($conn,$query13);

mysqli_close($conn);
    
}
if($pending == "ok")
{
    header('location: pending.php?post2='.$pid.'&submit1=Show+Applications');
}
else
{
    header('location: allapplication.php?post2='.$pid.'&submit1=Show+Applications');
}

?>