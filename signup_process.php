<?php
// Prevent any unwanted output

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ob_start();
include('connection/conn.php');

// Check if POST variables are set
$name = isset($_POST['fname']) ? mysqli_real_escape_string($conn, $_POST['fname']) : '';
$email = isset($_POST['mail']) ? mysqli_real_escape_string($conn, $_POST['mail']) : '';
$c_no = isset($_POST['cnic']) ? mysqli_real_escape_string($conn, $_POST['cnic']) : '';
$p_no = isset($_POST['pass']) ? mysqli_real_escape_string($conn, $_POST['pass']) : '';
echo $name;
// Validate inputs
if (empty($name) || empty($email) || empty($c_no) || empty($p_no)) {
    ob_end_clean();
    mysqli_close($conn);
    echo 3; // Empty fields
    exit;
}

// Check if CNIC already exists
$query = "SELECT cnic FROM `acount_details` WHERE cnic = '$c_no'";
$exe = mysqli_query($conn, $query);

if (!$exe) {
    ob_end_clean();
    error_log("SELECT query failed: " . mysqli_error($conn));
    mysqli_close($conn);
    echo 4; // Database error
    exit;
}

$rowcount = mysqli_num_rows($exe);

if ($rowcount >= 1) {
    ob_end_clean();
    mysqli_close($conn);
    echo 0; // CNIC already exists
    exit;
}

// Insert new user
$query1 = "INSERT INTO `acount_details` (`name`, `email`, `cnic`, `password`) VALUES ('$name', '$email', '$c_no', '$p_no')";
$exe1 = mysqli_query($conn, $query1);

if ($exe1) {
    ob_end_clean();
    mysqli_close($conn);
    echo 1; // Success
} else {
    ob_end_clean();
    error_log("INSERT failed: " . mysqli_error($conn));
    mysqli_close($conn);
    echo 2; // Insert failed
}

mysqli_close($conn);
ob_end_clean();
?>