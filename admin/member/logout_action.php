<?php
  session_start();
  $result = session_destroy();

  if($result){
?>
  <script>
    alert('로그아웃 되었습니다');
    location.replace('/ksv_lms/admin/member/login.php');
  </script>
<?php
}
?>