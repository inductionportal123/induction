<?php
include('../connection/conn.php');

if(isset($_POST['exceldata'])){
$postid = $_POST['postid'];
$sqll = "SELECT `name` , `gender` FROM `posts` WHERE `pid` = '$postid'";
$exee = mysqli_query($conn,$sqll);
$dataa = mysqli_fetch_array($exee);
$postname = $dataa['name'];  
$genderr = $dataa['gender'];
$checkHead=0;
    $sql="SELECT * FROM `post_apply`
                INNER JOIN details on post_apply.said = details.d_said 
                INNER JOIN per_info on post_apply.said = per_info.said
                LEFT JOIN results on results.roll_no=details.d_rollno
                INNER JOIN qualification on post_apply.said = qualification.said
                WHERE FIND_IN_SET('$postid',post_apply.post_apply) AND details.d_postid='$postid' AND per_info.undertaking = 1 AND details.d_status='Approved'";
  $result=mysqli_query($conn,$sql);
  $checkId=0;
     $output = '';
    
    $output .='<h4>Approved candidates</h4><br>';
  $output .='
      <table class="table" border="0.4">
        <tr>
        <th scope="col">Sr#</th>
        <th scope="col">Candidate Name</th>
        <th scope="col">Father Name</th>
        <th scope="col">CNIC</th>
        <th scope="col">Gender</th>
        <th scope="col">Married</th>
        <th scope="col">Religion</th>
        <th scope="col">Roll Number</th>
        <th scope="col">Contact</th>
        <th scope="col">Contact II</th>
        <th scope="col">Postal Address</th>
        <th scope="col">Permanent Address</th>
        <th scope="col">Email</th>
        <th scope="col">Date of Birth</th>
        <th scope="col">Domicile</th>
        
        <th scope="col">District</th>
        <th scope="col">Academic Qualification</th>
        <th scope="col">Professional Qualification</th>
        <th scope="col">Scedule Caste</th>
        <th scope="col">Army Retired</th>
        <th scope="col">Disabled</th>      
        <th scope="col">Widow</th>
        <th scope="col">Government Employee</th>
        <th scope="col">Test City</th>
        <th scope="col">Written Test Marks </th>
            
        </tr>
        ';
    while ($row=mysqli_fetch_assoc($result))
    {
     
                    if($row["basic_domicile"] == 1)
                    {
                        $dom = "Punjab";
                    }
                    elseif($row["basic_domicile"] == 2)
                    {
                        $dom = "KPK";
                    }
                    elseif($row["basic_domicile"] == 3)
                    {
                        $dom = "Balochistan";
                    }
                    elseif($row["basic_domicile"] == 4)
                    {
                        $dom = "Sindh(Urban)";
                    }
                    elseif($row["basic_domicile"] == 5)
                    {
                        $dom = "Sindh(Rural)";
                    }       
                    elseif($row["basic_domicile"] == 6)
                    {
                        $dom = "AJK";
                    }
                    elseif($row["basic_domicile"] == 7)
                    {
                        $dom = "FATA";
                    }
                    elseif($row["basic_domicile"] == 8)
                    {
                        $dom = "GB";
                    }

                    //-------------------------------------------




                    $highest_qualification = "";
                                if (!empty($row['ms_title']) && $row['ms_title'] !== NULL && $row['ms_title'] !== " " && $row['ms_title'] !== "NULL" ) {
                                    $highest_qualification = $row['ms_title'];
                                } elseif (!empty($row['bs16_title']) && $row['bs16_title'] !== NULL  && $row['bs16_title'] !== " " && $row['bs16_title'] !== "NULL"  ) {
                                    $highest_qualification = $row['bs16_title'];
                                } elseif (!empty($row['bs_title']) && $row['bs_title'] !== NULL  && $row['bs_title'] !== " " && $row['bs_title'] !== "NULL"  ) {
                                    $highest_qualification = $row['bs_title'];
                                } elseif (!empty($row['inter_title']) && $row ['inter_title'] !== NULL  && $row['inter_title'] !== " " && $row['inter_title'] !== "NULL"  ) {
                                    $highest_qualification = $row['inter_title'];
                                } elseif (!empty($row['matric_title']) && $row['matric_title'] !== NULL  && $row['matric_title'] !== " " && $row['matric_title'] !== "NULL"  ) {
                                    $highest_qualification = $row['matric_title'];
                                } elseif (!empty($row['middle_title']) && $row['middle_title'] !== NULL  && $row['middle_title'] !== " " && $row['middle_title'] !== "NULL"  ) {
                                    $highest_qualification = $row['middle_title'];
                                } elseif (!empty($row['primary_title']) && $row['primary_title'] !== NULL  && $row['primary_title'] !== " " && $row['primary_title'] !== "NULL"  ) {
                                    $highest_qualification = $row['primary_title'];
                                }
                                
                                
                                 $qualification = "SELECT qualification_category FROM qualification_category WHERE id = '$highest_qualification'";
                                    $qualification_query = mysqli_query($conn, $qualification);
                                    
                                    if ($qualification_query && mysqli_num_rows($qualification_query) > 0) {
                                        $qName = mysqli_fetch_assoc($qualification_query)['qualification_category'];
                                    } else {
                                        $qName = 'No Qualification Found';
                                    }





        
                    if($row['relax_schedule_caste'] == 1)
                    {
                        $rsc = "Yes";
                    }
                    else
                    {
                        $rsc = "No";
                    }
        
                    if($row['relax_retired'] == 1)
                    {
                        $rr = "Yes";
                    }
                    else
                    {
                        $rr = "No";
                    }
        
                    if($row['relax_disable'] == 1)
                    {
                        $rd = "Yes";
                    }
                    else
                    {
                        $rd = "No";
                    }
                    
                    if($row['relax_widow'] == 1)
                    {
                        $rw = "Yes";
                    }
                    else
                    {
                        $rw = "No";
                    }
        
                    if($row['gov'] == 1)
                    {
                        $rg = "Yes";
                    }
                    else
                    {
                        $rg = "No";
                    }
        
                    $city = "SELECT DISTINCT(centes.district) AS cityapplied FROM district JOIN centes ON district.name = centes.district WHERE district.id = '$row[city_prefer]'";
                    $cityexe = mysqli_query($conn,$city);
                    $citydata = mysqli_fetch_array($cityexe);
        
        
                    //-------------------------------------------
        
        $checkId=$checkId+1;
        $output .=' 
                <tr>
                    <td>'.$checkId.'</td>
                    <td>'.$row['basic_full_name'].'</td>
                    <td>'.$row['basic_father_name'].'</td>
                    <td>'.$row['contact_cnic'].'</td>
                    <td>'.$row['basic_gender'].'</td>
                    <td>'.$row['basic_marital_status'].'</td>
                    <td>'.$row['contact_religion'].'</td>
                    <td>'.$row['d_rollno'].'</td>
                    <td>'.$row['contact_phone_no'].'</td>
                    <td>'.$row['contact_mobile'].'</td>
                    <td>'.$row['contact_postal_address'].'</td>
                     <td>'.$row['contact_per_address'].'</td>
                    <td>'.$row['contact_email'].'</td>
                    <td>'.$row['basic_dob'].'</td>
                    <td>'.$dom.'</td>                 
                    <td>'.$row['contact_district'].'</td>
                    <td>'.$qName.'</td>
                    <td>'.$row['profes_certificate'].' , '.$row['profes_certificate_two'].' , '.$row['profes_certificate_three'].'</td>
                    <td>'.$rsc.'</td>
                    <td>'.$rr.'</td>
                    <td>'.$rd.'</td>                                       
                    <td>'.$rw.'</td>
                    <td>'.$rg.'</td>
                    <td>'.$citydata['cityapplied'].'</td>
                    <td>'.$row['marks'].'</td>
                    
                    
                </tr>
                <br>
                 ';
  
    }
    $output .= '</table>';
}
  header("Content-Type: application/xls , charset=utf-8");
  header("Content-Disposition: attachment; filename=".$postname."-".$genderr.".xls");
  echo $output;

?>
