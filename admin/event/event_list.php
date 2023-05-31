<?php
    session_start();
    $_SESSION['TITLE'] = "이벤트 관리";
    $_SESSION['NAME'] = "event";

include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
    <link rel="stylesheet" href="../css/event/event.css" />
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

    $pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
    if($pageNumber < 1) $pageNumber = 1;
    $pageCount  = $_GET['pageCount']??5;//페이지당 몇개씩 보여줄지, 없으면 10
    $startLimit = ($pageNumber-1)*$pageCount;//쿼리의 limit 시작 부분
    $firstPageNumber  = $_GET['firstPageNumber'];

    $search_keyword=$_GET["search_keyword"]??'';

    if($search_keyword){
    $search_where .=" and (ev_title like '%".$search_keyword."%')";
    //like 상품명 또는 상세설명 내용에서 검색
    }

    $sql = "SELECT * from lms_event where 1=1";//모든 쿠폰 조회
    $sql .= $search_where;//검색키워드 조건 추가하여 조회
    $order = " order by eidx desc";//마지막에 등록한걸 먼저 보여줌
    $limit = " limit $startLimit, $pageCount";
    $query = $sql.$order.$limit;

    $result = $mysqli->query($query) or die("query error => ".$mysqli->error);
    while($rs = $result->fetch_object()){
    $rsc[]=$rs;
    }

    //정보업데이트
    foreach($rsc as $r){
      $cc_name = $r->cou_name;
      $ccquery = "SELECT * from lms_coupon where cou_name='{$cc_name}'";
      $result = $mysqli->query($ccquery) or die("query error => ".$mysqli->error);
      $row = $result->fetch_object();
      $orgname = $row->cou_name;
      $orgreg = $row->cou_regdate;
      $orgdue = $row->cou_duedate;
      $passive = $row->cou_passive;
      $orgstat = $row->cou_status;
      $couidx = $row->couidx;
      $evUpdate = "UPDATE lms_event set cou_name='{$orgname}', cou_regdate='{$orgreg}', cou_duedate='{$orgdue}', cou_passive='{$passive}', cou_status='{$orgstat}' where couidx=$couidx";
      $evResult = $mysqli->query($evUpdate);
      // print_r($evUpdate);
    }

    //전체게시물 수 구하기
    $sqlcnt = "SELECT count(*) as cnt from lms_event where 1=1";
    $sqlcnt .= $search_where;
    $countresult = $mysqli->query($sqlcnt) or die("query error => ".$mysqli->error);
    $rscnt = $countresult->fetch_object();
    $totalCount = $rscnt->cnt;//전체 갯수를 구한다.
    $totalPage = ceil($totalCount/$pageCount);//전체 페이지를 구한다.

    //$pageCount = 5; //페이지당 출력할 게시물 수
    $block_ct = 5; //페이지네이션 한번에 몇개씩 보일지
    $block_num = ceil($pageNumber/$block_ct);//page9,  9/5 1.2 2
    $block_start = (($block_num -1)*$block_ct) + 1;//page6 start 6
    $block_end = $block_start + $block_ct -1; //start 1, end 5
    $total_block = ceil($totalPage/$block_ct);//총32, 2

    if($block_end > $totalPage) $block_end = $totalPage;
    //$totalPage = ceil($totalPage/$block_ct);//총32, 2 총 페이지 수

    $start_num = ($pageNumber -1) * $pageCount;
    // echo ($start_num);

    if($firstPageNumber < 1) $firstPageNumber = 1;
    $lastPageNumber = $firstPageNumber + $pageCount - 1;//페이징 나오는 부분에서 레인지를 정한다.
    if($lastPageNumber > $totalPage) $lastPageNumber = $totalPage;

    function isStatus($n){  //목록에서 상품의 상태를 변경할 때 숫자를 isSatus함수에 전달하여 변경

        switch($n) {           
            case -1:$rs="마감";
            break;
            case 0:$rs="대기";
            break;
            case 1:$rs="사용";
            break;
        }
        return $rs;
      }
?>
      <main class="main_container content_pd">
        <div
          class="tt_wrapper d-flex justify-content-between align-items-center"
        >
          <div class="d-flex justify-content-between align-items-center gap-3">
            <div class="bookmark">
              <input type="checkbox" id="bookmark1" value="<?php echo $name; ?>" <?php if($row['m_title']==$name) echo "checked"; ?>/>
              <label for="bookmark1"
                ><i class="fa-solid fa-bookmark"></i
              ></label>
            </div>
            <h2 class="main_tt pre_bold_l">이벤트 관리</h2>
          </div>
          <img src="../img/img_logo.png" alt="logo" />
        </div>
        <div class="option d-flex justify-content-between">
          <button onclick="location.href='event_add.php'" class="btn_m_pc pre_rg_m">이벤트 등록</button>
          <div class="search d-flex gap-3">
            <input
              type="text"
              class="form-control search_bar pre_rg_s"
              placeholder="검색어를 입력하세요."
              aria-label="Recipient's username"
              aria-describedby="basic-addon2"
            />
            <button class="btn_m_sc pre_rg_m" type="submit">검색</button>
          </div>
        </div>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">번호</th>
              <th scope="col">썸네일</th>
              <th scope="col">이벤트명</th>
              <th scope="col">기한</th>
              <th scope="col">적용쿠폰</th>
              <th scope="col">상태</th>
              <th scope="col">수정</th>
              <th scope="col">바로가기</th>
            </tr>
          </thead>
          <tbody class="pre_rg_s">
            <?php
              foreach($rsc as $r){
                $couidx=$r->couidx;
                $sqlc = "SELECT * from lms_coupon where couidx={$couidx}";
                $resultc = $mysqli->query($sqlc) or die("query error => ".$mysqli->error);
                $rsc = $resultc->fetch_assoc();

            ?>
            <tr>
              <td><?php echo $r->eidx; ?></td>
              <td><img src="/ksv_lms/admin/uploadImg/event/<?php echo $r->ev_thumb;?>" class="thumb"></td>
              <td><?php echo $r->ev_title; ?></td>
              <td><?php
              if($rsc['cou_regdate']==NULL){
                echo "무기한";
              }else{
                  echo $rsc['cou_regdate']." ~ ".$rsc['cou_duedate'];
              }
              ?></td>
              <td><?php echo $rsc['cou_name']; ?></td>
              <td><?php echo isStatus($rsc['cou_status']); ?></td>
              <td>
                <button class="btn_s_sc pre_rg_s" onclick="location.href='event_edit.php?idx=<?php echo $r->eidx; ?>'">이벤트 수정</button>
              </td>
              <td>
                <button class="btn_s_sc pre_rg_s">바로가기</button>
              </td>
            </tr>
            <?php
        }
        ?> 
          </tbody>
        </table>
        <div class="pagination">
          <ul class="d-flex justify-content-center align-items-center">
            <?php
                if($pageNumber>1){
                    if($block_num > 1){
                        $prev = ($block_num-2)*$pageCount + 1;
                        echo "<li>
                        <a class='suit_bold_m' href='?pageNumber=$prev'>
                        <i class='fa-solid fa-chevron-left'>
                        </a>
                        </li>";
                    }
                }


                for($i=$block_start;$i<=$block_end;$i++){
                    if($pageNumber == $i){
                        echo "<li><a href='?pageNumber=$i' class='suit_bold_m PG_num active click'>$i</a></li>";
                    }else{
                        echo "<li><a href='?pageNumber=$i' class='suit_bold_m PG_num'>$i</a></li>";
                    }
                }
                

                if($page<$totalPage){
                    if($total_block > $block_num){
                        $next = $block_num*$pageCount + 1;
                        echo "<li>
                        <a class='suit_bold_m' href='?pageNumber=$next'>
                        <i class='fa-solid fa-chevron-right'>
                        </a>
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
?>  
<!-- 각파트 script -->
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>

