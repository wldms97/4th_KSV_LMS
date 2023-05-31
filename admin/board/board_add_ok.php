<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";
    
    $b_title = $_POST['b_title'];
    $b_content = $_POST['b_content'];
    $b_regdate = date('Y-m-d');
    $adminname = $_POST['adminname'];

    // if($_FILES['b_img']){
    //     $file_orgname = mysqli_real_escape_string($mysqli, $_FILES['b_img']['name']); //$Files의 값 확인
    //     $tmpfile_path = $_FILES['b_img']['tmp_name']; //$Files의 경로 확인

    //     if($_FILES['b_img']['type'] != 'image/png' and $_FILES['b_img']['type'] != 'image/gif' and $_FILES['b_img']['type'] != 'image/jpeg'){
    //         $return_data = array("result"=>"image");
    //     }

    //     $upload_path = "./board_files/".$file_orgname;
    //     move_uploaded_file($tmpfile_path, $upload_path);
    // }


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


    $sql = "INSERT INTO lms_board (b_title, b_regdate, b_content, adminname, b_img) VALUES ('{$b_title}','{$b_regdate}','{$b_content}', '{$adminname}', '{$savefile}')";

    $result = $mysqli -> query($sql) or die("Query Error! => ".$mysqli->error);

    if($result){
        echo "<script>
        alert('공지사항이 등록되었습니다.');
        location.href = 'board_list.php';</script>";
    }else{
        echo "<script>
        alert('공지사항 등록에 실패했습니다.');
        history.back();</script>";
    }
?>