<?php
include('connection/conn.php');

if (!isset($_SESSION)) { 
    session_start(); 
}

include('timeout.php');

if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    // Initialize variables to avoid undefined variable errors
    $row_name = "";
    $row_dob = "";
    $row_cnic = "";
    $row_gender = "";
    $row_said = "";
    $row_mobile = "";
    $row_email = "";
    $row_postal = "";
    $row_post = "";
    $row_image = "";
    $undertaking = "";
    $profile_picture = "";
    $postss = "";

    // Query updated to join per_info_contact
    $query = "SELECT pi.basic_full_name, pi.contact_cnic, pi.basic_dob, pi.basic_gender, pi.said, 
        pic.contact_mobile, pic.contact_email, pic.contact_postal_address, 
        pa.post_apply, ed.image, pi.undertaking 
        FROM per_info pi
        INNER JOIN emp_document ed ON pi.said = ed.said 
        INNER JOIN post_apply pa ON pi.said = pa.said 
        LEFT JOIN per_info_contact pic ON pi.said = pic.said 
        WHERE pi.said = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $userid);
    mysqli_stmt_execute($stmt);
    $exe = mysqli_stmt_get_result($stmt);
    
    if (!$exe) {
        die("Query failed: " . mysqli_error($conn));
    }

    $rows = mysqli_fetch_array($exe);
    $rowcount = mysqli_num_rows($exe);

    if ($rowcount >= 1) {
        $row_name = $rows['basic_full_name'] ?? '';
        $row_dob = $rows['basic_dob'] ?? '';
        $row_cnic = $rows['contact_cnic'] ?? '';
        $row_gender = $rows['basic_gender'] ?? '';
        $row_said = $rows['said'] ?? '';
        $row_mobile = $rows['contact_mobile'] ?? '';
        $row_email = $rows['contact_email'] ?? '';
        $row_postal = $rows['contact_postal_address'] ?? '';
        $row_post = $rows['post_apply'] ?? '';
        $row_image = $rows['image'] ?? '';
        $undertaking = $rows['undertaking'] ?? '';
        $profile_picture = $rows['image'] ?? '';
    }
    
    if (!empty($row_post)) {
        $querypost = "SELECT `slot` FROM `fee_slot` WHERE `post_id` IN ($row_post)";
        $exepost = mysqli_query($conn, $querypost);
        if ($exepost) {
            $postss = '';
            while ($rowpost = mysqli_fetch_array($exepost)) {
                $postss .= $rowpost['slot'] . ',';
            }
            $postss = substr($postss, 0, -1);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI(C/G) - Recruitment Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .card { transition: all 0.4s ease; background: linear-gradient(135deg, #ffffff, #f9fafb); }
        .card:hover { transform: translateY(-8px); box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15); }
        .status-badge { padding: 4px 12px; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
        .announcement-text { transition: opacity 0.3s ease; }
        .announcement-text.hidden { opacity: 0; }
        .announcement-text:not(.hidden) { opacity: 1; }
        tbody tr:hover { background-color: #fef3f2; }
        .sidebar { transition: transform 0.3s ease-in-out; }
        .sidebar-item:hover { background: rgba(255, 255, 255, 0.1); transform: translateX(5px); }
        .tooltip { visibility: hidden; position: absolute; background: #333; color: white; padding: 5px 10px; border-radius: 4px; font-size: 0.875rem; }
        .sidebar-item:hover .tooltip { visibility: visible; left: 100%; margin-left: 10px; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased">
    <!-- Header -->
    <?php include 'header.php'; ?>
    <?php include 'sidebar.php'; ?>
    <!-- Main Content -->
    <br><br><br><br>
    <main class="p-8 pt-24 w-full max-w-7xl mx-auto md:ml-72">
        <!-- Dashboard Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="card p-6 rounded-xl shadow-lg text-center">
                <i class="fas fa-clipboard-list text-teal-600 text-3xl mb-3"></i>
                <p class="text-gray-800 font-bold"><?php echo $rowcount; ?> Total Applications</p>
            </div>
            <div class="card p-6 rounded-xl shadow-lg text-center">
                <i class="fas fa-hourglass-half text-pink-500 text-3xl mb-3"></i>
                <p class="text-gray-800 font-bold"><?php echo $undertaking ? '1' : '0'; ?> Submitted</p>
            </div>
            <div class="card p-6 rounded-xl shadow-lg text-center">
                <i class="fas fa-check-circle text-teal-600 text-3xl mb-3"></i>
                <p class="text-gray-800 font-bold"><?php echo mysqli_num_rows(mysqli_query($conn, "SELECT * FROM details WHERE d_status='Approved' AND d_said='$userid'")); ?> Approved</p>
            </div>
            <div class="card p-6 rounded-xl shadow-lg text-center">
                <i class="fas fa-id-card text-teal-700 text-3xl mb-3"></i>
                <p class="text-gray-800 font-bold">Call Letters</p>
            </div>
        </div>

        <!-- Announcements -->
        <div class="bg-gradient-to-r from-teal-100 to-pink-100 text-teal-800 p-6 mb-8 rounded-xl flex justify-between items-center shadow-md" id="announcement-section">
            <div class="flex items-center w-full">
                <button onclick="prevAnnouncement()" class="text-teal-700 hover:text-amber-400 mr-4 text-lg"><i class="fas fa-chevron-left"></i></button>
                <div class="flex-1">
                    <h3 class="font-bold text-lg text-teal-900">Announcements</h3>
                    <div id="announcement-content">
                        <?php
                        $anc = "SELECT * FROM message WHERE status ='Active'";
                        $exeanc = mysqli_query($conn, $anc);
                        $ancrows = mysqli_num_rows($exeanc);
                        if ($ancrows > 0) {
                            $index = 0;
                            while ($ancdata = mysqli_fetch_array($exeanc)) {
                                echo "<p class='text-base announcement-text " . ($index > 0 ? 'hidden' : '') . "' data-index='$index'>" . htmlspecialchars($ancdata['message']) . "</p>";
                                $index++;
                            }
                        }
                        ?>
                    </div>
                </div>
                <button onclick="nextAnnouncement()" class="text-teal-700 hover:text-amber-400 ml-4 text-lg"><i class="fas fa-chevron-right"></i></button>
                <span id="announcement-counter" class="text-sm bg-teal-200 text-teal-800 px-3 py-1 rounded-full ml-4 font-semibold shadow-sm">1/<?php echo $ancrows; ?></span>
            </div>
        </div>
        
        <!-- Job Applications -->
        <div class="bg-white p-8 rounded-xl shadow-lg mb-8">
            <h3 class="text-xl font-bold text-gray-800 mb-6">My Job Applications</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-teal-100 text-teal-800">
                            <th class="p-4 font-semibold">Roll No</th>
                            <th class="p-4 font-semibold">Job Title</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if there are records in post_apply for the user
                        $postid = "SELECT post_apply FROM `post_apply` WHERE said = ?";
                        $stmt = mysqli_prepare($conn, $postid);
                        mysqli_stmt_bind_param($stmt, "s", $userid);
                        mysqli_stmt_execute($stmt);
                        $postexe = mysqli_stmt_get_result($stmt);
                        
                        if (mysqli_num_rows($postexe) > 0) {
                            $postdata = mysqli_fetch_array($postexe);
                            $postapplied = $postdata['post_apply'];
                            $value = explode(",", $postapplied);

                            foreach ($value as $appliedpost) {
                                // Check the details table for this post
                                $rollslip = "SELECT * FROM `details` JOIN posts ON posts.pid = details.d_postid WHERE d_postid=? AND d_said=?";
                                $stmt = mysqli_prepare($conn, $rollslip);
                                mysqli_stmt_bind_param($stmt, "ss", $appliedpost, $userid);
                                mysqli_stmt_execute($stmt);
                                $exerollslip = mysqli_stmt_get_result($stmt);
                                $details_count = mysqli_num_rows($exerollslip);

                                while ($exedataroll = mysqli_fetch_array($exerollslip)) {
                                    // Determine the status
                                    $status = "";
                                    $status_class = "";
                                    $reason = "";

                                    // Check if post_apply and details are filled
                                    if ($details_count > 0) {
                                        if ($undertaking != 1) {
                                            $status = "In Process"; 
                                            $status_class = "bg-blue-200 text-blue-800";
                                        } else {
                                            if (isset($exedataroll['d_status'])) {
                                                if ($exedataroll['revert'] == '1' && $exedataroll['d_status'] == "Reverted") {
                                                    $status = "Reverted";
                                                    $status_class = "bg-yellow-200 text-yellow-800";
                                                    $reason = $exedataroll['d_feedback'] ?? "";
                                                } elseif ($exedataroll['d_status'] == "Pending") {
                                                    $status = "Submitted (Under Review)";
                                                    $status_class = "bg-green-200 text-green-800";
                                                } elseif ($exedataroll['d_status'] == "Approved") {
                                                    $status = "Approved";
                                                    $status_class = "bg-teal-200 text-teal-800";
                                                } elseif ($exedataroll['d_status'] == "Rejected") {
                                                    $status = "Rejected";
                                                    $status_class = "bg-pink-200 text-pink-800";
                                                    $reason = $exedataroll['d_feedback'] ?? "";
                                                } else {
                                                    $status = "Submitted";
                                                    $status_class = "bg-green-200 text-green-800";
                                                }
                                            } else {
                                                $status = "Submitted";
                                                $status_class = "bg-green-200 text-green-800";
                                            }
                                        }
                                    } else {
                                        $status = "In Process";
                                        $status_class = "bg-blue-200 text-blue-800";
                                    }

                                    // Determine if roll number should be shown
                                    $roll_number = !empty($exedataroll['d_centerid']) ? htmlspecialchars($exedataroll['d_rollno'] ?? 'N/A') : 'N/A';

                                    ?>
                                    <tr class="border-t border-stone-200">
                                        <td class="p-4 text-gray-700"><?php echo $roll_number; ?></td>
                                        <td class="p-4 text-gray-700"><?php echo htmlspecialchars($exedataroll['name'] ?? 'N/A'); ?></td>
                                        <td class="p-4">
                                            <span class="status-badge <?php echo $status_class; ?>">
                                                <?php echo htmlspecialchars($status); ?>
                                            </span>
                                            <?php if (!empty($reason)) echo "<p class='text-sm text-gray-600 mt-2'>Reason: " . htmlspecialchars($reason) . "</p>"; ?>
                                        </td>
                                        <td class="p-4 flex space-x-2">
                                            <?php if (!empty($exedataroll['d_centerid'])) { ?>
                                                <form action="rollslip.php" method="post" class="inline">
                                                    <input type="hidden" name="postid" value="<?php echo htmlspecialchars($exedataroll['d_postid']); ?>">
                                                    <input type="hidden" name="rollno" value="<?php echo htmlspecialchars($exedataroll['d_rollno']); ?>">
                                                    <input type="hidden" name="centerid" value="<?php echo htmlspecialchars($exedataroll['d_centerid']); ?>">
                                                    <button type="submit" class="text-teal-700 hover:text-amber-400 bg-teal-100 px-2 py-1 rounded" title="Download Roll Slip">
                                                        Download Slip <i class="fas fa-download ml-1"></i>
                                                    </button>
                                                </form>
                                            <?php } elseif ($status == "Reverted") { ?>
                                                <form action="resubmit.php" method="post" class="inline" id="resubmitForm">
    <input type="hidden" name="userid" value="<?php echo htmlspecialchars($userid); ?>">
    <input type="hidden" name="appliedpost" value="<?php echo htmlspecialchars($appliedpost); ?>">
    <button type="button" class="text-teal-700 hover:text-amber-400 bg-teal-100 px-2 py-1 rounded" 
            title="Edit Application" onclick="confirmResubmit()">
        Edit <i class="fas fa-edit ml-1"></i>
    </button>
</form>

<script>
function confirmResubmit() {
    if (confirm("Are you sure you want to resubmit your application? If you proceed, you will need to start the application from the beginning and complete all steps again until the end.")) {
        document.getElementById('resubmitForm').submit();
    }
}
</script>
                                            <?php } else { ?>
                                                <span class="text-gray-500">N/A</span>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="4" class="p-4 text-center text-gray-600">No applications found.</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="flex justify-between items-center mt-6 text-sm text-gray-600">
                <span>Items per page <select class="border border-stone-300 rounded-md p-2 bg-white shadow-sm">
                    <option>5</option>
                    <option>10</option>
                    <option>20</option>
                </select></span>
                <div class="flex space-x-1">
                    <button class="px-3 py-1 border border-stone-300 rounded-l-md bg-white hover:bg-teal-50"><i class="fas fa-angle-double-left"></i></button>
                    <button class="px-3 py-1 border border-stone-300 bg-white hover:bg-teal-50"><i class="fas fa-angle-left"></i></button>
                    <button class="px-3 py-1 border border-stone-300 bg-white hover:bg-teal-50"><i class="fas fa-angle-right"></i></button>
                    <button class="px-3 py-1 border border-stone-300 rounded-r-md bg-white hover:bg-teal-50"><i class="fas fa-angle-double-right"></i></button>
                </div>
            </div>
        </div>

        <!-- Profile and Additional Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <?php if ($undertaking == 1) { ?>
                <!-- Profile Card -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Profile Overview</h3>
                    <div class="flex flex-col md:flex-row gap-6">
                        <img src="<?php echo htmlspecialchars($row_image ?? 'images/default.png'); ?>" alt="Profile" 
                             class="w-32 h-32 rounded-full object-cover mx-auto md:mx-0 border-2 border-teal-300">
                        <div class="space-y-2">
                            <p><strong>Name:</strong> <?php echo htmlspecialchars($row_name ?? 'Nill'); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($row_email ?? 'Nill'); ?></p>
                            <p><strong>Mobile:</strong> <?php echo htmlspecialchars($row_mobile ?? 'Nill'); ?></p>
                            <p><strong>Applied Posts:</strong> <?php echo strtoupper(htmlspecialchars($postss ?? 'Nill')); ?></p>
                            <a href="per_info.php" class="text-teal-700 hover:text-amber-400 mt-2 inline-block">Edit Profile</a>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Quick Stats</h3>
                    <div class="space-y-4">
                        <p><i class="fas fa-calendar-alt text-teal-600 mr-2"></i><strong>DOB:</strong> <?php echo htmlspecialchars($row_dob ?? 'Nill'); ?></p>
                        <p><i class="fas fa-id-card text-teal-600 mr-2"></i><strong>CNIC:</strong> <?php echo htmlspecialchars($row_cnic ?? 'Nill'); ?></p>
                        <p><i class="fas fa-venus-mars text-teal-600 mr-2"></i><strong>Gender:</strong> <?php echo ucfirst(htmlspecialchars($row_gender ?? 'Nill')); ?></p>
                        <p><i class="fas fa-map-marker-alt text-teal-600 mr-2"></i><strong>Address:</strong> <?php echo ucfirst(htmlspecialchars($row_postal ?? 'Nill')); ?></p>
                    </div>
                </div>
            <?php } else { ?>
                <!-- Placeholder for Incomplete Application -->
                <div class="bg-white p-8 rounded-xl shadow-lg col-span-2">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Profile Information</h3>
                    <p class="text-gray-600 mb-4">Please complete and submit your application to view your profile details.</p>
                    <a href="per_info.php" class="text-teal-700 hover:text-amber-400 inline-block">Complete Application <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
            <?php } ?>
        </div>
    </main>

    <script>
        // Sidebar toggle
        const sidebar = document.getElementById('sidebar');
        const toggle = document.getElementById('sidebar-toggle');
        const close = document.getElementById('sidebar-close');
        toggle.addEventListener('click', () => sidebar.classList.toggle('-translate-x-full'));
        close.addEventListener('click', () => sidebar.classList.add('-translate-x-full'));

        // Announcement navigation
        let currentAnnouncement = 0;
        const totalAnnouncements = <?php echo $ancrows; ?>;
        function updateAnnouncement() {
            document.querySelectorAll('.announcement-text').forEach(text => text.classList.add('hidden'));
            const currentText = document.querySelector(`.announcement-text[data-index="${currentAnnouncement}"]`);
            if (currentText) currentText.classList.remove('hidden');
            document.getElementById('announcement-counter').textContent = `${currentAnnouncement + 1}/${totalAnnouncements}`;
        }
        function prevAnnouncement() {
            currentAnnouncement = (currentAnnouncement - 1 + totalAnnouncements) % totalAnnouncements;
            updateAnnouncement();
        }
        function nextAnnouncement() {
            currentAnnouncement = (currentAnnouncement + 1) % totalAnnouncements;
            updateAnnouncement();
        }
        if (totalAnnouncements > 0) updateAnnouncement();
    </script>
</body>
</html>

<?php
} else {
    header("Location: index.php");
    exit();
}
mysqli_close($conn);
?>