 <!-- Enhanced Sidebar -->
    <div id="sidebar" class="fixed inset-y-0 left-0 w-72 bg-teal-800 text-white transform -translate-x-full md:translate-x-0 sidebar z-30 shadow-xl">
        <div class="p-6 flex flex-col h-full">
            <div class="flex items-center justify-between mb-8">
                <!-- <img src="images/logo.png" class="w-16 h-16 rounded-full border-2 border-teal-300"> -->
                <button id="sidebar-close" class="md:hidden text-2xl text-teal-100 hover:text-amber-400">×</button>
            </div>
            <nav class="flex-1">
                <ul class="space-y-4">
                    <li class="sidebar-item relative rounded-lg transition-all duration-300">
                        <a href="profile.php" class="flex items-center p-3 text-teal-100 hover:text-amber-400">
                            <i class="fas fa-user mr-3 text-lg"></i>Profile
                            <span class="tooltip">View your profile details</span>
                        </a>
                    </li>
                    <li class="sidebar-item relative rounded-lg transition-all duration-300">
                        <a href="per_info.php" class="flex items-center p-3 text-teal-100 hover:text-amber-400">
                            <i class="fas fa-edit mr-3 text-lg"></i>Personal Info
                            <span class="tooltip">Update your personal information</span>
                        </a>
                    </li>
                    <li class="sidebar-item relative rounded-lg transition-all duration-300">
                        <a href="resetpassword.php" class="flex items-center p-3 text-teal-100 hover:text-amber-400">
                            <i class="fas fa-key mr-3 text-lg"></i>Reset Password
                            <span class="tooltip">Change your password</span>
                        </a>
                    </li>
                    <li class="sidebar-item relative rounded-lg transition-all duration-300">
                        <a href="queryportal.php" class="flex items-center p-3 text-teal-100 hover:text-amber-400">
                            <i class="fas fa-comment mr-3 text-lg"></i>Query Portal
                            <span class="tooltip">Ask questions or get support</span>
                        </a>
                    </li>
                    <li class="sidebar-item relative rounded-lg transition-all duration-300">
                        <a href="logout.php" class="flex items-center p-3 text-teal-100 hover:text-amber-400">
                            <i class="fas fa-sign-out-alt mr-3 text-lg"></i>Logout
                            <span class="tooltip">Sign out of your account</span>
                        </a>
                    </li>
                </ul>
            </nav>
          <div class="mt-auto text-center text-teal-200 text-sm">
    <p>Current Date: <?php echo date('d F, Y'); ?></p>
</div>
        </div>
    </div>
