<?php
include('connection/conn.php');
if(!isset($_SESSION)) { 
    session_start(); 
}

if(isset($_SESSION['u_name'], $_SESSION['u_id'])) {
    $user = $_SESSION['u_name'];
    $userid = $_SESSION['u_id'];

    mysqli_begin_transaction($conn);

    try {
        $del = "SELECT * FROM `emp_document` WHERE emp_document.said ='$userid'";
        $exedel = mysqli_query($conn, $del);
        $delrows = mysqli_num_rows($exedel);
        if($delrows > 0) {
            $delete = "DELETE FROM `emp_document` WHERE emp_document.said ='$userid'";
            $exedelete = mysqli_query($conn, $delete);
        }

        $validExtensions = ['jpg',  'JPG','jpeg', 'JPEG','png', 'PNG'];
        $maxFileSize = 102400; // 500 KB
        $files = [
            'recipt_image' => 'recipt',
            'pdegree_image' => 'pdegree',
            'ddegree_image' => 'ddegree',
            'passport_image' => 'passport',
            'cnic_image' => 'cnic',
            'domicile_image' => 'domicile',
            'degree_image' => 'degree',
        ];

        $targets = [];
        $dbImages = [];

        $postid= "SELECT post_apply.post_apply FROM post_apply WHERE post_apply.said='$userid'";
      $idexe = mysqli_query($conn, $postid);
      $iddata = mysqli_fetch_array($idexe);
      $ppid = $iddata['post_apply'];
      $str_arr = explode (",", $ppid);
      foreach ($str_arr as $postids)
      {
      $postapply = "SELECT SUM(fee_slot.fee) AS total  FROM fee_slot WHERE fee_slot.post_id ='$postids' ";
      $postexe = mysqli_query($conn, $postapply);
      $postdata = mysqli_fetch_array($postexe);
      if($postdata['total'] > 0)
      {

        if (!isset($_FILES['recipt_image']) || $_FILES['recipt_image']['size'] == 0) {
            throw new Exception("Receipt image is required.");
        }

    }
}


        foreach ($files as $key => $prefix) {
            if (isset($_FILES[$key]['size'])) {
                if ($_FILES[$key]['size'] <= $maxFileSize) {
                    $target = "documents/".$userid.'-'.$prefix.'-'.preg_replace('/[^A-Za-z0-9.]/', '', basename(strtolower($_FILES[$key]['name'])));
                    $dbImage = 'documents/'.$userid.'-'.$prefix.'-'.preg_replace('/[^A-Za-z0-9.]/', '', strtolower($_FILES[$key]['name']));
                    $ext = pathinfo($target, PATHINFO_EXTENSION);
                    if (!in_array($ext, $validExtensions)) {
                        throw new Exception("Invalid $prefix image format.");
                    }
                    $targets[$key] = $target;
                    $dbImages[$key] = $dbImage;
                } else {
                    throw new Exception("$prefix image size is too large.");
                }
            } else {
                $targets[$key] = 'NULL';
                $dbImages[$key] = 'NULL';
            }
        }
      

        $query = "INSERT INTO `emp_document`(`image`, `recipt`, `cnic`, `domicile`, `last_degree`, `professional_degree`, `driving_license`, `said`) VALUES 
                  ('{$dbImages['passport_image']}', '{$dbImages['recipt_image']}', '{$dbImages['cnic_image']}', '{$dbImages['domicile_image']}', 
                   '{$dbImages['degree_image']}', '{$dbImages['pdegree_image']}', '{$dbImages['ddegree_image']}', '$userid')";
        $exe = mysqli_query($conn, $query);

        if(!$exe) {
            throw new Exception(mysqli_error($conn));
        }

        foreach ($files as $key => $prefix) {
            if(isset($_FILES[$key]) && $targets[$key] !== 'NULL' && !move_uploaded_file($_FILES[$key]['tmp_name'], $targets[$key])) {
                throw new Exception("Failed to move $prefix image.");
            }
        }

        mysqli_commit($conn);
        header("Location: undertaking.php");
    } catch (Exception $e) {
        
        mysqli_rollback($conn);
        echo "Failed: " . $e->getMessage();
    }

    
} else {
    

    header("Location: index.php");
}

mysqli_close($conn);
?>

