<?php
include('connection/conn.php');
ini_set('display_errors', 0); // Disable display errors in production
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    header("Location: index.php");
    exit();
}

// User data from session
$user = $_SESSION['u_name'];
$userid = $_SESSION['u_id'];

// Required fields
$required_fields = [
    'basic_name', 'basic_fname', 'basic_gender', 'basic_dob', 'basic_domicile',
    'basic_status', 'network', 'basic_phone', 'disability', 'basic_mobile',
    'basic_cnic', 'basic_email', 'basic_district', 'basic_city', 'basic_religion',
    'basic_postal', 'basic_permanent'
];

// Validate required POST fields
foreach ($required_fields as $field) {
    if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
        log_error("Missing or empty required field: $field");
        echo json_encode(['status' => 'error', 'message' => 'All required fields must be filled.']);
        exit();
    }
}

// Sanitize and prepare form data
$basic_full_name = trim($_POST['basic_name']);
$basic_father_name = trim($_POST['basic_fname']);
$basic_gender = trim($_POST['basic_gender']);
$basic_dob = trim($_POST['basic_dob']);
$basic_domicile = trim($_POST['basic_domicile']);
$basic_status = trim($_POST['basic_status']);
$network = trim($_POST['network']);
$basic_phone = trim($_POST['basic_phone']);
$disability = trim($_POST['disability']);
$basic_mobile = trim($_POST['basic_mobile']);
$basic_cnic = trim($_POST['basic_cnic']);
$basic_email = trim($_POST['basic_email']);
$basic_district = trim($_POST['basic_district']);
$basic_city = trim($_POST['basic_city']);
$basic_religion = trim($_POST['basic_religion']);
$basic_postal = trim($_POST['basic_postal']);
$basic_permanent = trim($_POST['basic_permanent']);

// Validate critical fields
if (!filter_var($basic_email, FILTER_VALIDATE_EMAIL)) {
    log_error("Invalid email format: $basic_email");
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit();
}
if (!preg_match('/^\d{10,15}$/', $basic_phone) || !preg_match('/^\d{10,15}$/', $basic_mobile)) {
    log_error("Invalid phone number format: $basic_phone or $basic_mobile");
    echo json_encode(['status' => 'error', 'message' => 'Invalid phone number format.']);
    exit();
}
if (!preg_match('/^\d{13}$/', $basic_cnic)) {
    log_error("Invalid CNIC format: $basic_cnic");
    echo json_encode(['status' => 'error', 'message' => 'Invalid CNIC format.']);
    exit();
}
if (!DateTime::createFromFormat('Y-m-d', $basic_dob)) {
    log_error("Invalid date of birth format: $basic_dob");
    echo json_encode(['status' => 'error', 'message' => 'Invalid date of birth format.']);
    exit();
}

// Handle spouse-related fields
$basic_husband = isset($_POST['basic_husband']) && $_POST['basic_husband'] == 1 ? 1 : 0;
$basic_husbandname = $basic_husband ? (empty($_POST['basic_husbandname']) ? null : trim($_POST['basic_husbandname'])) : null;
$basic_husband_province = $basic_husband ? (empty($_POST['basic_husband_province']) ? null : trim($_POST['basic_husband_province'])) : null;
$basic_husband_district = $basic_husband ? (empty($_POST['basic_husband_district']) ? null : trim($_POST['basic_husband_district'])) : null;

// Validate spouse fields if basic_husband is 1
if ($basic_husband && (empty($basic_husbandname) || empty($basic_husband_province) || empty($basic_husband_district))) {
    log_error("Missing required spouse details.");
    echo json_encode(['status' => 'error', 'message' => 'Please provide all required spouse details.']);
    exit();
}

// Log received values for debugging
error_log("Received Values - basic_husband: $basic_husband, basic_husbandname: $basic_husbandname, basic_husband_province: $basic_husband_province, basic_husband_district: $basic_husband_district");

// Fetch existing data
$existing_data = [
    'per_info' => [],
    'per_info_contact' => [],
    'per_info_spouse' => []
];

// Use prepared statements to fetch data
$stmt = $conn->prepare("SELECT * FROM per_info WHERE said = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $existing_data['per_info'] = $result->fetch_assoc();
}
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM per_info_contact WHERE said = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $existing_data['per_info_contact'] = $result->fetch_assoc();
}
$stmt->close();

$stmt = $conn->prepare("SELECT * FROM per_info_spouse WHERE said = ?");
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $existing_data['per_info_spouse'] = $result->fetch_assoc();
}
$stmt->close();

// Compare submitted data with existing data
$has_changes = false;

if (
    !empty($existing_data['per_info']) &&
    (
        $basic_full_name !== $existing_data['per_info']['basic_full_name'] ||
        $basic_father_name !== $existing_data['per_info']['basic_father_name'] ||
        $basic_gender !== $existing_data['per_info']['basic_gender'] ||
        $basic_dob !== $existing_data['per_info']['basic_dob'] ||
        $basic_domicile !== $existing_data['per_info']['basic_domicile'] ||
        $basic_status !== $existing_data['per_info']['basic_marital_status'] ||
        $disability !== $existing_data['per_info']['disability'] ||
        $basic_cnic !== $existing_data['per_info']['contact_cnic']
    )
) {
    $has_changes = true;
}

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

if (
    !empty($existing_data['per_info_spouse']) &&
    (
        $basic_husband !== ($existing_data['per_info_spouse']['female_applying'] ?? 0) ||
        $basic_husbandname !== ($existing_data['per_info_spouse']['female_husband'] ?? null) ||
        $basic_husband_province !== ($existing_data['per_info_spouse']['female_husband_province'] ?? null) ||
        $basic_husband_district !== ($existing_data['per_info_spouse']['female_husband_district'] ?? null)
    )
) {
    $has_changes = true;
}

if ($basic_husband == 1 && empty($existing_data['per_info_spouse'])) {
    $has_changes = true;
}

if (empty($existing_data['per_info']) || empty($existing_data['per_info_contact'])) {
    $has_changes = true;
}

if (!$has_changes) {
    echo json_encode(['status' => 'success', 'message' => 'No changes detected.']);
    $conn->close();
    exit();
}

// Start transaction
$conn->begin_transaction();

try {
    if (!empty($existing_data['per_info'])) {
        // Update per_info
        $stmt = $conn->prepare("UPDATE per_info SET 
            basic_full_name = ?, basic_father_name = ?, basic_gender = ?, basic_dob = ?, 
            basic_domicile = ?, basic_marital_status = ?, disability = ?, contact_cnic = ?
            WHERE said = ?");
        $stmt->bind_param("sssssssss", 
            $basic_full_name, $basic_father_name, $basic_gender, $basic_dob, 
            $basic_domicile, $basic_status, $disability, $basic_cnic, $userid
        );
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert into per_info
        $stmt = $conn->prepare("INSERT INTO per_info (
            basic_full_name, basic_father_name, basic_gender, basic_dob, 
            basic_domicile, basic_marital_status, disability, contact_cnic, said
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", 
            $basic_full_name, $basic_father_name, $basic_gender, $basic_dob, 
            $basic_domicile, $basic_status, $disability, $basic_cnic, $userid
        );
        $stmt->execute();
        $stmt->close();
    }

    if (!empty($existing_data['per_info_contact'])) {
        // Update per_info_contact
        $stmt = $conn->prepare("UPDATE per_info_contact SET 
            network = ?, contact_phone_no = ?, contact_mobile = ?, contact_email = ?, 
            contact_district = ?, contact_city = ?, contact_religion = ?, 
            contact_postal_address = ?, contact_per_address = ?
            WHERE said = ?");
        $stmt->bind_param("ssssssssss", 
            $network, $basic_phone, $basic_mobile, $basic_email, 
            $basic_district, $basic_city, $basic_religion, 
            $basic_postal, $basic_permanent, $userid
        );
        $stmt->execute();
        $stmt->close();
    } else {
        // Insert into per_info_contact
        $stmt = $conn->prepare("INSERT INTO per_info_contact (
            said, network, contact_phone_no, contact_mobile, contact_email, 
            contact_district, contact_city, contact_religion, 
            contact_postal_address, contact_per_address
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", 
            $userid, $network, $basic_phone, $basic_mobile, $basic_email, 
            $basic_district, $basic_city, $basic_religion, 
            $basic_postal, $basic_permanent
        );
        $stmt->execute();
        $stmt->close();
    }

    if ($basic_husband == 1) {
        if (!empty($existing_data['per_info_spouse'])) {
            // Update per_info_spouse
            $stmt = $conn->prepare("UPDATE per_info_spouse SET 
                female_applying = ?, female_husband = ?, 
                female_husband_province = ?, female_husband_district = ?
                WHERE said = ?");
            $stmt->bind_param("issss", 
                $basic_husband, $basic_husbandname, $basic_husband_province, 
                $basic_husband_district, $userid
            );
            $stmt->execute();
            $stmt->close();
        } else {
            // Insert into per_info_spouse
            $stmt = $conn->prepare("INSERT INTO per_info_spouse (
                said, female_applying, female_husband, female_husband_province, 
                female_husband_district
            ) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sisss", 
                $userid, $basic_husband, $basic_husbandname, 
                $basic_husband_province, $basic_husband_district
            );
            $stmt->execute();
            $stmt->close();
        }
    } else {
        // Delete from per_info_spouse if exists
        $stmt = $conn->prepare("DELETE FROM per_info_spouse WHERE said = ?");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        $stmt->close();
    }

    // Commit transaction
    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => 'Data updated successfully.']);
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    log_error("Database error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating data.']);
}

// Close connection
$conn->close();

// Helper function to log errors securely
function log_error($message) {
    error_log(date('[Y-m-d H:i:s] ') . $message . PHP_EOL, 3, 'errors.log');
}
?>