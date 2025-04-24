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
	<title>Admin - Inductions</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
<?php include('header.php');  
    if($userid == "Editor")
{   ?>
        <div id="sidebar-collapse" class="col-sm-3 col-lg-3 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="image/logo.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo strtoupper($user) ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-4">
				<em class="fa fa-navicon"> </em> Applications <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-4">
					<li><a class="" href="allapplication.php">
						<span class="fa fa-arrow-right"> </span> All Applications
					</a></li>
					<li><a class="" href="approvedemp.php">
						<span class="fa fa-arrow-right"> </span> Approved Applications
					</a></li>
					<li><a class="" href="rejected.php">
						<span class="fa fa-arrow-right"> </span> Rejected Applications
					</a></li>
                    <li><a class="" href="pending.php">
						<span class="fa fa-arrow-right"> </span> Pending Applications
					</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a  data-toggle="collapse" href="#sub-item-5">
				<em class="fa fa-navicon"> </em> Reports <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-5">
					<li><a href="summaryreport.php"><em class="fa fa-list-ol"> </em> Report</a></li>
                    <li><a href="center_report.php"><em class="fa fa-list-ol"> </em> Center Report</a></li>
				</ul>
			</li>
            
            <li><a href="passwordchange.php"><i class="fa fa-key" aria-hidden="true"></i>
 Change Password</a></li>
            <li class="active" ><a href="query.php"><em class="fa fa-question-circle"> </em> Queries</a></li>
            <li><a href="logout.php"><em class="fa fa-power-off"> </em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
<?php
    
    }
    else{
    ?>
   <div id="sidebar-collapse" class="col-sm-3 col-lg-3 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="image/logo.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo strtoupper($user) ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-navicon"> </em> General Settings <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
                    <li class="active"><a href="admissiondate.php"><em class="fa fa-book"> </em> Induction Settings</a></li>
					<li><a href="region.php"><em class="fa fa-globe"> </em> Region Setting</a></li>
                    <li><a href="region_setting.php"><em class="fa fa-globe"> </em> Region Details</a></li>
                    <li><a href="district.php"><em class="fa fa-map-marker"> </em> District Setting</a></li>   <li><a href="bankfee.php"><em class="fa fa-credit-card"> </em> Bank Charges</a></li>
                    <li><a href="centers.php"><em class="fa fa-university"> </em> Centers</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-navicon"> </em> Post Settings <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-2">
                    <li><a href="createpost.php"><em class="fa fa-laptop"> </em> Posts</a></li>
                    <li><a href="category.php"><em class="fa fa-laptop"> </em> Post Details</a></li>
					<li><a href="feeslot.php"><em class="fa fa-money"> </em> Fee Slots</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-3">
				<em class="fa fa-navicon"> </em> Quota Settings <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-3">
                    <li><a class="" href="nonteachingquota.php"><span class="fa fa-arrow-right"> </span> Teaching/Non Teaching Staff</a></li>
					<li><a class="" href="lowerstaffquota.php"><span class="fa fa-arrow-right"> </span> Lower Staff</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-4">
				<em class="fa fa-navicon"> </em> Applications <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-4">
					<li><a class="" href="allapplication.php">
						<span class="fa fa-arrow-right"> </span> All Applications
					</a></li>
					<li><a class="" href="approvedemp.php">
						<span class="fa fa-arrow-right"> </span> Approved Applications
					</a></li>
					<li><a class="" href="rejected.php">
						<span class="fa fa-arrow-right"> </span> Rejected Applications
					</a></li>
                    <li><a class="" href="pending.php">
						<span class="fa fa-arrow-right"> </span> Pending Applications
					</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a  data-toggle="collapse" href="#sub-item-5">
				<em class="fa fa-navicon"> </em> Reports <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-5">
					<li><a href="summaryreport.php"><em class="fa fa-list-ol"> </em> Report</a></li>
                    <li><a href="center_report.php"><em class="fa fa-list-ol"> </em> Center Report</a></li>
				</ul>
			</li>
            <li><a href="centerallot.php"><em class="fa fa-university"> </em> Center Allotment</a></li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-6">
				<em class="fa fa-navicon"> </em> Test/Interview Scheduling<span data-toggle="collapse" href="#sub-item-6" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-6">
                    <li><a href="schedule.php"><em class="fa fa-calendar-check-o"> </em> Test Schedule</a></li>
                    <li><a href="interviewslots.php"><em class="fa fa-calendar-check-o"> </em> Interview Schedule</a></li>
				</ul>
			</li>
            <li><a href="importresult.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Selected Candidates</a></li>
            <li><a href="import_result.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Results</a></li>
            <li><a href="createusers.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Manage Users</a></li>
            <li><a href="passwordchange.php"><i class="fa fa-key" aria-hidden="true"></i>
 Change Password</a></li>
            <li class="active" ><a href="query.php"><em class="fa fa-question-circle"> </em> Queries</a></li>
            <li><a href="message.php"><em class="fa fa-question-circle"> </em> Announcements</a></li>
            <li><a href="logout.php"><em class="fa fa-power-off"> </em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
    <?php
    }
    ?>
    
<div class="col-sm-9 col-sm-offset-3 col-lg-8 col-lg-offset-4 main">
    <div class="row">
        <div class="col-lg-10" align="center">
            <h3 style="color: green;margin-bottom: 20px;">Queries</h3>
        </div>
    </div>
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
    $total_pages_sql = "SELECT acount_details.cnic, acount_details.email , query.query,query.picture , query.q_time , query.ans , query.f_time FROM `acount_details`,`query`  WHERE query.said=acount_details.id AND query.ans IS NULL";
    $result = mysqli_query($conn,$total_pages_sql);
    $total_rows = mysqli_num_rows($result);
    $total_pages = ceil($total_rows / $no_of_records_per_page); 
    $from = $offset+1;
    $to = $offset+$no_of_records_per_page;
    $counter = $from-1;
    $query2 = "SELECT acount_details.email,acount_details.cnic , query.query,query.picture , query.q_time , query.ans , query.f_time , query.id FROM `acount_details`,`query`  WHERE query.said=acount_details.id AND query.ans IS NULL ORDER BY `query`.`id`  DESC LIMIT $offset, $no_of_records_per_page  ";
    $exe2 = mysqli_query($conn,$query2);
    if (!$exe2){
        echo die(mysqli_error($conn));
    }
    else{
        $rowcount2 = mysqli_num_rows($exe2);
        if ($rowcount2 > 0)
        {
    ?>
    <div class="row">
        <div class="col-lg-10">
            <table class="table table-bordered" width="100%">
                <tr>
                    <th style="text-align: center;">Sr#</th>
                    <th style="text-align: center;">User</th>
                    <th style="text-align: center;">CNIC</th>
                    <th style="text-align: center;">Query</th>
                    <th style="text-align: center;">File</th>
                    <th style="text-align: center;">Feedback</th>
                    <th style="text-align: center;">Action</th>
                </tr>
                <?php
            while($rows = mysqli_fetch_array($exe2))
            {
                $counter=$counter+1;
                ?>
                <tr>
                    <td style="text-align: center;"><?php echo $counter ?></td>
                    <td style="text-align: center;"><?= $rows['email'] ?></td>
                    <td style="text-align: center;"><?= $rows['cnic'] ?></td>
                    <td style="text-align: center;"><?= strtoupper($rows['query'].'<br>('.$rows['q_time'].')') ?></td>
                    <td>
    <?php
        // Check if a picture is available
        if (!empty($rows['picture'])) {
            ?>
            <a href="<?php echo '../'. $rows['picture'] ?>" target="_blank">
            <img src="<?php echo '../'. $rows['picture'] ?>" style="max-width: 100px; max-height: 100px;">
        </a><br>     
    <?php   }
        ?>
</td>
                    <td style="text-align: center;">
                    <?php 
                        if($rows['ans'] == NULL)
                        { 
                            echo 'Yet not available';
                        }
                        else
                        {
                            echo strtoupper($rows['ans'].'<br>('.$rows['f_time'].')');
                        } 
                    ?>
                    </td>
                    <td style="text-align: center;"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalLong<?php echo $rows['id'];?>">Reply</button></td>
            
            <!-- Modal -->
            <div class="modal fade" id="exampleModalLong<?php echo $rows['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Replying to Query</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-group" action="" method="post" enctype="multipart/form-data">
                                <input class="form-control" type="hidden" name="id" value="<?php echo $rows['id'];?>" />
                                <textarea class="form-control" name="feedback" required><?php echo $rows['ans']?></textarea>
                                <br>
                                <input type="file" name="AdminPicture" style="margin-top: 10px; padding: 10px; border-radius: 8px; border: 1px solid #ccc; width: 100%; box-sizing: border-box;">
                                <button style="float-right" type="submit" name="submit" class="btn btn-primary">Send Reply</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </tr>
        <?php
          }
          ?>
        
        <form class="form" action="exportquery.php" method="post">
            <input class="btn btn-success" value="Export To Excel" name="Submit" type="submit">
        </form>
        
        <?php
      }
      // Form submission logic moved outside the loop
      if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
          date_default_timezone_set("Asia/Karachi");
          $time = date("Y-m-d h:i:sa");
          $id = $_POST['id'];
          $feedback = $_POST['feedback'];

          // Define upload directory and ensure it exists
          $uploads_directory = "../Uploads/";
          if (!is_dir($uploads_directory)) {
              mkdir($uploads_directory, 0755, true);
          }

          // Handle file upload
          $picture_path = "NULL";
          if (isset($_FILES['AdminPicture']) && $_FILES['AdminPicture']['error'] === UPLOAD_ERR_OK) {
              $picture = $_FILES['AdminPicture']['name'];
              $temp_file = $_FILES['AdminPicture']['tmp_name'];
              $upload_path = $uploads_directory . basename($picture);

              // Validate file type and size
              $allowed_types = ['image/jpeg', 'image/png', 'application/pdf'];
              $max_size = 5 * 1024 * 1024; // 5MB
              $file_type = mime_content_type($temp_file);
              $file_size = $_FILES['AdminPicture']['size'];

              if (in_array($file_type, $allowed_types) && $file_size <= $max_size) {
                  if (move_uploaded_file($temp_file, $upload_path)) {
                      $picture_path = $upload_path;
                  } else {
                      echo "<script>alert('Error: Failed to move uploaded file. Check directory permissions.');</script>";
                  }
              } else {
                  echo "<script>alert('Error: Invalid file type or size. Allowed types: JPEG, PNG, PDF. Max size: 5MB.');</script>";
              }
          }

          // Update database
          $sql = "UPDATE query SET ans=?, ansPicture=?, f_time=? WHERE id=?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("sssi", $feedback, $picture_path, $time, $id);

          if ($stmt->execute()) {
              if (isset($pageno)) {
                  header('location: querypending.php?pageno=' . $pageno);
              } else {
                  header('location: querypending.php');
              }
              exit();
          } else {
              echo "<script>alert('Error updating database: " . addslashes($conn->error) . "');</script>";
          }
          $stmt->close();
      }
      ?>
    </table>
            <?php
     $pagLink='';
                for ($i=1; $i<=$total_pages; $i++)
                {  
                    $pagLink .= "<a class='page-link' href='?pageno=".$i."'> ".$i." </a>";  
                };
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
            <div class="col-lg-10" style="align:left;">
                <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item"><a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".(1); } ?>">First</a></li>
                <li class="page-item"><a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a></li>
                <li class="page-item"><?php echo $pagLink; ?></li>
                <li class="page-item"><a class="page-link " href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>" >Next</a></li>
                <li class="page-item"><a class="page-link " href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($total_pages); } ?>" >Last</a></li>
            </ul>
        </nav>
    </div>
        </div>
    </div>
    
    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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