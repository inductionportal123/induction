<?php
include('../connection/conn.php');

$output = "";
$pid = $_POST['val']; // Post ID

// Base query
$query = "SELECT post_apply.post_apply, per_info.said, post_apply.city_prefer, 
                 per_info.basic_full_name, per_info.basic_father_name, 
                 per_info.contact_cnic, per_info.undertaking, per_info.undertaking_date,
                 emp_document.image, emp_document.cnic, emp_document.recipt
          FROM post_apply
          INNER JOIN details ON post_apply.said = details.d_said
          INNER JOIN per_info ON post_apply.said = per_info.said
          INNER JOIN emp_document ON per_info.said = emp_document.said
          WHERE FIND_IN_SET('$pid', post_apply.post_apply) 
          AND details.d_postid = '$pid' 
          AND details.d_status = 'Pending' 
          AND per_info.undertaking = 1 
          ";



// CNIC filter if CNIC is provided
if (!empty($_POST['cnic'])) {
    $cnic = $_POST['cnic'];
    $query .= " AND per_info.contact_cnic = '$cnic' ";
}

// Add ordering by undertaking_date
$query .= " ORDER BY per_info.undertaking_date DESC LIMIT 100";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
    $output .= '<table class="table table-striped table-bordered table-responsive" id="test">
                    <thead style="background-color: #4caf5047;">
                        <tr>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>CNIC</th>
                            <th>Personal Info</th>
                            <th>Documents</th>
                            <th>Approval</th>
                        </tr>
                    </thead>';

    while ($rows = mysqli_fetch_assoc($result)) {
        $output .= '<tbody>
                        <tr id="' . $rows["said"] . '">
                            <td>' . $rows["basic_full_name"] . '</td>
                            <td>' . $rows["basic_father_name"] . '</td>
                            <td>' . $rows["contact_cnic"] . '</td>
                            <td align="center">
                                <button type="button" name="see" class="btn-sm view_data" style="border-radius: 15px; color: black; background-color: #337ab7c9; width: 83px; height: 45px; border: none;" id="' . $rows["said"] . '">See Details</button>
                            </td>
                            <td>';

        // Document links
        $output .= '<a data-fancybox="gallery" title="Candidate Image" href="../' . $rows["image"] . '">
                        <i class="fa fa-image" style="font-size:22px;"></i>
                    </a>';
        
        if ($rows["cnic"] != "NULL") {
            $output .= '<a data-fancybox="gallery" class="primary-btn" title="Candidate CNIC" href="../' . $rows["cnic"] . '">
                            <i class="fa fa-image" style="font-size:22px;"></i>
                        </a>';
        }

        if ($rows["recipt"] != "NULL") {
            $output .= '<a data-fancybox="gallery" class="primary-btn" title="Challan Form" href="../' . $rows["recipt"] . '">
                            <i class="fa fa-image" style="font-size:22px;"></i>
                        </a>';
        }

     

        $output .= '</td>';
        $output .= '<td width="130px">
                        <button type="button" id="' . $rows['said'] . '" class="tik" style="border:none; background: none;"><i class="fa fa-check" style="font-size:22px; color: green;"></i></button>
                        <button type="button" class="cros" id="' . $rows['said'] . '" style="border:none; background: none;"><i class="fa fa-close view_form" style="font-size:22px; color: red;"></i></button>
                        <button type="button" class="held" id="' . $rows['said'] . '" style="border:none; background: none;"><i class="fa fa-question-circle view_form" style="font-size:22px; color: red;"></i></button>
                    </td>
                </tr>
            </tbody>';

        // Hidden field for city preference
        $output .= '<p hidden id="' . $rows["city_prefer"] . '" class="city"></p>';
    }

    $output .= '</table>';
}

echo $output;
?>
