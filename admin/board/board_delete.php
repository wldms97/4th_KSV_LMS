<?php 
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

    $bidx = $_POST['bidx'];
    $sql = "DELETE FROM lms_board where bidx='{$bidx}'";

    if($mysqli -> query($sql) === true){
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $mysqli->error]);
    }
?>