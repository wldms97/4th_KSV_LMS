<?php
  session_start();
  $_SESSION['TITLE'] = "공지사항 게시판";
  $_SESSION['NAME'] = "notice";

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
  <link rel="stylesheet" href="/ksv_lms/admin/css/board/board_list.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  $page = $_GET['page'] ?? 1;

  /* ================== 검색창 =================== */
  $select_board=$_GET["select_board"]??'';
  $search_bar=$_GET["search_bar"]??'';
  $search_where='';
  if($search_bar){
    $search_where .=" and ({$select_board} like '%".$search_bar."%')";
  }

  $list = 10; //페이지당 출력할 게시물 수
  $block_ct = 3; //한번에 보여지는 페이지네이션 넘버
  $block_num = ceil($page/$block_ct);
  $block_start = (($block_num -1 )*$block_ct) + 1;
  $block_end = $block_start + $block_ct - 1;
  $start_num = ($page - 1) * $list;

  $sql = "SELECT * from lms_board where 1=1";
  $sql .= $search_where;
  $order = " order by bidx desc";//마지막에 등록한 것 먼저 보여줌
  $limit= " limit $start_num, $list";
  $query = $sql.$order.$limit;

  $sql = "SELECT count(*) as cnt from lms_board where 1=1";
  $sql .= $search_where;
  $page_result = $mysqli->query($sql) or die("Query error! => ".$mysqli->error);
  $page_row = $page_result->fetch_assoc();
  $row_num = $page_row['cnt']; //전체 게시물 수

  $result = $mysqli->query($query) or die("Query Error! => ".$mysqli->error);
  while($rs = $result->fetch_object()){
      $rsc[]=$rs; //검색된 상품 목록 배열에 담기
  }
  
  $total_page = ceil($row_num/$list); 
  if($block_end > $total_page) $block_end = $total_page;
  $total_block = ceil($total_page/$block_ct);

?>

      <main class="main_container content_pd">
        <!-- bookmark + title + logo -->
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <!-- bookmark -->
            
            <div class="bookmark">
              <input type="checkbox" id="bookmark1" value="<?php echo $name; ?>" <?php if($row['m_title']==$name) echo "checked"; ?>/>
              <label for="bookmark1"><i class="fa-solid fa-bookmark"></i></label>
            </div>
            <h2 class="main_tt pre_bold_l">공지사항 게시판</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo">
        </div>
        <!-- select and search part -->
        <div class="board_btn_search d-flex justify-content-between">
            <button class="btn_m_pc pre_rg_m" onclick="location.href='board_add.php'">공지사항 등록</button>
            <form action="" method="GET" class="d-flex gap-3">
                <select name="select_board" id="select_board" class="form-select form-select-sm select_s" aria-label=".form-select-lg example">
                    <option value="b_title">제목</option>
                    <option value="adminid">작성자</option>
                    <option value="b_content">내용</option>
                </select>
                <input type="search" name="search_bar" class="form-control search_bar pre_rg_s" required placeholder="검색어를 입력하세요." aria-label="Recipient's username" aria-describedby="basic-addon2">
                <button class="btn_m_sc pre_rg_m" id="search_bar" type="submit">검색</button>
            </form>
        </div>
        
        <!-- table part -->
        <table class="table">
          <thead class="pre_rg_m">
            <tr>
              <th scope="col">번호</th>
              <th scope="col">제목</th>
              <th scope="col">작성자</th>
              <th scope="col">날짜</th>
              <th scope="col">수정</th>
              <th scope="col">삭제</th>
            </tr>
          </thead>

          <tbody class="pre_rg_s">
            <?php
              if(isset($rsc)){
                foreach($rsc as $r){
                  $origin = $r->bidx; //원래번호
                  $newArr[]=$origin; //배열
                  $idx=array_search($origin,$newArr);//새번호
                  $newIdx = $row_num-($idx+($page-1)*$list);
                  if($total_page-$page == 0){
                    $resultIdx=$idx+1;
                  }else{
                    $resultIdx=$idx+(($total_page-$page)*$block_ct);
                  }
            ?>
              <tr>
                <th scope="row"><?= $newIdx; ?></th>
                <td><a href="board_view.php?bidx=<?= $r -> bidx; ?>"><?= $r -> b_title; ?></a></td>
                <td><?= $_SESSION['AID'] ?></td>
                <td><?= $r -> b_regdate; ?></td>
                <td>
                  <button class="btn_s_sc pre_rg_s" onclick="location.href='board_edit.php?bidx=<?= $r->bidx; ?>'">수정</button>
                </td>
                <td>
                  <button type="button" value="<?= $r->bidx; ?>"
                  class="btn_s_pr pre_rg_s btn_board_delete">삭제</button>
                </td>
              </tr>
            <?php }} else { ?>
              <tr><td colspan="6" class="text-center">검색 결과가 없습니다.</tr>
            <?php } ?>
          </tbody>
        </table>

        <!-- pagination part -->
        <div class="pagination">
          <ul class="d-flex justify-content-center align-items-center">
            <?php
              if($page>1){
                if($block_num > 1){
                  $prev = ($block_num-2)*$block_ct + 1;
                  echo '
                  <li>
                    <a class="pre_rg_m" href="?select_board='.urlencode($select_board).'&search='.urlencode($search_bar).'&page='.$prev.'">
                      <i class="fa-solid fa-chevron-left"></i>
                    </a>
                  </li>';
                }
              }
              for($i=$block_start;$i<=$block_end;$i++){
                if($page == $i){
                    echo '<li><a href="?select_board='.urlencode($select_board).'&search_bar='.urlencode($search_bar).'&page='.$i.'" class="pre_rg_m click">'.$i.'</a></li>';
                }else{
                    echo '<li><a href="?select_board='.urlencode($select_board).'&search_bar='.urlencode($search_bar).'&page='.$i.'" class="pre_rg_m">'.$i.'</a></li>';
                }
              }
              if($page<$total_page){
                if($total_block > $block_num){
                    $next = $block_num*$block_ct + 1;
                    echo '<li><a class="pre_rg_m" href="?select_board='.urlencode($select_board).'&search='.urlencode($search_bar).'&page='.$next.'"><i class="fa-solid fa-chevron-right"></i></a></li>';
                }
              }
            ?>
          </ul>
        </div>
      </main>
    </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
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
          dataType:'json'
        });
      }
    });
</script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>