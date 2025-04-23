<?php
ob_start();
//include('../connection/conn.php');
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
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
<?php


if (isset($_POST["import"])) {
    
    //$del = "DELETE FROM selected_rollno";
    //$exedel = mysqli_query($conn, $del);
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        $count=1;
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $userId = "";
            if (isset($column[0])) {
                $userrollno = mysqli_real_escape_string($conn, $column[0]);
            }
           // if($count == 1){
           //     $userrollno =  substr($userrollno,3);
           // }
            $count++;
            $sqlInsert = "INSERT into selected_rollno (sel_rollno)
                   values (?)";
            $paramType = "s";
            $paramArray = array(
                $userrollno,
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
            
            if (! empty($insertId)) {
                $type = "success";
                $message = "Result is successfully Uploaded";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
<script src="jquery-3.2.1.min.js"></script>
<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin - Upload Result</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<style>

.outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 20px;
    border-radius: 2px;
}



.btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
}





.outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    text-align: right;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display: none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
</script>
</head>

<body>
    
    <?php include('header.php');  ?>

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
				<em class="fa fa-navicon">&nbsp;</em> General Settings <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-1">
                    <li class="active"><a href="admissiondate.php"><em class="fa fa-book">&nbsp;</em> Induction Settings</a></li>
					<li><a href="region.php"><em class="fa fa-globe">&nbsp;</em> Region Setting</a></li>
                    <li><a href="region_setting.php"><em class="fa fa-globe">&nbsp;</em> Region Details</a></li>
                    <li><a href="district.php"><em class="fa fa-map-marker">&nbsp;</em> District Setting</a></li>   <li><a href="bankfee.php"><em class="fa fa-credit-card">&nbsp;</em> Bank Charges</a></li>
                    <li><a href="centers.php"><em class="fa fa-university">&nbsp;</em> Centers</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-navicon">&nbsp;</em> Post Settings <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-2">
                    <li><a href="createpost.php"><em class="fa fa-laptop">&nbsp;</em> Posts</a></li>
                    <li><a href="category.php"><em class="fa fa-laptop">&nbsp;</em> Post Details</a></li>
					<li><a href="feeslot.php"><em class="fa fa-money">&nbsp;</em> Fee Slots</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-3">
				<em class="fa fa-navicon">&nbsp;</em> Quota Settings <span data-toggle="collapse" href="#sub-item-3" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-3">
                    <li><a class="" href="nonteachingquota.php"><span class="fa fa-arrow-right">&nbsp;</span> Teaching/Non Teaching Staff</a></li>
					<li><a class="" href="lowerstaffquota.php"><span class="fa fa-arrow-right">&nbsp;</span> Lower Staff</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-4">
				<em class="fa fa-navicon">&nbsp;</em> Applications <span data-toggle="collapse" href="#sub-item-4" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-4">
					<li><a class="" href="allapplication.php">
						<span class="fa fa-arrow-right">&nbsp;</span> All Applications
					</a></li>
					<li><a class="" href="approvedemp.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Approved Applications
					</a></li>
					<li><a class="" href="rejected.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Rejected Applications
					</a></li>
                    <li><a class="" href="pending.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Pending Applications
					</a></li>
				</ul>
			</li>
            <li class="parent ">
                <a  data-toggle="collapse" href="#sub-item-5">
				<em class="fa fa-navicon">&nbsp;</em> Reports <span data-toggle="collapse" href="#sub-item-5" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-5">
					<li><a href="summaryreport.php"><em class="fa fa-list-ol">&nbsp;</em> Report</a></li>
                    <li><a href="center_report.php"><em class="fa fa-list-ol">&nbsp;</em> Center Report</a></li>
				</ul>
			</li>
            <li><a href="centerallot.php"><em class="fa fa-university">&nbsp;</em> Center Allotment</a></li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-6">
				<em class="fa fa-navicon">&nbsp;</em> Test/Interview Scheduling<span data-toggle="collapse" href="#sub-item-6" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children collapse" id="sub-item-6">
                    <li><a href="schedule.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Test Schedule</a></li>
                    <li><a href="interviewslots.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Interview Schedule</a></li>
				</ul>
			</li>
            <li class="active" ><a href="importresult.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Selected Candidates</a></li>
            <li><a href="import_result.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Results</a></li>
            <li><a href="createusers.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Manage Users</a></li>
            <li><a href="passwordchange.php"><i class="fa fa-key" aria-hidden="true"></i>
 Change Password</a></li>
            <li><a href="query.php"><em class="fa fa-question-circle">&nbsp;</em> Queries</a></li>
            <li><a href="message.php"><em class="fa fa-question-circle">&nbsp;</em> Announcements</a></li>
            <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
<!-------------------------------------------  BODY  ------------------------------------------------------>
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-12" align="center">
                <h3 style="color: green;margin-bottom: 20px;">Import List of Roll Numbers For Call Letters</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5" align="right">
                <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
                <?php if(!empty($message)) { echo $message; } ?>
                </div>
            </div>
        </div>
        <div class="row" style="margin-left:10%">
                <form class="form-horizontal" action="" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                        <div class="col-lg-7" float="right">
                            <label>Upload your result in '.csv' format.</label>
                        <input class="form-control" type="file" name="file" id="file" accept=".csv" required>
                    </div>
                    <div class="col-lg-5" float="right" style="margin-top:30px">
                        <button type="submit" class="btn btn-primary" name="import" class="btn-submit">Upload</button>
                        </div>
                </form>
        </div>
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
        $total_pages_sql = "SELECT count(*) FROM `selected_rollno` where slotid is NULL";
        $result = mysqli_query($conn,$total_pages_sql);
        $total_rows = mysqli_fetch_array($result)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);
        $from = $offset+1;
        $to = $offset+$no_of_records_per_page;
        $counter = $from-1;
        ?>
        
      
<!--            Pagination ends-->
        <div class="row" style="margin-left:10%">
            <div class="col-lg-12" style="">
                <?php
                    $getroll = "SELECT * FROM `selected_rollno` where slotid is NULL LIMIT $offset, $no_of_records_per_page";
                    $exeget = mysqli_query($conn, $getroll);
                    $rollrows = mysqli_num_rows($exeget);
                    if($rollrows > 0)
                    {
                        ?>
                        <div class="col-lg-10" style="float:right">
                            <h5>Total Pending = <?php echo $total_rows; ?></h5>
                        </div>
                        <table class="table table-bordered table-hover" style="margin-top:10px">
                            <tr>
                                <th style="text-align:center">Roll Number</th>
                                <th style="text-align:center">Choose Slot</th>
                                <th style="text-align:center">Action</th>
                            </tr>
                        <?php
                        while($rolldata = mysqli_fetch_array($exeget))
                        {
                            $counter=$counter+1;
                            ?>
                            <form action="genslip.php" method="post" class="form">
                            <tr style="text-align:center">
                                <input type="hidden" name="rollno" value="<?php echo $rolldata['sel_rollno']; ?>" >
                                <td><?php echo $rolldata['sel_rollno']; ?></td>
                                <td>
                                <select class="form-control" name="slotid" required>
                                <option selected disabled value="">Choose Slot</option>
                                <?php
                                    $slot="SELECT * FROM `interview_slots`";
                                    $exeslot= mysqli_query($conn, $slot);
                                    $rowslot= mysqli_num_rows($exeslot);
                                    echo $rowslot;
                                    if($rowslot > 0)
                                    {
                                        while($dataslot = mysqli_fetch_array($exeslot))
                                        {
                                            ?>
                                           <option 
                                                   <?php
                                                        if(isset($rolldata['slotid']))
                                            { if($dataslot['id'] == $rolldata['slotid']){?>
                                            selected       
                                            <?php
                                            }}
                                            ?>
                                                   value="<?php echo $dataslot['id'] ?>" 
                                                    >
                                               <?php echo $dataslot['slot_name'];  ?></option>
                                            <?php
                                        }
                                    }
                                ?>
                                </select>
                                </td>
                                <td>
                                    <button type="submit" name="generate" class="btn btn-success" <?php 
                                            if(isset($rolldata['slotid']))
                                            {?>
                                            disabled 
                                            <?php
                                            } ?>>
                                        Generate Slip
                                    </button></td>
                            </tr>
                            </form>
                            <?php        
                        }
                        ?>
                </table>
                        <?php
                    }
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-10" style="float:right"><b>
                <?php
                    $from = $offset+1;
                    $to = $offset+$no_of_records_per_page;
                    echo $from.' - '.$counter.' of '.$total_rows ;
                ?>
                </b></div>
        </div>
        <div class="row">
    <div class="col-lg-10" style="float:right">
        <ul class="pagination">
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
            </li>
            <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
            </li>
        </ul>
    </div>
    </div>
    </div>
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, 'importresult.php' );
    }
</script>
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