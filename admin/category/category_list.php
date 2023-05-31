<?php
  session_start();
  $_SESSION['TITLE'] = "과정 카테고리";
  $_SESSION['NAME'] = "category";
  if(!$_SESSION['AID']){
    echo 
      "<script>
        alert('접근 권한이 없습니다');
        history.back();
      </script>";
  };
  
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/category_del.css" />
  <link rel="stylesheet" href="/ksv_lms/admin/css/category.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  $query = "SELECT * from lms_category WHERE cate_step=3";
  $result = $mysqli->query($query) or die("Query Error! => ".$mysqli->error);
  while($rs = $result->fetch_object()){
    $rsc[]=$rs; //검색된 상품 목록 배열에 담기
  }
?>

      <main class="main_container content_pd">
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <div class="bookmark">
              <input type="checkbox" id="bookmark1" value="<?php echo $name; ?>" <?php if($row['m_title']==$name) echo "checked"; ?>/>
              <label for="bookmark1"><i class="fa-solid fa-bookmark"></i></label>
            </div>
            <h2 class="main_tt pre_bold_l">과정 카테고리 관리</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo" />
        </div>
        <div class="cate_list_btn_wrapper d-flex pd-54 gap-3">
          <button class="btn_m_pc pre_rg_m" type="submit" onclick="location.href = 'category_add.php';">
            카테고리 등록
          </button>
          <button class="btn_m_sc pre_rg_m">
            카테고리 수정
          </button>
        </div>
        <table class="table">
          <thead class="pre_rg_m">
            <tr>
              <!-- <th scope="col">번호</th> -->
              <th scope="col">대분류</th>
              <th scope="col">중분류</th>
              <th scope="col">소분류</th>
              <th scope="col">삭제</th>
            </tr>
          </thead>
          <tbody class="pre_rg_s">
            <?php
            if (empty($rsc)) {
              // 등록된 카테고리가 없을 경우
              echo '<tr><td colspan="4">등록된 카테고리가 없습니다.</td></tr>';
            } else {
              foreach($rsc as $r){
            ?>
              <tr class="cate_list">
                <td class="cate1"></td>
                <td class="cate2"></td>
                <td class="cate3" data-pcode="<?php echo $r->cate_pcode; ?>"><?php echo $r->cate_name; ?></td>
                <td><button class="btn_s_pr pre_rg_s del">카테고리 삭제</button></td>
              </tr>
            <?php } }?>
          </tbody>
        </table>
        <!-- 삭제 팝업 HTML -->
        <div class="background">
          <div class="window">
            <div class="popup d-flex flex-column align-items-center justify-content-center">
              <div class="d-flex flex-column align-items-center">
                <p class="title pre_bold_m">카테고리를 삭제하시겠습니까?</p>
                <div class="popup_btns d-flex gap-3">
                  <button class="btn_m_pr pre_rg_m"><a id="deletebtn">삭제하기</a></button>
                  <button class="btn_m_sc pre_rg_m"><a id="close">취소하기</a></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>
<script src="./functions.js"></script>
<script>
  function show() {
    document.querySelector(".background").className = "background show";
  }
  // 삭제 버튼(바깥)을 누르면 할일
  $(".del").click(function(){
    $(".background").addClass('show');
    let tr = $(this).closest('tr');
    let cateidx = tr.attr('id');
    let title = tr.find('.trtitle').text();
    $(".background").find('input').attr('placeholder',title);

    $('#deletebtn').click(()=>{
      delAjax(cateidx, './category_del.php', './category_list.php')
    });
    
  });
  
  // 취소 버튼 누르면 할일
  $("#close").click(function(){
    $(".background").removeClass('show');
  });

  // 등록한 카테고리 리스트 출력
  $('.cate_list').each(function(){
  let cate2 = $(this).find('.cate3').attr('data-pcode');
  let cate2name = $(this).find(".cate2");
  let cate1name = $(this).find(".cate1");
  let data = {
    cate2 : cate2
  };

  $.ajax({
    async: false,
    type:'post',
    data:data,
    url: "category_list2.php", 
    success: function(returned_data){
      console.log(returned_data);
      cate2name.text(returned_data);
    }
  });

  $.ajax({
    async: false,
    type:'post',
    data:data,
    url: "category_list1.php", 
    success: function(returned_data){
      console.log(returned_data);
      cate1name.text(returned_data);
    }
  });
});
</script>
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>