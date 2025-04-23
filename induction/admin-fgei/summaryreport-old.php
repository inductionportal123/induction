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
            <h3 style="color: green;">Summary Report</h3>
        </div>
    </div>

<!-- Region START -->

<div class="row">
        <div class="col-lg-12" align="center">
            <form method ="GET" >
                <div class="row">
                    
                    <div class="col-lg-3" align="left" > 
                        <input href="summaryreport.php" type="submit" name="all" value="All" class="btn btn-sm btn-block btn-primary">
                        
                    </div>

                    <div class="col-lg-3" align="left" > 
                        <input type="submit" name="submitregion" value="Filter by Region" class="btn btn-sm btn-block btn-primary">
                        
                    </div>
                    <div   class="col-lg-3"  align="center" >
                    <input type="submit" name="submitprovince" value="Filter by Province" class="btn btn-sm btn-block btn-primary">
                </div>

                 <div class="col-lg-3" align="right" >
                    <input type="submit" name="submitdistrict" value="Filter by District" class="btn btn-sm btn-block btn-primary">
                </div>
                   
                </div>
        </div>
            </form>
         </div>
   <!-- $region1=$_GET['region']; -->
           <?php

  if (isset($_GET['submitregion']) )
       {
        ?>
        <br>
        <div class="row">
        <div class="col-lg-12" align="center">
            <form method ="POST" >
                <div class="row">
                    <div class="col-lg-3" align="right">
                        <label>Region:</label>
                    </div>
                    <div class="col-lg-5" align="left" > 
                        <select class="form-control" name="region" required>
              
                <option value="10" selected>Select Region</option>
               
              <?php

                    $regionq = "SELECT * FROM `region` ORDER BY name DESC";
                
              $regiond = mysqli_query($conn,$regionq);        
              $regionr = mysqli_num_rows($regiond);


              if($regionr>0){

              while ($region = mysqli_fetch_array($regiond)){
              ?>

                      <option value="<?php echo $region['name']; ?>"><?php echo $region['name']; ?></option> 
              <?php
              
              }
            }
              ?>
              </select>   
                    </div>
                    <div class="col-lg-3" align="right" style=" border:px solid black ">
                    <input type="submit" name="selectregion" value="Select Region" class="btn btn-sm btn-block btn-primary">
                </div>
        </div>
            </form>
         </div>
    </div>
           
           <?php
            }
  if (isset($_GET['submitprovince']) )
       {
           ?>
           <br>
           <div class="row">
        <div class="col-lg-12" align="center">
            <form method ="POST" >
                <div class="row">
                    <div class="col-lg-3" align="right">
                        <label>Province:</label>
                    </div>
                    <div class="col-lg-5" align="left" > 
              
              
                <select class="form-control" name="province" required>

                                <option value="20" selected>Select Province</option>
                                <option value="punjab">Punjab</option>
                                <option value="sindh-urb">Sindh (Urban)</option>
                                <option value="sindh-rural">Sindh (Rural)</option>
                                <option value="balochistan">Balochistan</option>
                                <option value="kpk">Khyber Pakhtunkhwa</option>
                                <option value="gilgit/fata">Gilgit Baltistan / FATA</option>
                                <option value="ajk">AJK</option>
              </select>
              
                    </div>
                    <div class="col-lg-3" align="right" style=" border:px solid black ">
                    <input type="submit" name="selectprovince" value="Submit Province" class="btn btn-sm btn-block btn-primary">
                </div>
        </div>
            </form>
         </div>
    </div>
<?php
            }
            
  if (isset($_GET['submitdistrict']) )
       {
        ?>
        <br>
           <div class="row">
        <div class="col-lg-12" align="center">
            <form method ="POST" >
                <div class="row">
                    <div class="col-lg-3" align="right">
                        <label>District:</label>
                    </div>
                    <div class="col-lg-5" align="left" > 
                        <select class="form-control" name="district" required>
              
              
                <option value="30" selected>Select District</option>
               
              <?php

                    $districtq = "SELECT * FROM `district` ORDER BY name DESC;";
                
              $districtd = mysqli_query($conn,$districtq);        
              $districtr = mysqli_num_rows($districtd);


              if($districtr>0){

              while ($district = mysqli_fetch_array($districtd)){
              ?>

                      <option value="<?php echo $district['name']; ?>"><?php echo $district['name']; ?></option> 
              <?php
              }
              }
            
              ?>
              </select>   
                    </div>
                    <div class="col-lg-3" align="right" style=" border:px solid black ">
                    <input type="submit" name="selectdistrict" value="Submit District" class="btn btn-sm btn-block btn-primary">
                </div>
                </div>
        
            </form>
         </div>
    </div>
           <?php }?>
<!--  Region END -->

<!-- Province   START -->
<!-- 


           <?php

  if ($_SERVER['REQUEST_METHOD'] == 'GET'  && isset($_GET['submitprovince']) )
      {
     
          $province1=$_GET['province'];





      }
            
?>



           <?php

 if ($_SERVER['REQUEST_METHOD'] == 'GET'  && isset($_GET['submitdistrict']) )
      {
     
         $district1 =$_GET['district'];
            
            }
?> -->
<!--  District END -->

  <div class="row" style="margin-top:10px">
        <table class="table table-striped table-bordered">
            <thead style="background-color: #4caf5047;">
                <tr>
                  <th>#</th>
                  <th>Posts</th>
                  <th>Total Applications</th>
                  <th>Approved Applications</th>
                  <th>Rejected Applications</th>
                  <th>Pending Applications</th>
                </tr>
              </thead> 
            
             <!-- Pagination Start   -->
    <?php


        
        $postsquery = "SELECT * FROM `posts`";
      $postsresult = mysqli_query($conn,$postsquery) ;
    ?>
    
            

<?php
      $counter=0;
  // output data of each row
  while( $postsmain = mysqli_fetch_assoc($postsresult)) {

      $counter=$counter+1;
      if($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectregion']) )
      {

      
      $regionnew = strtolower($_POST['region']);
            echo $regionnew;
            ?>
            
      <tbody>
                <td><?php echo $counter?></td>
                <td><?php echo $postsmain['name']."-(".$postsmain['gender'].")-(BPS-".$postsmain['bps'].")"; ?></td>
                <?php
                $pid = $postsmain['pid'];
                //totalcount
                
          
                $tcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id) AND district.region = '$regionnew' WHERE  FIND_IN_SET('$pid',post_apply)";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.region = '$regionnew' WHERE details.d_said=post_apply.said AND d_postid='$pid' AND details.d_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.region = '$regionnew' WHERE details.d_said=post_apply.said AND d_postid='$pid' AND details.d_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount
 
                ?>

                <td><?php echo $tcresult[0]; ?></td>
                <td><?php echo $acresult[0]?></td>
                <td><?php echo $rcresult[0]; ?></td>
                <?php

                  $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              </tbody>
              <?php
  



      }
      elseif($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectprovince']) )
      {

      
      $provincenew = $_POST['province'];?>
      <tbody>
                <td><?php echo $counter?></td>
                <td><?php echo $postsmain['name']."-(".$postsmain['gender'].")-(BPS-".$postsmain['bps'].")"; ?></td>
                <?php
                $pid = $postsmain['pid'];
                //totalcount
                $tcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id) AND district.province = '$provincenew' WHERE  FIND_IN_SET('$pid',post_apply)";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.province = '$provincenew' WHERE details.d_said=post_apply.said AND details.d_postid='$pid' AND details.d_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.province = '$provincenew' WHERE details.d_said=post_apply.said AND details.d_postid='$pid' AND details.d_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount
 
                ?>

                <td><?php echo $tcresult[0]; ?></td>
                <td><?php echo $acresult[0]?></td>
                <td><?php echo $rcresult[0]; ?></td>
                <?php

                  $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              </tbody>
              <?php
  



      }
      elseif($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectdistrict']) )
      {

      
      $districtnew = $_POST['district'];?>
      <tbody>
                <td><?php echo $counter?></td>
                <td><?php echo $postsmain['name']."-(".$postsmain['gender'].")-(BPS-".$postsmain['bps'].")"; ?></td>
                <?php
                $pid = $postsmain['pid'];
                //totalcount
                $tcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id) AND district.name = '$districtnew' WHERE  FIND_IN_SET('$pid',post_apply)";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.name = '$districtnew' WHERE details.d_said=post_apply.said AND details.d_postid='$pid' AND details.d_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.name = '$districtnew' WHERE details.d_said=post_apply.said AND details.d_postid='$pid' AND details.d_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount
 
                ?>

                <td><?php echo $tcresult[0]; ?></td>
                <td><?php echo $acresult[0]?></td>
                <td><?php echo $rcresult[0]; ?></td>
                <?php

                  $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              </tbody>
              <?php
  



      }

      elseif($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectprovince']) )
      {

      
      $provincenew = $_POST['province'];?>
      <tbody>
                <td><?php echo $counter?></td>
                <td><?php echo $postsmain['name']."-(".$postsmain['gender'].")-(BPS-".$postsmain['bps'].")"; ?></td>
                <?php
                $pid = $postsmain['pid'];
                //totalcount
                $tcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id) AND district.province = '$provincenew' WHERE  FIND_IN_SET('$pid',post_apply)";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.province = '$provincenew' WHERE details.d_said=post_apply.said AND details.d_postid='$pid' AND details.d_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `details`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.province = '$provincenew' WHERE details.d_said=post_apply.said AND details.d_postid='$pid' AND details.d_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount
 
                ?>

                <td><?php echo $tcresult[0]; ?></td>
                <td><?php echo $acresult[0]?></td>
                <td><?php echo $rcresult[0]; ?></td>
                <?php

                  $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              </tbody>
              <?php
  



      }

      else
      {

              ?>

            <tbody>
                <td><?php echo $counter?></td>
                <td><?php echo $postsmain['name']."-(".$postsmain['gender'].")-(BPS-".$postsmain['bps'].")"; ?></td>
                <?php
                $pid = $postsmain['pid'];
                //totalcount
                $tcq = "SELECT count(*) FROM per_info 
JOIN emp_document ON per_info.said = emp_document.said
JOIN post_apply ON per_info.said = post_apply.said
JOIN qualification ON per_info.said = qualification.said
JOIN details ON per_info.said = details.d_said
WHERE per_info.undertaking = 1 AND details.d_postid = '$pid'";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT count(*) FROM per_info 
JOIN emp_document ON per_info.said = emp_document.said
JOIN post_apply ON per_info.said = post_apply.said
JOIN qualification ON per_info.said = qualification.said
JOIN details ON per_info.said = details.d_said
WHERE per_info.undertaking = 1 AND details.d_postid = '$pid'
AND details.d_status = 'Approved'";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT count(*) FROM per_info 
JOIN emp_document ON per_info.said = emp_document.said
JOIN post_apply ON per_info.said = post_apply.said
JOIN qualification ON per_info.said = qualification.said
JOIN details ON per_info.said = details.d_said
WHERE per_info.undertaking = 1 AND details.d_postid = '$pid'
AND details.d_status = 'Rejected'";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount

                ?>

                <td><?php echo $tcresult[0]; ?></td>
                <td><?php echo $acresult[0]; ?></td>
                <td><?php echo $rcresult[0]; ?></td>
                <?php

                  $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              </tbody>
  
     

              <?php
} }
?>
 
</table>
</div>
<div class="row" >
        <div class="col-lg-2" style="float:right; ">
            <form action="exportsummary.php" method="post">
             <input style="align:right; " type="hidden" name="summarypid" value="<?php echo $pid; ?> ">
              <?php
              if($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectregion']) )
              {
              ?>
              <input style="align:right; " type="hidden" name="summaryregion" value="<?php echo $regionnew; ?> ">
              <input style="align:right; " type="hidden" name="placeregion" value="Region">
              <?php
              }
              elseif($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectprovince']) )
              {
              ?>
              <input style="align:right; " type="hidden" name="summaryprovince" value="<?php echo $provincenew; ?> ">
              <input style="align:right; " type="hidden" name="placeprovince" value="Province">
              <?php
              }
              elseif($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectdistrict']) )
              {
              ?>
              <input style="align:right; " type="hidden" name="summarydistrict" value="<?php echo $districtnew; ?> ">
              <input style="align:right; " type="hidden" name="placedistrict" value="District">
              <?php
              }
              ?>
                <button  style="align:right; " onclick ="return confirm('Are you sure you want to export data')" type="submit" id="btnExport" name='exceldata'
                    value="Export to Excel" class="btn btn-info">Export
                    to Excel</button>
            </form>
        </div>
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