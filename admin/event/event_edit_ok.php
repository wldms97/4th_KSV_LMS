<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
    ini_set( 'display_errors', '0' );

$eno = $_POST['eidx'];

$sql="SELECT * from lms_event WHERE eidx={$eno}";
$result=$mysqli->query($sql);
$row = $result->fetch_assoc();

$ev_title=$_POST['ev_title'];
$ev_content_text=$_POST['ev_content_text'];
$couidx=$_POST['couidx'];

$save_dir = $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/uploadImg/event/";
if($_POST['thumbChange'] == 1){
    $filename1 = $_FILES["ev_thumb"]["name"];
    $ext1 = pathinfo($filename1,PATHINFO_EXTENSION);//확장자 구하기
    $newfilename = date("YmdHis").substr(rand(),0,6);
    $upfile1 = $newfilename."_thumb.".$ext1;//새로운 파일이름과 확장자를 합친다
}else{
    $upfile1 = $row['ev_thumb'];
}
if($_POST['contChange'] == 1){
    $filename2 = $_FILES["ev_content_img"]["name"];
    $ext2 = pathinfo($filename2,PATHINFO_EXTENSION);//확장자 구하기
    $upfile2 = $newfilename."_content.".$ext2."";//새로운 파일이름과 확장자를 합친다
}else{
    $upfile2 = $row['ev_content_img'];
}

if(move_uploaded_file($_FILES["ev_thumb"]["tmp_name"], $save_dir.$upfile1)){//파일 등록에 성공하면 디비에 등록해준다.
    $sql="UPDATE lms_event_img_thumb set
    filename='{$upfile1}' WHERE eidx={$eno}";
    $result=$mysqli->query($sql) or die($mysqli->error);
}
if(move_uploaded_file($_FILES["ev_content_img"]["tmp_name"], $save_dir.$upfile2)){//파일 등록에 성공하면 디비에 등록해준다.
    $sql="UPDATE lms_event_img_cont set
    filename='{$upfile2}' WHERE eidx={$eno}";
    $result=$mysqli->query($sql) or die($mysqli->error);
}

$query="UPDATE lms_event set ev_thumb='{$upfile1}',ev_title='{$ev_title}',ev_content_img='{$upfile2}',couidx='{$couidx}' WHERE eidx='{$eno}'";

$rs=$mysqli->query($query) or die($mysqli->error);

$mysqli->commit();//디비에 커밋한다.


echo "<script>alert('수정되었습니다.');location.href='event_list.php';</script>";
exit;