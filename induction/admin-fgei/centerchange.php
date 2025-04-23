<?php
include('../connection/conn.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
    if(isset($_SESSION['user_name'],$_SESSION['user_access']))
    {
        	$user = $_SESSION['user_name'];
  $userid = $_SESSION['user_access'];

	$arr = explode(' ',trim($user));
	$newuser  = ucfirst("$arr[0]");
	
        
	if ($user=='super-admin' )
   		{
        

$usercnic = "";
$rows = [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cnic'])) {
    $usercnic = $_POST['cnic'];

    $query = "
        SELECT per_info.said, post_apply.city_prefer, post_apply.city_prefer_two 
        FROM per_info 
        JOIN post_apply ON per_info.said = post_apply.said 
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
            echo "<div class='alert alert-success col-sm-5' role='alert'>Records updated successfully.</div>";


            // Fetch updated data
            $updatedQuery = "
                SELECT per_info.said, post_apply.city_prefer, post_apply.city_prefer_two 
                FROM per_info 
                JOIN post_apply ON per_info.said = post_apply.said 
                WHERE per_info.contact_cnic = ?
            ";

            if ($stmt = mysqli_prepare($conn, $updatedQuery)) {
                mysqli_stmt_bind_param($stmt, "s", $usercnic);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                mysqli_stmt_close($stmt);
            } else {
                echo "Error preparing the query: " . mysqli_error($conn);
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updating record: " . mysqli_stmt_error($stmt) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error preparing the query: " . mysqli_error($conn) . "</div>";
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
<link href="css/font-awesome.min.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
<script src="js/bootstrap.min.js"></script> 
        
</head>
<body>
    <?php include('header.php');  
    include('appnav.php'); 
    ?>


<div class="container">
        <div class="container">
        <div class="row">
            <div class="col-md-3">
                
            </div>
            <div class="col-md-9">
                <div class="col-md-12">
                    <form action="" method="post" class="form-inline mb-3">
                        <br><br>
                <label for="cnic" class="mr-2">Enter CNIC:</label>
                <input type="text"  id="cnic" name="cnic" value="<?php echo isset($usercnic) ? htmlspecialchars($usercnic) : ''; ?>" class="form-control col-md" placeholder="Enter CNIC No" required>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
                    
                </div>
                <div class="col-md-12">
                    
                    <?php if (!empty($rows)): ?>
                <?php foreach ($rows as $row): ?>
                    <form action="" method="post">
                        <input type="hidden" name="said" value="<?php echo htmlspecialchars($row['said']); ?>">
                        <input type="hidden" name="cnic" value="<?php echo htmlspecialchars($usercnic); ?>">
                        <div class="form-group row mb-3">
                            <label for="test_city" class="col-md col-form-label">Test City Preferred I:</label>
                            <div class="col-md">
                                <select class="form-control" name="test_city" required>
                                    <option value="">Select City</option>
                                    <?php
                                    $nquery = "SELECT DISTINCT(district.id), centes.district FROM district JOIN centes ON district.name = centes.district";
                                    $nexe = mysqli_query($conn, $nquery);
                                    while ($ro = mysqli_fetch_array($nexe)) {
                                    ?>
                                        <option value="<?php echo $ro['id'] ?>" <?php if (isset($row['city_prefer']) && $row['city_prefer'] == str_replace(" ", "", $ro['id'])) { ?> selected <?php } ?>><?php echo strtoupper($ro['district']) ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="multy_city" class="col-md col-form-label">Test City Preferred II:</label>
                            <div class="col-md">
                                <select class="form-control" name="multy_city" required>
                                    <option value="">Select City</option>
                                    <?php
                                    $newqu = "SELECT DISTINCT(district.id), centes.district FROM district JOIN centes ON district.name = centes.district";
                                    $newe = mysqli_query($conn, $newqu);
                                    while ($rs = mysqli_fetch_array($newe)) {
                                    ?>
                                        <option value="<?php echo $rs['id'] ?>" <?php if (isset($row['city_prefer_two']) && $row['city_prefer_two'] == str_replace(" ", "", $rs['id'])) { ?> selected <?php } ?>><?php echo strtoupper($rs['district']) ?></option>
                                    <?php
                                    }
                                    ?>
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


    
    

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


<?php

}
else{
   echo '<div style="background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem;">You don\'t have any access of this page</div>';

}
    }
    else
    {
        header("Location: index.php");
    }
mysqli_close($conn);
