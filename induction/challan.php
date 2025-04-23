<?php
include('connection/conn.php');
if (!isset($_SESSION)) {
    session_start();
}

include('timeout.php');


if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

   $que = "SELECT acount_details.*, emp_document.image 
        FROM `acount_details` 
        INNER JOIN `emp_document` ON `acount_details`.`id` = `emp_document`.`said` 
        WHERE `acount_details`.`id` = '$userid'";
    $ex = mysqli_query($conn, $que);
    $ro = mysqli_fetch_array($ex);
    $rowcount = mysqli_num_rows($ex);

    if ($rowcount == 1) {
        $datast = "ok";
        $account_detail_name = $ro['name'];
        $account_detail_email = $ro['email'];
        $account_detail_cnic = $ro['cnic'];
        $profile_picture = $ro['image'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FGEI (C/G) - Recruitment | Challan Form</title>
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
        .table { border-collapse: separate; border-spacing: 0; }
        .table th, .table td { border: 1px solid #e5e7eb; padding: 12px; text-align: center; }
        .table th { background: #005faf; color: white; }
        .table tbody tr:nth-child(even) { background: #f9fafb; }
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

                      <?php include 'registration_form.php'; ?>

            <!-- Challan Form Content -->
            <div class="card p-6 rounded-lg">
                <h3 class="text-lg font-semibold text-teal-700 mb-4 flex items-center">
                    <i class="fas fa-money-check-alt mr-2"></i> Challan Form | چالان فارم
                </h3>

                <?php
                $postapply = "SELECT SUM(fee_slot.fee) AS total FROM fee_slot WHERE fee_slot.post_id IN (SELECT details.d_postid FROM details WHERE details.d_said='$userid')";
                $postexe = mysqli_query($conn, $postapply);
                $postdata = mysqli_fetch_array($postexe);
                if ($postdata['total'] > 0) {
                    $newquery = "SELECT `post_apply` FROM `post_apply` WHERE said = '$userid'";
                    $newexe = mysqli_query($conn, $newquery);
                    $newrow = mysqli_fetch_array($newexe);
                    $newrowcount = mysqli_num_rows($newexe);

                    if ($newrowcount == 1) {
                        $x = $newrow['post_apply'];
                    }
                    if (isset($x)) {
                        $value = explode(",", $x);
                        $result = strtolower("'" . implode("', '", $value) . "'");
                        $total = 0;

                        echo "<h4 class='text-green-600 mb-4 flex items-center'><i class='fas fa-check-circle mr-2'></i>You have applied for the following posts:</h4>";
                        $querys = "SELECT `slot`, `fee` FROM `fee_slot` WHERE `post_id` IN ($result)";
                        $exes = mysqli_query($conn, $querys);

                        if ($exes) {
                ?>
                            <div class="overflow-x-auto">
                                <table class="table w-full">
                                    <thead>
                                        <tr>
                                            <th>Applied Post</th>
                                            <th>Fee (PKR)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while ($rows = mysqli_fetch_array($exes)) {
                                            $total += (int)$rows['fee'];
                                        ?>
                                            <tr>
                                                <td><?php echo strtoupper($rows['slot']); ?></td>
                                                <td><?php echo $rows['fee']; ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr class="font-semibold">
                                            <td>Total Amount (Payable):</td>
                                            <td><?php echo $total; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-gray-600 mt-4">If your Total Fees is not zero (0), please download this challan form and submit the fees at any branch of the selected bank. Upload a scanned copy of the <strong>computerized receipt issued by the bank</strong> in the next tab along with your profile picture.</p>
                            <p class="text-red-600 mt-2"><strong>Notice:</strong> The fee is neither refundable nor transferable for the next induction/other posts.</p>

                            <!-- Bank Selection and Download -->
                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <?php
                                    $query2 = "SELECT * FROM `bank_fee` ORDER BY id ASC";
                                    $exe2 = mysqli_query($conn, $query2);
                                    ?>
                                    <form action="challanprocess.php" method="post" target="_blank">
                                        <label class="form-label mb-2">Select Your Bank</label>
                                        <select name="bank" class="w-full p-3 border rounded-md focus:ring-2 focus:ring-teal-500" required>
                                            <option value="">Select your bank</option>
                                            <?php while ($datarows = mysqli_fetch_array($exe2)) { ?>
                                                <option value="<?php echo $datarows['id']; ?>"><?php echo strtoupper($datarows['name']); ?></option>
                                            <?php } ?>
                                        </select>
                                        <button type="submit" class="mt-4 px-6 py-3 bg-teal-700 text-white rounded-lg hover:bg-teal-600 transition-all w-full">
                                            <i class="fas fa-download mr-2"></i> Download Challan Form
                                        </button>
                                    </form>
                                </div>
                            </div>
                <?php
                        }
                    }
                } else {
                ?>
                    <h4 class="text-red-600 flex items-center"><i class="fas fa-exclamation-circle mr-2"></i>No Posts Selected.</h4>
                <?php
                }
                ?>
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