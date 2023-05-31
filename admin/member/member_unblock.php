<?php 
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
  
  $uidx = $_GET['uidx'];
  $user_st = $_POST['user_st'];
  $sql = "UPDATE lms_user SET user_st=1 where uidx=".$uidx;
  $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
  
  if($result){
    echo "<script>
    alert('차단 해제 성공');
    location.replace('member_main.php');
    </script>";
  }else{
    echo "<script>
    alert('차단 해제 실패');
    history.back();
    </script>";
  }
?>