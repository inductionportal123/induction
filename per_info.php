<?php
// Start session
session_start();
include('connection/conn.php');
include('timeout.php');

// Generate CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Check if user is logged in
if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT pi.basic_full_name, pi.basic_father_name, pi.basic_gender, pi.basic_dob, pi.disability,
                     pi.basic_domicile, pi.basic_marital_status, pi.undertaking,
                     pic.network, pic.contact_phone_no, pic.contact_mobile, pic.contact_email, 
                     pic.contact_district, pic.contact_district_code, pic.contact_city, pic.contact_religion, 
                     pic.contact_postal_address, pic.contact_per_address, pi.contact_cnic,
                     pis.female_applying, pis.female_husband, pis.female_husband_province, 
                     pis.female_husband_district, pis.female_husband_district_code, 
                     ed.image 
              FROM per_info pi
              LEFT JOIN per_info_contact pic ON pi.said = pic.said
              LEFT JOIN per_info_spouse pis ON pi.said = pis.said
              LEFT JOIN emp_document ed ON pi.said = ed.said
              WHERE pi.said = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    $exes = mysqli_stmt_get_result($stmt);

    if (!$exes) {
        die("Error in query: " . mysqli_error($conn));
    }

    $rows = mysqli_fetch_array($exes);
    $rowcounts = mysqli_num_rows($exes);

    // Initialize variables to avoid undefined notices
    $account_detail_name = '';
    $basics_father = '';
    $basics_gender = '';
    $basics_dob = '';
    $basics_domicile = '';
    $basics_status = '';
    $network = '';
    $basics_contact_phone = '';
    $highest_qualification = '';
    $basics_mobile = '';
    $account_detail_cnic = '';
    $account_detail_email = '';
    $basics_district = '';
    $basics_district_code = '';
    $basics_city = '';
    $basics_religion = '';
    $basics_postal = '';
    $basics_permanent = '';
    $undertaking = '';
    $basics_female = '';
    $basics_female_husband = '';
    $basics_husband_province = '';
    $basics_husband_distric = '';
    $basics_husband_distric_code = '';
    $profile_picture = '';

    if ($rowcounts == 1) {
        $account_detail_name = $rows['basic_full_name'] ?? '';
        $basics_father = $rows['basic_father_name'] ?? '';
        $basics_gender = $rows['basic_gender'] ?? '';
        $basics_dob = $rows['basic_dob'] ?? '';
        $basics_domicile = $rows['basic_domicile'] ?? '';
        $basics_status = $rows['basic_marital_status'] ?? '';
        $network = $rows['network'] ?? '';
        $basics_contact_phone = $rows['contact_phone_no'] ?? '';
        $highest_qualification = $rows['highest_qualification'] ?? '';
        $basics_mobile = $rows['contact_mobile'] ?? '';
        $account_detail_cnic = $rows['contact_cnic'] ?? '';
        $account_detail_email = $rows['contact_email'] ?? '';
        $basics_district = $rows['contact_district'] ?? '';
        $basics_district_code = $rows['contact_district_code'] ?? '';
        $basics_city = $rows['contact_city'] ?? '';
        $basics_religion = $rows['contact_religion'] ?? '';
        $basics_postal = $rows['contact_postal_address'] ?? '';
        $basics_permanent = $rows['contact_per_address'] ?? '';
        $undertaking = $rows['undertaking'] ?? '';
        $basics_female = ($rows['female_applying'] == 1) ? '1' : ($rows['female_applying'] == 0 ? '0' : '');
        $basics_female_husband = $rows['female_husband'] ?? '';
        $basics_husband_province = $rows['female_husband_province'] ?? '';
        $basics_husband_distric = $rows['female_husband_district'] ?? '';
        $basics_husband_distric_code = $rows['female_husband_district_code'] ?? '';
        $profile_picture = $rows['image'] ?? '';
    } else {
        // Fallback query
        $que = "SELECT name, email, cnic FROM `acount_details` WHERE id = ?";
        $stmt = mysqli_prepare($conn, $que);
        mysqli_stmt_bind_param($stmt, "s", $userid);
        mysqli_stmt_execute($stmt);
        $ex = mysqli_stmt_get_result($stmt);

        if (!$ex) {
            die("Error in account details query: " . mysqli_error($conn));
        }

        $ro = mysqli_fetch_array($ex);
        $rowcount = mysqli_num_rows($ex);
        if ($rowcount == 1) {
            $account_detail_name = $ro['name'] ?? '';
            $account_detail_email = $ro['email'] ?? '';
            $account_detail_cnic = $ro['cnic'] ?? '';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Personal Info</title>
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
        #husbandFieldsContainer { transition: all 0.3s ease-in-out; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased">
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <!-- Main Content -->
    <main class="p-8 pt-24 w-full max-w-7xl mx-auto md:ml-72">
        <div class="bg-white p-8 rounded-xl shadow-lg">
           
            <!-- Advanced Navigation Tabs -->
            <?php include 'registration_form.php'; ?>

            <!-- Form -->
            <form id="first_person_form" action="per_info_processs.php" method="POST" class="space-y-8">
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                
                <!-- Basic Information -->
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4"><i class="fas fa-user mr-2"></i> Basic Information <span class="text-sm text-gray-500">(* Mandatory Fields)</span></h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Full Name <span class="required">*</span></label>
                            <input type="text" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_name" id="basic_name" value="<?php echo htmlspecialchars($account_detail_name); ?>" required>
                        </div>
                        <div>
                            <label class="form-label">Father Name <span class="required">*</span></label>
                            <input type="text" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_fname" id="basic_fname" value="<?php echo htmlspecialchars($basics_father); ?>" required>
                        </div>
                        <div>
                            <label class="form-label">Gender <span class="required">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_gender" id="basic_gender" required>
                                <option value="">Select</option>
                                <option value="male" <?php if ($basics_gender == "male") echo "selected"; ?>>Male</option>
                                <option value="female" <?php if ($basics_gender == "female") echo "selected"; ?>>Female</option>
                                <option value="transgender" <?php if ($basics_gender == "transgender") echo "selected"; ?>>Transgender</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Date of Birth <span class="required">*</span></label>
                            <input type="date" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_dob" id="basic_dob" value="<?php echo htmlspecialchars($basics_dob); ?>" onchange="checkAge(this.value)" required>
                            <span id="ageError" class="error-message"></span>
                        </div>
                        <div>
                            <label class="form-label">Domicile <span class="required">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_domicile" id="basic_domicile" onchange="prov()" required>
                                <option value="">Select Domicile</option>
                                <?php
                                $querys = "SELECT * FROM province";
                                $datas = mysqli_query($conn, $querys);
                                while ($rowss = mysqli_fetch_array($datas)) {
                                    $selected = ($rowss['id'] == $basics_domicile) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($rowss['id']) . "' $selected>" . htmlspecialchars(ucfirst($rowss['name'])) . "</option>";
                                }
                                ?>
                            </select>
                        </div>


                        <div>
                            <label class="form-label">disability if any  <span class="">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="disability" id="disability" >
                                <option value="">Select disability</option>
                               <option value="0">No</option>
                                 <option value="1">Yes</option>
                            </select>
                        </div>

                        

                        <div>
    <label class="form-label">Marital Status <span class="required">*</span></label>
    <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_status" id="basic_status" required>
        <option value="">Select</option>
        <option value="married" <?php if (isset($basics_status) && $basics_status == "married") echo "selected"; ?>>Married</option>
        <option value="unmarried" <?php if (isset($basics_status) && $basics_status == "unmarried") echo "selected"; ?>>Unmarried</option>
    </select>
</div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4"><i class="fas fa-phone mr-2"></i> Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Network <span class="required">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="network" id="network" required>
                                <option value="">Select Network</option>
                                <option value="Jazz" <?php if ($network == "Jazz") echo "selected"; ?>>Jazz</option>
                                <option value="Telenor" <?php if ($network == "Telenor") echo "selected"; ?>>Telenor</option>
                                <option value="Zong" <?php if ($network == "Zong") echo "selected"; ?>>Zong</option>
                                <option value="Ufone" <?php if ($network == "Ufone") echo "selected"; ?>>Ufone</option>
                                <option value="ONIC" <?php if ($network == "ONIC") echo "selected"; ?>>ONIC</option>
                                <option value="SCOM" <?php if ($network == "SCOM") echo "selected"; ?>>SCOM</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Personal Contact Number (03xx) <span class="required">*</span></label>
                            <input type="tel" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_phone" id="basic_phone" value="<?php echo htmlspecialchars($basics_contact_phone); ?>" pattern="03\d{9}" maxlength="11" required>
                            <span id="phone_error" class="error-message"></span>
                        </div>
                        <div>
                            <label class="form-label">WhatsApp Number</label>
                            <input type="tel" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_mobile" id="basic_mobile" value="<?php echo htmlspecialchars($basics_mobile); ?>" pattern="03\d{9}" maxlength="11">
                            <span id="mobile_error" class="error-message"></span>
                        </div>
                        <div>
                            <label class="form-label">CNIC Number <span class="required">*</span></label>
                            <input type="text" class="w-full p-3 border rounded-md bg-gray-100" name="basic_cnic" id="basic_cnic" value="<?php echo htmlspecialchars($account_detail_cnic); ?>" readonly>
                        </div>
                        <div>
                            <label class="form-label">Email Address <span class="required">*</span></label>
                            <input type="email" class="w-full p-3 border rounded-md bg-gray-100" name="basic_email" id="basic_email" value="<?php echo htmlspecialchars($account_detail_email); ?>" readonly>
                        </div>
                        <div>
                            <label class="form-label">Domicile District <span class="required">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_district" id="basic_district" required>
                                <option value="">Select District</option>
                            </select>
                            <input type="hidden" id="saved_district" value="<?php echo htmlspecialchars($basics_district); ?>">
                        </div>
                        <div>
                            <label class="form-label">City <span class="required">*</span></label>
                            <input type="text" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_city" id="basic_city" value="<?php echo htmlspecialchars($basics_city); ?>" required>
                        </div>
                        <div>
                            <label class="form-label">Religion <span class="required">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_religion" id="basic_religion" required>
                                <option value="">Select Religion</option>
                                <option value="muslim" <?php if ($basics_religion == "muslim") echo "selected"; ?>>Muslim</option>
                                <option value="Christianity" <?php if ($basics_religion == "Christianity") echo "selected"; ?>>Christianity</option>
                                <option value="Ahmadi" <?php if ($basics_religion == "Ahmadi") echo "selected"; ?>>Ahmadi</option>
                                <option value="Buddhist" <?php if ($basics_religion == "Buddhist") echo "selected"; ?>>Buddhist</option>
                                <option value="Sikhism" <?php if ($basics_religion == "Sikhism") echo "selected"; ?>>Sikhism</option>
                                <option value="Other" <?php if ($basics_religion == "Other") echo "selected"; ?>>Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Postal Address <span class="required">*</span></label>
                            <textarea class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_postal" id="basic_postal" rows="3" required><?php echo htmlspecialchars($basics_postal); ?></textarea>
                        </div>
                        <div>
                            <label class="form-label">Permanent Address <span class="required">*</span></label>
                            <textarea class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_permanent" id="basic_permanent" rows="3" required><?php echo htmlspecialchars($basics_permanent); ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Husband Fields -->
                <div id="husbandFieldsSection" class="card p-6 rounded-lg <?php echo ($basics_gender == 'female' && $basics_status == 'married') ? '' : 'hidden'; ?>">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4"><i class="fas fa-users mr-2"></i> For Married Female Candidates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="form-label">Applying Against Husband's Domicile?</label>
                            <div class="flex space-x-4">
                                <label class="flex items-center"><input type="radio" name="basic_husband" value="1" class="mr-2 basic_husband_radio" <?php if ($basics_female == "1") echo "checked"; ?>> Yes</label>
                                <label class="flex items-center"><input type="radio" name="basic_husband" value="0" class="mr-2 basic_husband_radio" <?php if ($basics_female == "0") echo "checked"; ?>> No</label>
                            </div>
                        </div>
                    </div>
                    <div id="husbandFieldsContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 <?php echo ($basics_female == "1") ? '' : 'hidden'; ?>">
                        <div>
                            <label class="form-label">Husband Name <span class="required">*</span></label>
                            <input type="text" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_husbandname" id="basic_husbandname" value="<?php echo htmlspecialchars($basics_female_husband); ?>">
                        </div>
                        <div>
                            <label class="form-label">Husband Domicile <span class="required">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basics_husband_province" id="sbasic_domicile" onchange="prov1()">
                                <option value="">Select Domicile</option>
                                <?php
                                $querys = "SELECT * FROM province";
                                $datas = mysqli_query($conn, $querys);
                                while ($rowss = mysqli_fetch_array($datas)) {
                                    $selected = ($rowss['id'] == $basics_husband_province) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($rowss['id']) . "' $selected>" . htmlspecialchars(ucfirst($rowss['name'])) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Husband Domicile District <span class="required">*</span></label>
                            <select class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="basic_husband_district" id="sbasic_district">
                                <option value="">Select District</option>
                            </select>
                            <input type="hidden" id="saved_husband_district" value="<?php echo htmlspecialchars($basics_husband_distric); ?>">
                        </div>
                    </div>
                </div>

                <!-- Response and Submit -->
                <div class="flex justify-between items-center">
                    <div id="response" class="text-sm"></div>
                    <div class="flex space-x-4">
                        <?php if (empty($undertaking) || $undertaking != 1) { ?>
                            <button type="button" class="px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all" id="basic_info_form_btn">Save & Next <i class="fas fa-arrow-right ml-2"></i></button>
                        <?php } else { ?>
                            <p class="text-green-600 font-semibold flex items-center"><i class="fas fa-check-circle mr-2"></i> Already Submitted</p>
                            <button type="button" class="px-6 py-3 bg-gray-400 text-white rounded-lg cursor-not-allowed" disabled>Save & Next</button>
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
        if (toggle && close && sidebar) {
            toggle.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
            close.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
        }

        // Age Check
        function checkAge(selectedDate) {
            const dob = new Date(selectedDate);
            const now = new Date();
            let age = now.getFullYear() - dob.getFullYear();
            if (now.getMonth() < dob.getMonth() || (now.getMonth() === dob.getMonth() && now.getDate() < dob.getDate())) age--;
            const error = document.getElementById("ageError");
            if (age < 18) {
                error.textContent = "Age must be at least 18 years.";
                document.getElementById("basic_dob").value = "";
            } else {
                error.textContent = "";
            }
        }

        // Phone Number Validation
        document.getElementById("basic_phone").addEventListener("input", function(e) {
            let phone = e.target.value.replace(/\D/g, '');
            e.target.value = phone.startsWith('03') ? phone : '03' + phone;
            document.getElementById("phone_error").textContent = phone.length < 11 ? "Phone number must be 11 digits." : "";
        });

        document.getElementById("basic_mobile").addEventListener("input", function(e) {
            let phone = e.target.value.replace(/\D/g, '');
            if (!phone.startsWith('03')) phone = '03' + phone;
            e.target.value = phone;
            document.getElementById("mobile_error").textContent = phone.length !== 11 ? "Phone number must be 11 digits." : "";
        });

        // Husband Fields Visibility
        const genderSelect = document.getElementById('basic_gender');
        const maritalStatusSelect = document.getElementById('basic_status');
        const husbandFieldsSection = document.getElementById('husbandFieldsSection');
        const husbandFieldsContainer = document.getElementById('husbandFieldsContainer');
        const husbandRadios = document.querySelectorAll('.basic_husband_radio');

        function updateHusbandFields() {
            const isMarriedFemale = (genderSelect.value === 'female' && maritalStatusSelect.value === 'married');
            const applyingHusbandDomicile = $("input[name='basic_husband']:checked").val();

            husbandFieldsSection.classList.toggle('hidden', !isMarriedFemale);

            if (isMarriedFemale) {
                husbandFieldsContainer.classList.toggle('hidden', applyingHusbandDomicile !== "1");
            } else {
                $("input[name='basic_husband']").prop('checked', false);
                $("#basic_husbandname").val('');
                $("#sbasic_domicile").val('');
                $("#sbasic_district").val('');
                husbandFieldsContainer.classList.add('hidden');
            }
        }

        updateHusbandFields();

        genderSelect.addEventListener('change', updateHusbandFields);
        maritalStatusSelect.addEventListener('change', updateHusbandFields);

        husbandRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const applyingHusbandDomicile = this.value;
                husbandFieldsContainer.classList.toggle('hidden', applyingHusbandDomicile !== "1");

                if (applyingHusbandDomicile !== "1") {
                    $("#basic_husbandname").val('');
                    $("#sbasic_domicile").val('');
                    $("#sbasic_district").val('');
                }
            });
        });

        // AJAX Form Submission
        $("#basic_info_form_btn").click(function() {
            const formData = $('#first_person_form').serialize();
            const requiredFields = ["basic_name", "basic_fname", "basic_gender", "basic_dob", "basic_domicile", "basic_status", "network", "basic_phone", "basic_cnic", "basic_email", "basic_district", "basic_city", "basic_religion", "basic_postal", "basic_permanent"];
            const husbandFields = ["basic_husbandname", "sbasic_domicile", "sbasic_district"];
            let isValid = true;

            requiredFields.forEach(id => {
                if (!$("#" + id).val()) {
                    isValid = false;
                    $("#" + id).addClass('border-red-500');
                } else {
                    $("#" + id).removeClass('border-red-500');
                }
            });

            const applyingHusbandDomicile = $("input[name='basic_husband']:checked").val();
            const isMarriedFemale = (genderSelect.value === 'female' && maritalStatusSelect.value === 'married');
            if (isMarriedFemale) {
                if (!applyingHusbandDomicile) {
                    isValid = false;
                    $("input[name='basic_husband']").closest('.flex').addClass('border-red-500 p-2 rounded');
                } else {
                    $("input[name='basic_husband']").closest('.flex').removeClass('border-red-500 p-2 rounded');
                    if (applyingHusbandDomicile === "1") {
                        husbandFields.forEach(id => {
                            if (!$("#" + id).val()) {
                                isValid = false;
                                $("#" + id).addClass('border-red-500');
                            } else {
                                $("#" + id).removeClass('border-red-500');
                            }
                        });
                    }
                }
            }

            if (!isValid) {
                $('#response').text("Please fill all required fields.").addClass('text-red-600');
                return;
            }

            $.ajax({
                url: "per_info_processs.php",
                type: "POST",
                data: formData,
                beforeSend: () => $('#response').text("Processing...").removeClass('text-red-600').addClass('text-teal-600'),
                success: (data) => {
                    if (data == 1) {
                        window.location.href = "qualification.php";
                    } else {
                        $('#response').text(data).removeClass('text-teal-600').addClass('text-red-600');
                    }
                },
                error: () => {
                    $('#response').text("An error occurred. Please try again.").addClass('text-red-600');
                }
            });
        });

        // Domicile District AJAX
        function prov() {
            const domicile = $("#basic_domicile").val();
            const savedDistrict = $("#saved_district").val();

            $.ajax({
                method: "POST",
                url: "admin-fgei/ajaxData.php",
                data: { basic_domicile: domicile },
                success: (data) => {
                    $("#basic_district").html(data);
                    if (savedDistrict) {
                        $("#basic_district").val(savedDistrict);
                    }
                },
                error: () => {
                    $("#basic_district").html('<option value="">Error loading districts</option>');
                }
            });
        }

        function prov1() {
            const husbandDomicile = $("#sbasic_domicile").val();
            const savedHusbandDistrict = $("#saved_husband_district").val();

            $.ajax({
                method: "POST",
                url: "admin-fgei/ajaxData.php",
                data: { sbasic_domicile: husbandDomicile },
                success: (data) => {
                    $("#sbasic_district").html(data);
                    if (savedHusbandDistrict) {
                        $("#sbasic_district").val(savedHusbandDistrict);
                    }
                },
                error: () => {
                    $("#sbasic_district").html('<option value="">Error loading districts</option>');
                }
            });
        }

        $(document).ready(() => {
            prov();
            $("#basic_domicile").on('change', prov);
            prov1();
            $("#sbasic_domicile").on('change', prov1);
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