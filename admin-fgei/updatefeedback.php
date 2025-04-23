<?php
include('../connection/conn.php');

$x = "rejected";
$q = $_GET['stu_id'];
$pages = $_GET['pagen'];
$feed = $_POST['message'];

    $query = " UPDATE `per_info` SET `status_app` = '$x' , `feedback`= '$feed' WHERE said = $q ";  


$exe = mysqli_query($conn,$query);

		if(!$exe)
		{
			die(mysqli_error($conn));
		}

	if($pages>0)
	{
		header("Location: allapplication.php?page=$pages");
	}
	else
	{
		header("Location: allapplication.php");
	}

?>