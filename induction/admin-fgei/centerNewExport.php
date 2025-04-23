<?php
ob_start();
include('../connection/conn.php');

if (!isset($_SESSION)) { 
    session_start(); 
}

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    $user = $_SESSION['user_name'];
    $userid = $_SESSION['user_access'];

    $arr = explode(' ', trim($user));
    $newuser = ucfirst("$arr[0]");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Reports</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>
</head>

<body>
<?php 
    include('header.php');
    include('reportnav.php');
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-4 main">
    <div class="row">
        <div class="col-lg-12" align="center">
            <h3 style="color: green;">Center Report</h3>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12" align="center">
            <h4>Select a Center to Export</h4>
            <div class="row">
                <?php
                // Fetch all centers from the centers table
                $query = "SELECT * FROM `centes`";
                $result = mysqli_query($conn, $query);
                $rowCount = mysqli_num_rows($result);

                if ($rowCount > 0) {
                    while ($row = mysqli_fetch_array($result)) {
                        $centerId = $row['id'];
                        $centerName = $row['center'];
                ?>
                        <div class="col-lg-4" style="margin-bottom: 10px;">
                            <form method="post" action="exportNewResultSheet.php">
                                <input type="hidden" value="<?php echo $centerId; ?>" name="pid">
                                <input type="hidden" value="<?php echo htmlspecialchars($centerName); ?>" name="center">
                                <button type="submit" class="btn btn-success btn-block" name="exceldata">
                                    <?php echo htmlspecialchars($centerName); ?>
                                </button>
                            </form>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No centers found.</p>";
                }
                ?>
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
} else {
    header("Location: index.php");
}
ob_flush();
?>