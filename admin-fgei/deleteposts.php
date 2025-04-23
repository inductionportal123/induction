<?php

include('../connection/conn.php');

$id = $_GET['id'];

$query = "DELETE FROM `posts` WHERE pid = '".$id."'";

$exe = mysqli_query($conn,$query);

header("Location: createpost.php");


?>