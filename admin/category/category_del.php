<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  $cateidx = $_POST['cateidx'];
  $sql = "DELETE from lms_category WHERE cateidx='".$cateidx."'"; 
  $result = $mysqli -> query($sql) or die("query Error! =>".$mysqli->error);

  if($result){
    $data = array('result' => true);
  } else{
    $data = array('result' => false);
  }

  echo json_encode($data);

?>