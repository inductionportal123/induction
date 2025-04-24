<?php
include('connection/conn.php');
if (!isset($_SESSION)) {
    session_start();
}

include('timeout.php');

if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    $fee_detail_query = "SELECT * FROM `fee_detial` WHERE s_id = '$userid'";
    $ex2 = mysqli_query($conn, $fee_detail_query);
    $ro2 = mysqli_fetch_array($ex2);

    $que = "SELECT * FROM `emp_document` WHERE said = '$userid'";
    $ex = mysqli_query($conn, $que);
    $ro = mysqli_fetch_array($ex);
   
    $rowcount = mysqli_num_rows($ex);

    if ($rowcount >= 1) {
        $profile_picture=$ro['image'];
        $dataset = "ok";
        $documentmesg = "You have successfully uploaded documents.";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Upload Documents</title>
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
        .required { color: #e11d48; }
        .error-message { color: #e11d48; font-size: 0.875rem; }
        .nav-tab { transition: all 0.3s ease; position: relative; }
        .nav-tab.active { background: linear-gradient(to right, #0d9488, #14b8a6); color: white; }
        .nav-tab:hover:not(.active) { background: #e5e7eb; transform: scale(1.05); }
        .nav-tab::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 100%; height: 2px; background: #14b8a6; transform: scaleX(0); transition: transform 0.3s ease; }
        .nav-tab.active::after { transform: scaleX(1); }
        .progress-bar { height: 4px; background: #14b8a6; transition: width 0.5s ease; }
        .file-preview { max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb; }
        .uploaded-image { max-width: 150px; max-height: 150px; object-fit: cover; border-radius: 4px; border: 1px solid #e5e7eb; }
    </style>
</head>
<body class="bg-stone-50 font-sans antialiased">
    <!-- Header -->
     <?php include 'header.php'; ?>

  <?php include 'sidebar.php'; ?>
    <!-- Main Content -->
    <main class="p-8 pt-24 w-full max-w-7xl mx-auto md:ml-72">
        <div class="bg-white p-8 rounded-xl shadow-lg">

                    <?php include 'registration_form.php'; ?>

            <!-- Document Upload Content -->
            <div class="card p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                    <i class="fas fa-file-upload mr-2"></i> Upload Documents | دستاویزات اپ لوڈ کریں
                </h3>

            
                <?php if (!$ro2) { ?>
                    <!-- Transaction Details Form -->
                    <form action="storeTransaction.php" method="POST" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-md space-y-6">
                        <h3 class="text-center text-lg font-semibold text-gray-800">Submit Transaction Details</h3>
                        <p class="text-center text-sm text-gray-600">Please provide the following details to complete your transaction submission. After submitting, you will be eligible to upload the necessary documents.</p>

                        <input type="hidden" name="said" value="<?php echo htmlspecialchars($userid); ?>">
                        <div>
                            <label for="type" class="form-label">Type (Bank Name):</label>
                            <select name="type" id="type" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" required>
                                <option value="" disabled selected>Select Payment Method</option>
                                <option value="UBL">UBL (Cash Payment)</option>
                                <option value="MobileBanking">EasyPaisa, JazzCash, and others (Mobile Banking)</option>
                                <option value="OtherBankApp">Other Bank Mobile App (Online Transfer)</option>
                            </select>
                        </div>
                        <p class="text-xs text-gray-600">
                            <strong>Note:</strong> 
                            - For UBL branch payments, enter the <strong>SEQ number</strong>.<br>
                            - For mobile banking (e.g., EasyPaisa, JazzCash), provide the <strong>account number</strong>.<br>
                            - For other bank apps, provide the <strong>account number</strong> used for the transfer.
                        </p>
                        <div id="transaction-detail" class="hidden">
                            <label for="no" class="form-label">Transaction Detail:</label>
                            <input type="text" name="no" id="no" required placeholder="Enter Transaction ID or Account Number" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                        </div>
                        <button type="submit" class="w-full p-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all">Submit</button>
                    </form>
                <?php } else { ?>
                    <!-- Update Transaction Details -->
                    <div class="max-w-md mx-auto p-6 bg-gray-50 rounded-lg shadow-md mb-6">
                        <h3 class="text-center text-lg font-semibold text-gray-800 mb-4">Update Transaction Details</h3>
                        <form action="updateTransaction.php" method="POST" class="space-y-4">
                            <div>
                                <label for="type" class="form-label">Payment Method:</label>
                                <select name="type" id="type" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" required>
                                    <option value="" disabled>Select Payment Method</option>
                                    <option value="UBL" <?php echo ($ro2['type'] == 'UBL') ? 'selected' : ''; ?>>UBL (Cash Payment)</option>
                                    <option value="MobileBanking" <?php echo ($ro2['type'] == 'MobileBanking') ? 'selected' : ''; ?>>EasyPaisa, JazzCash, and others (Mobile Banking)</option>
                                    <option value="OtherBankApp" <?php echo ($ro2['type'] == 'OtherBankApp') ? 'selected' : ''; ?>>Other Bank Mobile App (Online Transfer)</option>
                                </select>
                            </div>
                            <div>
                                <label for="transaction_id" class="form-label">Transaction ID / Account No:</label>
                                <input type="text" id="transaction_id" name="transaction_id" value="<?php echo htmlspecialchars($ro2['no']); ?>" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500">
                            </div>
                            <button type="submit" class="w-full p-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all">Update Details</button>
                        </form>
                    </div>

                    <!-- Document Upload Form -->
                    <form id="document_id" method="post" action="document_process.php" enctype="multipart/form-data" class="space-y-6">
                        <div>
                            <h4 class="text-teal-600 font-semibold mb-2">Upload Your Documents:</h4>
                            <p class="text-red-600 text-sm">All files should be in <strong>JPG, JPEG or PNG format</strong> and less than <strong>500kb</strong>.</p>
                        </div>

                        <!-- Bank Challan Receipt -->
                        <?php
                        $postid = "SELECT post_apply.post_apply FROM post_apply WHERE post_apply.said='$userid'";
                        $idexe = mysqli_query($conn, $postid);
                        $iddata = mysqli_fetch_array($idexe);
                        $ppid = $iddata['post_apply'];
                        $str_arr = explode(",", $ppid);
                        foreach ($str_arr as $postids) {
                            $postapply = "SELECT SUM(fee_slot.fee) AS total FROM fee_slot WHERE fee_slot.post_id ='$postids'";
                            $postexe = mysqli_query($conn, $postapply);
                            $postdata = mysqli_fetch_array($postexe);
                            if ($postdata['total'] > 0) {
                        ?>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                    <div>
                                        <label class="form-label">Receipt of Challan Form:</label>
                                        <p class="text-sm text-red-600">Upload the computerized receipt or mobile banking screenshot.</p>
                                    </div>
                                    <div>
                                        <input type="file" name="recipt_image" id="recipt_images" onchange="recipt1(this);" class="w-full p-2 border rounded-md" <?php echo isset($ro['recipt']) ? '' : 'required'; ?>>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <img id="recipti" src="#" alt="Receipt Preview" class="file-preview hidden">
                                        <?php if (isset($ro['recipt'])) { ?>
                                            <img src="<?php echo htmlspecialchars($ro['recipt']); ?>" alt="Uploaded Receipt" class="uploaded-image">
                                        <?php } ?>
                                    </div>
                                </div>
                                <p id="recipt_back" class="text-sm"></p>
                        <?php
                                break;
                            }
                        }
                        ?>

                        <!-- Passport Size Image -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                            <label class="form-label">Passport Size Image:</label>
                            <input type="file" name="passport_image" id="passport_images" onchange="passport1(this);" class="w-full p-2 border rounded-md" <?php echo isset($ro['image']) ? '' : 'required'; ?>>
                            <div class="flex items-center space-x-4">
                                <img id="passporti" src="#" alt="Passport Preview" class="file-preview hidden">
                                <?php if (isset($ro['image'])) { ?>
                                    <img src="<?php echo htmlspecialchars($ro['image']); ?>" alt="Uploaded Passport" class="uploaded-image">
                                <?php } ?>
                            </div>
                        </div>
                        <p id="passport_back" class="text-sm"></p>

                        <!-- CNIC Front Side -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                            <label class="form-label">CNIC (Front Side):</label>
                            <input type="file" name="cnic_image" id="cnic_images" onchange="cnic1(this);" class="w-full p-2 border rounded-md" <?php echo isset($ro['cnic']) ? '' : 'required'; ?>>
                            <div class="flex items-center space-x-4">
                                <img id="cnici" src="#" alt="CNIC Preview" class="file-preview hidden">
                                <?php if (isset($ro['cnic'])) { ?>
                                    <img src="<?php echo htmlspecialchars($ro['cnic']); ?>" alt="Uploaded CNIC" class="uploaded-image">
                                <?php } ?>
                            </div>
                        </div>
                        <p id="cnic_back" class="text-sm"></p>

                        <!-- Professional Degree (Conditional) -->
                        <?php
                        foreach ($str_arr as $postids) {
                            $postapply = "SELECT posts.name FROM posts WHERE posts.pid = '$postids'";
                            $postexe = mysqli_query($conn, $postapply);
                            $postrow = mysqli_num_rows($postexe);
                            if ($postrow > 0) {
                                while ($postdata = mysqli_fetch_array($postexe)) {
                                    if (in_array($postdata['name'], ['Librarian', 'Assistant Librarian', 'Elementary School Teacher', 'Library Assistant'])) {
                        ?>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                            <div>
                                                <label class="form-label">Professional Degree:</label>
                                                <p class="text-sm text-red-600">Required for EST, Assistant Librarian, Library Assistant, Librarian.</p>
                                            </div>
                                            <input type="file" name="pdegree_image" id="pdegree_images" onchange="pdegree1(this);" class="w-full p-2 border rounded-md" <?php echo isset($ro['professional_degree']) ? '' : 'required'; ?>>
                                            <div class="flex items-center space-x-4">
                                                <img id="pdegreei" src="#" alt="Professional Degree Preview" class="file-preview hidden">
                                                <?php if (isset($ro['professional_degree'])) { ?>
                                                    <img src="<?php echo htmlspecialchars($ro['professional_degree']); ?>" alt="Uploaded Professional Degree" class="uploaded-image">
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <p id="pdegree_back" class="text-sm"></p>
                        <?php
                                        break 2;
                                    }
                                }
                            }
                        }
                        ?>

                        <!-- Driving License (Conditional) -->
                        <?php
                        foreach ($str_arr as $postids) {
                            $postapply = "SELECT posts.name FROM posts WHERE posts.pid = '$postids'";
                            $postexe = mysqli_query($conn, $postapply);
                            $postrow = mysqli_num_rows($postexe);
                            if ($postrow > 0) {
                                while ($postdata = mysqli_fetch_array($postexe)) {
                                    if ($postdata['name'] == 'Driver') {
                        ?>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                                            <div>
                                                <label class="form-label">Driving License:</label>
                                                <p class="text-sm text-red-600">Required if applying for Driver.</p>
                                            </div>
                                            <input type="file" name="ddegree_image" id="ddegree_images" onchange="ddegree1(this);" class="w-full p-2 border rounded-md" <?php echo isset($ro['driving_license']) ? '' : 'required'; ?>>
                                            <div class="flex items-center space-x-4">
                                                <img id="ddegreei" src="#" alt="Driving License Preview" class="file-preview hidden">
                                                <?php if (isset($ro['driving_license'])) { ?>
                                                    <img src="<?php echo htmlspecialchars($ro['driving_license']); ?>" alt="Uploaded Driving License" class="uploaded-image">
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <p id="ddegree_back" class="text-sm"></p>
                        <?php
                                        break 2;
                                    }
                                }
                            }
                        }
                        ?>

                        <!-- Response and Submit -->
                        <div class="flex justify-between items-center">
                            <div id="response" class="text-sm">
                                <?php
                                if (isset($_GET['size']) && $_GET['size'] == 'false') echo "File size is greater than 1MB.";
                                if (isset($_GET['type']) && $_GET['type'] == 'false') echo "Upload only JPG files.";
                                ?>
                            </div>
                            <div class="flex items-center space-x-4">
                                <?php if (isset($documentmesg)) { ?>
                                    <p class="text-green-600 font-semibold flex items-center"><i class="fas fa-check-circle mr-2"></i><?php echo $documentmesg; ?></p>
                                <?php } ?>
                                <button type="submit" id="submit_btn" class="px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all disabled:bg-gray-400 disabled:cursor-not-allowed" <?php echo isset($dataset) ? 'disabled' : ''; ?>>
                                    Save & Next <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
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

    

        // Transaction Detail Toggle
        $('#type').change(function() {
            const selected = this.value;
            const transactionDetail = $('#transaction-detail');
            const noField = $('#no');
            transactionDetail.removeClass('hidden');
            if (selected === 'UBL') noField.attr('placeholder', 'Enter SEQ No');
            else if (selected === 'MobileBanking') noField.attr('placeholder', 'Enter Account No (Mobile Banking)');
            else if (selected === 'OtherBankApp') noField.attr('placeholder', 'Enter Account No (Other Bank Mobile App)');
        });

        // File Validation and Preview Functions
        function validateFile(input, feedbackId, previewId, sizeLimit = 1000000) {
            const file = input.files[0];
            const feedback = $(`#${feedbackId}`);
            const submitBtn = $('#submit_btn');
            if (file && file.size <= sizeLimit && file.name.match(/.(jpg|JPG|jpeg|JPEG|png|PNG)$/i)) {
                feedback.text("Image uploaded successfully.").css({ color: 'green', fontSize: '0.875rem' });
                submitBtn.prop('disabled', false);
            } else {
                feedback.text("Image not valid/uploaded (must be JPG/JPEG, < 1MB).").css({ color: 'red', fontSize: '0.875rem' });
                submitBtn.prop('disabled', true);
            }
        }

        function previewFile(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $(`#${previewId}`).attr('src', e.target.result).removeClass('hidden');
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Receipt
        function recipt1(input) {
            validateFile(input, 'recipt_back', 'recipti');
            previewFile(input, 'recipti');
        }

        // Passport
        function passport1(input) {
            validateFile(input, 'passport_back', 'passporti');
            previewFile(input, 'passporti');
        }

        // CNIC
        function cnic1(input) {
            validateFile(input, 'cnic_back', 'cnici');
            previewFile(input, 'cnici');
        }

        // Professional Degree
        function pdegree1(input) {
            validateFile(input, 'pdegree_back', 'pdegreei');
            previewFile(input, 'pdegreei');
        }

        // Driving License
        function ddegree1(input) {
            validateFile(input, 'ddegree_back', 'ddegreei');
            previewFile(input, 'ddegreei');
        }
    </script>
</body>
</html>
<?php
} else {
    header("Location: index.php");
}
?>