<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  $lecidx = $_POST['lecidx'];
  $clidx = $_POST['clidx'];
  $sql = "DELETE FROM lms_lec WHERE lecidx='{$lecidx}'";

  $response = array('success' => false);

  if ($mysqli->query($sql) === true) {
    $response['success'] = true;
    $response['clidx'] = $clidx;
  } 

  echo json_encode($response);
  $mysqli->close();

?>
