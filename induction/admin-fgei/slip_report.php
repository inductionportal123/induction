<?php
include('../connection/conn.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    
// Handle CNIC search
$search_cnic = isset($_POST['search_cnic']) ? $_POST['search_cnic'] : '';

// Prepare the query based on CNIC search
$download_logs_query = $search_cnic 
    ? "SELECT * FROM download_logs WHERE user_id IN (SELECT said FROM per_info WHERE contact_cnic = '$search_cnic')"
    : "SELECT * FROM download_logs LIMIT 10";

$download_logs_result = mysqli_query($conn, $download_logs_query);

// Get data for graph
$graph_data_query = "SELECT post_id, COUNT(*) AS total_downloads FROM download_logs GROUP BY post_id";
$graph_data_result = mysqli_query($conn, $graph_data_query);

$post_ids = [];
$total_downloads = [];

while ($row = mysqli_fetch_assoc($graph_data_result)) {
    $post_ids[] = $row['post_id'];
    $total_downloads[] = $row['total_downloads'];
}

// Query for total downloads per user
$total_downloads_query = "SELECT user_id, COUNT(DISTINCT post_id) AS total_downloads FROM download_logs GROUP BY user_id LIMIT 10";
$total_downloads_result = mysqli_query($conn, $total_downloads_query);

// Query for total unique downloads per post
$postwise_downloads_query = "SELECT post_id, COUNT(DISTINCT user_id) AS total_downloads FROM download_logs GROUP BY post_id";
$postwise_downloads_result = mysqli_query($conn, $postwise_downloads_query);
$total_download=0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Slip Details</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">

    <?php if(isset($_SESSION['user_name'], $_SESSION['user_access'])): ?>
    <div class="container mx-auto p-6">
      
      <a href="pending.php" class="btn btn-outline-danger btn-lg rounded-pill shadow-lg bg-red-500 text-white p-3 hover:bg-red-700 transition duration-300">Go Back</a>

      <h1 class="text-3xl font-semibold my-6">User Slip Details</h1>

      <!-- Search Form -->
      <form method="POST" class="mb-6 p-4 bg-white shadow-md rounded-lg flex items-center space-x-4">
          <label for="search_cnic" class="block text-lg font-medium">Search by CNIC</label>
          <input type="text" id="search_cnic" name="search_cnic" class="form-control p-2 border border-gray-300 rounded-lg w-1/3" placeholder="Enter CNIC" value="<?php echo htmlspecialchars($search_cnic); ?>">
          <button type="submit" class="btn bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 transition duration-300">Search</button>
      </form>

      <!-- Buttons for table, graph, and total downloads sections -->
      <div class="mb-6 space-x-4">
          <button id="showTable" class="btn bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Show Table</button>
          <button id="showGraph" class="btn bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Show Graph</button>
          <button id="showTotalDownloads" class="btn bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Show Total Downloads Per User</button>
          <button id="showPostwiseDownloads" class="btn bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Show Postwise Downloads</button>
      </div>

      <!-- Table -->
      <div id="tableContainer">
          <h2 class="text-xl font-semibold mb-4">Downloaded Slips (Table)</h2>
          <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
              <thead class="bg-gray-100">
                  <tr>
                      <th class="px-4 py-2">User Name</th>
                      <th class="px-4 py-2">User CNIC</th>
                      <th class="px-4 py-2">Post Name</th>
                      <th class="px-4 py-2">Download Time</th>
                  </tr>
              </thead>
              <tbody>
                  <?php while ($row = $download_logs_result->fetch_assoc()): 
                      $user_id = $row['user_id'];
                      $nameselect = "SELECT basic_full_name, contact_cnic FROM per_info WHERE said = $user_id";
                      $name_result = $conn->query($nameselect);
                      $name_row = $name_result->fetch_assoc();
                      $basic_full_name = $name_row['basic_full_name'];
                      $contact_cnic = $name_row['contact_cnic'];
                  ?>
                  <tr class="border-t hover:bg-gray-50">
                      <td class="px-4 py-2"><?php echo $basic_full_name; ?></td>
                      <td class="px-4 py-2"><?php echo $contact_cnic; ?></td>
                      <td class="px-4 py-2">
                          <?php
                          $post_id = $row['post_id'];
                          $querypost = "SELECT name, gender FROM posts WHERE pid=$post_id";
                          $result = mysqli_query($conn, $querypost);
                          if ($result && mysqli_num_rows($result) > 0) {
                              $post = mysqli_fetch_assoc($result);
                              echo $post['name'].'  ('.$post['gender'].')';
                          }
                          ?>
                      </td>
                      <td class="px-4 py-2"><?php echo $row['download_time']; ?></td>
                  </tr>
                  <?php endwhile; ?>
              </tbody>
          </table>
      </div>

      <!-- Graph -->
      <div id="graphContainer" class="mt-8" style="display: none;">
          <h2 class="text-xl font-semibold mb-4">Downloaded Slips (Graph)</h2>
          <canvas id="downloadsGraph" class="w-full max-w-4xl mx-auto" width="400" height="200"></canvas>
      </div>

      <!-- Total Downloads Per User -->
      <div id="totalDownloadsContainer" class="mt-8" style="display: none;">
          <h2 class="text-xl font-semibold mb-4">Total Downloads Per User</h2>
          <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
              <thead class="bg-gray-100">
                  <tr>
                      <th class="px-4 py-2">User Name</th>
                      <th class="px-4 py-2">User CNIC</th>
                      <th class="px-4 py-2">Total Downloads</th>
                  </tr>
              </thead>
              <tbody>
                  <?php while ($row = $total_downloads_result->fetch_assoc()): 
                      $user_id = $row['user_id'];
                      $nameselect = "SELECT basic_full_name, contact_cnic FROM per_info WHERE said = $user_id";
                      $name_result = $conn->query($nameselect);
                      $name_row = $name_result->fetch_assoc();
                      $basic_full_name = $name_row['basic_full_name'];
                      $contact_cnic = $name_row['contact_cnic'];
                  ?>
                  <tr class="border-t hover:bg-gray-50">
                      <td class="px-4 py-2"><?php echo $basic_full_name; ?></td>
                      <td class="px-4 py-2"><?php echo $contact_cnic; ?></td>
                      <td class="px-4 py-2"><?php echo $row['total_downloads']; ?></td>
                  </tr>
                  <?php endwhile; ?>
              </tbody>
          </table>
      </div>
<?php 
// Query to count total centers
$total_center_query = "SELECT COUNT(*) AS total FROM details WHERE d_centerid IS NOT NULL";

// Execute the query
$result = $conn->query($total_center_query);

if ($result) {
    $row = $result->fetch_assoc();
    $total_center = $row['total'];
} else {
    $total_center = 0; // Set default value in case of an error
}


?>

<!-- Postwise Downloads -->
<div id="postwiseDownloadsContainer" class="mt-8" style="display: none;">
    <h2 class="text-xl font-semibold mb-4">Total Unique Downloads Per Post</h2>
    <table class="table-auto w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2">Post Name</th>
                <th class="px-4 py-2">Total Unique Downloads</th>
            </tr>
        </thead>
      <tbody>
    <?php 
    $total_download = 0; // Initialize total download counter
    while ($row = $postwise_downloads_result->fetch_assoc()): 
        $post_id = (int) $row['post_id']; // Ensure it's an integer for security
        $querypost = "SELECT name, gender FROM posts WHERE pid = $post_id";
        $result = mysqli_query($conn, $querypost);
        
        if ($result && mysqli_num_rows($result) > 0) {
            $post = mysqli_fetch_assoc($result);
            $total_download += $row['total_downloads']; // Correctly sum downloads
    ?>
    <tr class="border-b hover:bg-gray-100 text-gray-700">
        <td class="px-4 py-3 font-medium"><?php echo htmlspecialchars($post['name']) . ' (' . htmlspecialchars($post['gender']) . ')'; ?></td>
        <td class="px-4 py-3 text-center"><?php echo $row['total_downloads']; ?></td>
    </tr>
    <?php } ?>
    <?php endwhile; ?>

    <!-- Total Row -->
    <tr class="border-t bg-gray-100 font-semibold text-gray-900">
        <td class="px-4 py-3">Total Downloads</td>
        <td class="px-4 py-3 text-center"><?php echo $total_download; ?></td>
    </tr>

    <!-- Remaining Row -->
    <tr class="border-t bg-gray-200 font-semibold text-gray-900">
        <td class="px-4 py-3">Remaining</td>
        <td class="px-4 py-3 text-center"><?php echo $total_center - $total_download; ?></td>
    </tr>
</tbody>

    </table>
</div>


    </div>

    <script>
        document.getElementById('showTable').addEventListener('click', function() {
            document.getElementById('tableContainer').style.display = 'block';
            document.getElementById('graphContainer').style.display = 'none';
            document.getElementById('totalDownloadsContainer').style.display = 'none';
            document.getElementById('postwiseDownloadsContainer').style.display = 'none';
        });

        document.getElementById('showGraph').addEventListener('click', function() {
            document.getElementById('tableContainer').style.display = 'none';
            document.getElementById('graphContainer').style.display = 'block';
            document.getElementById('totalDownloadsContainer').style.display = 'none';
            document.getElementById('postwiseDownloadsContainer').style.display = 'none';
        });

        document.getElementById('showTotalDownloads').addEventListener('click', function() {
            document.getElementById('tableContainer').style.display = 'none';
            document.getElementById('graphContainer').style.display = 'none';
            document.getElementById('totalDownloadsContainer').style.display = 'block';
            document.getElementById('postwiseDownloadsContainer').style.display = 'none';
        });

        document.getElementById('showPostwiseDownloads').addEventListener('click', function() {
            document.getElementById('tableContainer').style.display = 'none';
            document.getElementById('graphContainer').style.display = 'none';
            document.getElementById('totalDownloadsContainer').style.display = 'none';
            document.getElementById('postwiseDownloadsContainer').style.display = 'block';
        });

        var ctx = document.getElementById('downloadsGraph').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($post_ids); ?>,
                datasets: [{
                    label: 'Total Downloads',
                    data: <?php echo json_encode($total_downloads); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>

    <?php else: ?>
        <div class="alert alert-danger text-center shadow-lg rounded-lg p-6 bg-red-100">
            <h4 class="text-lg font-semibold">Access Denied</h4>
            <p>You don't have access to this page.</p>
            <p>If you believe this is an error, please contact support.</p>
        </div>
    <?php endif; ?>
</body>
</html>
