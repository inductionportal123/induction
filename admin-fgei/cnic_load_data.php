<?php
include('../connection/conn.php');
$output = "";
$value  = $_POST['val'];
$query="SELECT * from acount_details where acount_details.cnic = '$value'";

$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) 
{

	$output .= '<table class="table table-striped table-bordered table-responsive" id="test">
            <thead style="background-color: #4caf5047;">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>CNIC</th>
                  <th>Email</th>
                  <th>Password</th>                  
                </tr>
              </thead>';

while( $rows = mysqli_fetch_assoc($result))
{

			$output.='<tbody>
                <tr>
                <td>'.$rows["id"].'</td>
                <td>'.$rows["name"].'</td>
                <td>'.$rows["cnic"].'</td>
                <td>'.$rows["email"].'</td>
                <td>'.$rows["password"].'</td>
                </tr>';

 

}
$output .= '</tbody></table>';
}

echo $output;
?>