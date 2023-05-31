<?php
  session_start();
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

  if(!$_SESSION['AID']){
    echo "<script>
        alert('접근 권한이 없습니다');
        location.href = '../member/login.php';
    </script>";
  };

  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );

  $clidx=$_GET["clidx"];
  $lec_title=$_POST["lec_title"];
  $lec_url=$_POST["lec_url"];
  $lec_text=rawurldecode($_POST["lec_text"]);
  $lec_thumb=$_POST["lec_thumb"];

  if($_FILES['lec_thumb']['name']){
    if($_FILES['lec_thumb']['size']>10240000){
        echo "<script>
            alert('10Mb 이하만 첨부 가능합니다.');
            history.back();
        </script>";
        exit;
    }

    if($_FILES['lec_thumb']['type'] != 'image/png' and $_FILES['lec_thumb']['type'] != 'image/gif' and $_FILES['lec_thumb']['type'] != 'image/jpeg'){ 
      echo "<script>
        alert('이미지만 첨부 가능합니다.');
        history.back();
      </script>";
      exit;
    }

    $save_dir = $_SERVER['DOCUMENT_ROOT']."/ksv_lms/data/lec_thumb/"; 
    $filename = $_FILES['lec_thumb']['name'];
    $ext = pathinfo($filename,PATHINFO_EXTENSION); //확장자
    $newfilename = date("Ymd").substr(rand(),0,6);
    $savefile = $newfilename.$ext; 

    if(move_uploaded_file($_FILES['lec_thumb']['tmp_name'], $save_dir.$savefile)){
      $savefile = "/data/lec_thumb/".$savefile;
    } else{
      echo "<script>
        alert('이미지를 등록할 수 없습니다. 관리자에게 문의해주세요.');
        history.back();
      </script>";
      exit;
    }
  }

  $sql = "INSERT INTO lms_lec(lec_clsidx, lec_title, lec_url, lec_text, lec_thumb) VALUE ('{$clidx}','{$lec_title}','{$lec_url}','{$lec_text}','{$savefile}')";
  $result = $mysqli -> query($sql) or die($mysqli -> error);
  $lecidx = $mysqli->insert_id;

  if($_REQUEST['ts_min'] && $stp_second = $_REQUEST['ts_sec'] && $ts_desc = $_REQUEST['ts_desc']){
    $ts_min = $_REQUEST['ts_min'];
    $ts_sec = $_REQUEST['ts_sec'];
    $ts_desc = $_REQUEST['ts_desc'];
    $i=0;
    foreach($ts_desc as $td){
      if($td){
      $tque = "INSERT INTO lms_timestamp (ts_lecidx, ts_min, ts_sec, ts_desc)
      VALUES ('$lecidx', '{$ts_min[$i]}', '{$ts_sec[$i]}', '{$ts_desc[$i]}')";
      $tresult = $mysqli -> query($tque) or die('query error'.$mysqli->error);
      }
      $i++;
    }
  }

    echo "<script>alert('등록되었습니다'); location.href='../class/class_view.php?clidx=$clidx'</script>";

?>