<?php
include('../connection/conn.php');
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    
// Debug: Check for headers already sent
if (headers_sent($file, $line)) {
    error_log("Headers already sent in $file on line $line");
    exit("Headers already sent error.");
}

// Set memory and time limits for large data
ini_set('memory_limit', '2048M');  // Increase if needed
set_time_limit(0);

// Set headers for CSV download (simple and standard)
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=female_approved_candidates.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Debug: Log headers
if (headers_list()) {
    error_log("Headers set: " . implode(", ", headers_list()));
}

// Disable output buffering and open output stream
ob_implicit_flush(true);
ob_end_clean();
$handle = fopen('php://output', 'w');

// Write CSV column headers
fputcsv($handle, [
    'Sr#', 'Candidate Name', 'Father Name', 'CNIC', 'Roll No', 'Gender', 'Married', 
    'Religion', 'Contact', 'Email', 'Date of Birth', 'Domicile', 
    'Postal Address', 'Permanent Address', 'Result'
]);

// Get post ID safely
$postid = isset($_GET['postid']) ? (int)$_GET['postid'] : 50;

// Optimize batch size for streaming large datasets
$limit = 100;  // Reduced batch size for stability with large datasets
$offset = 0;
$sr = 0;

// Prepare statement to prevent SQL injection
$sql = "SELECT 
    per_info.basic_full_name, 
    per_info.basic_father_name, 
    per_info.contact_cnic, 
    per_info.basic_gender, 
    per_info.basic_marital_status, 
    per_info.contact_religion, 
    per_info.contact_phone_no, 
    per_info.contact_email, 
    per_info.basic_dob, 
    per_info.contact_district,
    per_info.contact_postal_address, 
    per_info.contact_per_address,
    details.d_rollno, 
    results.marks,
    GREATEST(
        COALESCE(NULLIF(qualification.bs16_title, ''), NULLIF(qualification.bs16_title, 'NULL'), 'No Qualification'), 
        COALESCE(NULLIF(qualification.ms_title, ''), NULLIF(qualification.ms_title, 'NULL'), 'No Qualification'),
        COALESCE(NULLIF(qualification.primary_title, ''), NULLIF(qualification.primary_title, 'NULL'), 'No Qualification')
    ) AS highest_qualification
FROM post_apply
INNER JOIN details ON post_apply.said = details.d_said 
INNER JOIN per_info ON post_apply.said = per_info.said
INNER JOIN results ON results.roll_no = details.d_rollno
INNER JOIN qualification ON qualification.said = per_info.said
WHERE post_apply.post_apply = ? 
AND details.d_postid = ? 
AND per_info.undertaking = 1 
AND details.d_status = 'Approved'
ORDER BY per_info.said
LIMIT ? OFFSET ?";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);
if (!$stmt) {
    error_log("Prepare failed: " . mysqli_error($conn));
    fclose($handle);
    exit("Database preparation error occurred: " . mysqli_error($conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, "iiii", $postid, $postid, $limit, $offset);

do {
    // Execute prepared statement
    if (!mysqli_stmt_execute($stmt)) {
        error_log("Execute failed: " . mysqli_stmt_error($stmt));
        fclose($handle);
        exit("Query execution error: " . mysqli_stmt_error($stmt));
    }

    $result = mysqli_stmt_get_result($stmt);
    $rowsFetched = 0;

    // Fetch and write rows
    while ($row = mysqli_fetch_assoc($result)) {
        $sr++;
        fputcsv($handle, [
            $sr,
            $row['basic_full_name'],
            $row['basic_father_name'],
            $row['contact_cnic'],
            $row['d_rollno'],
            $row['basic_gender'],
            $row['basic_marital_status'],
            $row['contact_religion'],
            $row['contact_phone_no'],
            $row['contact_email'],
            $row['basic_dob'],
            $row['contact_district'],
            $row['contact_postal_address'],
            $row['contact_per_address'],
            $row['highest_qualification'],
            $row['marks']
        ]);
        $rowsFetched++;

        // Flush frequently to prevent buffering issues with large datasets
        if ($sr % 50 == 0) {
            error_log("Processed $sr rows...");
            ob_flush();
            flush();
        }
    }

    // Free result memory
    mysqli_free_result($result);
    $offset += $limit;
    
    // Update offset in prepared statement
    mysqli_stmt_close($stmt);
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iiii", $postid, $postid, $limit, $offset);

} while ($rowsFetched > 0);

// Cleanup
fclose($handle);
mysqli_stmt_close($stmt);
mysqli_close($conn);

// Shutdown function to catch any fatal errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error) {
        error_log("Script terminated with error: " . print_r($error, true));
    }
});
}
exit;
?>