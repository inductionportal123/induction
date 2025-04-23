<?php
include('../connection/conn.php');

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['user_name'],$_SESSION['user_access']))
{
	

$conn->close();
unset($_SESSION["user_name"]);
session_destroy();
header("Location: index.php");


}

else{
  header("Location: index.php");
}

?>