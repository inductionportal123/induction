<?php
include('../connection/conn.php');

// Ensure session is started
if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    $user = $_SESSION['user_name'];
    $userid = $_SESSION['user_access'];

    $arr = explode(' ', trim($user));
    $newuser = ucfirst($arr[0]);

    if ($user == 'super-admin') {
        $usercnic = "";
        $rows = [];

        // Fetch records if CNIC is provided
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cnic'])) {
            $usercnic = $_POST['cnic'];

            $query = "
                SELECT per_info.said, details.d_postid, details.d_centerid, posts.name AS post_name
                FROM per_info
                JOIN post_apply ON per_info.said = post_apply.said
                JOIN details ON per_info.said = details.d_said
                JOIN posts ON details.d_postid = posts.pid
                WHERE per_info.contact_cnic = ?
            ";

            if ($stmt = mysqli_prepare($conn, $query)) {
                mysqli_stmt_bind_param($stmt, "s", $usercnic);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing the query: " . mysqli_error($conn);
            }
        }

        // Update center ID if form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['said'], $_POST['d_centerid'], $_POST['d_postid'])) {
            $said = $_POST['said'];
            $d_centerid = $_POST['d_centerid'];
            $d_postid = $_POST['d_postid'];

            $updateQuery = "UPDATE details SET d_centerid = ? WHERE d_said = ? AND d_postid = ?";
            if ($updateStmt = mysqli_prepare($conn, $updateQuery)) {
                mysqli_stmt_bind_param($updateStmt, "iis", $d_centerid, $said, $d_postid);
                mysqli_stmt_execute($updateStmt);
                mysqli_stmt_close($updateStmt);
                echo "Center updated successfully.";
            } else {
                echo "Error preparing the update query: " . mysqli_error($conn);
            }
        }
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Enter CNIC</title>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <link href="css/bootstrap.min.css" rel="stylesheet">
            <link href="css/styles.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
            <script src="js/bootstrap.min.js"></script>
        </head>
        <body>
            <?php include('header.php'); include('appnav.php'); ?>

            <div class="container">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <div class="col-md-12">
                            <form action="" method="post" class="form-inline mb-3">
                                <br><br>
                                <label for="cnic" class="mr-2">Enter CNIC:</label>
                                <input type="text" id="cnic" name="cnic" value="<?php echo isset($usercnic) ? htmlspecialchars($usercnic) : ''; ?>" class="form-control col-md" placeholder="Enter CNIC No" required>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>

                        <div class="col-md-12">
                            <?php if (!empty($rows)): ?>
                                <?php foreach ($rows as $row): ?>
                                    <form action="" method="post">
                                        <input type="hidden" name="said" value="<?php echo htmlspecialchars($row['said']); ?>">
                                        <input type="hidden" name="cnic" value="<?php echo htmlspecialchars($usercnic); ?>">
                                        <input type="hidden" name="d_postid" value="<?php echo htmlspecialchars($row['d_postid']); ?>">

                                        <div class="form-group row mb-3">
                                            <label for="post_name" class="col-md col-form-label">Post Name:</label>
                                            <div class="col-md">
                                                <input type="text" id="post_name" name="post_name" value="<?php echo htmlspecialchars($row['post_name']); ?>" class="form-control" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group row mb-3">
                                            <label for="d_centerid" class="col-md col-form-label">Center:</label>
                                            <div class="col-md">
                                                <select class="form-control" name="d_centerid" required>
                                                    <option value="">Select Center</option>
                                                    <?php
                                                    $centerQuery = "SELECT id, center FROM centers"; // Fixed table name
                                                    $centerExe = mysqli_query($conn, $centerQuery);
                                                    while ($centerRow = mysqli_fetch_array($centerExe)) {
                                                    ?>
                                                        <option value="<?php echo $centerRow['id']; ?>" <?php if (isset($row['d_centerid']) && $row['d_centerid'] == $centerRow['id']) echo "selected"; ?>>
                                                            <?php echo strtoupper($centerRow['center']); ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form>
                                <?php endforeach; ?>
                            <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                                <div class="alert alert-warning col-sm-6" role="alert">
                                    No record found for the given CNIC.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>

        <?php
    } else {
        echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access to this page</div>';
    }
} else {
    header("Location: index.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>
