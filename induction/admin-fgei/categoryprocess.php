<?php
include('../connection/conn.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $cat_name = $_POST['post'];
    $req_deg = $_POST['req_deg'];
    $cat_nop = $_POST['nop'];
    $cat_min = $_POST['min_age'];
    $cat_max = $_POST['max_age'];
    $cat_req = $_POST['requirements'];
    
    $query = "INSERT INTO `post_details`(`req_deg`,`nop`,`min`,`max`,`requirements`,`pid`) 
    VALUES('$req_deg', '$cat_nop','$cat_min','$cat_max','$cat_req','$cat_name')";
    $exe = mysqli_query($conn,$query);
    if(!$exe)
    {
        die(mysqli_error($conn));
    }
    else
    {
        header('Location:category.php?insert=sucs');
    }
}
?>
