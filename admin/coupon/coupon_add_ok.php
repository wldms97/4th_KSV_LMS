<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
    ini_set( 'display_errors', '0' );

$coupon_name=$_POST['cou_name'];
$coupon_type=$_POST['cou_type'];
$coupon_min_price=$_POST['cou_min_price'];
if($coupon_type==1){
    $coupon_price=$_POST['cou_discount'];
    $coupon_ratio="NULL";
}else{
    $coupon_ratio=$_POST['cou_discount'];
    $coupon_price="NULL";
}
$regdate=$_POST['cou_regdate'];
$duedate=$_POST['cou_duedate'];
$coupon_passive=$_POST['cou_passive'];
$coupon_status=$_POST['cou_status'];
if($_POST['date_limit']==1){
    $coupon_regdate=json_encode($regdate);
    $coupon_duedate=json_encode($duedate);
}else{
    $coupon_regdate="NULL";
    $coupon_duedate="NULL";
}
//NULL값은 문자열로 넘겨야하고, 받아오는 date값 역시 문자열로 넘겨야해서 "NULL", json_encode로 문자열로 통일

$sql="INSERT INTO lms_coupon (cou_name,cou_min_price,cou_type,cou_price,cou_ratio,cou_regdate,cou_duedate,cou_passive,cou_status) VALUES ('{$coupon_name}','{$coupon_min_price}',{$coupon_type},{$coupon_price},{$coupon_ratio},{$coupon_regdate},{$coupon_duedate},'{$coupon_passive}','{$coupon_status}')";

$result = $mysqli->query($sql) or die($mysqli->error);

echo "<script>alert('등록되었습니다.');location.href='coupon_list.php';</script>";