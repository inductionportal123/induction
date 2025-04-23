<?php
include('../connection/conn.php');
error_reporting(0);
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Post Apply</title>
    <!-- Bootstrap CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
<script src="js/bootstrap.min.js"></script> 
   

    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php include('header.php');
    ?>
     <?php if(isset($_SESSION['user_name'],$_SESSION['user_access']))
        {
            	$user = $_SESSION['user_name'];
  $userid = $_SESSION['user_access'];

	$arr = explode(' ',trim($user));
	$newuser  = ucfirst("$arr[0]");
            ?>
            
    <br><br><br>
   <a href="searchroll.php">Back</a>

    
   
    <div class="container">
        <div class="container">
        <div class="row">
            <div class="col-md-3">
                
            </div>
            <div class="col-md-9">
                
        <br><br>
        <h2 class="mt-4">Search Post Apply</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="mt-3">
            <div class="form-group">
                <label for="cnic">Enter CNIC with Dash:</label>
                <input type="text" id="cnic" name="cnic" class="form-control" placeholder="99999-9999999-9" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <?php
        

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            include('../connection/conn.php');

            // Sanitize input
            $cnic = $_POST["cnic"];

            // Prepare the query to get the 'said' from 'acount_details'
            $stmt1 = $conn->prepare("SELECT id FROM acount_details WHERE cnic = ?");
            $stmt1->bind_param("s", $cnic); // 's' indicates that 'cnic' is a string

            // Execute the query
            $stmt1->execute();
            $result1 = $stmt1->get_result();

            if ($result1) {
                if ($result1->num_rows > 0) {
                    // Fetch the 'said'
                    $row = $result1->fetch_assoc();
                    $said = $row["id"];

                    // Prepare the query to get the 'post_apply' data based on 'said'
                    $stmt2 = $conn->prepare("SELECT post_apply.post_apply, post_apply.city_prefer,per_info.basic_full_name,per_info.undertaking FROM post_apply INNER JOIN per_info ON post_apply.said = per_info.said WHERE per_info.said = ?");
                    $stmt2->bind_param("i", $said); // 'i' indicates that 'said' is an integer

                    // Execute the query
                    $stmt2->execute();
                    $result2 = $stmt2->get_result();
                    

                    if ($result2) {
                        if ($result2->num_rows > 0) {
                            echo "<h3 class='mt-4'>Post Apply Details:  ".$cnic."</h3>";
                            echo "<div class='table-responsive'>";
                            echo "<table class='table table-striped'>";
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>Applicant Name</th>";
                            echo "<th>Submited</th>";
                            echo "<th>Post Apply</th>";
                            // echo "<th>City Prefer</th>";
                            echo "<th>Status</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                    
                            while ($row = $result2->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["basic_full_name"] . "</td>";
                                if($row["undertaking"]==1){
                                   
                                    echo "<td>" . 'Yes' . "</td>";

                                }
                                else if($row["undertaking"]==0)
                                {
                                    echo "<td>" . 'No' . "</td>";
                                }
                                // echo "<td>" . $row["undertaking"] . "</td>";

                            
                                // Split the string into an array of values
                                $post_apply_values = explode(",", $row["post_apply"]);
                            
                                // Initialize an empty string to store post names
                                $post_names = "";
                            
                                // Loop through each value
                                foreach ($post_apply_values as $post_apply_value) {
                                    // Get the name of the post applied
                                    $stmt4 = $conn->prepare("SELECT name FROM posts WHERE pid = ?");
                                    $stmt4->bind_param("i", $post_apply_value);
                                    $stmt4->execute();
                                    $result4 = $stmt4->get_result();
                            
                                    if ($result4->num_rows > 0) {
                                        $post_row = $result4->fetch_assoc();
                                        $post_names .= $post_row["name"] . ", ";
                                    }
                                    $stmt4->close();
                                }
                            
                                // Remove the trailing comma
                                $post_names = rtrim($post_names, ", ");
                            
                                if (!empty($post_names)) {
                                    echo "<td>" . $post_names . "</td>";
                                } else {
                                    echo "<td>No Post Name Found</td>";
                                }
                            
                                // Fetch the city preference
                                // $city_prefer = $row["city_prefer"];
                            
                                // Display the city preference
                                echo "<td>" . $city_prefer . "</td>";
                            
                                // Fetch the status for each post applied
                                $stmt3 = $conn->prepare("SELECT d_status FROM details WHERE d_said = ?");
                                $stmt3->bind_param("i", $said);
                                $stmt3->execute();
                                $result3 = $stmt3->get_result();
                            
                                // Initialize an empty string to store status
                                $status = "";
                            
                                // Loop through each status and append to the string
                                while ($row_status = $result3->fetch_assoc()) {
                                    $status .= $row_status["d_status"] . ", ";
                                }
                            
                                // Remove the trailing comma
                                $status = rtrim($status, ", ");
                                
                                    if (!empty($status)) {
                                        echo "<td>" . $status . "</td>";
                                    } else {
                                        echo "<td>No status found</td>";
                                    }
                                
                                
                            
                                // Close the statement
                                $stmt3->close();
                            
                                echo "</tr>";
                            }
                            
                    
                            echo "</tbody>";
                            echo "</table>";
                            echo "</div>";
                        } else {
                            echo "<p class='mt-3'>No records found for this CNIC: " . $cnic . "</p>";
                        }
                    } else {
                        echo "<p class='mt-3'>Error retrieving data from post_apply table: " . $stmt2->error . "</p>";
                    }


                    
                    $stmt2->close();
                } else {
                    echo "<p class='mt-3'>No records found for CNIC: " . $cnic . "</p>";
                }
            } else {
                echo "<p class='mt-3'>Error retrieving data from acount_details table: " . $stmt1->error . "</p>";
            }
            $stmt1->close();
            // Close the connection
            $conn->close();
        }
    }
    else {
        echo '<div class="alert alert-danger" role="alert">Sorry, you have no access.</div>';
    
    }
        ?>
    </div>
     </div>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php 

?>