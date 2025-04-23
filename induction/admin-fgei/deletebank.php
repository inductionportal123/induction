<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `bank_fee` WHERE id = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: bankfee.php");


?>