<?php
include('connection/conn.php');
if (!isset($_SESSION)) {
    session_start();
}

// Session timeout (5 minutes, consistent with queryportal.php)
$timeout = 5 * 60;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}
$_SESSION['last_activity'] = time();

if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    $query = "SELECT per_info.undertaking FROM per_info WHERE per_info.said = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowcount = $result->num_rows;

    if ($rowcount == 1) {
        $rows = $result->fetch_assoc();
        $undertaking = $rows['undertaking'];
    }
    $stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Reset Password</title>
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
        .error-msg { color: #e11d48; font-size: 0.875rem; }
        .succes-msg { color: #059669; font-size: 0.875rem; }
        .process-msg { color: #d97706; font-size: 0.875rem; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased">
    <!-- Header -->
     <?php include 'header.php'; ?>

<?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="p-8 pt-24 w-full max-w-7xl mx-auto md:ml-72">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-key text-teal-600 mr-2"></i> Reset Password
            </h2>

            <!-- Password Reset Form -->
            <div class="card p-6 rounded-lg">
                <form id="passwordset" class="space-y-6 max-w-md mx-auto">
                    <div>
                        <label for="oldpass" class="form-label">Old Password:</label>
                        <input type="password" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="oldpass" id="oldpass" required>
                    </div>
                    <div>
                        <label for="newpass" class="form-label">New Password:</label>
                        <input type="password" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="newpass" id="newpass" required>
                    </div>
                    <div>
                        <label for="confirmpass" class="form-label">Confirm Password:</label>
                        <input type="password" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" name="confirmpass" id="confirmpass" required>
                    </div>
                    <div class="flex items-center justify-between">
                        <button type="button" id="submitsave" class="px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all focus:outline-none">
                            Save & Update <i class="fas fa-save ml-2"></i>
                        </button>
                        <div id="response" class="text-sm"></div>
                    </div>
                </form>
            </div>
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

        // Session Timeout
        let timeout;
        const timeoutPeriod = 5 * 60 * 1000;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(() => window.location.href = "logout.php", timeoutPeriod);
        }
        resetTimer();

        // AJAX Password Reset
        $(document).ready(function() {
            $("#submitsave").click(function() {
                var oldpass = $("#oldpass").val();
                var newpass = $("#newpass").val();
                var confirmpass = $("#confirmpass").val();

                if (oldpass == "" || newpass == "" || confirmpass == "") {
                    $('#response').fadeIn().addClass('error-msg').html("All fields are required.");
                    return false;
                } else if (newpass != confirmpass) {
                    $('#response').fadeIn().addClass('error-msg').html("New Password and Confirm Password do not match.");
                    return false;
                } else {
                    $.ajax({
                        url: "password_reset_processs.php",
                        type: "POST",
                        data: $('#passwordset').serialize(),
                        beforeSend: function() {
                            $('#response').fadeIn().removeClass('error-msg succes-msg').addClass('process-msg').html("Processing...");
                        },
                        success: function(data) {
                            if (data == 1) {
                                $("#passwordset")[0].reset();
                                $('#response').fadeIn().removeClass('process-msg error-msg').addClass('succes-msg').html("Password updated successfully.");
                            } else {
                                $('#response').fadeIn().removeClass('process-msg succes-msg').addClass('error-msg').html(data);
                            }
                        },
                        error: function() {
                            $('#response').fadeIn().removeClass('process-msg succes-msg').addClass('error-msg').html("An error occurred. Please try again.");
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>

<?php
mysqli_close($conn);
} else {
    header("Location: index.php");
}
?>