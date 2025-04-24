<?php
error_reporting(0);
include('connection/conn.php');
if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
  if(isset($_SESSION['u_name'], $_SESSION['u_id']))
{
  $user = $_SESSION['u_name'];
  $userid = $_SESSION['u_id'];
  $post_of_teching=$_POST['post_apply'];

// ---------------------------------POST 1-------------------------------------
$list = '';
      if(isset($_POST['post_apply'])){
          
         
        foreach ($_POST['post_apply'] as $post1) {
            
    $check_pro_enter = "SELECT qualification.matric_title,qualification.primary_title,qualification.middle_title,qualification.inter_title,qualification.bs_title,qualification.bs16_title, qualification.profes_certificate FROM qualification WHERE said = '$userid'";
    $pro_check = mysqli_query($conn, $check_pro_enter);
    $opendata2 = mysqli_fetch_array($pro_check);

    $check_pro_degree = "SELECT posts.name, posts.professional_degree_required FROM posts WHERE pid = '$post1'";
    $pro_exe = mysqli_query($conn, $check_pro_degree);
    $opendata1 = mysqli_fetch_array($pro_exe);
    $ppp = $opendata1['professional_degree_required'];
    $dt = $opendata2['profes_certificate'];
    $matric= $opendata2['matric_title'];

    
    
    if ($ppp == 1 && (is_null($dt) || $dt === '')) {
        echo 'Professional Degree required for ' . htmlspecialchars($opendata1['name']) . ' Post. Please Complete Professional Degree Portion from Qualification';
    }
        else{
            
            
             

          $opencheck = "SELECT nonteachingstaff.open_merit FROM `nonteachingstaff` WHERE nonteachingstaff.pid = '$post1'";
          $openexe = mysqli_query($conn, $opencheck);
          $opendata = mysqli_fetch_array($openexe);
          $open_merit = $opendata['open_merit'];
         
          if($open_merit != 0)
          {
              $list .= $post1 . ',';
              
          }
          
          else
          { 
             
              $domgen = "SELECT per_info.basic_gender , per_info.basic_domicile , per_info.female_applying , per_info.female_husband_province FROM `per_info` WHERE said ='$userid'";
              $exedomgen = mysqli_query ($conn, $domgen);
              $domgendata = mysqli_fetch_array($exedomgen);
              $can_gender = $domgendata['basic_gender'];
              
              $can_dom = $domgendata['basic_domicile'];
              $can_female = $domgendata['female_applying'];
              $can_hdom = $domgendata['female_husband_province']; 
              

              if($can_female == 0)
              {
                  $can_domicile = $can_dom;
                   
              }
              
              else
              {
                  $can_domicile = $can_hdom;
              }
              switch($can_domicile)
              {
                  case 1:
                  if($can_gender == 'male')
                  {
                      
                      $meritcheck = "SELECT nonteachingstaff.pu_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $pu_merit = $datameritcheck['pu_merit'];
                      
                      if($pu_merit != 0)
                      {
                          $list .= $post1 . ',';
                           
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.pu_women , nonteachingstaff.pu_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $pu_women = $datameritcheck['pu_women'];
                      $pu_merit = $datameritcheck['pu_merit'];
                      if($pu_women != 0 || $pu_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //---------------punjab ended------------------------      
                  case 2:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.kpk_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $kpk_merit = $datameritcheck['kpk_merit'];
                      if($kpk_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.kpk_women , nonteachingstaff.kpk_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $kpk_women = $datameritcheck['kpk_women'];
                      $kpk_merit = $datameritcheck['kpk_merit'];
                      if($kpk_women != 0 || $kpk_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //-----------------KPK ended-------------------------      
                  case 3:
                       if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.bl_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $bl_merit = $datameritcheck['bl_merit'];
                      if($bl_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.bl_women , nonteachingstaff.bl_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $bl_women = $datameritcheck['bl_women'];
                      $bl_merit = $datameritcheck['bl_merit'];
                      if($bl_women != 0 || $bl_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //-----------------Balochistan ended-----------------
                  case 4:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.su_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $su_merit = $datameritcheck['su_merit'];
                      if($su_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.su_women , nonteachingstaff.su_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $su_women = $datameritcheck['su_women'];
                      $su_merit = $datameritcheck['su_merit'];
                      if($su_women != 0 || $su_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //-----------------Sindh-urban ended------------------      
                  case 5:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.sr_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $sr_merit = $datameritcheck['sr_merit'];
                      if($sr_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.sr_women , nonteachingstaff.sr_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $sr_women = $datameritcheck['sr_women'];
                      $sr_merit = $datameritcheck['sr_merit'];
                      if($sr_women != 0 || $sr_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //-----------------sindh rural ended------------------      
                  case 6:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.akj_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $akj_merit = $datameritcheck['akj_merit'];
                      if($akj_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.akj_women , nonteachingstaff.akj_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $akj_women = $datameritcheck['akj_women'];
                      $akj_merit = $datameritcheck['akj_merit'];
                      if($akj_women != 0 || $akj_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  
                  break;
                //-------------------ajk ended-------------------------  


                case 7:
                    if($can_gender == 'male')
                {
                    $meritcheck = "SELECT nonteachingstaff.fata_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                    $exemeritcheck = mysqli_query($conn, $meritcheck);
                    $datameritcheck = mysqli_fetch_array($exemeritcheck);
                    $fata_merit = $datameritcheck['fata_merit'];
                    if($fata_merit != 0)
                    {
                        $list .= $post1 . ',';
                    }
                    else
                    {
                        ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                              window.location.replace("post_apply.php");
                          </script>
              
                      <?php
                    }
                }
                else if($can_gender == 'female')
                {
                    $meritcheck = "SELECT nonteachingstaff.fata_women , nonteachingstaff.fata_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                    $exemeritcheck = mysqli_query($conn, $meritcheck);
                    $datameritcheck = mysqli_fetch_array($exemeritcheck);
                    $fata_women = $datameritcheck['fata_women'];
                    $fata_merit = $datameritcheck['fata_merit'];

                    if($fata_women != 0 || $fata_merit != 0 )
                    {
                        $list .= $post1 . ',';
                    }
                    else
                    {
                        ?>
                        <script>alert("No seats are available for the selected post in your selected domicile.");
                              window.location.replace("post_apply.php");
                          </script>
<?php
                    }
                
                break;
              //-------------------FATE ended-------------------------  
                }




                  case '8':
                      echo 'ya raha'.$post1;
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.gb_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $gb_merit = $datameritcheck['gb_merit'];
                      if($gb_merit != 0 )
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.fata_women , nonteachingstaff.fata_merit ,nonteachingstaff.gb_women , nonteachingstaff.gb_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post1'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);

                      $gb_women = $datameritcheck['gb_women'];
                      $gb_merit = $datameritcheck['gb_merit'];
                      if( $gb_women != 0 || $gb_merit != 0)
                      {
                          $list .= $post1 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  
                  break;
                //-------------------GB ended-------------------------  
                  }
              }
          }
        }
        }
      }
      
//--------------------------Quota code post 1 end --------------------------  
                      
                      
                      
                      
//----------------------- POST 2--------------------------------------------
      if(isset($_POST['post_apply2'])){
        
        foreach($_POST['post_apply2'] as $post2)
        {
            
            
         
          


            $check_pro_enter = "SELECT qualification.matric_title,qualification.primary_title,qualification.middle_title,qualification.inter_title,qualification.bs_title,qualification.bs16_title, qualification.profes_certificate FROM qualification WHERE said = '$userid'";
        $pro_check = mysqli_query($conn, $check_pro_enter); 
        $opendata2 = mysqli_fetch_array($pro_check);

        $check_pro_degree = "SELECT posts.name, posts.professional_degree_required FROM posts WHERE pid = '$post2'";
        $pro_exe = mysqli_query($conn, $check_pro_degree);
        $opendata1 = mysqli_fetch_array($pro_exe);
        $ppp=$opendata1['professional_degree_required'];
        $dt=$opendata2['profes_certificate'];
        if ($ppp == 1 && ($dt == 'NULL' || $dt == '' || $dt == NULL))
        {
            ?>
            <script>alert("Professional Degree required for <?php echo $opendata1['name']; ?> Post. Please Complete Professional Degree Portion from Qulification ");
                                window.location.replace("post_apply.php");
                            </script>
                            <?php
        }
        else{
            
           
    
          
            
          
          $opencheck = "SELECT nonteachingstaff.open_merit FROM `nonteachingstaff` WHERE nonteachingstaff.pid = '$post2'";
          $openexe = mysqli_query($conn, $opencheck);
     
          $opendata = mysqli_fetch_array($openexe);
        
          $open_merit = $opendata['open_merit'];
          
          if($open_merit != 0)
          {

              $list .= $post2 . ',';
              
            
          }
          else
          {
              
              $domgen = "SELECT per_info.basic_gender , per_info.basic_domicile , per_info.female_applying , per_info.female_husband_province FROM `per_info` WHERE said ='$userid'";
              $exedomgen = mysqli_query ($conn, $domgen);
              $domgendata = mysqli_fetch_array($exedomgen);
              $can_gender = $domgendata['basic_gender'];
              $can_dom = $domgendata['basic_domicile'];
             
              $can_female = $domgendata['female_applying'];
              $can_hdom = $domgendata['female_husband_province']; 
              
              if($can_female == 0)
              {
                  $can_domicile = $can_dom; 
                  
                  
              }
              else
              {
                  $can_domicile = $can_hdom;
              }
              switch($can_domicile)
              {
                  case 1:
                  if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.pu_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $pu_merit = $datameritcheck['pu_merit'];
                      if($pu_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.pu_women , nonteachingstaff.pu_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $pu_women = $datameritcheck['pu_women'];
                      $pu_merit = $datameritcheck['pu_merit'];
                      if($pu_women != 0 || $pu_merit != 0)
                      {
                          $list .= $post2 . ',';
                         
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //---------------punjab ended------------------------      
                  case 2:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.kpk_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $kpk_merit = $datameritcheck['kpk_merit'];
                      if($kpk_merit != 0)
                      {
                          $list .= $post2 . ',';
                          
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.kpk_women , nonteachingstaff.kpk_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $kpk_women = $datameritcheck['kpk_women'];
                      $kpk_merit = $datameritcheck['kpk_merit'];
                      if($kpk_women != 0 || $kpk_merit != 0)
                      {
                          $list .= $post2 . ',';
                          
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //-----------------KPK ended-------------------------      
                  case 3:
                       if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.bl_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $bl_merit = $datameritcheck['bl_merit'];
                      if($bl_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.bl_women , nonteachingstaff.bl_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $bl_women = $datameritcheck['bl_women'];
                      $bl_merit = $datameritcheck['bl_merit'];
                      if($bl_women != 0 || $bl_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //-----------------Balochistan ended-----------------
                  case 4:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.su_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $su_merit = $datameritcheck['su_merit'];
                      if($su_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.su_women , nonteachingstaff.su_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $su_women = $datameritcheck['su_women'];
                      $su_merit = $datameritcheck['su_merit'];
                      if($su_women != 0 || $su_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                  
                //-----------------Sindh-urban ended------------------      
                  case 5:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.sr_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $sr_merit = $datameritcheck['sr_merit'];
                      if($sr_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.sr_women , nonteachingstaff.sr_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $sr_women = $datameritcheck['sr_women'];
                      $sr_merit = $datameritcheck['sr_merit'];
                      if($sr_women != 0 || $sr_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  break;
                //-----------------sindh rural ended------------------      
                  case 6:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.akj_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $akj_merit = $datameritcheck['akj_merit'];
                      if($akj_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.akj_women , nonteachingstaff.akj_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $akj_women = $datameritcheck['akj_women'];
                      $akj_merit = $datameritcheck['akj_merit'];
                      if($akj_women != 0 || $akj_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  }
                  
                  break;
                //-------------------ajk ended-------------------------  



                case 7:
                    if($can_gender == 'male')
                {
                    $meritcheck = "SELECT nonteachingstaff.fata_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                    $exemeritcheck = mysqli_query($conn, $meritcheck);
                    $datameritcheck = mysqli_fetch_array($exemeritcheck);
                    $fata_merit = $datameritcheck['fata_merit'];
                    if( $fata_merit != 0)
                    {
                        $list .= $post2 . ',';
                    }
                    else
                    {
                        ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                              window.location.replace("post_apply.php");
                          </script>
              
                      <?php
                    }
                }
                else if($can_gender == 'female')
                {
                    $meritcheck = "SELECT nonteachingstaff.fata_women , nonteachingstaff.fata_merit ,nonteachingstaff.gb_women , nonteachingstaff.gb_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                    $exemeritcheck = mysqli_query($conn, $meritcheck);
                    $datameritcheck = mysqli_fetch_array($exemeritcheck);
                    $fata_women = $datameritcheck['fata_women'];
                    $fata_merit = $datameritcheck['fata_merit'];

                    if($fata_women != 0 || $fata_merit != 0)
                    {
                        $list .= $post2 . ',';
                    }
                    else
                    {
                        ?>
                        <script>alert("No seats are available for the selected post in your selected domicile.");
                              window.location.replace("post_apply.php");
                          </script>
<?php
                    }
                
                break;
              //-------------------FATA ended-------------------------  
                }



                  case 8:
                      if($can_gender == 'male')
                  {
                      $meritcheck = "SELECT nonteachingstaff.fata_merit, nonteachingstaff.gb_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      $fata_merit = $datameritcheck['fata_merit'];
                      $gb_merit = $datameritcheck['gb_merit'];
                      if($gb_merit != 0 )
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                            <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
                
                        <?php
                      }
                  }
                  else if($can_gender == 'female')
                  {
                      $meritcheck = "SELECT nonteachingstaff.fata_women , nonteachingstaff.fata_merit ,nonteachingstaff.gb_women , nonteachingstaff.gb_merit FROM nonteachingstaff WHERE nonteachingstaff.pid='$post2'";
                      $exemeritcheck = mysqli_query($conn, $meritcheck);
                      $datameritcheck = mysqli_fetch_array($exemeritcheck);
                      
                      $gb_women = $datameritcheck['gb_women'];
                      $gb_merit = $datameritcheck['gb_merit'];
                      if( $gb_women != 0 || $gb_merit != 0)
                      {
                          $list .= $post2 . ',';
                      }
                      else
                      {
                          ?>
                          <script>alert("No seats are available for the selected post in your selected domicile.");
                                window.location.replace("post_apply.php");
                            </script>
<?php
                      }
                  
                  break;
                //-------------------GB ended-------------------------  




                  }
              }
          }
          
        }
        }
      }
      
      
//----------------------- quoto code post 2 ended--------------------------------------------
      
//----------------------- POST 3--------------------------------------------
if(isset($_POST['post_apply3']))
{
    $check_pro_enter = "SELECT qualification.matric_title,qualification.primary_title,qualification.middle_title,qualification.inter_title,qualification.bs_title,qualification.bs16_title, qualification.profes_certificate FROM qualification WHERE said = '$userid'";
    $pro_check = mysqli_query($conn, $check_pro_enter);
    $opendata2 = mysqli_fetch_array($pro_check);
    
   
    foreach($_POST['post_apply3'] as $post3)
    {
        
        
        $list .= $post3 . ',';
    }
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
if ($emp_domicile == 24) {
	array_push($relax,3);
}
    
    
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

    $service_relax = $appointment->diff($retirement);
    

    // Calculate the total months of service
    $total_months = ($service_relax->y * 12) + $service_relax->m;

    // Calculate the total days of service
    $total_days = $service_relax->days;

    // echo "Total months of service: $total_months\n";
    // echo "Total days of service: $service_relax->y.$total_days\n";

    
    if ($service_relax->y >= 15) {
        array_push($relax, 15);
       
    } else {
        array_push($relax, $total_days);
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



// Calculate age in years, months, and days
$ageInterval = $dobemp->diff($x);
$ageInYears = $ageInterval->y;
$ageInMonths = $ageInYears * 12 + $ageInterval->m;
$ageInDays = $ageInterval->days;

// echo "Age in years: $ageInYears\n";
// echo "Age in months: $ageInMonths\n";
// echo "Age in days: $ageInDays\n";






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
    
        // ------------------- GOVERNMENT AGE RELAXATION ----------------------------
    
        $dateofappointment = new DateTime($gov_appoint);  // appointment date
        $dateofretire = new DateTime($gov_retire);       // retirement date
        $registerationdate = new DateTime($registration_end_date); // registeration end date
        $total_experience = $dateofappointment->diff ($dateofretire); // experience = retirement date - appointment date
        if($total_experience->y >= 2) // if experience is greater than or equal to 2
        {
            array_push($relax,10);
        }
        // ------------------- GOVERNMENT AGE RELAXATION ----------------------------
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


	$age = $cal_gov_age->format('%y');

// Assume connection to the database is established
// $conn = new mysqli("servername", "username", "password", "dbname");

if (isset($_POST['post_apply']) || isset($_POST['post_apply2']) || isset($_POST['post_apply3'])){
    // Fetch the candidate's qualifications
    $check_pro_enter = "SELECT qualification.matric_title, qualification.primary_title, qualification.middle_title, qualification.inter_title, qualification.bs_title, qualification.bs16_title, qualification.profes_certificate 
                        FROM qualification 
                        WHERE said = '$userid'";
    $pro_check = mysqli_query($conn, $check_pro_enter); 
    $opendata_post1 = mysqli_fetch_array($pro_check);
    $opendata_post2 = $opendata_post1; // Initialize for post 2, assuming same qualifications

    // Ensure $opendata_post1 is not empty
    if (!$opendata_post1) {
        echo "Error fetching qualification data.";
        exit();
    }

    // Define degree hierarchy and fields
    $degree_hierarchy = [ 'Bachelors', 'Bachelors16', 'ms', 'Primary' ];
    $degree_fields = [
       
        'Bachelors' => 'bs_title',
        'Bachelors16' => 'bs16_title',
        'ms' => 'ms_title',
        'Primary' => 'primary_title',

    ];

    // Define eligibility function
    function is_eligible($req_degree, $opendata, $degree_hierarchy, $degree_fields) {
        $required_index = array_search($req_degree, $degree_hierarchy);

        for ($i = $required_index; $i < count($degree_hierarchy); $i++) {
            $current_degree = $degree_hierarchy[$i];
            $current_field = $degree_fields[$current_degree];
            
            if (!empty($opendata[$current_field]) && $opendata[$current_field] !== 'NULL' && trim($opendata[$current_field]) !== '') {
                return true;
            }
        }

        echo 'You are not eligible. ' . $req_degree . ' is required for this post.';
        return false;
    }

    // Iterate over post_apply (POST 1)
    if (isset($_POST['post_apply'])) {
        foreach ($_POST['post_apply'] as $post1) { 
            // Fetch the post details
            $query_age = "SELECT posts.pid, posts.name, post_details.req_deg, post_details.min, post_details.max 
                          FROM posts
                          INNER JOIN post_details ON posts.pid = post_details.pid 
                          WHERE posts.pid = '".$post1."'";
            $exe_age = mysqli_query($conn, $query_age);
            $row_age = mysqli_fetch_array($exe_age);

            // Ensure $row_age is not empty
            if (!$row_age) {
                echo "Error fetching post details for post ID: " . $post1;
                exit();   // Skip this post and continue with the next one
            }

            $req_degree = $row_age['req_deg'];

            // Check eligibility based on qualifications for POST 1
            if (!is_eligible($req_degree, $opendata_post1, $degree_hierarchy, $degree_fields)) {
                exit();   // If not eligible, skip this post and continue with the next one
            }

            // Continue with age validation for POST 1
            $maxage = $row_age['max'] + 5;
            $minage = $row_age['min'];

           

    // $maxage = $row_age['max'] + 5;
    // $minage = $row_age['min'];
    
    
    if($age >= $minage && $age < $maxage )
    {
        $x = "ok";
    }
   
    elseif($age == $maxage)
    {
        if(!empty($relax))
        {
            $total_relax = max($relax);
            $age = $age - $total_relax;
            $x = "ok";
        }
        elseif($cal_gov_age->m == 0 && $cal_gov_age->d == 0)
        {
            $x = "ok";
        }
        else
        {
            echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
            echo "<br>Your age on Closing date is: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
            echo "<br>Your age on closing date of appliaction should be : ".$maxage." or less (including 5 years of general relaxation)";
            // Max allowed age limit is
            exit();
        }
    }
    elseif($age > $maxage)
    {
        if(!empty($relax))
        {
            $total_relax = max($relax);
            if (isset($_POST['retire_age_relax']) && $total_relax!='15' ) 
            {

                
                $age = $ageInDays - $total_relax;
                $maxage=$maxage*365.3;
                
            }
            else{
                $age = $age - $total_relax;
            }

            if($age < $maxage )
            {
                $x = "ok";
            }
            elseif($age == $maxage && $cal_gov_age->m == 0 && $cal_gov_age->d == 0)
            {
                $x = "ok";
            }
            else
            {
                
                if (isset($_POST['retire_age_relax']) && $total_relax!='15' ) 
                {
                    echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
                    // Calculate age in years, months, and days
                    $years = floor($age / 365);
                    $remainingDays = $age % 365;
                    $months = floor($remainingDays / 30);
                    $days = $remainingDays % 30;
                    echo "<br>Age after relaxation: $years Years $months Months $days Days<br>";  
                    echo "<br>Max allowed age limit is: ".$maxage/365.3." (including 5 years of general relaxation)";
                     exit();
                 }
                else
                {
                echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
                echo "<br>Age after relaxation: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
                echo "<br>Max allowed age limit is: ".$maxage." (including 5 years of general relaxation)";
                exit();
                }
                
            }
        }
        else
        {
            echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
            echo "<br>Your age on Closing date is: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
            echo "<br>Max allowed age limit is: ".$maxage." (including 5 years of general relaxation)";
            exit();
        }
    }
    elseif ($age < $minage)
    {
        echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
        echo "<br>Your age on Closing date is: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        echo "<br>Max allowed age limit is: ".$maxage." (including 5 years of general relaxation)";
        exit();
    }
        }
    }

    // Iterate over post_apply2 (POST 2)
    if (isset($_POST['post_apply2'])) {
        foreach ($_POST['post_apply2'] as $post2) { 
            // Fetch the post details
            $query_age = "SELECT posts.pid, posts.name, post_details.req_deg, post_details.min, post_details.max 
                          FROM posts
                          INNER JOIN post_details ON posts.pid = post_details.pid 
                          WHERE posts.pid = '".$post2."'";
            $exe_age = mysqli_query($conn, $query_age);
            $row_age = mysqli_fetch_array($exe_age);

            // Ensure $row_age is not empty
            if (!$row_age) {
                echo "Error fetching post details for post ID: " . $post2;
                exit();  // Skip this post and continue with the next one
            }

            $req_degree = $row_age['req_deg'];

            // Check eligibility based on qualifications for POST 2
            if (!is_eligible($req_degree, $opendata_post2, $degree_hierarchy, $degree_fields)) {
                exit();  // If not eligible, skip this post and continue with the next one
            }

            // Continue with age validation for POST 2
            $maxage = $row_age['max'] + 5;
            $minage = $row_age['min'];

            
    $maxage = $row_age['max'] + 5;
    $minage = $row_age['min'];
	if($age >= $minage && $age < $maxage )
    {
        $x = "ok";
    }
    elseif($age == $maxage)
    {
        if(!empty($relax))
        {
            $total_relax = max($relax);
            $age = $age - $total_relax;
            $x = "ok";
        }
        elseif($cal_gov_age->m == 0 && $cal_gov_age->d == 0)
        {
            $x = "ok";
        }
        else
        {
            echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
            echo "<br>Your age on Closing date is: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
            echo "<br>Max allowed age limit is: ".$maxage." (including 5 years of general relaxation)";
            exit();
        }
    }
    elseif($age > $maxage)
    {
        if(!empty($relax))
        {
            $total_relax = max($relax);
            $age = $age - $total_relax;
            if($age < $maxage )
            {
                $x = "ok";
            }
            elseif($age == $maxage && $cal_gov_age->m == 0 && $cal_gov_age->d == 0)
            {
                $x = "ok";
            }
            else
            {
                echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
                echo "<br>Your age on Closing date is: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
                echo "<br>Max allowed age limit is: ".$maxage." (including 5 years of general relaxation)";
                exit();
            }
        }
        else
        {
            echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
            echo "<br>Your age on Closing date is: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
            echo "<br>Max allowed age limit is: ".$maxage." (including 5 years of general relaxation)";
            exit();
        }
    }
    elseif ($age < $minage)
    {
        echo "You are not eligible for the post of ".strtoupper($row_age['name'])." due to age limit.<br>";
        echo "<br>Your age on Closing date is: ".$age." Years ".$cal_gov_age->m." Months ".$cal_gov_age->d." Days<br>";
        echo "<br>Max allowed age limit is: ".$maxage." (including 5 years of general relaxation)";
        exit();
    }
        }
    }

    //---------------------------------POST 3----------------------------------

if(isset($_POST['post_apply3']))
{
    // Fetch the candidate's qualifications for POST 3
    $check_pro_enter_post3 = "SELECT qualification.matric_title, qualification.primary_title, qualification.middle_title, qualification.inter_title, qualification.bs_title, qualification.bs16_title, qualification.profes_certificate 
                        FROM qualification 
                        WHERE said = '$userid'";
    $pro_check_post3 = mysqli_query($conn, $check_pro_enter_post3); 
    $opendata_post3 = mysqli_fetch_array($pro_check_post3);

    // Ensure $opendata_post3 is not empty
    if (!$opendata_post3) {
        echo "Error fetching qualification data for POST 3.";
        exit();
    }

    // Define degree hierarchy and fields
    $degree_hierarchy = ['Primary', 'Middle', 'Matric', 'Inter', 'Bachelors', 'Bachelors16'];
    $degree_fields = [
        'Primary' => 'primary_title',
        'Middle' => 'middle_title',
        'Matric' => 'matric_title',
        'Inter' => 'inter_title',
        'Bachelors' => 'bs_title',
        'Bachelors16' => 'bs16_title'
    ];

    // Define eligibility function for POST 3
    function is_eligible_post3($req_degree, $opendata_post3, $degree_hierarchy, $degree_fields) {
        $required_index = array_search($req_degree, $degree_hierarchy);

        for ($i = $required_index; $i < count($degree_hierarchy); $i++) {
            $current_degree = $degree_hierarchy[$i];
            $current_field = $degree_fields[$current_degree];
            
            if (!empty($opendata_post3[$current_field]) && $opendata_post3[$current_field] !== 'NULL' && trim($opendata_post3[$current_field]) !== '') {
                return true;
            }
        }

        echo 'You are not eligible. ' . $req_degree . ' is required for POST 3.';
        return false;
    }

    // Iterate over post_apply3 (POST 3)
    foreach ($_POST['post_apply3'] as $post3) { 
        // Fetch the post details for POST 3
        $query_age_post3 = "SELECT posts.pid, posts.name, post_details.req_deg, post_details.min, post_details.max 
                      FROM posts
                      INNER JOIN post_details ON posts.pid = post_details.pid 
                      WHERE posts.pid = '".$post3."'";
        $exe_age_post3 = mysqli_query($conn, $query_age_post3);
        $row_age_post3 = mysqli_fetch_array($exe_age_post3);

        // Ensure $row_age_post3 is not empty
        if (!$row_age_post3) {
            echo "Error fetching post details for POST 3 with ID: " . $post3;
            exit();  // Skip this post and continue with the next one
        }

        $req_degree_post3 = $row_age_post3['req_deg'];

        // Check eligibility based on qualifications for POST 3
        if (!is_eligible_post3($req_degree_post3, $opendata_post3, $degree_hierarchy, $degree_fields)) {
            exit();  // If not eligible, skip this post and continue with the next one
        }

        // Continue with age validation for POST 3
        $maxage_post3 = $row_age_post3['max'] + 5;
        $minage_post3 = $row_age_post3['min'];

        // Age validation logic remains unchanged for POST 3
        if ($age >= $minage_post3 && $age < $maxage_post3) {
            $x_post3 = "ok";  // Consider using a unique variable name for POST 3 validation result
        } elseif ($age == $maxage_post3) {
            if (!empty($relax)) {
                $total_relax = max($relax);
                $age = $age - $total_relax;
                $x_post3 = "ok";  // Consider using a unique variable name for POST 3 validation result
            } elseif ($cal_gov_age->m == 0 && $cal_gov_age->d == 0) {
                $x_post3 = "ok";  // Consider using a unique variable name for POST 3 validation result
            } else {
                echo "You are not eligible for the post of " . strtoupper($row_age_post3['name']) . " due to age limit.<br>";
                echo "<br>Your age on Closing date is: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
                echo "<br>Max allowed age limit is: " . $maxage_post3 . " (including 5 years of general relaxation)";
                exit();
            }
        } elseif ($age > $maxage_post3) {
            if (!empty($relax)) {
                $total_relax = max($relax);
                $age = $age - $total_relax;
                if ($age < $maxage_post3) {
                    $x_post3 = "ok";  // Consider using a unique variable name for POST 3 validation result
                } elseif ($age == $maxage_post3 && $cal_gov_age->m == 0 && $cal_gov_age->d == 0) {
                    $x_post3 = "ok";  // Consider using a unique variable name for POST 3 validation result
                } else {
                    echo "You are not eligible for the post of " . strtoupper($row_age_post3['name']) . " due to age limit.<br>";
                    echo "<br>Your age on Closing date is: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
                    echo "<br>Max allowed age limit is: " . $maxage_post3 . " (including 5 years of general relaxation)";
                    exit();
                }
            } else {
                echo "You are not eligible for the post of " . strtoupper($row_age_post3['name']) . " due to age limit.<br>";
                echo "<br>Your age on Closing date is: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
                echo "<br>Max allowed age limit is: " . $maxage_post3 . " (including 5 years of general relaxation)";
                exit();
            }
        } elseif ($age < $minage_post3) {
            echo "You are not eligible for the post of " . strtoupper($row_age_post3['name']) . " due to age limit.<br>";
            echo "<br>Your age on Closing date is: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
            echo "<br>Max allowed age limit is: " . $maxage_post3 . " (including 5 years of general relaxation)";
            exit();
        }
    }
}




}




//---------------------------------POST 3----------------------------------

// if(isset($_POST['post_apply3']))
// {
//     // Fetch the candidate's qualifications
//     $check_pro_enter = "SELECT qualification.matric_title, qualification.primary_title, qualification.middle_title, qualification.inter_title, qualification.bs_title, qualification.bs16_title, qualification.profes_certificate 
//                         FROM qualification 
//                         WHERE said = '$userid'";
//     $pro_check = mysqli_query($conn, $check_pro_enter); 
//     $opendata_post3 = mysqli_fetch_array($pro_check);

//     // Ensure $opendata_post3 is not empty
//     if (!$opendata_post3) {
//         echo "Error fetching qualification data.";
//         exit();
//     }

//     // Define degree hierarchy and fields
//     $degree_hierarchy = ['Primary', 'Middle', 'Matric', 'Inter', 'Bachelors', 'Bachelors16'];
//     $degree_fields = [
//         'Primary' => 'primary_title',
//         'Middle' => 'middle_title',
//         'Matric' => 'matric_title',
//         'Inter' => 'inter_title',
//         'Bachelors' => 'bs_title',
//         'Bachelors16' => 'bs16_title'
//     ];

//     // Define eligibility function
//     function is_eligible($req_degree, $opendata, $degree_hierarchy, $degree_fields) {
//         $required_index = array_search($req_degree, $degree_hierarchy);

//         for ($i = $required_index; $i < count($degree_hierarchy); $i++) {
//             $current_degree = $degree_hierarchy[$i];
//             $current_field = $degree_fields[$current_degree];
            
//             if (!empty($opendata[$current_field]) && $opendata[$current_field] !== 'NULL' && trim($opendata[$current_field]) !== '') {
//                 return true;
//             }
//         }

//         echo 'You are not eligible. ' . $req_degree . ' is required for this post.';
//         return false;
//     }

//     // Iterate over post_apply3 (POST 3)
//     foreach ($_POST['post_apply3'] as $post3) { 
//         // Fetch the post details
//         $query_age = "SELECT posts.pid, posts.name, post_details.req_deg, post_details.min, post_details.max 
//                       FROM posts
//                       INNER JOIN post_details ON posts.pid = post_details.pid 
//                       WHERE posts.pid = '".$post3."'";
//         $exe_age = mysqli_query($conn, $query_age);
//         $row_age = mysqli_fetch_array($exe_age);

//         // Ensure $row_age is not empty
//         if (!$row_age) {
//             echo "Error fetching post details for post ID: " . $post3;
//             continue;  // Skip this post and continue with the next one
//         }

//         $req_degree = $row_age['req_deg'];

//         // Check eligibility based on qualifications for POST 3
//         if (!is_eligible($req_degree, $opendata_post3, $degree_hierarchy, $degree_fields)) {
//             continue;  // If not eligible, skip this post and continue with the next one
//         }

//         // Continue with age validation for POST 3
//         $maxage = $row_age['max'] + 5;
//         $minage = $row_age['min'];

//         // Age validation logic remains unchanged
//         if ($age >= $minage && $age < $maxage) {
//             $x = "ok";
//         } elseif ($age == $maxage) {
//             if (!empty($relax)) {
//                 $total_relax = max($relax);
//                 $age = $age - $total_relax;
//                 $x = "ok";
//             } elseif ($cal_gov_age->m == 0 && $cal_gov_age->d == 0) {
//                 $x = "ok";
//             } else {
//                 echo "You are not eligible for the post of " . strtoupper($row_age['name']) . " due to age limit.<br>";
//                 echo "<br>Your current age: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
//                 echo "<br>Max allowed age limit is: " . $maxage . " (including 5 years of general relaxation)";
//                 exit();
//             }
//         } elseif ($age > $maxage) {
//             if (!empty($relax)) {
//                 $total_relax = max($relax);
//                 $age = $age - $total_relax;
//                 if ($age < $maxage) {
//                     $x = "ok";
//                 } elseif ($age == $maxage && $cal_gov_age->m == 0 && $cal_gov_age->d == 0) {
//                     $x = "ok";
//                 } else {
//                     echo "You are not eligible for the post of " . strtoupper($row_age['name']) . " due to age limit.<br>";
//                     echo "<br>Your current age: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
//                     echo "<br>Max allowed age limit is: " . $maxage . " (including 5 years of general relaxation)";
//                     exit();
//                 }
//             } else {
//                 echo "You are not eligible for the post of " . strtoupper($row_age['name']) . " due to age limit.<br>";
//                 echo "<br>Your current age: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
//                 echo "<br>Max allowed age limit is: " . $maxage . " (including 5 years of general relaxation)";
//                 exit();
//             }
//         } elseif ($age < $minage) {
//             echo "You are not eligible for the post of " . strtoupper($row_age['name']) . " due to age limit.<br>";
//             echo "<br>Your current age: " . $age . " Years " . $cal_gov_age->m . " Months " . $cal_gov_age->d . " Days<br>";
//             echo "<br>Max allowed age limit is: " . $maxage . " (including 5 years of general relaxation)";
//             exit();
//         }
//     }
// }



   
// -----------------------------age relaxation ends--------------------	
$value = explode(",", $list);    
$delsql = "DELETE FROM `details` WHERE d_said= '$userid'";
    $exesql = mysqli_query($conn, $delsql);
foreach ($value as $item)
{
    $insertsql = "INSERT INTO `details`(`d_said`,`d_postid`,`d_status`) VALUES ('$userid','$item','Pending')";
    $exeinsert=mysqli_query($conn,$insertsql);
}
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