<?php
    session_start();
    $_SESSION['TITLE'] = "쿠폰 수정";

include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";

$cno = $_GET['idx'];
$sql = "SELECT * from lms_coupon where couidx=$cno"; //idx번호에 맞는 게시글 추출 구문 저장
$result = $mysqli->query($sql); //게시글 추출 구문 실행
$row = $result->fetch_assoc(); // 게시글 추출내용을 연관배열로 저장
?>
    <link rel="stylesheet" href="../css/coupon/coupon.css" />
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";
?>
      <main class="main_container content_pd">
        <div
          class="tt_wrapper d-flex justify-content-between align-items-center"
        >
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h2 class="main_tt pre_bold_l">쿠폰 수정</h2>
          </div>
          <img src="../img/img_logo.png" alt="logo" />
        </div>
        <form method="post" action="coupon_edit_ok.php"  class="d-flex flex-column"
        >
        <input type="hidden" name="couidx" value="<?php echo $cno;?>">
          <div class="thumbnail">
            <p class="pre_bold_m">쿠폰명</p>
            <input
              type="text"
              class="input-field"
              placeholder="쿠폰명을 입력해주세요."
              aria-label="Recipient's username"
              aria-describedby="basic-addon2"
              name="cou_name"
              id="cou_name"
              value="<?php echo $row['cou_name']; ?>"
            />
          </div>
          <div class="price">
            <p class="pre_bold_m">가격옵션(할인유형/최소주문금액/할인폭)</p>
            <div class="d-flex">
            <select name="cou_type" id="cou_type">
                    <option>가격옵션</option>
                    <option value="1" <?php if($row['cou_type']==1) echo "selected='selected'"; ?>>정액</option>
                    <option value="2" <?php if($row['cou_type']==2) echo "selected='selected'"; ?>>정율</option>
                </select>
                <input type="text" placeholder="최소주문금액" name="cou_min_price" id="cou_min_price"
                value="<?php echo $row['cou_min_price']; ?>"
                />
              <input type="text" placeholder="할인" name="cou_discount" id="cou_discount" value="<?php
                if($row['cou_type']==1){
                  echo $row['cou_price'];
                }else{
                  echo $row['cou_ratio'];
                }
              ?>"/>
              <!-- <input type="text" placeholder="%" name="cou_ratio" id="cou_ratio"/> -->
            </div>
          </div>
          <div class="method">
            <p class="pre_bold_m">발급방식</p>
            <div class="d-flex">
              <select name="cou_passive" id="cou_passive">
                <option>발급방식</option>
                <option value="1" <?php if($row['cou_passive']==1) echo "selected='selected'"; ?>>자동</option>
                <option value="2" <?php if($row['cou_passive']==2) echo "selected='selected'"; ?>>수동</option>
              </select>
              <select name="cou_status" id="cou_status">
                <option>상태</option>
                <option value="0" <?php if($row['cou_status'] == 0) echo "selected='selected'"; ?>>대기</option>
                <option value="1" <?php if($row['cou_status'] == 1) echo "selected='selected'"; ?>>사용</option>
                <option value="-1" <?php if($row['cou_status'] == -1) echo "selected='selected'"; ?>>마감</option>
              </select>
            </div>
          </div>
          <div class="deadline">
            <p class="pre_bold_m">쿠폰기한</p>
            <div class="d-flex">
              <input type="date" name="cou_regdate" id="cou_regdate" value="<?php if($row['cou_regdate'] != NULL) echo $row['cou_regdate']; ?>"/>
              <input type="date" name="cou_duedate" id="cou_duedate" value="<?php if($row['cou_duedate'] != NULL) echo $row['cou_duedate']; ?>"/>
              <div class="checkbox d-flex">
              <input type="checkbox" name="date_limit" id="date_limit" <?php if($row['cou_regdate'] == NULL) echo "checked" ?>/>
                <input type="hidden" name="date_limit" id="checked" value='<?php
                  if($row['cou_regdate']!= NULL){
                    echo 1;
                  }else{
                    echo 0;
                  }
                ?>' checked/>
                <label for="">기한없음</label>
              </div>
            </div>
          </div>
          <div class="ebutton d-flex">
            <button class="btn_m_sc pre_rg_m" onclick="history.back();">취소</button>
            <button class="btn_m_pc pre_rg_m">쿠폰 수정</button>
          </div>
        </form>
      </main>
    </div>
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
?>  
<script src="../js/coupon/coupon.js"></script>
<?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
?>

