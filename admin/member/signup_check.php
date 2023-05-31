<?php
  include $_SERVER["DOCUMENT_ROOT"]."/ksv_lms/admin/inc/db.php";

  //넘어온 값을 변수 지정
  $userid=$_POST["userid"];

  $sql = "SELECT COUNT(*) AS cnt FROM lms_user WHERE userid='".$userid."'";
  $result = $mysqli -> query($sql) or die("query error=>".$mysqli->error);
  $rs = $result -> fetch_object();

  $data = array("cnt"=>$rs->cnt);
  echo json_encode($data);

?>