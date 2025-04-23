<?php
include('../connection/conn.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    $user = $_SESSION['user_name'];
    $userid = $_SESSION['user_access'];

    $arr = explode(' ', trim($user));
    $newuser = ucfirst($arr[0]);

    if ($user == 'super-admin' || $user == 'aoi-3') {
        // SQL query to fetch data from lowerstaff table, join with posts table and details table
        $sql = "SELECT ls.*, p.name as post_name FROM lowerstaff ls 
                JOIN posts p ON ls.pid = p.pid";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $data = [];
            $districts = [
                'mardan', 'kohat', 'hangu', 'peshawar', 'nowshera', 'attock', 'islamabad', 'rawalpindi', 'haripur', 'abbottabad', 'jhelum', 'kotli', 'muzaffarabad', 
                'mianwali', 'khushab', 'mandi bahauddin', 'gujrat', 'gujranwala', 'sialkot', 'lahore', 'jhang', 'multan', 'hyderabad', 'quetta','karachi',
                'karachi north', 'karachi west', 'karachi east', 'karachi central', 'karachi south', 'karachi malir', 'karachi korangi', 'karachi keamari'
            ];

            // Initialize totals
            $districtTotals = array_fill_keys($districts, 0);
            $postTotals = [];

            // Organize data into a pivot table structure
            while ($row = $result->fetch_assoc()) {
                $postName = $row['post_name'];
                $postId = $row['pid'];

                if (!isset($data[$postName])) {
                    $data[$postName] = array_fill_keys($districts, 0);
                    $postTotals[$postName] = 0;
                }

                foreach ($districts as $district) {
                    // SQL query to count relevant records with d_status='Approved'
                    $query2 = "SELECT COUNT(*) AS count 
                               FROM per_info 
                               JOIN post_apply ON per_info.said = post_apply.said 
                               JOIN details d ON per_info.said = d.d_said 
                               WHERE 
                                 (CASE 
                                    WHEN per_info.female_applying = 1 THEN per_info.female_husband_district 
                                    ELSE per_info.contact_district 
                                  END) = '$district'
                                 AND FIND_IN_SET('$postId', d.d_postid) > 0 
                                 AND d.d_status = 'Approved' 
                                 AND per_info.undertaking = 1";

                    $result2 = $conn->query($query2);
                    if ($result2) {
                        $count = $result2->fetch_assoc()['count'];
                        $data[$postName][$district] += $count;
                        $districtTotals[$district] += $count;
                        $postTotals[$postName] += $count;
                    } else {
                        $data[$postName][$district] = "Error: " . $conn->error;
                    }
                }
            }

            // Output the data in an HTML table
            echo "<table border='1'>";
            echo "<tr><th>Post Name</th>";

            foreach ($districts as $district) {
                echo "<th>{$district}</th>";
            }
            echo "<th>Total</th></tr>";

            foreach ($data as $postName => $districtCounts) {
                echo "<tr>";
                echo "<td>{$postName}</td>";

                foreach ($districtCounts as $count) {
                    echo "<td>{$count}</td>";
                }

                // Add the post total column
                echo "<td>{$postTotals[$postName]}</td>";
                echo "</tr>";
            }

            // Add the district totals row
            echo "<tr><td>Total</td>";

            foreach ($districts as $district) {
                echo "<td>{$districtTotals[$district]}</td>";
            }
            echo "<td></td></tr>";

            echo "</table>";

            // Function to generate Excel content
            function generateExcel($data, $districts, $postTotals, $districtTotals) {
                $output = '';

                // Header row
                $output .= "Post Name";
                foreach ($districts as $district) {
                    $output .= ",{$district}";
                }
                $output .= ",Total\n";

                // Data rows
                foreach ($data as $postName => $districtCounts) {
                    $output .= "{$postName}";
                    foreach ($districtCounts as $count) {
                        $output .= ",{$count}";
                    }
                    $output .= ",{$postTotals[$postName]}\n";
                }

                // Total row
                $output .= "Total";
                foreach ($districts as $district) {
                    $output .= ",{$districtTotals[$district]}";
                }
                $output .= ",\n";

                return $output;
            }

            // Export to Excel or CSV logic
            if (isset($_POST['export_excel'])) {
                $filename = "district_wise_counts.csv"; // You can change to .xls for Excel format
                $excel_output = generateExcel($data, $districts, $postTotals, $districtTotals);

                // Output headers to force download
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="'.$filename.'"');
                echo $excel_output;
                exit;
            }

            // Add the Export to Excel button
            echo '<form method="post">';
            echo '<button type="submit" name="export_excel">Export to Excel</button>';
            echo '</form>';
        } else {
            echo "0 results";
        }
    } else {
        echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access to this page</div>';
    }

    $conn->close();
} else {
    echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You are not logged in</div>';
}
?>
