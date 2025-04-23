<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `region` WHERE id = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: region.php");


?>