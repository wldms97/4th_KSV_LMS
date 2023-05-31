<?php
session_start();
include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
// include $_SERVER["DOCUMENT_ROOT"]."/ksv_lms/admin/inc/coupon_lib.php";

//넘어온 값을 변수 지정
$userid = $_POST["userid"];
$userpw = $_POST["userpw"];
$userpw = hash('sha512',$userpw);
$username = $_POST["username"];
$userphone = $_POST["userphone"];
$useremail = $_POST["useremail"];
$uregdate = date('Y-m-d');
$user_st = 1;
$super = 0;
$user_profile = $_POST["user_profile"];
$cate_like1 = $_POST["cate_like1"];
$cate_like2 = $_POST["cate_like2"];
$user_ability = $_POST["user_ability"];
$use_agree = 1;
$personalinfo_agree = 1;
$marketing_agree = $_POST["marketing_agree"] ?? 0;

if($_FILES['user_profile']['name']){
  if($_FILES['user_profile']['size']>10240000){
      echo "<script>
          alert('10Mb 이하만 첨부 가능합니다.');
          history.back();
      </script>";
      exit;
  }

  if($_FILES['user_profile']['type'] != 'image/png' and $_FILES['user_profile']['type'] != 'image/gif' and $_FILES['user_profile']['type'] != 'image/jpeg'){ 
    echo "<script>
      alert('이미지만 첨부 가능합니다.');
      history.back();
    </script>";
    exit;
  }

  $save_dir = $_SERVER['DOCUMENT_ROOT']."/ksv_lms/data/member_profile/"; 
  $filename = $_FILES['user_profile']['name'];
  $ext = pathinfo($filename,PATHINFO_EXTENSION); //확장자
  $newfilename = date("Ymd").substr(rand(),0,6);
  $savefile = $newfilename.$ext; 

  if(move_uploaded_file($_FILES['user_profile']['tmp_name'], $save_dir.$savefile)){
    $savefile = "/data/member_profile/".$savefile;
  } else{
    echo "<script>
      alert('이미지를 등록할 수 없습니다. 관리자에게 문의해주세요.');
      history.back();
    </script>";
    exit;
  }
}

//쿼리 작성 실행
$mysqli->autocommit(FALSE);

try {
  //회원가입
  $query="INSERT INTO lms_user
  (userid, userpw, username, userphone, useremail, uregdate, user_st, super, user_profile, cate_like1, cate_like2, user_ability, use_agree, personalinfo_agree, marketing_agree)
  VALUES('".$userid."'
  , '".$userpw."'
  , '".$username."'
  , '".$userphone."'
  , '".$useremail."'
  , '".$uregdate."'
  , '".$user_st."'
  , '".$super."'
  , '".$file_orgname."'
  , '".$cate_like1."'
  , '".$cate_like2."'
  , '".$user_ability."'
  , '".$use_agree."'
  , '".$personalinfo_agree."'
  , '".$marketing_agree."'
  )";

  $rs1=$mysqli->query($query) or die($mysqli->error);

  // lms_user_coupon($userid, 1, '회원가입');
      
  $mysqli->commit();//디비에 커밋한다.

  echo "<script>alert('회원가입 성공!');
  location.href='/ksv_lms/user/member/login.php';</script>";
  exit;
}catch (Exception $e) {
  $mysqli->rollback();
  echo "<script>alert('회원가입 실패!');history.back();</script>";
  exit;
}

?>