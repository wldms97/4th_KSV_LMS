<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );

    if(!$_SESSION['AID']){
      $return_data = array("result"=>"member");
      echo json_encode($return_data); 
      exit;       
    };

    if($_FILES['savefile']['size']> 10240000){
      $return_data = array("result"=>"size");
      echo json_encode($return_data);  
      exit;
    }

    if($_FILES['savefile']['type'] != 'image/png' and $_FILES['savefile']['type'] != 'image/gif' and $_FILES['savefile']['type'] != 'image/jpeg'){
      $return_data = array("result"=>"image");
      echo json_encode($return_data);  
      exit;
    }

    $save_dir = $_SERVER['DOCUMENT_ROOT']."/data/";
    $filename = $_FILES['savefile']['name'];
    $ext = pathinfo($filename,PATHINFO_EXTENSION); //확장자
    $newfilename = iconv_substr($filename,0,7).date("YmdHis").substr(rand(),0,6);
    $savefile = $newfilename.'.'.$ext;

    if(move_uploaded_file($_FILES['savefile']['tmp_name'], $save_dir.$savefile)){
      $sql = "INSERT into lms_class_img (adminid, filename) 
              VALUES ('{$_SESSION['AID']}','{$savefile}')";
      $result = $mysqli -> query($sql);
      $imgid = $mysqli -> insert_id;

      $return_data = array("result"=>"success","imgid"=>$imgid,"savename"=>$savefile);
      echo json_encode($return_data);
      exit;
    }else{
      $return_data = array("result"=>"error");
      echo json_encode($return_data);
      exit;
    }
    
?>