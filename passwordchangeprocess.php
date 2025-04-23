<?php
include('connection/conn.php');

$stuid = $_GET['id'];

$password1 = $_POST['pass'];
$password2 = $_POST['conpass'];


if($password1 == $password2){

$query = "UPDATE `acount_details` SET `password`='$password1' WHERE email = '$stuid'";

			$exe = mysqli_query($conn,$query);

			header("Location: index.php?changepas=ok");

}

else{

	header("Location: passwordchange.php?password=false");
}

?>