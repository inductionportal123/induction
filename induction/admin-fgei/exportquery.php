<?php
include('../connection/conn.php');

if(isset($_POST['Submit'])){

    $sql="SELECT * FROM `query`";
  $result=mysqli_query($conn,$sql);
  $checkId=0;
     $output = '';
    
    $output .='<h4>Queries</h4><br>';
  $output .='
      <table class="table" border="0.4">
        <tr>
        <th scope="col">Email</th>
        <th scope="col">Query</th>
        <th scope="col">Reply</th>
        <th scope="col">Query Time</th>
        <th scope="col">Reply Time</th>
        </tr>
        ';
    while ($row=mysqli_fetch_assoc($result))
    {
        $id = $row['said'];
        $sql="SELECT email FROM `acount_details` WHERE id='$id'";
        $exe=mysqli_query($conn, $sql);
        $data=mysqli_fetch_array($exe);
        
        $output .=' 
                <tr>
                <td>'.$data['email'].'</td>
                <td>'.$row['query'].'</td>
                <td>'.$row['ans'].'</td>
                <td>'.$row['q_time'].'</td>
                <td>'.$row['f_time'].'</td>
                </tr>
                <br>
                 ';
  
    }
    $output .= '</table>';
}
  header("Content-Type: application/xls , charset=utf-8");
  header("Content-Disposition: attachment; filename=download.xls");
  echo $output;

?>
