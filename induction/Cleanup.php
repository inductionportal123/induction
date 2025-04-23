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

    $result = $conn->query("SELECT id FROM information_schema.PROCESSLIST WHERE Command = 'Sleep';");


    if ($result->num_rows == 0) {
        error_log("No Auto generated idle connections found in Induction.");
        echo "No idle Auto generated connections found in Induction.";
    } else {
        while ($row = $result->fetch_assoc()) {
            $connection_id = $row['id'];

   
            if ($conn->query("KILL {$connection_id};")) {
                error_log("Killed Auto generated Connection ID: {$connection_id}");
                echo "Killed Auto generated Connection ID: {$connection_id}";
            } else {
                error_log("Failed to kill connection ID: {$connection_id}");
                echo "Failed to kill connection ID: {$connection_id}";
            }
        }
    }

    error_log("Auto generated Idle connection cleanup completed.");
    echo "Idle connection cleanup completed.";

} catch (Exception $e) {
    error_log("Error killing idle connections: " . $e->getMessage());
    echo "Error killing idle connections: " . $e->getMessage();
}

$conn->close();
?>
