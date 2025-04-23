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
							<h3 style="color: green;">Lower Staff Quota</h3>
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

             				$newquery = "SELECT * FROM `posts` WHERE cat='2'";
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
     
      
      $sql = "SELECT * FROM `lowerstaff` WHERE pid=$id1";
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
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>mardan</label>
						</div>

						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="mardan" value="<?php echo $newrowss1['mardan']; ?>"   type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>kohat</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="kohat" value="<?php echo $newrowss1['kohat']; ?>"   type="text"  />
						</div>
					</div>
					<br>


            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>hangu</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="hangu"  value="<?php echo $newrowss1['hangu']; ?>"   type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>peshawar</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="peshawar" value="<?php echo $newrowss1['peshawar']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>nowshera</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="nowshera" value="<?php echo $newrowss1['nowshera']; ?>"   type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>attock</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="attock"  value="<?php echo $newrowss1['attock']; ?>"  type="text"  />
						</div>
					</div>
         
            <br>
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>islamabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="islamabad"  value="<?php echo $newrowss1['islamabad']; ?>"  type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>rawalpindi</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="rawalpindi"  value="<?php echo $newrowss1['rawalpindi']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>haripur</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="haripur"  value="<?php echo $newrowss1['haripur']; ?>"  type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>abbottabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="abbottabad"  value="<?php echo $newrowss1['abbottabad']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>jhelum</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="jhelum" value="<?php echo $newrowss1['jhelum']; ?>"   type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>kotli</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="kotli" value="<?php echo $newrowss1['kotli']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>muzaffarabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="muzaffarabad"  value="<?php echo $newrowss1['muzaffarabad']; ?>"  type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>mianwali</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="mianwali" value="<?php echo $newrowss1['mianwali']; ?>"   type="text"  />
						</div>
					</div>
            <br>

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>khushab</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="khushab"  value="<?php echo $newrowss1['khushab']; ?>"  type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>mandi bahauddin</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="mandi_bahauddin"  value="<?php echo $newrowss1['mandi_bahauddin']; ?>"  type="text"  />
						</div>
					</div>
            <br>
            
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>gujrat</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="gujrat"  value="<?php echo $newrowss1['gujrat']; ?>"  type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>gujranwala</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="gujranwala" value="<?php echo $newrowss1['gujranwala']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>sialkot</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="sialkot" value="<?php echo $newrowss1['sialkot']; ?>"   type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>lahore</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="lahore" value="<?php echo $newrowss1['lahore']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>jhang</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="jhang" value="<?php echo $newrowss1['jhang']; ?>"   type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>multan</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="multan" value="<?php echo $newrowss1['multan']; ?>"   type="text"  />
						</div>
					</div>
            <br>

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>hyderabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="hyderabad" value="<?php echo $newrowss1['hyderabad']; ?>"   type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>karachi</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="karachi" value="<?php echo $newrowss1['karachi']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>quetta</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control amount" onblur="findTotal()" name="quetta" value="<?php echo $newrowss1['quetta']; ?>"   type="text"  />
						</div>
					</div>
            <br>
            
            

            
    

            
            <div class="row" style="margin-top:20px ; width:50% ; ">
						<div class="col-lg-5" align="center" style="margin-left:30% ; margin-bottom: 40px">
					<input type="submit" name="update" value="Update" id="update" class="btn btn-lg btn-block btn-primary">
						</div>
					</div>
            
        </form>
	</div>




	<?php
             }
    } else {
          
  ?>  
        
    <form action=" " method ="Post" style="padding-right: 70px; padding-left: 30px; padding-top: 10px" onsubmit="return findTotal2();" >
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
                        <input class="form-control" style="font-weight:bold ; text-align:center" type="text" name="totalordercost1"  id="totalordercost1" readonly   />
                      </div>
                 </div>
                  <br>
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>mardan</label>
						</div>

						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="mardan" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>kohat</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="kohat" type="text"  />
						</div>
					</div>
					<br>


            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>hangu</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="hangu"  type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>peshawar</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="peshawar" type="text"  />
						</div>
					</div>
            <br>
            
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>nowshera</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="nowshera" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>attock</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="attock" type="text"  />
						</div>
					</div>
         
            <br>
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>islamabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="islamabad" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>rawalpindi</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="rawalpindi" type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>haripur</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="haripur" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>abbottabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="abbottabad" type="text"  />
						</div>
					</div>
            <br>
            
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" value='0' align="left">
							<label>jhelum</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="jhelum" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>kotli</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="kotli" type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>muzaffarabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="muzaffarabad" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>mianwali</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="mianwali" type="text"  />
						</div>
					</div>
            <br>

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>khushab</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="khushab" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>mandi bahauddin</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="mandi_bahauddin" type="text"  />
						</div>
					</div>
            <br>
            
            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>gujrat</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="gujrat" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>gujranwala</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="gujranwala" type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>sialkot</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="sialkot" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>lahore</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="lahore" type="text"  />
						</div>
					</div>
            <br>
            

            
             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>jhang</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="jhang" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>multan</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="multan" type="text"  />
						</div>
					</div>
            <br>

             <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>hyderabad</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="hyderabad" type="text"  />
						</div>
						<div class="col-lg-2" align="right">
							<label>karachi</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="karachi" type="text"  />
						</div>
					</div>
            <br>
            
            <div class="row" style="margin-left: 19%;">
						<div class="col-lg-2" align="left">
							<label>quetta</label>
						</div>
						<div class="col-lg-2" align="left">
							<input class="form-control samount" onblur="findTotal2()" value='0' name="quetta" type="text"  />
						</div>
					
					</div>
            <br>
            
            
            
            
            
            
            
            <div class="row" style="margin-top:20px ; width:50% ; ">
						<div class="col-lg-5" align="center" style="margin-left:30% ; margin-bottom: 40px">
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
      		$mardan = $_POST['mardan'];
        	$kohat = $_POST['kohat'];
        	$hangu = $_POST['hangu'];
        	$peshawar = $_POST['peshawar'];
        	$nowshera = $_POST['nowshera'];
        	$attock = $_POST['attock'];
        	$islamabad = $_POST['islamabad'];
        	$rawalpindi = $_POST['rawalpindi'];
        	$haripur = $_POST['haripur'];
        	$abbottabad = $_POST['abbottabad'];
        	$jhelum = $_POST['jhelum'];
        	$kotli = $_POST['kotli'];
        	$muzaffarabad = $_POST['muzaffarabad'];
        	$mianwali = $_POST['mianwali'];
        	$khushab = $_POST['khushab'];
        	$mandi_bahauddin = $_POST['mandi_bahauddin'];
        	$gujrat = $_POST['gujrat'];
        	$gujranwala = $_POST['gujranwala'];
        	$sialkot = $_POST['sialkot'];
        	$lahore = $_POST['lahore'];
        	$jhang = $_POST['jhang'];
        	$multan = $_POST['multan'];
        	$hyderabad = $_POST['hyderabad'];
        	$karachi = $_POST['karachi'];
        	$quetta = $_POST['quetta'];

        	if(isset($_POST['submit'])){


        	$query = "INSERT INTO `lowerstaff`(`pid` , `mardan`, `kohat`, `hangu`, `peshawar`, `nowshera`, `attock`, `islamabad`, `rawalpindi`, `haripur`, `abbottabad`, `jhelum`, `kotli`, `muzaffarabad`, `mianwali`, `khushab`, `mandi_bahauddin`, `gujrat`, `gujranwala`, `sialkot`, `lahore`, `jhang`, `multan`, `hyderabad`, `karachi` , `quetta`) VALUES ('$post','$mardan','$kohat','$hangu','$peshawar','$nowshera','$attock','$islamabad','$rawalpindi','$haripur','$abbottabad','$jhelum','$kotli','$muzaffarabad','$mianwali','$khushab','$mandi_bahauddin','$gujrat','$gujranwala','$sialkot','$lahore','$jhang','$multan','$hyderabad','$karachi','$quetta')";

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
        window.history.replaceState( null, null, 'lowerstaffquota.php' );
    }
</script><?php

		} elseif(isset($_POST['update'])) {
        
               
               $query = "UPDATE `lowerstaff` SET 
`mardan` = '$mardan',
`kohat` = '$kohat',
`hangu` = '$hangu',
`peshawar` = '$peshawar',
`nowshera` = '$nowshera',
`attock` = '$attock',
`islamabad` = '$islamabad',
`rawalpindi` = '$rawalpindi',
`haripur` = '$haripur',
`abbottabad` = '$abbottabad',
`jhelum` = '$jhelum',
`kotli` = '$kotli',
`muzaffarabad` = '$muzaffarabad',
`mianwali` = '$mianwali',
`khushab` = '$khushab',
`mandi_bahauddin` = '$mandi_bahauddin',
`gujrat` = '$gujrat',
`gujranwala` = '$gujranwala',
`sialkot` = '$sialkot',
`lahore` = '$lahore',
`jhang` = '$jhang',
`multan` = '$multan',
`hyderabad` = '$hyderabad',
`karachi` = '$karachi',
`quetta` = '$quetta'
WHERE `pid` = '$post'";


               
                
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
        window.history.replaceState( null, null, 'lowerstaffquota.php' );
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