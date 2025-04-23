<?php
// Include database connection
include 'connection/conn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI Induction Portal - CNIC Result Search</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 100%);
            overflow-x: hidden;
        }
        .glassmorph {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }
        .input-focus {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            background: rgba(255, 255, 255, 0.8);
        }
        .input-focus:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 12px rgba(79, 70, 229, 0.3);
            background: rgba(255, 255, 255, 1);
        }
        .btn-hover {
            transition: all 0.3s ease;
        }
        .btn-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(79, 70, 229, 0.3);
        }
        .loading-spinner {
            display: none;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
        @keyframes fadeIn {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulseGlow {
            0% { box-shadow: 0 0 8px rgba(79, 70, 229, 0.2); }
            50% { box-shadow: 0 0 16px rgba(79, 70, 229, 0.4); }
            100% { box-shadow: 0 0 8px rgba(79, 70, 229, 0.2); }
        }
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out;
        }
        .glow-hover {
            transition: all 0.3s ease;
        }
        .glow-hover:hover {
            animation: pulseGlow 1.5s infinite;
        }
        .result-table tr {
            transition: all 0.3s ease;
        }
        .result-table tr:hover {
            background: rgba(99, 102, 241, 0.05);
            transform: translateX(5px);
        }
        .progress-bar {
            transition: width 1s ease-in-out;
        }
    </style>
</head>
<body class="min-h-screen text-gray-800 flex items-center justify-center p-4 relative">
    <!-- Subtle Background Accents -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="w-80 h-80 bg-indigo-200/20 rounded-full absolute -top-40 -left-40 animate-pulse blur-3xl"></div>
        <div class="w-64 h-64 bg-blue-200/20 rounded-full absolute bottom-0 right-0 animate-pulse blur-3xl delay-1000"></div>
    </div>

    <div class="glassmorph rounded-3xl shadow-2xl w-full max-w-lg p-8 relative z-10 animate-fadeIn glow-hover">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <a href="index.php">
                <img src="images/logo.png" alt="FGEI Logo" class="h-24 transition-transform hover:scale-110 duration-500 filter drop-shadow-md">
            </a>
        </div>

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center">
                <i class="ri-user-search-line text-3xl text-indigo-600 mr-3 animate-pulse"></i>
                <h1 class="text-3xl md:text-4xl font-extrabold text-indigo-900 tracking-tight">FGEI Induction Portal</h1>
            </div>
            <p id="searchTitle" class="text-lg text-gray-600 mt-2 transition-colors duration-300">Search Result by CNIC</p>
        </div>

        <!-- Form -->
        <form method="POST" action="" id="searchForm">
            <div class="mb-6">
                <label for="cnic" class="block text-indigo-900 font-semibold mb-2">Enter Your CNIC (With or Without Dashes)</label>
                <div class="relative">
                    <i class="ri-id-card-line absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-500 text-xl"></i>
                    <input 
                        type="text" 
                        id="cnic" 
                        name="cnic" 
                        placeholder="e.g., 12345-1234567-1 or 1234512345671" 
                        class="w-full pl-12 pr-4 py-3 rounded-xl input-focus text-gray-800 placeholder-gray-400 shadow-sm"
                        required
                    >
                </div>
            </div>

            <!-- Password Field -->
            <div id="passwordField" class="mb-6">
                <label for="password" class="block text-indigo-900 font-semibold mb-2">Enter Your Password</label>
                <div class="relative">
                    <i class="ri-lock-line absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-500 text-xl"></i>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password" 
                        class="w-full pl-12 pr-4 py-3 rounded-xl input-focus text-gray-800 placeholder-gray-400 shadow-sm"
                        required
                    >
                </div>
            </div>

            <!-- DOB Field -->
            <div id="dobField" class="mb-6 hidden">
                <label for="dob" class="block text-indigo-900 font-semibold mb-2">Enter Your Date of Birth</label>
                <div class="relative">
                    <i class="ri-calendar-line absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-500 text-xl"></i>
                    <input 
                        type="date" 
                        id="dob" 
                        name="dob" 
                        class="w-full pl-12 pr-4 py-3 rounded-xl input-focus text-gray-800 shadow-sm"
                    >
                </div>
            </div>

            <!-- Toggle Buttons -->
            <div class="mb-6 flex justify-center space-x-4">
                <button type="button" id="togglePassword" class="hidden bg-indigo-600 text-white py-2 px-6 rounded-full btn-hover font-semibold shadow-md hover:bg-indigo-700 transition-colors duration-300">Search by Password</button>
                <button type="button" id="toggleDob" class="bg-indigo-600 text-white py-2 px-6 rounded-full btn-hover font-semibold shadow-md hover:bg-indigo-700 transition-colors duration-300">Forgot Password</button>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                id="searchBtn" 
                class="w-full bg-gradient-to-r from-indigo-600 to-indigo-800 text-white py-3 rounded-full btn-hover font-semibold flex items-center justify-center shadow-md hover:shadow-lg transition-all duration-300"
            >
                <i class="ri-search-line text-xl mr-2"></i>
                <span id="btnText">Search Result</span>
                <i id="loadingSpinner" class="ri-loader-4-line text-xl ml-2 loading-spinner"></i>
            </button>
        </form>

        <!-- Result Section -->
        <div id="result" class="mt-8 <?php echo (isset($_POST['cnic']) && (isset($_POST['dob']) || isset($_POST['password']))) ? '' : 'hidden'; ?>">
            <h2 class="text-2xl font-semibold text-indigo-900 mb-4 flex items-center">
                <i class="ri-checkbox-circle-line text-2xl text-green-500 mr-2 animate-bounce"></i>
                Your Result
            </h2>
            <div id="resultContent" class="p-6 bg-white rounded-xl shadow-inner border border-indigo-100">
                <?php
                if (isset($_POST['cnic']) && (isset($_POST['dob']) || isset($_POST['password']))) {
                    $cnic_input = preg_replace("/[^0-9]/", "", mysqli_real_escape_string($conn, trim($_POST['cnic'])));
                    $dob = isset($_POST['dob']) ? mysqli_real_escape_string($conn, trim($_POST['dob'])) : '';
                    $password = isset($_POST['password']) ? mysqli_real_escape_string($conn, trim($_POST['password'])) : '';

                    if (empty($cnic_input) || (empty($dob) && empty($password))) {
                        echo "<p class='text-red-600 font-semibold flex items-center'><i class='ri-error-warning-line text-xl mr-2'></i>Please enter CNIC and either Date of Birth or Password!</p>";
                    } else if (!preg_match('/^\d{13}$/', $cnic_input)) {
                        echo "<p class='text-red-600 font-semibold flex items-center'><i class='ri-error-warning-line text-xl mr-2'></i>Invalid CNIC format! Must be 13 digits (e.g., 12345-1234567-1 or 1234512345671).</p>";
                    } else {
                        $cnic = substr($cnic_input, 0, 5) . "-" . substr($cnic_input, 5, 7) . "-" . substr($cnic_input, 12, 1);

                        if (!empty($dob)) {
                            $query = "
                                SELECT a.name, a.cnic, l.marks, per_info.basic_dob, l.status AS latest_status, d.d_status
                                FROM `acount_details` a
                                INNER JOIN `details` d ON d.d_said = a.id
                                INNER JOIN per_info ON per_info.said = a.id
                                INNER JOIN `leatest_result` l ON d.d_rollno = l.roll_no
                                WHERE a.cnic = '$cnic' AND per_info.basic_dob = '$dob'
                            ";
                        } else if (!empty($password)) {
                            $query = "
                                SELECT a.name, a.cnic, l.marks, per_info.basic_dob, l.status AS latest_status, d.d_status
                                FROM `acount_details` a
                                INNER JOIN `details` d ON d.d_said = a.id
                                INNER JOIN per_info ON per_info.said = a.id
                                INNER JOIN `leatest_result` l ON d.d_rollno = l.roll_no
                                WHERE a.cnic = '$cnic' AND a.password = '$password'
                            ";
                        }

                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            echo "<p class='text-red-600 font-semibold flex items-center'><i class='ri-error-warning-line text-xl mr-2'></i>Database Error: " . mysqli_error($conn) . "</p>";
                        } else if (mysqli_num_rows($result) > 0) {
                            $row = mysqli_fetch_assoc($result);
                            $statusColor = $row['latest_status'] == 'Pass' ? 'text-green-600' : 'text-red-600';
                            echo "
                                <table class='result-table w-full'>
                                    <tr class='border-b border-indigo-100'>
                                        <td class='font-semibold text-indigo-900 py-3 px-4 text-left'>Name:</td>
                                        <td class='text-gray-700 py-3 px-4'>{$row['name']}</td>
                                    </tr>
                                    <tr class='border-b border-indigo-100'>
                                        <td class='font-semibold text-indigo-900 py-3 px-4 text-left'>CNIC:</td>
                                        <td class='text-gray-700 py-3 px-4'>{$row['cnic']}</td>
                                    </tr>
                                    <tr class='border-b border-indigo-100'>
                                        <td class='font-semibold text-indigo-900 py-3 px-4 text-left'>Date of Birth:</td>
                                        <td class='text-gray-700 py-3 px-4'>{$row['basic_dob']}</td>
                                    </tr>
                                    <tr>
                                        <td class='font-semibold text-indigo-900 py-3 px-4 text-left'>Marks:</td>
                                        <td class='text-gray-700 py-3 px-4'>
                                            <div class='flex items-center space-x-3'>
                                                <span class='text-lg font-medium text-indigo-800'>{$row['marks']}</span>
                                                <span class='text-sm text-gray-500'>/ 100</span>
                                                <div class='w-40 h-3 bg-indigo-100 rounded-full overflow-hidden'>
                                                    <div class='h-full bg-gradient-to-r from-indigo-500 to-indigo-700 rounded-full progress-bar' style='width: {$row['marks']}%;'></div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            ";
                        } else {
                            echo "<p class='text-gray-600 flex items-center'><i class='ri-information-line text-xl mr-2'></i>No result found for this CNIC and " . (!empty($dob) ? "Date of Birth" : "Password") . " combination. Please check and try again.</p>";
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            const dobField = $('#dobField');
            const passwordField = $('#passwordField');
            const toggleDobBtn = $('#toggleDob');
            const togglePasswordBtn = $('#togglePassword');
            const searchTitle = $('#searchTitle');

            passwordField.removeClass('hidden');
            $('#password').prop('required', true);
            dobField.addClass('hidden');
            $('#dob').prop('required', false);
            togglePasswordBtn.addClass('hidden');
            toggleDobBtn.removeClass('hidden');
            searchTitle.text('Search Result by CNIC').removeClass('text-red-600').addClass('text-gray-600');

            toggleDobBtn.on('click', function() {
                dobField.removeClass('hidden');
                passwordField.addClass('hidden');
                $('#dob').prop('required', true);
                $('#password').prop('required', false);
                toggleDobBtn.addClass('hidden');
                togglePasswordBtn.removeClass('hidden');
                searchTitle.text('Search Result by Date of Birth').removeClass('text-gray-600').addClass('text-red-600');
            });

            togglePasswordBtn.on('click', function() {
                passwordField.removeClass('hidden');
                dobField.addClass('hidden');
                $('#password').prop('required', true);
                $('#dob').prop('required', false);
                togglePasswordBtn.addClass('hidden');
                toggleDobBtn.removeClass('hidden');
                searchTitle.text('Search Result by CNIC').removeClass('text-red-600').addClass('text-gray-600');
            });
        });

        const form = document.getElementById('searchForm');
        const searchBtn = document.getElementById('searchBtn');
        const btnText = document.getElementById('btnText');
        const loadingSpinner = document.getElementById('loadingSpinner');

        form.addEventListener('submit', (e) => {
            const cnic = $("#cnic").val().replace(/[^0-9]/g, "");
            const dob = document.getElementById('dob').value.trim();
            const password = document.getElementById('password').value.trim();

            if (cnic !== '' && (dob !== '' || password !== '') && /^\d{13}$/.test(cnic)) {
                searchBtn.disabled = true;
                btnText.textContent = 'Searching...';
                loadingSpinner.style.display = 'inline-block';
            } else if (!/^\d{13}$/.test(cnic)) {
                e.preventDefault();
                alert('Invalid CNIC format! Must be 13 digits (e.g., 12345-1234567-1 or 1234512345671).');
            } else {
                e.preventDefault();
                alert('Please fill the required field (Password or Date of Birth).');
            }
        });
    </script>
</body>
</html>