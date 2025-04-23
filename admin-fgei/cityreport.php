<?php
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
    include('reportnav.php');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-1 main">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div id="ui">
                <div class="row">
                    <div class="col-lg-12" align="center">
                        <h3 style="color: green;margin-bottom: 20px;">City Report</h3>
                    </div>
                </div>
                <div class="row">
                    <table class="table table-bordered">
                        <thead style="background-color:#30a5ff ; color:white">
                            <th>City</th>
                            <th>Applicants</th>
                        </thead>
                        <tbody>
                            <?php
                                $total = 0;
                                $sql = "SELECT DISTINCT(district.id) , centes.district FROM district JOIN centes ON district.name = centes.district";
                                $exe = mysqli_query($conn, $sql);
                                while($data = mysqli_fetch_array($exe))
                                {
                                    ?>
                                        <tr>
                                            <td><?php echo strtoupper($data['district']); ?></td>
                                            <?php
                                                $sql1 = "SELECT details.d_said FROM details INNER JOIN post_apply ON post_apply.said=details.d_said WHERE post_apply.city_prefer = '$data[id]' AND details.d_status = 'Approved'  AND details.d_postid IN (9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24)";
                                                $exe1 = mysqli_query($conn, $sql1);
                                                $rows = mysqli_num_rows($exe1);
                                            ?>
                                            <td><?php echo $rows; ?></td>
                                        </tr>
                                    <?php
                                    $total = $total + $rows;
                                }  
                            ?>
                            <tr>
                                <td>Total</td>
                                <td><?php echo $total; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
else{header("Location: index.php");
}

?>