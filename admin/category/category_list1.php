<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  ini_set('display_errors','1');

  $cate2 = $_POST['cate2'];
  $query = "SELECT * from lms_category where cate_step=2 and cate_code='{$cate2}'";
  $result = $mysqli -> query($query) or die("query error =>".$mysqli->error);
  
  while($rs = $result -> fetch_object()){
    $cate1 = $rs->cate_pcode ;
  }

  $query = "SELECT * from lms_category where cate_step=1 and cate_code='{$cate1}'";
  $result = $mysqli -> query($query) or die("query error =>".$mysqli->error);

  while($rs = $result -> fetch_object()){
    $cate1name = $rs->cate_name ;
  }
  echo $cate1name;

?>