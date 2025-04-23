<?php
ob_start();
include('../connection/conn.php');
session_start(); // Always start session before using session variables

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    $user = $_SESSION['user_name'];
    $userid = $_SESSION['user_access'];
    $arr = explode(' ', trim($user));
    $newuser = ucfirst($arr[0]);

    if (isset($_GET['action']) && $_GET['action'] == 'export') {
        // Check if connection is successful
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $output = '';

        $output .= '<html><body>';
        $output .= '<table border="1">';
        $output .= '<tr>';
        $output .= '<th>Sno</th>';
        $output .= '<th>Post Name</th>';
        $output .= '<th>Total Applications</th>';
        $output .= '<th>Approved Applications</th>';
        $output .= '<th>Rejected Applications</th>';
        $output .= '<th>Reverted Applications</th>';
        $output .= '<th>Pending Applications</th>';
        $output .= '</tr>';

        $postsquery = "SELECT * FROM `posts`";
        $postsresult = mysqli_query($conn, $postsquery);

        if ($postsresult) {
            $counter = 0;

            // Check if there are any posts
            if (mysqli_num_rows($postsresult) > 0) {
                while ($postsmain = mysqli_fetch_assoc($postsresult)) {
                    $counter++;
                    $pid = $postsmain['pid'];

                    // Total count
                    $tcq = "SELECT post_apply.said FROM `post_apply`
                            INNER JOIN details ON post_apply.said = details.d_said 
                            INNER JOIN per_info ON post_apply.said = per_info.said
                            WHERE FIND_IN_SET('$pid', post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1";
                    $tcq2 = mysqli_query($conn, $tcq);
                    $tcresult = mysqli_num_rows($tcq2);
                    $totalapplied = $totalapplied + $tcresult;

                    // Approved count
                    $acq = "SELECT post_apply.said FROM `post_apply`
                            INNER JOIN details ON post_apply.said = details.d_said 
                            INNER JOIN per_info ON post_apply.said = per_info.said
                            WHERE FIND_IN_SET('$pid', post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1 AND details.d_status='Approved'";
                    $acq2 = mysqli_query($conn, $acq);
                    $acresult = mysqli_num_rows($acq2);
                    $totalapproved =$totalapproved +  $acresult;
                    
                    // Reverted count
                    $rcqr = "SELECT post_apply.said FROM `post_apply`
                            INNER JOIN details ON post_apply.said = details.d_said 
                            INNER JOIN per_info ON post_apply.said = per_info.said
                            WHERE FIND_IN_SET('$pid', post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1 AND details.d_status='Rejected' AND details.revert=1";
                    $rcqr2 = mysqli_query($conn, $rcqr);
                    $rcresultr = mysqli_num_rows($rcqr2);
                     $totalrejectedr =$totalrejectedr +  $rcresultr;
                    
                    
                    
                    

                    // Rejected count
                    $rcq = "SELECT post_apply.said FROM `post_apply`
                            INNER JOIN details ON post_apply.said = details.d_said 
                            INNER JOIN per_info ON post_apply.said = per_info.said
                            WHERE FIND_IN_SET('$pid', post_apply.post_apply) AND details.d_postid='$pid' AND per_info.undertaking = 1 AND details.d_status='Rejected'";
                    $rcq2 = mysqli_query($conn, $rcq);
                    $rcresult = mysqli_num_rows($rcq2);
                    $totalrejected =$totalrejected +  $rcresult;

                    // Pending count
                    $totalpending = $tcresult - $acresult - $rcresult;

                    // Constructing table row
                    $output .= '<tr>';
                    $output .= '<td>' . $counter . '</td>';
                    $output .= '<td>' . $postsmain['name'] . ' (' . $postsmain['gender'] . ') (BPS-' . $postsmain['bps'] . ')' . '</td>';
                    $output .= '<td>' . $tcresult . '</td>';
                    $output .= '<td>' . $acresult . '</td>';
                    $output .= '<td>' . $rcresult-$rcresultr . '</td>';
                    $output .= '<td>' . $rcresultr . '</td>';
                    $output .= '<td>' . $tcresult-$rcresult-$acresult . '</td>';
                    $output .= '</tr>';
                }
                $output .= '<tr>';
                    $output .= '<td>' . $counter . '</td>';
                    $output .= '<td>' .  ' Total </td>';
                    $output .= '<td>' . $totalapplied . '</td>';
                    $output .= '<td>' . $totalapproved . '</td>';
                    $output .= '<td>' . $totalrejected-$totalrejectedr . '</td>';
                    $output .= '<td>' . $totalrejectedr . '</td>';
                    $output .= '<td>' . $totalapplied-$totalapproved-$totalrejected . '</td>';
                    $output .= '</tr>';
                    
            } else {
                $output .= '<tr><td colspan="6">No posts found.</td></tr>'; // Handle case where no posts are found
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        $output .= '</table>';
        $output .= '</body></html>';

        // Output as Excel file
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=summary_report.xls");
        echo $output;

        exit();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Reports</title>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>

<!--<div class="col-sm-9 col-sm-3 col-lg-7 col-lg-offset-4 main">-->
<!--    <div class="row">-->
<!--        <div class="col-lg-12" align="center">-->
<!--            <h3 style="color: green;">Summary Report - All Posts</h3>-->
<!--        </div>-->
<!--    </div>-->

    <!-- Your summary report table for All Posts (if needed) -->
<!--    <div class="row" style="margin-top:10px" id="printableTable">-->
        <!-- Table for displaying data (if needed) -->
<!--        <button class="btn btn-primary btn-md" onclick="printDiv()">Print</button>-->
<!--        <a href="?action=export" class="btn btn-secondary btn-md">Export to Excel</a>-->
<!--    </div>-->
<!--</div>-->

<!-- Include your JavaScript files here -->

</body>
</html>

<?php
    mysqli_close($conn);
} else {
    header("Location: index.php");
    exit(); // Redirect if session is not valid
}
ob_flush();
?>
