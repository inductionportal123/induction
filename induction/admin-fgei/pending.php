<?php
include('../connection/conn.php');

if (!isset($_SESSION)) {
    session_start();
}

if (isset($_SESSION['user_name'], $_SESSION['user_access'])) {
    $user = $_SESSION['user_name'];
    $userid = $_SESSION['user_access'];

    $arr = explode(' ', trim($user));
    $newuser  = ucfirst("$arr[0]");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Pending Applications</title>
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
<?php 
    include('header.php');  
    include('appnav.php'); 
?>

<div class="col-lg-offset-3 col-md-offset-3 col-md-8 col-lg-8" align="center">
    <h3 style="color: green;">Pending Applications</h3>
    <div class="form-inline">
        <!--<label>List of Posts: &nbsp;&nbsp;</label>-->
        <select name="post" class="form-control" id="postData" required="">
            <option value="" selected>Select Your Group</option>
            <?php
            $query = "SELECT * FROM `posts` ORDER BY gender DESC;";
            $data = mysqli_query($conn,$query);
            $rowcounts = mysqli_num_rows($data);
            $conn->close();

            if($rowcounts > 0) {
                while ($row = mysqli_fetch_array($data)) {
                    ?>
                    <option value="<?=$row['pid']?>">
                        <?php echo $row['name'] . ' (BPS-' . $row['bps'] . ') - ' . ucfirst($row['gender']); ?>
                    </option> 
                    <?php
                }
            }
            ?>
        </select>

        <!-- CNIC Search Input -->
        <input type="text" name="cnic" id="cnic" class="form-control" placeholder="Enter CNIC to filter">

        <button type="button" class="btn btn-primary" id="searchBtn">Search</button>
    </div>

    <h4 id="load" style="align-items: center;color: green;letter-spacing: 1;font-weight: bold"></h4>
    <div id="table_load" style="margin-top:40px;margin-left:50px"></div>
</div>

<!-- Modals -->
<div id="dataModal" class="modal fade">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Applicant Details</h4>
            </div>
            <div class="modal-body" id="employee_detail"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 

<div id="dataModalReject" class="modal fade">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Rejection Details</h4>
            </div>
            <div class="modal-body" id="employee_detail_Reject"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> 

<script type="text/javascript">
    $(document).ready(function(){
        $("#searchBtn").on("click", function(){
            var post_id = $("#postData").val();
           
            var cnic = $("#cnic").val().trim(); // Get CNIC input value

            $.ajax({
                url: "ajax_table_load.php",
                type: "POST",
                data: { val: post_id, cnic: cnic }, // Pass both post_id and cnic
                beforeSend: function() {
                    $("#load").html("Loading New Records....");
                    $("#postData").attr('disabled', 'disabled');
                },
                success: function(data) {
                    $("#load").html("");
                   
                    $("#postData").attr('disabled', false);
                    $("#table_load").html(data);
                }
            });
        });

        // Modal functionality remains unchanged as per your existing code
        $(document).on("click", ".view_data", function(){
            var employee_id = $(this).attr("id");
            $.ajax({
                url: "modalPending.php",
                method: "post",
                data: { employee_id: employee_id },
                success: function(data) {
                    $('#employee_detail').html(data);
                    $('#dataModal').modal("show");
                }
            });
        });

        $(document).on("click",".tik", function(){
        if(confirm("DO you realy want to approve this record ?")){
        var said = $(this).attr("id");
        var pid = $("#postData").val();
        var element = this;
        var city = $(".city").attr("id");
        $.ajax({
          url:"Approval_PendingPage_status.php",
          method:"post",
          data:{stu_id:said,post_id:pid,city_prefer:city},
          success:function(data){
            if(data == 1)
              {
                  $(element).closest("tr").fadeOut(500); 
              }
              else{
              $("#table_load").html(data);
                
              }
              
          }
        });
      }
    });

      $(document).on("click",".held", function(){
        if(confirm("DO you realy want to Held this record ?")){
        var said = $(this).attr("id");
        var pid = $("#postData").val();
        var element = this;
        var city = $(".city").attr("id");
        $.ajax({
          url:"held_PendingPage_status.php",
          method:"post",
          data:{stu_id:said,post_id:pid,city_prefer:city},
          success:function(data){
            if(data == 1)
              {
                  $(element).closest("tr").fadeOut(500); 
              }
          }
        });
      }
    });

        $(document).on("click", ".cros", function() {
    var said = $(this).attr("id");
    var pid = $("#postData").val();
    var city = $(".city").attr("id");
    $.ajax({
        url: "reject_PendingPage_status.php",
        method: "post",
        data: { stu_id: said, post_id: pid, city_prefer: city },
        success: function(data) {
            $('#employee_detail_Reject').html(data);
            $('#dataModalReject').modal("show");
        }
    });
});

$(document).on("click", ".reject", function() {
    var said = $(this).attr("id");
    var pid = $("#postData").val();
    var mesg = $(".mesgs").val();
    var option = $('input[name="option"]:checked').val(); // Get the selected radio button value
    if (mesg.trim() === "") {
        alert("Please enter Feedback in TextArea");
    } else {
        $.ajax({
            url: "held_data_pass.php",
            method: "post",
            data: { stu_id: said, post_id: pid, mesg_info: mesg, option: option },
            success: function(data) {
                if (data == 1) {
                    $('#dataModalReject').modal("hide");
                    $('#' + said).closest("tr").fadeOut(500);
                }
            }
        });
    }
});
    });
</script>

<?php
} else {
    header("Location: index.php");
}
?>
</body>
</html>
