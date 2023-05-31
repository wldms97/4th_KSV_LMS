<?php
  session_start();
  $_SESSION['TITLE'] = "강의 관리";

  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );
  
  if(!$_SESSION['AID']){
    echo "<script>
            alert('접근 권한이 없습니다');
            location.href = '../member/login.php';
        </script>";
  };
  
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/lecture/lecture_view.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  error_reporting( E_ALL );
  ini_set( "display_errors", 1 );

  //lms_lec SELECT구문
  $lecidx = $_GET['lecidx'];
  $que = "SELECT * FROM lms_lec WHERE lecidx='{$lecidx}'";
  $raw = $mysqli ->query($que) or die("query_error".$mysqli->error);
  $row = $raw -> fetch_object();

  //lms_class SELECT구문
  $que2 = "SELECT * FROM lms_class WHERE clidx =" .(int)$row -> lec_clsidx;
  $raw2 = $mysqli ->query($que2) or die("query_error".$mysqli->error);
  $row2 = $raw2 -> fetch_object();

?>
    <main class="main_container content_pd">
      <div
        class="tt_wrapper d-flex justify-content-between align-items-center"
      >
        <div class="d-flex justify-content-between align-items-center gap-3">
          <h2 class="main_tt pre_bold_l">강의 관리</h2>
        </div>
        <img src="/ksv_lms/admin/img/img_logo.png" alt="logo" />
      </div>
      <div class="information d-flex justify-content-between gap-3">
        <div class="lec_thumbnail">
          <img src="/ksv_lms/<?php echo $row -> lec_thumb; ?>" alt="강의 썸네일" />
        </div>
        <div class="info d-flex flex-column justify-content-center gap-3">
          <p class="pre_bold_m">강좌명 : <span class="pre_rg_m"><?php echo $row2 -> cls_title; ?></span></p>
          <p class="pre_bold_m">강의명 : <span class="pre_rg_m"><?php echo $row -> lec_title; ?></span></p>
        </div>
      </div>
      <div class="lecture_video">
        <iframe class="video" width="100%" height="625px" src="https://www.youtube.com/embed/<?= $row -> lec_url; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width: 100%; height: 625px;"></iframe>
      </div>
      <div class="lecture_description">
        <p class="pre_rg_s"><?php echo nl2br($row -> lec_text); ?></p>
      </div>
      <div class="lecture_timestamp">
        <h3 class="pre_bold_m">타임 스탬프</h3>
        <?php 
          $tsque = "SELECT * FROM lms_timestamp WHERE ts_lecidx ='$lecidx'";              
          $tsres = $mysqli->query($tsque) or die("query_error".$mysqli->error);
          while($tsobg = $tsres->fetch_object()){
            $tsrow[] = $tsobg;
          }
          if(!empty($tsrow)) {
          foreach($tsrow as $t){
        ?>
          <p class="pre_rg_s"><span class="pre_bold_s ts_digit"><?php echo $t->ts_min; ?> : <?php echo $t->ts_sec; ?></span> <?php echo $t->ts_desc; ?></p>
        <?php } 
          } else {
            echo "등록된 타임스탬프가 없습니다.";
          }
        ?>
      </div>
      <div class="btns d-flex justify-content-end gap-3">
        <button class="btn_m_pc pre_rg_m" onclick="location.href='../class/class_view.php?clidx=<?= $row2->clidx; ?>'">
          강의 목록
        </button>
        <button class="btn_m_sc pre_rg_m" onclick="location.href='lecture_edit.php?lecidx=<?= $row->lecidx; ?>'">
          강의 수정
        </button>
        <button class="btn_m_pr pre_rg_m" onclick="deleteLecture(<?= $row->lecidx; ?>, <?= $row2->clidx; ?>)">
          강의 삭제
        </button>
      </div>
    </main>
  </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
<script src="../js/lecture/lecture.js"></script>
<script>
  function deleteLecture(lecidx, clidx) {
    if (confirm('강의를 삭제하시겠습니까?')) {
      $.ajax({
        async: true,
        type: 'POST',
        url: 'lecture_delete.php',
        data: { lecidx: lecidx, clidx: clidx },
        dataType: 'json',
        success: function(response) {
          if (response.success) {
            alert('삭제되었습니다.');
            location.href = '../class/class_view.php?clidx=' + response.clidx;
          } else {
            alert('삭제 실패했습니다.');
            history.back();
          }
        }
      });
    }
  }
</script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>

