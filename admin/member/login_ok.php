<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  $adminid = $_POST["adminid"];
  $adminpw = $_POST["adminpw"];
  $adminpw = hash('sha512',$adminpw);

  $sql = "SELECT * from lms_admin where adminid='{$adminid}' and adminpw='{$adminpw}'";
  $result = $mysqli -> query($sql);
  $rs = $result ->fetch_object();

  if($rs){
    $sql = "UPDATE lms_admin set last_login=now() where idx = '{$rs->aidx}'";
    $result = $mysqli -> query($sql);

    // rs에 super값이 1이냐 아니냐에 따라 if문 작성
    if($rs->super == 1){
      $_SESSION['AID'] = $rs->adminid;
      $_SESSION['ANAME'] = $rs->adminname;
      echo "<script>
        alert('".$rs->adminname."님 어서오세요');
        location.href='/ksv_lms/admin/dashboard.php';
      </script>";
      exit;
    }else{
      $_SESSION['UID'] = $rs->userid;
      $_SESSION['UNAME'] = $rs->username;
      echo "<script>
        alert('".$rs->username." 님 어서오세요');
        location.href='/ksv_lms/index.html';
      </script>";
    }
  }else{
    echo "<script>
      alert('아이디 또는 암호가 일치하지 않습니다.');
      history.back();
    </script>";
    exit;
  }
 
?>