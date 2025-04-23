<?php
include('../connection/conn.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    $user = $_SESSION['user_name'];
    $userid = $_SESSION['user_access'];

    $arr = explode(' ', trim($user));
    $newuser = ucfirst("$arr[0]");

    // Handle Search and Toggle Status
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Search by CNIC
        if (isset($_POST['cnic'])) {
            $cnic = $_POST['cnic'];
            $cnic = $conn->real_escape_string($cnic); // Prevent SQL Injection
            $query = "SELECT * FROM acount_details WHERE cnic = '$cnic'";
            $result = $conn->query($query);

            if ($result) {
                $user = $result->fetch_assoc();
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }

        // Toggle status
        if (isset($_POST['toggle_status'])) {
            $id = $_POST['user_id'];
            $current_status = $_POST['current_status'];
            $new_status = ($current_status == 1) ? 0 : 1;
            $id = (int)$id; // Ensure ID is treated as an integer
            $update_query = "UPDATE acount_details SET status = $new_status WHERE id = $id";

            // Perform the update query
            if ($conn->query($update_query)) {
                // Redirect to the same page after updating the status
                header("Location: ".$_SERVER['PHP_SELF']);
                exit;
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Toggle Status</title>
    <!-- Add Tailwind CSS link -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<div class="container mx-auto p-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">Admin Panel</h1>

        <!-- CNIC Search Form -->
        <form method="POST" class="mb-6">
            <label for="cnic" class="block text-gray-700 font-medium mb-2">Enter CNIC</label>
            <input type="text" name="cnic" id="cnic" required class="w-full p-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4">
            <button type="submit" class="w-full p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Search</button>
        </form>

        <!-- Error Message -->
        <?php if (isset($error_message)): ?>
            <div class="bg-red-100 text-red-700 p-4 rounded-md mb-6">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- User Data and Status Toggle -->
        <?php if (isset($user)): ?>
            <div class="bg-gray-50 p-6 rounded-md border border-gray-300">
                <p><strong class="font-semibold">Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                <p><strong class="font-semibold">CNIC:</strong> <?php echo htmlspecialchars($user['cnic']); ?></p>
                <p class="mt-4">
                    <strong class="font-semibold">Status:</strong> 
                    <span class="text-sm <?php echo ($user['status'] == 1) ? 'text-green-600' : 'text-red-600'; ?>">
                        <?php echo ($user['status'] == 1) ? 'Active' : 'Inactive'; ?>
                    </span>
                    <form method="POST" class="mt-4">
                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                        <input type="hidden" name="current_status" value="<?php echo $user['status']; ?>">
                        <button type="submit" name="toggle_status" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <?php echo ($user['status'] == 1) ? 'Deactivate' : 'Activate'; ?>
                        </button>
                    </form>
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>

<?php
} else {
    echo "<div class='bg-red-100 text-red-700 p-6 rounded-md mx-auto my-4'>Please log in to access this page.</div>";
}

// Close database connection
$conn->close();
?>
