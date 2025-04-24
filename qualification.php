<?php
// Start session
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('connection/conn.php');
include('timeout.php');

// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Check if user is logged in
if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    // Initialize variables to avoid undefined notices
    $undertaking = '';
    $bs_title = '';
    $bs_specialization = '';
    $bs_total_marks = '';
    $bs_board = '';
    $bs16_title = '';
    $bs16_specialization = '';
    $bs16_total_marks = '';
    $bs16_board = '';
    $ms_title = '';
    $ms_specialization = '';
    $ms_total_marks = '';
    $ms_board = '';
    $primary_title = '';
    $primary_specialization = '';
    $primary_total_marks = '';
    $primary_board = '';
    $profes_certificate = '';
    $profes_obtained_marks = '';
    $profes_total_marks = '';
    $profes_board = '';
    $profes_certificate_two = '';
    $profes_obtained_marks_two = '';
    $profes_total_marks_two = '';
    $profes_board_two = '';
    $profes_certificate_three = '';
    $profes_obtained_marks_three = '';
    $profes_total_marks_three = '';
    $profes_board_three = '';
    $profile_picture = '';

    // Query for undertaking
    $query = "SELECT undertaking FROM per_info WHERE said = ?";
    $stmt = mysqli_prepare($conn, $query);
    if (!$stmt) {
        die("Error preparing per_info query: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    $exes = mysqli_stmt_get_result($stmt);

    if (!$exes) {
        die("Error in per_info query: " . mysqli_error($conn));
    }

    $rows = mysqli_fetch_array($exes);
    $rowcounts = mysqli_num_rows($exes);
    if ($rowcounts == 1) {
        $undertaking = $rows['undertaking'] ?? '';
    }

    // Query for qualifications
    $que = "SELECT bs_title, bs_specialization, bs_total_marks, bs_board,
                   bs16_title, bs16_specialization, bs16_total_marks, bs16_board,
                   ms_title, ms_specialization, ms_total_marks, ms_board,
                   primary_title, primary_specialization, primary_total_marks, primary_board,
                   profes_certificate, profes_obtained_marks, profes_total_marks, profes_board,
                   profes_certificate_two, profes_obtained_marks_two, profes_total_marks_two, profes_board_two,
                   profes_certificate_three, profes_obtained_marks_three, profes_total_marks_three, profes_board_three,
                   emp_document.image
            FROM qualification 
            LEFT JOIN emp_document ON qualification.said = emp_document.said 
            WHERE qualification.said = ?";
    
    $stmt = mysqli_prepare($conn, $que);
    if (!$stmt) {
        die("Error preparing qualification query: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    $ex = mysqli_stmt_get_result($stmt);

    if (!$ex) {
        die("Error in qualification query: " . mysqli_error($conn));
    }

    $ro = mysqli_fetch_array($ex);
    $rowcount = mysqli_num_rows($ex);

    if ($rowcount == 1) {
        $bs_title = $ro['bs_title'] ?? '';
        $bs_specialization = $ro['bs_specialization'] ?? '';
        $bs_total_marks = $ro['bs_total_marks'] ?? '';
        $bs_board = $ro['bs_board'] ?? '';
        $bs16_title = $ro['bs16_title'] ?? '';
        $bs16_specialization = $ro['bs16_specialization'] ?? '';
        $bs16_total_marks = $ro['bs16_total_marks'] ?? '';
        $bs16_board = $ro['bs16_board'] ?? '';
        $ms_title = $ro['ms_title'] ?? '';
        $ms_specialization = $ro['ms_specialization'] ?? '';
        $ms_total_marks = $ro['ms_total_marks'] ?? '';
        $ms_board = $ro['ms_board'] ?? '';
        $primary_title = $ro['primary_title'] ?? '';
        $primary_specialization = $ro['primary_specialization'] ?? '';
        $primary_total_marks = $ro['primary_total_marks'] ?? '';
        $primary_board = $ro['primary_board'] ?? '';
        $profes_certificate = $ro['profes_certificate'] ?? '';
        $profes_obtained_marks = $ro['profes_obtained_marks'] ?? '';
        $profes_total_marks = $ro['profes_total_marks'] ?? '';
        $profes_board = $ro['profes_board'] ?? '';
        $profes_certificate_two = $ro['profes_certificate_two'] ?? '';
        $profes_obtained_marks_two = $ro['profes_obtained_marks_two'] ?? '';
        $profes_total_marks_two = $ro['profes_total_marks_two'] ?? '';
        $profes_board_two = $ro['profes_board_two'] ?? '';
        $profes_certificate_three = $ro['profes_certificate_three'] ?? '';
        $profes_obtained_marks_three = $ro['profes_obtained_marks_three'] ?? '';
        $profes_total_marks_three = $ro['profes_total_marks_three'] ?? '';
        $profes_board_three = $ro['profes_board_three'] ?? '';
        $profile_picture = $ro['image'] ?? '';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Qualification</title>
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
        table { width: 100%; }
        th, td { padding: 10px; vertical-align: middle; }
        .required-field::after { content: '*'; color: #e11d48; margin-left: 4px; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased">
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="p-8 pt-24 w-full max-w-7xl mx-auto md:ml-72">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <!-- Form -->

               <!-- Advanced Navigation Tabs -->
               <?php include 'registration_form.php'; ?>

               
            <form id="qualification_form" action="qualification_process.php" method="POST" class="space-y-8">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">

                <!-- Academic Information -->
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                        <i class="fas fa-graduation-cap mr-2"></i> Academic Information 
                        <span class="text-sm text-gray-500 ml-2">(* At least one academic qualification is required)</span>
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-teal-100">
                                <tr>
                                    <th class="text-left text-teal-800">Level</th>
                                    <th class="text-left text-teal-800">Certificate/Degree</th>
                                    <th class="text-left text-teal-800">Specialization</th>
                                    <th class="text-left text-teal-800">Grade/CGPA</th>
                                    <th class="text-left text-teal-800">Board/University</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Bachelors (14 Years) -->
                                <tr>
                                    <th class="form-label">Bachelors (14 Years)</th>
                                    <td>
                                        <select name="bs_title" id="bs_title" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" onchange="toggleRequiredFields('bs')">
                                            <option value="">--Select--</option>
                                            <?php
                                            $querys = "SELECT * FROM qualification_category WHERE type = 'Bachelors'";
                                            $datas = mysqli_query($conn, $querys);
                                            while ($rowss = mysqli_fetch_array($datas)) {
                                                $selected = ($rowss['id'] == $bs_title) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($rowss['id']) . "' $selected>" . htmlspecialchars(ucfirst($rowss['Qualification_category'])) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="bs_specialization" id="bs_specialization" value="<?php echo htmlspecialchars($bs_specialization); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="bs_total_marks" id="bs_total_marks" value="<?php echo htmlspecialchars($bs_total_marks); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="bs_board" id="bs_board" value="<?php echo htmlspecialchars($bs_board); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                </tr>

                                <!-- Bachelors (16 Years) -->
                                <tr>
                                    <th class="form-label">Bachelors (Hons)/Masters (16 Years)</th>
                                    <td>
                                        <select name="bs16_title" id="bs16_title" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" onchange="toggleRequiredFields('bs16')">
                                            <option value="">--Select--</option>
                                            <?php
                                            $querys = "SELECT * FROM qualification_category WHERE type = 'Bachelors16'";
                                            $datas = mysqli_query($conn, $querys);
                                            while ($rowss = mysqli_fetch_array($datas)) {
                                                $selected = ($rowss['id'] == $bs16_title) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($rowss['id']) . "' $selected>" . htmlspecialchars(ucfirst($rowss['Qualification_category'])) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="bs16_specialization" id="bs16_specialization" value="<?php echo htmlspecialchars($bs16_specialization); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="bs16_total_marks" id="bs16_total_marks" value="<?php echo htmlspecialchars($bs16_total_marks); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="bs16_board" id="bs16_board" value="<?php echo htmlspecialchars($bs16_board); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                </tr>

                                <!-- MS / M.Phil -->
                                <tr>
                                    <th class="form-label">MS / M.Phil (18 Years)</th>
                                    <td>
                                        <select name="ms_title" id="ms_title" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" onchange="toggleRequiredFields('ms')">
                                            <option value="">--Select--</option>
                                            <?php
                                            $querys = "SELECT * FROM qualification_category WHERE type = 'MS'";
                                            $datas = mysqli_query($conn, $querys);
                                            while ($rowss = mysqli_fetch_array($datas)) {
                                                $selected = ($rowss['id'] == $ms_title) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($rowss['id']) . "' $selected>" . htmlspecialchars(ucfirst($rowss['Qualification_category'])) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="ms_specialization" id="ms_specialization" value="<?php echo htmlspecialchars($ms_specialization); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="ms_total_marks" id="ms_total_marks" value="<?php echo htmlspecialchars($ms_total_marks); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="ms_board" id="ms_board" value="<?php echo htmlspecialchars($ms_board); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                </tr>

                                <!-- PhD -->
                                <tr>
                                    <th class="form-label">PhD</th>
                                    <td>
                                        <select name="primary_title" id="primary_title" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" onchange="toggleRequiredFields('primary')">
                                            <option value="">--Select--</option>
                                            <?php
                                            $querys = "SELECT * FROM qualification_category WHERE type = 'phd'";
                                            $datas = mysqli_query($conn, $querys);
                                            while ($rowss = mysqli_fetch_array($datas)) {
                                                $selected = ($rowss['id'] == $primary_title) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($rowss['id']) . "' $selected>" . htmlspecialchars(ucfirst($rowss['Qualification_category'])) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="primary_specialization" id="primary_specialization" value="<?php echo htmlspecialchars($primary_specialization); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="primary_total_marks" id="primary_total_marks" value="<?php echo htmlspecialchars($primary_total_marks); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td>
                                        <input type="text" name="primary_board" id="primary_board" value="<?php echo htmlspecialchars($primary_board); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Professional Qualification -->
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                        <i class="fas fa-certificate mr-2"></i> Professional Qualification
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-teal-100">
                                <tr>
                                    <th class="text-left text-teal-800">Sr.#</th>
                                    <th class="text-left text-teal-800">Degree</th>
                                    <th class="text-left text-teal-800">Obtained Marks</th>
                                    <th class="text-left text-teal-800">Total Marks</th>
                                    <th class="text-left text-teal-800">Board/University</th>
                                </tr>
                            </thead>
                            <tbody>
    <tr>
        <th class="form-label">01</th>
        <td>
            <input type="text" value="B.Ed/Equivalent" class="w-full p-3 border rounded-md bg-gray-100 text-gray-600 cursor-not-allowed" >
            <input type="hidden" name="dip_name_one" value="B.Ed/Equivalent">
        </td>
        <td>
    <input type="number" name="dip_obt_one" id="dip_obt_one" value="<?php echo htmlspecialchars($profes_obtained_marks); ?>" min="0" step="1" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500 required-field" required>
</td>
<td>
    <input type="number" name="dip_total_one" id="dip_total_one" value="<?php echo htmlspecialchars($profes_total_marks); ?>" min="0" step="1" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500 required-field" required>
</td>
        <td>
            <input type="text" name="dip_board_one" id="dip_board_one" value="<?php echo htmlspecialchars($profes_board); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500 required-field" required>
        </td>
    </tr>
    <tr>
        <th class="form-label">02</th>
        <td><input type="text" name="dip_name_two" value="<?php echo htmlspecialchars($profes_certificate_two); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
        <td><input type="text" name="dip_obt_two" value="<?php echo htmlspecialchars($profes_obtained_marks_two); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
        <td><input type="text" name="dip_total_two" value="<?php echo htmlspecialchars($profes_total_marks_two); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
        <td><input type="text" name="dip_board_two" value="<?php echo htmlspecialchars($profes_board_two); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
    </tr>
    <tr>
        <th class="form-label">03</th>
        <td><input type="text" name="dip_name_three" value="<?php echo htmlspecialchars($profes_certificate_three); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
        <td><input type="text" name="dip_obt_three" value="<?php echo htmlspecialchars($profes_obtained_marks_three); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
        <td><input type="text" name="dip_total_three" value="<?php echo htmlspecialchars($profes_total_marks_three); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
        <td><input type="text" name="dip_board_three" value="<?php echo htmlspecialchars($profes_board_three); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500"></td>
    </tr>
</tbody>
                        </table>
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
                            <button type="button" class="px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all" id="qual_btn">Save & Next <i class="fas fa-arrow-right ml-2"></i></button>
                        <?php } ?>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
    // Sidebar Toggle
    const sidebar = document.getElementById('sidebar');
    const toggle = document.getElementById('sidebar-toggle');
    const close = document.getElementById('sidebar-close');
    if (toggle && close && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
        close.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
    }

    // Toggle required fields for academic qualifications
    function toggleRequiredFields(prefix) {
        const title = document.getElementById(`${prefix}_title`);
        const specialization = document.getElementById(`${prefix}_specialization`);
        const totalMarks = document.getElementById(`${prefix}_total_marks`);
        const board = document.getElementById(`${prefix}_board`);

        if (title && specialization && totalMarks && board) {
            if (title.value) {
                specialization.required = true;
                totalMarks.required = true;
                board.required = true;
                specialization.classList.add('required-field');
                totalMarks.classList.add('required-field');
                board.classList.add('required-field');
            } else {
                specialization.required = false;
                totalMarks.required = false;
                board.required = false;
                specialization.classList.remove('required-field');
                totalMarks.classList.remove('required-field');
                board.classList.remove('required-field');
            }
        }
    }

    // Initialize required fields on page load
    ['bs', 'bs16', 'ms', 'primary'].forEach(prefix => {
        toggleRequiredFields(prefix);
    });

    // AJAX Form Submission
    $("#qual_btn").click(function() {
        let isValid = true;
        let hasAcademicQualification = false;

        // Validate academic qualifications (at least one must be filled)
        ['bs', 'bs16', 'ms', 'primary'].forEach(prefix => {
            const title = $(`#${prefix}_title`).val();
            const specialization = $(`#${prefix}_specialization`).val();
            const totalMarks = $(`#${prefix}_total_marks`).val();
            const board = $(`#${prefix}_board`).val();

            if (title) {
                hasAcademicQualification = true;
                if (!specialization || !totalMarks || !board) {
                    isValid = false;
                    if (!specialization) $(`#${prefix}_specialization`).addClass('border-red-500');
                    if (!totalMarks) $(`#${prefix}_total_marks`).addClass('border-red-500');
                    if (!board) $(`#${prefix}_board`).addClass('border-red-500');
                } else {
                    $(`#${prefix}_specialization`).removeClass('border-red-500');
                    $(`#${prefix}_total_marks`).removeClass('border-red-500');
                    $(`#${prefix}_board`).removeClass('border-red-500');
                }
            } else {
                $(`#${prefix}_specialization`).removeClass('border-red-500');
                $(`#${prefix}_total_marks`).removeClass('border-red-500');
                $(`#${prefix}_board`).removeClass('border-red-500');
            }
        });

        // Validate professional qualification (all fields are compulsory)
        const dipObtOne = $('#dip_obt_one').val();
        const dipTotalOne = $('#dip_total_one').val();
        const dipBoardOne = $('#dip_board_one').val();

        if (!dipObtOne || !dipTotalOne || !dipBoardOne) {
            isValid = false;
            if (!dipObtOne) $('#dip_obt_one').addClass('border-red-500');
            if (!dipTotalOne) $('#dip_total_one').addClass('border-red-500');
            if (!dipBoardOne) $('#dip_board_one').addClass('border-red-500');
        } else {
            // Validate numeric values and obtained marks <= total marks
            const obtMarks = parseFloat(dipObtOne);
            const totalMarks = parseFloat(dipTotalOne);
            if (isNaN(obtMarks) || isNaN(totalMarks)) {
                isValid = false;
                if (isNaN(obtMarks)) $('#dip_obt_one').addClass('border-red-500');
                if (isNaN(totalMarks)) $('#dip_total_one').addClass('border-red-500');
                $('#response').text("Obtained Marks and Total Marks must be numeric.").addClass('text-red-600');
            } else if (obtMarks <= 0 || totalMarks <= 0) {
                isValid = false;
                $('#dip_obt_one').addClass('border-red-500');
                $('#dip_total_one').addClass('border-red-500');
                $('#response').text("Obtained Marks and Total Marks must be positive numbers.").addClass('text-red-600');
            } else if (obtMarks > totalMarks) {
                isValid = false;
                $('#dip_obt_one').addClass('border-red-500');
                $('#response').text("Obtained Marks cannot exceed Total Marks.").addClass('text-red-600');
            } else {
                $('#dip_obt_one').removeClass('border-red-500');
                $('#dip_total_one').removeClass('border-red-500');
                $('#dip_board_one').removeClass('border-red-500');
            }
        }

        // Check if at least one academic qualification is provided
        if (!hasAcademicQualification) {
            isValid = false;
            $('#response').text("Please fill at least one academic qualification.").addClass('text-red-600');
            return;
        }

        if (!isValid) {
            $('#response').text("Please fill all required fields for selected qualifications.").addClass('text-red-600');
            return;
        }

        $.ajax({
            url: "qualification_process.php",
            type: "POST",
            data: $('#qualification_form').serialize(),
            beforeSend: () => $('#response').text("Processing...").removeClass('text-red-600').addClass('text-teal-600'),
            success: (data) => {
                if (data == 1) {
                    window.location.replace("post_apply.php");
                } else {
                    $('#response').text(data).removeClass('text-teal-600').addClass('text-red-600');
                }
            },
            error: () => {
                $('#response').text("An error occurred. Please try again.").addClass('text-red-600');
            }
        });
    });
</script>
</body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
?>