<?php 
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/db.php";

    error_reporting( E_ALL );
    ini_set( "display_errors", 1 );

    $clidx = $_POST['clidx'];
    $cls_cate=$_POST["cate1"].$_POST["cate2"].$_POST["cate3"]; //카테고리
    $cls_cate_big=$_POST["cate1"]; //카테고리 대분류
    $cls_cate_mid=$_POST["cate2"]; //카테고리 중분류
    $cls_cate_sm=$_POST["cate3"]; //카테고리 소분류
    $cls_title = $_POST['cls_title']; //강의명
    $cls_price_option = $_POST['cls_price_option']; //가격옵션
    $cls_price = $_POST['cls_price']; //금액
    $cls_recom=$_POST["cls_recom"] ?? 0; //추천
    $cls_basic=$_POST["cls_basic"] ?? 0; //초급
    $cls_inter=$_POST["cls_inter"] ?? 0; //중급
    $cls_adv=$_POST["cls_adv"] ?? 0; //중급
    $cls_text=$_POST["cls_text"] ; // 강의설명
    $cls_thumb=$_POST["cls_thumb"] ; // 썸네일

    //썸네일 이미지
    if($_FILES['cls_thumb']['name']){
        if($_FILES['cls_thumb']['size']>10240000){
            echo "<script>
                alert('10Mb 이하만 첨부 가능합니다.');
                history.back();
            </script>";
            exit;
        }

        if($_FILES['cls_thumb']['type'] != 'image/png' and $_FILES['cls_thumb']['type'] != 'image/gif' and $_FILES['cls_thumb']['type'] != 'image/jpeg'){ 
            echo "<script>
                alert('이미지만 첨부 가능합니다.');
                history.back();
            </script>";
            exit;
        }

        $save_dir = $_SERVER['DOCUMENT_ROOT']."/ksv_lms/data/class_thumb/"; 
        $filename = $_FILES['cls_thumb']['name'];
        $ext = pathinfo($filename,PATHINFO_EXTENSION); //확장자
        $newfilename = $cls_title.date("Ymd").substr(rand(),0,6);
        $savefile = $newfilename."_thumb.".$ext; 

        if(move_uploaded_file($_FILES['cls_thumb']['tmp_name'], $save_dir.$savefile)){
            $savefile = "/data/class_thumb/".$savefile;
        } else{
            echo "<script>
                    alert('이미지를 등록할 수 없습니다. 관리자에게 문의해주세요.');
                    history.back();
                </script>";
            exit;
        }
    }

    $sql = "UPDATE lms_class SET 
    cls_title='{$cls_title}', 
    cls_text='{$cls_text}', 
    cls_cate ='{$cls_cate}', 
    cls_cate_big ='{$cls_cate_big}', 
    cls_cate_mid ='{$cls_cate_mid}', 
    cls_cate_sm ='{$cls_cate_sm}', 
    cls_recom ='{$cls_recom}', 
    cls_basic ='{$cls_basic}', 
    cls_inter ='{$cls_inter}', 
    cls_adv ='{$cls_adv}', 
    cls_price_option ='{$cls_price_option}', 
    cls_price ='{$cls_price}', 
    cls_thumb ='{$savefile}' 
    WHERE clidx='{$clidx}'";

    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);

    if($result){
        echo "<script>
        alert('강좌 수정 성공');
        location.replace('class_view.php?clidx={$clidx}');
        </script>";
    }else{
        echo "<script>
        alert('강좌 수정 실패'); history.back();
        </script>";
        exit;
    }
?>