<?php
// Database connection assumed to be set up in 'connection/conn.php'
if (!isset($conn)) {
    include 'connection/conn.php';
}

// Ensure $userid is set and sanitized
$userid = isset($userid) ? mysqli_real_escape_string($conn, $userid) : '';

$que = "SELECT image 
        FROM emp_document 
        WHERE said = ? 
        LIMIT 1";
$stmt = mysqli_prepare($conn, $que);
mysqli_stmt_bind_param($stmt, "s", $userid);
mysqli_stmt_execute($stmt);
$ex1 = mysqli_stmt_get_result($stmt);

if (!$ex1) {
    die("Query failed: " . mysqli_error($conn));
}

$rowcount = mysqli_num_rows($ex1);
if ($rowcount > 0) {
    $ro = mysqli_fetch_array($ex1);
    $profile_picture = $ro['image'];
} else {
    $profile_picture = null;
}
?>

<header class="bg-teal-800 text-white py-6 px-8 flex flex-col md:flex-row justify-between items-center w-full shadow-lg fixed top-0 left-0 z-30">
    <div class="flex items-center mb-4 md:mb-0 ml-4 md:ml-[calc(280px+1rem)]">
        <img src="images/logo.png" alt="FGEI Logo" class="w-12 h-12 rounded-full border-2 border-teal-300 mr-4">
        <div>
            <h1 class="text-2xl font-extrabold tracking-tight">Federal Government Educational Institutions</h1>
            <p class="text-sm text-teal-200 mt-1">
                Recruitment Portal | <span id="current-time"><?php echo date('d F, Y h:i A'); ?></span>
            </p>
        </div>
    </div>
    <div class="flex items-center space-x-6">
        <button id="sidebar-toggle" class="md:hidden text-white text-2xl"><i class="fas fa-bars"></i></button>
        <a href="profile.php" class="text-teal-100 hover:text-amber-400 transition-colors hidden md:block"><i class="fas fa-user mr-2"></i>Profile</a>
        <a href="logout.php" class="text-teal-100 hover:text-amber-400 transition-colors hidden md:block"><i class="fas fa-sign-out-alt mr-2"></i>Logout</a>
        <div class="flex items-center bg-teal-700 px-4 py-2 rounded-full">
            <span class="text-sm text-teal-100"><?php echo isset($user) ? htmlspecialchars($user) : 'Guest'; ?></span>
            <img 
                src="<?php echo isset($profile_picture) && !empty($profile_picture) ? htmlspecialchars($profile_picture) : 'default-avatar.png'; ?>" 
                alt="User Avatar" 
                class="w-10 h-10 rounded-full ml-3 border-2 border-teal-300"
                onerror="this.src='default-avatar.jpg'"
            >
        </div>
    </div>
</header>

<script>
// Function to update the time every second
function updateTime() {
    const timeElement = document.getElementById('current-time');
    const now = new Date();
    const options = { 
        day: '2-digit', 
        month: 'long', 
        year: 'numeric', 
        hour: '2-digit', 
        minute: '2-digit', 
        hour12: true 
    };
    // Format the date and time to match PHP's 'd F, Y h:i A'
    const formattedTime = now.toLocaleString('en-US', options)
        .replace(/,/, '') // Remove comma after year
        .replace(/(\d+:\d+) (AM|PM)/, '$1 $2'); // Ensure AM/PM format
    timeElement.textContent = formattedTime;
}

// Update time immediately on load
updateTime();
// Update time every second (1000ms)
setInterval(updateTime, 1000);
</script>