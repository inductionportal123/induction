<?php
error_reporting(0);
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"><link href="css/bootstrap.min.css" rel="stylesheet">
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
    @media print {
  * {
    display: none;
  }
  #printableTable {
    display: block;
  }
}
    </style>
    <script>
          function printDiv() {
  window.frames[
    "print_frame"
  ].document.body.innerHTML = document.getElementById(
    "printableTable"
  ).innerHTML;
  window.frames["print_frame"].window.focus();
  window.frames["print_frame"].window.print();
}
    </script>
<body>
<?php
    include('header.php');
    include('reportnav.php');
?>
<div  class="col-sm-9 col-sm- -3 col-lg-7 col-lg-offset-4 main" >
    <div class="row">
        <div class="col-lg-12" align="center">
            <h3 style="color: green;">Summary Report</h3>
        </div>
    </div>
    
                            <!--                      FILTER BUTTONS                   -->
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
                    <div class="col-lg-3"  align="center" >
                        <input type="submit" name="submitprovince" value="Filter by Province" class="btn btn-sm btn-block btn-primary">
                    </div>
                    <div class="col-lg-3" align="right" >
                        <input type="submit" name="submitdistrict" value="Filter by District" class="btn btn-sm btn-block btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>

                            <!--                     REGION                   -->
    
    <?php
    if (isset($_GET['submitregion']))
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
                                if($regionr>0)
                                {
                                    while ($region = mysqli_fetch_array($regiond))
                                    {
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
    
//                          <!--                     PROVINCE                   -->   
    
    if(isset($_GET['submitprovince']))
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
                            <option value="" selected>Select Province</option>
                            <option value="1">Punjab</option>
                            <option value="4">Sindh (Urban)</option>
                            <option value="5-rural">Sindh (Rural)</option>
                            <option value="3">Balochistan</option>
                            <option value="2">Khyber Pakhtunkhwa</option>
                            <option value="7">FATA</option>
                            <option value="6">AJK</option>
                            <option value="g">Gilgit Baltistan</option>
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
    $totalapplied = 0;
    $totalapproved = 0;
    $totalrejected = 0;
//                            <!--                     DISTRICT                   -->     
    
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
                                if($districtr>0)
                                {
                                    while ($district = mysqli_fetch_array($districtd))
                                    {
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
    <?php
    }
    ?>
    
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectregion']))
    {
        $cityarray= '';
        $regionnew = strtolower($_POST['region']);
        $regioncity = "SELECT id FROM `district` WHERE `region` = '$regionnew'";
        $exeregcity = mysqli_query($conn, $regioncity);
        $regcityrows = mysqli_num_rows($exeregcity);
        if($regcityrows > 0)
        {
            while($regcitydata = mysqli_fetch_array($exeregcity))
            {
                $cityarray .= $regcitydata['id'] . ",";
            }
        }
        $cityarray = substr($cityarray,0,-1);
    }
    ?>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectprovince']))
    {
        $procityarray= '';
        $pronew = strtolower($_POST['province']);
        $procity = "SELECT id FROM `district` WHERE `province` = '$pronew'";
        $exeprocity = mysqli_query($conn, $procity);
        $procityrows = mysqli_num_rows($exeprocity);
        if($procityrows > 0)
        {
            while($procitydata = mysqli_fetch_array($exeprocity))
            {
                $procityarray .= $procitydata['id'] . ",";
            }
        }
        $procityarray = substr($procityarray,0,-1);
    }
    ?>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectdistrict']))
    {
        $district1 =$_POST['district'];
        echo $district1;
        $dist = "SELECT * FROM `district` WHERE `name` = '$district1'";
        $distexe = mysqli_query($conn,$dist);
        $distdata = mysqli_fetch_array($distexe);
        $distcity = $distdata['id'];
    }
    ?>
    
    <div class="row" style="margin-top:10px" id="printableTable">
        <table class="table table-striped table-bordered print">
            <thead style="background-color: #4caf5047;">
                <tr>
                  <th>#</th>
                  <th>Posts</th>
                  <th>Total Applications</th>
                  <th>Approved Applications</th>
                  <th>Rejected Applications</th>
                  
                   <th>Reverted Applications</th>
                   <th>Pending Applications</th>
                </tr>
            </thead>
            <?php
    $postsquery = "SELECT * FROM `posts`";
    $postsresult = mysqli_query($conn,$postsquery);
            ?>
            <?php
    $counter=0;
    while( $postsmain = mysqli_fetch_assoc($postsresult))
    {
        $counter=$counter+1;
        if($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectregion']))
        {
                    $regionnew = strtolower($_POST['region']);
                    $regioncity = "SELECT id FROM `district` WHERE `region` = '$regionnew'";
                    $exeregcity = mysqli_query($conn, $regioncity);
                    $regcityrows = mysqli_num_rows($exeregcity);
                    if($regcityrows > 0)
                    {
                   
            ?>
            <tbody>
                <td><?php echo $counter?></td>
                <td><?php echo $postsmain['name']."-(".$postsmain['gender'].")-(BPS-".$postsmain['bps'].")"; ?></td>
                <?php
                $pid = $postsmain['pid'];
                
            
                //totalcount
                $tcq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer IN ($cityarray) AND details.d_postid='$pid' AND per_info.undertaking = 1";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_num_rows($tcq2);
                $totalapplied = $totalapplied + $tcresult;
            
                //approvedcount
                $acq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer IN ($cityarray)  AND details.d_postid='$pid' AND details.d_status = 'Approved' AND per_info.undertaking = 1";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_num_rows($acq2);
                $totalapproved =$totalapproved +  $acresult;
                
                //rejectedcount
                $rcq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said INNER JOIN qualification on qualification.said = post_apply.said INNER JOIN emp_document on post_apply.said = emp_document.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer IN ($cityarray)  AND details.d_postid='$pid' AND details.d_status = 'Rejected' AND per_info.undertaking = 1";
                $rcq2 = mysqli_query($conn, $rcq);
                $rcresult = mysqli_num_rows($rcq2);
                $totalrejected =$totalrejected +  $rcresult;
                ?>

                <td><?php echo $tcresult; ?></td>
                <td><?php echo $acresult?></td>
                <td><?php echo $rcresult; ?></td>
                <?php
                    $acseries = $postsmain['series'];
                    $pcq = $acresult + $rcresult;
                    $pcq2 = $tcresult;
                    $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              </tbody>
              <?php
  
                    }
            else{
                ?>
            <h4>No cities in this region</h4>
            <?php
                break;
            }


      }
      elseif($_SERVER['REQUEST_METHOD'] == 'POST'  && isset($_POST['selectprovince']) )
      {
        $pronew = strtolower($_POST['province']);
        $procity = "SELECT id FROM `district` WHERE `province` = '$pronew'";
        $exeprocity = mysqli_query($conn, $procity);
        $procityrows = mysqli_num_rows($exeprocity);
        echo $procityrows;
        if($procityrows > 0)
        {
            ?>
      <tbody>
                <td><?php echo $counter?></td>
                <td><?php echo $postsmain['name']."-(".$postsmain['gender'].")-(BPS-".$postsmain['bps'].")"; ?></td>
                <?php
                $pid = $postsmain['pid'];
                //totalcount
                $tcq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer IN ($procityarray) AND details.d_postid='$pid' AND per_info.undertaking = 1";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_num_rows($tcq2);
                $totalapplied = $totalapplied + $tcresult;
                
                //approvedcount
                $acq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer IN ($procityarray) AND details.d_postid='$pid' AND details.d_status = 'Approved' AND per_info.undertaking = 1";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_num_rows($acq2);
                $totalapproved =$totalapproved +  $acresult;
                
                //rejectedcount
                $rcq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said INNER JOIN qualification on qualification.said = post_apply.said INNER JOIN emp_document on post_apply.said = emp_document.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer IN ($procityarray)  AND details.d_postid='$pid' AND details.d_status = 'Rejected' AND per_info.undertaking = 1";
                $rcq2 = mysqli_query($conn, $rcq);
                $rcresult = mysqli_num_rows($rcq2);
                $totalrejected =$totalrejected +  $rcresult;
                
                //pendingcount
 
                ?>

                <td><?php echo $tcresult; ?></td>
                <td><?php echo $acresult; ?></td>
                <td><?php echo $rcresult; ?></td>
                <?php

                  $acseries = $postsmain['series'];
                   $pcq = $acresult + $rcresult;
                $pcq2 = $tcresult;
                $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              </tbody>
              <?php
  

        }else{
            ?>
            <h4>No cities in this province</h4>
            <?php
            break;
        }

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
                $tcq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer = $distcity AND details.d_postid='$pid' AND per_info.undertaking = 1";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_num_rows($tcq2);
                $totalapplied = $totalapplied + $tcresult;
                
                //approvedcount
                $acq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer = $distcity  AND details.d_postid='$pid' AND details.d_status = 'Approved' AND per_info.undertaking = 1";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_num_rows($acq2);
                $totalapproved =$totalapproved +  $acresult;
                //rejectedcount
                $rcq = "SELECT post_apply.said FROM `post_apply` INNER JOIN details on post_apply.said = details.d_said INNER JOIN per_info on post_apply.said = per_info.said WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND post_apply.city_prefer = $distcity  AND details.d_postid='$pid' AND details.d_status = 'Rejected' AND per_info.undertaking = 1";
                $rcq2 = mysqli_query($conn, $rcq);
                $rcresult = mysqli_num_rows($rcq2);
                $totalrejected =$totalrejected +  $rcresult;
                //pendingcount
 
                ?>

                <td><?php echo $tcresult; ?></td>
                <td><?php echo $acresult; ?></td>
                <td><?php echo $rcresult; ?></td>
                <?php

                  $acseries = $postsmain['series'];
                   $pcq = $acresult + $rcresult;
                $pcq2 = $tcresult;
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
                $tcq = "SELECT post_apply.said FROM `post_apply`
                INNER JOIN details on post_apply.said = details.d_said 
                INNER JOIN per_info on post_apply.said = per_info.said
                WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_num_rows($tcq2);
                $totalapplied = $totalapplied + $tcresult;
                
        
                //approvedcount
                $acq = "SELECT post_apply.said FROM `post_apply`
                INNER JOIN details on post_apply.said = details.d_said 
                INNER JOIN per_info on post_apply.said = per_info.said
                WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1 AND details.d_status='Approved'";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_num_rows($acq2);
                $totalapproved =$totalapproved +  $acresult;
                
    
                //rejectedcount
                $rcq = "SELECT post_apply.said FROM `post_apply`
                INNER JOIN details on post_apply.said = details.d_said 
                INNER JOIN per_info on post_apply.said = per_info.said
                WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1 AND details.d_status='Rejected'" ;
                $rcq2 = mysqli_query($conn, $rcq);
                $rcresult = mysqli_num_rows($rcq2);
                
                $totalrejected =$totalrejected +  $rcresult;
                
                
                //Reverted Applications
                $rcqr = "SELECT post_apply.said FROM `post_apply`
                INNER JOIN details on post_apply.said = details.d_said 
                INNER JOIN per_info on post_apply.said = per_info.said
                WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1 AND details.d_status='Rejected' AND details.revert=1 " ;
                $rcqr2 = mysqli_query($conn, $rcqr);
                $rcresultr = mysqli_num_rows($rcqr2);
                
                $totalrejectedr =$totalrejectedr +  $rcresultr;
                

                ?>

                <td><?php echo $tcresult; ?></td>
                <td><?php echo $acresult; ?></td>
                <td><?php echo $rcresult-$rcresultr; ?></td>
                <td><?php echo $rcresultr; ?></td>
                
                <?php
                    $acseries = $postsmain['series'];
                    $pcq = $acresult + $rcresult;
                    $pcq2 = $tcresult;
                    $pcq3 = $pcq2 - $pcq;
                 ?>
                <td><?php echo $pcq3; ?></td>
              <?php
} }
    ?>
                <tr>
                    <td></td>
                <td>Total</td>
                <td><?php echo $totalapplied;?></td>
                <td><?php echo $totalapproved;?></td>
                <td><?php echo $totalrejected-$totalrejectedr;?></td>
                    <?php $totalpending = $totalapplied - ($totalapproved + $totalrejected); ?>
                    <td><?php echo $totalrejectedr?></td>
                    <td><?php echo $totalpending?></td>
                    
                </tr>
            </tbody>
 
</table>
        <button class="btn btn-primary btn-md" onclick="printDiv()">Print</button>
</div>
    <iframe name="print_frame" width="0" height="0" frameborder="0" src="about:blank"></iframe>
</div>


  <div style="text-align: center; margin-top: 20px;">
        <!-- Hidden iframe for downloading Excel file -->
       
        <iframe name="print_frame" style="width: 0; height: 0; border: none;"></iframe>
        
        <!-- Download button -->
        <a href="export_to_excel.php?action=export" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px; transition: background-color 0.3s ease;">Download Excel</a>
    </div>

</div>

<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
<!-- 	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script> -->
</body>
</html>

<?php
mysqli_close($conn);
      
}

else{
  header("Location: index.php");
}
ob_flush();
?>