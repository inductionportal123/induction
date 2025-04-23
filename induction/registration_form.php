<?php
// Get the current page filename
$current_page = basename($_SERVER['PHP_SELF']);

// Define the page sequence and calculate progress
$pages = ['per_info.php', 'qualification.php', 'post_apply.php', 'challan.php', 'documents.php', 'undertaking.php'];
$total_pages = count($pages);
$current_step = array_search($current_page, $pages) + 1; // Add 1 since array is 0-based
$progress_width = ($current_step / $total_pages) * 100; // Percentage width
?>


<br><br><br><br><br>

<h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-clipboard-list text-teal-600 mr-2"></i> Registration Form
            </h2>
<!-- Advanced Navigation Tabs -->
<div class="relative mb-8">
    <div class="flex flex-wrap gap-4 bg-teal-50 p-4 rounded-lg shadow-inner">
        <a href="per_info.php" class="nav-tab flex-1 text-center px-4 py-3 rounded-md font-semibold <?php echo $current_page === 'per_info.php' ? 'text-teal-700 active' : 'text-gray-700'; ?>">
            <i class="fas fa-user mr-2"></i>Personal Info<br><span class="text-sm <?php echo $current_page === 'per_info.php' ? 'text-teal-600' : 'text-gray-600'; ?>">ذاتی معلومات</span>
        </a>
        <a href="qualification.php" class="nav-tab flex-1 text-center px-4 py-3 rounded-md font-semibold <?php echo $current_page === 'qualification.php' ? 'text-teal-700 active' : 'text-gray-700'; ?>">
            <i class="fas fa-graduation-cap mr-2"></i>Qualification<br><span class="text-sm <?php echo $current_page === 'qualification.php' ? 'text-teal-600' : 'text-gray-600'; ?>">قابلیت</span>
        </a>
        <a href="post_apply.php" class="nav-tab flex-1 text-center px-4 py-3 rounded-md font-semibold <?php echo $current_page === 'post_apply.php' ? 'text-teal-700 active' : 'text-gray-700'; ?>">
            <i class="fas fa-briefcase mr-2"></i>Post Apply<br><span class="text-sm <?php echo $current_page === 'post_apply.php' ? 'text-teal-600' : 'text-gray-600'; ?>">پوسٹ اپلائی کریں</span>
        </a>
        <a href="challan.php" class="nav-tab flex-1 text-center px-4 py-3 rounded-md font-semibold <?php echo $current_page === 'challan.php' ? 'text-teal-700 active' : 'text-gray-700'; ?>">
            <i class="fas fa-money-check-alt mr-2"></i>Challan Form<br><span class="text-sm <?php echo $current_page === 'challan.php' ? 'text-teal-600' : 'text-gray-600'; ?>">چالان فارم</span>
        </a>
        <a href="documents.php" class="nav-tab flex-1 text-center px-4 py-3 rounded-md font-semibold <?php echo $current_page === 'documents.php' ? 'text-teal-700 active' : 'text-gray-700'; ?>">
            <i class="fas fa-file-upload mr-2"></i>Upload Documents<br><span class="text-sm <?php echo $current_page === 'documents.php' ? 'text-teal-600' : 'text-gray-600'; ?>">دستاویزات اپ لوڈ کریں</span>
        </a>
        <a href="undertaking.php" class="nav-tab flex-1 text-center px-4 py-3 rounded-md font-semibold <?php echo $current_page === 'undertaking.php' ? 'text-teal-700 active' : 'text-gray-700'; ?>">
            <i class="fas fa-handshake mr-2"></i>Undertaking<br><span class="text-sm <?php echo $current_page === 'undertaking.php' ? 'text-teal-600' : 'text-gray-600'; ?>">انڈرٹیکنگ</span>
        </a>
    </div>
    <div class="w-full bg-gray-200 mt-2 rounded-full h-2">
        <div class="bg-teal-600 h-2 rounded-full" style="width: <?php echo $progress_width; ?>%;"></div>
    </div>
</div>