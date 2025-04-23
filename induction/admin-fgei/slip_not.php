<?php
// Assuming you have already connected to the database using $conn
include('../connection/conn.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    
// SQL query to get the list of applicants who did not download their slip
$sql = "
    SELECT per_info.said, per_info.basic_full_name, per_info.basic_father_name, per_info.basic_domicile, 
           per_info.contact_phone_no, details.d_postid, per_info.contact_mobile, per_info.contact_cnic, 
           per_info.contact_postal_address, details.d_status, details.d_rollno, details.d_centerid
    FROM per_info 
    INNER JOIN details ON per_info.said = details.d_said 
    LEFT JOIN download_logs ON per_info.said = download_logs.user_id 
    WHERE download_logs.user_id IS NULL 
      AND details.d_status = 'Approved' 
      AND details.d_postid NOT IN (25, 39, 28, 29, 34, 31, 33, 36, 38)
";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    // Start of the HTML table
    echo '<table border="1">';
    echo '<tr>';
    echo '<th>Sno</th>';
    echo '<th>SAID</th>';
    echo '<th>Full Name</th>';
    echo '<th>Father Name</th>';
    echo '<th>Domicile</th>';
    echo '<th>Phone No</th>';
    echo '<th>Mobile</th>';
    echo '<th>CNIC</th>';
    echo '<th>Post Name</th>'; // Changed from 'Post ID' to 'Post Name'
    echo '<th>Postal Address</th>';
    echo '<th>Status</th>';
    echo '<th>Roll No</th>';
    echo '<th>Center</th>'; // Changed from 'Center ID' to 'Center'
    echo '</tr>';

    // Initialize the serial number counter
    $sno = 1;

    // Fetch and display the results
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $sno++ . '</td>'; // Increment the serial number
        echo '<td>' . htmlspecialchars($row['said'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['basic_full_name'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['basic_father_name'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['basic_domicile'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['contact_phone_no'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['contact_mobile'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['contact_cnic'] ?? '') . '</td>';

        // Fetch the post name
        $postid = (int)$row['d_postid']; // Ensure postid is an integer
        $query2 = "SELECT name FROM posts WHERE pid = $postid";
        $result2 = mysqli_query($conn, $query2);
        $post = mysqli_fetch_assoc($result2);

        // Display the post name, or an empty string if not found
        echo '<td>' . htmlspecialchars($post['name'] ?? '') . '</td>';

        echo '<td>' . htmlspecialchars($row['contact_postal_address'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['d_status'] ?? '') . '</td>';
        echo '<td>' . htmlspecialchars($row['d_rollno'] ?? '') . '</td>';

        // Fetch the center name
        $center = (int)$row['d_centerid']; // Ensure center is an integer
        $query3 = "SELECT center FROM centes WHERE id = $center"; // Changed from 'centes' to 'centers'
        $result3 = mysqli_query($conn, $query3);
        $centerData = mysqli_fetch_assoc($result3);

        // Display the center name, or an empty string if not found
        echo '<td>' . htmlspecialchars($centerData['center'] ?? '') . '</td>';
        echo '</tr>';
    }

    // End of the HTML table
    echo '</table>';
} else {
    echo 'No results found.';
}
}
else
{
    echo 'No Access';
}
// Close the database connection
mysqli_close($conn);
?>

