<?php 
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

    $clidx = $_POST['clidx'];
    $sql = "DELETE FROM lms_class where clidx='{$clidx}'";

    if($mysqli -> query($sql) === true){
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
    }
?>