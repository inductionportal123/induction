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
            <h3 style="color: green;">Rejected Applications</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" align="center">
           <form method="GET">
    <div class="row">
        <!--<div class="col-lg-3" align="right">-->
        <!--    <label>Post:</label>-->
        <!--</div>-->
        <div class="col-lg-6">
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
        <div class="col-lg-3">
            <input type="text" class="form-control" name="cnic" placeholder="Enter CNIC" value="<?php echo isset($_GET['cnic']) ? htmlspecialchars($_GET['cnic']) : ''; ?>">
        </div>
        <div class="col-lg-1" align="right">
            <input type="submit" name="submit1" value="Show Applications" class="btn btn-primary">
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

// Pagination Start
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}

$no_of_records_per_page = 10;
$offset = ($pageno - 1) * $no_of_records_per_page;

// Total records calculation
$total_pages_sql = "SELECT COUNT(*) AS total_count
                    FROM post_apply
                    INNER JOIN details ON post_apply.said = details.d_said
                    INNER JOIN per_info ON post_apply.said = per_info.said
                    INNER JOIN qualification ON qualification.said = post_apply.said
                    INNER JOIN emp_document ON post_apply.said = emp_document.said
                    WHERE FIND_IN_SET('$pid', post_apply.post_apply) 
                    AND details.d_postid = '$pid' 
                    AND details.d_status = 'Rejected' 
                    AND per_info.undertaking = 1";

$exepages = mysqli_query($conn, $total_pages_sql);
$total_rows = mysqli_fetch_array($exepages)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);
$from = $offset + 1;
$to = min($offset + $no_of_records_per_page, $total_rows);

// Pagination ends

// Fetching rejected applications with CNIC filter
$approved = "
    SELECT 
        details.d_feedback,
        details.revert,
        post_apply.city_prefer,
        post_apply.said,
        post_apply.post_apply,
        details.d_said,
        details.d_postid,
        per_info.*,
        per_info_contact.*,
        per_info_spouse.*,
        qualification.*,
        emp_document.image,
        emp_document.recipt,
        emp_document.cnic,
        emp_document.domicile,
        emp_document.said,
        emp_document.last_degree,
        emp_document.professional_degree,
        emp_document.driving_license,
        details.d_status,
        details.act_by
    FROM post_apply
    INNER JOIN details ON post_apply.said = details.d_said
    INNER JOIN per_info ON post_apply.said = per_info.said
    INNER JOIN per_info_contact ON post_apply.said = per_info_contact.said
    INNER JOIN per_info_spouse ON post_apply.said = per_info_spouse.said
    INNER JOIN qualification ON post_apply.said = qualification.said
    INNER JOIN emp_document ON post_apply.said = emp_document.said
    WHERE FIND_IN_SET('$pid', post_apply.post_apply) 
      AND details.d_postid = '$pid' 
      AND details.d_status = 'Rejected' 
      AND per_info.undertaking = 1
";


// Adding CNIC filter if provided
if (!empty($cnic)) {
    $approved .= " AND per_info.contact_cnic = '$cnic'";
}

$approved .= " LIMIT $offset, $no_of_records_per_page";

$exeapproved = mysqli_query($conn, $approved);
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
                          <th>Status</th>
                          <th>Action</th>
                          <th>Acted By</th>
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
                                          <label>Feedback </label>
                                      </div>
                                        <div class="col-lg-5">
                                         <?php echo $approveddata["d_feedback"];?>
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
<?php

                                           $dob = $approveddata["basic_dob"]; // Assume the date is in YYYY-MM-DD format
               $date = new DateTime($dob);
               $formattedDate = $date->format('d-m-Y'); // Change this to your desired format
               echo $formattedDate ;
               

               ?>
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
                        $dom = "GB";
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

                                      <div class="row">
                                               <div class="col-lg-5">
                                            <label>Female appliying against their spouse Domicile </label>
                                                   </div>
                                               <div class="col-lg-5">
                                           <?php
                                           if($approveddata["female_applying"]== 1)
                                           {
                                            echo 'yes';
?>
                                            </div>
                                               </div>
                                               <?php

 if($approveddata["female_husband"] != 'NULL'){ ?>
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
                                                    <?php }




                                           } 
                                           else 
                                           {
                                            echo 'No';
                                           }
                                           ?>
                                           </div>
                                               </div>

                                       
          
          
          <!-- <?php  if($approveddata["female_husband_district_code"] != 'NULL'){ ?>
               <div class="row">
                   <div class="col-lg-5">
              <label>Husband's District Code </label>
                       </div>
                   <div class="col-lg-5">
                <?php echo $approveddata["female_husband_district_code"];?>     
                       </div>
                   </div>
          <?php } ?> -->
                                    
          <?php
$hasQualification = false;

// Check if at least one qualification exists
$qualificationFields = [
    "matric_title", "inter_title", "bs_title", "ms_title", "diploma_title"
];

foreach ($qualificationFields as $field) {
    if (!empty($approveddata[$field]) && $approveddata[$field] != 'NULL') {
        $hasQualification = true;
        break;
    }
}

if ($hasQualification):
?>
<div class="row" style="background-color: white;">
    <hr style="width:100%;height:5px;">
    <h5 style="font-weight:bold;margin-left:15px;">Qualification</h5>
    <br><br>
    <div class="col-lg-3" style="font-weight:bold;">Title</div>
    <div class="col-lg-3" style="font-weight:bold;">Specialization</div>
    <div class="col-lg-3" style="font-weight:bold;">Total Marks</div>
    <div class="col-lg-3" style="font-weight:bold;">Board</div>
    <br>

    <?php
    function showQualification($title, $specialization, $marks, $board, $tableField = null, $isDirectText = false) {
        global $conn, $approveddata;

        echo '<br>';

        if ($isDirectText) {
            echo '<div class="col-lg-3">' . $title . '</div>';
        } else {
            $query = "SELECT qualification_category FROM qualification_category WHERE id='" . $approveddata[$title] . "'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
            echo '<div class="col-lg-3">' . $row["qualification_category"] . '</div>';
        }

        echo '<div class="col-lg-3">' . $approveddata[$specialization] . '</div>';
        echo '<div class="col-lg-3">' . $approveddata[$marks] . '</div>';
        echo '<div class="col-lg-3">' . $approveddata[$board] . '</div>';
        echo '<br>';
    }

    if (!empty($approveddata["matric_title"]) && $approveddata["matric_title"] != 'NULL') {
        showQualification("matric_title", "matric_specialization", "matric_total_marks", "matric_board");
    }

    if (!empty($approveddata["inter_title"]) && $approveddata["inter_title"] != 'NULL') {
        showQualification("inter_title", "inter_specialization", "inter_total_marks", "inter_board");
    }

    if (!empty($approveddata["bs_title"]) && $approveddata["bs_title"] != 'NULL') {
        showQualification("bs_title", "bs_specialization", "bs_total_marks", "bs_board");
    }

    if (!empty($approveddata["ms_title"]) && $approveddata["ms_title"] != 'NULL') {
        showQualification("ms_title", "ms_specialization", "ms_total_marks", "ms_board");
    }

    if (!empty($approveddata["diploma_title"]) && $approveddata["diploma_title"] != 'NULL') {
        showQualification($approveddata["diploma_title"], "diploma_specialization", "diploma_total_marks", "diploma_board", null, true);
    }
    ?>
</div>

<?php endif; ?>

<br/>
          <?php  if($approveddata["profes_certificate"] != 'NULL'){ ?>

          <div class="row"  style="background-color: white;">
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

          

                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>            
                  
                  
                  
                <td align="center">
                    <?php if($approveddata['image'] != 'NULL'){  ?>
                    <a data-fancybox="gallery" title="Candidate Image" href="../<?php echo $approveddata['image']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                    
                    <?php if($approveddata['cnic'] != 'NULL'){  ?>
                    <a data-fancybox="gallery" class="primary-btn" title="CNIC" href="../<?php echo $approveddata['cnic']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                    
                    <?php if($approveddata['recipt'] != 'NULL'){  ?>
                    <a data-fancybox="gallery" class="primary-btn" title="RECIPT" href="../<?php echo $approveddata['recipt']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php  } ?>
                    
                    <?php if($approveddata['domicile'] != 'NULL'){  ?>
                    <a data-fancybox="gallery" class="primary-btn" title="DOMICILE" href="../<?php echo $approveddata['domicile']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php  } ?>
                    
                    <?php if($approveddata['last_degree'] != 'NULL'){  ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Last Degree" href="../<?php echo $approveddata['last_degree']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php  } ?>
                    
                    <?php if($approveddata['professional_degree'] != 'NULL'){  ?>
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
                         <?php
                         
                         if($approveddata["revert"] == 1 )
                         {
                             echo 'reverted';
                         }
                         else
                         {
                                                      echo $approveddata["d_status"];

                         }
                         
                         
                         
                         ?>   
              </td>
              
              <td align="center">
                <form action="" >
                  <a href="reverse.php?id=<?= $approveddata['d_postid'] ?>&postid=<?= $approveddata['said'] ?>" class="btn btn-danger btn-sm">Reverse</a>
               </form>
              </td>
              
              
                    <td><?php echo strtoupper($approveddata['act_by']);?></td>
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
            <form class="form" action="exportfilteredrejected.php" method="post">
                <input type="hidden" class="form-control" value="<?php echo $pid; ?>" name="postid">
                <button onclick ="return confirm('Are you sure you want to export data')"  type="submit" id="btnExport" name='exceldata'
                    value="Export to Excel" class="btn btn-info">Export
                    Filtered</button>
            </form>
            <br>
            
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
      }
         ?> <form class="form" action="exportrejected.php" method="post">
                <button onclick ="return confirm('Are you sure you want to export data')"  type="submit" id="btnExport" name='exceldata'
                    value="Export to Excel" class="btn btn-info">Export
                    All Rejected</button>
            </form>
    <?php
      }
    ?>
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

?>