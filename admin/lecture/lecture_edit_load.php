<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );

  $postdata = file_get_contents("php://input");
  $request = json_decode($postdata);
  $lecidx = $request->lecidx;

  $que= "SELECT * FROM lms_lec WHERE lecidx='$lecidx'";
  $raw = $mysqli ->query($que) or die("query_error".$mysqli->error);
  $row = $raw -> fetch_object();

  $que1 = "SELECT * FROM lms_timestamp WHERE ts_lecidx = '$lecidx' ORDER BY tsidx ASC";
  $raw1 = $mysqli -> query($que1) or die("query_error".$mysqli->error);
  $row1 = array();
  while($raw1_obj = $raw1->fetch_object()){
    $row1[] = $raw1_obj;
  };

  if ($row) {
    if ($row1) {
      $row->row1 = $row1;
      $data = $row;
    } else {
      $data = $row;
    }
  } else {
    $data = array(
      'result' => 'error',
      'massage' => '실패',
    );
  }
  echo json_encode($data);

?>