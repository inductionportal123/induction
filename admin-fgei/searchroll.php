<?php
include('../connection/conn.php');

if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['user_name'],$_SESSION['user_access']))
{
	$user = $_SESSION['user_name'];
  $userid = $_SESSION['user_access'];

	$arr = explode(' ',trim($user));
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
<?php 
	include('header.php');  
	include('appnav.php'); 
?>

<div class="col-lg-offset-3 col-md-offset-3 col-md-8 col-lg-8" align="center">
   	<h3 style="color: green;margin-bottom: 20px">Pending Applications</h3>
   	<div class="form-inline">
   		<label>Enter Cnic No: &nbsp;&nbsp;</label>
   		<input type="text" name="cnic" placeholder="(Format xxxxx-xxxxxxx-x)" class="form-control" style="width: 300px;height: 36px" id="cnic">
   		<?php

//echo $user;
   		if ($user=='super-admin' || $user=='aoi-3')
   		{
   			?>
   		<button type="button" style="outline: none" class="btn btn-info btn-md" id="load">Load</button>

   		<?php
   	   }
   	  ?>
   	

   	</div>
   	<h4 id="loading" style="align-items: center;color: green;letter-spacing: 1;font-weight: bold"></h4>
   	<div id="table_load"  style="margin-top:40px;margin-left:50px"></div>
</div>

<div id="dataModal" class="modal fade" >
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

                  <button type="button" class="close"  data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Applicant Details</h4>
          
        </div>
        <div class="modal-body" id="employee_detail">
          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div> 


<script type="text/javascript">
    $(document).ready(function(){
    	 $("#load").on("click",function(e){
         $("#cnic").attr('disabled', 'disabled');
         $("#loading").html("Loading New Records....");
    		var value = $("#cnic").val();
		 	if(value == "")
		 	{
					$("#table_load").html("");
		 	}
		 	else{
			$.ajax({
				url	 : "cnic_load_data.php",
				type : "POST",
				data : {val:value},
				success : function(data)
				{
		              $("#cnic").attr('disabled', false);
		               $("#loading").html("");
		              $("#table_load").html(data);
    				} 
    			});
    			}
    		});
    	});

     	$(document).on("click",".view_data", function(){
	      var employee_id = $(this).attr("id");
	      $.ajax({
	        url:"modalPending.php",
	        method:"post",
	        data:{employee_id:employee_id},
	        success:function(data){
	          $('#employee_detail').html(data);
	          $('#dataModal').modal("show");
	        }
	      });
		});


   
</script>


<?php
}
else{
  header("Location: index.php");
}
?>
</body>
</html>