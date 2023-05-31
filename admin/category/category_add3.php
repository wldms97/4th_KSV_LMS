<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  $cate2 = $_POST['cate2'];
  $html = "<option value=\"\">소분류</option>";
  $query = "SELECT * from lms_category where cate_step=3 and cate_pcode='{$cate2}'";
  $result = $mysqli -> query($query) or die("query error =>".$mysqli->error);

  while($rs = $result->fetch_object()){
    $rsc[] = $rs;
  }

  foreach($rsc as $r){ // $rsc[] 배열을 foreach문으로 반복 처리
    $html .= "<option value=\"".$r->cate_code."\">".$r->cate_name."</option>";
  }
  echo $html;
?>