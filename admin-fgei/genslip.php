<?php
include('../connection/conn.php');

    echo $slotid = $_POST['slotid'];
    echo $rollno = $_POST['rollno'];

    $slot = "UPDATE `selected_rollno` SET `slotid` = '$slotid'  WHERE `sel_rollno` = '$rollno' ";
    $exeslot = mysqli_query($conn, $slot);

    header('location: importresult.php');
    
?>