<?php
  session_start();
  $_SESSION['TITLE'] = "공지사항 게시판";
  
  $aid = $_SESSION['AID'];
  if(!$_SESSION['AID']){
    echo "<script>
            alert('접근 권한이 없습니다');
            location.href = '../member/login.php';
        </script>";
  };

  // $book_mark = $_SESSION['ADBOOK'];
  
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/board/board_view.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";
?>
<?php
      $bidx = $_GET['bidx'];
      $sql = "SELECT * from lms_board where bidx='{$bidx}'"; 
      $result = $mysqli -> query($sql) or die("Query Error ! => ".$mysqli -> error);
      $r = $result->fetch_object();
?>
      <main class="main_container content_pd">
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h2 class="main_tt pre_bold_l">공지사항 게시판</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo">
        </div>
        <div class="board_view">
            <div class="board_view_title pre_rg_s">
                <div class="d-flex justify-content-between align-items-center pre_rg_s">
                    <h3 class="pre_rg_s"><?= $r -> b_title; ?></h3>
                    <div class="d-flex justify-content-between align-items-center gap-3">
                        <p><?= $a -> adminname; ?></p>
                        <p><?= $r -> b_regdate; ?></p>
                    </div>
                </div>
            </div>
            <div>
                <div class="board_view_img">
                    <img src="/ksv_lms<?= $r -> b_img; ?>" alt="">
                </div>
                <div class="board_view_content pre_rg_xs">
                    <p><?= nl2br($r -> b_content); ?></p>
                </div>
                <div class="btns_edit_del d-flex justify-content-end gap-3">
                    <button class="btn_s_sc pre_rg_s" onclick="location.href='board_edit.php?bidx=<?= $r -> bidx; ?>'">수정</button>
                    <button type="button" class="btn_s_pr pre_rg_s btn_board_delete" value="<?= $r->bidx; ?>">삭제</button>
                </div>
                <div class="attach_file pre_rg_xs">
                    <p>첨부파일 : <a href="/ksv_lms/<?= $r -> b_img; ?>" target="_blank"><?= $r -> b_img; ?></a></p>
                </div>
            </div>
        </div>
        <?php
          $bidx = $_GET['bidx'];          
          $sql = "SELECT * from lms_board";
          $result = $mysqli -> query($sql) or die("Query Error ! => ".$mysqli -> error);
          while($rs = $result->fetch_object()){
            $rsc[]=$rs; //검색된 상품 목록 배열에 담기
          }

          foreach($rsc as $r){
            $origin = $r->bidx; //원래번호
            $newArr[]=$origin; //배열
          }
          $current_Idx = array_search($bidx,$newArr);//현재 글의 인덱스
          $prev_bidx = $newArr[$current_Idx-1];
          $next_bidx = $newArr[$current_Idx+1];
        ?>
        <div class="btns_prev_next d-flex justify-content-center align-items-center">
          <?php
            if(isset($prev_bidx)){
              echo"<a href='board_view.php?bidx=$prev_bidx' class='prev_btn'><i class='fa-solid fa-chevron-left'></i>이전</a>";
            }
          ?>
            <button class="btn_m_pc" onclick="location.href='board_list.php'">목록보기</button>
          <?php
            if(isset($next_bidx)){
              echo "<a href='board_view.php?bidx=$next_bidx' class='next_btn '>다음<i class='fa-solid fa-chevron-right'></i></a>";
            }
          ?>
        </div>
      </main>
    </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
<script src="../js/board/board.js"></script>
<script>
  $('.btn_board_delete').click((e)=>{
    let bidx = $(e.target).val();
    let confirmDelete = confirm('공지사항을 삭제하시겠습니까?');
      let data = {
        bidx:bidx,
        confirmDelete:confirmDelete 
      }
      if(confirmDelete==true){
        $.ajax({
          async:true,
          type:'post',
          url:'board_delete.php',
          data:data,
          dataType:'json',
          success: function(action){
            if(action.success){
              alert('공지사항 삭제');
              location.href = 'board_list.php';
            } else {
            alert('공지사항 삭제 실패');
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