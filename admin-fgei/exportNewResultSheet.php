<?php
include('../connection/conn.php');

if (isset($_POST['exceldata'])) {
    $cid = $_POST['pid'];
    $center = $_POST['center'];

    // Use prepared statements for security
$stmt = $conn->prepare("SELECT 
                per_info.basic_full_name,
                per_info.basic_father_name,
                per_info.contact_cnic,
                per_info.contact_mobile,
                per_info.basic_gender,
                per_info.basic_marital_status,
                per_info.contact_religion,
                per_info.contact_postal_address,
                per_info.contact_per_address,
                per_info.contact_email,
                per_info.basic_dob,
                per_info.contact_district,
                per_info.basic_domicile,
                post_apply.relax_schedule_caste,
                post_apply.relax_retired,
                post_apply.relax_disable,
                post_apply.relax_widow,
                post_apply.gov,
                details.d_rollno,
                qualification.primary_title,
                qualification.matric_title,
                qualification.inter_title,
                qualification.bs_title,
                qualification.bs16_title,
                qualification.ms_title,
                leatest_result.marks
            FROM details 
            INNER JOIN per_info ON per_info.said = details.d_said
            INNER JOIN post_apply ON per_info.said = post_apply.said
            LEFT JOIN qualification ON per_info.said = qualification.said
            LEFT JOIN leatest_result ON leatest_result.roll_no = details.d_rollno
            Where post_apply.post_apply=48 AND details.d_centerid = ?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();
    // Set headers for Excel Download
    header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=roll_numbers.xls");

    // Prepare Output
    echo "<h4>List of all Roll Numbers in " . htmlspecialchars($center) . "</h4><br>";
    echo "<table border='1'>
        <tr>
            <th>Full Name</th>
            <th>Father Name</th>
            <th>CNIC</th>
            <th>Roll Number</th>
            <th>Contact No</th>
            <th>Gender</th>
            <th>Married</th>
            <th>Religion</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Domicile</th>
            <th>District</th>
            <th>Postal Address</th>
            <th>Permanent Address</th>
            <th>Scheduled Caste Relaxation</th>
            <th>Retired Relaxation</th>
            <th>Disabled Relaxation</th>
            <th>Widow Relaxation</th>
            <th>Government Employee</th>
            <th>Highest Qualification</th>
            <th>Written Test Marks</th>
        </tr>";

    // Process Data
while ($row = $result->fetch_assoc()) {
    // ... [previous code for qualifications and domicile remains the same] ...
       // ✅ Determine highest qualification
        $qualifications = [
            $row['primary_title'], $row['ms_title'], $row['bs16_title'], 
        ];
        $qualifications = array_filter($qualifications, function ($value) {
    return !empty(trim($value)) && strtoupper(trim($value)) !== 'NULL';
});

        $highest_qualification = !empty($qualifications) ? max($qualifications) : 'No Qualification';
        
        $qualification = "SELECT qualification_category FROM qualification_category WHERE id = '$highest_qualification'";
$qualification_query = mysqli_query($conn, $qualification);
                                    
if ($qualification_query && mysqli_num_rows($qualification_query) > 0) {
    $qName = mysqli_fetch_assoc($qualification_query)['qualification_category'];
} else {
    $qName = 'No Qualification Found';
}

    // Convert relaxation fields to Yes/No
    $schedule_caste = ($row['relax_schedule_caste'] == 1) ? 'Yes' : 'No';
    $retired = ($row['relax_retired'] == 1) ? 'Yes' : 'No';
    $disable = ($row['relax_disable'] == 1) ? 'Yes' : 'No';
    $widow = ($row['relax_widow'] == 1) ? 'Yes' : 'No';
    $gov = ($row['gov'] == 1) ? 'Yes' : 'No';


 // ✅ Get domicile name
        $domicile_map = [
            1 => "Punjab", 2 => "KPK", 3 => "Balochistan", 4 => "Sindh(Urban)", 
            5 => "Sindh(Rural)", 6 => "AJK", 7 => "FATA", 8 => "GB"
        ];
        $domicile = $domicile_map[$row['basic_domicile']] ?? 'Unknown';


    echo "<tr>
            <td>" . htmlspecialchars($row['basic_full_name']) . "</td>
            <td>" . htmlspecialchars($row['basic_father_name']) . "</td>
            <td>" . htmlspecialchars($row['contact_cnic']) . "</td>
            <td>" . htmlspecialchars($row['d_rollno']) . "</td>
            <td>" . htmlspecialchars($row['contact_mobile']) . "</td>
            <td>" . htmlspecialchars($row['basic_gender']) . "</td>
            <td>" . htmlspecialchars($row['basic_marital_status']) . "</td>
            <td>" . htmlspecialchars($row['contact_religion']) . "</td>
            <td>" . htmlspecialchars($row['contact_email']) . "</td>
            <td>" . htmlspecialchars($row['basic_dob']) . "</td>
            <td>" . htmlspecialchars($domicile) . "</td>
            <td>" . htmlspecialchars($row['contact_district']) . "</td>
            <td>" . htmlspecialchars($row['contact_postal_address']) . "</td>
            <td>" . htmlspecialchars($row['contact_per_address']) . "</td>
            <td>" . htmlspecialchars($schedule_caste) . "</td>
            <td>" . htmlspecialchars($retired) . "</td>
            <td>" . htmlspecialchars($disable) . "</td>
            <td>" . htmlspecialchars($widow) . "</td>
            <td>" . htmlspecialchars($gov) . "</td>
            <td>" . htmlspecialchars($qName) . "</td>
            <td>" . htmlspecialchars($row['marks'] ?? 'N/A') . "</td>
          </tr>";
}
    echo "</table>";
    
    // Clean up
    $stmt->close();
    $stmt_qual->close();
    $conn->close();
    
    exit();
}
?>