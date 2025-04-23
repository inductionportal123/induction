<?php
ob_start();
include('../connection/conn.php');

if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];
    $query = "SELECT * FROM `per_info` WHERE said = '" . $userid . "'";
    $exes = mysqli_query($conn, $query);
    $rows = mysqli_fetch_array($exes);
    $rowcounts = mysqli_num_rows($exes);
    if ($rowcounts == 1) {
        $basics_district = $rows['contact_district'];
        $hbasics_district = $rows['female_husband_district'];
    }

}



if (!empty($_POST["id"])) {
    $id = $_POST['id'];

    $query = "select * from specialization where qualificstion_id=$id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
} 


if (!empty($_POST["ms_title_id"])) {
    $id = $_POST['ms_title_id'];

    $query = "select * from specialization where qualificstion_id=$id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
} 




if (!empty($_POST["Intermediate"])) {
    $id = $_POST['Intermediate'];

    $query = "select * from specialization where qualificstion_id=$id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
}



if (!empty($_POST["matric"])) {
    $id = $_POST['matric'];

    $query = "select * from specialization where qualificstion_id=$id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
}




if (!empty($_POST["Middle"])) {
    $id = $_POST['Middle'];

    $query = "select * from specialization where qualificstion_id=$id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
}



// Primary


if (!empty($_POST["Primary"])) {
    $id = $_POST['Primary'];

    $query = "select * from specialization where qualificstion_id=$id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
}


// BS


if (!empty($_POST["bs"])) {
    $id = $_POST['bs'];

    $query = "select * from specialization where qualificstion_id=$id";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        echo '<option value="">Select Specialization</option>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
        }
    }
}



// Distrivt

if (!empty($_POST["basic_domicile"])) {
    $basic_domicile = $_POST['basic_domicile'];
  
    // Sanitize the input to prevent SQL injection
    $basic_domicile = mysqli_real_escape_string($conn, $basic_domicile);
  
    $query = "SELECT * FROM district WHERE province = '$basic_domicile'";
    $result = mysqli_query($conn, $query);
    
    if ($result) { // Check if the query executed successfully
        echo '<option value="">Select Region</option>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            // Placeholder value for $rowss['id']
           
            
            // Check if the current district is selected
            
            $selected = ($row['name'] == $basics_district) ? 'selected' : '';
            echo '<option value="' . $row['name'] . '" ' . $selected . '>' . $row['name'] . '</option>';
        }
    } else {
        echo "Error: " . mysqli_error($conn); // Print any errors encountered during query execution
    }
} 





if (!empty($_POST["sbasic_domicile"])) {
    $basic_husband_district = $_POST['sbasic_domicile'];
  
    // Sanitize the input to prevent SQL injection
    $basic_husband_district = mysqli_real_escape_string($conn, $basic_husband_district);
  
    $query1 = "SELECT * FROM district WHERE province = '$basic_husband_district'";
    $result1 = mysqli_query($conn, $query1);
    
    if ($result1) { // Check if the query executed successfully
        echo '<option value="">Select Region</option>';
        
        while ($row = mysqli_fetch_assoc($result1)) {
            // Output each district as an option

            $selected = ($row['name'] == $hbasics_district) ? 'selected' : '';
            echo '<option value="' . $row['name'] . '" ' . $selected . '>' . $row['name'] . '</option>';


        }
    } else {
        echo "Error: " . mysqli_error($conn); // Print any errors encountered during query execution
    }
}





