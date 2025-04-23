<?php
include('../connection/conn.php');
if(!isset($_SESSION)) 
{ 
    session_start(); 
}

if(isset($_SESSION['user_name'],$_SESSION['user_access']))
{
    $user = $_SESSION['user_name'];
    $userid = $_SESSION['user_access'];
    $arr = explode(' ',trim($user));
	$newuser  = ucfirst("$arr[0]");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - Posts</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
<?php
    include('header.php');
    include('postnav.php');
    $id = $_GET['id'];
    $query2 = "SELECT * FROM `post_details` WHERE `pid` = '$id' ";
    $exe2 = mysqli_query($conn,$query2);
    $rows2 = mysqli_fetch_array($exe2);
    $rowcount2 = mysqli_num_rows($exe2);
    $arrg1 = " SELECT * FROM `posts` where pid = $id ";
    $result1 = mysqli_query($conn,$arrg1);
    $row2x = mysqli_fetch_array($result1);
    if($rowcount2 == 1)
    {
        $req_deg = $rows2['req_deg'];
        $a = $row2x['name'];
        $n = $rows2['nop'];
        $m_age = $rows2['min'];
        $ma_age = $rows2['max'];
        $req = $rows2['requirements'];
    }	
    ?>
    
    <div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" >
        <div class="row">
            <div class="col-lg-12" align="center">
                <h3 style="color: green;">Posts</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="row"></div>
                <div id="ui">
                    <form class="form-group" action="" method="post">
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Name of post:</label>
                            </div>
                            <div class="col-lg-9" align="left">
                                <label><?php  echo $a ?> </label>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top:20px" >
                            <div class="col-lg-3" align="right">
                                <label>Required Degree</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <select class="form-control" name="req_deg" required>
                                <option <?php if($req_deg=='Primary'){ ?> selected <?php } ?> value="Primary">Primary</option>
                                <option <?php if($req_deg=='Middle'){ ?> selected <?php } ?>  value="Middle">Middle</option>

                                    <option <?php if($req_deg=='Matric'){ ?> selected <?php } ?> value="Matric">Matric</option>
                                    <option <?php if($req_deg=='Inter'){ ?> selected <?php } ?>  value="Inter">Inter</option>
                                    <option <?php if($req_deg=='Bachelors'){ ?> selected <?php } ?>  value="Bachelors">Bachelors</option>
                                    <option <?php if($req_deg=='Bachelors16'){ ?> selected <?php } ?>  value="Bachelors16">Bachelors16</option>
                                    <option <?php if($req_deg=='MS'){ ?> selected <?php } ?>  value="MS">MS</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row"  style="margin-top:20px" >
                            <div class="col-lg-3" align="right">
                                <label>NOP:</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <input type="text" name="nop" class="form-control" <?php if(isset($n)){ ?> value="<?php  echo $n ?>" <?php } ?> required/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Min Age:</label>
                            </div>
                            <div class="col-lg-9" align="left" > 
                                <input type="text" name="min_age" class="form-control" <?php if(isset($m_age)){ ?> value="<?php  echo $m_age ?>" <?php } ?> required/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Max Age:</label>
                            </div>
                            <div class="col-lg-9" align="left" > 
                                <input type="text" name="max_age" class="form-control" <?php if(isset($m_age)){ ?> value="<?php  echo $ma_age ?>" <?php } ?> required/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Requirements:</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <textarea class="ckeditor" name="requirements"><?php echo $req  ?></textarea>
                            </div>
                        </div>
                        
                        <br>
                        
                        <div class="row">
                            <div class="col-lg-12" align="center">
                                <?php if(isset($messg)){ echo $messg; } ?>
                                <input type="submit" name="Update" value="Update" class="btn btn-lg btn-block btn-primary">
                            </div>
                        </div>
                    </form>
                    <hr>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Update']))
    {
    

        $req_deg = $_POST['req_deg'];
        $cat_nop = $_POST['nop'];
        $cat_min = $_POST['min_age'];
        $cat_max = $_POST['max_age'];
        $cat_req = $_POST['requirements'];
        
    
        $query = "UPDATE `post_details` SET `req_deg`='$req_deg' ,`nop`='$cat_nop',`min`='$cat_min',`max`='$cat_max',`requirements`='$cat_req' WHERE `pid` = '$id'";
        $exe = mysqli_query($conn,$query);
        if(!$exe)
        {
            die(mysqli_error($conn));
        }
        else
        {
            echo "<script>window.location.href = 'category.php?update=success';</script>";
        }
    }
    ?>

    
    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>



</body>
</html>



<?php
}

else{
  header("Location: index.php");
}

?> 