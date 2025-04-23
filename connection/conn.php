<?php
$servername = "localhost";  // or use 127.0.0.1
$username = "tstind_induction_25";
$password = "@#%$@#@#%$12345";
$dbname = "tstind_induction_25aasdfasdfsdfsd";

try {
    // Enable exception mode for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    

} catch (Exception $e) {
    // Catch the exception and display the error message
    echo "Connection error: " . $e->getMessage();
}
?>
