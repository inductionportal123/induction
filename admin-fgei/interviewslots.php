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
	<title>Admin - Slots</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
	<link href="css/styles.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
</head>
<body>
     <?php 
      include('header.php');  
        include('testnav.php');  
    
    ?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-12" align="center">
                <h3 style="color: green;margin-bottom: 20px;">Interview Slots</h3>
            </div>
        </div>
                <form class="form-group" action="" method="POST">
    <div class="row">
        <div class="col-lg-4" align="right">
            <label>Name of Post:</label>
        </div>
        <div class="col-lg-5" align="center">

            <select class="form-control" name="post_id" required>
                <option value="" selected>Select Post</option>
                <?php
        $newquery = "SELECT * FROM `posts` ORDER BY gender DESC;";
      $newdatas = mysqli_query($conn,$newquery);
      $newrowct = mysqli_num_rows($newdatas);
      if($newrowct>0){
          while ($newrowss = mysqli_fetch_array($newdatas))
          {
                ?>
                <option value="<?php echo $newrowss['pid']; ?>">
                    <?php echo $newrowss['name']; echo ' (BPS-'. $newrowss['bps']; echo ') - '.ucfirst($newrowss['gender']);   ?>
                </option>
                <?php
          }
      }
                ?>
            </select>
        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
						<div class="col-lg-4" align="right">
							<label>Region Name:</label>
						</div>
						<div class="col-lg-5" align="left">
							<select class="form-control" name="region_name" required>
							
							
								<option value="" selected>Select Your Region</option>
							 
							<?php

             				$newquery = "SELECT `name` FROM `region` ORDER BY id ASC;";
							$newdatas = mysqli_query($conn,$newquery);				
							$newrowct = mysqli_num_rows($newdatas);


							if($newrowct>0){

							while ($newrowss = mysqli_fetch_array($newdatas)){
							?>

							        <option value="<?=$newrowss['name']?>"><?= strtoupper($newrowss['name']) ?></option> 
							<?php
							}
							}
							?>
							</select>
						</div>
					</div>
                    <div class="row">
                        <br>
                        <div class="col-lg-4" align="right">
                            <label>Slot Name:</label>
                        </div>
                        <div class="col-lg-5" align="center">
                            <input class="form-control" type="text" name="slotname" required >
                            <br>
                            <input class="form-control" type="datetime-local" name="date_time" value="2021-01-01T00:00"
                            min="2021-01-01T00:00" required>
                            <br>
                            <input type="submit" name="submit" value="Save" class="btn btn-lg btn-block btn-primary">
                        </div>
                    </div>
        </form>
        <?php
      if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
          $reg = $_POST['region_name'];
          $pid = $_POST['post_id'];
          $date_time = $_POST['date_time'];
          $slot_name = $_POST['slotname'];
          if(isset($_POST['submit'])){
              $insertdate = "INSERT INTO `interview_slots`( `post_id`, `date_time` , `slot_name` ,`region`) VALUES ('$pid','$date_time','$slot_name','$reg')";
              $exeinsert = mysqli_query($conn, $insertdate);
          }
      }
      ?>
        
            <div class="col-lg-offset-3" align="center" style="width:60%">
        <?php
       $query2 = "SELECT * FROM `interview_slots`";
          $exe2 = mysqli_query($conn,$query2);
          $rowcount2 = mysqli_num_rows($exe2);
          if ($rowcount2 > 0)
          {
        ?>
        <table class="table table-bordered" width="70%">
            <tr>
                <th style="text-align: center;">Post</th>
                <th style="text-align: center;">Region</th>
                <th style="text-align: center;">Slot Name</th>
                <th style="text-align: center;">Test Time</th>
                <th style="text-align: center;">Edit</th>
            </tr>
            <?php
              while ($rows = mysqli_fetch_array($exe2))
              {
                  $sql = "SELECT * FROM `posts` where pid='$rows[post_id]'";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_assoc($result)) {
                  $post_name = $row['name'];
              }
          }
                  
            ?>
            <tr>
                <td style="text-align: center;"><?php echo  $post_name ;?></td>
                <td style="text-align: center;"><?php echo $rows['region'] ;?></td>
                <td style="text-align: center;"><?php echo $rows['slot_name'] ;?></td>
                <td style="text-align: center;"><?php echo $rows['date_time'];?></td>
                <td style="text-align: center;">
                <a href="editslots.php?id=<?=$rows['id']?>" onclick="return confirm('Are you sure to Edit?')">Edit</a> | 
                <a href="delslot.php?id=<?=$rows['id']?>" onclick="return confirm('Are you sure to Delete?')">Delete</a>
                </td>
            </tr>

<?php
}
}
?>
 </table>
                </div>
            </div>
   
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