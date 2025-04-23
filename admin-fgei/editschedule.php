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
<?php
      include('header.php');
      include('testnav.php');
      $id = $_GET['id'];
      $sql="SELECT * FROM `test_schedule` WHERE id='$id'";
      $exesql = mysqli_query($conn, $sql);
      $sqldata = mysqli_fetch_array($exesql);
      echo $sqldata['date_time'];
      
    ?>



    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <div class="row">
            <div class="col-lg-12" align="center">
                <h3 style="color: green;margin-bottom: 20px;">Edit Test Scheduling</h3>
            </div>
        </div>
        
        <form class="form-group" action="" method="POST">
            <div class="row">
                <br>
                <div class="col-lg-4" align="right">
                    <label>DATE and TIME:</label>
                </div>
                <div class="col-lg-5" align="center">
                    <input class="form-control" type="datetime-local" name="date_time"  min="2021-01-01T00:00" 
                                value="<?php echo $sqldata['date_time'] ?>"   required>
                    <br>
                    <input type="submit" name="Update" value="Update" class="btn btn-lg btn-block btn-primary">
                </div>
            </div>
        </form>
    </div>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $datetime = $_POST['date_time'];
        $update ="UPDATE `test_schedule` SET `date_time`='$datetime' WHERE id=$id";
        $exeupdate = mysqli_query($conn, $update);
        header('location: schedule.php');
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