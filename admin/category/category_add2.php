<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  $cate1 = $_POST['cate1'];
  $html = "<option value=\"\">중분류</option>";
  $query = "SELECT * from lms_category where cate_step=2 and cate_pcode='{$cate1}'";
  $result = $mysqli -> query($query) or die("query error =>".$mysqli->error);

  while($rs = $result->fetch_object()){
    $rsc[] = $rs;
  }

  foreach($rsc as $r){ // $rsc[] 배열을 foreach문으로 반복 처리
    $html .= "<option value=\"".$r->cate_code."\">".$r->cate_name."</option>";
  }
  echo $html;
?>