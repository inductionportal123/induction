<?php
include('connection/conn.php');
if (!isset($_SESSION)) {
    session_start();
}

include('timeout.php');


if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    $que = "SELECT `undertaking` FROM `per_info` WHERE undertaking = 1 AND said = '$userid'";
    $ex = mysqli_query($conn, $que);
    $ro = mysqli_fetch_array($ex);
    $rowcount = mysqli_num_rows($ex);

    $que2 = "SELECT * FROM `emp_document` WHERE said = '$userid'";
    $ex2 = mysqli_query($conn, $que2);
    $ro2 = mysqli_fetch_array($ex2);

    if ($rowcount == 1) {
        $profile_picture=$ro2['image'];
        $undertakingset = "You have submitted the form successfully";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Undertaking</title>
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
        .nav-tab { transition: all 0.3s ease; position: relative; }
        .nav-tab.active { background: linear-gradient(to right, #0d9488, #14b8a6); color: white; }
        .nav-tab:hover:not(.active) { background: #e5e7eb; transform: scale(1.05); }
        .nav-tab::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 100%; height: 2px; background: #14b8a6; transform: scaleX(0); transition: transform 0.3s ease; }
        .nav-tab.active::after { transform: scaleX(1); }
        .progress-bar { height: 4px; background: #14b8a6; transition: width 0.5s ease; }
        .image-preview { max-width: 120px; max-height: 120px; object-fit: cover; border: 1px solid #e5e7eb; padding: 5px; border-radius: 4px; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased">
    <!-- Header -->
     <?php include 'header.php'; ?>

 <?php include 'sidebar.php'; ?>
    <!-- Main Content -->
    <main class="p-8 pt-24 w-full max-w-7xl mx-auto md:ml-72">
        <div class="bg-white p-8 rounded-xl shadow-lg">
            <!-- <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <i class="fas fa-clipboard-list text-teal-600 mr-2"></i> Registration Form
            </h2> -->

            <!-- Advanced Navigation Tabs -->
                        <?php include 'registration_form.php'; ?>

            <!-- Undertaking Content -->
            <div class="card p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                    <i class="fas fa-handshake mr-2"></i> Undertaking | انڈرٹیکنگ
                </h3>

             

                <!-- Undertaking Text -->
                <div class="mb-6">
                    <h5 class="text-teal-600 font-semibold mb-2">UNDERTAKING:</h5>
                    <ul class="list-disc pl-5 space-y-2 text-gray-700">
                        <li>I hereby undertake that I have read and understood the instructions / terms and conditions. All the information provided by me is true and accurate to the best of my knowledge, and I understand that any misrepresentation or omission of information may result in the disqualification of my application or termination of employment if I am selected.</li>
                        <li class="text-right">میں یہ عہد کرتا / کرتی ہوں کہ میں نے ہدایات / شرائط و ضوابط کو پڑھ اور سمجھ لیا ہے۔ میری طرف سے فراہم کردہ تمام معلومات میری بہترین معلومات کے مطابق درست اور مکمل ہیں، اور میں سمجھتا / سمجھتی ہوں کہ کسی بھی قسم کی غلط بیانی یا معلومات کو چھوڑنے کے نتیجے میں میری درخواست مسترد ہو سکتی ہے اور یہاں تک کہ ملازمت پر منتخب ہونے کے بعد ملازمت کے خاتمے کا سبب بھی بن سکتی ہے۔</li>
                    </ul>
                </div>

                <!-- Uploaded Images -->
              <!-- Uploaded Images -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <?php if (!empty($ro2['image'])) { ?>
        <div class="text-center">
            <h5 class="text-gray-700 font-semibold mb-2">Uploaded Profile Picture:</h5>
            <img src="<?php echo htmlspecialchars($ro2['image']); ?>" alt="Profile Picture" class="image-preview mx-auto" onerror="this.src='assets/no-image.png';">
        </div>
    <?php } else { ?>
        <div class="text-center">
            <h3 class="text-red-600 font-semibold">No image found. Please upload your Profile Picture.</h3>
        </div>
    <?php } ?>

    <?php if (!empty($ro2['recipt'])) { ?>
        <div class="text-center">
            <h5 class="text-gray-700 font-semibold mb-2">Uploaded Receipt:</h5>
            <img src="<?php echo htmlspecialchars($ro2['recipt']); ?>" alt="Receipt" class="image-preview mx-auto" onerror="this.src='assets/no-image.png';">
        </div>
    <?php } else { ?>
        <div class="text-center">
            <h3 class="text-red-600 font-semibold">No image found. Please upload your receipt.</h3>
        </div>
    <?php } ?>

    <?php if (!empty($ro2['cnic'])) { ?>
        <div class="text-center">
            <h5 class="text-gray-700 font-semibold mb-2">Uploaded Document (CNIC):</h5>
            <img src="<?php echo htmlspecialchars($ro2['cnic']); ?>" alt="CNIC" class="image-preview mx-auto" onerror="this.src='assets/no-image.png';">
        </div>
    <?php } else { ?>
        <div class="text-center">
            <h3 class="text-red-600 font-semibold">No image found. Please upload your CNIC.</h3>
        </div>
    <?php } ?>
</div>


                <?php if (isset($ro2) && is_array($ro2) && !empty($ro2['recipt']) && !empty($ro2['image'])) { ?>                    <!-- Undertaking Form -->
                    <form action="undertakingprocess.php" method="post" class="space-y-4">
                        <?php
                        $sqlcheck = "SELECT acount_details.id, per_info.said, emp_document.said, post_apply.said 
                                    FROM acount_details, per_info, emp_document, post_apply 
                                    WHERE acount_details.id='$userid' AND acount_details.id=per_info.said 
                                    AND acount_details.id=emp_document.said AND acount_details.id=post_apply.said";
                        $execheck = mysqli_query($conn, $sqlcheck);
                        $checkrow = mysqli_num_rows($execheck);
                        ?>

                        <div class="flex items-center">
                            <input type="checkbox" name="agree" id="agree" <?php echo isset($undertakingset) ? 'checked disabled' : 'required'; ?> class="h-5 w-5 text-teal-600 focus:ring-teal-500 border-gray-300 rounded">
                            <label for="agree" class="ml-2 text-gray-700">I agree to the terms and conditions</label>
                        </div>

                        <div class="flex justify-end items-center space-x-4">
                            <?php if (isset($undertakingset)) { ?>
                                <p class="text-green-600 font-semibold flex items-center"><i class="fas fa-check-circle mr-2"></i><?php echo $undertakingset; ?></p>
                            <?php } else if ($checkrow == 0) { ?>
                                <p class="text-red-600 font-semibold flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>Please complete your details.</p>
                            <?php } ?>
                            <button type="submit" class="px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all disabled:bg-gray-400 disabled:cursor-not-allowed" <?php echo ($checkrow == 0 || isset($undertakingset)) ? 'disabled' : ''; ?>>
                                Submit <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                <?php } else { ?>
                    <h3 class="text-red-600 font-semibold flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>Please submit the documents first.</h3>
                <?php } ?>
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

       
    </script>
</body>
</html>
<?php
} else {
    header("Location: index.php");
}
?>