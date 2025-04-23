<?php
include('connection/conn.php');
ini_set('display_errors', 1); // Enable error display for debugging
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION)) {
    session_start(); 
}

if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    // Sanitize and prepare form data
    $basic_full_name = mysqli_real_escape_string($conn, $_POST['basic_name']);
    $basic_father_name = mysqli_real_escape_string($conn, $_POST['basic_fname']);
    $basic_gender = mysqli_real_escape_string($conn, $_POST['basic_gender']);
    $basic_dob = mysqli_real_escape_string($conn, $_POST['basic_dob']);
    $basic_domicile = mysqli_real_escape_string($conn, $_POST['basic_domicile']);
    $basic_status = mysqli_real_escape_string($conn, $_POST['basic_status']);
    $network = mysqli_real_escape_string($conn, $_POST['network']);
    $basic_phone = mysqli_real_escape_string($conn, $_POST['basic_phone']);
    $basic_mobile = mysqli_real_escape_string($conn, $_POST['basic_mobile']);
    $basic_cnic = mysqli_real_escape_string($conn, $_POST['basic_cnic']);
    $basic_email = mysqli_real_escape_string($conn, $_POST['basic_email']);
    $basic_district = mysqli_real_escape_string($conn, $_POST['basic_district']);
    $basic_city = mysqli_real_escape_string($conn, $_POST['basic_city']);
    $basic_religion = mysqli_real_escape_string($conn, $_POST['basic_religion']);
    $basic_postal = mysqli_real_escape_string($conn, $_POST['basic_postal']);
    $basic_permanent = mysqli_real_escape_string($conn, $_POST['basic_permanent']);

    // Handle spouse-related fields
    $basic_husband = isset($_POST['basic_husband']) ? (int)$_POST['basic_husband'] : 0;
    $basic_husbandname = empty($_POST['basic_husbandname']) ? NULL : mysqli_real_escape_string($conn, $_POST['basic_husbandname']);
    $basic_husband_province = empty($_POST['basics_husband_province']) ? NULL : mysqli_real_escape_string($conn, $_POST['basics_husband_province']);
    $basic_husband_district = empty($_POST['basic_husband_district']) ? NULL : mysqli_real_escape_string($conn, $_POST['basic_husband_district']);

    // Log the received values for debugging
    error_log("Received Values - basic_husband: $basic_husband, basic_husbandname: $basic_husbandname, basic_husband_province: $basic_husband_province, basic_husband_district: $basic_husband_district");

    // Fetch existing data from the database for comparison
    $existing_data = [
        'per_info' => [],
        'per_info_contact' => [],
        'per_info_spouse' => []
    ];

    // Fetch from per_info
    $query_per_info = "SELECT * FROM per_info WHERE said = '$userid'";
    $result_per_info = mysqli_query($conn, $query_per_info);
    if ($result_per_info && mysqli_num_rows($result_per_info) > 0) {
        $existing_data['per_info'] = mysqli_fetch_assoc($result_per_info);
    }

    // Fetch from per_info_contact
    $query_contact = "SELECT * FROM per_info_contact WHERE said = '$userid'";
    $result_contact = mysqli_query($conn, $query_contact);
    if ($result_contact && mysqli_num_rows($result_contact) > 0) {
        $existing_data['per_info_contact'] = mysqli_fetch_assoc($result_contact);
    }

    // Fetch from per_info_spouse
    $query_spouse = "SELECT * FROM per_info_spouse WHERE said = '$userid'";
    $result_spouse = mysqli_query($conn, $query_spouse);
    if ($result_spouse && mysqli_num_rows($result_spouse) > 0) {
        $existing_data['per_info_spouse'] = mysqli_fetch_assoc($result_spouse);
    }

    // Compare submitted data with existing data
    $has_changes = false;

    // Compare per_info fields
    if (
        !empty($existing_data['per_info']) &&
        (
            $basic_full_name !== $existing_data['per_info']['basic_full_name'] ||
            $basic_father_name !== $existing_data['per_info']['basic_father_name'] ||
            $basic_gender !== $existing_data['per_info']['basic_gender'] ||
            $basic_dob !== $existing_data['per_info']['basic_dob'] ||
            $basic_domicile !== $existing_data['per_info']['basic_domicile'] ||
            $basic_status !== $existing_data['per_info']['basic_marital_status'] ||
            $basic_cnic !== $existing_data['per_info']['contact_cnic']
        )
    ) {
        $has_changes = true;
    }

    // Compare per_info_contact fields
    if (
        !empty($existing_data['per_info_contact']) &&
        (
            $network !== $existing_data['per_info_contact']['network'] ||
            $basic_phone !== $existing_data['per_info_contact']['contact_phone_no'] ||
            $basic_mobile !== $existing_data['per_info_contact']['contact_mobile'] ||
            $basic_email !== $existing_data['per_info_contact']['contact_email'] ||
            $basic_district !== $existing_data['per_info_contact']['contact_district'] ||
            $basic_city !== $existing_data['per_info_contact']['contact_city'] ||
            $basic_religion !== $existing_data['per_info_contact']['contact_religion'] ||
            $basic_postal !== $existing_data['per_info_contact']['contact_postal_address'] ||
            $basic_permanent !== $existing_data['per_info_contact']['contact_per_address']
        )
    ) {
        $has_changes = true;
    }

    // Compare per_info_spouse fields
    if (
        !empty($existing_data['per_info_spouse']) &&
        (
            $basic_husband != ($existing_data['per_info_spouse']['female_applying'] ?? 0) ||
            $basic_husbandname !== ($existing_data['per_info_spouse']['female_husband'] ?? NULL) ||
            $basic_husband_province !== ($existing_data['per_info_spouse']['female_husband_province'] ?? NULL) ||
            $basic_husband_district !== ($existing_data['per_info_spouse']['female_husband_district'] ?? NULL)
        )
    ) {
        $has_changes = true;
    }

    // If basic_husband is 1 and there is no existing spouse record, we need to insert
    if ($basic_husband == 1 && empty($existing_data['per_info_spouse'])) {
        $has_changes = true;
    }

    // If no record exists in per_info, we need to insert
    if (empty($existing_data['per_info'])) {
        $has_changes = true;
    }

    // If there are no changes, skip the update and redirect
    if (!$has_changes) {
        echo 1; // Success, redirect to qualification.php
        exit();
    }

    // Proceed with insert/update if there are changes
    $rowcount = !empty($existing_data['per_info']) ? 1 : 0;

    if ($rowcount == 1) {
        // Update existing records in the three tables
        // Update per_info
        $query_update_per_info = "UPDATE per_info SET 
            basic_full_name = '$basic_full_name',
            basic_father_name = '$basic_father_name',
            basic_gender = '$basic_gender',
            basic_dob = '$basic_dob',
            basic_domicile = '$basic_domicile',
            basic_marital_status = '$basic_status',
            contact_cnic = '$basic_cnic'
            WHERE said = '$userid'";
        $exe_per_info = mysqli_query($conn, $query_update_per_info);
        if (!$exe_per_info) {
            echo "Error updating per_info: " . mysqli_error($conn);
            exit();
        }

        // Update per_info_contact
        $query_update_contact = "UPDATE per_info_contact SET 
            network = '$network',
            contact_phone_no = '$basic_phone',
            contact_mobile = '$basic_mobile',
            contact_email = '$basic_email',
            contact_district = '$basic_district',
            contact_city = '$basic_city',
            contact_religion = '$basic_religion',
            contact_postal_address = '$basic_postal',
            contact_per_address = '$basic_permanent'
            WHERE said = '$userid'";
        $exe_contact = mysqli_query($conn, $query_update_contact);
        if (!$exe_contact) {
            // If no record exists in per_info_contact, insert one
            if (mysqli_affected_rows($conn) == 0) {
                $query_insert_contact = "INSERT INTO per_info_contact (
                    said, network, contact_phone_no, contact_mobile, contact_email, 
                    contact_district, contact_city, contact_religion, 
                    contact_postal_address, contact_per_address
                ) VALUES (
                    '$userid', '$network', '$basic_phone', '$basic_mobile', '$basic_email', 
                    '$basic_district', '$basic_city', '$basic_religion', 
                    '$basic_postal', '$basic_permanent'
                )";
                $exe_insert_contact = mysqli_query($conn, $query_insert_contact);
                if (!$exe_insert_contact) {
                    echo "Error inserting into per_info_contact: " . mysqli_error($conn);
                    exit();
                }
            } else {
                echo "Error updating per_info_contact: " . mysqli_error($conn);
                exit();
            }
        }

        // Update per_info_spouse
        if ($basic_husband == 1) {
            // Validate that all required husband fields are provided
            if (empty($basic_husbandname) || empty($basic_husband_province) || empty($basic_husband_district)) {
                echo "Please provide all required husband details.";
                exit();
            }

            // Check if a record already exists in per_info_spouse
            $query_check_spouse = "SELECT * FROM per_info_spouse WHERE said = '$userid'";
            $result_check_spouse = mysqli_query($conn, $query_check_spouse);
            if (mysqli_num_rows($result_check_spouse) > 0) {
                // Update existing record
                $query_update_spouse = "UPDATE per_info_spouse SET 
                    female_applying = '$basic_husband',
                    female_husband = " . ($basic_husbandname === NULL ? "NULL" : "'$basic_husbandname'") . ",
                    female_husband_province = " . ($basic_husband_province === NULL ? "NULL" : "'$basic_husband_province'") . ",
                    female_husband_district = " . ($basic_husband_district === NULL ? "NULL" : "'$basic_husband_district'") . "
                    WHERE said = '$userid'";
                $exe_spouse = mysqli_query($conn, $query_update_spouse);
                if (!$exe_spouse) {
                    echo "Error updating per_info_spouse: " . mysqli_error($conn);
                    exit();
                }
            } else {
                // Insert new record
                $query_insert_spouse = "INSERT INTO per_info_spouse (
                    said, female_applying, female_husband, female_husband_province, female_husband_district
                ) VALUES (
                    '$userid', '$basic_husband', 
                    " . ($basic_husbandname === NULL ? "NULL" : "'$basic_husbandname'") . ", 
                    " . ($basic_husband_province === NULL ? "NULL" : "'$basic_husband_province'") . ", 
                    " . ($basic_husband_district === NULL ? "NULL" : "'$basic_husband_district'") . "
                )";
                $exe_spouse = mysqli_query($conn, $query_insert_spouse);
                if (!$exe_spouse) {
                    echo "Error inserting into per_info_spouse: " . mysqli_error($conn);
                    exit();
                }
            }
        } else {
            // If basic_husband is 0, delete any existing record in per_info_spouse
            $delete_spouse_query = "DELETE FROM per_info_spouse WHERE said = '$userid'";
            $exe_delete_spouse = mysqli_query($conn, $delete_spouse_query);
            if (!$exe_delete_spouse) {
                echo "Error deleting from per_info_spouse: " . mysqli_error($conn);
                exit();
            }
        }

        echo 1; // Success
    } else {
        // Insert new records into the three tables
        // Insert into per_info
        $query_insert_per_info = "INSERT INTO per_info (
            basic_full_name, basic_father_name, basic_gender, basic_dob, 
            basic_domicile, basic_marital_status, contact_cnic, said
        ) VALUES (
            '$basic_full_name', '$basic_father_name', '$basic_gender', '$basic_dob', 
            '$basic_domicile', '$basic_status', '$basic_cnic', '$userid'
        )";
        $exe_per_info = mysqli_query($conn, $query_insert_per_info);
        if (!$exe_per_info) {
            echo "Error inserting into per_info: " . mysqli_error($conn);
            exit();
        }

        // Insert into per_info_contact
        $query_insert_contact = "INSERT INTO per_info_contact (
            said, network, contact_phone_no, contact_mobile, contact_email, 
            contact_district, contact_city, contact_religion, 
            contact_postal_address, contact_per_address
        ) VALUES (
            '$userid', '$network', '$basic_phone', '$basic_mobile', '$basic_email', 
            '$basic_district', '$basic_city', '$basic_religion', 
            '$basic_postal', '$basic_permanent'
        )";
        $exe_contact = mysqli_query($conn, $query_insert_contact);
        if (!$exe_contact) {
            echo "Error inserting into per_info_contact: " . mysqli_error($conn);
            exit();
        }

        // Insert into per_info_spouse if basic_husband is 1
        if ($basic_husband == 1) {
            // Validate that all required husband fields are provided
            if (empty($basic_husbandname) || empty($basic_husband_province) || empty($basic_husband_district)) {
                echo "Please provide all required husband details.";
                exit();
            }

            $query_insert_spouse = "INSERT INTO per_info_spouse (
                said, female_applying, female_husband, female_husband_province, female_husband_district
            ) VALUES (
                '$userid', '$basic_husband', 
                " . ($basic_husbandname === NULL ? "NULL" : "'$basic_husbandname'") . ", 
                " . ($basic_husband_province === NULL ? "NULL" : "'$basic_husband_province'") . ", 
                " . ($basic_husband_district === NULL ? "NULL" : "'$basic_husband_district'") . "
            )";
            $exe_spouse = mysqli_query($conn, $query_insert_spouse);
            if (!$exe_spouse) {
                echo "Error inserting into per_info_spouse: " . mysqli_error($conn);
                exit();
            }
        }

        echo 1; // Success
    }
} else {
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>