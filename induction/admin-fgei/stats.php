<?php
// Include database connection
include('../connection/conn.php');

// Set timezone to Pakistan Standard Time
date_default_timezone_set('Asia/Karachi');

// Start session if not already started
if (!isset($_SESSION)) {
    session_start();
}

// Check if user is logged in
if (!isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    echo "User not logged in.";
    exit;
}

$user = $_SESSION['user_name'];
$userid = $_SESSION['user_access'];

// Initialize variables to avoid undefined errors
$total_users = 0;
$total_undertaking = 0;

// Query to count total number of registered users
$query_total = "SELECT COUNT(*) AS total_users FROM acount_details";
$stmt_total = $conn->prepare($query_total);

if ($stmt_total) {
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $row_total = $result_total->fetch_assoc();
    $total_users = isset($row_total['total_users']) ? $row_total['total_users'] : 0;
    $stmt_total->close();
}

// Query to count total final submitted applicants
$query = "SELECT COUNT(DISTINCT said) AS total FROM per_info WHERE undertaking = 1";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $total_undertaking = isset($row['total']) ? $row['total'] : 0;
    $stmt->close();
}

// Fetch data for undertaking graph (every 1-hour interval for today in Pakistan Time)
$query_undertaking = "
    SELECT 
        DATE_FORMAT(CONVERT_TZ(undertaking_date, '+00:00', '+05:00'), '%Y-%m-%d %H:00:00') AS hour_interval, 
        COUNT(*) as count 
    FROM per_info 
    WHERE undertaking = 1 
    AND DATE(CONVERT_TZ(undertaking_date, '+00:00', '+05:00')) = CURDATE() 
    GROUP BY hour_interval 
    ORDER BY hour_interval ASC
";

$stmt_undertaking = $conn->prepare($query_undertaking);
$undertaking_data = [];

if ($stmt_undertaking) {
    $stmt_undertaking->execute();
    $result_undertaking = $stmt_undertaking->get_result();

    while ($row = $result_undertaking->fetch_assoc()) {
        $undertaking_data[] = $row;
    }

    $stmt_undertaking->close();
}

// Convert data to JSON for Chart.js
$undertaking_labels = [];
$undertaking_counts = [];

foreach ($undertaking_data as $data) {
    $undertaking_labels[] = $data['hour_interval']; // X-axis (Hours)
    $undertaking_counts[] = $data['count']; // Y-axis (Counts)
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Statistics (PST)</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <!-- Back Button -->
        <div class="mb-4">
            <button onclick="window.history.back()" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-300">
                ← Back
            </button>
        </div>

        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">User Registration Statistics (PST)</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Total Registered Users -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700">Total Registered Users</h2>
                <p class="text-5xl font-bold text-blue-600 mt-2"><?php echo $total_users; ?></p>
                <p class="text-gray-500 mt-2">All users registered on the platform.</p>
            </div>

            <!-- Total Final Submitted Applicants -->
            <div class="bg-white p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-semibold text-gray-700">Final Submitted Applicants</h2>
                <p class="text-5xl font-bold text-green-600 mt-2"><?php echo $total_undertaking; ?></p>
                <p class="text-gray-500 mt-2">Users who have completed their submissions.</p>
            </div>
        </div>

        <!-- Undertaking Stats Chart -->
        <div class="bg-white p-6 rounded-lg shadow-lg mt-8">
            <h2 class="text-xl font-semibold text-gray-700">Final Submission Statistics (Hourly for Today - PST)</h2>
            <canvas id="undertakingChart"></canvas>
        </div>
    </div>

    <script>
        // Undertaking Data
        let undertakingLabels = <?php echo json_encode($undertaking_labels); ?>;
        let undertakingCounts = <?php echo json_encode($undertaking_counts); ?>;

        // Create Chart
        let ctx = document.getElementById("undertakingChart").getContext("2d");
        let undertakingChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: undertakingLabels,
                datasets: [{
                    label: "Undertakings Per Hour (PST)",
                    data: undertakingCounts,
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Function to Fetch Latest Data
        function fetchUndertakingData() {
            fetch("stats.php?action=fetch_undertaking_data")
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        console.error(data.error);
                    } else {
                        undertakingChart.data.labels = data.labels;
                        undertakingChart.data.datasets[0].data = data.counts;
                        undertakingChart.update();
                    }
                })
                .catch(error => console.error("Error fetching data:", error));
        }

        // Auto-refresh every 5 seconds
        setInterval(fetchUndertakingData, 5000);
    </script>
</body>
</html>

<?php
// Handle AJAX request for undertaking data
if (isset($_GET['action']) && $_GET['action'] === 'fetch_undertaking_data') {
    include('../connection/conn.php');

    $query_undertaking = "
        SELECT 
            DATE_FORMAT(CONVERT_TZ(undertaking_date, '+00:00', '+05:00'), '%Y-%m-%d %H:00:00') AS hour_interval, 
            COUNT(*) as count 
        FROM per_info 
        WHERE undertaking = 1 
        AND DATE(CONVERT_TZ(undertaking_date, '+00:00', '+05:00')) = CURDATE() 
        GROUP BY hour_interval 
        ORDER BY hour_interval ASC
    ";

    $stmt_undertaking = $conn->prepare($query_undertaking);
    $undertaking_data = [];

    if ($stmt_undertaking) {
        $stmt_undertaking->execute();
        $result_undertaking = $stmt_undertaking->get_result();

        while ($row = $result_undertaking->fetch_assoc()) {
            $undertaking_data[] = $row;
        }

        $stmt_undertaking->close();
    }

    echo json_encode([
        'labels' => array_column($undertaking_data, 'hour_interval'),
        'counts' => array_column($undertaking_data, 'count')
    ]);
    exit;
}
?>
