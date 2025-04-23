<?php
session_start();
header('Content-Type: application/json');
include('../connection/conn.php'); // Adjust path if needed

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['cnic']) || !isset($data['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'CNIC and password required']);
    exit;
}

$cnic = mysqli_real_escape_string($conn, $data['cnic']);
$password = mysqli_real_escape_string($conn, $data['password']);
echo 
$query = "SELECT * FROM acount_details WHERE cnic = '$cnic' AND password = '$password' AND status = 1";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user) {
    $_SESSION['u_name'] = $user['name'];
    $_SESSION['u_id'] = $user['id'];

    echo json_encode([
        'status' => 'success',
        'message' => 'Login successful'
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid CNIC or password']);
}
?>
