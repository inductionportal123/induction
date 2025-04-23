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
            <h3 style="color: green;">Pending Applications</h3>
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
            
                </tr>
              </thead>    

            <?php
     
     $sql1 = "SELECT * FROM `posts` WHERE pid = '$pid'";
      $result1 = mysqli_query($conn, $sql1);

      if (mysqli_num_rows($result1) > 0) {
  while( $rows1 = mysqli_fetch_assoc($result1)) {
     $name=$rows1['name'];
}}
?>

<?php
      $sql = "SELECT post_apply.post_apply, post_apply.city_prefer,per_info.basic_full_name , per_info.basic_father_name , per_info.contact_cnic , emp_document.image , emp_document.recipt , emp_document.cnic , emp_document.domicile, emp_document.last_degree, emp_document.professional_degree, emp_document.driving_license, emp_document.said , per_info.undertaking FROM `post_apply` 

INNER JOIN details on post_apply.said = details.d_said 

INNER JOIN per_info on post_apply.said = per_info.said

INNER JOIN emp_document on post_apply.said = emp_document.said

WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND details.d_postid='$pid' AND details.d_status = 'Pending' AND per_info.undertaking = 1 LIMIT 10";


      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
$counter=0;
  while( $rows = mysqli_fetch_assoc($result)) {
       $counter=$counter+1;
      ?>

            <tbody>
                <td><?php echo $counter?></td>
                <td><?=$rows['basic_full_name']?></td>
                <td><?=$rows['basic_father_name']?></td>
                <td><?=$rows['contact_cnic']?></td>
<!--                <td><?php echo $name ?></td>-->
                <td align="center"><button type="button" name="see" class="btn-sm view_data" style="border-radius: 15px; color: black; background-color: #337ab7c9; width: 83px; height: 45px; border: none;"  id="<?=$rows['said']?>" >See Details</button></td>
                  
                  
                <td align="center">
                    
                    <a data-fancybox="gallery" title="Candidate Image" href="../<?php echo $rows['image']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <a data-fancybox="gallery" class="primary-btn" title="Candidate CNIC" href="../<?php echo $rows['cnic']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php if($rows['recipt'] != 'NULL'){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Challan Form" href="../<?php echo $rows['recipt']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                    <?php if($rows['domicile'] != 'NULL'){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Domicile" href="../<?php echo $rows['domicile']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>

                    <?php if($rows['last_degree'] != 'NULL'){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Last Degree" href="../<?php echo $rows['last_degree']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                  <?php } ?>

                    <?php if($rows['professional_degree'] != 'NULL'){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Professional Degree" href="../<?php echo $rows['professional_degree']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                    <?php if($rows['driving_license'] != "NULL"){ ?>
                    <a data-fancybox="gallery" class="primary-btn" title="Driving Liscence" href="../<?php echo $rows['driving_license']?>">
                        <i class='fa fa-image' style="font-size:22px;"></i>
                    </a>
                    <?php } ?>
                </td>

                <?php
                
                $sql2 = "SELECT details.d_status , details.d_rollno FROM `details` WHERE d_said = '$rows[said]' AND d_postid = '$pid' ";
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
                      ?>
                      <input type="hidden" name="p_name" value="<?php echo $data['name'];?>" />
                      <input type="hidden" name="p_gender" value="<?php echo $data['gender'];?>" />
                      <input type="hidden" name="p_city" value="<?php echo $rows['city_prefer'];?>" />
                      <input type="hidden" name="pending" value="pending" />
                      <input type="hidden" name="id" value="<?php echo $rows['said'];?>" />
                      <textarea class="hidden" name="feedback" required>
                          <?php echo $rows['feedback']?>Your application has been approved for the post of <?php echo $name; ?>
                      </textarea>
                      <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
                      <button type="submit" style="border:none; background: none;" name="submit1"><i class="fa fa-check" style="font-size:22px; color: green;"></i></button>
                        </form>
                        </div>
                        <div class="span6">
                            <form class="form-group" action="rejectedapp.php" method="POST" onsubmit="">
                        
                        <input type="hidden" name="pending" value="pending" />
                                <input type="hidden" name="id" value="<?php echo $rows['said'];?>" />
                                <textarea class="hidden" name="feedback" required><?php echo $rows['feedback']?>Your application for the post of <?php echo $name; ?> has been rejected. </textarea>
                                <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
                    <button type="button" style="border:none; background: none;" name="submit1" data-toggle="modal" data-target="#exampleModal<?php echo $rows['said']; ?>"><i class="fa fa-close view_form" style="font-size:22px; color: red;"></i></button>
                        
                      <div class="modal fade" id="exampleModal<?php echo $rows['said']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form>
                              <div class="form-group">
                                <label for="message-text" class="col-form-label">Reason For Rejection:</label>
                                <textarea class="form-control" id="message-text" name="message"></textarea>
                              </div>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="modalsubmit" class="btn btn-primary">Submit</button>
                          </div>
                        </div>
                      </div>
                    </div>
                        
                            </form>
                        </div>
                        <div class="span6">
                        
                  <form class="form-group" action="held.php" method="POST" onsubmit="return confirm('Are you sure you want to Held?');">
                      <input type="hidden" name="pending" value="pending" />
                      <input type="hidden" name="id" value="<?php echo $rows['said'];?>" />
                      <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
                      <button type="submit" style="border:none; background: none;" name="submit1"><i class="fa fa-question" style="font-size:22px; color: blue;"></i></button>
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
                    
              </tbody>

<?php
}?></table>
</div>

<?php 
}

?>
<script>
   $(document).ready(function(){
    $('.view_data').click(function(){
      $('#dataModal').modal("show");
      var employee_id = $(this).attr("id");

      $.ajax({
        url:"modalPending.php",
        method:"post",
        data:{employee_id:employee_id},
        success:function(data){
          $('#employee_detail').html(data);
          $('#dataModal').modal("show");
        }
      });
    });
  });
</script>


<!-- --------------------------------modal----------------------------------- -->
<div id="dataModal" class="modal fade" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

                  <button type="button" class="close"  data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Applicant Details</h4>
          
        </div>
        <div class="modal-body" id="employee_detail">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>  
    
<!-- --------------------------------modal----------------------------------- -->
    
    <div class="row">
    <div class="col-lg-10" style="align:left;">
    </div>
        <div class="col-lg-2">
            <form action="exportpending.php" method="post">
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
}

else{
  header("Location: index.php");
}

?>