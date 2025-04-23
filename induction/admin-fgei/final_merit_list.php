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
?>


<!DOCTYPE html>
<html>
    <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin - Reports</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/font-awesome.min.css" rel="stylesheet">
  <link href="css/datepicker3.css" rel="stylesheet">
  <link href="css/styles.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>
</head>
<style>
    .table-responsive {
        overflow-x: auto;
    }

    .table td,
    .table th {
        white-space: nowrap;
    }
</style>


<body>
<?php include('header.php');
      include('reportnav.php');
    ?>
    
    
    
    

<div  class="col-sm-9 col-sm- -3 col-lg-7 col-lg-offset-4 main" >
    <div class="row">
        <div class="col-lg-12" align="center">
            <h3 style="color: green;">Final Merit List</h3>
        </div>
    </div>
        <div class="row">
        <div class="col-lg-12" align="center">
            <form method ="GET" >
                <div class="row">
                    <div class="col-lg-3" align="right">
                        <label>Center:</label>
                    </div>
                    <div class="col-lg-6" align="left" > 
                        <select class="form-control" name="post2" required>
							
							
								<option value="" selected>Select Post</option>
							 
							<?php

             				$newquery = "SELECT * FROM `posts`";
							$newdatas = mysqli_query($conn,$newquery);				
							$newrowct = mysqli_num_rows($newdatas);


							if($newrowct>0){

							while ($newrowss = mysqli_fetch_array($newdatas)){
							?>

							        <option <?php if ($_SERVER['REQUEST_METHOD'] == 'GET'  && isset($_GET['submit1']) ){
                                    if($_GET['post2']== $newrowss['pid']){
                                            ?>
                                            selected
                                            <?php
                                    }}?> value="<?php echo $newrowss['pid']; ?>"><?php echo $newrowss['pid'].') '.$newrowss['name'];?></option> 
							        <?php
							}
							}
							?>
							</select>		
                    </div>
                    <div class="col-lg-3" align="right" style=" border:px solid black ">
                    <input type="submit" name="submit1" value="Show Records" class="btn btn-block btn-primary">
                   </div>
				</div>
            </form>
         </div>
    </div>



    <div class="row">
    <div class="col-lg-12 mt-4">
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit1'])) {
            $cid = $_GET['post2'];

            $newquery = "SELECT * FROM post_apply WHERE post_apply='$cid'";
            $newdatas = mysqli_query($conn, $newquery);
            $newrowct = mysqli_num_rows($newdatas);
            $center = mysqli_fetch_array($newdatas);
            $sqlroll = "SELECT per_info.contact_cnic, per_info.basic_domicile,per_info.contact_postal_address, post_apply.relax_disable, post_apply.relax_disabled_nature,per_info.said, per_info.basic_full_name, per_info.basic_father_name, per_info.basic_dob, per_info.highest_qualification, province.name
            FROM per_info 
            INNER JOIN post_apply ON post_apply.said=per_info.said 
            LEFT JOIN province ON per_info.basic_domicile = province.id
            WHERE post_apply.post_apply = '$cid'";
            $sqlexe = mysqli_query($conn, $sqlroll);

            $sqlrows = mysqli_num_rows($sqlexe);
            if ($sqlrows > 0) {
                $counter = 0;
        ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th rowspan="2" class="align-middle">Serial #</th>
                                <th rowspan="2" class="align-middle">CNIC / Roll #</th>
                                <th rowspan="2" class="align-middle">Name S/O or D/O</th>
                                <th rowspan="2" class="align-middle">Postal Address</th>
                                <th rowspan="2" class="align-middle">Contact Number</th>
                                <th rowspan="2" class="align-middle">Date of Birth</th>
                                <th rowspan="2" class="align-middle">Domicile Province</th>
                                <th rowspan="2" class="align-middle">Domicile District</th>
                                <th rowspan="2" class="align-middle">Academic Qualification</th>
                                <th rowspan="2" class="align-middle">Professional Qualification</th>
                                <th colspan="5" class="text-center">Test Marks</th>
                                <th rowspan="2" class="align-middle">Total Marks Obtained</th>
                                <th rowspan="2" class="align-middle">Remarks</th>
                            
                            		<th rowspan="2" class="align-middle" >Disability If any</th>	
                                    <th rowspan="2" class="align-middle">Age Relaxation (If any)	</th>
                                    <th rowspan="2" class="align-middle">Test Centre	</th>
                                    <th rowspan="2" class="align-middle">written Test Marks</th>
                                    	<th rowspan="2" class="align-middle">Weight (70%)	</th>
                                        <th rowspan="2" class="align-middle">Interview Marks (50)	</th>
                                        <th rowspan="2" class="align-middle">Weight (30%)</th>	
                                       <th rowspan="2" class="align-middle"> Total Marks</th>
                                        
                                       </tr>      

                        </thead>
                        <tbody>
                            <?php
                            while ($sqldata = mysqli_fetch_array($sqlexe)) {
                                $counter++;
                            ?>
                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $sqldata['contact_cnic']; ?></td>
                                    <td><?php echo $sqldata['basic_full_name']; ?> s/d/o <?php echo $sqldata['basic_father_name']; ?></td>
                                    <td><?php echo $sqldata['contact_postal_address'];?></td>
                                    <td><?php echo $sqldata['contact_postal_address'];?></td>


                                    <td><?php echo $sqldata['name'];?></td>
                                    <td><?php echo $sqldata['basic_dob']; ?></td>
                                    <td><?php echo $sqldata['highest_qualification']; ?></td>
                                    <td><?php echo ' '; ?></td>
                                    <td><?php if($sqldata['relax_disable']=='1')
                                     {echo 'Yes'.$sqldata['relax_disabled_nature'];} 
                                     else {echo 'No';} ?></td>
                                    <td><?php echo ' '; ?></td>
                                    <td><?php echo ' '; ?></td>
                                    <td><?php echo ' '; ?></td>
                                    <td><?php echo 'Rawalpindi'; ?></td>
                                    <td><?php echo '44'; ?></td>
                                    <td><?php echo ' '; ?></td>
                                    <td><?php echo ' '; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <form class="mt-4" method="post" action="exportroll.php">
                    <input type="hidden" name="pid" value="<?php echo $cid; ?>">
                    <input type="hidden" name="center">
                    <button type="submit" class="btn btn-success"><i class="fas fa-file-excel"></i> Export To Excel</button>
                </form>
            <?php

            } else {
                echo "<p class='text-danger'>No Record found.</p>";
            }
        }
        ?>
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
</body>
</html>

<?php
      
}

else{
  header("Location: index.php");
}
ob_flush();
?>