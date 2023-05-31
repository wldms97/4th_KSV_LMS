<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  $lecidx = $_POST['lecidx'];

  $que = "SELECT * FROM lms_timestamp WHERE ts_lecidx ='$lecidx'";
  $res = $mysqli->query($que) or die("query_error".$mysqli->error);

  $resp = array();
  while($obg = $res->fetch_object()){
    $resp[] =  array('lecidx' => $obg->lec_clsidx, 'mn'=>$obg->ts_min, 'sc'=>$obg->ts_sec,'ds'=>$obg->ts_desc);
  }
  echo json_encode($resp);

?> 