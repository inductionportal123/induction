<?php
include('../connection/conn.php');

$id = $_GET['cid'];



        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	$cat_nop = $_POST['nop'];
                $cat_min = $_POST['min_age'];
                $cat_max = $_POST['max_age'];
            $req = $_POST['requirements'];

        	$query = "UPDATE `post_details` SET `nop`='$cat_nop',`min`='$cat_min',`max`='$cat_max' ,`requirements`='$req' WHERE pid = '$id'";


        	$exe = mysqli_query($conn,$query);

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
				else
				{
						header('Location:category.php?update=success');

	
				}

        } 

        ?>