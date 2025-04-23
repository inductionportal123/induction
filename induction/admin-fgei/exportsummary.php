<?php
include('../connection/conn.php');

if(isset($_POST['exceldata'])){
$pid = $_POST['summarypid'];



 $postsquery = "SELECT * FROM `posts`";
 $postsresult = mysqli_query($conn,$postsquery) ;
$counter=0;


    $output = '';
    
    $output .='<h4>Summary Report</h4><br>';
    if(isset($_POST['summaryregion']))
{
  $placer = $_POST['placeregion'];
    $output .='<h5>Filter by '.$placer.'</h5><br>';

}
   elseif(isset($_POST['summaryprovince']))
{
  $placep = $_POST['placeprovince'];
    $output .='<h5>Filter by '.$placep.'</h5><br>';

}
  elseif(isset($_POST['summarydistrict']))
  {
    $placed = $_POST['placedistrict'];
    $output .='<h5>Filter by '.$placed.'</h5><br>';
  }
  $output .='
      <table class="table" border="0.4">
        <tr>
        <th scope="col">#</th>
        <th scope="col">Posts</th>
        <th scope="col">Total Applications</th>
        <th scope="col">Approved Applications</th>
        <th scope="col">Rejected Applications</th>
        <th scope="col">Pending Applications</th>
        </tr>
        ';
 


 while( $postsmain = mysqli_fetch_assoc($postsresult)) {
$counter=$counter+1;


if(isset($_POST['summaryregion']))
{
  $regionnew = $_POST['summaryregion'];
  
            
                //totalcount
                $pid = $postsmain['pid'];
                $tcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id) AND district.region = '$regionnew' WHERE  FIND_IN_SET('$pid',post_apply)";  
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                echo $tcresult[0];
                //approvedcount
                $acq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `appstatus`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.region = '$regionnew' WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `appstatus`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.region = '$regionnew' WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount
 

                $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                $output .=' 
                <tr>
                <td>'.$counter.'</td>
                <td>'.$postsmain['name'].'</td>
                <td>'.$tcresult[0].'</td>
                <td>'.$acresult[0].'</td>
                <td>'.$rcresult[0].'</td>
                <td>'.$pcq3.'</td>
                </tr>
                <br>
                 ';
 
                 ?>
                
              <?php
}
elseif(isset($_POST['summaryprovince']))
{
  $provincenew = $_POST['summaryprovince'];
  ?><?php
                //totalcount
                $pid = $postsmain['pid'];
                $tcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id) AND district.province = '$provincenew' WHERE  FIND_IN_SET('$pid',post_apply)";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `appstatus`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.province = '$provincenew' WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `appstatus`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.province = '$provincenew' WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount
 

                $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                $output .=' 
                <tr>
                <td>'.$counter.'</td>
                <td>'.$postsmain['name'].'</td>
                <td>'.$tcresult[0].'</td>
                <td>'.$acresult[0].'</td>
                <td>'.$rcresult[0].'</td>
                <td>'.$pcq3.'</td>
                </tr>
                <br>
                 ';
 
                 ?>
                
              <?php
}
elseif(isset($_POST['summarydistrict']))
{
  $districtnew = $_POST['summarydistrict'];
  ?><?php
                //totalcount
                $pid = $postsmain['pid'];
                $tcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id) AND district.name = '$districtnew' WHERE  FIND_IN_SET('$pid',post_apply)";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `appstatus`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.name = '$districtnew' WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(DISTINCT post_apply.post_apply) FROM `appstatus`,`post_apply` JOIN `district` ON (city_prefer= district.id OR city_prefer_two=district.id)  AND district.name = '$districtnew' WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                //pendingcount
 

                $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                $output .=' 
                <tr>
                <td>'.$counter.'</td>
                <td>'.$postsmain['name'].'</td>
                <td>'.$tcresult[0].'</td>
                <td>'.$acresult[0].'</td>
                <td>'.$rcresult[0].'</td>
                <td>'.$pcq3.'</td>
                </tr>
                <br>
                 ';
 
                 ?>
                
              <?php



}
else
{

                    //totalcount
                $pid = $postsmain['pid'];
               $tcq = "SELECT COUNT(*) FROM `post_apply` WHERE FIND_IN_SET('$pid',post_apply)";
                $tcq2 = mysqli_query($conn, $tcq);
                $tcresult = mysqli_fetch_array($tcq2);
                //approvedcount
                $acq = "SELECT COUNT(*) FROM `appstatus`,`post_apply` WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Approved' AND FIND_IN_SET('$pid',post_apply)";
                $acq2 = mysqli_query($conn, $acq);
                $acresult = mysqli_fetch_array($acq2);
                //rejectedcount
                $rcq = "SELECT COUNT(*) FROM `appstatus`,`post_apply` WHERE appstatus.s_candid=post_apply.said AND appstatus.s_catid='$pid' AND appstatus.s_status = 'Rejected' AND FIND_IN_SET('$pid',post_apply)";
                $rcq2 = mysqli_query($conn, $rcq);
              $rcq3 = mysqli_num_rows($rcq2);

                $rcresult = mysqli_fetch_array($rcq2);
                 //pendingcount
 

                $acseries = $postsmain['series'];
                   $pcq = $acresult[0] + $rcresult[0];
                $pcq2 = $tcresult[0];
                $pcq3 = $pcq2 - $pcq;
                $output .=' 
                <tr>
                <td>'.$counter.'</td>
                <td>'.$postsmain['name'].'</td>
                <td>'.$tcresult[0].'</td>
                <td>'.$acresult[0].'</td>
                <td>'.$rcresult[0].'</td>
                <td>'.$pcq3.'</td>
                </tr>
                <br>
                 ';
 
                 ?>
                
              <?php

}

}
    $output .= '</table>';
        
}
  header("Content-Type: application/xls , charset=utf-8");
  header("Content-Disposition: attachment; filename=download.xls");
  echo $output;

?>
