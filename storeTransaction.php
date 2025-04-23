<?php
include('connection/conn.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $said = trim($_POST['said']);
    $type = trim($_POST['type']);
    $no = trim($_POST['no']);

    // Validate the form data
    if (empty($said) || empty($type) || empty($no)) {
        echo "All fields are required!";
        exit;
    }

    // Prepare and check if the record already exists
    $query = "SELECT * FROM `fee_detial` WHERE s_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $said);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $updateQuery = "UPDATE `fee_detial` SET type = ?, no = ? WHERE s_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("sss", $type, $no, $said);

        if ($updateStmt->execute()) {
            header("Location: documents.php");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // Insert new record
        $insertQuery = "INSERT INTO `fee_detial` (s_id, type, no) VALUES (?, ?, ?)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bind_param("sss", $said, $type, $no);

        if ($insertStmt->execute()) {
            header("Location: documents.php");
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }

    // Close the prepared statement and connection
    $stmt->close();
    $conn->close();
} else {
    header("Location: index.php");
    exit;
}
