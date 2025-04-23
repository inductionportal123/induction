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
    
    
    
    	if ($user=='super-admin')
   		{
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />

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
            <li class="active" ><a href="centerallot.php"><em class="fa fa-university">&nbsp;</em> Center Allotment</a></li>
            <li class="parent ">
                <a data-toggle="collapse" href="#sub-item-6">
                <em class="fa fa-navicon">&nbsp;</em> Test/Interview Scheduling<span data-toggle="collapse" href="#sub-item-6" class="icon pull-right"><em class="fa fa-plus"></em></span>
                </a>
                <ul class="children collapse" id="sub-item-6">
                    <li><a href="schedule.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Test Schedule</a></li>
                    <li><a href="interviewslots.php"><em class="fa fa-calendar-check-o">&nbsp;</em> Interview Schedule</a></li>
                </ul>
            </li>
            <li><a href="importresult.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Selected Candidates</a></li>
            <li><a href="import_result.php"><i class="fa fa-list-alt" aria-hidden="true"></i> Results</a></li>
            <li><a href="createusers.php"><i class="fa fa-user-circle" aria-hidden="true"></i> Manage Users</a></li>
            <li><a href="passwordchange.php"><i class="fa fa-key" aria-hidden="true"></i>
 Change Password</a></li>
            <li><a href="query.php"><em class="fa fa-question-circle">&nbsp;</em> Queries</a></li>
            <li><a href="message.php"><em class="fa fa-question-circle">&nbsp;</em> Announcements</a></li>
            <li><a href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
        </ul>
    </div><!--/.sidebar-->
   
   
   
   
<div  class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-4 main" >
    <div class="row">
        <div class="col-lg-12" align="center">
            <h2 style="color: green;"><b>Center Allotment</b></h2>
           <h2 style="color: green;">Preferred City Wise</h2>
  
        </div>
    </div>
    
    <div class="row" style="margin:16px;text-align:center;">
        <a href="centerallot1.php"><button class="btn btn-primary btn-lg text-bold" style="padding:12px;">Preferred City I</button></a>
        <a href="centerallot2.php"><button class="btn btn-primary btn-lg text-bold" style="padding:12px;">Preferred City II</button></a>
        
        
    <script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/custom.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>

    </body>
</html>
<?php

}
else{
   echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access of this page</div>';

}

}
else
{
    header("Location: index.php");
}
?>
