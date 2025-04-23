<?php

$servername = "210.56.13.236";  // or use 127.0.0.1
$username = "fgeigov_induction";
$password = "}!NmKab+CTjc-aNoHU";
$dbname = "fgeigov_induction";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
try {
   session_destroy();
   echo 'Session Flush';

} catch (Exception $e) {
    error_log("Error killing idle connections: " . $e->getMessage());
    echo "Error killing idle connections: " . $e->getMessage();
}


?>