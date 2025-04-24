<?php
include('connection/conn.php');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Session timeout (5 minutes)
$timeout = 5 * 60;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

$_SESSION['last_activity'] = time();

// Check if user is logged in
if (!isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    header("Location: index.php");
    exit();
}

$user = $_SESSION['u_name'];
$userid = (int)$_SESSION['u_id'];

// Fetch user profile data
$query = "SELECT pi.undertaking, pi.basic_full_name, pi.contact_cnic, 
                 pi.basic_dob, pi.basic_gender, pi.said, pic.contact_mobile, 
                 pic.contact_email, pic.contact_postal_address, pa.post_apply, 
                 ed.image 
          FROM per_info pi
          INNER JOIN emp_document ed ON pi.said = ed.said 
          INNER JOIN per_info_contact pic ON pi.said = pic.said
          INNER JOIN post_apply pa ON pi.said = pa.said 
          WHERE pi.said = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $rows = $result->fetch_assoc();
    $row_name = $rows['basic_full_name'];
    $row_dob = $rows['basic_dob'];
    $row_cnic = $rows['contact_cnic'];
    $row_gender = $rows['basic_gender'];
    $row_said = $rows['said'];
    $row_mobile = $rows['contact_mobile'];
    $row_email = $rows['contact_email'];
    $row_postal = $rows['contact_postal_address'];
    $row_post = $rows['post_apply'];
    $row_image = $rows['image'];
    $undertaking = $rows['undertaking'];
    $profile_picture = $rows['image'];
} else {
    echo "<div class='mt-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center'>
            <i class='fas fa-exclamation-circle mr-2'></i> Error: User profile not found.</div>";
    exit();
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Query Portal</title>
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
        .table-container { max-height: 400px; overflow-y: auto; }
        .image-preview { max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb; }
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
                <i class="fas fa-comment text-teal-600 mr-2"></i> Query Portal
            </h2>

            <!-- Query Submission Form -->
            <div class="card p-6 rounded-lg mb-6">
                <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                    <i class="fas fa-pen mr-2"></i> Submit a Query
                </h3>
                <form method="post" action="" enctype="multipart/form-data" class="space-y-4">
                    <div>
                        <label class="form-label">Write Your Query:</label>
                        <textarea name="query" rows="5" required class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500 resize-none" placeholder="Enter your query here..."></textarea>
                    </div>
                    <div>
                        <label class="form-label">Attach a File (Optional, JPG/JPEG, < 500KB):</label>
                        <input type="file" name="queryPicture" accept="image/jpeg,image/jpg" class="w-full p-2 border rounded-md">
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" name="submit" class="px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all">
                            Send <i class="fas fa-paper-plane ml-2"></i>
                        </button>
                    </div>
                </form>

                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
                    $query1 = $conn->real_escape_string(trim($_POST['query']));
                    $picture_path = null;
                    $upload_success = true;

                    if (isset($_FILES['queryPicture']) && $_FILES['queryPicture']['error'] !== UPLOAD_ERR_NO_FILE) {
                        $picture = $_FILES['queryPicture']['name'];
                        $temp_file = $_FILES['queryPicture']['tmp_name'];
                        $file_size = $_FILES['queryPicture']['size'];
                        $uploads_directory = "Uploads/";

                        // Create uploads directory if it doesn't exist
                        if (!is_dir($uploads_directory)) {
                            mkdir($uploads_directory, 0755, true);
                        }

                        $file_extension = strtolower(pathinfo($picture, PATHINFO_EXTENSION));
                        $picture = uniqid('query_') . '.' . $file_extension;
                        $upload_path = $uploads_directory . $picture;

                        $allowed_types = ['jpg', 'jpeg'];
                        $max_size = 500 * 1024; // 500KB

                        if (!in_array($file_extension, $allowed_types)) {
                            echo "<div class='mt-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center'>
                                    <i class='fas fa-exclamation-circle mr-2'></i> Error: Only JPG/JPEG files are allowed.</div>";
                            $upload_success = false;
                        } elseif ($file_size > $max_size) {
                            echo "<div class='mt-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center'>
                                    <i class='fas fa-exclamation-circle mr-2'></i> Error: File size must be less than 500KB.</div>";
                            $upload_success = false;
                        } elseif ($file_size === 0) {
                            echo "<div class='mt-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center'>
                                    <i class='fas fa-exclamation-circle mr-2'></i> Error: File is empty.</div>";
                            $upload_success = false;
                        } else {
                            $picture = preg_replace('/[^A-Za-z0-9\._-]/', '', $picture);
                            if (move_uploaded_file($temp_file, $upload_path)) {
                                if (!getimagesize($upload_path)) {
                                    unlink($upload_path);
                                    echo "<div class='mt-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center'>
                                            <i class='fas fa-exclamation-circle mr-2'></i> Error: Uploaded file is not a valid image.</div>";
                                    $upload_success = false;
                                } else {
                                    $picture_path = $upload_path;
                                }
                            } else {
                                echo "<div class='mt-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center'>
                                        <i class='fas fa-exclamation-circle mr-2'></i> Error uploading file.</div>";
                                $upload_success = false;
                            }
                        }
                    }

                    if ($upload_success) {
                        date_default_timezone_set("Asia/Karachi");
                        $time = date("Y-m-d H:i:s");

                        $sql12 = "INSERT INTO query (said, query, picture, q_time) VALUES (?, ?, ?, ?)";
                        $stmt = $conn->prepare($sql12);
                        $stmt->bind_param("isss", $userid, $query1, $picture_path, $time);

                        if ($stmt->execute()) {
                            echo "<div class='mt-4 p-4 bg-green-100 text-green-700 rounded-lg flex items-center'>
                                    <i class='fas fa-check-circle mr-2'></i> Query submitted successfully!</div>";
                        } else {
                            echo "<div class='mt-4 p-4 bg-red-100 text-red-700 rounded-lg flex items-center'>
                                    <i class='fas fa-exclamation-circle mr-2'></i> Error: " . htmlspecialchars($conn->error) . "</div>";
                        }
                        $stmt->close();
                    }
                }
                ?>
            </div>

            <!-- Existing Queries -->
            <?php
            $query2 = "SELECT q.*, pi.basic_full_name 
                      FROM query q
                      INNER JOIN per_info pi ON q.said = pi.said 
                      WHERE q.said = ? 
                      ORDER BY q.q_time DESC";
            $stmt = $conn->prepare($query2);
            $stmt->bind_param("i", $userid);
            $stmt->execute();
            $result2 = $stmt->get_result();

            if ($result2->num_rows > 0) {
            ?>
                <div class="card p-6 rounded-lg">
                    <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                        <i class="fas fa-history mr-2"></i> Already Asked Queries
                    </h3>
                    <div class="table-container">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-teal-50 sticky top-0">
                                <tr>
                                    <th class="p-3 border-b font-semibold text-teal-700">Query</th>
                                    <th class="p-3 border-b font-semibold text-teal-700">File</th>
                                    <th class="p-3 border-b font-semibold text-teal-700">Feedback</th>
                                    <th class="p-3 border-b font-semibold text-teal-700">File Attach</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($rows = $result2->fetch_assoc()) { ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-3 border-b"><?php echo htmlspecialchars(strtoupper($rows['query'] . '<br>' . $rows['q_time'])); ?></td>
                                        <td class="p-3 border-b">
                                            <?php if (!empty($rows['picture']) && $rows['picture'] !== 'NULL') { ?>
                                                <a href="<?php echo htmlspecialchars($rows['picture']); ?>" target="_blank">
                                                    <img src="<?php echo htmlspecialchars($rows['picture']); ?>" alt="Query File" class="image-preview">
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td class="p-3 border-b">
                                            <?php echo ($rows['ans'] === null) ? 'Yet not answered' : htmlspecialchars(strtoupper($rows['ans'] . '<br>(' . $rows['f_time'] . ')')); ?>
                                        </td>
                                        <td class="p-3 border-b">
                                            <?php if (!empty($rows['ansPicture']) && $rows['ansPicture'] !== 'NULL') { ?>
                                                <a href="<?php echo htmlspecialchars($rows['ansPicture']); ?>" target="_blank">
                                                    <img src="<?php echo htmlspecialchars($rows['ansPicture']); ?>" alt="Feedback File" class="image-preview">
                                                </a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php
            }
            $stmt->close();
            ?>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebar-toggle');
        const close = document.getElementById('sidebar-close');
        if (toggle && sidebar) {
            toggle.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
        }
        if (close && sidebar) {
            close.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));
        }

        // Session Timeout
        let timeout;
        const timeoutPeriod = 5 * 60 * 1000;
        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(() => window.location.href = "logout.php", timeoutPeriod);
        }
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        resetTimer();
    </script>
</body>
</html>

<?php
$conn->close();
?>