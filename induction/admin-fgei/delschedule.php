<?php
include('../connection/conn.php');
$id = $_GET['id'];

$del = "DELETE FROM `test_schedule` WHERE id='$id'";
$exedel = mysqli_query($conn, $del);

header('location: schedule.php');

?>