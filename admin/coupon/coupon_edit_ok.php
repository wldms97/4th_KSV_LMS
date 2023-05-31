<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
    ini_set( 'display_errors', '0' );

    $cno = $_POST['couidx'];

$coupon_name=$_POST['cou_name'];
$coupon_type=$_POST['cou_type'];
$coupon_min_price=$_POST['cou_min_price'];
if($coupon_type==1){
    $coupon_price=$_POST['cou_discount'];
    $coupon_ratio='null';
}else{
    $coupon_ratio=$_POST['cou_discount'];
    $coupon_price='null';
}
$coupon_passive=$_POST['cou_passive'];
$coupon_status=$_POST['cou_status'];
if($_POST['date_limit']==1){
    $regdate=$_POST['cou_regdate'];
    $duedate=$_POST['cou_duedate'];
    $coupon_regdate=json_encode($regdate);
    $coupon_duedate=json_encode($duedate);
}else{
    $coupon_regdate='null';
    $coupon_duedate='null';
}
//NULL값은 문자열로 넘겨야하고, 받아오는 date값 역시 문자열로 넘겨야해서 "NULL", json_encode로 문자열로 통일

$sql="UPDATE lms_coupon set cou_name='{$coupon_name}',cou_min_price={$coupon_min_price},cou_type={$coupon_type},cou_price={$coupon_price},cou_ratio={$coupon_ratio},cou_regdate={$coupon_regdate},cou_duedate={$coupon_duedate},cou_passive={$coupon_passive},cou_status={$coupon_status} where couidx={$cno}";
// print_r($sql);
// print_r($_POST['date_limit']);
$result = $mysqli->query($sql) or die($mysqli->error);

echo "<script>alert('수정되었습니다.');location.href='coupon_list.php';</script>";