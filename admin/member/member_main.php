<?php
  session_start();
  $_SESSION['TITLE'] = "회원 정보";
  $_SESSION['NAME'] = "user";
  if(!$_SESSION['AID']){
    echo 
      "<script>
        alert('접근 권한이 없습니다');
        history.back();
      </script>";
  };

  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/member.css" />

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  //pagination
  if(isset($_GET['page'])){
    $page = $_GET['page'];
  } else {
    $page = 1;
  }
  $pagesql = "SELECT COUNT(*) as uidx from lms_user";
  $page_result = $mysqli->query($pagesql);
  $page_row = $page_result->fetch_assoc();
  $row_num = $page_row['uidx']; //전체 게시물 수

  $list = 10; //페이지당 출력할 게시물 수
  $block_ct = 3;
  $block_num = ceil($page/$block_ct); 
  $block_start = (($block_num -1)*$block_ct) + 1;
  $block_end = $block_start + $block_ct -1; 

  $total_page = ceil($row_num/$list);
  if($block_end > $total_page) $block_end = $total_page;
  $total_block = ceil($total_page/$block_ct);

  $start_num = ($page -1) * $list;
  
  $search_keyword=$_GET["search_keyword"]??'';
  $search_bar=$_GET["search_bar"]??'';
  $search_where = '';

  if($search_bar){
    $search_where .=" and $search_keyword like '%".$search_bar."%'";
    //like 상품명 또는 상세설명 내용에서 검색
  }
?>

      <main class="main_container content_pd">
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <div class="bookmark">
              <input type="checkbox" id="bookmark1" value="<?php echo $name; ?>" <?php if($row['m_title']==$name) echo "checked"; ?>/>
              <label for="bookmark1"><i class="fa-solid fa-bookmark"></i></label>
            </div>
            <h2 class="main_tt pre_bold_l">회원관리</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo" />
        </div>
        <form action="" method="GET" class="d-flex gap-3 justify-content-end" action="<?php echo $_SERVER["PHP_SELF"]?>">
          <select class="form-select form-select-sm select_s"aria-label=".form-select-lg example" name="search_keyword" id="search_keyword">
            <option selected value="none" class="pre_rg_s">선택</option>
            <option value="username">회원명</option>
            <option value="userid">회원ID</option>
          </select>
          <input
            type="search"
            class="form-control search_bar pre_rg_s"
            name="search_bar"
            placeholder="검색어를 입력하세요."
            aria-label="Recipient's username"
            aria-describedby="basic-addon2"
          />
          <button class="btn_m_sc pre_rg_m" id="search_bar" type="submit">검색</button>
        </form>

        <table class="table">
          <thead class="pre_rg_m">
            <tr>
              <th scope="col">번호</th>
              <th scope="col">회원명</th>
              <th scope="col">회원 ID</th>
              <th scope="col">E-mail</th>
              <th scope="col">전화번호</th>
              <th scope="col">가입 날짜</th>
              <th scope="col">상태</th>
              <th scope="col">관리</th>
            </tr>
          </thead>
          <tbody class="pre_rg_s">
            <?php
              $sql = "SELECT * FROM lms_user where super=0";
              $sql .= $search_where;
              $order = " ORDER BY uidx desc limit $start_num,$list";
              $query = $sql.$order;
              $result = $mysqli->query($query) or die("query error => ".$mysqli->error);
              while($rs = $result->fetch_object()){
                $rsc[]=$rs;
              }
              if (empty($rsc)) {
                echo '<tr><td colspan="8">등록된 회원이 없습니다.</td></tr>';
              } else {
                foreach($rsc as $r){
              ?>
            <!-- <tr>
              <th scope="row">1</th>
              <td>김지은</td>
              <td>wldms97</td>
              <td>wldms97@gmail.com</td>
              <td>010-2240-3973</td>
              <td>2023.04.26</td>
              <td><p class="st_join">가입</p></td>
              <td>
                <button class="btn_block pre_rg_s">차단</button>
              </td>
            </tr> -->
            <tr>
              <th scope="row"><?php echo $r->uidx; ?></th>
              <td><?php echo $r->username; ?></td>
              <td><?php echo $r->userid; ?></td>
              <td><?php echo $r->useremail; ?></td>
              <td><?php echo $r->userphone; ?></td>
              <td><?php echo $r->uregdate; ?></td>
              <td>
              <?php if($r->user_st == 1){ ?>
                <p class="st_join">가입</p></td>
              <?php } ?>
              <?php if($r->user_st == 0){ ?>
                <p class="st_session">탈퇴</p>
              <?php } ?>
              <?php if($r->user_st == 2){ ?>
                <p class="st_block">차단</p>
              <?php } ?>
              </td>
              <td>
              <?php if($r->user_st == 1){ ?>
                <button type="button" class="btn_block pre_rg_s" onclick="location.href='member_block.php?uidx=<?php echo $r->uidx;?>'">차단</button>
              <?php } ?>
              <?php if($r->user_st == 2){ ?>
                <button type="button" class="btn_block pre_rg_s" onclick="location.href='member_unblock.php?uidx=<?php echo $r->uidx;?>'">차단 해제</button>
              <?php } ?>
              </td>
            </tr>
            <?php } } ?>
          </tbody>
        </table>

        <div class="pagination">
          <ul class="d-flex justify-content-center align-items-center">
            <?php
              if($page>1){
                if($block_num > 1){
                  $prev = ($block_num-2)*$block_ct + 1;
                  echo
                  "<li>
                    <a class='pre_rg_m' href='?page=$prev'><i class='fa-solid fa-chevron-left'></i></a>
                  </li>";
                }
              }
              for($i=$block_start;$i<=$block_end;$i++){
                if($page == $i){
                  echo "<li><a href='?page=$i' class='pre_rg_m PG_num active click'>$i</a></li>";
                }else{
                  echo "<li><a href='?page=$i' class='pre_rg_m PG_num'>$i</a></li>";
                }
              }
              if($page<$total_page){
                if($total_block > $block_num){
                  $next = $block_num*$block_ct + 1;
                  echo
                  "<li>
                    <a class='pre_rg_m' href='?page=$next'><i class='fa-solid fa-chevron-right'></i></a>
                  </li>";
                }
              }
            ?>
          </ul>
        </div>
      </main>
    </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>

