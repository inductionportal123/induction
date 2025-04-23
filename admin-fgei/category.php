<?php
ob_start();
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
	
	
	if ($user=='super-admin' || $user=='aoi-3')
   		{
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
    if (@$_GET['insert'] == 'success')
    {
        $messg = "Record Enter Successfully";
    }
    if (@$_GET['update'] == 'suc')
    {
        $messg = "Record Update Successfully";
    }
    ?>
    
    <div  class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div id="ui">
                    <div class="row">
                        <div class="col-lg-12" align="center">
                            <h3 style="color: green;">Post Details</h3>
                        </div>
                    </div>
                    
                    <form class="form-group" action="categoryprocess.php" method="post" style="padding-right: 70px; padding-left: 30px; padding-top: 10px">
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Name of Post:</label>
                            </div>
                            <div class="col-lg-9" align="left">
                                <select class="form-control" name="post" required>
                                    <option value="" selected>Select Post</option>
                                    <?php
                                        $newquery = "SELECT * FROM `posts` ORDER BY gender DESC;";
                                        $newdatas = mysqli_query($conn,$newquery);				
                                        $newrowct = mysqli_num_rows($newdatas);
                                        if($newrowct>0)
                                        {
                                            while ($newrowss = mysqli_fetch_array($newdatas))
                                            {
                                    ?>
                                    <option value="<?php echo $newrowss['pid']; ?>"><?php echo $newrowss['name']; echo ' (BPS-'. $newrowss['bps']; echo ') - '.ucfirst($newrowss['gender']);   ?></option>
                                    <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top:20px" >
                            <div class="col-lg-3" align="right">
                                <label>Required Degree</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <select class="form-control" name="req_deg" required>
                                    <option value="" selected>Select Post</option>
                                    <option value="Primary">Primary</option>
                                    <option value="Middle">Middle</option>
                                    <option value="Matric">Matric</option>
                                    <option value="Inter">Inter</option>
                                    <option value="Bachelors">Bachelors</option>
                                    <option value="Bachelors16">Bachelors16</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row" style="margin-top:20px" >
                            <div class="col-lg-3" align="right">
                                <label>NOP:</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <input type="text" name="nop" class="form-control" placeholder="Enter NOP:" required/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Min Age:</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <input type="text" name="min_age" class="form-control" placeholder="Enter Min Age:" required/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Max Age:</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <input type="text" name="max_age" class="form-control" placeholder="Enter Max Age:" required/>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-3" align="right">
                                <label>Requirements:</label>
                            </div>
                            <div class="col-lg-9" align="left" >
                                <textarea class="ckeditor" name="requirements"></textarea>
                            </div>
                        </div>
                        
                        <br>
                        
                        <div class="row">
                            <div class="col-lg-12" align="center">
                                <?php if(isset($messg)){ echo $messg; } ?>
                                <input type="submit" name="submit" value="Save" class="btn btn-lg btn-block btn-primary">
                            </div>
                        </div>
                    
                    </form>
                    
                    <hr>
                    
                    <?php
                        $query2 = "SELECT * FROM `post_details` ORDER BY pid DESC ";
                        $exe2 = mysqli_query($conn,$query2);
                        $rowcount2 = mysqli_num_rows($exe2);
                        if ($rowcount2 > 0)
                        {
                    ?>
                    <table class="table table-bordered" width="100%">
                        <tr>
                            <th style="text-align: center;">Post</th>
                            <th style="text-align: center;">Required Degree</th>
                            <th style="text-align: center;">NOP</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                        
                        <?php
                            while ($rows = mysqli_fetch_array($exe2))
                            {
                        ?>
                        
                        <tr>
                            <td style="text-align: center;">
                                <?php 
                                $idd = $rows['pid'];
                                $arrg = " SELECT * FROM `posts` where pid = $idd ";
                                $result = mysqli_query($conn,$arrg);
                                $row45 = mysqli_fetch_array($result);
                                echo $row45['name']; echo ' (BPS-'. $row45['bps']; echo ') - '.ucfirst($row45['gender']); ?>
                            </td>
                            <td style="text-align: center;"><?= $rows['req_deg'] ?></td>
                            <td style="text-align: center;"><?= $rows['nop'] ?></td>
                            <td style="text-align: center;"><a href="editcategory.php?id=<?=$rows['pid']?>">Edit</a> &iota; <a href="deletecat.php?id=<?=$rows['pid']?>" onclick="return confirm('Are you sure to delete?')">Delete</td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </div>
    
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
   echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access of this page</div>';

}
}
else
{
  header("Location: index.php");
}
?> 