<?php
  session_start();
  $_SESSION['TITLE'] = "강의 등록";
  
  if(!$_SESSION['AID']){
    echo
    "<script>
      alert('접근 권한이 없습니다');
      location.href = '../member/login.php';
    </script>";
  };
  
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/lecture/lecture_add.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  $clidx = $_GET['clidx'];
  $que= "SELECT cls_title FROM lms_class WHERE clidx='$clidx'";
  $raw = $mysqli ->query($que) or die("query_error".$mysqli->error);
  $row = $raw -> fetch_object();
?>

    <main class="main_container content_pd">
      <div class="tt_wrapper d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h2 class="main_tt pre_bold_l">강의 등록</h2>
        </div>
        <img src="/ksv_lms/admin/img/img_logo.png" alt="logo">
      </div>
      <h3 class="pre_bold_m">강좌명 <span class="pre_rg_m">[<?= $row -> cls_title;?>]</span></h3>
      <form action="lecture_add_ok.php?clidx=<?= $clidx; ?>" method="post" enctype="multipart/form-data">
      <input type="hidden" name="lecidx" id="lecidx" value="">
        <h3 class="pre_bold_m">강의명</h3>
        <div class="lec_title">
          <input type="text" id="lec_title" name="lec_title" class="pre_rg_s" required placeholder="강의명을 입력하세요.">
        </div>
        <h3 class="pre_bold_m">강의 영상 업로드</h3>
        <div class="lec_url">
          <input type="text" id="lec_url" name="lec_url" class="pre_rg_s" required placeholder="URL을 입력하세요.">
        </div>
        <div class="lec_text_wrapper">
          <h3 class="pre_bold_m">강의설명</h3>
          <label for="lec_text" class="hidden"></label>
          <textarea id="lec_text" name="lec_text" class="lec_text" cols="30" rows="10" required placeholder="강의설명을 입력하세요."></textarea>
        </div>
        <div class="lec_thumb">
          <h3 class="pre_bold_m">썸네일 이미지</h3>
          <div class="d-flex justify-content-between gap-3">
            <label for="lec_thumb" class="pre_rg_m">파일선택</label>
            <input type="file" id="lec_thumb" name="lec_thumb">
            <input class="file_name" id="lec_thumb" name="lec_thumb" value="파일을 첨부해주세요.">
          </div>
        </div>
        <div class="lec_ts">
          <div class="d-flex gap-2">
            <h3 class="pre_bold_m">타임스탬프</h3>
            <span class="lec_upload"><i class="fa-solid fa-square-plus"  onclick="tsplus()"></i></span>
          </div>
          <div id="lec_ts">
            <div class="d-flex justify-content-between gap-3 lec_ts_up" id="lec_ts_content">
              <input type="text" id="ts_min" name="ts_min[]" class="ts_min" placeholder="분">
              <input type="text" id="ts_sec" name="ts_sec[]" class="ts_sec" placeholder="초">
              <input type="text" id="ts_desc" name="ts_desc[]" class="ts_desc" placeholder="해당 부분 설명을 입력하세요">
            </div>
          </div>
        </div>
        <div class="btns d-flex justify-content-end gap-3">
          <button class="btn_m_pc pre_rg_m" onclick="location.href='/class/class_view.php?clidx=<?= $clidx; ?>'">강의 등록</button>
          <button class="btn_m_sc pre_rg_m" onclick="history.back()">취소</button>
        </div>
    </form>
    </main>
  </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
<script src="../js/lecture/lecture.js"></script>
<script>
  //강의리스트 추가
  function tsplus(){
    let addHtml2 = $('#lec_ts_content').html();
    let addHtml = `<div class="d-flex justify-content-between gap-3 lec_ts_up">${addHtml2}</div>`;

    $('#lec_ts').append(addHtml);
  };
</script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>s