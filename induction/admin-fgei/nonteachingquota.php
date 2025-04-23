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
	
	if ($user=='super-admin' || $user=='aoi-3')
   		{
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
	<?php 
      include('header.php');  
        include('quotanav.php');  
    ?>




	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		
            <div class="row">
						<div class="col-lg-12" align="center">
							<h3 style="color: green;">Teaching/Non Teaching Staff Quota</h3>
						</div>
            </div>
            <form  action=" " method ="GET" style="padding-right: 70px; padding-left: 30px; padding-top: 10px">
            <div class="row" style="margin-bottom: px; border:px solid black ">
						<div class="col-lg-3" align="right">
							<label>Post:</label>
						</div>
						<div class="col-lg-6" align="left" style=" border:px solid black ">
							<select class="form-control" name="post2" required>
							
							
								<option value="" selected>Select Post</option>
							 
							<?php

             				$newquery = "SELECT * FROM `posts` WHERE cat='1' || '3' ";
							$newdatas = mysqli_query($conn,$newquery);				
							$newrowct = mysqli_num_rows($newdatas);


							if($newrowct>0){

							while ($newrowss = mysqli_fetch_array($newdatas)){
							?>

							       <option <?php if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['submit1']) ){
                                if($_GET['post2'] == $newrowss['pid']){
                                    ?>
                                           selected
                                           <?php
                                }
                            }?> value="<?php echo $newrowss['pid']; ?>"><?php echo $newrowss['name']; echo ' (BPS-'. $newrowss['bps']; echo ') - '.ucfirst($newrowss['gender']);   ?></option> 
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

<?php
     
      
      $sql = "SELECT * FROM `nonteachingstaff` WHERE pid=$id1";
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
            
            <div class="row" style="margin-left:11%" >
                <br>

                <br>
                <div class="col-lg-2" align="center" style="margin-left:13%">
				    <label>Merit</label>
				</div>
                <div class="col-lg-2" align="center"style="margin-left:2%">
				    <label>Women</label>
				</div>
                <div class="col-lg-2" align="center" style="margin-left:2%">
				    <label>Minority</label>
				</div>
                <div class="col-lg-2" align="center" style="margin-left:3%">
				    <label>Special Persons</label>
				</div>
            </div>
            <br>
            <div class="row" style="margin-left:10%" >
            							<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>PUNJAB</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="pu_m" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['pu_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="pu_w" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['pu_women']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="pu_m2" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['pu_minority']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="pu_sp" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['pu_special_persons']; ?>"  />
						</div>
            </div>
            
            
             <div class="row">	
                <br>
    

            </div>
            <div class="row" style="margin-left:10%" >
            							<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>SINDH-URBAN</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="su_m" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['su_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="su_w" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['su_women']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="su_m2" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['su_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="su_sp" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['su_special_persons']; ?>"  />
						</div>
            </div>
            
             <div class="row">
                <br>

            </div>
            <div class="row" style="margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>SINDH-RURAL</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="sr_m" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['sr_merit']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="sr_w" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['sr_women']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="sr_m2" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['sr_minority']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="sr_sp" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['sr_special_persons']; ?>"  />
						</div>
            </div>
            
             <div class="row">
                <br>
                	</div>

            <div class="row" style="margin-left:10%" >
            				<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>KPK</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="kpk_m" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['kpk_merit']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right"style="margin-left:2%">
							<input class="form-control amount" name="kpk_w" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['kpk_women']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="kpk_m2" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['kpk_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="kpk_sp" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['kpk_special_persons']; ?>"  />
						</div>
            </div>
            
             <div class="row">
                <br>
						
                
            </div>
             <div class="row" style="margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>BALOCHISTAN</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="bl_m" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['bl_merit']; ?>"    />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="bl_w" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['bl_women']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="bl_m2" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['bl_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="bl_sp" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['bl_special_persons']; ?>"  />
						</div>
            </div>
            
             <div class="row">
                <br>
						

            </div>
            <div class="row" style="margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>FATA</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="fata_m" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['fata_merit']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="fata_w" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['fata_women']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="fata_m2" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['fata_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="fata_sp" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['fata_special_persons']; ?>"  />
						</div>
            </div>
            
             <div class="row">
                <br>
						
               
            </div>
            <div class="row" style=" margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>AZAD JAMMU KASHMIR</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="akj_m" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['akj_merit']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="akj_w" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['akj_women']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="akj_m2" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['akj_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="akj_sp" type="text" onblur="findTotal()"   value="<?php echo $newrowss1['akj_special_persons']; ?>"  />
						</div>
            </div>
            
            <div class="row">
                <br>
						
                
            </div>
            <div class="row" style=" margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>GILGIT-BALTISTAN</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control amount" name="gb_m" type="text"  onblur="findTotal()"   value="<?php echo $newrowss1['gb_merit']; ?>" />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="gb_w" type="text" onblur="findTotal()"  value="<?php echo $newrowss1['gb_women']; ?>"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="gb_m2" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['gb_minority']; ?>"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control amount" name="gb_sp" type="text"  onblur="findTotal()"  value="<?php echo $newrowss1['gb_special_persons']; ?>"  />
						</div>
            </div>
            
            
            

            
            <div class="row" style="margin-top:20px ; width:50% ; ">
						<div class="col-lg-5" align="center" style="margin-left:75% ; margin-bottom: 40px">
					<?php if(isset($messg)){ echo $messg; } ?> 
					<input type="submit" name="update" value="Update" id="update" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>
            
        </form>
	</div>
<?php
             }
    } else {
          
  ?>  
	<form action=" " method ="Post" style="padding-right: 70px; padding-left: 30px; padding-top: 10px" onsubmit="return findTotal2();">


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
                        <input class="form-control" style="font-weight:bold ; text-align:center" type="text" name="totalordercost1" id="totalordercost1" readonly   />
                      </div>
                 </div>
                  <br>

<div class="col-lg-3" align="right" style="margin-left:15%;">
							<label>Open Merit</label>
						</div>
						<div class="col-lg-2" align="left">
							<input  class="form-control samount amount"  onblur="findTotal2()" value='0' name="om" type="text" />
						</div>
					</div>
            
            <div class="row" style="margin-left:11%" >
                <br>

                <br>
                <div class="col-lg-2" align="center" style="margin-left:13%">
				    <label>Merit</label>
				</div>
                <div class="col-lg-2" align="center"style="margin-left:2%">
				    <label>Women</label>
				</div>
                <div class="col-lg-2" align="center" style="margin-left:2%">
				    <label>Minority</label>
				</div>
                <div class="col-lg-2" align="center" style="margin-left:3%">
				    <label>Special Persons</label>
				</div>
            </div>
            <br>
            <div class="row" style="margin-left:10%" >
            							<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>PUNJAB</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="pu_m" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="pu_w" value='0' type="text" onblur="findTotal2()"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="pu_m2" type="text" value='0' onblur="findTotal2()"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="pu_sp" type="text" value='0'  onblur="findTotal2()"  />
						</div>
            </div>
            
            
             <div class="row">	
                <br>
    

            </div>
            <div class="row" style="margin-left:10%" >
            							<div class="col-lg-1" align="left" value='0' style="margin-right:6%;"  >
							<label>SINDH-URBAN</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="su_m" value='0' type="text"  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="su_w" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="su_m2" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="su_sp" type="text" value='0' onblur="findTotal2()"  />
						</div>
            </div>
            
             <div class="row">
                <br>

            </div>
            <div class="row" style="margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>SINDH-RURAL</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="sr_m" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="sr_w" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="sr_m2" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="sr_sp" type="text" value='0' onblur="findTotal2()"  />
						</div>
            </div>
            
             <div class="row">
                <br>
                	</div>

            <div class="row" style="margin-left:10%" >
            				<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>KPK</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="kpk_m" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right"style="margin-left:2%">
							<input class="form-control samount" name="kpk_w" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="kpk_m2" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="kpk_sp" type="text" value='0'  onblur="findTotal2()"  />
						</div>
            </div>
            
             <div class="row">
                <br>
						
                
            </div>
             <div class="row" style="margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>BALOCHISTAN</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="bl_m" type="text" value='0' onblur="findTotal2()"   />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="bl_w" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="bl_m2" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="bl_sp" type="text" value='0' onblur="findTotal2()"  />
						</div>
            </div>
            
             <div class="row">
                <br>
						

            </div>
            <div class="row" style="margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>FATA</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="fata_m" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="fata_w" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="fata_m2" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="fata_sp" type="text" value='0' onblur="findTotal2()"  />
						</div>
            </div>
            
             <div class="row">
                <br>
						
               
            </div>
            <div class="row" style=" margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>AZAD JAMMU KASHMIR</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="akj_m" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="akj_w" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="akj_m2" type="text" value='0'value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="akj_sp" type="text" value='0' onblur="findTotal2()"  />
						</div>
            </div>
            
            <div class="row">
                <br>
						
                
            </div>
            <div class="row" style=" margin-left:10%" >
            	<div class="col-lg-1" align="left" style="margin-right:6%;"  >
							<label>GILGIT-BALTISTAN</label>
						</div>
						<div class="col-lg-2" align="right">
							<input class="form-control samount" name="gb_m" type="text" value='0' onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="gb_w" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="gb_m2" type="text" value='0'  onblur="findTotal2()"  />
						</div>
                        <div class="col-lg-2" align="right" style="margin-left:2%">
							<input class="form-control samount" name="gb_sp" type="text" value='0'  onblur="findTotal2()"  />
						</div>
            </div>
            
            
            

            
            <div class="row" style="margin-top:20px ; width:50% ; ">
						<div class="col-lg-5" align="center" style="margin-left:75% ; margin-bottom: 40px">
					<?php if(isset($messg)){ echo $messg; } ?> 
					<input type="submit" name="submit" id="save" value="Save" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>
            
        </form>

         <?php
}
}	
      
?>
    
        		<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
        	$post = $_POST['post_name'];
      		$om = $_POST['om'];
        	$pu_m = $_POST['pu_m'];
        	$pu_w = $_POST['pu_w'];
        	$pu_m2 = $_POST['pu_m2'];
        	$pu_sp = $_POST['pu_sp'];
        	$su_m = $_POST['su_m'];
        	$su_w = $_POST['su_w'];
        	$su_m2 = $_POST['su_m2'];
        	$su_sp = $_POST['su_sp'];
        	$sr_m = $_POST['sr_m'];
        	$sr_w = $_POST['sr_w'];
        	$sr_m2 = $_POST['sr_m2'];
        	$sr_sp = $_POST['sr_sp'];
        	$kpk_m = $_POST['kpk_m'];
        	$kpk_w = $_POST['kpk_w'];
        	$kpk_m2 = $_POST['kpk_m2'];
        	$kpk_sp = $_POST['kpk_sp'];
        	$bl_m = $_POST['bl_m'];
        	$bl_w = $_POST['bl_w'];
        	$bl_m2 = $_POST['bl_m2'];
        	$bl_sp = $_POST['bl_sp'];
        	$fata_m = $_POST['fata_m'];
        	$fata_w = $_POST['fata_w'];
        	$fata_m2 = $_POST['fata_m2'];
        	$fata_sp = $_POST['fata_sp'];
        	$akj_m = $_POST['akj_m'];
        	$akj_w = $_POST['akj_w'];
        	$akj_m2 = $_POST['akj_m2'];
        	$akj_sp = $_POST['akj_sp'];
        	$gb_m = $_POST['gb_m'];
        	$gb_w = $_POST['gb_w'];
        	$gb_m2 = $_POST['gb_m2'];
        	$gb_sp = $_POST['gb_sp'];

        	if(isset($_POST['submit'])){
				
        	  

        	$query = "INSERT INTO `nonteachingstaff`(`pid` , `open_merit`, `pu_merit`, `pu_women`, `pu_minority`, `pu_special_persons`, `su_merit`, `su_women`, `su_minority`, `su_special_persons`, `sr_merit`, `sr_women`, `sr_minority`, `sr_special_persons`, `kpk_merit`, `kpk_women`, `kpk_minority`, `kpk_special_persons`, `bl_merit`, `bl_women`, `bl_minority`, `bl_special_persons`, `fata_merit`, `fata_women`, `fata_minority`, `fata_special_persons`, `akj_merit`, `akj_women`, `akj_minority`, `akj_special_persons`, `gb_merit`, `gb_women`, `gb_minority`, `gb_special_persons`) VALUES ('$post','$om','$pu_m','$pu_w','$pu_m2','$pu_sp','$su_m','$su_w','$su_m2','$su_sp','$sr_m','$sr_w','$sr_m2','$sr_sp','$kpk_m','$kpk_w','$kpk_m2','$kpk_sp','$bl_m','$bl_w','$bl_m2','$bl_sp','$fata_m','$fata_w','$fata_m2','$fata_sp','$akj_m','$akj_w','$akj_m2','$akj_sp','$gb_m','$gb_w','$gb_m2','$gb_sp')";

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
        window.history.replaceState( null, null, 'nonteachingquota.php' );
    }
</script><?php
	
			}elseif(isset($_POST['update'])) {
               $query = "UPDATE `nonteachingstaff` SET `open_merit`='$om' , `pu_merit`='$pu_m', `pu_women`='$pu_w',  `pu_minority`='$pu_m2', `pu_special_persons`='$pu_sp', `su_merit`='$su_m',  `su_women`='$su_w', `su_minority`='$su_m2', `su_special_persons`='$su_sp', `sr_merit`='$sr_m', `sr_women`='$sr_w', `sr_minority`='$sr_m2', `sr_special_persons`='$sr_sp', `kpk_merit`='$kpk_m', `kpk_women`='$kpk_w', `kpk_minority` ='$kpk_m2', `kpk_special_persons`='$kpk_sp',  `bl_merit`='$bl_m', `bl_women`='$bl_w', `bl_minority`='$bl_m2', `bl_special_persons`='$bl_sp', `fata_merit`='$fata_m', `fata_women`='$fata_w', `fata_minority`='$fata_m2', `fata_special_persons`='$fata_sp', `akj_merit`='$akj_m',  `akj_women`='$akj_w',  `akj_minority`='$akj_m2',  `akj_special_persons`='$akj_sp',`gb_merit`='$gb_m', `gb_women`='$gb_w', `gb_minority`='$gb_m2', `gb_special_persons`='$gb_sp'   WHERE pid = '$post'";
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
        window.history.replaceState( null, null, 'nonteachingquota.php' );
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
   echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access of this page</div>';

}
}
else{
  header("Location: index.php");
}
?>