<?php
session_start();
include('../connection/conn.php');


$admin = $_POST['admin'];
$pass = $_POST['pass'];



$query = "SELECT * FROM `admin` WHERE `name` = '".$admin."' and `pass` = '".$pass."' ";


$exe = mysqli_query($conn,$query);
$rows = mysqli_fetch_array($exe);
$rowcount = mysqli_num_rows($exe);

mysqli_close($conn);


if ($rowcount == 1)
{

				$_SESSION['user_name'] = $rows['name'];
				$_SESSION['user_access'] = $rows['role'];
                $_SESSION['user_id'] = $rows['id'];
                if($rows['role'] == 'Admin'){
                    header('Location:pending.php');
                }
                else if($rows['role'] == 'Read Only'){
                    header('Location:pending.php');
                }
                else{
                    header('Location:pending.php');
                }
				

}


else
{

//echo "sss";

header('Location:index.php?password=false');
	
}

?>