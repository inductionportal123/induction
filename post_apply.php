<?php
include('connection/conn.php');
if (!isset($_SESSION)) {
    session_start();
}

include('timeout.php');

if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];
    
    // Initialize variables to avoid undefined variable errors
    $undertaking = "";
    $user_gender = "";
    $profile_picture = "";
    $post_data = "";
    $post_category_data = "";
    $post_apply_data = [];
    $city_prefer_data = "";
    $city_prefer_two_data = "";
    $relax_schedule_caste_data = "";
    $relax_retired_data = "";
    $relax_retired_from_data = "";
    $relax_retired_position_data = "";
    $relax_retired_appoint_data = "";
    $relax_retired_retired_data = "";
    $relax_diabled_data = "";
    $relax_disabled_nature_data = "";
    $relax_widow_data = "";
    $relax_name_employ_data = "";
    $relax_designation_data = "";
    $relax_department_data = "";
    $relax_date_death_data = "";
    $gov_data = "";
    $gov_name_data = "";
    $gov_designation_data = "";
    $gov_basic_pay_data = "";
    $gov_appoint_date_data = "";
    $gov_retire_date_data = "";
    $gov_appoint_nature_data = "";

    // Query to fetch data from per_info and emp_document
    $query = "SELECT pi.*, ed.image 
              FROM per_info pi
              LEFT JOIN emp_document ed ON pi.said = ed.said
              WHERE pi.said = '$userid'";
    
    $exes = mysqli_query($conn, $query);
    if (!$exes) {
        die("Error in query: " . mysqli_error($conn));
    }

    $rows = mysqli_fetch_array($exes);
    $rowcounts = mysqli_num_rows($exes);
    if ($rowcounts == 1) {
        $undertaking = $rows['undertaking'];
        $user_gender = $rows['basic_gender'];
        $profile_picture = $rows['image'];
    }

    // Query to fetch data from post_apply
    $que = "SELECT * FROM post_apply WHERE said = '$userid'";
    $ex = mysqli_query($conn, $que);
    if (!$ex) {
        die("Error in query: " . mysqli_error($conn));
    }

    $ro = mysqli_fetch_array($ex);
    $rowcount = mysqli_num_rows($ex);
    if ($rowcount == 1) {
        $post_data = "ok";
        $post_category_data = $ro['post_category'];
        $post_apply_data = $ro['post_apply'] ? explode(',', $ro['post_apply']) : [];
        $city_prefer_data = $ro['city_prefer'];
        $city_prefer_two_data = $ro['city_prefer_two'];
        $relax_schedule_caste_data = $ro['relax_schedule_caste'];
        $relax_retired_data = $ro['relax_retired'];
        $relax_retired_from_data = $ro['relax_retired_from'];
        $relax_retired_position_data = $ro['relax_retired_position'];
        $relax_retired_appoint_data = $ro['relax_retired_appoint'];
        $relax_retired_retired_data = $ro['relax_retired_retired'];
        $relax_diabled_data = $ro['relax_disable'];
        $relax_disabled_nature_data = $ro['relax_disabled_nature'];
        $relax_widow_data = $ro['relax_widow'];
        $relax_name_employ_data = $ro['relax_name_employ'];
        $relax_designation_data = $ro['relax_designation'];
        $relax_department_data = $ro['relax_department'];
        $relax_date_death_data = $ro['relax_date_death'];
        $gov_data = $ro['gov'];
        $gov_name_data = $ro['gov_name'];
        $gov_designation_data = $ro['gov_designation'];
        $gov_basic_pay_data = $ro['gov_basic_pay'];
        $gov_appoint_date_data = $ro['gov_appoint_date'];
        $gov_retire_date_data = $ro['gov_retire_date'];
        $gov_appoint_nature_data = $ro['gov_appoint_nature'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Post Apply</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .card { transition: all 0.4s ease; background: linear-gradient(135deg, #ffffff, #f9fafb); }
        .card:hover { transform: translateY(-8px); box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15); }
        .sidebar { transition: transform 0.3s ease-in-out; }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.1); transform: translateX(5px); }
        .tooltip { visibility: hidden; position: absolute; background: #333; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.875rem; }
        .sidebar-item:hover .tooltip { visibility: visible; left: 100%; margin-left: 10px; }
        .form-label { font-weight: 600; color: #374151; }
        .required { color: #e11d48; }
        .error-message { color: #e11d48; font-size: 0.875rem; }
        .nav-tab { transition: all 0.3s ease; position: relative; }
        .nav-tab.active { background: linear-gradient(to right, #0d9488, #14b8a6); color: white; }
        .nav-tab:hover:not(.active) { background: #e5e7eb; transform: scale(1.05); }
        .nav-tab::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 100%; height: 2px; background: #14b8a6; transform: scaleX(0); transition: transform 0.3s ease; }
        .nav-tab.active::after { transform: scaleX(1); }
        .progress-bar { height: 4px; background: #14b8a6; transition: width 0.5s ease; }
        .checkbox-group { display: flex; flex-wrap: wrap; gap: 1rem; }
        .checkbox-item { flex: 1 1 30%; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased">
    <!-- Header -->
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="p-8 pt-24 w-full max-w-7xl mx-auto md:ml-72">
        <div class="bg-white p-8 rounded-xl shadow-lg">
          

            <?php include 'registration_form.php'; ?>

            <!-- Form -->
            <form id="post_apply_form" class="space-y-8">
                <!-- Post Information -->
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                        <i class="fas fa-briefcase mr-2"></i> Post Information <span class="text-sm text-gray-500 ml-2">(* Mandatory Fields)</span>
                    </h3>

                    <!-- Category I: Teaching (BPS-17) -->
<div class="mb-6">
    <h4 class="text-teal-600 font-semibold mb-2">Category I: Teaching (BPS-17) | زمرہ I: تدریسی عملہ</h4>
    <?php
    // Re-run the same qualification logic for BPS-17
    if ($qualirow > 0) {
        // Use the same $eligible_degrees and $eligible_degrees_str from above
        if (empty($eligible_degrees)) {
            echo '<p class="text-red-600">No valid qualifications found. Please add qualifications first.</p>';
        } else {
            // Query to fetch eligible posts for BPS-17
            $newquery = $user_gender == 'transgender'
                ? "SELECT p.pid, p.name, p.gender, p.bps 
                   FROM posts p
                   JOIN post_details pd ON p.pid = pd.pid
                   WHERE p.cat = 3 
                   AND pd.req_deg IN ($eligible_degrees_str)
                   AND p.bps = 17
                   ORDER BY p.bps ASC"
                : "SELECT p.pid, p.name, p.gender, p.bps 
                   FROM posts p
                   JOIN post_details pd ON p.pid = pd.pid
                   WHERE p.cat = 3 
                   AND pd.req_deg IN ($eligible_degrees_str)
                   AND (p.gender = '$user_gender' OR p.gender = 'both') 
                   AND p.bps = 17
                   ORDER BY p.bps ASC";

            $newexe = mysqli_query($conn, $newquery);
            if (mysqli_num_rows($newexe) > 0) {
                echo '<div class="checkbox-group">';
                while ($rows = mysqli_fetch_array($newexe)) {
                    $checked = !empty($post_apply_data) && in_array($rows["pid"], $post_apply_data) ? 'checked' : '';
                    echo "<label class='checkbox-item'><input type='checkbox' name='post_apply[]' value='{$rows['pid']}' $checked> " . strtoupper($rows['name']) . " (<small>" . strtoupper($rows['gender']) . ", BPS-{$rows['bps']}</small>)</label>";
                }
                echo '</div>';
            } else {
                echo '<p class="text-red-600">No BPS-17 posts available for your qualifications.</p>';
            }
        }
    } else {
        echo '<p class="text-red-600">Please add <b>Qualifications</b> first.</p>';
    }
    ?>
</div>

<!-- Category I: Teaching (BPS-16) -->
<div class="mb-6">
    <h4 class="text-teal-600 font-semibold mb-2">Category II: Teaching (BPS-16) | زمرہ II: تدریسی عملہ</h4>
    <style>
        .checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .checkbox-item {
            flex: 0 0 calc(50% - 0.5rem);
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            padding: 0.5rem;
            box-sizing: border-box;
        }
        .checkbox-item input {
            margin-right: 0.5rem;
        }
        @media (max-width: 600px) {
            .checkbox-item {
                flex: 0 0 100%;
            }
        }
    </style>
    <?php
    // Check if user has qualifications
    $quali = "SELECT bs_title, bs16_title, ms_title, primary_title 
              FROM qualification 
              WHERE said = '$userid'";
    $exequali = mysqli_query($conn, $quali);
    $qualirow = mysqli_num_rows($exequali);

    if ($qualirow > 0) {
        // Fetch qualifications
        $qual_data = mysqli_fetch_array($exequali);

        // Define degree levels
        $degree_levels = [
            'Primary' => 1,
            'Middle' => 2,
            'Matric' => 3,
            'Inter' => 4,
            'Bachelors' => 5,
            'Bachelors16' => 6,
            'MS' => 7,
            'PhD' => 8
        ];

        // Determine highest degree
        $highest_degree_level = 0;
        $degrees_obtained = [];

        if (!empty($qual_data['bs_title'])) {
            $degrees_obtained[] = 'Bachelors';
        }
        if (!empty($qual_data['bs16_title'])) {
            $degrees_obtained[] = 'Bachelors16';
        }
        if (!empty($qual_data['ms_title'])) {
            $degrees_obtained[] = 'MS';
        }
        if (!empty($qual_data['primary_title'])) {
            $degrees_obtained[] = 'PhD';
        }

        // Find the highest degree level
        foreach ($degrees_obtained as $degree) {
            if (isset($degree_levels[$degree]) && $degree_levels[$degree] > $highest_degree_level) {
                $highest_degree_level = $degree_levels[$degree];
            }
        }

        // Convert highest degree level back to degree names for the query
        $eligible_degrees = [];
        foreach ($degree_levels as $degree => $level) {
            if ($level <= $highest_degree_level) {
                $eligible_degrees[] = $degree;
            }
        }

        // If no degrees found, show message
        if (empty($eligible_degrees)) {
            echo '<p class="text-red-600">No valid qualifications found. Please add qualifications first.</p>';
        } else {
            // Convert eligible degrees to a string for the SQL query
            $eligible_degrees_str = "'" . implode("','", $eligible_degrees) . "'";

            // Query to fetch eligible posts for BPS-16
            $newquery = $user_gender == 'transgender'
                ? "SELECT p.pid, p.name, p.gender, p.bps 
                   FROM posts p
                   JOIN post_details pd ON p.pid = pd.pid
                   WHERE p.cat = 3 
                   AND pd.req_deg IN ($eligible_degrees_str)
                   AND p.bps = 16
                   ORDER BY p.bps ASC"
                : "SELECT p.pid, p.name, p.gender, p.bps 
                   FROM posts p
                   JOIN post_details pd ON p.pid = pd.pid
                   WHERE p.cat = 3 
                   AND pd.req_deg IN ($eligible_degrees_str)
                   AND (p.gender = '$user_gender' OR p.gender = 'both') 
                   AND p.bps = 16
                   ORDER BY p.bps ASC";

            $newexe = mysqli_query($conn, $newquery);
            if (mysqli_num_rows($newexe) > 0) {
                echo '<div class="checkbox-group">';
                while ($rows = mysqli_fetch_array($newexe)) {
                    $checked = !empty($post_apply_data) && in_array($rows["pid"], $post_apply_data) ? 'checked' : '';
                    echo "<label class='checkbox-item'><input type='checkbox' name='post_apply[]' value='{$rows['pid']}' $checked> " . strtoupper($rows['name']) . " (<small>" . strtoupper($rows['gender']) . ", BPS-{$rows['bps']}</small>)</label>";
                }
                echo '</div>';
            } else {
                echo '<p class="text-red-600">No BPS-16 posts available for your qualifications.</p>';
            }
        }
    } else {
        echo '<p class="text-red-600">Please add <b>Qualifications</b> first.</p>';
    }
    ?>
</div>

<!-- Category I: Teaching (BPS-17) -->
<div class="mb-6">
    <h4 class="text-teal-600 font-semibold mb-2">Category II: Teaching (BPS-17) | زمرہ I: تدریسی عملہ</h4>
    <?php
    // Re-run the same qualification logic for BPS-17
    if ($qualirow > 0) {
        // Use the same $eligible_degrees and $eligible_degrees_str from above
        if (empty($eligible_degrees)) {
            echo '<p class="text-red-600">No valid qualifications found. Please add qualifications first.</p>';
        } else {
            // Query to fetch eligible posts for BPS-17
            $newquery = $user_gender == 'transgender'
                ? "SELECT p.pid, p.name, p.gender, p.bps 
                   FROM posts p
                   JOIN post_details pd ON p.pid = pd.pid
                   WHERE p.cat = 3 
                   AND pd.req_deg IN ($eligible_degrees_str)
                   AND p.bps = 17
                   ORDER BY p.bps ASC"
                : "SELECT p.pid, p.name, p.gender, p.bps 
                   FROM posts p
                   JOIN post_details pd ON p.pid = pd.pid
                   WHERE p.cat = 3 
                   AND pd.req_deg IN ($eligible_degrees_str)
                   AND (p.gender = '$user_gender' OR p.gender = 'both') 
                   AND p.bps = 17
                   ORDER BY p.bps ASC";

            $newexe = mysqli_query($conn, $newquery);
            if (mysqli_num_rows($newexe) > 0) {
                echo '<div class="checkbox-group">';
                while ($rows = mysqli_fetch_array($newexe)) {
                    $checked = !empty($post_apply_data) && in_array($rows["pid"], $post_apply_data) ? 'checked' : '';
                    echo "<label class='checkbox-item'><input type='checkbox' name='post_apply[]' value='{$rows['pid']}' $checked> " . strtoupper($rows['name']) . " (<small>" . strtoupper($rows['gender']) . ", BPS-{$rows['bps']}</small>)</label>";
                }
                echo '</div>';
            } else {
                echo '<p class="text-red-600">No BPS-17 posts available for your qualifications.</p>';
            }
        }
    } else {
        echo '<p class="text-red-600">Please add <b>Qualifications</b> first.</p>';
    }
    ?>
</div>


                
                </div>

                <!-- Test City -->
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2"></i> Test City | ٹیسٹ سٹی
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Test City Preferred I <span class="required">*</span> | ٹیسٹ سٹی ترجیحی I</label>
                            <select name="test_city" id="test_city" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" required>
                                <option value="">Select City</option>
                                <?php
                                $nquery = "SELECT DISTINCT(district.id), centes.district FROM district JOIN centes ON district.name = centes.district";
                                $nexe = mysqli_query($conn, $nquery);
                                while ($ro = mysqli_fetch_array($nexe)) {
                                    $selected = isset($city_prefer_data) && $city_prefer_data == str_replace(" ", "", $ro['id']) ? 'selected' : '';
                                    echo "<option value='{$ro['id']}' $selected>" . strtoupper($ro['district']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Test City Preferred II <span class="required">*</span> | ٹیسٹ سٹی ترجیحی II</label>
                            <select name="multy_city" id="multy_city" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" required>
                                <option value="">Select City</option>
                                <?php
                                $newqu = "SELECT DISTINCT(district.id), centes.district FROM district JOIN centes ON district.name = centes.district";
                                $newe = mysqli_query($conn, $newqu);
                                while ($rs = mysqli_fetch_array($newe)) {
                                    $selected = isset($city_prefer_two_data) && $city_prefer_two_data == str_replace(" ", "", $rs['id']) ? 'selected' : '';
                                    echo "<option value='{$rs['id']}' $selected>" . strtoupper($rs['district']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Age Relaxation -->
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                        <i class="fas fa-clock mr-2"></i> Age Relaxation Claim | عمر کی حد میں رعایت
                    </h3>
                    <div class="space-y-6">
                        <!-- Scheduled Castes -->
                        <div class="flex items-center justify-between">
                            <label class="form-label flex-1">Scheduled Castes, Buddhist Community, Recognized Tribes of the Tribal Areas, Azad Kashmir, Gilgit Baltistan, AJK, Sindth (Rural), Balochistan Domiciled .</label>
                            <input type="checkbox" name="caste_age_relax" id="caste_age_relax" class="h-5 w-5" <?php echo isset($relax_schedule_caste_data) && $relax_schedule_caste_data == 1 ? 'checked' : ''; ?>>
                        </div>

                        <!-- Retired Armed Forces -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="form-label flex-1">Released or Retired Officer Personnel of Armed Forces</label>
                                <input type="checkbox" name="retire_age_relax" id="retire_age_relax" class="h-5 w-5" <?php echo isset($relax_retired_data) && $relax_retired_data == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div id="retired-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 <?php echo isset($relax_retired_data) && $relax_retired_data == 1 ? '' : 'hidden'; ?>">
                                <div>
                                    <label class="form-label">Retired From</label>
                                    <select name="retired_armed_person" id="retired_armed_person" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_retired_data) && $relax_retired_data != 1 ? 'disabled' : ''; ?>>
                                        <option value="">Select Your Force</option>
                                        <option value="army" <?php echo isset($relax_retired_from_data) && $relax_retired_from_data == "army" ? 'selected' : ''; ?>>Army</option>
                                        <option value="navy" <?php echo isset($relax_retired_from_data) && $relax_retired_from_data == "navy" ? 'selected' : ''; ?>>Navy</option>
                                        <option value="air" <?php echo isset($relax_retired_from_data) && $relax_retired_from_data == "air" ? 'selected' : ''; ?>>Air Force</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="form-label">Rank</label>
                                    <input type="text" name="retired_armed_position" id="retired_armed_position" value="<?php echo htmlspecialchars($relax_retired_position_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_retired_data) && $relax_retired_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Date of Appointment</label>
                                    <input type="date" name="retired_armed_appoint" id="retired_armed_appoint" value="<?php echo htmlspecialchars($relax_retired_appoint_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_retired_data) && $relax_retired_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Date of Retirement</label>
                                    <input type="date" name="retired_armed_retirement" id="retired_armed_retirement" value="<?php echo htmlspecialchars($relax_retired_retired_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_retired_data) && $relax_retired_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                            </div>
                        </div>

                        <!-- Disabled Person -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="form-label flex-1">Disabled Person (Nature of Disability must be mentioned) </label>
                                <input type="checkbox" name="diabled_age_relax" id="diabled_age_relax" class="h-5 w-5" <?php echo isset($relax_diabled_data) && $relax_diabled_data == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div id="disabled-fields" class="mt-4 <?php echo isset($relax_diabled_data) && $relax_diabled_data == 1 ? '' : 'hidden'; ?>">
                                <label class="form-label">Nature of Disability</label>
                                <select name="nature_diable" id="nature_diable" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_diabled_data) && $relax_diabled_data != 1 ? 'disabled' : ''; ?>>
                                    <option value="">Select Your Disability</option>
                                    <option value="Leg/Arm Paralyze" <?php echo isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Leg/Arm Paralyze" ? 'selected' : ''; ?>>Leg/Arm Paralyze</option>
                                    <option value="Visual Defect" <?php echo isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Visual Defect" ? 'selected' : ''; ?>>Visual Defect</option>
                                    <option value="Mental/Congnitive" <?php echo isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Mental/Congnitive" ? 'selected' : ''; ?>>Mental/Cognitive</option>
                                    <option value="Deaf/Dumb" <?php echo isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Deaf/Dumb" ? 'selected' : ''; ?>>Deaf/Dumb</option>
                                    <option value="Other" <?php echo isset($relax_disabled_nature_data) && $relax_disabled_nature_data == "Other" ? 'selected' : ''; ?>>Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Widow/Widower -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="form-label flex-1">Widow/ Widower or Child of Govt Servant died during Service (on or after 01-07-2005) </label>
                                <input type="checkbox" name="widow_age_relax" id="widow_age_relax" class="h-5 w-5" <?php echo isset($relax_widow_data) && $relax_widow_data == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div id="widow-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 <?php echo isset($relax_widow_data) && $relax_widow_data == 1 ? '' : 'hidden'; ?>">
                                <div>
                                    <label class="form-label">Name of Deceased Govt Employee</label>
                                    <input type="text" name="widow_husband_name" id="widow_husband_name" value="<?php echo htmlspecialchars($relax_name_employ_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_widow_data) && $relax_widow_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Designation and BPS</label>
                                    <input type="text" name="widow_husband_designaiton" id="widow_husband_designaiton" value="<?php echo htmlspecialchars($relax_designation_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_widow_data) && $relax_widow_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Department</label>
                                    <input type="text" name="widow_husband_department" id="widow_husband_department" value="<?php echo htmlspecialchars($relax_department_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_widow_data) && $relax_widow_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Date of Death</label>
                                    <input type="date" name="widow_husband_death" id="widow_husband_death" value="<?php echo htmlspecialchars($relax_date_death_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($relax_widow_data) && $relax_widow_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                            </div>
                        </div>

                        <!-- Government Employee -->
                        <!-- <div>
                            <div class="flex items-center justify-between">
                                <label class="form-label flex-1">Government Employee (Currently Serving)</label>
                                <input type="checkbox" name="gov_emp" id="gov_emp" class="h-5 w-5" <?php echo isset($gov_data) && $gov_data == 1 ? 'checked' : ''; ?>>
                            </div>
                            <div id="gov-fields" class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 <?php echo isset($gov_data) && $gov_data == 1 ? '' : 'hidden'; ?>">
                                <div>
                                    <label class="form-label">Dept Name</label>
                                    <input type="text" name="gov_dept_name" id="gov_dept_name" value="<?php echo htmlspecialchars($gov_name_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($gov_data) && $gov_data != 1 ? 'disabled' : ''; ?> required>
                                </div>
                                <div>
                                    <label class="form-label">Designation</label>
                                    <input type="text" name="gov_dept_desig" id="gov_dept_desig" value="<?php echo htmlspecialchars($gov_designation_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($gov_data) && $gov_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Basic Pay Scale</label>
                                    <input type="text" name="gov_basic_scale" id="gov_basic_scale" value="<?php echo htmlspecialchars($gov_basic_pay_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($gov_data) && $gov_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Appointment Date</label>
                                    <input type="date" name="gov_appoint" id="gov_appoint" value="<?php echo htmlspecialchars($gov_appoint_date_data); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($gov_data) && $gov_data != 1 ? 'disabled' : ''; ?>>
                                </div>
                                <div>
                                    <label class="form-label">Till Registration End Date</label>
                                    <?php
                                    $date = "SELECT `end_date` FROM `registrationdate`";
                                    $exedate = mysqli_query($conn, $date);
                                    $datedate = mysqli_fetch_array($exedate);
                                    $regenddate = $datedate['end_date'] ?? '';
                                    ?>
                                    <input type="text" name="gov_retire" id="gov_retire" value="<?php echo htmlspecialchars($regenddate); ?>" class="w-full p-3 border rounded-md bg-gray-100" readonly>
                                </div>
                                <div>
                                    <label class="form-label">Appointment Nature</label>
                                    <select name="gov_nature" id="gov_nature" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" <?php echo isset($gov_data) && $gov_data != 1 ? 'disabled' : ''; ?>>
                                        <option value="">Select...</option>
                                        <option value="permanent" <?php echo isset($gov_appoint_nature_data) && $gov_appoint_nature_data == "permanent" ? 'selected' : ''; ?>>Permanent</option>
                                        <option value="contract" <?php echo isset($gov_appoint_nature_data) && $gov_appoint_nature_data == "contract" ? 'selected' : ''; ?>>Contract</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- Response and Submit -->
                <div class="flex justify-between items-center">
                    <div id="response" class="text-sm"></div>
                    <div class="flex space-x-4">
                        <?php if ($undertaking == 1) { ?>
                            <p class="text-green-600 font-semibold flex items-center"><i class="fas fa-check-circle mr-2"></i> Already Submitted</p>
                            <button type="button" class="px-6 py-3 bg-gray-400 text-white rounded-lg cursor-not-allowed" disabled>Save & Next</button>
                        <?php } else { ?>
                            <button type="button" class="px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all" id="post_submit">Save & Next <i class="fas fa-arrow-right ml-2"></i></button>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebar-toggle');
        const close = document.getElementById('sidebar-close');
        toggle.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
        close.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));

        // Checkbox Toggle Fields
        $('#retire_age_relax').change(function() {
            $('#retired-fields').toggleClass('hidden', !this.checked);
            $('#retired_armed_person, #retired_armed_position, #retired_armed_appoint, #retired_armed_retirement').prop('disabled', !this.checked);
        });
        $('#diabled_age_relax').change(function() {
            $('#disabled-fields').toggleClass('hidden', !this.checked);
            $('#nature_diable').prop('disabled', !this.checked);
        });
        $('#widow_age_relax').change(function() {
            $('#widow-fields').toggleClass('hidden', !this.checked);
            $('#widow_husband_name, #widow_husband_designaiton, #widow_husband_department, #widow_husband_death').prop('disabled', !this.checked);
        });
        $('#gov_emp').change(function() {
            $('#gov-fields').toggleClass('hidden', !this.checked);
            $('#gov_dept_name, #gov_dept_desig, #gov_basic_scale, #gov_appoint, #gov_nature').prop('disabled', !this.checked);
            $('#gov_retire').prop('disabled', true); // Always disabled as readonly
        });

        // Form Submission
        $("#post_submit").click(function() {
            const checked = $("#post_apply_form input[type=checkbox][name^='post_apply']:checked").length;
            const test_city = $("#test_city").val();
            const multy_city = $("#multy_city").val();
            const retired_armed_person = $("#retired_armed_person").val();
            const retired_armed_position = $("#retired_armed_position").val();
            const retired_armed_appoint = $("#retired_armed_appoint").val();
            const retired_armed_retirement = $("#retired_armed_retirement").val();
            const nature_diable = $("#nature_diable").val();
            const widow_husband_name = $("#widow_husband_name").val();
            const widow_husband_designaiton = $("#widow_husband_designaiton").val();
            const widow_husband_department = $("#widow_husband_department").val();
            const widow_husband_death = $("#widow_husband_death").val();
            const gov_dept_name = $("#gov_dept_name").val();
            const gov_dept_desig = $("#gov_dept_desig").val();
            const gov_basic_scale = $("#gov_basic_scale").val();
            const gov_appoint = $("#gov_appoint").val();
            const gov_nature = $("#gov_nature").val();

            if (checked == 0) {
                $('#response').text("Please Select at least 1 Post.").removeClass('text-teal-600').addClass('text-red-600');
            } else if (!test_city) {
                $('#response').text("Please choose Preferred City I").removeClass('text-teal-600').addClass('text-red-600');
            } else if (!multy_city) {
                $('#response').text("Please choose Preferred City II").removeClass('text-teal-600').addClass('text-red-600');
            } else if (test_city === multy_city) {
                $('#response').text("Preferred City I & II can't be the same").removeClass('text-teal-600').addClass('text-red-600');
            } else if ($("#retire_age_relax").is(':checked') && (!retired_armed_person || !retired_armed_position || !retired_armed_appoint || !retired_armed_retirement)) {
                $('#response').text("All Fields Are Required (with the red star)").removeClass('text-teal-600').addClass('text-red-600');
            } else if ($("#diabled_age_relax").is(':checked') && !nature_diable) {
                $('#response').text("All Fields Are Required (with the red star)").removeClass('text-teal-600').addClass('text-red-600');
            } else if ($("#widow_age_relax").is(':checked') && (!widow_husband_name || !widow_husband_designaiton || !widow_husband_department || !widow_husband_death)) {
                $('#response').text("All Fields Are Required (with the red star)").removeClass('text-teal-600').addClass('text-red-600');
            } else if ($("#gov_emp").is(':checked') && (!gov_dept_name || !gov_dept_desig || !gov_basic_scale || !gov_appoint || !gov_nature)) {
                $('#response').text("All Fields Are Required (with the red star)").removeClass('text-teal-600').addClass('text-red-600');
            } else {
                $.ajax({
                    url: "postprocess.php",
                    type: "POST",
                    data: $('#post_apply_form').serialize(),
                    beforeSend: () => $('#response').text("Processing...").removeClass('text-red-600').addClass('text-teal-600'),
                    success: (data) => {
                        if (data == 0) $('#response').text("Please first fill Personal Information tab").removeClass('text-teal-600').addClass('text-red-600');
                        else if (data == 2) $('#response').text("There is no seat in this domicile").removeClass('text-teal-600').addClass('text-red-600');
                        else if (data == 1) window.location.href = "challan.php";
                        else $('#response').text(data).removeClass('text-teal-600').addClass('text-red-600');
                    }
                });
            }
        });
    </script>
</body>
</html>
<?php
} else {
    header("Location: index.php");
    exit();
}
mysqli_close($conn);
?>