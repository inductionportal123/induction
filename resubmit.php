<?php
// Include the database connection
include('connection/conn.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the submitted data
    $userid = $_POST['userid'];
    $appliedpost = $_POST['appliedpost'];

    // Sanitize the input data to prevent SQL injection
    $userid = mysqli_real_escape_string($conn, $userid);
    $appliedpost = mysqli_real_escape_string($conn, $appliedpost);

    // Construct the SQL query to update `details` table
    $query_details = "UPDATE `details` SET d_rollno=NULL, d_status='Pending', d_feedback=NULL, revert=0 WHERE d_postid='$appliedpost' AND d_said='$userid'";

    // Execute the details update query
    if (mysqli_query($conn, $query_details)) {
        // Success message for details update
        header("Location: per_info.php");
        echo "Form resubmitted successfully.";
    } else {
        // Error message for details update
        echo "Error updating details: " . mysqli_error($conn);
    }

    // Construct the SQL query to update `per_info` table
    $query_per_info = "UPDATE `per_info` SET undertaking=0 WHERE said='$userid'";

    // Execute the per_info update query
    if (mysqli_query($conn, $query_per_info)) {
        // Success message for per_info update
        header("Location: per_info.php");
exit;
    } else {
        // Error message for per_info update
        echo "Error updating per_info: " . mysqli_error($conn);
    }

} else {
    // Handle the case where the form is not submitted
    echo "Invalid request.";
}

// Close the database connection
mysqli_close($conn);
?>
