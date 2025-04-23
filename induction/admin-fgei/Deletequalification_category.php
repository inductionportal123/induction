<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `qualification_category` WHERE id = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: Qualification_Cate.php");


?>