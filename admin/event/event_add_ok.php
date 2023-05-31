<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
    ini_set( 'display_errors', '0' );

$ev_title=$_POST['ev_title'];
$ev_content_text=$_POST['ev_content_text'];
$couidx=$_POST['couidx'];

$save_dir = $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/uploadImg/event/";
$filename1 = $_FILES["ev_thumb"]["name"];
$filename2 = $_FILES["ev_content_img"]["name"];
$ext1 = pathinfo($filename1,PATHINFO_EXTENSION);//확장자 구하기
$ext2 = pathinfo($filename2,PATHINFO_EXTENSION);//확장자 구하기
$newfilename = date("YmdHis").substr(rand(),0,6);
$upfile1 = $newfilename."_thumb.".$ext1;//새로운 파일이름과 확장자를 합친다
$upfile2 = $newfilename."_content.".$ext2."";//새로운 파일이름과 확장자를 합친다

$ev_idx = $mysqli -> insert_id;

if(move_uploaded_file($_FILES["ev_thumb"]["tmp_name"], $save_dir.$upfile1)){//파일 등록에 성공하면 디비에 등록해준다.
    $sql="INSERT INTO lms_event_img_thumb
    (eidx, filename)
    VALUES(".$ev_idx.", '".$upfile1."')";
    $result=$mysqli->query($sql) or die($mysqli->error);
}
if(move_uploaded_file($_FILES["ev_content_img"]["tmp_name"], $save_dir.$upfile2)){//파일 등록에 성공하면 디비에 등록해준다.
    $sql="INSERT INTO lms_event_img_cont
    (eidx, filename)
    VALUES(".$ev_idx.", '".$upfile2."')";
    $result=$mysqli->query($sql) or die($mysqli->error);
}

$query="INSERT INTO lms_event
(ev_thumb, ev_title, ev_content_img, ev_content_text, couidx)
VALUES('".$upfile1."'
, '".$ev_title."'
, '".$upfile2."'
, '".$ev_content_text."'
, '".$couidx."'
)";

$rs=$mysqli->query($query) or die($mysqli->error);

$mysqli->commit();//디비에 커밋한다.


echo "<script>alert('등록되었습니다.');location.href='event_list.php';</script>";
exit;