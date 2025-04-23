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
	<title>Admin - Applications</title>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

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
    include('appnav.php'); 
    ?>
    
  
    
    
<div  class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-4 main" >
    <div class="row">
        <div class="col-lg-12" align="center">
            <h3 style="color: green;">All Applications</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12" align="center">
            <form method ="GET" >
                <div class="row">
                    <div class="col-lg-3" align="right">
                        <label>Post:</label>
                    </div>
                    <div class="col-lg-5" align="left" > 
                        <select class="form-control" name="post2" required>
							
							
								<option value="" selected>Select Post</option>
							 
							<?php

             				$newquery = "SELECT * FROM `posts` ORDER BY gender DESC;";
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
                                    }}?> value="<?php echo $newrowss['pid']; ?>"><?php echo $newrowss['name']; echo ' (BPS-'. $newrowss['bps']; echo ') - '.ucfirst($newrowss['gender']);   ?></option> 
							<?php
							}
							}
							?>
							</select>		
                    </div>
                    <div class="col-lg-3" align="right" style=" border:px solid black ">
                    <input type="submit" name="submit1" value="Show Applications" class="btn btn-block btn-primary">
                </div>
				</div>
            </form>
         </div>
    </div>


           <?php

 if ($_SERVER['REQUEST_METHOD'] == 'GET'  && isset($_GET['submit1']) )
      {
     
           $pid=$_GET['post2'];
            
?>



    <div class="row" style="margin-top:10px">
        <table class="table table-striped table-bordered">
            <thead style="background-color: #4caf5047;">
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Father Name</th>
                  <th>CNIC</th>
                  <th>Personal Info</th>
                  <th>Documents</th>
                  <th>Approval</th>
                  <th>Acted By</th>
                </tr>
              </thead>    

            <?php
     
     $sql1 = "SELECT * FROM `posts` WHERE pid = '$pid'";
      $result1 = mysqli_query($conn, $sql1);

      if (mysqli_num_rows($result1) > 0) {
  // output data of each row
  while( $rows1 = mysqli_fetch_assoc($result1)) {
     $name=$rows1['name'];
}}
?>
<!--
      <div class="col-lg-5">
          Total applications for the post of <?php echo $name; ?> : <?php $total_rows; ?>
      <b><input class="form-control" type="text" value="<?php echo $name ?>" style="margin-bottom: 10px" readonly> </b>
    </div>
-->

    <!-- Pagination Start   -->
    <?php
        if (isset($_GET['pageno'])) 
        {
            $pageno = $_GET['pageno'];
        } 
        else 
        { 
            $pageno = 1;
        }
        $no_of_records_per_page = 10;
        $offset = ($pageno-1) * $no_of_records_per_page;
        $total_pages_sql = "SELECT COUNT(*) FROM`per_info`,`emp_document`,`post_apply` WHERE emp_document.said=per_info.said AND post_apply.said=emp_document.said AND FIND_IN_SET('$pid' , post_apply) ";
    $result = mysqli_query($conn,$total_pages_sql);
    $total_rows = mysqli_fetch_array($result)[0];
    $total_pages = ceil($total_rows / $no_of_records_per_page);
    $sql = "SELECT * FROM table LIMIT $offset, $no_of_records_per_page"; 
    ?>
            
            <div class="col-lg-6">
          <h5>Total applications = <?php echo $total_rows; ?></h5>
<!--      <b><input class="form-control" type="text" value="<?php echo $name ?>" style="margin-bottom: 10px" readonly> </b>-->
    </div>
      
<!--            Pagination ends-->
<?php
      $sql = "SELECT * FROM `per_info`,`emp_document`,`post_apply` WHERE emp_document.said=per_info.said AND post_apply.said=emp_document.said AND FIND_IN_SET('$pid' , post_apply) LIMIT $offset, $no_of_records_per_page ";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
  // output data of each row
        ?>


       <?php 
                $from = $offset+1;
                $to = $offset+$no_of_records_per_page;
          $counter = $from-1;
            ?>

        <?php

  while( $rows = mysqli_fetch_assoc($result)) {
       $counter=$counter+1;
//      $sql11 = "SELECT s_status FROM appstatus WHERE s_candid='$rows[said]' AND s_catid='$pid' ";
//      $result11 = $conn->query($sql11);
//      if ($result11->num_rows > 0) {
//} else {
//  $query11 = "INSERT INTO appstatus (s_candid, s_catid , s_status)
//                        VALUES ('$rows[said]', '$pid' , 'Pending')";  
//	           $exe = mysqli_query($conn,$query11);
//}
//      
      
      ?>

            <tbody>
                <td><?php echo $counter?></td>
                <td><?=$rows['basic_full_name']?></td>
                <td><?=$rows['basic_father_name']?></td>
                <td><?=$rows['contact_cnic']?></td>
<!--                <td><?php echo $name ?></td>-->
                <td align="center"><button type="button" name="see"  value="<?=$rows['said']?>" class="btn-sm view_data" style="border-radius: 15px; color: black; background-color: #337ab7c9; width: 83px; height: 45px; border: none;"  data-toggle="modal" data-target="#exampleModalCenter<?php echo $rows['id'];?>">See Details</button></td>
                  
                  
<div class="modal fade" id="exampleModalCenter<?php echo $rows['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Applicant Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-lg-5">
                  <label>Name </label>
              </div>
                <div class="col-lg-5">
                 <?php echo $rows["basic_full_name"];?>
              </div>
               </div>
                
            <div class="row">
          <div class="col-lg-5">
                <label>Father Name </label>
                </div>
                <div class="col-lg-5">
                    <?php echo $rows["basic_father_name"];?> 
                </div>
          </div>
               
                 <div class="row">
          <div class="col-lg-5">
                     <label>Gender </label>
                     </div>
                        <div class="col-lg-5">
                            <?php echo $rows["basic_gender"];?> 
                     </div>
          </div>
               
               
               
                 
               <div class="row">
                   <div class="col-lg-5">
               <label>Date of Birth </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["basic_dob"];?>
                       </div>
                   </div>
                  
               <div class="row">
                   <div class="col-lg-5">
                <label>Domicile </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["basic_domicile"];?>
                       </div>
                   </div>
               
              
                  <div class="row">
                   <div class="col-lg-5">
                <label>Marital Status </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["basic_marital_status"];?>
                       </div>
                   </div>
               
               <div class="row">
                   <div class="col-lg-5">
                <label>Contact Landline </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_phone_no"];?> 
                       </div>
                   </div>
               
                  <div class="row">
                   <div class="col-lg-5">
                <label>Contact Mobile </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_mobile"];?> 
                       </div>
                   </div>
               
               <div class="row">
                   <div class="col-lg-5">
                <label>CNIC </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_cnic"];?>  
                       </div>
                   </div>
               
                 <div class="row">
                   <div class="col-lg-5">
                <label>Email </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_email"];?>  
                       </div>
                   </div>
               
               
               <div class="row">
                   <div class="col-lg-5">
                <label>District </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_district"];?>  
                       </div>
                   </div>
                  
          <div class="row">
                   <div class="col-lg-5">
                <label>District Code </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_district_code"];?>  
                       </div>
                   </div>
          
          <div class="row">
                   <div class="col-lg-5">
                <label>City </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_city"];?>  
                       </div>
                   </div>
     
               
                <div class="row">
                   <div class="col-lg-5">
                <label>Religion </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_religion"];?>   
                       </div>
                   </div>
                 
               <div class="row">
                   <div class="col-lg-5">
                <label>Postal Address </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_postal_address"];?>    
                       </div>
                   </div>
               
               
                 <div class="row">
                   <div class="col-lg-5">
                <label>Permanent Address </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["contact_per_address"];?>    
                       </div>
                   </div>
               
          <div class="row">
                   <div class="col-lg-5">
                <label>Female Applying </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["female_applying"];?>    
                       </div>
                   </div>
          
          
          <?php  if($rows["female_husband"] != 'NULL'){ ?>
           <div class="row">
                   <div class="col-lg-5">
                <label>Husband's Name </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["female_husband"];?>    
                       </div>
                   </div>
          <?php } ?>
               
          <?php  if($rows["female_husband_province"] != 'NULL'){ ?>
               <div class="row">
                   <div class="col-lg-5">
                <label>Husband's Provinve </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $rows["female_husband_province"];?>    
                       </div>
                   </div>
          <?php } ?>
                 
          
          <?php  if($rows["female_husband_district"] != 'NULL'){ ?>
               <div class="row">
                   <div class="col-lg-5">
              <label>Husband's District </label>
                       </div>
                   <div class="col-lg-5">
                <?php echo $rows["female_husband_district"];?>     
                       </div>
                   </div>
               <?php } ?>
          
          <?php  if($rows["female_husband_district_code"] != 'NULL'){ ?>
               <div class="row">
                   <div class="col-lg-5">
              <label>Husband's District Code </label>
                       </div>
                   <div class="col-lg-5">
                <?php echo $rows["female_husband_district_code"];?>     
                       </div>
                   </div>
          <?php } ?>
          
                  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>            
                  
                  
                  
                <td align="center">
                    
                    <a data-fancybox="gallery" title="Candidate Image" href="../<?php echo $rows['image']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <a data-fancybox="gallery" class="primary-btn" title="Candidate Father CNIC" href="../<?php echo $rows['cnic']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <a data-fancybox="gallery" class="primary-btn" title="Candidate Nadra Form-B" href="../<?php echo $rows['recipt']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <a data-fancybox="gallery" class="primary-btn" title="Recipt Challan" href="../<?php echo $rows['domicile']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <a data-fancybox="gallery" class="primary-btn" title="Character Certificate" href="../<?php echo $rows['last_degree']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php if(isset($rows['professional_degree'])){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Professional Degree" href="../<?php echo $rows['professional_degree']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                    <?php if(isset($rows['driving_license'])){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Driving Liscence" href="../<?php echo $rows['driving_license']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                </td>

                <?php
                
                $sql2 = "SELECT * FROM `details` WHERE d_said = '$rows[said]' AND d_postid = '$pid' ";
                $result2 = $conn->query($sql2);
                if ($result2->num_rows > 0) {
                  while($row2 = $result2->fetch_assoc()) {
              ?>

        
                <td align="center">
                  <?php
                    if($row2['d_status']=='Approved' || $row2['d_status']=='Rejected' ){
                      if($row2['d_status']=='Approved')
                      {
                        echo $row2['d_rollno'];
                      }
                      else
                      {
                      echo strtoupper($row2['d_status']);
                      }
                    }
                    
                    else{
                        if($userid == 'Read Only'){
                            echo 'Pending';
                        }
                        else{
                  ?>
                    <div class="row">
 
                    <div class="span6">
                        
                  <form class="form-group" action="approved.php" method="POST" onsubmit="return confirm('Are you sure you want to Accept?');">
                     <?php 
                      $sql="SELECT  `name`, `gender` FROM `posts` WHERE `pid` = '$pid'";
        $exe2 = mysqli_query($conn , $sql);
        $data = mysqli_fetch_array($exe2);
//        $p_name = $data['name'];      
//        $p_gender = $data['gender']; 
                      ?>
                      <input type="hidden" name="p_name" value="<?php echo $data['name'];?>" />
                      <input type="hidden" name="p_gender" value="<?php echo $data['gender'];?>" />
                      <input type="hidden" name="p_city" value="<?php echo $rows['city_prefer'];?>" />

                      
                      
                      
                      
<!--                                <input type="type" name="f_time" id="code" value="CURRENT_DATE();">-->
                                <input type="hidden" name="id" value="<?php echo $rows['said'];?>" />
                                <textarea class="hidden" name="feedback" required><?php echo $rows['feedback']?>Your application has been approved for the post of <?php echo $name; ?></textarea>
                                <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
                                <button type="submit" style="border:none; background: none;" name="submit1" value="<?php echo $pageno; ?>"><i class="fa fa-check" style="font-size:22px; color: green;"></i></button>
                            </form>
                        </div>
                        <div class="span6">
                    <form class="form-group" action="rejectedapp.php" method="POST" onsubmit="return confirm('Are you sure you want to Reject?');">
<!--                                <input type="type" name="f_time" id="code" value="CURRENT_DATE();">-->
                                <input type="hidden" name="id" value="<?php echo $rows['said'];?>" />
                                <textarea class="hidden" name="feedback" required><?php echo $rows['feedback']?>Your application for the post of <?php echo $name; ?> has been rejected. </textarea>
                                <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
                                <button type="submit" style="border:none; background: none;" name="submit1" value="<?php echo $pageno; ?>"><i class="fa fa-close view_form" style="font-size:22px; color: red;"></i></button>
                            </form>
                        </div>
                    </div>
                <?php
                    }  
                  }
                }
                }
                  ?>                    
              </td>
                <?php
                    $username = "SELECT * FROM `details` WHERE d_said = '$rows[said]' AND d_postid = '$pid' ";
                    $exeusername = mysqli_query($conn, $username);
                    $usernamedata = mysqli_fetch_array($exeusername);
                    
                ?>
                 <td><?php echo strtoupper($usernamedata['act_by']); ?></td>   
              </tbody>

<?php
}?></table>
</div>
<div class="row">
    <b>
        <?php
          $from = $offset+1;
          $to = $offset+$no_of_records_per_page;
          echo $from.' - '.$counter.' of '.$total_rows ;
        ?>
    </b>
</div>
<?php 
}

?>

    <div class="row">
    <div class="col-lg-10" style="align:left;">
        <ul class="pagination">
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".($pageno - 1); } ?>">Prev</a>
            </li>
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".($pageno + 1); } ?>">Next</a>
            </li>
        </ul>
    </div>
        <div class="col-lg-2">
            <form action="exportall.php" method="post">
              <input type="hidden" name="pix" value="<?php echo $pid; ?> ">
                <button onclick ="return confirm('Are you sure you want to export data')" type="submit" id="btnExport" name='exceldata'
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
}

else{
  header("Location: index.php");
}

?>