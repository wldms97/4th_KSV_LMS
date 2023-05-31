<?php
  session_start();
  $_SESSION['TITLE'] = "강좌 관리";
  
  if(!$_SESSION['AID']){
    echo "<script>
            alert('접근 권한이 없습니다');
            location.href = '../member/login.php';
        </script>";
  };
  
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
    <link rel="stylesheet" href="/ksv_lms/admin/css/class/class_view.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  //카테고리 select
  $query = "SELECT * from lms_category where cate_step=1";
  $result = $mysqli -> query($query) or die("query error =>".$mysqli-->error);
  while($rs_lec = $result -> fetch_object()){
    $cate1array[]=$rsc;
  }
  if($cate1){
    $query = "SELECT * from lms_category where cate_step=2 and cate_pcode='{$cate1}'";
    $result = $mysqli -> query($query) or die("query error =>".$mysqli-->error);
    while($rsc = $result -> fetch_object()){
      $cate2array[]=$rsc;
    }
  }
  if($cate2){
    $query = "SELECT * from lms_category where cate_step=3 and cate_pcode='{$cate2}'";
    $result = $mysqli -> query($query) or die("query error =>".$mysqli-->error);
    while($rsc = $result -> fetch_object()){
      $cate3array[]=$rsc;
    }
  }

  //lms_class SELECT구문
  $clidx = $_GET['clidx'];
  $sql = "SELECT * from lms_class where clidx='{$clidx}'"; 
  $result = $mysqli -> query($sql) or die("Query Error ! => ".$mysqli -> error);
  $r = $result->fetch_object();

  //lms_lecture SELECT구문
  $sql2 = "SELECT * from lms_lec where lec_clsidx='{$clidx}'"; 
  $result2 = $mysqli -> query($sql2) or die("Query Error ! => ".$mysqli -> error);

  while($rs = $result2->fetch_object()){
    $lecture_id[] = $rs;
  }
?>
      <main class="main_container content_pd">
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h2 class="main_tt pre_bold_l">강좌 관리</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo">
        </div>
        <div class="information d-flex justify-content-between gap-3">
            <div class="thumbnail">
              <img src="/ksv_lms<?= $r -> cls_thumb; ?>" alt="썸네일">
            </div>
            <div class="info d-flex align-items-center">
                <div class="main_info d-flex flex-column gap-4">
                    <div class="d-flex flex-column gap-1">
                    <?php
                      $cb_code = $r->cls_cate_big;
                      $cm_code = $r->cls_cate_mid;
                      $cs_code = $r->cls_cate_sm;

                      $cs_query = "SELECT * from lms_category where cate_step=3 and cate_code='".$cs_code."'";
                      $cs_result = $mysqli -> query($cs_query) or die("query error =>".$mysqli-->error);
                      $csr = $cs_result -> fetch_object();

                      $cm_query = "SELECT * from lms_category where cate_step=2 and cate_code='".$cm_code."'";
                      $cm_result = $mysqli -> query($cm_query) or die("query error =>".$mysqli-->error);
                      $cmr = $cm_result -> fetch_object();

                      $cb_query = "SELECT * from lms_category where cate_step=1 and cate_code='".$cb_code."'";
                      $cb_result = $mysqli -> query($cb_query) or die("query error =>".$mysqli-->error);
                      $cbr = $cb_result -> fetch_object();
                    ?>
                        <p class="pre_rg_xs"><?= $cbr -> cate_name; ?> > <?= $cmr -> cate_name; ?> > <?= $csr -> cate_name; ?></p>
                        <div class="title d-flex align-items-center gap-2">
                            <p class="pre_bold_m"><?= $r->cls_title; ?></p>
                            <?php 
                              if($r->cls_price_option=='0'){ //무료
                            ?>
                              <div class="free_tag"><p class="pre_rg_xs">무료</p></div>
                            <?php
                              } else if($r->cls_price_option=='1'){ //유료
                            ?>
                              <div class="pay_tag"><p class="pre_rg_xs">유료</p></div>
                            <?php
                              }
                            ?>
                        </div>
                    </div>
                    <p class="pre_rg_s">금액 : <?php echo $r->cls_price ?></p>
                </div>
                <div class="option">
                    <h3 class="pre_bold_s">강좌옵션</h3>
                    <div class="lecture_option pre_rg_s d-flex justify-content-between align-items-center gap-3">
                      <input type="checkbox" name="cls_recom[<?php echo $r->clidx;?>]" id="cls_recom_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_recom){echo "checked";}?> class="col">
                      <label for="cls_recom" class="col">추천</label>
                      <input type="checkbox" name="cls_basic[<?php echo $r->clidx;?>]" id="cls_basic_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_basic){echo "checked";}?> class="col">
                      <label for="cls_basic" class="col">초급</label>
                      <input type="checkbox" name="cls_inter[<?php echo $r->clidx;?>]" id="cls_inter_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_inter){echo "checked";}?> class="col">
                      <label for="cls_inter" class="col">중급</label>
                      <input type="checkbox" name="cls_adv[<?php echo $r->clidx;?>]" id="cls_adv_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_adv){echo "checked";}?> class="col">
                      <label for="cls_adv" class="col">고급</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="class_description">
            <h3 class="pre_bold_m">강좌 설명</h3>
            <p class="pre_rg_s"><?php echo $r->cls_text ?></p>
        </div>
        <div class="lecture_video_list">
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="pre_bold_m">강의 리스트</h3>
            <button class="pre_rg_m" onclick="location.href='../lecture/lecture_add.php?clidx=<?= $r->clidx; ?>'">+ 강의 추가</button>
          </div>
            <ul>
              <?php 
                if(isset($lecture_id)){ //강의가 있다면
                  foreach($lecture_id as $lid){
              ?>
                <li class="lecture_video">
                  <p class="pre_rg_ms"><a href="../lecture/lecture_view.php?lecidx=<?= $lid->lecidx; ?>"><?php echo $lid->lec_title ?></a></p>
                </li>
              <?php } } else { //강의가 없다면 ?>
                <p class="pre_rg_xs">등록된 강의가 없습니다. 강의를 등록해주세요.</p>
              <?php } ?>
            </ul>
        </div>
        <div class="btns d-flex justify-content-end gap-3">
            <button class="btn_m_pc pre_rg_m" onclick="location.href='class_list.php'">강좌 목록</button>
            <button class="btn_m_sc pre_rg_m" onclick="location.href='class_edit.php?clidx=<?= $r->clidx; ?>'">강좌 수정</button>
            <button type="button" class="btn_m_pr pre_rg_m btn_class_delete" value="<?= $r->clidx; ?>">강좌 삭제</button>
        </div>
      </main>
    </div>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
  <script src="../js/class/class.js"></script>
  <script>
  // 강의 삭제 버튼
  $('.btn_class_delete').click((e)=>{
    let clidx = $(e.target).val();
    let confirmDelete = confirm('강좌를 삭제하시겠습니까?');
      let data = {
        clidx:clidx,
        confirmDelete:confirmDelete 
      }
      if(confirmDelete==true){
        $.ajax({
          async:true,
          type:'post',
          url:'class_delete.php',
          data:data,
          dataType:'json',
          success: function(action){
            if(action.success){
              alert('강좌 삭제');
              location.href = 'class_list.php';
            } else {
            alert('강좌 삭제 실패');
            history.back();
            }
          }
          });
        }
      });
  </script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>