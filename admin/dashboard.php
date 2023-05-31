<?php
    session_start();
    $_SESSION['TITLE'] = "대시보드";

include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
ini_set( 'display_errors', '0' );
?>
    <link rel="stylesheet" href="/ksv_lms/admin/css/dashboard/dashboard.css" />
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

    $page = $_GET['page'] ?? 1;

    $sql = "SELECT * from lms_management WHERE m_bookmark=1";
    $result=$mysqli->query($sql) or die($mysqli->error);
    while($rs = $result->fetch_object()){
        $rsc[]=$rs;
    }

    $list = 8; //페이지당 출력할 게시물 수

    $sql2 = "SELECT * from lms_board where 1=1";
    $order = " order by bidx desc";//마지막에 등록한 것 먼저 보여줌
    $limit= " limit 1, $list";
    $query = $sql2.$order.$limit;

    $result2 = $mysqli->query($query) or die($mysqli->error);
    while($rs2 = $result2->fetch_object()){
        $brs[]=$rs2; //검색된 상품 목록 배열에 담기
    }

    $sql3 = "SELECT count(*) as cnt from lms_board where 1=1";
    $page_result = $mysqli->query($sql3) or die("Query error! => ".$mysqli->error);
    $page_row = $page_result->fetch_assoc();
    $row_num = $page_row['cnt']; //전체 게시물 수

?>
      <main class="main_container content_pd d-flex flex-column">
        <div class="bookmark">
          <p class="pre_bold_l">즐겨찾기</p>
          <div class="d-flex">
            <?php
                foreach($rsc as $r){
            ?>
            <div class="box" onclick="location.href='/ksv_lms/admin/<?php echo $r->link; ?>.php'">
              <i class="fa-solid <?php echo $r->m_icon; ?>"></i>
              <p class="pre_rg_m"><?php echo $r->m_name; ?></p>
            </div>
            <?php } ?>
          </div>
        </div>
        <div class="charts d-flex">
          <div class="chart-doughnut">
            <div class="d-flex justify-content-between">
              <p class="pre_bold_l">카테고리 별 강좌 비율</p>
              <p class="pre_rg_m more">+ 더보기</p>
            </div>
            <div class="box d-flex justify-content-center align-items-center">
              <div class="d-flex">
                <canvas id="myChart"></canvas>
                <div class="desc d-flex flex-column justify-content-center">
                  <div class="d-flex">
                    <div class="dot red"></div>
                    <p class="pre_rg_s">프론트엔드</p>
                  </div>
                  <div class="d-flex">
                    <div class="dot blue"></div>
                    <p class="pre_rg_s">백엔드</p>
                  </div>
                  <div class="d-flex">
                    <div class="dot black"></div>
                    <p class="pre_rg_s">UI/UX</p>
                  </div>
                  <div class="d-flex">
                    <div class="dot green"></div>
                    <p class="pre_rg_s">일반 디자인</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="chart-bar">
            <div class="d-flex justify-content-between">
              <p class="pre_bold_l">카테고리 별 판매량</p>
              <p class="pre_rg_m more">+ 더보기</p>
            </div>
            <div class="box d-flex justify-content-center align-items-center">
              <div>
                <canvas id="myChart2"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="d-flex">
          <div class="notice">
            <div class="d-flex justify-content-between">
              <p class="pre_bold_l">공지사항</p>
              <p class="pre_rg_m more">+ 더보기</p>
            </div>
            <table class="table">
              <thead class="pre_rg_m">
                <tr>
                  <th scope="col">번호</th>
                  <th scope="col">제목</th>
                  <th scope="col">날짜</th>
                  <th scope="col">바로가기</th>
                </tr>
              </thead>
              <tbody class="pre_rg_s">
                <?php
                    foreach($brs as $b){
                      $origin = $b->bidx; //원래번호
                      $newArr[]=$origin; //배열
                      $idx=array_search($origin,$newArr);//새번호
                      $newIdx = $row_num-$idx;
                ?>
                  <tr>
                    <th scope="row"><?php echo $newIdx; ?></th>
                    <td><a href="/ksv_lms/admin/board/board_view.php?bidx=<?php echo $b->bidx; ?>"><?php echo $b->b_title; ?></a></td>
                    <td><?php echo $b->b_regdate; ?></td>
                    <td>
                      <button class="btn_s_sc pre_rg_s" onclick="location.href='/ksv_lms/admin/board/board_view.php?bidx=<?php echo $b->bidx; ?>'">바로가기</button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
          <div class="calender">
            <div class="d-flex justify-content-between">
              <p class="pre_bold_l">일정</p>
              <p class="pre_rg_m more">+ 더보기</p>
            </div>
            <div class="box">
              <div id='calendar'></div>
            </div>
          </div>
        </div>
      </main>
    </div>
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="/ksv_lms/admin/js/dashboard/dashboard.js"></script>
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>
