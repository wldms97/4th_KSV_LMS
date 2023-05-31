<?php
  session_start();
  $_SESSION['TITLE'] = "공지사항 게시판";

  if(!$_SESSION['AID']){
    echo "<script>
            alert('접근 권한이 없습니다');
            location.href = '../member/login.php';
        </script>";
  };

  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/board/board_add_edit.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";
?>
      <main class="main_container content_pd">
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h2 class="main_tt pre_bold_l">공지사항 게시판 수정</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo">
        </div>
        <?php
          $bidx = $_GET['bidx'];
          $sql = "SELECT * from lms_board WHERE bidx='{$bidx}'";
          $result = $mysqli -> query($sql) or die("Query Error ! => ".$mysqli -> error);
          $r = $result->fetch_object();
        ?>
        <form method="post" action="board_edit_ok.php" enctype="multipart/form-data">
            <input type="hidden" id="bidx" name="bidx" value="<?= $bidx; ?>">
            <div class="title">
                <label for="b_title" class="pre_bold_m">글제목</label>
                <input type="text" id="title" name="b_title" class="pre_rg_s" required placeholder="제목을 입력하세요." value="<?= $r -> b_title ?>">
            </div>
            <div class="content">
                <label for="b_content" class="pre_bold_m">글내용</label>
                <textarea id="content" name="b_content" class="pre_rg_s" cols="50" rows="20" required placeholder="내용을 입력하세요." ><?= $r -> b_content ?></textarea>
            </div>
            <div class="attach_file">
                <h3 class="pre_bold_m">첨부파일</h3>
                <div class="d-flex justify-content-between gap-3">
                  <label for="b_img" class="pre_rg_m">파일선택</label>
                  <input type="file" id="b_img" name="b_img" class="file_hidden">
                  <input class="file_name" value="<?= $r -> b_img ?>" placeholder="파일을 첨부해주세요." >
                </div>
            </div>
            <div class="btns d-flex justify-content-end gap-3">
              <button type="submit" class="btn_m_pc pre_rg_m" onclick="location.href='board_view.php?bidx=<?= $r -> bidx; ?>'">글 수정</button>
              <button type="button" class="btn_m_sc pre_rg_m" onclick="location.href='board_list.php'">취소</button>
            </div>
        </form>
      </main>
    </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
<script src="../js/board/board.js"></script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>