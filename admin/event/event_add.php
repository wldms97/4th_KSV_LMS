<?php
    session_start();
    $_SESSION['TITLE'] = "이벤트 등록";

include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
    <link rel="stylesheet" href="../css/event/event.css" />
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

    $sql = "SELECT * from lms_coupon where cou_status=1";
    $result = $mysqli->query($sql) or die("query error => ".$mysqli->error);
    while($rs = $result->fetch_object()){
        $rsc[]=$rs;
    }
?>
      <main class="main_container content_pd">
        <div
          class="tt_wrapper d-flex justify-content-between align-items-center"
        >
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h2 class="main_tt pre_bold_l">이벤트 등록</h2>
          </div>
          <img src="../img/img_logo.png" alt="logo" />
        </div>
        <form
          form method="post" action="event_add_ok.php" onsubmit="return save()" enctype="multipart/form-data"
          class="d-flex flex-column gap-4"
        >
          <div class="thumbnail">
            <p class="pre_bold_m">썸네일 등록</p>
            <div class="customize">
              <label for="ev_thumb" class="choice">파일선택</label>
              <input type="text" class="input-field"/>
              <span class="fileName">선택된 파일 없음</span>
            </div>
            <input type="file"  id="ev_thumb" name="ev_thumb"/>
          </div>
          <div class="title">
            <p class="pre_bold_m">이벤트명</p>
            <input
              type="text"
              class="input-field"
              placeholder="이벤트명을 입력해주세요."
              aria-label="Recipient's username"
              aria-describedby="basic-addon2"
              id="ev_title" name="ev_title"
            />
          </div>
          <div class="image">
            <p class="pre_bold_m">이벤트 이미지</p>
            <div class="customize">
              <label for="ev_content_img" class="choice">파일선택</label>
              <input type="text" class="input-field"/>
              <span class="fileName">선택된 파일 없음</span>
            </div>
            <input type="file" id="ev_content_img" name="ev_content_img"/>
          </div>
          <div class="desc">
            <p class="pre_bold_m">이벤트 설명</p>
            <textarea
              cols="30"
              rows="10"
              placeholder="이벤트 설명을 입력해주세요."
              id="ev_content_text" name="ev_content_text"
            ></textarea>
          </div>
          <div class="coupon">
            <p class="pre_bold_m">적용 쿠폰</p>
            <select id="couidx" name="couidx">
              <option>선택하기</option>
              <?php
                foreach($rsc as $r){
              ?>
              <option value="<?php echo $r->couidx?>" ><?php echo $r->cou_name?></option>
              <?php }?>
            </select>
          </div>
          <div class="ebutton d-flex">
            <button class="btn_m_sc pre_rg_m">취소</button>
            <button class="btn_m_pc pre_rg_m">이벤트 등록</button>
          </div>
        </form>
      </main>
    </div>
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>  
    <script src="../js/event/event.js"></script>
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>

