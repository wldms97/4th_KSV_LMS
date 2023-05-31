<?php
    session_start();
    $_SESSION['TITLE'] = "쿠폰 관리";
    $_SESSION['NAME'] = "coupon";

include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";

/*
사용쿠폰의 기한 체크
*/
$csql = "UPDATE lms_coupon set cou_status=-1 WHERE cou_status=1 and duedate < NOW() - INTERVAL 1 DAY";//기한 지나면 마감으로 변경 
$result = $mysqli->query($csql);
$csql2 = "UPDATE lms_coupon set cou_status=1 WHERE cou_status=0 and regdate = DATE_FORMAT(now(), '%Y-%m-%d')";//기한 시작하면 사용으로 변경 
$result2 = $mysqli->query($csql2);

$pageNumber  = $_GET['pageNumber']??1;//현재 페이지, 없으면 1
if($pageNumber < 1) $pageNumber = 1;
$pageCount  = $_GET['pageCount']??5;//페이지당 몇개씩 보여줄지, 없으면 10
$startLimit = ($pageNumber-1)*$pageCount;//쿼리의 limit 시작 부분
$firstPageNumber  = $_GET['firstPageNumber'];

//$row_num = $page_row['qidx']; //전체 게시물 수

$search_keyword=$_GET["search_keyword"]??'';

if($search_keyword){
  $search_where .=" and (cou_name like '%".$search_keyword."%')";
  //like 상품명 또는 상세설명 내용에서 검색
}

$sql = "SELECT * from lms_coupon c where 1=1";//모든 쿠폰 조회
$sql .= $search_where;//검색키워드 조건 추가하여 조회
$order = " order by couidx desc";//마지막에 등록한걸 먼저 보여줌
$limit = " limit $startLimit, $pageCount";
$query = $sql.$order.$limit;

$result = $mysqli->query($query) or die("query error => ".$mysqli->error);
while($rs = $result->fetch_object()){
  $rsc[]=$rs;
}
//전체게시물 수 구하기
$sqlcnt = "SELECT count(*) as cnt from lms_coupon where 1=1";
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
$origin=[];
foreach($rsc as $rs){
    array_push($origin,$rs->couidx);
}

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

function isIssue($n){

  switch($n){
    case 1:$rs="자동";
    break;
    case 2:$rs="수동";
    break;
  }
  return $rs;
}

?>
    <link rel="stylesheet" href="../css/coupon/coupon.css" />
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";
?>
<main class="main_container content_pd">
    <div class="tt_wrapper d-flex justify-content-between align-items-center">
        <div class="d-flex justify-content-between align-items-center gap-3">
        <div class="bookmark">
            <input type="checkbox" id="bookmark1" value="<?php echo $name; ?>" <?php if($row['m_title']==$name) echo "checked"; ?>/>
            <label for="bookmark1"
            ><i class="fa-solid fa-bookmark"></i
            ></label>
        </div>
        <h2 class="main_tt pre_bold_l">쿠폰 관리</h2>
        </div>
        <img src="../img/img_logo.png" alt="logo" />
    </div>
    <div class="option d-flex justify-content-between">
        <button class="btn_m_pc pre_rg_m" onClick="location.href='coupon_add.php'">쿠폰 등록</button>
        <form method="get" action="<?php echo $_SERVER["PHP_SELF"]?>">
        <div class="search d-flex gap-3">
        <input
            type="searchs"
            class="form-control search_bar pre_rg_s"
            placeholder="검색어를 입력하세요."
            aria-label="Recipient's username"
            aria-describedby="basic-addon2"
            name="search_keyword" id="search_keyword" value="<?php echo $search_keyword;?>"
        />
        <button class="btn_m_sc pre_rg_m" type="submit">검색</button>
        </div>
        </form>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">번호</th>
            <th scope="col">쿠폰명</th>
            <th scope="col">최소주문금액</th>
            <th scope="col">할인폭</th>
            <th scope="col">발급방식</th>
            <th scope="col">상태</th>
            <th scope="col">기한</th>
            <th scope="col">수정</th>
        </tr>
        </thead>
        <tbody class="pre_rg_s">
            <?php
                
                foreach($rsc as $r){
                    $coupon_min_price = $r->cou_min_price;
                    $coupon_price = $r->cou_price;
                    $origin = $r->couidx;
                    $newIdx[]=$origin;
            ?>
        <tr>
            <td scope="row"><?php echo $totalCount-(array_search($origin,$newIdx)+($pageNumber-1)*$pageCount); ?></td>
            <td><?php echo $r->cou_name; ?></td>
            <td><?php echo number_format($r->cou_min_price)."₩"; ?></td>
            <td><?php
                if($r->cou_type==1){
                    echo number_format($r->cou_price)."₩";
                }else{
                    echo $r->cou_ratio."%";
                }
            ?></td>
            <td><?php echo isIssue($r->cou_passive); ?></td>
            <td><?php echo isStatus($r->cou_status); ?></td>
            <td>
                <?php
                    if($r->cou_regdate != NULL){
                        echo $r->cou_regdate."~".$r->cou_duedate;
                    }else{
                        echo "무기한";
                    }
                ?>
            </td>
            <td>
            <button class="btn_s_sc pre_rg_s" onclick="location.href='coupon_edit.php?idx=<?php echo $r->couidx; ?>'">쿠폰 수정</button>
            </td>
        </tr>
        <?php } ?> 
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
