<?php
include('../connection/conn.php');

// Step 1: Fetch records
$query = "SELECT details.id, per_info.undertaking, details.d_said , details.d_status,details.d_rollno FROM details 
INNER JOIN per_info ON details.d_said = per_info.said WHERE details.d_postid = 48 AND per_info.undertaking = 1 AND
details.d_rollno IS NULL AND d_status='Pending' ORDER BY details.id ASC LIMIT 3000;
        ";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching records: " . mysqli_error($conn));
}

if (mysqli_num_rows($result) > 0) {
    // Step 2: Update d_rollno, d_status, and act_by with incrementing values
    $rollno = 27900; // Starting number
    $rowsUpdated = 0; // Counter for updated rows

    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $newRollNo = "ETM-" . $rollno++;

        // Update query
        $updateQuery = "UPDATE details 
                        SET d_rollno = ?, d_status = 'Approved', act_by = 'IT5' 
                        WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateQuery);

        if (!$stmt) {
            die("Error preparing update statement: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, "si", $newRollNo, $id);

        if (mysqli_stmt_execute($stmt)) {
            $rowsUpdated++; // Increment the counter if the update is successful
        } else {
            die("Error updating record: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    }

    echo "Roll numbers updated successfully! Total rows updated: " . $rowsUpdated;
} else {
    echo "No records found to update.";
}

mysqli_close($conn);
?>