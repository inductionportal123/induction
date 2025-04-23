<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `fee_slot` WHERE id = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: feeslot.php");


?>