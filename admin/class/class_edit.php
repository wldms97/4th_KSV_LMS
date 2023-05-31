<?php
  session_start();
  $_SESSION['TITLE'] = "강좌 수정";
  
  if(!$_SESSION['AID']){
    echo "<script>
            alert('접근 권한이 없습니다');
            location.href = '../member/login.php';
        </script>";
  };
  
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/class/class_add_edit.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

    //카테고리 select
    $sql = "SELECT * FROM lms_category WHERE cate_step=1";
    $result = $mysqli -> query($sql) or die("Query error! =>".$mysqli-->error);
    while($rs = $result -> fetch_object()){
        $cate1[]=$rs;
    }

    //lms_class SELECT구문
    $clidx = $_GET['clidx'];
    $sql = "SELECT * from lms_class where clidx='{$clidx}'"; 
    $result = $mysqli -> query($sql) or die("Query Error ! => ".$mysqli -> error);
    $r = $result->fetch_object();
?>

      <main class="main_container content_pd">
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h2 class="main_tt pre_bold_l">강좌 수정</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo">
        </div>
        <form action="class_edit_ok.php" method="post" enctype="multipart/form-data">
            <!-- <input type="hidden" id="file_table_id" name="file_table_id" value=""> -->
            <input type="hidden" id="clidx" name="clidx" value="<?= $clidx; ?>">
            <div class="select_category">
                <h3 class="pre_bold_m">카테고리 선택</h3>
                <label for="select_category" class="hidden"></label>
                <div class="classification pre_rg_s d-flex justify-content-between gap-3">
                    <select class="col" id="cate1" name="cate1">
                      <option disabled selected>대분류</option>
                      <?php 
                        foreach($cate1 as $c){
                      ?>
                        <option value="<?php echo $c->cate_code; ?>"><?php echo $c->cate_name; ?></option>
                      <?php
                        }
                      ?>
                    </select>
                    <select class="col" id="cate2" name="cate2">
                      <option disabled selected>중분류</option>
                    </select>
                    <select class="col" id="cate3" name="cate3">
                      <option disabled selected>소분류</option>
                    </select>
                </div>
            </div>
            <h3 class="pre_bold_m">강좌명</h3>
            <div class="cls_title">
                <input type="text" id="cls_title" name="cls_title" class="pre_rg_s" required placeholder="강좌명을 입력하세요." value="<?php echo $r->cls_title; ?>">
            </div>
            <div class="about_price d-flex justify-content-between gap-3">
                <div class="cls_price_option col">
                    <h3 class="pre_bold_m">가격옵션</h3>
                    <select name="cls_price_option" id="cls_price_option" >
                        <option disabled selected>가격옵션</option>
                        <option value="무료">무료</option>
                        <option value="유료">유료</option>
                      </select>
                </div>
                <div class="cls_price col">
                    <h3 class="pre_bold_m">가격</h3>
                    <label for="cls_price" class="hidden"></label>
                    <input type="text" id="cls_price" name="cls_price" class="pre_rg_s col" required placeholder=" 원" value="<?php echo number_format($r->cls_price); ?>">
                </div>
            </div>
            <h3 class="pre_bold_m">강좌옵션</h3>
            <div class="lecture_option pre_rg_s d-flex justify-content-between align-items-center gap-3">
                <input type="checkbox" name="cls_recom" id="cls_recom" value="1" <?php if($r->cls_recom){echo "checked";}?> class="col">
                <label for="cls_recom" class="col">추천</label>
                <input type="checkbox" name="cls_basic" id="cls_basic" value="1" <?php if($r->cls_basic){echo "checked";}?> class="col">
                <label for="cls_basic" class="col">초급</label>
                <input type="checkbox" name="cls_inter" id="cls_inter" value="1" <?php if($r->cls_inter){echo "checked";}?> class="col">
                <label for="cls_inter" class="col">중급</label>
                <input type="checkbox" name="cls_adv" id="cls_adv" value="1" <?php if($r->cls_adv){echo "checked";}?> class="col">
                <label for="cls_adv" class="col">고급</label>
            </div>
            <div class="cls_text">
                <h3 class="pre_bold_m">강좌설명</h3>
                <label for="cls_text" class="hidden"></label>
                <textarea id="cls_text" name="cls_text" class="pre_rg_s" cols="30" rows="10" required placeholder="강좌설명을 입력하세요."><?php echo $r->cls_text; ?></textarea>
            </div>
            <div class="cls_thumb">
                <h3 class="pre_bold_m">썸네일 이미지</h3>
                <div class="d-flex justify-content-between gap-3">
                  <label for="cls_thumb" class="pre_rg_m">파일선택</label>
                  <input type="file" id="cls_thumb" name="cls_thumb">
                  <input class="file_name" id="cls_thumb" name="cls_thumb" value="<?php echo $r->cls_thumb; ?>" >
                </div>
            </div>
            <div class="btns d-flex justify-content-end gap-3">
              <button type="submit" class="btn_m_pc pre_rg_m">강좌 수정</button>
              <button type="button" class="btn_m_sc pre_rg_m" onclick="location.href='class_list.php'">취소</button>
            </div>
        </form>
      </main>
    </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
<script src="../js/class/class.js"></script>
<script>
  //cate1 대분류
  $("#cate1").change(function () {
    let cate1 = $(this).val();
    let data = {
      cate1: cate1
    };
    $.ajax({
      async: false,
      type: "post",
      data: data,
      url: "../category/category_add2.php",
      dataType: "html",
      success: function (return_data) {
        $("#cate2").html(return_data);
      }
    });
  });
  //cate2 중분류
  $("#cate2").change(function () {
    let cate2 = $(this).val();
    let data = {
      cate2: cate2
    };
    $.ajax({
      async: false,
      type: "post",
      data: data,
      url: "../category/category_add3.php",
      dataType: "html",
      success: function (return_data) {
        $("#cate3").html(return_data);
      },
    });
  });
  //cate3 소분류
  $("#pcode2_1").change(function () {
    let cate = $(this).val();
    let data = {
      cate: cate
    };
    $.ajax({
      async: false,
      type: "post",
      data: data,
      url: "../category/category_add4.php",
      dataType: "html",
      success: function (return_data) {
        $("#pcode3").html(return_data);
      },
    });
  });
</script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
  ?>