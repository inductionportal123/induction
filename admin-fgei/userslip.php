<?php
include('connection/conn.php');

// Get downloaded slips
$download_logs_query = "SELECT * FROM download_logs";
$download_logs_result = mysqli_query($conn, $download_logs_query);

// Get total number of downloads
$total_downloads_query = "SELECT COUNT(*) AS total FROM download_logs";
$total_downloads_result = mysqli_query($conn, $total_downloads_query);
$total_downloads_row = mysqli_fetch_assoc($total_downloads_result);
$total_downloads = $total_downloads_row['total'];

// Get user details
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
    $user_details_query = "SELECT * FROM per_info WHERE said='$user_id'";
    $user_details_result = mysqli_query($conn, $user_details_query);
    $user_details_row = mysqli_fetch_assoc($user_details_result);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <h2>Downloaded Slips</h2>
    <table border="1">
        <thead>
            <tr>
                <th>User ID</th>
                <th>Post ID</th>
                <th>Download Time</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($download_logs_result)) : ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['post_id']; ?></td>
                    <td><?php echo $row['download_time']; ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h2>User Details</h2>
    <form action="admin_panel.php" method="POST">
        <label for="user_id">Enter User ID:</label>
        <input type="text" id="user_id" name="user_id">
        <button type="submit">Get User Details</button>
    </form>
    <?php if (isset($user_details_row)) : ?>
        <div>
            <h3>User ID: <?php echo $user_details_row['said']; ?></h3>
            <p>Name: <?php echo $user_details_row['basic_full_name']; ?></p>
            <p>Father's Name: <?php echo $user_details_row['basic_father_name']; ?></p>
            <p>CNIC: <?php echo $user_details_row['contact_cnic']; ?></p>
            <!-- Add more details as needed -->
        </div>
    <?php endif; ?>
    <h2>Total Downloads</h2>
    <p>Total number of downloads: <?php echo $total_downloads; ?></p>
</body>
</html>
