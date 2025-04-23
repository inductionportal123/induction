<?php
include('connection/conn.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  
  if(isset($_SESSION['u_name'], $_SESSION['u_id']))
{
  $user = $_SESSION['u_name'];
  $userid = $_SESSION['u_id'];

// ---------------------------------POST 1-------------------------------------
$list = '';
      if(isset($_POST['post_apply'])){
          $post1=$_POST['post_apply'];
          $sql11 = "SELECT * FROM `details` WHERE d_said='$userid' AND d_postid='$post1' ";
    $result11 = $conn->query($sql11);
    if ($result11->num_rows > 0)
    {
        
    }
    else
    {
        $insertpost ="INSERT INTO `details`(`d_said`, `d_postid`, `d_status`) VALUES ('$userid','$post1','Pending')";
        $exe=mysqli_query($conn,$insertpost);
         if(!$exe){
            echo die(mysqli_error($conn));
        }
    }
	$list .= $post1 . ',';
    
}
      
//----------------------- POST 2--------------------------------------------
      if(isset($_POST['post_apply1'])){
          $post2=$_POST['post_apply1'];
          $sql11 = "SELECT * FROM `details` WHERE d_said='$userid' AND d_postid='$post2' ";
    $result11 = $conn->query($sql11);
    if ($result11->num_rows > 0)
    {
        
    }
    else
    {
        $insertpost ="INSERT INTO `details`(`d_said`, `d_postid`, `d_status`) VALUES ('$userid','$post2','Pending')";
        $exe=mysqli_query($conn,$insertpost);
        if(!$exe){
            echo die(mysqli_error($conn));
        }
    }
	$list .= $post2 . ',';
    
}
//----------------------- POST 3--------------------------------------------
      if(isset($_POST['post_apply2'])){
          $post3=$_POST['post_apply2'];
          $sql11 = "SELECT * FROM `details` WHERE d_said='$userid' AND d_postid='$post3' ";
    $result11 = $conn->query($sql11);
    if ($result11->num_rows > 0)
    {
        
    }
    else
    {
        $insertpost ="INSERT INTO `details`(`d_said`, `d_postid`, `d_status`) VALUES ('$userid','$post3','Pending')";
        $exe=mysqli_query($conn,$insertpost);
         if(!$exe){
            echo die(mysqli_error($conn));
        }
    }
	$list .= $post3 . ',';
    
}    
$list = substr($list,0,-1);

//--------------------------------------------------------------------------      

$test_city_i = $_POST['test_city'];


$cities = $_POST['multy_city'];


$query_one = "SELECT `basic_dob` , `basic_domicile` FROM `per_info` WHERE `said` =  $userid ";
$query_exe = mysqli_query($conn,$query_one);
$query_row = mysqli_fetch_array($query_exe);
$query_count = mysqli_num_rows($query_exe);


if($query_count == 1)
{
	$emp_domicile = $query_row['basic_domicile'];
	$emp_dob = $query_row['basic_dob'];

	

// -----------------------------age relaxation--------------------	
$relax = array();
if (isset($_POST['caste_age_relax'])) {
	$caste_age_relax = 1;
	array_push($relax,3);
}
else{
	$caste_age_relax = 0;
}

// ----------------------retire person-----------------
if (isset($_POST['retire_age_relax'])) {
	$retire_age_relax = 1;
	$retired_armed_person = $_POST['retired_armed_person'];
	$retired_armed_position = $_POST['retired_armed_position'];

			$retired_armed_appoint = $_POST['retired_armed_appoint'];
			$retired_armed_retirement = $_POST['retired_armed_retirement'];


				$appointment = new DateTime($retired_armed_appoint);
				$retirement = new DateTime($retired_armed_retirement);
				$service_relax = $appointment->diff ($retirement);
				$difference =  (($service_relax->y) * 12) + ($service_relax->m);
				if($service_relax->format('%y') > 15)
				{
					array_push($relax,15);
				}
				else
				{
					$relax_retirment = $service_relax->format('%y');
					array_push($relax,$relax_retirment);
				}
}
else{
	$retire_age_relax = 0;
	$retired_armed_person = NULL;
	$retired_armed_position = NULL;
	$retired_armed_appoint = NULL;
	$retired_armed_retirement =  NULL;
}

// -----------------------------disabled----------------------

if (isset($_POST['diabled_age_relax']))
{
		$diabled_age_relax = 1;
		array_push($relax,10);

	$nature_diable = $_POST['nature_diable'];

}
else{
	$diabled_age_relax = 0;
	$nature_diable = NULL;
}


// --------------------------------widow age relax-----------------

if (isset($_POST['widow_age_relax']))
{
		$widow_age_relax = 1;
		array_push($relax,5);
		$widow_husband_name = $_POST['widow_husband_name'];
		$widow_husband_designaiton = $_POST['widow_husband_designaiton'];
		$widow_husband_department = $_POST['widow_husband_department'];
		$widow_husband_death = $_POST['widow_husband_death'];


}
else{
	$widow_age_relax = 0;
	$widow_husband_name = NULL;
	$widow_husband_designaiton =  NULL;
	$widow_husband_department =  NULL;
	$widow_husband_death =  NULL;
}

// ----------------------------government emply-----------------------

$query_emply = "SELECT `end_date` FROM `registrationdate`";
$query_emply_exe = mysqli_query($conn,$query_emply);
$query_emply_row = mysqli_fetch_array($query_emply_exe);
$query_emply_count = mysqli_num_rows($query_emply_exe);
if($query_emply_count == 1)
{
	$registration_end_date = $query_emply_row['end_date'];
}
$dobemp = new DateTime($emp_dob);
 $x = new DateTime($registration_end_date);

 $cal_gov_age = $dobemp->diff ($x);
//    echo "Year: ";
//    echo  $cal_gov_age->y;
//    echo "<br>Month: ";
//    echo  $cal_gov_age->m;
//    echo "<br>Day: ";
//    echo  $cal_gov_age->d;
    
    

if (isset($_POST['gov_emp']))
{
		$gov_emp = 1;
		$gov_dept_name = $_POST['gov_dept_name'];
		$gov_dept_desig = $_POST['gov_dept_desig'];
		$gov_basic_scale = $_POST['gov_basic_scale'];
		$gov_appoint = $_POST['gov_appoint'];
		$gov_retire = $_POST['gov_retire'];
		$gov_nature = $_POST['gov_nature'];

			if($cal_gov_age->format('%y') >= 55)
			{
				array_push($relax,10);
			}
}
else{
	$gov_emp = 0;
	$gov_dept_name = NULL;
		$gov_dept_desig = NULL;
		$gov_basic_scale = NULL;
		$gov_appoint = NULL;
		$gov_retire = NULL;
		$gov_nature = NULL;
}

// ---------------------------checking maximum value--------------

if(!empty($relax))
{
$total_relax = max($relax);
//    echo "Total Relax:".$total_relax."<br>";
$age = $cal_gov_age->format('%y') - $total_relax ;
    $age=$age-5;
     

}
else
{
	$age = $cal_gov_age->format('%y') - 5;
     //echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
}

//---------------------------------POST 1----------------------------------
if(isset($_POST['post_apply'])){
    $post1=$_POST['post_apply'];
	$query_age = "SELECT posts.pid , posts.name, post_details.min, post_details.max FROM posts
					INNER JOIN post_details
					ON posts.pid=post_details.pid where posts.pid = '".$post1."' ";


	$exe_age = mysqli_query($conn,$query_age);
	$row_age = mysqli_fetch_array($exe_age);

	if($age == $row_age['min'] && $age == $row_age['max']) //29 >= 18 && 29 <= 30
	{
        if($cal_gov_age->m == 0)
        {
            if($cal_gov_age->d == 0)
            {
                $x = "ok";
            }
            else
            {
                
                echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
                echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
                exit();
            }
        }
        else
        {
           
            echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
            echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
            exit();
        }
    }
    elseif($age > $row_age['min'] && $age < $row_age['max'])
    {
        //echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        $x = "ok";
    }
    else
    {
       
		echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
        echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        exit();
	}

}
//---------------------------------POST 2----------------------------------
if(isset($_POST['post_apply1'])){
    $post2=$_POST['post_apply1'];
	$query_age = "SELECT posts.pid , posts.name, post_details.min, post_details.max FROM posts
					INNER JOIN post_details
					ON posts.pid=post_details.pid where posts.pid = '".$post2."' ";


	$exe_age = mysqli_query($conn,$query_age);
	$row_age = mysqli_fetch_array($exe_age);

	if($age == $row_age['min'] && $age == $row_age['max']) //29 >= 18 && 29 <= 30
	{
        if($cal_gov_age->m == 0)
        {
            if($cal_gov_age->d == 0)
            {
                $x = "ok";
            }
            else
            {
                
                echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
                echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
                exit();
            }
        }
        else
        {
           
            echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
            echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
            exit();
        }
    }
    elseif($age > $row_age['min'] && $age < $row_age['max'])
    {
        //echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        $x = "ok";
    }
    else
    {
       
		echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
        echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        exit();
	}
}
//---------------------------------POST 2----------------------------------
if(isset($_POST['post_apply2'])){
    $post3=$_POST['post_apply2'];
	$query_age = "SELECT posts.pid , posts.name, post_details.min, post_details.max FROM posts
					INNER JOIN post_details
					ON posts.pid=post_details.pid where posts.pid = '".$post3."' ";


	$exe_age = mysqli_query($conn,$query_age);
	$row_age = mysqli_fetch_array($exe_age);

	if($age == $row_age['min'] && $age == $row_age['max']) //29 >= 18 && 29 <= 30
	{
        if($cal_gov_age->m == 0)
        {
            if($cal_gov_age->d == 0)
            {
                $x = "ok";
            }
            else
            {
                
                echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
                echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
                exit();
            }
        }
        else
        {
           
            echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
            echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
            exit();
        }
    }
    elseif($age > $row_age['min'] && $age < $row_age['max'])
    {
        //echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        $x = "ok";
    }
    else
    {
       
		echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
        echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        exit();
	}
}
   
// -----------------------------age relaxation ends--------------------	


$que = "SELECT * FROM `post_apply` WHERE said = '".$userid."'";
$ex = mysqli_query($conn,$que);
$ro = mysqli_fetch_array($ex);
$rowcount = mysqli_num_rows($ex);

if($rowcount == 1)
{
		$inserting_data_update = "UPDATE `post_apply` SET `post_apply`='$list',`city_prefer`='$test_city_i',`city_prefer_two`='$cities',`relax_schedule_caste`='$caste_age_relax',
	`relax_retired`='$retire_age_relax',`relax_retired_from`='$retired_armed_person',
	`relax_retired_position`='$retired_armed_position',`relax_retired_appoint`='$retired_armed_appoint',`relax_retired_retired`='$retired_armed_retirement',`relax_disable`='$diabled_age_relax',`relax_disabled_nature`='$nature_diable',`relax_widow`='$widow_age_relax',`relax_name_employ`='$widow_husband_name',`relax_designation`='$widow_husband_designaiton',`relax_department`='$widow_husband_department',`relax_date_death`='$widow_husband_death',`gov`='$gov_emp',`gov_name`='$gov_dept_name',
	`gov_designation`='$gov_dept_desig',`gov_basic_pay`='$gov_basic_scale',
	`gov_appoint_date`='$gov_appoint',`gov_retire_date`='$gov_retire'
	,`gov_appoint_nature`='$gov_nature' WHERE `said` = $userid";	

			$inserting_data_query_exes = mysqli_query($conn,$inserting_data_update);
			echo 1;
}
else
{
	$inserting_data_query = "INSERT INTO `post_apply`(`post_apply`, `city_prefer`, `city_prefer_two`, `relax_schedule_caste`, `relax_retired`, `relax_retired_from`, `relax_retired_position`, `relax_retired_appoint`, `relax_retired_retired`, `relax_disable`, `relax_disabled_nature`, `relax_widow`, `relax_name_employ`, `relax_designation`, `relax_department`, `relax_date_death`,`gov`, `gov_name`, `gov_designation`, `gov_basic_pay`, `gov_appoint_date`, `gov_retire_date`, `gov_appoint_nature`, `said`)
	VALUES ('$list','$test_city_i','$cities','$caste_age_relax','$retire_age_relax','$retired_armed_person','$retired_armed_position','$retired_armed_appoint','$retired_armed_retirement','$diabled_age_relax','$nature_diable','$widow_age_relax','$widow_husband_name','$widow_husband_designaiton','$widow_husband_department','$widow_husband_death','$gov_emp','$gov_dept_name','$gov_dept_desig','$gov_basic_scale','$gov_appoint','$gov_retire','$gov_nature','$userid')";

			$inserting_data_query_exe = mysqli_query($conn,$inserting_data_query);
			echo 1;
}


}

else
{
	echo 0;
}


// ----------------------------------Session ends -------------------------------
}
else{
  header("Location: index.php");
}

?>