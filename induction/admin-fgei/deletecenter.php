<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `centes` WHERE id = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: centers.php");


?>