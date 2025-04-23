<?php
include('../connection/conn.php');

// Check if the POST request contains the employee_id
if (isset($_POST["employee_id"])) {
    $id = $_POST["employee_id"];
    $output = '';

    // Add custom CSS for styling
    $output .= '
    <style>
        /* General container styling */
        .profile-container {
            font-family: Arial, sans-serif;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Section headings */
        .section-heading {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }

        /* Row styling */
        .profile-row {
            display: flex;
            flex-wrap: wrap;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            align-items: center;
        }

        /* Label and value styling */
        .profile-label {
            flex: 1 1 40%;
            font-weight: bold;
            color: #555;
            padding: 5px;
        }

        .profile-value {
            flex: 1 1 60%;
            color: #333;
            padding: 5px;
        }

        /* Qualification and Work Experience table styling */
        .qualification-table, .work-experience-table, .professional-table {
            display: flex;
            flex-wrap: wrap;
            padding: 10px 0;
            background-color: #fff;
            border-radius: 5px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .qualification-table div, .work-experience-table div, .professional-table div {
            flex: 1 1 25%;
            padding: 10px;
            border-right: 1px solid #eee;
        }

        .qualification-table div:last-child, .work-experience-table div:last-child, .professional-table div:last-child {
            border-right: none;
        }

        .qualification-table .header, .work-experience-table .header, .professional-table .header {
            font-weight: bold;
            background-color: #007bff;
            color: #fff;
            border-radius: 5px 5px 0 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .profile-label, .profile-value {
                flex: 1 1 100%;
            }

            .qualification-table div, .work-experience-table div, .professional-table div {
                flex: 1 1 50%;
            }
        }

        @media (max-width: 480px) {
            .qualification-table div, .work-experience-table div, .professional-table div {
                flex: 1 1 100%;
            }
        }

        /* Highlight "Yes" for age relaxation */
        .highlight-yes {
            color: #28a745;
            font-weight: bold;
        }
    </style>';

    // Use prepared statements to prevent SQL injection and join the new tables
    $stmt = $conn->prepare("SELECT 
        pi.basic_full_name, pi.basic_father_name, pi.basic_gender, pi.basic_dob, 
        pi.basic_domicile, pi.said, pi.undertaking,
        pic.contact_email, pic.contact_mobile, pic.contact_district, pic.contact_religion,
        pis.female_applying, pis.female_husband, pis.female_husband_province, pis.female_husband_district,
        q.primary_title, q.primary_specialization, q.primary_total_marks, q.primary_board,
        q.middle_title, q.middle_specialization, q.middle_total_marks, q.middle_board,
        q.matric_title, q.matric_specialization, q.matric_result_date, q.matric_obtained_marks, 
        q.matric_total_marks, q.matric_percent, q.matric_board, 
        q.inter_title, q.inter_specialization, q.inter_result_date, q.inter_obtained_marks, 
        q.inter_total_marks, q.inter_percent, q.inter_board, 
        pa.relax_schedule_caste, pa.relax_retired, pa.relax_disable, pa.relax_widow, pa.gov, 
        q.bs_title, q.bs_specialization, q.bs_result_date, q.bs_obtained_marks, q.bs_total_marks, 
        q.bs_percent, q.bs_board, 
        q.bs16_title, q.bs16_specialization, q.bs16_obtained_marks, q.bs16_total_marks, q.bs16_board,
        q.ms_title, q.ms_specialization, q.ms_result_date, q.ms_obtained_marks, q.ms_total_marks, 
        q.ms_percent, q.ms_board, 
        q.diploma_title, q.diploma_specialization, q.diploma_result, q.diploma_obtained_marks, 
        q.diploma_total_marks, q.diploma_percent, q.diploma_board, 
        q.profes_certificate, q.profes_result_date, q.profes_obtained_marks, q.profes_total_marks, q.profes_board, 
        q.profes_certificate_two, q.profes_result_date_two, q.profes_obtained_marks_two, q.profes_total_marks_two, q.profes_board_two, 
        q.profes_certificate_three, q.profes_result_date_three, q.profes_obtained_marks_three, q.profes_total_marks_three, q.profes_board_three, 
        q.employ_organization, q.employ_job_title, q.employ_from_date, q.employ_to_date, 
        q.employ_organization_two, q.employ_job_title_two, q.employ_from_date_two, q.employ_to_date_two, 
        q.employ_organizatin_three, q.employ_job_title_three, q.employ_from_date_three, q.employ_to_date_three, 
        fd.type, fd.no 
    FROM `per_info` pi 
    LEFT JOIN per_info_contact pic ON pic.said = pi.said 
    LEFT JOIN per_info_spouse pis ON pis.said = pi.said 
    INNER JOIN qualification q ON q.said = pi.said 
    INNER JOIN fee_detial fd ON fd.s_id = pi.said 
    INNER JOIN post_apply pa ON pa.said = pi.said 
    WHERE pi.said = ?");
    
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $rows11 = $result->fetch_assoc();

        // Format Date of Birth
        $dob = $rows11["basic_dob"];
        if (!empty($dob)) {
            $date = new DateTime($dob);
            $formattedDate = $date->format('d-m-Y');
        } else {
            $formattedDate = 'Not Provided';
        }

        // Start building the output with a container
        $output .= '<div class="profile-container">';

        // Personal Information Section
        $output .= '<h5 class="section-heading">Personal Information</h5>';

        $output .= '
        <div class="profile-row">
            <div class="profile-label">Name</div>
            <div class="profile-value">' . htmlspecialchars($rows11["basic_full_name"] ?? 'Not Provided') . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Father Name</div>
            <div class="profile-value">' . htmlspecialchars($rows11["basic_father_name"] ?? 'Not Provided') . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Gender</div>
            <div class="profile-value">' . htmlspecialchars(ucfirst($rows11["basic_gender"] ?? 'Not Provided')) . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Email</div>
            <div class="profile-value">' . htmlspecialchars($rows11["contact_email"] ?? 'Not Provided') . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Transaction Type</div>
            <div class="profile-value">' . htmlspecialchars($rows11["type"] ?? 'Not Provided') . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Account No/SEQ No:</div>
            <div class="profile-value">' . htmlspecialchars($rows11["no"] ?? 'Not Provided') . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Date of Birth</div>
            <div class="profile-value">' . htmlspecialchars($formattedDate) . '</div>
        </div>';

        // Domicile mapping
        $domicile_map = [
            1 => "Punjab",
            2 => "KPK",
            3 => "Balochistan",
            4 => "Sindh(Urban)",
            5 => "Sindh(Rural)",
            6 => "AJK",
            7 => "FATA",
            8 => "Gilgit Baltistan"
        ];
        $dom = $domicile_map[$rows11["basic_domicile"]] ?? 'Not Provided';

        // Husband's Domicile mapping
        $dom1 = $domicile_map[$rows11["female_husband_province"]] ?? 'Not Provided';

        // Female applying status
        $female_app = ($rows11["female_applying"] == 1) ? 'Yes' : (($rows11["female_applying"] == 0) ? 'No' : 'Not Provided');

        // Continue Personal Information
        $output .= '
        <div class="profile-row">
            <div class="profile-label">Domicile</div>
            <div class="profile-value">' . htmlspecialchars($dom) . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Contact Mobile</div>
            <div class="profile-value">' . htmlspecialchars($rows11["contact_mobile"] ?? 'Not Provided') . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">District</div>
            <div class="profile-value">' . htmlspecialchars($rows11["contact_district"] ?? 'Not Provided') . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Religion</div>
            <div class="profile-value">' . htmlspecialchars(ucfirst($rows11["contact_religion"] ?? 'Not Provided')) . '</div>
        </div>

        <div class="profile-row">
            <div class="profile-label">Applying against spouse\'s domicile</div>
            <div class="profile-value">' . htmlspecialchars($female_app) . '</div>
        </div>';

        // Spouse Details
        if ($rows11["female_applying"] == '1') {
            if ($rows11["female_husband"] != 'NULL' && !empty($rows11["female_husband"])) {
                $output .= '
                <div class="profile-row">
                    <div class="profile-label">Spouse\'s Name</div>
                    <div class="profile-value">' . htmlspecialchars($rows11["female_husband"]) . '</div>
                </div>';
            }

            if ($rows11["female_husband_province"] != 'NULL' && !empty($rows11["female_husband_province"])) {
                $output .= '
                <div class="profile-row">
                    <div class="profile-label">Spouse\'s Province</div>
                    <div class="profile-value">' . htmlspecialchars($dom1) . '</div>
                </div>';
            }

            if ($rows11["female_husband_district"] != 'NULL' && !empty($rows11["female_husband_district"])) {
                $output .= '
                <div class="profile-row">
                    <div class="profile-label">Spouse\'s District</div>
                    <div class="profile-value">' . htmlspecialchars($rows11["female_husband_district"]) . '</div>
                </div>';
            }
        }

        // Age Relaxation Claims
        $output .= '<h5 class="section-heading">Age Relaxation Claims</h5>';

        if ($rows11['relax_schedule_caste'] == '1') {
            $output .= '
            <div class="profile-row">
                <div class="profile-label">Caste Age Relaxation?</div>
                <div class="profile-value"><span class="highlight-yes">Yes</span></div>
            </div>';
        }

        if ($rows11['relax_retired'] == '1') {
            $output .= '
            <div class="profile-row">
                <div class="profile-label">Released or Retired Officer Personnel of the Armed Forces of Pakistan</div>
                <div class="profile-value"><span class="highlight-yes">Yes</span></div>
            </div>';
        }

        if ($rows11['relax_disable'] == '1') {
            $output .= '
            <div class="profile-row">
                <div class="profile-label">Disabled Person (Nature of Disability must be mentioned)</div>
                <div class="profile-value"><span class="highlight-yes">Yes</span></div>
            </div>';
        }

        if ($rows11['relax_widow'] == '1') {
            $output .= '
            <div class="profile-row">
                <div class="profile-label">Widow/Widower or Child of Govt Servant died during Service (on or after 01-07-2005)</div>
                <div class="profile-value"><span class="highlight-yes">Yes</span></div>
            </div>';
        }

        if ($rows11['gov'] == '1') {
            $output .= '
            <div class="profile-row">
                <div class="profile-label">Government Employee</div>
                <div class="profile-value"><span class="highlight-yes">Yes</span></div>
            </div>';
        }

        // Qualification Section
        $output .= '<h5 class="section-heading">Qualifications</h5>';

        $output .= '<div class="qualification-table">';
        $output .= '
            <div class="header">Title</div>
            <div class="header">Specialization</div>
            <div class="header">Total Marks</div>
            <div class="header">Board</div>';

        // Primary Qualification
        if ($rows11["primary_title"] != 'NULL' && !empty($rows11["primary_title"])) {
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            $stmt_qual->bind_param("i", $rows11['primary_title']);
            $stmt_qual->execute();
            $result_qual = $stmt_qual->get_result();
            $rows12 = $result_qual->fetch_assoc();
            $stmt_qual->close();

            $output .= '
            <div>' . htmlspecialchars($rows12["qualification_category"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["primary_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["primary_total_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["primary_board"] ?? 'Not Provided') . '</div>';
        }

        // Middle Qualification
        if ($rows11["middle_title"] != 'NULL' && !empty($rows11["middle_title"])) {
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            $stmt_qual->bind_param("i", $rows11['middle_title']);
            $stmt_qual->execute();
            $result_qual = $stmt_qual->get_result();
            $rows12 = $result_qual->fetch_assoc();
            $stmt_qual->close();

            $output .= '
            <div>' . htmlspecialchars($rows12["qualification_category"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["middle_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["middle_total_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["middle_board"] ?? 'Not Provided') . '</div>';
        }

        // Matric Qualification
        if ($rows11["matric_title"] != 'NULL' && !empty($rows11["matric_title"])) {
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            $stmt_qual->bind_param("i", $rows11['matric_title']);
            $stmt_qual->execute();
            $result_qual = $stmt_qual->get_result();
            $rows12 = $result_qual->fetch_assoc();
            $stmt_qual->close();

            $output .= '
            <div>' . htmlspecialchars($rows12["qualification_category"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["matric_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["matric_total_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["matric_board"] ?? 'Not Provided') . '</div>';
        }

        // Intermediate Qualification
        if ($rows11["inter_title"] != 'NULL' && !empty($rows11["inter_title"])) {
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            $stmt_qual->bind_param("i", $rows11['inter_title']);
            $stmt_qual->execute();
            $result_qual = $stmt_qual->get_result();
            $rows12 = $result_qual->fetch_assoc();
            $stmt_qual->close();

            $output .= '
            <div>' . htmlspecialchars($rows12["qualification_category"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["inter_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["inter_total_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["inter_board"] ?? 'Not Provided') . '</div>';
        }

        // BS Qualification
        if ($rows11["bs_title"] != 'NULL' && !empty($rows11["bs_title"])) {
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            $stmt_qual->bind_param("i", $rows11['bs_title']);
            $stmt_qual->execute();
            $result_qual = $stmt_qual->get_result();
            $rows12 = $result_qual->fetch_assoc();
            $stmt_qual->close();

            $output .= '
            <div>' . htmlspecialchars($rows12["qualification_category"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["bs_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["bs_total_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["bs_board"] ?? 'Not Provided') . '</div>';
        }

        // BS16 Qualification
        if ($rows11["bs16_title"] != 'NULL' && !empty($rows11["bs16_title"])) {
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            $stmt_qual->bind_param("i", $rows11['bs16_title']);
            $stmt_qual->execute();
            $result_qual = $stmt_qual->get_result();
            $rows12 = $result_qual->fetch_assoc();
            $stmt_qual->close();

            $output .= '
            <div>' . htmlspecialchars($rows12["qualification_category"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["bs16_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["bs16_total_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["bs16_board"] ?? 'Not Provided') . '</div>';
        }

        // MS Qualification
        if ($rows11["ms_title"] != 'NULL' && !empty($rows11["ms_title"])) {
            $stmt_qual = $conn->prepare("SELECT qualification_category FROM qualification_category WHERE id = ?");
            $stmt_qual->bind_param("i", $rows11['ms_title']);
            $stmt_qual->execute();
            $result_qual = $stmt_qual->get_result();
            $rows12 = $result_qual->fetch_assoc();
            $stmt_qual->close();

            $output .= '
            <div>' . htmlspecialchars($rows12["qualification_category"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["ms_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["ms_total_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["ms_board"] ?? 'Not Provided') . '</div>';
        }

        // Diploma Qualification
        if ($rows11["diploma_title"] != 'NULL' && !empty($rows11["diploma_title"])) {
            $output .= '
            <div>' . htmlspecialchars($rows11["diploma_title"]) . '</div>
            <div>' . htmlspecialchars($rows11["diploma_specialization"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["diploma_obtained_marks"] ?? 'Not Provided') . '</div>
            <div>' . htmlspecialchars($rows11["diploma_total_marks"] ?? 'Not Provided') . '</div>';
        }

        $output .= '</div>';

        // Professional Qualification
        if ($rows11["profes_certificate"] != 'NULL' && !empty($rows11["profes_certificate"])) {
            $output .= '<h5 class="section-heading">Professional Qualifications</h5>';
            $output .= '<div class="professional-table">';
            $output .= '
                <div class="header">Certificate</div>
                <div class="header">Marks Obtained</div>
                <div class="header">Total Marks</div>
                <div class="header">Board</div>
                <div>' . htmlspecialchars($rows11["profes_certificate"]) . '</div>
                <div>' . htmlspecialchars($rows11["profes_obtained_marks"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["profes_total_marks"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["profes_board"] ?? 'Not Provided') . '</div>
            </div>';
        }

        // Work Experience
        if ($rows11["employ_job_title"] != 'NULL' && !empty($rows11["employ_job_title"])) {
            $output .= '<h5 class="section-heading">Work Experience</h5>';
            $output .= '<div class="work-experience-table">';
            $output .= '
                <div class="header">Job Title</div>
                <div class="header">Organization</div>
                <div class="header">Date From</div>
                <div class="header">Date To</div>
                <div>' . htmlspecialchars($rows11["employ_job_title"]) . '</div>
                <div>' . htmlspecialchars($rows11["employ_organization"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["employ_from_date"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["employ_to_date"] ?? 'Not Provided') . '</div>';

            if ($rows11["employ_organization_two"] != 'NULL' && !empty($rows11["employ_organization_two"])) {
                $output .= '
                <div>' . htmlspecialchars($rows11["employ_job_title_two"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["employ_organization_two"]) . '</div>
                <div>' . htmlspecialchars($rows11["employ_from_date_two"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["employ_to_date_two"] ?? 'Not Provided') . '</div>';
            }

            if ($rows11["employ_job_title_three"] != 'NULL' && !empty($rows11["employ_job_title_three"])) {
                $output .= '
                <div>' . htmlspecialchars($rows11["employ_job_title_three"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["employ_organizatin_three"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["employ_from_date_three"] ?? 'Not Provided') . '</div>
                <div>' . htmlspecialchars($rows11["employ_to_date_three"] ?? 'Not Provided') . '</div>';
            }

            $output .= '</div>';
        }

        $output .= '</div>'; // Close profile-container

        echo $output;
    } else {
        echo '<div class="profile-container"><p style="color: red; text-align: center;">No record found for this employee.</p></div>';
    }

    $stmt->close();
    mysqli_close($conn);
} else {
    echo '<div class="profile-container"><p style="color: red; text-align: center;">Invalid request. Employee ID not provided.</p></div>';
}
?>