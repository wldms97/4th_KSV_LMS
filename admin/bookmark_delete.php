<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

    ini_set( 'display_errors', '1' );

    $name = $_POST['value'];

    $sql = "UPDATE lms_management SET m_bookmark=0 WHERE m_title='{$name}'";
    $result=$mysqli->query($sql) or die($mysqli->error);
?>