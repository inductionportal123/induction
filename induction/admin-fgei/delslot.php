<?php
include('../connection/conn.php');
$id = $_GET['id'];

$del = "DELETE FROM `interview_slots` WHERE id='$id'";
$exedel = mysqli_query($conn, $del);

header('location: interviewslots.php');

?>