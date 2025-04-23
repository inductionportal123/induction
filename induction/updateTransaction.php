<?php
// Include your database connection
include('connection/conn.php');

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['u_name'], $_SESSION['u_id']))
{
  $user = $_SESSION['u_name'];
  $userid = $_SESSION['u_id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $type = trim($_POST['type']);
    $no = trim($_POST['transaction_id']);
    
    // Validate the form data
    if (empty($userid) || empty($type) || empty($no)) {
        echo "All fields are required!";
        exit;
    }

    // Prepare the SQL query to update the transaction
    $query = "UPDATE `fee_detial` SET type = ?, no = ? WHERE s_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $type, $no, $userid);

    // Execute the query
    if ($stmt->execute()) {
        // If successful, redirect to documents page
        header("Location: documents.php");
        exit;  // Exit after redirect
    } else {
        // If error occurs, show error message
        echo "Error updating record: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
    // Close the database connection
    $conn->close();
} else {
    // If the request is not POST, redirect to the index page
    header("Location: index.php");
    exit;
}



}
else{
  header("Location: index.php");
}
?>


