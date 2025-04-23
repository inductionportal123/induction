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
<?php 
      include('header.php');  
    include('appnav.php');  
    
    ?>
  
<div  class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-4 main" >
    <div class="row">
        <div class="col-lg-12" align="center">
            <h3 style="color: green;">Approved Applications</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" align="center">
               <form method="GET">
    <div class="row">
        <!--<div class="col-lg-3" align="right">-->
        <!--    <label>Post:</label>-->
        <!--</div>-->
        <div class="col-lg-5" align="left">
            <select class="form-control" name="post2" required>
                <option value="" selected>Select Post</option>
                <?php
                $newquery = "SELECT * FROM `posts` ORDER BY gender DESC;";
                $newdatas = mysqli_query($conn, $newquery);
                $newrowct = mysqli_num_rows($newdatas);

                if ($newrowct > 0) {
                    while ($newrowss = mysqli_fetch_array($newdatas)) {
                ?>
                        <option <?php if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit1'])) {
                                    if ($_GET['post2'] == $newrowss['pid']) {
                                        echo 'selected';
                                    }
                                } ?> value="<?php echo $newrowss['pid']; ?>"><?php echo $newrowss['name'] . ' (BPS-' . $newrowss['bps'] . ') - ' . ucfirst($newrowss['gender']); ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <!--<div class="col-lg-2" align="right">-->
        <!--    <label>CNIC:</label>-->
        <!--</div>-->
        <div class="col-lg-3" align="left">
            <input type="text" class="form-control" name="cnic" placeholder="Enter CNIC" value="<?php echo isset($_GET['cnic']) ? htmlspecialchars($_GET['cnic']) : ''; ?>">
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
              $pid = isset($_GET['post2']) ? $_GET['post2'] : '';
$cnic = isset($_GET['cnic']) ? $_GET['cnic'] : '';

// Pagination variables
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno - 1) * $no_of_records_per_page;

// Query to fetch total records for pagination
$total_count_sql = "SELECT COUNT(*) AS total_count
                    FROM post_apply
                    INNER JOIN details ON post_apply.said = details.d_said
                    INNER JOIN per_info ON post_apply.said = per_info.said
                    INNER JOIN qualification ON qualification.said = post_apply.said
                    INNER JOIN emp_document ON post_apply.said = emp_document.said
                    WHERE FIND_IN_SET('$pid', post_apply.post_apply) 
                    AND details.d_postid = '$pid' 
                    AND details.d_status = 'Approved' 
                    AND per_info.undertaking = 1";
                    
if (!empty($cnic)) {
    $total_count_sql .= " AND per_info.contact_cnic = '$cnic'";
}

$exepages = mysqli_query($conn, $total_count_sql);
$total_rows = mysqli_fetch_array($exepages)['total_count'];
$total_pages = ceil($total_rows / $no_of_records_per_page);

// Query to fetch approved applications with pagination and CNIC filter
$approved_query = "SELECT post_apply.city_prefer, post_apply.said, post_apply.post_apply, details.d_said, details.d_postid, per_info.*, qualification.*, emp_document.image, emp_document.recipt, emp_document.cnic, emp_document.domicile, emp_document.said, emp_document.last_degree, emp_document.professional_degree, emp_document.driving_license, details.d_rollno,results.marks,	 details.act_by 
                    FROM post_apply 
                    INNER JOIN details ON post_apply.said = details.d_said 
                    LEFT JOIN results ON details.d_rollno= results.roll_no
                    INNER JOIN per_info ON post_apply.said = per_info.said 
                    INNER JOIN qualification ON qualification.said = post_apply.said 
                    INNER JOIN emp_document ON post_apply.said = emp_document.said 
                    WHERE FIND_IN_SET('$pid', post_apply.post_apply) 
                    AND details.d_postid = '$pid' 
                    AND details.d_status = 'Approved' 
                    AND per_info.undertaking = 1";
if (!empty($cnic)) {
    $approved_query .= " AND per_info.contact_cnic = '$cnic'";
}
$approved_query .= " LIMIT $offset, $no_of_records_per_page";

$exeapproved = mysqli_query($conn, $approved_query);
$rowsapproved = mysqli_num_rows($exeapproved);
          if($rowsapproved > 0){
              $counter=$offset;
              ?>
                <table class="table table-striped table-bordered">
                    <thead style="background-color: #4caf5047;">
                        <tr>
                          <th>Sr#</th>
                          <th>Name</th>
                          <th>Father Name</th>
                          <th>CNIC</th>
                          <th>Post Apply</th>
                          <th>Personal Info</th>
                          <th>Documents</th>
                          <th>Roll Number</th>
                          <th>Marks</th>
                          <th>Action</th>
                        </tr>
                    </thead>
                    
                    <?php
                  while($approveddata = mysqli_fetch_array($exeapproved)){
                  $counter++;
                  ?>
                    <tbody>
                        <td><?php echo $counter?></td>
                        <td><?=$approveddata['basic_full_name']?></td>
                        <td><?=$approveddata['basic_father_name']?></td>
                        <td><?=$approveddata['contact_cnic']?></td>
                        <?php
                        $qury = "SELECT `name` FROM `posts` WHERE pid= '".$approveddata['d_postid']."'";
                        $sss = mysqli_query($conn, $qury);
                        $ery = mysqli_fetch_array($sss);
                        $cat = $ery['name'];
                        ?>
                        <td><?=$cat?></td>
                        <td align="center"><button type="button" name="see"  value="<?=$approveddata['said']?>" class="btn-sm view_data" style="border-radius: 15px; color: black; background-color: #337ab7c9; width: 83px; height: 45px; border: none;"  data-toggle="modal" data-target="#exampleModalCenter<?php echo $approveddata['id'];?>">See Details</button></td>
                        
                        <!-------------------------Modal----------------------------->
                        <div class="modal fade" id="exampleModalCenter<?php echo $approveddata['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Applicant Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                      <div class="col-lg-5">
                                          <label>Rol Number </label>
                                          </div>
                                          
                                        <div class="col-lg-5">
                                         <?php echo $approveddata["d_rollno"];?>
                                      </div>
                                      </div>
                                       </div>
                                  <div class="row">
                                      <div class="col-lg-5">
                                          <label>Name </label>
                                      </div>
                                        <div class="col-lg-5">
                                         <?php echo $approveddata["basic_full_name"];?>
                                      </div>
                                       </div>
                                    <div class="row">
                                      <div class="col-lg-5">
                                            <label>Father Name </label>
                                            </div>
                                            <div class="col-lg-5">
                                                <?php echo $approveddata["basic_father_name"];?> 
                                            </div>
                                      </div>
                                    <div class="row">
                                      <div class="col-lg-5">
                                                 <label>Gender </label>
                                                 </div>
                                                    <div class="col-lg-5">
                                                        <?php echo $approveddata["basic_gender"];?> 
                                                 </div>
                                      </div>




                                           <div class="row">
                                               <div class="col-lg-5">
                                           <label>Date of Birth </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["basic_dob"];?>
                                                   </div>
                                               </div>

                                           <?php 
                    if($approveddata["basic_domicile"] == 1)
                    {
                        $dom = "Punjab";
                    }
                    elseif($approveddata["basic_domicile"] == 2)
                    {
                        $dom = "KPK";
                    }
                    elseif($approveddata["basic_domicile"] == 3)
                    {
                        $dom = "Balochistan";
                    }
                    elseif($approveddata["basic_domicile"] == 4)
                    {
                        $dom = "Sindh(Urban)";
                    }
                    elseif($approveddata["basic_domicile"] == 5)
                    {
                        $dom = "Sindh(Rural)";
                    }       
                    elseif($approveddata["basic_domicile"] == 6)
                    {
                        $dom = "AJK";
                    }
                    elseif($approveddata["basic_domicile"] == 7)
                    {
                        $dom = "FATA";
                    }
                    elseif($approveddata["basic_domicile"] == 8)
                    {
                        $dom = "GB ";
                    }
                ?>
                
          
          
          
          
               <div class="row">
                   <div class="col-lg-5">
                <label>Domicile </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $dom;?>
                       </div>
                   </div>


                                              <div class="row">
                                               <div class="col-lg-5">
                                            <label>Marital Status </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["basic_marital_status"];?>
                                                   </div>
                                               </div>

                                           <div class="row">
                                               <div class="col-lg-5">
                                            <label>Contact Landline </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_phone_no"];?> 
                                                   </div>
                                               </div>

                                              <div class="row">
                                               <div class="col-lg-5">
                                            <label>Contact Mobile </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_mobile"];?> 
                                                   </div>
                                               </div>

                                           <div class="row">
                                               <div class="col-lg-5">
                                            <label>CNIC </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_cnic"];?>  
                                                   </div>
                                               </div>

                                             <div class="row">
                                               <div class="col-lg-5">
                                            <label>Email </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_email"];?>  
                                                   </div>
                                               </div>


                                           <div class="row">
                                               <div class="col-lg-5">
                                            <label>District </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_district"];?>  
                                                   </div>
                                               </div>

                                     

                                      <div class="row">
                                               <div class="col-lg-5">
                                            <label>City </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_city"];?>  
                                                   </div>
                                               </div>


                                            <div class="row">
                                               <div class="col-lg-5">
                                            <label>Religion </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_religion"];?>   
                                                   </div>
                                               </div>

                                           <div class="row">
                                               <div class="col-lg-5">
                                            <label>Postal Address </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_postal_address"];?>    
                                                   </div>
                                               </div>


                                             <div class="row">
                                               <div class="col-lg-5">
                                            <label>Permanent Address </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php echo $approveddata["contact_per_address"];?>    
                                                   </div>
                                               </div>
                                               
                                               <?php if($approveddata['basic_gender']=='female')
                                               {
                                               ?>

                                      <div class="row">
                                               <div class="col-lg-5">
                                            <label>Appliying against spouse &apos;s domicile </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php if($approveddata["female_applying"]==1)
                                           {
                                            echo 'Yes';
                                           }
                                           else 
                                           {
                                            echo 'No';
                                           }
                                           ?>    
                                                   </div>
                                               </div>
                                            

                                               <?php } if($approveddata["female_applying"]==1)
                              {   if($approveddata["female_husband"] != 'NULL'){ ?>
           <div class="row">
                   <div class="col-lg-5">
                <label>Spouse's Name </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $approveddata["female_husband"];?>    
                       </div>
                   </div>
          <?php } ?>
               
          <?php  if($approveddata["female_husband_province"] != 'NULL'){ ?>
               <div class="row">
                   <div class="col-lg-5">
                <label>Spouse's Provinve </label>
                       </div>
                   <div class="col-lg-5">
               <?php echo $approveddata["female_husband_province"];?>    
                       </div>
                   </div>
          <?php } ?>
                 
          
          <?php  if($approveddata["female_husband_district"] != 'NULL'){ ?>
               <div class="row">
                   <div class="col-lg-5">
              <label>Spouse's District </label>
                       </div>
                   <div class="col-lg-5">
                <?php echo $approveddata["female_husband_district"];?>     
                       </div>
                   </div>
               <?php } ?>
          
          <?php  if($approveddata["female_husband_district_code"] != 'NULL'){ ?>
               <div class="row">
                   <div class="col-lg-5">
              <label>Spouse's District Code </label>
                       </div>
                   <div class="col-lg-5">
                <?php echo $approveddata["female_husband_district_code"];?>     
                       </div>
                   </div>
          <?php } }?>
                                    
                                    
                                    <div class="row">
              <hr style="width:100%;height:5px;">
              <h5 style="font-weight:bold;margin-left:15px;">Qualification</h5>
              <br/>
              <br/>                                
                <div class="col-lg-3" style="font-weight:bold;">Title</div>
                <div class="col-lg-3" style="font-weight:bold;">Specialization</div>
                <div class="col-lg-3" style="font-weight:bold;">Total Marks</div>
                <div class="col-lg-3" style="font-weight:bold;">Board</div>
<br>





<?php  if($approveddata["primary_title"] != 'NULL'){ 
                $details1 = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata['primary_title'] . "'";
$detailsexe1 = mysqli_query($conn, $details1);
$rows12 = mysqli_fetch_array($detailsexe1);
?>

              
                <div class="col-lg-3"><?php echo $rows12["qualification_category"];?></div>

                <div class="col-lg-3"><?php echo $approveddata["primary_specialization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["primary_total_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["primary_board"];?></div>

              <?php } ?>
<br/>
<br/>



<?php  if($approveddata["middle_title"] != 'NULL'){ 
                $details1 = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata['middle_title'] . "'";
$detailsexe1 = mysqli_query($conn, $details1);
$rows12 = mysqli_fetch_array($detailsexe1);
?>

              
                <div class="col-lg-3"><?php echo $rows12["qualification_category"];?></div>

                <div class="col-lg-3"><?php echo $approveddata["middle_specialization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["middle_total_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["middle_board"];?></div>

              <?php } ?>
<br/>
<br/>


<?php
$details1 = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata['matric_title'] . "'";
$detailsexe1 = mysqli_query($conn, $details1);
$rows12 = mysqli_fetch_array($detailsexe1);
?>

              
                <div class="col-lg-3"><?php echo $rows12["qualification_category"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["matric_specialization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["matric_total_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["matric_board"];?></div>
<br/>
<br/>                
              <?php  if($approveddata["inter_title"] != 'NULL'){  
                  $details1 = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata['inter_title'] . "'";
$detailsexe1 = mysqli_query($conn, $details1);
$rows12 = mysqli_fetch_array($detailsexe1);
?>

              
                <div class="col-lg-3"><?php echo $rows12["qualification_category"];?></div>

                <div class="col-lg-3"><?php echo $approveddata["inter_specialization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["inter_total_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["inter_board"];?></div>
                
              <?php } ?>
<br/>
<br/>
              <?php  if($approveddata["bs_title"] != 'NULL'){ 
                $details1 = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata['bs_title'] . "'";
                $detailsexe1 = mysqli_query($conn, $details1);
                $rows12 = mysqli_fetch_array($detailsexe1);
                ?>
                
                              
                                <div class="col-lg-3"><?php echo $rows12["qualification_category"];?></div>

                <div class="col-lg-3"><?php echo $approveddata["bs_specialization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["bs_total_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["bs_board"];?></div>

            <?php } ?>
<br/>
<br/>



              <?php  if($approveddata["bs16_title"] != 'NULL'){ 
                $details1 = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata['bs16_title'] . "'";
                $detailsexe1 = mysqli_query($conn, $details1);
                $rows12 = mysqli_fetch_array($detailsexe1);
                ?>
                
                              
                                <div class="col-lg-3"><?php echo $rows12["qualification_category"];?></div>

                <div class="col-lg-3"><?php echo $approveddata["bs16_specialization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["bs16_total_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["bs16_board"];?></div>

            <?php } ?>
<br/>
<br/>




            <?php  if($approveddata["ms_title"] != 'NULL'){ 
                $details1 = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata['ms_title'] . "'";
$detailsexe1 = mysqli_query($conn, $details1);
$rows12 = mysqli_fetch_array($detailsexe1);
?>

              
                <div class="col-lg-3"><?php echo $rows12["qualification_category"];?></div>

                <div class="col-lg-3"><?php echo $approveddata["ms_specialization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["ms_total_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["ms_board"];?></div>

              <?php } ?>
<br/>
<br/>
              <?php  if($approveddata["diploma_title"] != 'NULL'){ ?>
              
                <div class="col-lg-2"><?php echo $approveddata["diploma_title"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["diploma_specialization"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["diploma_obtained_marks"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["diploma_total_marks"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["diploma_percent"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["diploma_board"];?></div>
              
              <?php } ?>

          </div>
          
<br/>
<br/>
          <?php  if($approveddata["profes_certificate"] != 'NULL'){ ?>

          <div class="row">
                <hr style="width:100%;height:5px;">
                <h5 style="font-weight:bold;">Professional Qualification</h5>
<br/>                                
                <div class="col-lg-3" style="font-weight:bold;">Certificate</div>
                <div class="col-lg-3" style="font-weight:bold;">Marks Obtain</div>
                <div class="col-lg-3" style="font-weight:bold;">Total Marks</div>
                <div class="col-lg-3" style="font-weight:bold;">Board</div>
<br/>                                
<br/>                                
                <div class="col-lg-3"><?php echo $approveddata["profes_certificate"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["profes_obtained_marks"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["profes_total_marks"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["profes_board"];?></div>
          </div>
                     <?php } ?>

          
<br/>
<br/>
          
<?php  if($approveddata["employ_job_title"] != 'NULL'){ ?>
       
          <div class="row">
                <hr style="width:100%;height:5px;">
                <h5 style="font-weight:bold;margin-left:25px;">Work Experience</h5>             
<br/>                  
                <div class="col-lg-3" style="font-weight:bold;">Job Title</div>
                <div class="col-lg-3" style="font-weight:bold;">Organization</div>
                <div class="col-lg-3" style="font-weight:bold;">Date From</div>
                <div class="col-lg-3" style="font-weight:bold;">Date TO</div>
<br/>
<br/>                  
                <div class="col-lg-3"><?php echo $approveddata["employ_job_title"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["employ_organization"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["employ_from_date"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["employ_to_date"];?></div>
<br/>
<br/>
                
                <?php  if($approveddata["employ_organization_two"] != 'NULL'){ ?>

                <div class="col-lg-3"><?php echo $approveddata["employ_job_title_two"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["employ_organization_two"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["employ_from_date_two"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["employ_to_date_two"];?></div>

                 <?php } ?>
<br/>
<br/>
                <?php  if($approveddata["employ_job_title_three"] != 'NULL'){ ?>
                
                <div class="col-lg-3"><?php echo $approveddata["employ_job_title_three"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["employ_organization_three"];?></div>
                <div class="col-lg-3"><?php echo $approveddata["employ_from_date_three"];?></div>
                <div class="col-lg-2"><?php echo $approveddata["employ_from_to_three"];?></div>

                <?php } ?>
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
                    
                    <a data-fancybox="gallery" title="Candidate Image" href="../<?php echo $approveddata['image']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <a data-fancybox="gallery" class="primary-btn" title="CNIC" href="../<?php echo $approveddata['cnic']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php if($approveddata['recipt'] != 'NULL'){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Reciept" href="../<?php echo $approveddata['recipt']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Domicile" href="../<?php echo $approveddata['domicile']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <a data-fancybox="gallery" class="primary-btn" title="Last Degree" href="../<?php echo $approveddata['last_degree']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php if($approveddata['professional_degree'] != 'NULL'){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Professional Degree" href="../<?php echo $approveddata['professional_degree']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                    <?php if($approveddata['driving_license'] != 'NULL'){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Driving License" href="../<?php echo $approveddata['driving_license']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                </td>

                <td align="center">
                         <?php echo $approveddata["d_rollno"];?>   
              </td>
                   <td align="center">
    <?php 
        echo isset($approveddata["marks"]) && !empty($approveddata["marks"]) 
            ? strtoupper($approveddata["marks"]) 
            : 'N/A'; // Default value if marks are not set
    ?>   
</td>



              <form action="">
              <td align="center">
    <a href="reverse.php?id=<?= $approveddata['d_postid'] ?>&postid=<?= $approveddata['said'] ?>" class="btn btn-danger btn-sm">Reverse</a>
</td>
              </form>












              </tbody>  
                <?php
                  }
                    ?>
                    <div class="row">
                        <b>
                        <?php
                          $from = $offset+1;
                          $to = $offset+$no_of_records_per_page;
                          echo $from.' - '.$counter.' of '.$total_rows ;
                        ?>
                        </b>
                    </div>
    </table>
    <?php
     $pagLink='';
                for ($i=1; $i<=$total_pages; $i++)
                {  
                    $pagLink .= "<a class='page-link' href='?post2=".$pid."&submit1=Show+Applications&pageno=".$i."'> ".$i." </a>";  
                };
            ?>
        <div class="row">
        <div class="col-lg-10" style="align:left;">
            <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".(1); } ?>">First</a></li>
                <li class="page-item"><a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".($pageno - 1); } ?>">Prev</a></li>
                <li class="page-item"><?php echo $pagLink; ?></li>
                <li class="page-item"><a class="page-link " href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".($pageno + 1); } ?>" >Next</a></li>
                <li class="page-item"><a class="page-link " href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".($total_pages); } ?>" >Last</a></li>
            </ul>
        </nav>
<!--
            <ul class="pagination">
                <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".($pageno - 1); } ?>">Prev</a>
                </li>
                <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                    <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?post2=".$pid."&submit1=Show+Applications&pageno=".($pageno + 1); } ?>">Next</a>
                </li>
            </ul>
-->
        </div>
        <div class="col-lg-2">
            <form action="exportfilteredapproved.php" method="post">
                <input type="hidden" class="form-control" value="<?php echo $pid; ?>" name="postid">
                <button onclick ="return confirm('Are you sure you want to export data')"  type="submit" id="btnExport" name='exceldata'
                    value="Export to Excel" class="btn btn-info">Export
                    By Post</button>
            </form>
        </div>
        </div>
    <?php
          }
          else{
          ?>
            <div class="row">
                <div class="col-lg-9 col-lg-offset-2" style="align:center;">
                    <h4>No Approved Applications for selected post.</h4>
                </div>
            </div>
        <?php
      }?>
          <form action="exportapproved.php" method="post">
                <button onclick ="return confirm('Are you sure you want to export data')"  type="submit" id="btnExport" name='exceldata'
                    value="Export to Excel" class="btn btn-info">Export
                    All</button>
            </form>
              <?php
      }
    ?>
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

?>