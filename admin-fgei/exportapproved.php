<?php
include('../connection/conn.php');

if(isset($_POST['exceldata'])){

$checkHead=0;
    $sql="SELECT * FROM `per_info`,`emp_document`,`post_apply`,`details` WHERE emp_document.said=per_info.said AND post_apply.said=emp_document.said AND details.d_status ='Approved'AND post_apply.said=details.d_said ";
  $result=mysqli_query($conn,$sql);
  $checkId=0;
     $output = '';
    
    $output .='<h4>List of all Approved candidates</h4><br>';
  $output .='
      <table class="table" border="0.4">
        <tr>
        <th scope="col">Sr#</th>
        <th scope="col">Candidate Name</th>
        <th scope="col">Father Name</th>
        <th scope="col">CNIC</th>
        <th scope="col">Post Apply</th>
        <th scope="col">Roll Number</th>
        <th scope="col">Acted By</th>
        </tr>
        ';
    while ($row=mysqli_fetch_assoc($result))
    {
        $checkId=$checkId+1;
        $qury = "SELECT `name` FROM `posts` WHERE pid= '".$row['d_postid']."'";
        $sss = mysqli_query($conn, $qury);
        $ery = mysqli_fetch_array($sss);
        $cat = $ery['name'];
        
       
        
        $output .=' 
                <tr>
                <td>'.$checkId.'</td>
                <td>'.$row['basic_full_name'].'</td>
                <td>'.$row['basic_father_name'].'</td>
                <td>'.$row['contact_cnic'].'</td>
                <td>'.$ery['name'].'</td>
                <td>'.$row['d_rollno'].'</td>
                <td>'.$row['act_by'].'</td>
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
