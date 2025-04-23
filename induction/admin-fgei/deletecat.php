<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `post_details` WHERE pid = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: category.php");


?>