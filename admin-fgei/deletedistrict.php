<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `district` WHERE id = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: district.php");


?>