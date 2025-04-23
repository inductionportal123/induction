<?php
include('connection/conn.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['u_name'], $_SESSION['u_id']))
{
  $user = $_SESSION['u_name'];
  $userid = $_SESSION['u_id'];



		$query = "SELECT per_info.rollno, per_info.basic_full_name, per_info.contact_cnic, per_info.basic_dob, per_info.basic_gender, per_info.said, per_info.contact_mobile, per_info.contact_email, per_info.contact_postal_address, post_apply.post_apply, emp_document.image, per_info.undertaking FROM per_info
INNER JOIN emp_document ON per_info.said=emp_document.said 
INNER JOIN post_apply ON per_info.said=post_apply.said where per_info.said = $userid"
;
		$exe = mysqli_query($conn,$query);
		$rows = mysqli_fetch_array($exe);
		$rowcount = mysqli_num_rows($exe);

		if($rowcount >= 1)
		{
			$row_name = $rows['basic_full_name'];
			$row_dob = $rows['basic_dob'];
			$row_cnic = $rows['contact_cnic'];
			$row_gender = $rows['basic_gender'];
			$row_said = $rows['said'];
			$row_mobile = $rows['contact_mobile'];
			$row_email = $rows['contact_email'];
			$row_postal = $rows['contact_postal_address'];
			$row_post = $rows['post_apply'];
			$row_image = $rows['image'];
            $row_rollno = $rows['rollno'];
            $undertaking = $rows['undertaking'];
            
		}
		if(isset($row_post)){
		$querypost = "SELECT `slot` FROM `fee_slot` WHERE `post_id` IN ($row_post)";
		$exepost = mysqli_query($conn,$querypost);
		$postss = '';
		 while ($rowpost = mysqli_fetch_array($exepost))
		{
		      $postss .= $rowpost['slot'].',';
		}
            $postss = substr($postss,0,-1);
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>FGEI (C/G) Recruitment</title>

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
	<link rel="stylesheet" href="css/profilestyle.css">
</head>
    <style>
        .white{
            color: white;
            font-size: 16px;
        }
    </style>
<body>
	
<div class="wrapper hover_collapse">
	<?php include('header.php'); ?>

	<div class="sidebar">
		<div class="sidebar_inner">
		<ul>
			<li>
				<img src="images/logo.png" width="70%" height="70%" style="margin:30px;">
			</li>
			<li>
				<a href="profile.php" style="background: #292323;">
					<span class="icon"><i class="fas fa-user"></i></span>
					<span class="text">Profile</span>
				</a>
			</li>
		<!--	
            <?php
            //    if(!isset($undertaking))
                {
            ?>
			<li>
				<a href="per_info.php">
					<span class="icon"><i class="fas fa-edit"></i></span>
					<span class="text">Personal Info</span>
				</a>
			</li>
            <?php
                }
              //  elseif(isset($undertaking))
                {
            //       if($undertaking == 0)
                    {
            ?>
			<li>
			   <a href="per_info.php">
					<span class="icon"><i class="fas fa-edit"></i></span>
					<span class="text">Personal Info</span>
				</a>
			</li>
            <?php
                    } 
                }
            ?>
        -->
			<li>
				<a href="resetpassword.php">
					<span class="icon"><i class="fas fa-key"></i></span>
					<span class="text">Reset Password</span>
				</a>
			</li>

			<!--	<li>
				<a href="queryportal.php">
					<span class="icon"><i class="fas fa-comment"></i></span>
					<span class="text">Query Portal</span>
				</a>
			</li>
			-->
			<li>
				<a href="logout.php">
					<span class="icon"><i class="fas fa-sign-out-alt"></i></span>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
		</div>
	</div>




<!-- --------------------------------------body working------------------------------------------ -->
<div class="main_container">
	<div class="container">
		<hr style=" border-top: 2px solid #005faf;">



		<div class="container" style="color:black">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="color:black">
                    <?php
                    $anc = "SELECT * FROM message WHERE status ='Active' ";
                    $exeanc = mysqli_query($conn, $anc);
                    $ancrows = mysqli_num_rows($exeanc);
                    if($ancrows > 0)
                    {
                        ?>
<!--                        <h4><b>Announcements:</b></h4>-->
                        <?php
                        while($ancdata = mysqli_fetch_array($exeanc))
                        {
                            ?>
                                <?php echo "<FONT color=‘#000017’>".$ancdata['message']."</font>"; ?>
                            <?php
                        }
                    }
                    ?>
					<h4>Notifications:</h4>
                    <?php
                    $checkid = 0;
                        $postid="SELECT post_apply.post_apply FROM `post_apply` WHERE said = '$userid'";
                        $postexe = mysqli_query($conn, $postid);
                        $postrows = mysqli_num_rows($postexe);
                        if($postrows > 0)
                        {
                            $postdata = mysqli_fetch_array($postexe);
                            $postapplied = $postdata['post_apply'];
                            $value = explode(",", $postapplied);
                            foreach($value as $appliedpost)
                            {
                                $rollslip = "SELECT * FROM `details` JOIN posts ON posts.pid = details.d_postid WHERE d_postid='$appliedpost' AND d_said='$userid'";
                                $exerollslip = mysqli_query($conn, $rollslip);
                                $rollrows = mysqli_num_rows($exerollslip);
                                {
                                    if($rollrows > 0)
                                    {
                                        while($exedataroll = mysqli_fetch_array($exerollslip))
                                        {
                                            if($exedataroll['d_status'] == "Approved" && $exedataroll['d_centerid'] != NULL)
                                            {
                                                ?>
                                                    <form action="rollslip.php" method="post" style="color:green ; font-size:16px">
                                                        <input type="hidden" name="postid" value="<?php echo $exedataroll['d_postid']; ?>">
                                                        <input type="hidden" name="rollno" value="<?php echo $exedataroll['d_rollno']; ?>">
                                                        <input type="hidden" name="centerid" value="<?php echo $exedataroll['d_centerid']; ?>">
                                                        <em class="fa fa-address-card">&nbsp;</em><button type="submit" style="background-color:transparent ; border:none">Your Application for the post of <b><?php echo $exedataroll['name']; ?></b> is approved. Please Click here to download your Roll Number Slip.</button>
                                                        <br><br>
                                                    </form>
                                                <?php
                                                $checkid=1;
                                            }
                                            else if($exedataroll['d_status'] == "Rejected")
                                            {
                                            ?>
                                               <!-- <h4 style="font-size:16px; color:red"> <em class="fa fa-ban">&nbsp;</em>Your Application for the post of <b><?php echo $exedataroll['name']; ?></b> is Rejected.<h5><?php echo "<b>Reason:</b> ".$exedataroll['d_feedback'];  ?></h5></h4> 
                                               -->

                                                 <h4 style="font-size:16px; color:blue">Your application has been submitted successfully. </h4>
                                                
                                            <?php
                                                $checkid=1;
                                            }
                                        }
                                    }
                                }
                            }
                            if($checkid == 0)
                            {
                                if($undertaking == 1)
                                {
                    ?>
                    <h4 style="font-size:16px; color:blue">Your application has been submitted successfully. </h4>
                    <?php
                            }
                            }
                        }
                    else
                    {
                    ?>
                    <?php if(!isset($undertaking))
                    { ?>
                        <h4>Welcome to online recruitment.<br>Please go to personal info tab to submit application.</h4>
                    <?php
                    }
                    else
                    {
                        ?>
                            <h4 style="color:black">Your application has been submitted successfully.<br>.</h4>
                        <?php
                    }
                        }
                        ?>
                    <?php
                        $postid="SELECT post_apply.post_apply FROM `post_apply` WHERE said = '$userid'";
                        $postexe = mysqli_query($conn, $postid);
                        $postrows = mysqli_num_rows($postexe);
                        if($postrows > 0)
                        {
                            $postdata = mysqli_fetch_array($postexe);
                            $postapplied = $postdata['post_apply'];
                            $value = explode(",", $postapplied);
                        foreach ($value as $pid)
                        {
                            $genletter="SELECT * FROM details JOIN selected_rollno ON details.d_rollno = selected_rollno.sel_rollno WHERE details.d_postid = '$pid' AND details.d_status = 'Approved' AND d_centerid is NOT null AND d_said = '$userid'";
                            $exeletter = mysqli_query($conn, $genletter);
                            $letterrows = mysqli_num_rows($exeletter);
                            if($letterrows > 0)
                            {
                                ?>
                                <br><h4><b>Call Letter:</b></h4>
                            <?php
                                while($letterdata = mysqli_fetch_array($exeletter))
                                {
                                    if(isset($letterdata['slotid']))
                                    {
                                        $postname1="SELECT name FROM posts WHERE pid='$letterdata[d_postid]'";
                                        $exepostname1=mysqli_query($conn, $postname1);
                                        $postrow1 = mysqli_num_rows($exepostname1);
                                        if($postrow1 > 0)
                                        {
                                            while($postdata1 = mysqli_fetch_array($exepostname1))
                                            {
                                                $appliedpost1 = $postdata1['name'];
                                            }
                                        }
                                ?>
                                    <form action="letter.php" method="post" style="color:#005faf ; font-size:16px">
                                    <input type="hidden" name="postname" value="<?php echo $appliedpost1; ?>">
                                    <input type="hidden" name="slotid" value="<?php echo $letterdata['slotid']; ?>">
                                    <em class="fa fa-address-card">&nbsp;</em><button type="submit" style="background-color:transparent ; border:none">Your Call letter for the post of <b><?php echo $appliedpost1 ; ?></b> is generated. Please Click here to download your Interview Call Letter.</button>
                                    <br><br>
                                    </form>
                                <?php
                                }
                            }
                        }
                        }
                        }
                    ?>
				</div>
			</div>
		</div>

        <?php
        $result="SELECT results.roll_no, results.marks , results.status FROM results JOIN details ON details.d_rollno=results.roll_no WHERE details.d_rollno=results.roll_no AND details.d_said='$userid'";
        $exeresult=mysqli_query($conn, $result);
        $datarow = mysqli_num_rows($exeresult);
        if($datarow > 0 )
        {
        ?>
        <div class="container">
            <div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<h4>Result:</h4>
                    <?php
            while($dataresult = mysqli_fetch_array($exeresult))
            {
                    ?>
                    <h5 style="color:black">You obtained <b><?php echo $dataresult['marks']; ?></b> against roll number <b><?php echo $dataresult['roll_no'];   ?></b> and your application status is <b><?php echo $dataresult['status']; ?></b> </h5>
                    <?php
                    }
                    ?>
				</div>
			</div>
		</div>
        
        
            <?php
        }
        
        ?>
        

		<div class="content" >
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
					<figure class="figcol">
						<?php if(isset($row_image)){ ?>
							<img src="<?php echo $row_image ?>"   width="150px" height="150px">
						<?php } else { ?>
						<img src="images/default.png" width="150px" height="150px">
						<?php } ?>

					</figure>
				</div>
				<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
					<table cellpadding="2px" >
						<tr>
							<td colspan="2"  width="50%" ><h3 style="color:white"><?php if(isset($row_name)){ echo "WELCOME ".$row_name; } else{ echo "Your Full Name";} ?></h3></td>
						</tr>
						<tr>
							<th><kbd class="white" >Cnic:</kbd></th>
							<td><kbd class="white" ><?php if(isset($row_cnic)){ echo $row_cnic; } else{ echo "Nill";} ?></kbd></td>
						</tr>
						<tr>
							<th><kbd class="white" >Date of Birth:</kbd></th>
							<td><kbd class="white" ><?php if(isset($row_dob)){ echo $row_dob; } else{ echo "Nill";} ?></kbd></td>
						</tr>
						<tr>
							<th><kbd class="white" >Gender:</kbd></th>
							<td><kbd class="white" ><?php if(isset($row_gender)){ echo ucfirst($row_gender); } else{ echo "Nill";} ?></kbd></td>
						</tr>
						<tr>
							<th><kbd class="white" >Mobile Number:</kbd></th>
							<td><kbd class="white" ><?php if(isset($row_mobile)){ echo "+".$row_mobile; } else{ echo "Nill";} ?></kbd></td>
						</tr>
						<tr>
							<th><kbd class="white" >Email Address:</kbd></th>
							<td><kbd class="white" ><?php if(isset($row_email)){ echo $row_email; } else{ echo "Nill";} ?></kbd></td>
						</tr>
						<tr>
							<th><kbd class="white" >Postal Address:</kbd></th>
							<td><kbd class="white" ><?php if(isset($row_postal)){ echo ucfirst($row_postal); } else{ echo "Nill";} ?></kbd></td>
						</tr>
						<tr>
							
							<td><kbd class="white" ><?php if(isset($postss)){ echo strtoupper($postss); } else{ echo "";} ?></kbd></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- body Ends -->
</div>


    <!-- jQuery first, then Tether, then Bootstrap JS. -->
	<script src="script/scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>


<?php
mysqli_close($conn);
}
else{
  header("Location: index.php");
}
?>	