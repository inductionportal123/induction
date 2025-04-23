<?php
include('../connection/conn.php');

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['usernames']))
{
  $user = $_SESSION['usernames'];
  $readstatus = $_SESSION['readonly'];
  $arr = explode(' ',trim($user));
  $newuser  = ucfirst("$arr[0]");


?>
<!DOCTYPE html>
<html>
<head>
	<title>Approved Applications</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src='https://kit.fontawesome.com/a076d05399.js'></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css" rel="stylesheet" />

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<link href="css/pagination.css" rel="stylesheet" type="text/css" />
<link href="css/A_green.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css">
<link rel="stylesheet" type="text/css" href="admincss/all.css">

</head>
<body style="background-color: #F5FFFA">


<div class="container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12">


<?php
    if(isset($_POST['submit_no']))
    {
      
$rolno_sch = $_POST['search_roll'];
?>


<div class="container-fluid">
<div class="row">
<div class="col-md-12 col-sm-12">

            <table class="table table-striped table-bordered">
              <thead style="background-color: #4caf5047;">
                <tr>
                  <th>ID</th>
                  <th>Candidate Name</th>
                  <th>Father Name</th>
                  <th>Exam Center</th>
                  <th>Student Group</th>
                  <th>Mobile No</th>
                  <th>Candidate DOB</th>
                  <th>Personal Info</th>
                  <th>Documents</th>
                  <th>Approval</th>
                  <th>Roll No</th>
                </tr>
              </thead>
<?php
include('conn.php');


 $query = "SELECT class_viii.rollno_search, class_viii.approval , class_viii.id, class_viii.cadidate_name, class_viii.approval, class_viii.father_name, class_viii.exam_center, class_viii.choice_group, class_viii.mobile_no, class_viii.candidate_dob, class_viii.said , class_viii.slip, viiidocument.image , viiidocument.cnic_father , viiidocument.nadra_formb , viiidocument.recipt_challan , viiidocument.charactercertificate FROM class_viii 
INNER JOIN viiidocument 
ON viiidocument.said=class_viii.said where rollno_search = '$rolno_sch'";



    $exe=mysqli_query($conn,$query);
      if (! $exe) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
$num = mysqli_num_rows($exe);
                if($num == 0){
                  echo "No Record Found!";
                  exit();
                }
 while ($rows = mysqli_fetch_array($exe))
{

?>
              <tbody>
                <td><?=$rows['id']?></td>
                <td><?=$rows['cadidate_name']?></td>
                <td><?=$rows['father_name']?></td>
                <td><?=$rows['exam_center']?></td>
                <td><?=$rows['choice_group']?></td>
                <td><?=$rows['mobile_no']?></td>
                <td><?=$rows['candidate_dob']?></td>
                <td align="center"><button type="button"  id="<?=$rows['said']?>" class="btn-sm view_data" style="border-radius: 15px; color: white; background-color: #337ab7c9; width: 83px; height: 27px; border: none;">See Details</button></td>

            <td align="center">

 <a data-fancybox="gallery" class="primary-btn" title="Candidate Image" href="../<?=$rows['image']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
 <a data-fancybox="gallery" class="primary-btn" title="Candidate Father CNIC" href="../<?=$rows['cnic_father']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
<a data-fancybox="gallery" class="primary-btn" title="Candidate Nadra Form-B" href="../<?=$rows['nadra_formb']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
 <a data-fancybox="gallery" class="primary-btn" title="Recipt Challan" href="../<?=$rows['recipt_challan']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
 <a data-fancybox="gallery" class="primary-btn" title="character Certificate" href="../<?=$rows['charactercertificate']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
                </td>
                <td align="center">
                  <?php
                    if($rows['approval']=='Approved' || $rows['approval']=='Rejected'){
                      echo $rows['approval'];
                    }
                    else{
                  ?>
                      <button type="button" onclick="if (confirm('Are you sure you want to approve?')) { location.href='allapproval.php?approve=true&stu_id=<?=$rows['said']?>&pagno=<?=$page?>'}" style="border:none; background: none;" id="tik"><i class="fa fa-check" style="font-size:22px; color: green;"></i></button>

                <button type="button" onclick="if (confirm('Are you sure you want to reject?')) {
      location.href='allapproval.php?reject=true&stu_id=<?=$rows['said']?>&pagno=<?=$page?>'} " style="border:none; background: none;" id="cros"><i class="fa fa-close" style="font-size:22px; color: red;"></i></button>

                <?php
                    }
                  ?>
                      
                
                </td>
                <td>
                  <?php
                  if($rows['slip']=='Generated'){

                         echo $rows['rollno_search'];
                    }
                   
                    else{
                  ?>
                  <button type="button" onclick="if (confirm('Are you sure you want to generate roll no slip?')) {
      location.href='generateslipupdate.php?approve=true&stu_id=<?=$rows['said']?>&pagno=<?=$page?>&citycenter=<?=$var?>&optradio=<?=$rad?>'} " class="btn-sm" style="border-radius: 15px; color: white; background-color: red;  height: 27px; border: none;">Generate Slip</button>
      <?php
    }
    ?>
                </td>
              </tbody>

<?php

}

?>

</table>

</div>
</div>
</div>
<script>
   $(document).ready(function(){
    $('.view_data').click(function(){
      $('#dataModal').modal("show");
      var employee_id = $(this).attr("id");

      $.ajax({
        url:"eightstudentmodal.php",
        method:"post",
        data:{employee_id:employee_id},
        success:function(data){
          $('#employee_detail').html(data);
          $('#dataModal').modal("show");
        }
      });
    });
  });
</script>


 <div id="dataModal" class="modal fade" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

                  <button type="button" class="close"  data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Student Details</h4>
          
        </div>
        <div class="modal-body" id="employee_detail">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>






<?php

}
else{
?>

<form accept="" method="GET">
    <div style="padding-left: 380px !important;padding-top: 30px !important; padding-bottom: 20px !important;">
        <table>
<tr>  
      <td align="right"><label> Category: </label></td>
      <td><select  name="citycenter" id="inputbox" required/>
      
                     <?php
                    $querys = "SELECT * FROM `categories` ORDER BY id ASC;";
                    $datas = mysqli_query($conn,$querys);
                        if (! $datas) {
                        printf("Error: %s\n", mysqli_error($conn));
                        exit();
                    }
                    $rowcounts = mysqli_num_rows($datas);


                    if($rowcounts>0){

                    while ($rowss = mysqli_fetch_array($datas)){
                    ?>

<option value="<?=$rowss['name_value']?>"> <?= strtoupper($rowss['name']) ?> </option> 

                    <?php
                    }
                    }
                    ?>
                                     </select>
                                  </td>
                                  
            </tr>
<tr>

        <td align="left" colspan="2">
           <label class="radio-inline">
              <input type="checkbox" name="optradio" value="O-level" checked> All
            </label>
          <label class="radio-inline">
              <input type="checkbox" name="optradio" value="cch" > Scheduled Castes
            </label>
            <label class="radio-inline">
              <input type="checkbox" name="optradio" value="8th(with Biology)" > Retired Officer
            </label>
            <label class="radio-inline">
              <input type="checkbox" name="optradio" value="O-level" > Disabled
            </label>
            <label class="radio-inline">
              <input type="checkbox" name="optradio" value="O-level" > Widow
            </label>
            
  </td>

</tr>

<tr>
 <!--  <td></td> -->
  <td align="center" colspan="3"><input type="submit" name="submit" value="Load" class="btn btn-md btn-success" style="margin-top: 25px !important; width: 100px; margin-left: -90px;" ></td>
 <!--  <td></td> -->
</tr>
         </table>
    </div>
</form>











<?php
          if(isset($_GET['citycenter']) && isset($_GET['optradio'])){

$var = $_GET['citycenter'];
$rad =  $_GET['optradio'];
?>









<div class="container-fluid">
<div class="row">
<div class="col-md-12 col-sm-12">

            <table class="table table-striped table-bordered">
              <thead style="background-color: #4caf5047;">
                <tr>
                  <th>ID</th>
                  <th>Candidate Name</th>
                  <th>Father Name</th>
                  <th>Exam Center</th>
                  <th>Student Group</th>
                  <th>Mobile No</th>
                  <th>Candidate DOB</th>
                  <th>Personal Info</th>
                  <th>Documents</th>
                  <th>Approval</th>
                  <th>Roll No</th>
                </tr>
              </thead>
<?php
include('conn.php');

include("approvefunction.php");






 $page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
      $limit = 10; //if you want to dispaly 10 records per page then you have to change here
      $startpoint = ($page * $limit) - $limit;
if($rad == "cch"){      
        $statement = "class_viii WHERE approval = 'Approved' and exam_center = '$var' order by id DESC "; //you have to pass your query over here
}
else{
        $statement = "class_viii WHERE approval = 'Approved' and choice_group = '$rad' and exam_center = '$var' order by id DESC "; //you have to pass your query over here

}

if($rad == "cch"){
 $query = "SELECT class_viii.rollno_search, class_viii.approval , class_viii.id, class_viii.cadidate_name, class_viii.approval, class_viii.father_name, class_viii.exam_center, class_viii.choice_group, class_viii.mobile_no, class_viii.candidate_dob, class_viii.said , class_viii.slip, viiidocument.image , viiidocument.cnic_father , viiidocument.nadra_formb , viiidocument.recipt_challan , viiidocument.charactercertificate FROM class_viii 
INNER JOIN viiidocument 
ON viiidocument.said=class_viii.said where approval = 'Approved' and exam_center = '$var' ORDER BY class_viii.id DESC LIMIT {$startpoint} , {$limit}";
}
else{
  $query = "SELECT class_viii.rollno_search, class_viii.approval , class_viii.id, class_viii.cadidate_name, class_viii.approval, class_viii.father_name, class_viii.exam_center, class_viii.choice_group, class_viii.mobile_no, class_viii.candidate_dob, class_viii.said , class_viii.slip, viiidocument.image , viiidocument.cnic_father , viiidocument.nadra_formb , viiidocument.recipt_challan , viiidocument.charactercertificate FROM class_viii 
INNER JOIN viiidocument 
ON viiidocument.said=class_viii.said where approval = 'Approved' and choice_group = '$rad' and exam_center = '$var' ORDER BY class_viii.id DESC LIMIT {$startpoint} , {$limit}";
}


    $exe=mysqli_query($conn,$query);
      if (! $exe) {
    printf("Error: %s\n", mysqli_error($conn));
    exit();
}
$num = mysqli_num_rows($exe);
                if($num == 0){
                  echo "No Record Found!";
                  exit();
                }
 while ($rows = mysqli_fetch_array($exe))
{

?>
              <tbody>
                <td><?=$rows['id']?></td>
                <td><?=$rows['cadidate_name']?></td>
                <td><?=$rows['father_name']?></td>
                <td><?=$rows['exam_center']?></td>
                <td><?=$rows['choice_group']?></td>
                <td><?=$rows['mobile_no']?></td>
                <td><?=$rows['candidate_dob']?></td>
                <td align="center"><button type="button"  id="<?=$rows['said']?>" class="btn-sm view_data" style="border-radius: 15px; color: white; background-color: #337ab7c9; width: 83px; height: 27px; border: none;">See Details</button></td>

            <td align="center">

 <a data-fancybox="gallery" class="primary-btn" title="Candidate Image" href="../<?=$rows['image']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
 <a data-fancybox="gallery" class="primary-btn" title="Candidate Father CNIC" href="../<?=$rows['cnic_father']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
<a data-fancybox="gallery" class="primary-btn" title="Candidate Nadra Form-B" href="../<?=$rows['nadra_formb']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
 <a data-fancybox="gallery" class="primary-btn" title="Recipt Challan" href="../<?=$rows['recipt_challan']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
 <a data-fancybox="gallery" class="primary-btn" title="character Certificate" href="../<?=$rows['charactercertificate']?>"><i class='fas fa-images' style="font-size:22px;"></i></a>
                </td>
                <td align="center">
                  <?php
                    if($rows['approval']=='Approved' || $rows['approval']=='Rejected'){
                      echo $rows['approval'];
                    }
                    else{
                  ?>
                      <button type="button" onclick="if (confirm('Are you sure you want to approve?')) { location.href='allapproval.php?approve=true&stu_id=<?=$rows['said']?>&pagno=<?=$page?>'}" style="border:none; background: none;" id="tik"><i class="fa fa-check" style="font-size:22px; color: green;"></i></button>

                <button type="button" onclick="if (confirm('Are you sure you want to reject?')) {
      location.href='allapproval.php?reject=true&stu_id=<?=$rows['said']?>&pagno=<?=$page?>'} " style="border:none; background: none;" id="cros"><i class="fa fa-close" style="font-size:22px; color: red;"></i></button>

                <?php
                    }
                  ?>
                      
                
                </td>
                <td>
                  <?php
                  if($rows['slip']=='Generated'){

                         echo $rows['rollno_search'];
                    }
                    
                    else{
                  ?>
                  <button type="button" onclick="if (confirm('Are you sure you want to generate roll no slip?')) {
      location.href='generateslipupdate.php?approve=true&stu_id=<?=$rows['said']?>&pagno=<?=$page?>&citycenter=<?=$var?>&optradio=<?=$rad?>'} " class="btn-sm" style="border-radius: 15px; color: white; background-color: red;  height: 27px; border: none;">Generate Slip</button>
      <?php
    }
    ?>
                </td>
              </tbody>

<?php

}

?>

</table>

<div class="col text-center">
<?php
echo "<div id='pagingg' >";
echo pagination($statement,$limit,$page);
echo "</div>";
?>
</div>
<br>
<br>
<form action="approvedexcel.php" method="POST" target="_blank">
<button type="submit" onclick="return confirm('Are you sure you want to export data?');"  name="exceldata" class="btn btn-sm btn-success"  style="float: right; margin-top: -38px;">Export to excel</button>
 </form>
 

<?php

}

?>

<script>
   $(document).ready(function(){
    $('.view_data').click(function(){
      $('#dataModal').modal("show");
      var employee_id = $(this).attr("id");

      $.ajax({
        url:"eightstudentmodal.php",
        method:"post",
        data:{employee_id:employee_id},
        success:function(data){
          $('#employee_detail').html(data);
          $('#dataModal').modal("show");
        }
      });
    });
  });
</script>


 <div id="dataModal" class="modal fade" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

                  <button type="button" class="close"  data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Student Details</h4>
          
        </div>
        <div class="modal-body" id="employee_detail">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <br>

<script>
    $("[data-fancybox]").fancybox({
   toolbar         : false,
  arrows          : true
});
 $(document).ready(function(){
  $(".view_data").click(function(){
    var id = this.id;
      $('#' + id).css("background" , "#4caf5047");
  });
});

</script>

</div>
</div>
</div>

<?php


}


?>

</body>
</html>		

   
<?php
}
else{
  header("Location: index.php");
}

?>