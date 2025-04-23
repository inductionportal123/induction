<?php
// Include database connection
include('connection/conn.php');

// Check database connection
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNIC Checker</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white p-8 rounded-xl shadow-2xl w-full max-w-lg transition-all transform hover:scale-105 animate-fadeIn">
        
        <!-- Header -->
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">🔍 CNIC Status Checker</h2>

        <?php if (isset($_GET['cnic'])): ?>
            <?php
                $cnic = trim($_GET['cnic']);
                if (!empty($cnic)) {
                    $stmt = $conn->prepare("SELECT details.*, acount_details.name FROM details INNER JOIN acount_details ON acount_details.id = details.d_said WHERE acount_details.cnic = ?");
                    if ($stmt) {
                        $stmt->bind_param("s", $cnic);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();

                            // ✅ Approved & Center Assigned
                            if ($row['d_status'] == "Approved" && $row['d_centerid'] != NULL) {
            ?>
                                <div class="text-center bg-green-100 text-green-700 p-4 rounded-lg shadow-sm">
                                    <p class="text-lg font-medium">✅ Your application is approved.</p>
                                </div>

                                <form action="slipthoughcnic.php" method="post" class="text-center mt-4">
                                    <input type="hidden" name="said" value="<?php echo htmlspecialchars($row['d_said']); ?>">
                                    <input type="hidden" name="postid" value="<?php echo htmlspecialchars($row['d_postid']); ?>">
                                    <input type="hidden" name="rollno" value="<?php echo htmlspecialchars($row['d_rollno']); ?>">
                                    <input type="hidden" name="centerid" value="<?php echo htmlspecialchars($row['d_centerid']); ?>">

                                    <button type="submit" class="mt-4 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-all duration-300 shadow-md">
                                        📄 Download Roll Number Slip
                                    </button>
                                </form>
                                
            <?php
                            }
                            // ❌ Rejected
                            elseif ($row['d_status'] == "Rejected") {
                                echo '<div class="text-center bg-red-100 text-red-700 p-4 rounded-lg shadow-sm">
                                        <p class="text-lg font-medium">❌ Your Application was rejected with following remarks/p>
                                      '.$row['d_feedback'].'
                                      </div>';
                            }
                            // ⏳ Center Not Assigned
                            elseif ($row['d_centerid'] == NULL) {
                                echo '<div class="text-center bg-yellow-100 text-yellow-700 p-4 rounded-lg shadow-sm">
                                        <p class="text-lg font-medium">⚠️ Application not completed/ submitted in due time</p>
                                      </div>';
                            }
                            // 🟡 Pending Approval
                            else {
                                echo '<div class="text-center bg-yellow-100 text-yellow-700 p-4 rounded-lg shadow-sm">
                                        <p class="text-lg font-medium">⚠️ Application not completed/ submitted in due time</p>
                                      </div>';
                            }
                        } else {
                            // 🟥 No Record Found
                            echo '<div class="text-center bg-red-100 text-red-700 p-4 rounded-lg shadow-sm">
                                    <p class="text-lg font-medium">🚫 No records found for the provided CNIC.</p>
                                  </div>';
                            echo '<div class="text-center mt-4">
                                    <a href="index.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-300 shadow-md">🔙 Go Back</a>
                                  </div>';
                        }
                        $stmt->close();
                    }
                } else {
                    echo '<div class="text-center bg-red-100 text-red-700 p-4 rounded-lg shadow-sm">
                            <p class="text-lg font-medium">⚠️ Please enter a valid CNIC!</p>
                          </div>';
                    echo '<div class="text-center mt-4">
                            <a href="index.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-300 shadow-md">🔙 Go Back</a>
                          </div>';
                }
            ?>
        <?php else: ?>
            <div class="text-center bg-blue-100 text-blue-700 p-4 rounded-lg shadow-sm">
                <p class="text-lg font-medium">ℹ️ Please provide a CNIC.</p>
            </div>
            <div class="text-center mt-4">
                <a href="index.php" class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-all duration-300 shadow-md">🔙 Go Back</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>

<?php $conn->close(); ?>
