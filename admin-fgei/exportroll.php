<?php
include('../connection/conn.php');

// Increase PHP limits to handle large data
set_time_limit(300); // 5 minutes
ini_set('memory_limit', '512M'); // Increase memory limit

// List of center IDs
$centerIds = [86, 87, 88, 89, 90, 91, 92, 94, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 123, 124, 127, 128, 129, 130, 131, 132, 133];

if (isset($_POST['exceldata'])) {
    $center = $_POST['center'] ?? 'Unknown Center';

    // Set headers for CSV download (single file for all centers)
    header('Content-Type: text/csv; charset=UTF-8');
    header('Content-Disposition: attachment; filename="roll_numbers_all_centers.csv"');

    // Open output stream to write CSV directly to the browser
    $output = fopen('php://output', 'w');

    // Write CSV headers with Center ID column
    fputcsv($output, [
        'Center ID',
        'Full Name',
        'Father Name',
        'CNIC',
        'Roll Number',
        'Contact No',
        'Gender',
        'Married',
        'Religion',
        'Email',
        'Date of Birth',
        'Domicile',
        'District',
        'Postal Address',
        'Permanent Address',
        'Scheduled Caste Relaxation',
        'Retired Relaxation',
        'Disabled Relaxation',
        'Widow Relaxation',
        'Government Employee',
        'Highest Qualification',
        'Written Test Marks'
    ]);

    // Loop through each center ID
    foreach ($centerIds as $cid) {
        // Prepare the SQL statement for the current center ID
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
                    details.d_rollno,
                    qualification.primary_title, 
                    qualification.matric_title,
                    qualification.inter_title, 
                    qualification.bs_title, 
                    qualification.bs16_title, 
                    qualification.ms_title,
                    post_apply.relax_schedule_caste,
                    post_apply.relax_retired,
                    post_apply.relax_disable,
                    post_apply.relax_widow,
                    post_apply.gov,
                    leatest_result.marks
                FROM details 
                INNER JOIN per_info ON per_info.said = details.d_said 
                INNER JOIN post_apply ON per_info.said = post_apply.said
                LEFT JOIN qualification ON per_info.said = qualification.said
                LEFT JOIN leatest_result ON leatest_result.roll_no = details.d_rollno
                WHERE post_apply.post_apply = 48 AND details.d_centerid = ?");

        if ($stmt === false) {
            die("Prepare failed for CID $cid: " . $conn->error);
        }

        $stmt->bind_param("i", $cid);

        if (!$stmt->execute()) {
            die("Execute failed for CID $cid: " . $stmt->error);
        }

        $result = $stmt->get_result();
        if ($result === false) {
            die("Result fetch failed for CID $cid: " . $stmt->error);
        }

        // Process data and write to CSV
        while ($row = $result->fetch_assoc()) {
            // Determine highest qualification
            $qualifications = [
                $row['primary_title'], 
                $row['ms_title'], 
                $row['bs16_title']
            ];
            $qualifications = array_filter($qualifications, function ($value) {
                return !empty(trim($value)) && strtoupper(trim($value)) !== 'NULL';
            });
            
            $highest_qualification = !empty($qualifications) ? max($qualifications) : 'No Qualification';

            // Fetch qualification name using prepared statement
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            if ($stmt_qual === false) {
                $qName = 'No Qualification Found';
            } else {
                $stmt_qual->bind_param("s", $highest_qualification);
                $stmt_qual->execute();
                $result_qual = $stmt_qual->get_result();
                $qName = $result_qual && $result_qual->num_rows > 0 ? $result_qual->fetch_assoc()['qualification_category'] : 'No Qualification Found';
                $stmt_qual->close();
            }

            // Convert relaxation fields to Yes/No
            $schedule_caste = ($row['relax_schedule_caste'] == 1) ? 'Yes' : 'No';
            $retired = ($row['relax_retired'] == 1) ? 'Yes' : 'No';
            $disable = ($row['relax_disable'] == 1) ? 'Yes' : 'No';
            $widow = ($row['relax_widow'] == 1) ? 'Yes' : 'No';
            $gov = ($row['gov'] == 1) ? 'Yes' : 'No';

            // Get domicile name
            $domicile_map = [
                1 => "Punjab", 2 => "KPK", 3 => "Balochistan", 4 => "Sindh(Urban)", 
                5 => "Sindh(Rural)", 6 => "AJK", 7 => "FATA", 8 => "GB"
            ];
            $domicile = $domicile_map[$row['basic_domicile']] ?? 'Unknown';

            // Write row to CSV with center ID
            fputcsv($output, [
                
                $cid,
                $row['basic_full_name'],
                $row['basic_father_name'],
                $row['contact_cnic'],
                $row['d_rollno'],
                $row['contact_mobile'],
                $row['basic_gender'],
                $row['basic_marital_status'],
                $row['contact_religion'],
                $row['contact_email'],
                $row['basic_dob'],
                $domicile,
                $row['contact_district'],
                $row['contact_postal_address'],
                $row['contact_per_address'],
                $schedule_caste,
                $retired,
                $disable,
                $widow,
                $gov,
                $qName,
                $row['marks'] ?? 'N/A'
            ]);
        }

        $stmt->close();
    }

    // Clean up
    fclose($output);
    $conn->close();
    
    exit();
}
?>