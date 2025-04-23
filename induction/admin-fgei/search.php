<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Post Apply</title>
</head>
<body>
    <h2>Search Post Apply</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="cnic">Enter CNIC:</label>
        <input type="text" id="cnic" name="cnic" required>
        <input type="submit" value="Search">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include('../connection/conn.php');

        // Sanitize input
        $cnic = $_POST["cnic"];

        // Prepare the query to get the 'said' from 'acount_details'
        $stmt1 = $conn->prepare("SELECT said FROM acount_details WHERE cnic = ?");
        $stmt1->bind_param("s", $cnic); // 's' indicates that 'cnic' is a string

        // Execute the query
        $stmt1->execute();
        $result1 = $stmt1->get_result();

        if ($result1) {
            if ($result1->num_rows > 0) {
                // Fetch the 'said'
                $row = $result1->fetch_assoc();
                $said = $row["said"];

                // Prepare the query to get the 'post_apply' data based on 'said'
                $stmt2 = $conn->prepare("SELECT * FROM post_apply WHERE said = ?");
                $stmt2->bind_param("i", $said); // 'i' indicates that 'said' is an integer

                // Execute the query
                $stmt2->execute();
                $result2 = $stmt2->get_result();

                if ($result2) {
                    if ($result2->num_rows > 0) {
                        echo "<h2>Post Apply Details:</h2>";
                        while($row = $result2->fetch_assoc()) {
                            echo "id: " . $row["id"] . " - Post Category: " . $row["post_category"] . " - Post Apply: " . $row["post_apply"] . " - City Prefer: " . $row["city_prefer"] . "<br>";
                        }
                    } else {
                        echo "No records found in post_apply for said: " . $said;
                    }
                } else {
                    echo "Error retrieving data from post_apply table: " . $stmt2->error;
                }
                $stmt2->close();
            } else {
                echo "No records found for CNIC: " . $cnic;
            }
        } else {
            echo "Error retrieving data from acount_details table: " . $stmt1->error;
        }
        $stmt1->close();
        // Close the connection
        $conn->close();
    }
    ?>
</body>
</html>
