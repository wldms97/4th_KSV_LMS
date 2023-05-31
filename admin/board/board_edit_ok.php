<?php 
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );

    $bidx = $_POST['bidx'];
    $b_title = $_POST['b_title'];
    $b_content = $_POST['b_content'];
    $b_regdate = date('Y-m-d');
    
    //썸네일 이미지
    if($_FILES['b_img']['name']){
        if($_FILES['b_img']['size']>10240000){
            echo "<script>
                alert('10Mb 이하만 첨부 가능합니다.');
                history.back();
            </script>";
            exit;
        }

        if($_FILES['b_img']['type'] != 'image/png' and $_FILES['b_img']['type'] != 'image/gif' and $_FILES['b_img']['type'] != 'image/jpeg'){ 
            echo "<script>
                alert('이미지만 첨부 가능합니다.');
                history.back();
            </script>";
            exit;
        }

        $save_dir = $_SERVER['DOCUMENT_ROOT']."/ksv_lms/data/board_img/"; 
        $filename = $_FILES['b_img']['name'];
        $ext = pathinfo($filename,PATHINFO_EXTENSION); //확장자
        $newfilename = $b_title.date("Ymd").substr(rand(),0,6);
        $savefile = $newfilename."_img.".$ext; 

        if(move_uploaded_file($_FILES['b_img']['tmp_name'], $save_dir.$savefile)){
            $savefile = "/data/board_img/".$savefile;
        } else{
            echo "<script>
                    alert('이미지를 등록할 수 없습니다. 관리자에게 문의해주세요.');
                    history.back();
                </script>";
            exit;
        }
    }

    $sql = "UPDATE lms_board SET b_title='{$b_title}', b_content='{$b_content}', b_regdate ='{$b_regdate}', b_img ='{$savefile}' WHERE bidx='{$bidx}'";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);

    if($result){
        echo "<script>
        alert('공지사항 수정 성공');
        location.replace('board_view.php?bidx={$bidx}');
        </script>";
    }else{
        echo "<script>
        alert('공지사항 수정 실패');
        location.replace('board_edit.php?bidx={$bidx}');
        </script>";
    }
?>
