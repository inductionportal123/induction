<?php
include('connection/conn.php');
if (!isset($_SESSION)) {
session_start();
}


    // Set the session timeout period (in seconds)
$timeout = 3 * 60; // 15 minutes

// Check if the session has timed out
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    // If session has expired, destroy the session and redirect to the login page
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session
    header("Location: login.php"); // Redirect to the login page
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();



if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
$user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];
    $query = "SELECT * FROM `per_info` WHERE said = '" . $userid . "'";
    $exes = mysqli_query($conn, $query);
    
    if (!$exes) {
    die("Error in query: " . mysqli_error($conn)); // Display the MySQL error
}

    $rows = mysqli_fetch_array($exes);
    $rowcounts = mysqli_num_rows($exes);
    if ($rowcounts == 1) {
    $dataset = "ok";
    $account_detail_name = $rows['basic_full_name'];
    $basics_father = $rows['basic_father_name'];
    $basics_gender = $rows['basic_gender'];
    $basics_dob = $rows['basic_dob'];
    $basics_domicile = $rows['basic_domicile'];
    $basics_status = $rows['basic_marital_status'];
    $network = $rows['network'];
    $basics_contact_phone = $rows['contact_phone_no'];
    $highest_qualification = $rows['highest_qualification'];
    $basics_mobile = $rows['contact_mobile'];
    $account_detail_cnic = $rows['contact_cnic'];
    $account_detail_email = $rows['contact_email'];
    $basics_district = $rows['contact_district'];
    $basics_district_code = $rows['contact_district_code'];
    $basics_city = $rows['contact_city'];
    $basics_religion = $rows['contact_religion'];
    $basics_postal = $rows['contact_postal_address'];
    $basics_permanent = $rows['contact_per_address'];
    $undertaking = $rows['undertaking'];
    if ($rows['female_applying'] == 2) {
    $basics_female = "not";
    } else {
    $basics_female = $rows['female_applying'];
    }
    if ($rows['female_husband'] == "NULL") {
    $basics_female_husband = "null";
    } else {
    $basics_female_husband = $rows['female_husband'];
    }
    if ($rows['female_husband_province'] == "NULL") {
    $basics_husband_province = "null";
    } else {
    $basics_husband_province = $rows['female_husband_province'];
    }
    if ($rows['female_husband_district'] == "NULL") {
    $basics_husband_distric = "null";
    } else {
    $basics_husband_distric = $rows['female_husband_district'];
    }
    if ($rows['female_husband_district_code'] == "NULL") {
    $basics_husband_distric_code = "null";
    } else {
    $basics_husband_distric_code = $rows['female_husband_district_code'];
    }
    } else {
    $que = "SELECT * FROM `acount_details` WHERE id = '" . $userid . "'";
    $ex = mysqli_query($conn, $que);
    $ro = mysqli_fetch_array($ex);
    $rowcount = mysqli_num_rows($ex);
    if ($rowcount == 1) {
    $datast = "ok";
    $account_detail_name = $ro['name'];
    $account_detail_email = $ro['email'];
    $account_detail_cnic = $ro['cnic'];
    }
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>FGEI (C/G) - Recruitment</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <link rel="stylesheet" href="css/styles.css">
    </head>
    
    <!-- -------------- added this extra start  -------- -->
    <link rel="stylesheet" href="css/per_info.css">


    <!-- -------------- added this extra start  -------- -->
    <script>
        function closeNav() {
            document.getElementById("mysidebar").style.width = "0"

        }

        function openNav() {
            document.getElementById("mysidebar").style.width = "250px";
            
        }
    </script>
    <!-- -------------- added this extra start  -------- -->
    
    
       <script>
        let timeout;

        // Set timeout period (in milliseconds, e.g., 15 minutes)
        const timeoutPeriod = 3 * 60 * 1000; // 15 minutes

        // Reset the timeout whenever there's user activity
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;

        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(logout, timeoutPeriod);
        }

        // Logout function to redirect to the logout page
        function logout() {
            window.location.href = "logout.php";  // Redirect to logout page after timeout
        }

        // Start the timer initially
        resetTimer();
    </script>

    
    <script>
    $(document).ready(function() {
    $("#exampleModal").modal('show');
    });
    </script>
    <script type="text/javascript">
    function myFunction() {
    return confirm('Are you sure you want to submit this information?');
    }
    function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
    return true;
    }
    </script>
    <body>
    <div class="wrapper hover_collapse">
    <?php include('header.php'); ?>
    <div class="sidebar" id="mysidebar">
    <div class="sidebar_inner">
    <ul>
        
        
        <!-- -------------- added this extra start  -------- -->
                        <li class="closebtn"> <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a></li>
                        <li>
                            <!-- -------------- added this extra end  -------- -->
                            
                            
                            
    <li>
        <img src="images/logo.png" width="70%" height="70%" style="margin:30px;">
    </li>
    <li>
        <a href="profile.php">
            <span class="icon"><i class="fas fa-user" title="profile"></i></span>
            <span class="text">Profile</span>
        </a>
    </li>
    <li>
        <a href="per_info.php" style="background: #292323;">
            <span class="icon"><i class="fas fa-edit" title="Personal Info"></i></span>
            <span class="text">Personal Info</span>
        </a>
    </li>
    <li>
        <a href="resetpassword.php">
            <span class="icon"><i class="fas fa-key" title="Reset Password"></i></span>
            <span class="text">Reset Password</span>
        </a>
    </li>
    <li>
        <a href="queryportal.php">
            <span class="icon"><i class="fas fa-comment" title="Query Portal"></i></span>
            <span class="text">Query Portal</span>
        </a>
    </li>
    <li>
        <a href="logout.php">
            <span class="icon"><i class="fas fa-sign-out-alt" title="Logout"></i></span>
            <span class="text">Logout</span>
        </a>
    </li>
    </ul>
    </div>
    </div>
    <!-- --------------------------------------body working------------------------------------------ -->
    <div class="main_container">
    <div class="container">
    <div class="content">
    <div class="row">
        <!-- -------------- added this extra start  -------- -->
                                <span class="added" style="font-size:30px;cursor:pointer " onclick="openNav()">&#9776;</span>

                                <!-- -------------- added this extra start  -------- -->
        <div class="col-sm-12 col-md-12 col-lg-12">
            
            <h2 class="heading">Registration Form</h2>
            <br>
<!--          <div class="alert alert-danger alert-dismissible fade show" role="alert">-->
<!--    <strong>Registration Closed!</strong> The registration date has now ended. If you have already applied and submitted the form, please visit <a href="profile.php" class="alert-link">Profile</a> for other updates. It will show in the profile section of this portal.-->
<!--    <button type="button" class="close" data-dismiss="alert" aria-label="Close">-->
<!--        <span aria-hidden="true">&times;</span>-->
<!--    </button>-->
<!--</div>-->

            <!-- Nav pills -->
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="per_info.php">Personal Info <br> ذاتی معلومات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="qualification.php">Qualification <br> قابلیت</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  " href="post_apply.php">Post Apply <br> پوسٹ اپلائی کریں۔</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="challan.php">Challan Form <br> چالان فارم</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="documents.php">Upload Documents <br> دستاویزات اپ لوڈ کریں۔</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="undertaking.php">Undertaking <br> انڈرٹیکنگ</a>
                </li>
            </ul>
            

            
       
    
    
            <div class="tab-content">
                <div id="perid" class="container tab-pane active"><br>
                    <form id="first_person_form">
                        <div class="row">
                            <div class="col-sm-10 col-xs-10 col-md-10 col-lg-10">
                                <h6><kbd>Basic information:</kbd></h6>
                            </div>
                            <div class="col-sm-2 col-xs-2 col-md-2 col-lg-2"><sub class="fieldrequired"> *</sub> <b>Mandatory Fields</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Full Name: <br>(پورا نام)</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" name="basic_name" value="<?php if (isset($account_detail_name)) {
                                    echo $account_detail_name;
                                                                                                    } ?>" id="basic_name" />
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Father Name:<br> (والد کا نام)</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" name="basic_fname" value="<?php if (isset($basics_father)) {
                                             echo $basics_father;
                                                                                                    } ?>" id="basic_fname">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Gender:<br> (صنف)</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <select class="form-control" name="basic_gender" id="basic_gender">
                                    <option value="">Select</option>
                                    <option value="male" <?php if (isset($basics_gender) && $basics_gender == "male") { ?> selected <?php } ?>>Male</option>
                                    <option value="female" <?php if (isset($basics_gender) && $basics_gender == "female") { ?> selected <?php } ?>>Female</option>
                                    <option value="transgender" <?php if (isset($basics_gender) && $basics_gender == "transgender") { ?> selected <?php } ?>>Transgender</option>
                                </select>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Date of Birth:<br>(پیدائش کی تاریخ)</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <input placeholder="dd-mm-yyyy" type="date" class="form-control" name="basic_dob" value="<?php if (isset($basics_dob)) {
                                            echo $basics_dob;
                                   } ?>" id="basic_dob" onchange="checkAge(this.value)">
                                <span id="ageError" style="color: red;"></span>
                            </div>

                            <script>
                                function checkAge(selectedDate) {
                                    var dob = new Date(selectedDate);
                                    var now = new Date();
                                    var age = now.getFullYear() - dob.getFullYear();
                                    if (now.getMonth() < dob.getMonth() || (now.getMonth() === dob.getMonth() && now.getDate() < dob.getDate())) {
                                        age--;
                                    }
                                    if (age < 18) {
                                        document.getElementById("ageError").textContent = "Error: Age must be at least 18 years.";
                                        document.getElementById("basic_dob").value = ""; // Clear the input field
                                    } else {
                                        document.getElementById("ageError").textContent = "";
                                    }
                                }
                            </script>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Domicile:</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">

                                <select class="form-control" onchange="prov()" name="basic_domicile" id="basic_domicile">
                                    <option>select domicile</option>
                                    <?php
                                    $querys = "SELECT * FROM province";
                                    $datas = mysqli_query($conn, $querys);
                                    $rowcounts = mysqli_num_rows($datas);
                                    if ($rowcounts > 0) {
                                        while ($rowss = mysqli_fetch_array($datas)) {
                                            // Check if the option ID matches the selected option in the per_info table
                                            $selected = ($rowss['id'] == $basics_domicile) ? 'selected' : '';
                                    ?>
                                            <option value="<?= $rowss['id'] ?>" <?= $selected ?>><?= ucfirst($rowss['name']) ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Marital Status:</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <select class="form-control" name="basic_status" id="basic_status">
                                    <option value=''>select</option>

                                    <option value="married" <?php if (isset($basics_status) && $basics_status == "married") { ?> selected <?php } ?>>Married</option>
                                    <option value="unmarried" <?php if (isset($basics_status) && $basics_status == "unmarried") { ?> selected <?php } ?>>Unmarried</option>
                                </select>
                            </div>
                        </div>
                        <!-- -----------------------------end of main information--------------------------- -->
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                                <h6><kbd>Contact information:</kbd></h6>
                            </div>
                    </div>
                        <div class="row">
    <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
    <h5><b>Network</b><sub class="fieldrequired"></sub>*</h5>
    </div>
    <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
    <select name="network" id="network" required class="form-control">
    <option value="">Select Network</option>
    <option value="Jazz" <?php if (isset($network) && $network == "Jazz") { ?> selected <?php } ?> >Jazz</option>
    <option value="Telenor" <?php if (isset($network) && $network == "Telenor") { ?> selected <?php } ?> >Telenor</option>
    <option value="Zong" <?php if (isset($network) && $network == "Zong") { ?> selected <?php } ?>>Zong</option>
    <option value="Ufone" <?php if (isset($network) && $network == "Ufone") { ?> selected <?php } ?>>Ufone</option>
    <option value="ONIC" <?php if (isset($network) && $network == "ONIC") { ?> selected <?php } ?>>ONIC</option>
    <option value="SCOM" <?php if (isset($network) && $network == "SCOM") { ?> selected <?php } ?>>SCOM</option>
    </select>
    </div>
    </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Personal Contact Number: (03xx) <br> ذاتی رابطہ نمبر:</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
    <input type="tel" class="form-control" name="basic_phone" value="<?php if (isset($basics_contact_phone)) { echo $basics_contact_phone; } ?>" id="basic_phone" pattern="03\d{9}" maxlength="11" required>
    <div id="phone_error" class="error-message"></div> <!-- New div for displaying error message -->
    </div>

    <script>
    // Add "03" prefix to the input field automatically
    document.getElementById("basic_phone").addEventListener("input", function(event) {
    var phone = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters
    event.target.value = phone.startsWith('03') ? phone : '03' + phone;

    // Check if the phone number is less than 11 digits
    if (phone.length < 11) {
    document.getElementById("phone_error").textContent = "Phone number must be 11 digits long.";
    event.target.setCustomValidity("Phone number must be 11 digits long.");

    } else {
    document.getElementById("phone_error").textContent = ""; // Clear error message
    event.target.setCustomValidity("");
    }
    });
    </script>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>WhatsApp Number:<br>واٹس ایپ نمبر</b></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
    <input type="tel" class="form-control" name="basic_mobile" value="<?php if (isset($basics_mobile)) { echo $basics_mobile; } ?>" id="basic_mobile" pattern="03\d{9}" maxlength="11">
    <div id="mobile_error" class="error-message"></div> <!-- New div for displaying error message -->
    </div>
    <script>
    document.getElementById("basic_mobile").addEventListener("input", function(event) {
    var phone = event.target.value.replace(/\D/g, ''); // Remove non-numeric characters

    // Prefix "03" if not present
    if (!phone.startsWith('03')) {
    phone = '03' + phone;
    }
    // Check if the phone number is less than or greater than 11 digits
    if (phone.length !== 11) {
    document.getElementById("mobile_error").textContent = "Phone number must be 11 digits long.";
    event.target.setCustomValidity("Phone number must be 11 digits long.");
    } else {
    document.getElementById("mobile_error").textContent = ""; // Clear error message
    event.target.setCustomValidity("");
    }
    // Update the input value
    event.target.value = phone;
    });
    // Handle form submission
    document.querySelector("form").addEventListener("submit", function(event) {
    var phone = document.getElementById("basic_mobile").value.replace(/\D/g, '');
    if (phone.length !== 11) {
    event.preventDefault(); // Prevent form submission
    document.getElementById("mobile_error").textContent = "Phone number must be 11 digits long.";
    }
    });
    </script>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>CNIC NO: <br> شناختی کارڈ نمبر</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" value="<?php if (isset($account_detail_cnic)) {
                                           echo $account_detail_cnic;                                             } ?>" name="basic_cnic" id="basic_cnic" readonly />
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Email Address: <br> ای میل اڈریس</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" value="<?php if (isset($account_detail_email)) {
                                                                                    echo $account_detail_email;
                                                                                } ?>" name="basic_email" id="basic_email" readonly />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Domicile District: <br> ڈومیسائل ڈسٹرکٹ</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <select class="form-control" id="basic_district" name="basic_district" required>

                                </select>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>City: <br> شہر</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <input type="text" class="form-control" name="basic_city" value="<?php if (isset($basics_city)) {
                                      echo $basics_city;
                                                    } ?>" id="basic_city">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Religion: <br> مذہب</b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <select class="form-control" name="basic_religion" id="basic_religion">
                                    <option value="">Select you religion.</option>
                                    <option value="muslim" <?php if (isset($basics_religion) && $basics_religion == "muslim") { ?> selected <?php } ?>>Muslim</option>
                                    <option value="Christianity" <?php if (isset($basics_religion) && $basics_religion == "Christianity") { ?> selected <?php } ?>>Christianity</option>
                                    <option value="Ahmadi" <?php if (isset($basics_religion) && $basics_religion == "Ahmadi") { ?> selected <?php } ?>>Ahmadi</option>
                                    <option value="Buddhist" <?php if (isset($basics_religion) && $basics_religion == "Buddhist") { ?> selected <?php } ?>>Buddhist</option>
                                    <option value="Sikhism" <?php if (isset($basics_religion) && $basics_religion == "Sikhism") { ?> selected <?php } ?>>Sikhism</option>
                                    <option value="Other" <?php if (isset($basics_religion) && $basics_religion == "Other") { ?> selected <?php } ?>>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Postal Address: <br> ڈاک کا پتا </b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <textarea rows="4" cols="5" class="form-control" name="basic_postal" id="basic_postal" placeholder="Enter Here ...."><?php if (isset($basics_postal)) {
                                    echo $basics_postal;
                                } ?> </textarea>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                <h5><b>Permanent Address: <br> مستقل پتہ </b><sub class="fieldrequired"> *</sub></h5>
                            </div>
                            <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                <textarea rows="4" class="form-control" cols="5" name="basic_permanent" id="basic_permanent" placeholder="Enter Here ...."><?php if (isset($basics_permanent)) {
                                           echo $basics_permanent;
                                                          } ?></textarea>
                            </div>
                        </div>
                        <br>
                        <div id="husbandFieldsContainer" style="display: none;">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
                                    <h6><kbd>only for married female candidates:</kbd></h6>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-xs-12 col-md-5 col-lg-5">
                                    <h5><b>Are you appliying against your husband Domicile?</b></h5>
                                </div>
                                <div class="col-sm-12 col-xs-12 col-md-7 col-lg-7">
                                    <kbd><input type="radio" value="1" name="basic_husband" id="basic_husband" <?php if (isset($basics_female) && $basics_female == 1) { ?> checked <?php } ?>> Yes </kbd>&nbsp;&nbsp;&nbsp;
                                    <kbd><input type="radio" value="0" name="basic_husband" id="basic_husband" <?php if (isset($basics_female) && $basics_female == 0) { ?> checked <?php } ?>> No &nbsp;</kbd>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                    <h5><b>Husband Name:</b><sub class="fieldrequired"> *</sub></h5>
                                </div>
                                <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
                                    <input type="text" name="basic_husbandname" id="basic_husbandname" value="<?php if (isset($basics_female_husband)) {
                                     echo $basics_female_husband;
                                                                        } ?>" class="form-control">
                                </div>
                                <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
                                    <h5><b>Husband Domicile<sub class="fieldrequired"> *</sub><small style="display: block;">Domicile Region:</small></b></h5>
                                </div>
                                <div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">


                                <select class="form-control" onchange="prov1()" name="basics_husband_province" id="sbasic_domicile">
    <option value="">select domicile</option>
    <?php
    $querys = "SELECT * FROM province";
    $datas = mysqli_query($conn, $querys);
    $rowcounts = mysqli_num_rows($datas);
    if ($rowcounts > 0) {
        while ($rowss = mysqli_fetch_array($datas)) {
            // Check if the option ID matches the selected option in the per_info table
            $selected = ($rowss['id'] == $basics_husband_province) ? 'selected' : '';
            ?>
            <option value="<?= $rowss['id'] ?>" <?= $selected ?>><?= ucfirst($rowss['name']) ?></option>
            <?php
        }
    }
    ?>
</select>




                                




                                    <!-- <select class="form-control" name="basics_husband_province" onchange="prov1()" id="sbasic_domicile" required>
                                        <option value="">Select Province</option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '1') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="1">Punjab</option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '4') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="4">Sindh (Urban)</option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '5') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="5">Sindh (Rural)</option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '3') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="3">Balochistan</option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '2') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="2">Khyber Pakhtunkhwa</option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '8') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="8">Gilgit Baltistan </option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '7') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="7">FATA</option>
                                        <option <?php
                                                if (isset($basics_husband_province)) {
                                                    if ($basics_husband_province == '6') {
                                                ?> selected <?php
                                                        }
                                                    }
                                                            ?> value="6">AJK</option>
                                    </select> -->
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-sm-6 col-xs-6 col-md-2 col-lg-2">
    <h5><b>Husband Domicile District:</b><sub class="fieldrequired"> *</sub></h5>
</div>
<div class="col-sm-6 col-xs-6 col-md-4 col-lg-4">
    <select class="form-control" id="sbasic_district" required name="basic_husband_district">
    </select>
</div>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-8 col-xs-8 col-md-8 col-lg-8" align="left">
                                <div id="response"></div>
                            </div>
                            <div class="col-sm-4 col-xs-4 col-md-4 col-lg-4" align="right">
                                <?php
                                if (!isset($undertaking) || $undertaking != 1){ ?>
 <input type="button" class="btn btn-lg btn-info" style="margin-bottom: 10px;border: none; outline: none;" name="basic_info_form_btn" id="basic_info_form_btn"    value="Save & Next">
 
                                <?php } elseif ($undertaking == 1) { ?>
<p style="font-size: 16px; color: green; "><?php echo "Already Submitted"  ?></p><input type="button" class="btn btn-lg btn-info" style="margin-bottom: 10px;border: none; outline: none;" name="basic_info_form_btn" id="basic_info_form_btn" value="Save & Next" disabled  >

             <?php
                                }
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <script src="script/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script type="text/javascript">
    $(document).ready(function() {
    $("#basic_info_form_btn,#basic_info_form_btn_update").click(function() {
    var basic_full_name = $("#basic_name").val();
    var basic_father_name = $("#basic_fname").val();
    var basic_gender = $("#basic_gender").val();
    var basic_dob = $("#basic_dob").val();
    var basic_domicile = $("#basic_domicile").val();
    var basic_status = $("#basic_status").val();
    var network = $("#network").val();
    var basic_phone = $("#basic_phone").val();
    var basic_mobile = $("#basic_mobile").val();
    var basic_cnic = $("#basic_cnic").val();
    var basic_email = $("#basic_email").val();
    var basic_district = $("#basic_district").val();
    var basic_city = $("#basic_city").val();
    var basic_religion = $("#basic_religion").val();
    var basic_postal = $("#basic_postal").val();
    var basic_permanent = $("#basic_permanent").val();

    var basic_husband = $("input[name='basic_husband']:checked").val();
    var basic_husbandname = $("#basic_husbandname").val();
    var basics_husband_province = $("#basics_husband_province").val();
    var basic_husband_district = $("#basic_husband_district").val();
    var basic_husband_districtcode = $("#basic_husband_districtcode").val();
    if (basic_full_name == "" || basic_father_name == "" || basic_gender == "" || network == "" || basic_dob == "" || basic_domicile == "" || basic_status == "" ||  basic_phone == "" || basic_mobile == ""  || basic_cnic == "" || basic_email == "" || basic_district == "" || basic_city == "" || basic_religion == "" || basic_postal == "" || basic_permanent == "") {
    $('#response').fadeIn();
    $('#response').addClass('error-msg').html("All Field Are Required (with the red star)");
    exit;
    }
    if (basic_husband == 1) {
    if (basic_husbandname == "" || basics_husband_province == "" || basic_husband_district == "" || basic_husband_districtcode == "") {
        $('#response').fadeIn();
        $('#response').addClass('error-msg').html("Please fill all the field if you are applying against husabnd's domicile");
    } else {
        $.ajax({
            url: "per_info_processs.php",
            type: "POST",
            data: $('#first_person_form').serialize(),
            beforesend: function() {
                $('#response').fadeIn();
                $('#response').removeClass('error-msg').addClass('process-msg').html("Processing....");
            },
            success: function(data) {
                if (data == 1) {
                    window.location.href = "qualification.php";
                } else {
                    $('#response').fadeIn();
                    $('#response').addClass('error-msg').html(data);
                }
            }
        });
    }
    } else {
    $.ajax({
        url: "per_info_processs.php",
        type: "POST",
        data: $('#first_person_form').serialize(),
        beforesend: function() {
            $('#response').fadeIn();
            $('#response').removeClass('error-msg').addClass('process-msg').html("Processing....");
        },
        success: function(data) {
            if (data == 1) {
                window.location.href = "qualification.php";
            } else {
                $('#response').fadeIn();
                $('#response').addClass('error-msg').html(data);
            }
        }
    });
    }
    });
    });
    </script>



<script>
    prov1();
    // Define the function prov1
    function prov1() {
        var basic_domiciless = $("#sbasic_domicile").val(); // Get the value of the basic_domicile dropdown

        // Perform AJAX request
        $.ajax({
            method: "POST",
            url: "admin-fgei/ajaxData.php",
            data: {
                sbasic_domicile: basic_domiciless
            },
            dataType: "html",
            success: function(data) {
                // Update the HTML of the sbasic_district dropdown with the received data
                $("#sbasic_district").html(data);
            },
            error: function(xhr, status, error) {
                // Handle any errors that occur during the AJAX request
                console.error(xhr.responseText);
            }
        });
    }

    // Call the prov1 function when the basic_domicile dropdown changes
    $(document).ready(function() {
        $("#sbasic_domicile").on('change', prov1);
    });
</script>






    <!-- <script>
    $("#sbasic_domicile").on('change', function() {
    var basic_domiciless = $(this).val();

    $.ajax({
    method: "POST",
    url: "admin-fgei/ajaxData.php",
    data: {
    basic_domicile: basic_domiciless
    },
    dataType: "html",
    success: function(data) {

    $("#sbasic_district").html(data);

    $("#sbasic_district").html(data);

    }
    });
    });
    </script> -->

    <script>
    // Define the function prov
    prov();

    function prov() {
    var basic_domiciless = $("#basic_domicile").val(); // Get the value of the basic_domicile dropdown

    // Perform AJAX request
    $.ajax({
    method: "POST",
    url: "admin-fgei/ajaxData.php",
    data: {
    basic_domicile: basic_domiciless
    },
    dataType: "html",
    success: function(data) {
    // Update the HTML of the basic_district dropdown with the received data
    $("#basic_district").html(data);
    },
    error: function(xhr, status, error) {
    // Handle any errors that occur during the AJAX request
    console.error(xhr.responseText);
    }
    });
    }

    // Call the prov function when the basic_domicile dropdown changes
    $(document).ready(function() {
    $("#basic_domicile").on('change', prov);
    });
    </script>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <br><br><br><br> <br><br><br><br>

    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
    <div class="modal-header bg-primary text-white">
    <h5 class="modal-title text-center w-100" id="exampleModalLabel">Important Instructions</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
    <div class="alert alert-info" role="alert">
        Please carefully read the following instructions before proceeding:
    </div>
    <ul class="list-group ">
        <li class="list-group-item">- Read the eligibility criteria published in the newspaper carefully and fill the form for the relevant post.</li>
        <li class="list-group-item">- Fill the application form properly with complete and correct information/answers. Name, Father Name, and Date of Birth must be filled as per Matriculation certificate.</li>
        <li class="list-group-item">- Applications received after the closing date will not be entertained.</li>
        <li class="list-group-item">- Intimation regarding written test/interview will be sent via SMS service or through the login account. Therefore, provide an active mobile number for information communication. Moreover, do not provide a mobile number that is ported out to another network, otherwise, FGEI Dte will not be responsible for non-delivery of SMS.</li>
        <li class="list-group-item">- FGEI Dte will not be responsible for any wrong information/entry by the candidate, and no fee will be refunded.</li>
        <li class="list-group-item">- After the application submission, the application status will be displayed in the <b>profile</b>.</li>
    </ul>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" id="acceptBtn">Close</button>
    </div>
    </div>
    </div>
    </div>
    <script>
    document.getElementById('acceptBtn').addEventListener('click', function() {
    $('#exampleModal').modal('hide');
    });
    </script>
    <!-- script to handle visibility of husband-related fields -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    var genderSelect = document.getElementById('basic_gender');
    var maritalStatusSelect = document.getElementById('basic_status');
    var husbandFieldsContainer = document.getElementById('husbandFieldsContainer');

    function updateHusbandFieldsVisibility() {
    if (genderSelect.value === 'female' && maritalStatusSelect.value === 'married') {
    husbandFieldsContainer.style.display = 'block';
    } else {
    husbandFieldsContainer.style.display = 'none';
    }
    }
    // Initial visibility update
    updateHusbandFieldsVisibility();
    // Event listeners for changes in gender and marital status
    genderSelect.addEventListener('change', updateHusbandFieldsVisibility);
    maritalStatusSelect.addEventListener('change', updateHusbandFieldsVisibility);
    });
    </script>
    </body>
    </html>
    <?php
    } else {
    header("Location: index.php");
    }
    ?>