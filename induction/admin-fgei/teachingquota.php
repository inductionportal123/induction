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
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
   
    
<body>
	<?php include('header.php'); 
    ?>

<div id="sidebar-collapse" class="col-sm-3 col-lg-3 sidebar">
		<div class="profile-sidebar">
			<div class="profile-userpic">
				<img src="image/logo.png" class="img-responsive" alt="">
			</div>
			<div class="profile-usertitle">
				<div class="profile-usertitle-name"><?php echo $user ?></div>
				<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="divider"></div>
		<ul class="nav menu">
			<li><a href="admissiondate.php"><em class="fa fa-book">&nbsp;</em> Induction Settings</a></li>
			<li><a href="region.php"><em class="fa fa-globe">&nbsp;</em> Region Setting</a></li>
			<li><a href="district.php"><em class="fa fa-map-marker">&nbsp;</em> District Setting</a></li>
			<li><a href="centers.php"><em class="fa fa-university">&nbsp;</em> Centers</a></li>
            <li><a href="feeslot.php"><em class="fa fa-money">&nbsp;</em> Fee Slots</a></li>
            <li><a href="bankfee.php"><em class="fa fa-credit-card">&nbsp;</em> Bank Charges</a></li>
            <li><a href="createpost.php"><em class="fa fa-laptop">&nbsp;</em> Posts</a></li>
            <li><a href="category.php"><em class="fa fa-laptop">&nbsp;</em> Post Details</a></li>

			<li class="parent " >
                <a class="active" data-toggle="collapse" href="#sub-item-1">
				<em class="fa fa-navicon">&nbsp;</em> Quota <span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children" id="sub-item-1">
<!--
					<li ><a class="active" class="" href="teachingquota.php">
						<span  class="fa fa-arrow-right">&nbsp;</span> Teaching Staff
					</a></li>
-->
					<li><a class="" href="nonteachingquota.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Teaching/Non Teaching Staff
					</a></li>
					<li><a class="" href="lowerstaffquota.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Lower Staff
					</a></li>
				</ul>
			</li>
						<li class="parent ">
                <a data-toggle="collapse" href="#sub-item-2">
				<em class="fa fa-dashboard">&nbsp;</em> Applications <span data-toggle="collapse" href="#sub-item-2" class="icon pull-right"><em class="fa fa-plus"></em></span>
				</a>
				<ul class="children" id="sub-item-2">
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
<!--
					<li><a class="" href="overage.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Over_Age Applications
					</a></li>
-->
				</ul>
			</li>
			<li><a href="query.php"><em class="fa fa-question-circle">&nbsp;</em> Queries</a></li>
			<li><a onclick="myfunc()" href="logout.php"><em class="fa fa-power-off">&nbsp;</em> Logout</a></li>
		</ul>
	</div><!--/.sidebar-->
    
  
    
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		
        
            <div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Teaching Staff Quota</h3>
						</div>
            </div>
        <form action=" " method ="GET" style="padding-right: 70px; padding-left: 30px; padding-top: 10px">
            <div class="row" style="margin-bottom: px; border:px solid black ">
						<div class="col-lg-3" align="right">
							<label>Post:</label>
						</div>

						<div class="col-lg-6" align="left" style=" border:px solid black ">
							<select class="form-control" name="post2" required>
							
							
								<option value="" selected>Select Post</option>
							 
							<?php

             				$newquery = "SELECT * FROM `posts` WHERE cat='1'";
							$newdatas = mysqli_query($conn,$newquery);				
							$newrowct = mysqli_num_rows($newdatas);


							if($newrowct>0){

							while ($newrowss = mysqli_fetch_array($newdatas)){
							?>

							        <option value="<?php echo $newrowss['pid']; ?>"><?php echo $newrowss['name']; echo ' (BPS-'. $newrowss['bps']; echo ') - '.ucfirst($newrowss['gender']);   ?></option> 
							<?php
							}
							}
							?>
							</select>
                            
                            
						</div>
                                <div class="col-lg-3" align="right" style=" border:px solid black ">
					<input type="submit" name="submit1" value="Show Records" class="btn btn-lg btn-block btn-primary">
						</div>
                
					</div>
            
</form>
        
        <?php
      $id1=NULL;
      if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit1']) )
        {
          $id1=$_GET['post2'];
      
          
          $sql = "SELECT nop FROM `post_details` where pid=$id1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while($row = mysqli_fetch_assoc($result)) {
    $numop = $row["nop"];
  }
}
          else{
              $numop=0;
          }
?>
        
        <script>
    function findTotal(){
    var arr = document.getElementsByClassName('amount');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
        
    document.getElementById('totalordercost').value = tot;
        console.log(tot);
        var totall= "<?php echo $numop ?>" ;
        console.log(totall);
        if(tot > totall)
        {
            window.alert("Number of posts exceeded");
            document.getElementById("update").disabled = true;
            document.getElementById("totalordercost").style.backgroundColor =  "red";
            document.getElementById("totalordercost").style.color =  "white";
            return false;
            
        }
        else{
            document.getElementById("update").disabled = false;
            document.getElementById("totalordercost").style.backgroundColor =  "#54d654";
            document.getElementById("totalordercost").style.color =  "white";
            return true;
        }
    
     
}
    
            
            function findTotal2(){
    var arr = document.getElementsByClassName('samount');
    var tot=0;
    for(var i=0;i<arr.length;i++){
        if(parseFloat(arr[i].value))
            tot += parseFloat(arr[i].value);
    }
        
    document.getElementById('totalordercost1').value = tot;
        console.log(tot);
        var totall= "<?php echo $numop ?>" ;
        console.log(totall);
        if(tot > totall)
        {
            window.alert("Number of posts exceeded");
            document.getElementById("save").disabled = true;
            document.getElementById("totalordercost1").style.backgroundColor =  "red";
            document.getElementById("totalordercost1").style.color =  "white";
            return false;
            
        }
        else{
            document.getElementById("save").disabled = false;
            document.getElementById("totalordercost1").style.backgroundColor =  "#54d654";
            document.getElementById("totalordercost1").style.color =  "white";
            return true;
        }
    
     
}
     
   
    </script> 
        
        
        
<!--        <input type="text" class="form-control samount total"  value="<?php echo $numop ?>"/>-->
        <?php
     
      
      $sql = "SELECT * FROM `teachingstaff` WHERE pid=$id1";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
  // output data of each row
  while( $newrowss1 = mysqli_fetch_assoc($result)) {
      ?>
        
            <form action=" " onsubmit="return findTotal();" method ="Post" style="padding-right: 70px; padding-left: 30px; padding-top: 10px">
             <div class="row" align="center" style="padding-left: 10%">
                  <div class="row" style="border:0px solid black;">
               

                <div class="col-lg-6" align="center"  style="margin-left:1%" >
				    <?php

             				$newquery3 = "SELECT * FROM `posts` WHERE pid=$id1;";
							$newdatas3 = mysqli_query($conn,$newquery3);				
							$newrowct3 = mysqli_num_rows($newdatas3);


							if($newrowct3>0){

							while ($newrowss3 = mysqli_fetch_array($newdatas3)){
							?>
                                    
							<label for="post_name">Post</label>
                                    <input style="font-weight:bold ; text-align:center  ;" class="form-control" value="<?php echo $newrowss3['name']; echo ' (BPS-'. $newrowss3['bps']; echo ') - '.ucfirst($newrowss3['gender']);   ?>"  readonly >
							        <input type="hidden"  class="form-control" name="post_name" value="<?php echo $id1; ?>" /> <br><label style="margin-left:75%;" >Quota Details</label>
							<?php
							}
                                ?>
                                
                    <?php
							}
							?>
                      </div>
                    <div class="col-lg-2" align="center"  style="margin-left:1%" >
                        <label>NOP</label>
                        <input class="form-control" style="font-weight:bold ; text-align:center ;"  type="text" name="NOP" id="NOP"  value="<?php echo $numop; ?>"  readonly   />
                      </div>
                      <div class="col-lg-2" align="center"  style="margin-left:1%" >
                        <label>Held</label>
                        <input class="form-control" style="font-weight:bold ; text-align:center" type="text" name="totalordercost" id="totalordercost" readonly   />
                      </div>
                 </div>
                  <br>
						<div class="col-lg-3" align="right" style="margin-left:15%;">
							<label>Open Merit</label>
						</div>
						<div class="col-lg-2" align="left">
							<input  class="form-control amount"  onblur="findTotal()" name="om" type="text" value="<?php echo $newrowss1['open_merit']; ?>"  />
						</div>
					</div>
            
            <div class="row" style="border:0px solid black;">
                <br>

                <div class="col-lg-2" align="right" style="margin-left: 24%;" >
				    <label>Merit</label>
				</div>
                <div class="col-lg-2" align="center" style=" margin-left: 3%">
				    <label>Minority</label>
				</div>
                <div class="col-lg-2" align="left" style=" margin-left: 0.5%;">
				    <label>Special Persons</label>
				</div>
            </div>
            
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>PUNJAB</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control amount"  onblur="findTotal()" name="pu_m" type="text"  value="<?php echo $newrowss1['pu_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control amount"  onblur="findTotal()" name="pu_m2" type="text"  value="<?php echo $newrowss1['pu_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
							<input class="form-control amount"  onblur="findTotal()" name="pu_sp" type="text"  value="<?php echo $newrowss1['pu_special_persons']; ?>"  />
						</div>
            </div>
            
             <div class="row">
                <br>

                <div class="col-lg-2" align="right" style="margin-left: 19%;" >
<!--				    <label>Merit</label>-->
				</div>
              <div class="col-lg-2" align="center" style=" margin-left: 6%">

				</div>
                <div class="col-lg-2" align="right" style=" margin-right: 1%;">
<!--				    <label>Special Persons</label>-->
				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>SINDH-URBAN</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
                            <input class="form-control amount" onblur="findTotal()"  name="su_m" type="text" value="<?php echo $newrowss1['su_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
<!--							<input class="form-control" type="text"  />-->
						</div>
            </div>
            
            <div class="row">
                <br>

                <div class="col-lg-2" align="right" style="margin-left: 19%;" >
<!-- 				    <label>Merit</label> -->
				</div>
                <div class="col-lg-2" align="right" style=" margin-right: 1%;">
<!-- 				    <label>Minority</label> -->
				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>SINDH-RURAL</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control amount"  onblur="findTotal()" name="sr_m" type="text"  value="<?php echo $newrowss1['sr_merit']; ?>"  />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control amount"  onblur="findTotal()" name="sr_m2" type="text" value="<?php echo $newrowss1['sr_minority']; ?>"   />
						</div>
            </div>
            
            <div class="row">
                <br>

                <div class="col-lg-3" align="center" style="margin-left:26%">

				</div>
                <div class="col-lg-3" align="left" style="margin-left:2%">

				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>KPK</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control amount" onblur="findTotal()"  name="kpk_m" type="text"  value="<?php echo $newrowss1['kpk_merit']; ?>"  />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">	
							<input class="form-control amount"  onblur="findTotal()" name="kpk_m2" type="text"  value="<?php echo $newrowss1['kpk_minority']; ?>"  />
						</div>
            </div>
            
            
            <div class="row">
                <br>

                <div class="col-lg-3" align="center" style="margin-left:26%">
				</div>
                <div class="col-lg-3" align="left" style="margin-left:2%">
				</div>
            </div>
           <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>BALOCHISTAN</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control amount"  onblur="findTotal()" name="bl_m" type="text" value="<?php echo $newrowss1['bl_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control amount"  onblur="findTotal()" name="bl_m2" type="text"  value="<?php echo $newrowss1['bl_minority']; ?>"  />
						</div>
            </div>
            
            <div class="row">
                <br>
                <div class="col-lg-3" align="right">
				</div>
                <div class="col-lg-3" align="right">

				</div>
                <div class="col-lg-3" align="right">

				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>FATA</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control amount"  onblur="findTotal()" name="fata_m" type="text" value="<?php echo $newrowss1['fata_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control amount"  onblur="findTotal()" name="fata_m2" type="text"  value="<?php echo $newrowss1['fata_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
							<input class="form-control amount"  onblur="findTotal()" name="fata_sp" type="text" value="<?php echo $newrowss1['fata_special_persons']; ?>"   />
						</div>
            </div>
            
                         <div class="row">
                <br>

                <div class="col-lg-2" align="right">
<!--				    <label>Merit</label>-->
				</div>
                <div class="col-lg-3" align="right" style="margin-left:7%">

				</div>
                <div class="col-lg-3" align="right">
<!--				    <label>Special Persons</label>-->
				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            	         <div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>AZAD JAMMU KASHMIR</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left:0.1%">
							<input class="form-control amount" onblur="findTotal()"  name="akj_m" type="text" value="<?php echo $newrowss1['akj_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">

						</div>
                        <div class="col-lg-3" align="right" style="margin-left:1%">
<!--							<input class="form-control" type="text"  />-->
						</div>
            </div>
            
                        <div class="row">
                <br>
                <div class="col-lg-3" align="right">

				</div>
                <div class="col-lg-3" align="right">

				</div>
                <div class="col-lg-3" align="right">

				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>GILGIT-BALTISTAN</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left:0.1%">
							<input class="form-control amount" onblur="findTotal()"  name="gb_m" type="text" value="<?php echo $newrowss1['gb_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control amount" onblur="findTotal()"  name="gb_m2" type="text" value="<?php echo $newrowss1['gb_minority']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
							<input class="form-control amount" onblur="findTotal()"  name="gb_sp" type="text"  value="<?php echo $newrowss1['gb_special_persons']; ?>"  />
						</div>
                
                
                
            </div>
                
                <div class="row" style="margin-top:20px ; width:50% ;  ">
						<div class="col-lg-5" align="center" style="margin-left:75% ; margin-bottom: 40px;">
					<?php if(isset($messg)){ echo $messg; } ?> 
					<input type="submit" name="update" value="Update" id="update" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>
        </form>
                <?php
             }
    } else {
          
  ?>  
        
    <form action=" " method ="Post" style="padding-right: 70px; padding-left: 30px; padding-top: 10px" onsubmit="return findTotal2();">
             <div class="row" align="center" style="padding-left: 10%">
                 
                  <div class="row" align="left" style="border:0px solid black;">
               

                <div class="col-lg-6" align="center"  style="margin-left:1%" >
                   <label>Selected Post</label>
				    <?php

             				$newquery3 = "SELECT * FROM `posts` WHERE pid=$id1;";
							$newdatas3 = mysqli_query($conn,$newquery3);				
							$newrowct3 = mysqli_num_rows($newdatas3);


							if($newrowct3>0){

							while ($newrowss3 = mysqli_fetch_array($newdatas3)){
							?>
                     
                                    <input style="font-weight:bold ; text-align:center ; " class="form-control" value="<?php echo $newrowss3['name']; echo ' (BPS-'. $newrowss3['bps']; echo ') - '.ucfirst($newrowss3['gender']);   ?>"  readonly >
							        <input type="hidden"  class="form-control" name="post_name" value="<?php echo $id1; ?>" /> 
							<?php
							}
							}
							?><br><label style="margin-left:75%;" >Quota Details</label>
                      </div>
                 <div class="col-lg-2" align="center"  style="margin-left:1%" >
                        <label>NOP</label>
                        <input class="form-control" style="font-weight:bold ; text-align:center ; "  type="text" name="NOP" id="NOP" value="<?php echo $numop; ?>" readonly   />
                      </div>
                      <div class="col-lg-2" align="center"  style="margin-left:1%" >
                        <label>Held</label>
                        <input class="form-control" style="font-weight:bold ; text-align:center" type="text" name="totalordercost1" id="totalordercost1" readonly   />
                      </div>
                 </div>
                  <br>
						<div class="col-lg-3" align="right" style="margin-left:15%;" >
							<label>Open Merit</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" name="om" id="1" type="text" />
						</div>
					</div>
            
            <div class="row" style="border:0px solid black;">
                <br>

                <div class="col-lg-2" align="right" style="margin-left: 24%;" >
				    <label>Merit</label>
				</div>
                <div class="col-lg-2" align="center" style=" margin-left: 3%">
				    <label>Minority</label>
				</div>
                <div class="col-lg-2" align="left" style=" margin-left: 0.5%;">
				    <label>Special Persons</label>
				</div>
            </div>
            
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>PUNJAB</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control samount"  onblur="findTotal2()" name="pu_m" id="2" type="text"    />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="pu_m2" id="3" type="text"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="pu_sp" id="4" type="text"   />
						</div>
            </div>
            
             <div class="row">
                <br>

                <div class="col-lg-2" align="right" style="margin-left: 19%;" >
<!--				    <label>Merit</label>-->
				</div>
              <div class="col-lg-2" align="center" style=" margin-left: 6%">

				</div>
                <div class="col-lg-2" align="right" style=" margin-right: 1%;">
<!--				    <label>Special Persons</label>-->
				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>SINDH-URBAN</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
                            <input class="form-control samount"  onblur="findTotal2()" name="su_m" type="text"    />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
<!--							<input class="form-control samount"  onblur="findTotal2()" type="text"  />-->
						</div>
            </div>
            
            <div class="row">
                <br>

                <div class="col-lg-2" align="right" style="margin-left: 19%;" >
<!-- 				    <label>Merit</label> -->
				</div>
                <div class="col-lg-2" align="right" style=" margin-right: 1%;">
<!-- 				    <label>Minority</label> -->
				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>SINDH-RURAL</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control samount"  onblur="findTotal2()" name="sr_m" type="text"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="sr_m2" type="text"    />
						</div>
            </div>
            
            <div class="row">
                <br>

                <div class="col-lg-3" align="center" style="margin-left:26%">

				</div>
                <div class="col-lg-3" align="left" style="margin-left:2%">

				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>KPK</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control samount"  onblur="findTotal2()" name="kpk_m" type="text"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">	
							<input class="form-control samount"  onblur="findTotal2()" name="kpk_m2" type="text"   />
						</div>
            </div>
            
            
            <div class="row">
                <br>

                <div class="col-lg-3" align="center" style="margin-left:26%">
				</div>
                <div class="col-lg-3" align="left" style="margin-left:2%">
				</div>
            </div>
           <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>BALOCHISTAN</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control samount"  onblur="findTotal2()" name="bl_m" type="text"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="bl_m2" type="text"   />
						</div>
            </div>
            
            <div class="row">
                <br>
                <div class="col-lg-3" align="right">
				</div>
                <div class="col-lg-3" align="right">

				</div>
                <div class="col-lg-3" align="right">

				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>FATA</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left: 0.1%;">
							<input class="form-control samount"  onblur="findTotal2()" name="fata_m" type="text"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="fata_m2" type="text"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="fata_sp" type="text"  />
						</div>
            </div>
            
                         <div class="row">
                <br>

                <div class="col-lg-2" align="right">
<!--				    <label>Merit</label>-->
				</div>
                <div class="col-lg-3" align="right" style="margin-left:7%">

				</div>
                <div class="col-lg-3" align="right">
<!--				    <label>Special Persons</label>-->
				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            	         <div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>AZAD JAMMU KASHMIR</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left:0.1%">
							<input class="form-control samount"  onblur="findTotal2()" name="akj_m" type="text"  />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">

						</div>
                        <div class="col-lg-3" align="right" style="margin-left:1%">
<!--							<input class="form-control samount"  onblur="findTotal2()" type="text"  />-->
						</div>
            </div>
            
                        <div class="row">
                <br>
                <div class="col-lg-3" align="right">

				</div>
                <div class="col-lg-3" align="right">

				</div>
                <div class="col-lg-3" align="right">

				</div>
            </div>
            <div class="row" style=" margin-left: 16%; border:0px solid black;" >
            							<div class="col-lg-2" align="left" style="margin-right:0%;" >
							<label>GILGIT-BALTISTAN</label>
						</div>
						<div class="col-lg-2" align="right" style="margin-left:0.1%">
							<input class="form-control samount"  onblur="findTotal2()" name="gb_m" type="text"   />
						</div>
                        <div class="col-lg-2" align="center" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="gb_m2" type="text"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:1%">
							<input class="form-control samount"  onblur="findTotal2()" name="gb_sp" type="text"   />
						</div>
            </div>
                
                 <div class="row" style="margin-top:20px ; width:50% ;  ">
						<div class="col-lg-5" align="center" style="margin-left:75% ; margin-bottom: 40px;">
					<?php if(isset($messg)){ echo $messg; } ?> 
					<input type="submit" name="submit" id="save" value="Save" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>
            
        </form>
                
                
  <?php
}}
      
?>
           
	</div>
    		<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            
        	$post = $_POST['post_name'];
      		$om = $_POST['om'];
        	$pu_m = $_POST['pu_m'];
        	$pu_m2 = $_POST['pu_m2'];
        	$pu_sp = $_POST['pu_sp'];
        	$su_m = $_POST['su_m'];
        	$sr_m = $_POST['sr_m'];
        	$sr_m2 = $_POST['sr_m2'];
        	$kpk_m = $_POST['kpk_m'];
        	$kpk_m2 = $_POST['kpk_m2'];
        	$bl_m = $_POST['bl_m'];
        	$bl_m2 = $_POST['bl_m2'];
        	$fata_m = $_POST['fata_m'];
        	$fata_m2 = $_POST['fata_m2'];
        	$fata_sp = $_POST['fata_sp'];
        	$akj_m = $_POST['akj_m'];
        	$gb_m = $_POST['gb_m'];
        	$gb_m2 = $_POST['gb_m2'];
        	$gb_sp = $_POST['gb_sp'];
            
            
           if(isset($_POST['submit'])){
        	  
        	$query = "INSERT INTO `teachingstaff`(`pid` , `open_merit`, `pu_merit`, `pu_minority`, `pu_special_persons`, `su_merit`, `sr_merit`, `sr_minority`, `kpk_merit`, `kpk_minority`,  `bl_merit`, `bl_minority`, `fata_merit`, `fata_minority`, `fata_special_persons`, `akj_merit`, `gb_merit`, `gb_minority`, `gb_special_persons`) VALUES ('$post','$om','$pu_m','$pu_m2','$pu_sp','$su_m','$sr_m','$sr_m2','$kpk_m','$kpk_m2','$bl_m','$bl_m2','$fata_m','$fata_m2','$fata_sp','$akj_m','$gb_m','$gb_m2','$gb_sp' )";
               
               
              
                
               ?>
    
    <script>window.location("<?php echo $total ?>")</script>
    <?php
              
        	$exe = mysqli_query($conn,$query); 

        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
         ?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, 'teachingquota.php' );
    }
</script><?php

		} elseif(isset($_POST['update'])) {
               $query = "UPDATE `teachingstaff` SET `open_merit`='$om' , `pu_merit`='$pu_m', `pu_minority`='$pu_m2', `pu_special_persons`='$pu_sp', `su_merit`='$su_m', `sr_merit`='$sr_m', `sr_minority`='$sr_m2', `kpk_merit`='$kpk_m', `kpk_minority` ='$kpk_m2',  `bl_merit`='$bl_m', `bl_minority`='$bl_m2', `fata_merit`='$fata_m', `fata_minority`='$fata_m2', `fata_special_persons`='$fata_sp', `akj_merit`='$akj_m', `gb_merit`='$gb_m', `gb_minority`='$gb_m2', `gb_special_persons`='$gb_sp'   WHERE pid = '$post'";
               
               
                
               ?>
    
    <script>window.location(<?php echo $total ?>)</script>
    <?php
               
             
               
        	$exe = mysqli_query($conn,$query);
        		if(!$exe)
				{
						die(mysqli_error($conn));
				}
               ?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, 'teachingquota.php' );
    }
</script><?php

			
		}
            
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
</body>
</html>

<?php
}

else{
  header("Location: index.php");
}

?>