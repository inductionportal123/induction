<?php
include('connection/conn.php');

// Initialize variables
$error = '';
$success = '';
$cnic = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle CNIC and email verification
    if (isset($_POST['action']) && $_POST['action'] === 'verify_cnic_email' && isset($_POST['cnic']) && isset($_POST['email'])) {
        $cnic = $_POST['cnic'];
        $email = $_POST['email'];

        // Validate CNIC format (XXXXX-XXXXXXX-X)
        if (!preg_match('/^\d{5}-\d{7}-\d{1}$/', $cnic)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid CNIC format. Please use the format: 12345-6789012-3']);
            exit;
        }

        // Basic email format validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
            exit;
        }

        // Check if CNIC and email exist in database
        $query = "SELECT * FROM acount_details WHERE cnic = ? AND email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ss', $cnic, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            echo json_encode(['status' => 'success', 'message' => 'CNIC and email verified. Please enter your new password.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'The provided CNIC or email does not match our records.']);
        }
        mysqli_stmt_close($stmt);
        exit;
    }

    // Handle password update
    if (isset($_POST['submit_password']) && isset($_POST['cnic']) && isset($_POST['email'])) {
        // Debug: Log POST data (uncomment to use)
        // file_put_contents('debug.log', print_r($_POST, true), FILE_APPEND);

        $cnic = $_POST['cnic'];
        $email = $_POST['email'];
        $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';
        $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

        // Validate passwords
        if (empty($new_password) || empty($confirm_password)) {
            $error = "Both password fields are required.";
        } elseif ($new_password !== $confirm_password) {
            $error = "Passwords do not match. Please try again.";
        } else {
            // Optional: Hash the password (uncomment to use)
            // $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            // $query = "UPDATE acount_details SET password = ? WHERE cnic = ? AND email = ?";
            // $stmt = mysqli_prepare($conn, $query);
            // mysqli_stmt_bind_param($stmt, 'sss', $hashed_password, $cnic, $email);

            // Current: Plaintext password (matching original code)
            $query = "UPDATE acount_details SET password = ? WHERE cnic = ? AND email = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'sss', $new_password, $cnic, $email);

            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $success = "Password changed successfully!";
            } else {
                $error = "Failed to change password. Please try again.";
            }
            mysqli_stmt_close($stmt);
        }
    } else {
        // If submit_password is set but cnic/email are missing, show error
        if (isset($_POST['submit_password'])) {
            $error = "CNIC or email missing. Please verify again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- jQuery CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- jQuery Inputmask CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f7fb;
        }
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        .success-message {
            color: #15803d;
            font-size: 1rem;
            margin-top: 0.5rem;
        }
        .readonly-input {
            background-color: #e5e7eb;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Reset Password</h2>

        <?php if (!empty($error)) { ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php } ?>
        <?php if (!empty($success)) { ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-4 text-center">
                <p class="text-lg font-semibold"><?php echo htmlspecialchars($success); ?></p>
                <p class="text-sm mt-2">You will be redirected to the login page in <span id="countdown">5</span> seconds.</p>
                <a href="index.php" class="inline-block bg-blue-600 text-white py-2 px-4 rounded-lg mt-4 hover:bg-blue-700 transition duration-200">Go to Login Now</a>
            </div>
        <?php } else { ?>
            <form method="POST" id="resetPasswordForm">
                <div class="mb-4">
                    <label for="cnic" class="block text-sm font-medium text-gray-700 mb-2">Enter your CNIC:</label>
                    <input
                        type="text"
                        id="cnic"
                        name="cnic"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="12345-6789012-3"
                        data-inputmask="'mask': '99999-9999999-9'"
                        required
                    >
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Enter your Email:</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="example@domain.com"
                        required
                    >
                </div>

                <div id="passwordFields" class="hidden">
                    <!-- Hidden inputs to ensure cnic and email are sent -->
                    <input type="hidden" id="hidden_cnic" name="cnic">
                    <input type="hidden" id="hidden_email" name="email">
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">New Password:</label>
                        <input
                            type="password"
                            id="new_password"
                            name="new_password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password:</label>
                        <input
                            type="password"
                            id="confirm_password"
                            name="confirm_password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required
                        >
                    </div>
                </div>

                <div id="response" class="text-center mb-4"></div>

                <button
                    type="button"
                    id="verifyCnicEmail"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200"
                >
                    Verify CNIC & Email
                </button>
                <button
                    type="submit"
                    id="submitPassword"
                    name="submit_password"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200 hidden"
                >
                    Change Password
                </button>
            </form>
        <?php } ?>

        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                Don't have an account? <a href="signup.php" class="text-blue-600 hover:underline">Register here</a>.
            </p>
        </div>
        <div class="text-center mt-2">
            <p class="text-sm text-gray-600">
                Remembered your password? <a href="index.php" class="text-blue-600 hover:underline">Log in</a>.
            </p>
        </div>
        <div class="text-center mt-4">
            <p class="text-sm text-gray-600">
                <b>In case of any query, please contact: 051-4252080</b>
            </p>
            <p class="text-sm text-gray-600">© 2024 FGEI (C/G). All rights reserved.</p>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Apply input mask to CNIC field
            $("#cnic").inputmask();

            // Verify CNIC and Email via AJAX
            $("#verifyCnicEmail").click(function () {
                var cnic = $("#cnic").val();
                var email = $("#email").val();

                if (cnic === "" || !cnic.match(/^\d{5}-\d{7}-\d{1}$/)) {
                    $("#response").addClass("error-message").html("Please enter a valid CNIC in the format 12345-6789012-3.");
                    return;
                }
                if (email === "" || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    $("#response").addClass("error-message").html("Please enter a valid email address.");
                    return;
                }

                $.ajax({
                    url: window.location.href,
                    type: "POST",
                    data: { action: "verify_cnic_email", cnic: cnic, email: email },
                    dataType: "json",
                    beforeSend: function () {
                        $("#response").removeClass("error-message success-message").html("Verifying...");
                    },
                    success: function (data) {
                        if (data.status === "success") {
                            $("#response").removeClass("error-message").addClass("success-message").html(data.message);
                            $("#passwordFields").removeClass("hidden");
                            $("#verifyCnicEmail").addClass("hidden");
                            $("#submitPassword").removeClass("hidden");
                            // Set hidden inputs for form submission
                            $("#hidden_cnic").val(cnic);
                            $("#hidden_email").val(email);
                            // Make inputs readonly instead of disabled
                            $("#cnic").addClass("readonly-input").prop("readonly", true);
                            $("#email").addClass("readonly-input").prop("readonly", true);
                        } else {
                            $("#response").removeClass("success-message").addClass("error-message").html(data.message);
                        }
                    },
                    error: function () {
                        $("#response").removeClass("success-message").addClass("error-message").html("An error occurred. Please try again.");
                    }
                });
            });

            // Auto-redirect countdown for success message
            if ($(".bg-green-100").length) {
                let countdown = 5;
                const countdownElement = $("#countdown");
                const interval = setInterval(function () {
                    countdown--;
                    countdownElement.text(countdown);
                    if (countdown <= 0) {
                        clearInterval(interval);
                        window.location.href = "index.php";
                    }
                }, 1000);
            }
        });
    </script>
</body>
</html>