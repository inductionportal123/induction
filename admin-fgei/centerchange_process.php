<?php
include('../connection/conn.php');
if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['said'], $_POST['test_city'], $_POST['multy_city'])) {
    $said = $_POST['said'];
    $test_city = $_POST['test_city'];
    $multy_city = $_POST['multy_city'];

    $updateQuery = "
        UPDATE post_apply 
        SET city_prefer = ?, city_prefer_two = ? 
        WHERE said = ?
    ";

    if ($stmt = mysqli_prepare($conn, $updateQuery)) {
        mysqli_stmt_bind_param($stmt, "ssi", $test_city, $multy_city, $said);
        if (mysqli_stmt_execute($stmt)) {
            echo "Records updated successfully.";
        } else {
            echo "Error updating record: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the query: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Result</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <a href="centerchange.php" class="btn btn-primary">Go Back</a>
    </div>
</body>
</html>
