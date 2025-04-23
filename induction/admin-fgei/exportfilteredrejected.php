<?php
include('../connection/conn.php');

if(isset($_POST['exceldata'])){
$pid = $_POST['postid'];
$checkHead=0;
    $sql="SELECT details.d_feedback, post_apply.city_prefer,post_apply.said,post_apply.post_apply,details.d_said,details.revert,details.d_postid,per_info.*,qualification.*,emp_document.image,emp_document.recipt,emp_document.cnic,emp_document.domicile,emp_document.said,emp_document.last_degree,emp_document.professional_degree,emp_document.driving_license , details.d_status , details.act_by FROM `post_apply` 

INNER JOIN details on post_apply.said = details.d_said 

INNER JOIN per_info on post_apply.said = per_info.said

INNER JOIN qualification on qualification.said = post_apply.said

INNER JOIN emp_document on post_apply.said = emp_document.said

WHERE FIND_IN_SET('$pid',post_apply.post_apply) AND details.d_postid='$pid' AND details.d_status = 'Rejected' AND per_info.undertaking = 1";
  $result=mysqli_query($conn,$sql);
  $checkId=0;
     $output = '';
    
    $output .='<h4>List of all rejected candidates</h4><br>';
  $output .='
      <table class="table" border="0.4">
        <tr>
        <th scope="col">Sr#</th>
        <th scope="col">Candidate Name</th>
        <th scope="col">Father Name</th>
        <th scope="col">CNIC</th>
        <th scope="col">Post Apply</th>
        <th scope="col">Acted By</th>
        <th scope="col">Feedback</th>
        <th scope="col">Status</th>
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
                <td>'.$row['act_by'].'</td>
                <td>'.$row['d_feedback'].'</td>
                 ';
                 if($row['revert']=1)
                 {
                     $output .='
                <td>Reverted</td>
                </tr>
                <br>
                 ';
                 }
                 else
                 {
                      $output .='
                <td>Rejected</td>
                </tr>
                <br>
                 ';
        
                 }
                
  
    }
    $output .= '</table>';
}
  header("Content-Type: application/xls , charset=utf-8");
  header("Content-Disposition: attachment; filename=".$cat.".xls");
  echo $output;

?>
