<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `admin` WHERE id = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: createusers.php");


?>