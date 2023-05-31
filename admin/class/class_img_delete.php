<?php 
    session_start();
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );

    if(!$_SESSION['AID']){
      $return_data = array("result" => "member");
      echo json_encode($return_data);
      exit;
    }

    $imgid = $_POST['imgidx'];
    $sql = "SELECT * from lms_class_img where imgidx='".$imgid."' ";
    $result = $mysqli -> query($sql);
    $rs = $result -> fetch_object();
    
    if($rs->adminid != $_SESSION['AID']){
    $return_data = array("result"=>"my");
    echo json_encode($return_data);
    exit;
    }

    $sql = "UPDATE lms_class_img set status=0 where imgidx='{$imgid}'";
    $result = $mysqli -> quey($sql);

    if($result){
      $delete_file = $_SERVER['DOCUMENT_ROOT']."/data/".$rs->filename;
      unlink($delete_file); //파일 삭제
      $return_data = array("result"=>"ok");
      echo json_encode($return_data);
    }else{
      $return_data = array("result"=>"no");
      echo json_encode($return_data);
    }
?>