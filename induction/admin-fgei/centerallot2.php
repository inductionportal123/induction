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
            <p style="font-size:18px;">Preferred City Two (II)</p>
        </div>
    </div>
    
    <div class="row" style="margin-bottom:12px;">
        <form method ="POST" style="margin:8px;" action="">
            <div class="col-md-6" style="margin-top:18px;margin-bottom:18px;">
                <select class="form-control" name="city" id="city" required>
                    <option>Select City</option>
                    <?php
    $newquery = "SELECT DISTINCT(`district`) FROM `centes`";
    $newdatas = mysqli_query($conn,$newquery);
    $newrowct = mysqli_num_rows($newdatas);
    if($newrowct>0)
    {
        while ($newrowss = mysqli_fetch_array($newdatas))
        {
                    ?>
                    <option 
                            <?php
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if ($_POST['city'] == $newrowss['district'])
                {
                            ?>
                            selected="true"
                            <?php
                };
            } ?>
                            >
                        <?php echo $newrowss['district']; ?>
                    </option>
                    <?php
        }
    }
                    ?>
                </select>
            </div>
            <div class="col-md-3" style="margin-bottom:18px;">
                <input type="submit" name="submit" value="Search" class="btn btn-info btn-block" style="margin-top:18px;margin-bottom:8px;"/>
            </div>
        </form>
    </div>
    
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_POST['city']))
    {
        $district_name = $_POST['city'];
        $newquery = "SELECT * FROM `centes` WHERE `district` LIKE '%$district_name%' ";
	    $newdatas = mysqli_query($conn,$newquery);
	    $newrowct = mysqli_num_rows($newdatas);
		if($newrowct>0)
        {
    ?>
    <table class="table table-hover table-bordered">
        <thead>
            <th>S.No.</th>
            <th>Center</th>
            <th>Assign</th>
        </thead>
        <tbody>
            <?php
            $count=0;
            $cityidq = "SELECT id FROM `district` WHERE `name` = '$district_name' ";
            $cityidd = mysqli_query($conn,$cityidq);
            $cityidx = mysqli_fetch_array($cityidd);
            $cityidx[0];
            while ($newrowss = mysqli_fetch_array($newdatas))
            {
                $count++;
            ?>
            
            <div class="row">
                <div class="col-md-10">
                    <td><?php echo $count;?></td>
             		<td><?php echo $newrowss['center'];?></td>
                </div>
                <td>
                    <div class="col-md-2">
                        <form method="POST">
                            <input type="hidden" type="text" name="city" value="<?php echo $district_name; ?>" /><input type="hidden" type="text" name="cityidx" value="<?php echo $cityidx[0]; ?>" /><button type="submit" class="btn btn-info" name="assign" id="assign" data-target="#demo<?php echo $newrowss['id'];?>" value="<?php echo $newrowss['id']; ?>">
                            Assign Center
                            </button>
                        </form>
                    </div>
                </td>
            </div>
        </tbody>
        <?php
            }
        ?>
    </table>
    <?php
            if(isset($_POST['assign']))
            {
                $id = $_POST['assign'];
                $id2 = $_POST['cityidx'];
                $newquery1 = "SELECT * FROM `centes` WHERE `id` ='$id' ";
                $newdatas1 = mysqli_query($conn,$newquery1);
                $newrowss1 = mysqli_fetch_array($newdatas1);
    ?>
    
    <script type="text/javascript"></script>
    
    <form method="post">
        <div id="demo<?php echo $newrowss['id'];?>">
            <div class="row">
                <div class="col-md-6 text-center">
                    <label>Center Name</label>
                </div>
                <div class="col-md-3 text-center">
                    <label>Available Seats</label>
                </div>
                <div class="col-md-3 text-center">
                    <label>Reserved</label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="center_name" id="center_name" value="<?php echo $newrowss1['center'];?>" readonly />
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="available_seats" id="available_seats" value="<?php echo $newrowss1['seat'];?>"   readonly />
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control" name="reserved" id="reserved" readonly />
                </div>
                <div class="col-md-3">
                    <input type="hidden" class="form-control" name="centerid" id="centerid" value="<?php echo $newrowss1['id'];?>"   readonly  />
                </div>
            </div>
            
            <br><br>
            
            <div class="row">
                
                <div class="col-lg-2" style="margin-left: 35%;">
                    <label class="" style="text-align:left;">Assign Value</label>
                </div>
                <div class="col-lg-2">
                    <label class="" style="text-align:left;">Total Assigned</label>
                </div>
                <div class="col-lg-2"style="margin-right:2%;">
                    <label class="" style="text-align:left;">Total Applied</label>
                </div>
            </div>
            
            <script type="text/javascript">
                function findTotal()
                {
                    var postx = 0;
                    var arr = document.getElementsByClassName('amount');
                    var arr2 = document.getElementsByClassName('amount2');
                    var arr3 = document.getElementsByClassName('amount3');
                    var arr4 = [];
                    var arr5 = [];
                    var tot=0;
                    for(var i=0;i<arr2.length;i++)
                    {
                        arr4[i] = parseInt(arr2[i].value) - parseInt(arr3[i].value);
                        if(parseInt(arr[i].value) > parseInt(arr4[i]))
                        {
                            window.alert("Number of posts exceeded");
                            document.getElementById("centersubmit").disabled = true;
                            postx=1;
                        }
                        arr5[i] = parseInt(arr[i].value);
                        if(isNaN(parseInt(arr[i].value)))
                        {
                            arr5[i] = parseInt(arr[i].value);
                            arr5[i] = 0;
                        }
                        tot += parseInt(arr3[i].value);
                        tot += parseInt(arr5[i]);
                    }
                    arr = 0;
                    arr5 = 0;
                    document.getElementById('reserved').value = tot;
                    var totall= "<?php echo $newrowss1['seat'] ?>" ;
                    if(tot > totall || postx == 1)
                    {
                        window.alert("Number of posts exceeded");
                        document.getElementById("centersubmit").disabled = true;
                        document.getElementById("reserved").style.backgroundColor =  "red";
                        document.getElementById("reserved").style.color =  "white";
                        return false;
                    }
                    else
                    {
                        document.getElementById("centersubmit").disabled = false;
                        document.getElementById("reserved").style.backgroundColor =  "#54d654";
                        document.getElementById("reserved").style.color =  "white";
                        return true;
                    }
                }
            </script>
            
            <?php
        $postsq = "SELECT * FROM `posts` ";
                $postsd = mysqli_query($conn,$postsq);
                $postsr = mysqli_num_rows($postsd);
                $counter=0;
                if ($postsr>0)
                    $total_post = array();
                while ($posts = mysqli_fetch_array($postsd))
                {
                    $posts1 = $posts['pid'];
                    $total_post[] = $posts1;
                    $posttotalc = count($total_post);
                    $total = $total_post;
            ?>
            <input type="hidden" type=" text" name="total_post" value="<?php echo $posttotalc; ?>" />
            <input type="hidden" type="text" name="p1<?php echo $counter; ?>" value="<?php echo $posts1; ?>" />
            <?php
                    $postscount2q = "SELECT COUNT(d_centerid) FROM `details` JOIN post_apply ON (city_prefer_two= '$id2') AND d_said = said WHERE  d_centerid IS NOT NULL AND d_postid = '$posts1' AND d_status ='Approved'";
                    $postscount2d = mysqli_query($conn,$postscount2q);
                    $postscount2r = mysqli_num_rows($postscount2d);
                    $postscount2 = mysqli_fetch_array($postscount2d);
            ?>
            
            <div class="row" style="">
                <div class="col-lg-4 ">
                    <label class="" style="text-align:left;"><?php echo $posts['name']; echo' - '. ucfirst($posts['gender']) ;?></label>
                </div>
                <div class="col-lg-2">
                    <input type="number" min="0" class="form-control amount" onblur="findTotal()" name="postfinal<?php echo $counter; ?>" value="0" placeholder="0" align="left"/>
                </div>
                <div class="col-lg-2">
                    <input type="text" class="form-control amount3"name="postfinal2<?php echo $counter; ?>" value="<?php echo $postscount2[0];?>" align="left" readonly/>
                </div>
                <div class="col-lg-2">
                    <?php
                    $postscountq = "SELECT COUNT(d_postid) FROM `details` JOIN post_apply ON (city_prefer_two= '$id2') AND d_said = said WHERE d_postid = '$posts1' AND d_status ='Approved'";
                    $postscountd = mysqli_query($conn,$postscountq);
                    $postscountr = mysqli_num_rows($postscountd);
                    $postscount = mysqli_fetch_array($postscountd);
                    ?>
                    <input type="text" class="form-control amount2" name="postcount" id="postcount" value="<?php echo $postscount[0];?>"   readonly />
                </div>
            </div>
            <?php $counter=$counter+1;
                }
            ?>
            <br>
            <input type="hidden" type="text" name="cityidx1" value="<?php echo $id2; ?>" />
            <input type="hidden" type="text" name="city" value="<?php echo $district_name; ?>" />
            <div class="col-lg-9" float="right">
                <input type="submit" name="centersubmit" id="centersubmit" class="btn btn-primary"/>
            </div>
        </div>
    </form>
    </div>
    <?php
            }
        }
    }
    ?>
    <br>
    <br>
    <?php
    if(isset($_POST['centersubmit']))
    {
        $id = $_POST['centerid'];
        $id3 = $_POST['cityidx1'];
        $posttotalc = $_POST['total_post'];
        $post1=array();
        $post2=array();
        $countp=0;
        while ($countp <= $posttotalc)
        {
            $post1[$countp] = $_POST['postfinal'.$countp];
            $post2[$countp] = $_POST['p1'.$countp];
            $countp=$countp+1;
        }
        for($i=0; $i<=$posttotalc; $i++)
        {
            $postdyn = $post1[$i];
            $query1 = "UPDATE `details` JOIN post_apply ON city_prefer_two= '$id3' AND d_said = said SET `d_centerid`='$id' WHERE d_postid='$post2[$i]' AND d_centerid IS NULL AND d_status='Approved' LIMIT $postdyn";
            $exe = mysqli_query($conn,$query1);
            if ($conn->query($exe) === TRUE) {
                echo "Database created successfully";
                } 
        }
         //---------------------------------------------------------
            
       //     require 'PHPMailer/PHPMailerAutoload.php';
       //     $mail = new PHPMailer;

       //     $mail->isSMTP();
       //     $mail->Host = 'smtp.gmail.com';
       //     $mail->SMTPAuth = true;
      //      $mail->Username = 'saadmalik031996@gmail.com';
       //     $mail->Password = 'Saadi031996';
      //      $mail->SMTPSecure = 'tls';
      //      $mail->Port = 587;

      //      $mail->From = 'saadmalik031996@gmail.com';
      //      $mail->FromName = 'Saad Ullah Qamar';
            
            

            $sql = "SELECT per_info.contact_email, per_info.said FROM per_info WHERE per_info.said IN (SELECT details.d_said FROM details WHERE d_centerid IS NOT NULL AND details.d_rollno IS NOT NULL AND details.d_status IS NOT NULL AND details.email_check = 0)";
            $exe = mysqli_query($conn, $sql);
            while ($data = mysqli_fetch_array($exe))
            {
                $email = $data['contact_email'];
                $said = $data['said'];
          //      $mail->addBCC($email);
                $sqlupdate = "UPDATE `details` SET `email_check`='1' WHERE details.d_said='$said' AND details.d_status = 'Approved' AND details.d_centerid IS NOT NULL";
                $upexe = mysqli_query($conn, $sqlupdate);
            }
       //     $mail->addReplyTo('saadmalik031996@gmail.com');
       //     $mail->WordWrap = 50;
       ////     $mail->isHTML(true);
        //    $mail->Subject = 'Roll Number Slip Issued';
       //     $mail->Body    = 'Dear Candidate, Your roll number slip is issued please login to portal and download your roll number slip from there. Thankyou';
      //      if(!$mail->send())
      //      {
      //          echo 'Message could not be sent.';
      //          echo 'Mailer Error: ' . $mail->ErrorInfo;
       //         exit;
       //     }
            
            //-----------------------------------------------
    }
    ?>
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
else
{
    header("Location: index.php");
}
?>
