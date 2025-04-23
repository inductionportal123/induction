<?php
$servername = "localhost";  // or use 127.0.0.1
$username = "tstind_tstind_newinduction";
$password = "newinduction!#%$@#$1234";
$dbname = "tstind_newinduction";

try {
    // Enable exception mode for mysqli
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Query to get the current database name
    $result = $conn->query("SELECT DATABASE() AS db_name");
    $row = $result->fetch_assoc();
    $current_db = $row['db_name'];

    // Output the connected database
    echo "Successfully connected to database: " . $current_db;

    // Close the connection
    $conn->close();

} catch (Exception $e) {
    // Catch the exception and display the error message
    echo "Connection error: " . $e->getMessage();
}
?>