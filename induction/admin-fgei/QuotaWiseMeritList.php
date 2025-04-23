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


<body>
<?php include('header.php');
      include('reportnav.php');
    ?>
<div  class="col-sm-9 col-sm- -3 col-lg-7 col-lg-offset-4 main" >
    <div class="row">
        <div class="col-lg-12" align="center">
            <h3 style="color: green;">Center Report</h3>
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
          
            $sqlroll = "SELECT per_info.contact_cnic, per_info.basic_domicile,per_info.contact_district, post_apply.relax_disable, post_apply.relax_disabled_nature,per_info.said, per_info.basic_full_name, per_info.basic_father_name, per_info.basic_dob, per_info.highest_qualification, province.name,
            details.d_centerid,details.d_rollno,
            qualification.primary_title,
            qualification.middle_title,
            qualification.matric_title,
            qualification.inter_title,
            qualification.bs_title,
            qualification.bs16_title,
            qualification.ms_title,
            post_apply.relax_schedule_caste,
            post_apply.relax_retired,
            post_apply.relax_widow,
            post_apply.gov
            FROM per_info 
            INNER JOIN post_apply ON post_apply.said=per_info.said 
            INNER JOIN details ON per_info.said=details.d_said
            INNER JOIN qualification ON per_info.said=qualification.said
            LEFT JOIN province ON per_info.basic_domicile = province.id
            WHERE details.d_postid='$cid' AND details.d_status='Approved'  AND details.d_centerid is  NOT NULL  ";
            $sqlexe = mysqli_query($conn, $sqlroll);


            // Assuming $cid contains multiple values like '22,23,24,51'
            // $cid_array = explode(',', $cid);
            // $conditions = '';
            // foreach ($cid_array as $value) {
            //     $conditions .= "post_apply.post_apply = '$value' OR ";
            // }
            // $conditions = rtrim($conditions, ' OR ');

            // $sqlroll = "SELECT per_info.contact_cnic, per_info.basic_domicile, per_info.said, per_info.basic_full_name, per_info.basic_father_name, per_info.basic_dob, per_info.highest_qualification, province.name
            //             FROM per_info 
            //             INNER JOIN post_apply ON post_apply.said = per_info.said 
            //             LEFT JOIN province ON per_info.basic_domicile = province.id
            //             WHERE $conditions";
            // $sqlexe = mysqli_query($conn, $sqlroll);


            $sqlrows = mysqli_num_rows($sqlexe);
            if ($sqlrows > 0) {
                $counter = 0;
        ?>
        
        
       
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Serial #</th>
                                <th>CNIC/Roll #</th>
                                <th>Name</th>
                                <th>Date of Birth</th>

                                <th>Domicile Province</th>
                                <th>Domicile District</th>
                                <th>Academic Qualification</th>
                                <th>Professional Qualification</th>
                                <th>Disability (If Any)</th>
                                <th>Age Relaxation (If any)</th>
                                <th>Test Centre</th>
                                <th>Written Test Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($sqldata = mysqli_fetch_array($sqlexe)) {
                                $counter++;

                                $province_id=$sqldata['contact_cnic'];


                                $sql_province= "SELECT name FROM province WHERE id='$province_id'";
                                $sql_p=mysqli_query($conn, $sql_province);
                                $sqlrows1 = mysqli_num_rows($sql_p);
                           ?>
                           
                           <?php
                                $highest_qualification = "";
                                if (!empty($sqldata['ms_title']) && $sqldata['ms_title'] !== NULL && $sqldata['ms_title'] !== " " && $sqldata['ms_title'] !== "NULL" ) {
                                    $highest_qualification = $sqldata['ms_title'];
                                } elseif (!empty($sqldata['bs16_title']) && $sqldata['bs16_title'] !== NULL  && $sqldata['bs16_title'] !== " " && $sqldata['bs16_title'] !== "NULL"  ) {
                                    $highest_qualification = $sqldata['bs16_title'];
                                } elseif (!empty($sqldata['bs_title']) && $sqldata['bs_title'] !== NULL  && $sqldata['bs_title'] !== " " && $sqldata['bs_title'] !== "NULL"  ) {
                                    $highest_qualification = $sqldata['bs_title'];
                                } elseif (!empty($sqldata['inter_title']) && $sqldata['inter_title'] !== NULL  && $sqldata['inter_title'] !== " " && $sqldata['inter_title'] !== "NULL"  ) {
                                    $highest_qualification = $sqldata['inter_title'];
                                } elseif (!empty($sqldata['matric_title']) && $sqldata['matric_title'] !== NULL  && $sqldata['matric_title'] !== " " && $sqldata['matric_title'] !== "NULL"  ) {
                                    $highest_qualification = $sqldata['matric_title'];
                                } elseif (!empty($sqldata['middle_title']) && $sqldata['middle_title'] !== NULL  && $sqldata['middle_title'] !== " " && $sqldata['middle_title'] !== "NULL"  ) {
                                    $highest_qualification = $sqldata['middle_title'];
                                } elseif (!empty($sqldata['primary_title']) && $sqldata['primary_title'] !== NULL  && $sqldata['primary_title'] !== " " && $sqldata['primary_title'] !== "NULL"  ) {
                                    $highest_qualification = $sqldata['primary_title'];
                                }
                                
                                
                                 $qualification = "SELECT qualification_category FROM qualification_category WHERE id = '$highest_qualification'";
                                    $qualification_query = mysqli_query($conn, $qualification);
                                    
                                    if ($qualification_query && mysqli_num_rows($qualification_query) > 0) {
                                        $qName = mysqli_fetch_assoc($qualification_query)['qualification_category'];
                                    } else {
                                        $qName = 'No Qualification Found';
                                    }
                                
                                $relaxation = "No";
                                if (
                                    $sqldata['relax_schedule_caste'] == 1 ||
                                    $sqldata['relax_retired'] == 1 ||
                                    $sqldata['relax_widow'] == 1 ||
                                    $sqldata['gov'] == 1
                                ) {
                                    $relaxation = "Yes";
                                }


                                ?>

                           
                           
                           



                                <tr>
                                    <td><?php echo $counter; ?></td>
                                    <td><?php echo $sqldata['contact_cnic'].'/ '.$sqldata['d_rollno']; ?></td>
                                    <td><?php echo $sqldata['basic_full_name']; ?> s/d/o <?php echo $sqldata['basic_father_name']; ?></td>
                                    <td><?php echo $sqldata['basic_dob']; ?></td>
                                    <td><?php echo $sqldata['name'];?></td>
                                    
                                    <td><?php echo $sqldata['contact_district'];?></td>
                                     <td><?php echo $qName; ?></td>
                                    <td><?php echo ' '; ?></td>
                                    <td><?php if($sqldata['relax_disable']=='1')
                                     {echo 'Yes ('.$sqldata['relax_disabled_nature'].')';} 
                                     else {echo 'No';} ?></td>
                                     
                                    
                                    <?php
                                    
                                    $centerId = $sqldata['d_centerid'];
                                    $centerQuery = "SELECT center FROM centes WHERE id = $centerId ";
                                    $centerResult = mysqli_query($conn, $centerQuery);
                                    $centerName = mysqli_fetch_assoc($centerResult)['center'];


?>
                                     <td><?php echo $relaxation; ?></td>
                                     <td><?php echo $centerName; ?></td>
                                    
                                 
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