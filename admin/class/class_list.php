<?php
  session_start();
  $_SESSION['TITLE'] = "강좌 리스트";
  $_SESSION['NAME'] = "management";
  
  if(!$_SESSION['AID']){
    echo "<script>
            alert('접근 권한이 없습니다');
            location.href = '../member/login.php';
        </script>";
  };

  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/class/class_list.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  //변수명 설정
  $cls_cate_big = $_GET['cate1']?? '';
  $cls_cate_mid = $_GET['cate2']?? '';
  $cls_cate_sm = $_GET['cate3']?? '';
  $cls_recom = $_GET['cla_recom']?? '';
  $cls_basic = $_GET['cls_basic']?? '';
  $cls_inter = $_GET['cls_inter']?? '';
  $cls_adv = $_GET['cls_adv']?? '';
  $search_bar=$_GET["search_bar"]??'';
  $search_where = '';
  $page=$_GET["page"]?? 1;

  //카테고리 select
  $query = "SELECT * from lms_category where cate_step=1";
  $result = $mysqli -> query($query) or die("query error =>".$mysqli->error);
  while($rs = $result -> fetch_object()){
    $cate1array[]=$rs;
  }
  if($cls_cate_big){
    $query = "SELECT * from lms_category where cate_step=2 and cate_pcode='{$cls_cate_big}'";
    $result = $mysqli -> query($query) or die("query error =>".$mysqli->error);
    while($rs = $result -> fetch_object()){
      $cate2array[]=$rs;
    }
  }
  if($cls_cate_mid){
    $query = "SELECT * from lms_category where cate_step=3 and cate_pcode='{$cls_cate_mid}'";
    $result = $mysqli -> query($query) or die("query error =>".$mysqli->error);
    while($rs = $result -> fetch_object()){
      $cate3array[]=$rs;
    }
  }
  $cates = $cls_cate_big.$cls_cate_mid.$cls_cate_sm;
  if($cates){
    $search_where .= " and cls_cate like '".$cates."%'";
  }
  //강좌옵션 checkbox
  if($cls_recom){
    $search_where .= " and cls_recom=1";
  }
  if($cls_basic){
    $search_where .= " and cls_basic=1";
  }
  if($cls_inter){
    $search_where .= " and cls_inter=1";
  }
  if($cls_adv){
    $search_where .= " and cls_adv=1";
  }
  //검색
  if($search_bar){
    $search_where .= " and (cls_title like '%".$search_bar."%' or cls_text like '%".$search_bar."%')";
  }
  //pagination
  $list = 3; //페이지당 출력할 게시물 수
  $block_ct = 3; //한번에 보여지는 페이지네이션 넘버
  $block_num = ceil($page/$block_ct);
  $block_start = (($block_num -1 )*$block_ct) + 1;
  $block_end = $block_start + $block_ct - 1;
  $start_num = ($page - 1) * $list;

  $sql = "SELECT * from lms_class where 1=1";
  $sql .= $search_where;
  $order = " order by clidx desc";//마지막에 등록한 것 먼저 보여줌
  $limit= " limit $start_num, $list";
  $query = $sql.$order.$limit;

  $sql = "SELECT count(*) as cnt from lms_class where 1=1";
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
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <!-- bookmark -->
            <div class="bookmark">
              <input type="checkbox" id="bookmark1" value="<?php echo $name; ?>" <?php if($row['m_title']==$name) echo "checked"; ?>/>
              <label for="bookmark1"><i class="fa-solid fa-bookmark"></i></label>
            </div>
            <h2 class="main_tt pre_bold_l">강좌 리스트</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo">
        </div>
        <div class="d-flex justify-content-end">
          <button class="btn_m_pc pre_rg_m" onclick="location.href='class_add.php'">강좌등록</button>
        </div>
        <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="GET">
          <div class="classification d-flex justify-content-between gap-3">
              <select name="cate1" id="cate1" class="form-select form-select-sm select_cate col" aria-label=".form-select-lg example">
                <option value="" selected>대분류</option>
                <?php
                  foreach($cate1array as $c){
                ?>
                  <option value="<?php echo $c->cate_code; ?>"<?php if($cls_cate_big==$c->cate_code){echo "selected";}?>><?php echo $c->cate_name;?></option>
                <?php
                  }
                ?>
              </select>
              <select name="cate2" id="cate2" class="form-select form-select-sm select_cate col" aria-label=".form-select-lg example">
                <option value="" selected>중분류</option>
                <?php
                  foreach($cate2array as $c){
                ?>
                  <option value="<?php echo $c->cate_code; ?>"<?php if($cls_cate_mid==$c->cate_code){echo "selected";}?>><?php echo $c->cate_name;?></option>
                <?php
                  }
                ?>
              </select>
              <select name="cate3" id="cate3" class="form-select form-select-sm select_cate col" aria-label=".form-select-lg example">
                <option value="" selected>소분류</option>
                <?php
                  foreach($cate3array as $c){
                ?>
                  <option value="<?php echo $c->cate_code; ?>"<?php if($cls_cate_sm==$c->cate_code){echo "selected";}?>><?php echo $c->cate_name;?></option>
                <?php
                  }
                ?>
              </select>
          </div>
          <div class="d-flex justify-content-between gap-3">
              <div class="class_option d-flex justify-content-between align-items-center gap-4">
                  <input type="checkbox" name="cls_recom" id="cls_recom" value="1" <?php if($cls_recom){echo "checked";}?> class="col">
                  <label for="cls_recom" class="col">추천</label>
                  <input type="checkbox" name="cls_basic" id="cls_basic" value="1" <?php if($cls_basic){echo "checked";}?> class="col">
                  <label for="cls_basic" class="col">초급</label>
                  <input type="checkbox" name="cls_inter" id="cls_inter" value="1" <?php if($cls_inter){echo "checked";}?> class="col">
                  <label for="cls_inter" class="col">중급</label>
                  <input type="checkbox" name="cls_adv" id="cls_adv" value="1" <?php if($cls_adv){echo "checked";}?> class="col">
                  <label for="cls_adv" class="col">고급</label>
                </div>
              <div class="d-flex justify-content-end gap-3">
                  <input type="search" name="search_bar" class="form-control search_bar pre_rg_s" placeholder="검색어를 입력하세요." aria-label="Recipient's username" aria-describedby="basic-addon2">
                  <button class="btn_m_sc pre_rg_m" id="search_bar" type="submit">검색</button>
              </div>
          </div>
        </form>
        <ul class="class">
          <?php
          if(isset($rsc)){
            foreach($rsc as $r){
          ?>
          <input type="hidden" name="clidx[]" value="<?php echo $r->clidx;?>">
            <li class="class_list d-flex justify-content-between align-items-center">
                <div class="class_thumbnail">
                    <img src="/ksv_lms<?php echo $r -> cls_thumb; ?>" alt="썸네일">
                </div>
                <div class="d-flex justify-content-between align-items-center col-8">
                  <div class="class_information">
                      <p class="class_title pre_bold_m"><?php echo $r -> cls_title; ?></p>
                      <?php
                        $cb_code = $r->cls_cate_big;
                        $cm_code = $r->cls_cate_mid;
                        $cs_code = $r->cls_cate_sm;
          
                        $cs_query = "SELECT * from lms_category where cate_step=3 and cate_code='".$cs_code."'";
                        $cs_result = $mysqli -> query($cs_query) or die("query error =>".$mysqli->error);
                        $csr = $cs_result -> fetch_object();
          
                        $cm_query = "SELECT * from lms_category where cate_step=2 and cate_code='".$cm_code."'";
                        $cm_result = $mysqli -> query($cm_query) or die("query error =>".$mysqli->error);
                        $cmr = $cm_result -> fetch_object();
          
                        $cb_query = "SELECT * from lms_category where cate_step=1 and cate_code='".$cb_code."'";
                        $cb_result = $mysqli -> query($cb_query) or die("query error =>".$mysqli->error);
                        $cbr = $cb_result -> fetch_object();
                      ?>
                      <p class="class_classification pre_rg_s"><?php echo $cbr -> cate_name; ?> > <?php echo $cmr -> cate_name; ?> > <?php echo $csr -> cate_name; ?></p>
                      <p class="class_price pre_rg_s">가격 : <?php echo number_format($r -> cls_price); ?>원</p>
                      <div class="class_option d-flex justify-content-between align-items-center gap-4">
                        <input type="checkbox" name="cls_recom[<?php echo $r->clidx;?>]" id="cls_recom_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_recom){echo "checked";}?> class="col">
                        <label for="cls_recom" class="col">추천</label>
                        <input type="checkbox" name="cls_basic[<?php echo $r->clidx;?>]" id="cls_basic_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_basic){echo "checked";}?> class="col">
                        <label for="cls_basic" class="col">초급</label>
                        <input type="checkbox" name="cls_inter[<?php echo $r->clidx;?>]" id="cls_inter_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_inter){echo "checked";}?> class="col">
                        <label for="cls_inter" class="col">중급</label>
                        <input type="checkbox" name="cls_adv[<?php echo $r->clidx;?>]" id="cls_adv_<?php echo $r->clidx;?>" value="1" <?php if($r->cls_adv){echo "checked";}?> class="col">
                        <label for="cls_adv" class="col">고급</label>
                      </div>
                  </div>
                  <div class="class_btns d-flex flex-column gap-3">
                      <button class="btn_m_pc pre_rg_m" onclick="location.href='class_view.php?clidx=<?php echo $r->clidx; ?>'">바로가기</button>
                      <button class="btn_m_sc pre_rg_m" onclick="location.href='class_edit.php?clidx=<?php echo $r->clidx; ?>'">강좌 수정</button>
                      <button type="button" class="btn_m_pr pre_rg_m btn_class_delete" value="<?php echo $r->clidx; ?>">강좌 삭제</button>
                  </div>
                </div>
            </li>
          <?php }} else { ?>
            <li class="text-center">검색 결과가 없습니다.</li>
          <?php } ?>
        </ul>

        <!-- pagination part -->
        <div class="pagination">
          <ul class="d-flex justify-content-center align-items-center">
          <?php
            if ($page > 1) {
              if ($block_num > 1) {
                $prev = ($block_num - 2) * $block_ct + 1;
                echo "<li><a href='?cate1=$cls_cate_big&cate2=$cls_cate_mid&cate3=$cls_cate_sm&cls_recom=$cls_recom&cls_basic=$cls_basic&cls_inter=$cls_inter&cls_adv=$cls_adv&search_bar=" . urlencode($search_bar) . "&page=$prev' class='pre_rg_m'><i class='fa-solid fa-chevron-left'></i></a></li>";
              }
            }
            for ($i = $block_start; $i <= $block_end; $i++) {
              if ($page == $i) {
                echo "<li><a href='?cate1=$cls_cate_big&cate2=$cls_cate_mid&cate3=$cls_cate_sm&cls_recom=$cls_recom&cls_basic=$cls_basic&cls_inter=$cls_inter&cls_adv=$cls_adv&search_bar=" . urlencode($search_bar) . "&page=$i' class='pre_rg_m click'>$i</a></li>";
              } else {
                echo "<li><a href='?cate1=$cls_cate_big&cate2=$cls_cate_mid&cate3=$cls_cate_sm&cls_recom=$cls_recom&cls_basic=$cls_basic&cls_inter=$cls_inter&cls_adv=$cls_adv&search_bar=" . urlencode($search_bar) . "&page=$i' class='pre_rg_m'>$i</a></li>";
              }
            }
            if ($page < $total_page) {
              if ($total_block > $block_num) {
                $next = $block_num * $block_ct + 1;
                echo "<li><a href='?cate1=$cls_cate_big&cate2=$cls_cate_mid&cate3=$cls_cate_sm&cls_recom=$cls_recom&cls_basic=$cls_basic&cls_inter=$cls_inter&cls_adv=$cls_adv&search_bar=" . urlencode($search_bar) . "&page=$next' class='pre_rg_m'><i class='fa-solid fa-chevron-right'></i></a></li>";
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
    //cate1 대분류
    $("#cate1").change(function () {
    let cate1 = $(this).val();
    let data = {
      cate1: cate1
    };
    $.ajax({
      async: false,
      type: "post",
      data: data,
      url: "../category/category_add2.php",
      dataType: "html",
      success: function (return_data) {
        $("#cate2").html(return_data);
      }
    });
  });
  //cate2 중분류
  $("#cate2").change(function () {
    let cate2 = $(this).val();
    let data = {
      cate2: cate2
    };
    $.ajax({
      async: false,
      type: "post",
      data: data,
      url: "../category/category_add3.php",
      dataType: "html",
      success: function (return_data) {
        $("#cate3").html(return_data);
      },
    });
  });

  //강좌 삭제 버튼
  $('.btn_class_delete').click((e)=>{
    let clidx = $(e.target).val();
    let confirmDelete = confirm('강좌를 삭제하시겠습니까?');
      let data = {
        clidx:clidx,
        confirmDelete:confirmDelete 
      }
      if(confirmDelete==true){
        $.ajax({
          async:true,
          type:'post',
          url:'class_delete.php',
          data:data,
          dataType:'json',
          success: function(action){
            if(action.success){
              alert('강좌 삭제');
              location.href = 'class_list.php';
            } else {
            alert('강좌 삭제 실패');
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