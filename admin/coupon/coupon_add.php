<?php
    session_start();
    $_SESSION['TITLE'] = "쿠폰 등록";

include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
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
            <h2 class="main_tt pre_bold_l">쿠폰 등록</h2>
          </div>
          <img src="../img/img_logo.png" alt="logo" />
        </div>
        <form method="post" action="coupon_add_ok.php" class="d-flex flex-column">
          <div class="sub thumbnail">
            <label for="cou_name" class="pre_bold_m">쿠폰명</label>
            <input
              type="text"
              class="input-field"
              placeholder="쿠폰명을 입력해주세요."
              aria-label="Recipient's username"
              aria-describedby="basic-addon2"
              name="cou_name"
              id="cou_name"
            />
          </div>
          <div class="sub price">
            <label for="cou_discount" class="pre_bold_m">가격옵션</label>
            <div class="d-flex">
                <select name="cou_type" id="cou_type">
                    <option>가격옵션</option>
                    <option value="1">정액</option>
                    <option value="2">정율</option>
                </select>
                <input type="text" placeholder="최소주문금액" name="cou_min_price" id="cou_min_price"/>
              <input type="text" placeholder="할인폭" name="cou_discount" id="cou_discount"/>
            </div>
          </div>
          <div class="sub method">
            <label class="pre_bold_m">발급방식</label>
            <div class="d-flex">
              <select name="cou_passive" id="cou_passive">
                <option>발급방식</option>
                <option value="1">자동</option>
                <option value="2">수동</option>
              </select>
              <select name="cou_status" id="cou_status">
                <option>상태</option>
                <option value="0">대기</option>
                <option value="1">사용</option>
                <option value="-1">마감</option>
              </select>
            </div>
          </div>
          <div class="sub deadline">
            <label class="pre_bold_m">쿠폰기한</label>
            <div class="d-flex">
              <input type="date" name="cou_regdate" id="cou_regdate"/>
              <input type="date" name="cou_duedate" id="cou_duedate"/>
              <div class="checkbox d-flex">
                <input type="checkbox" name="date_limit" id="date_limit" />
                <input type="hidden" name="date_limit" id="checked" value='1' checked/>
                <label for="">기한없음</label>
              </div>
            </div>
          </div>
          <div class="ebutton d-flex">
            <button class="btn_m_sc pre_rg_m" onclick='history.back()' type="button">취소</button>
            <button class="btn_m_pc pre_rg_m" type="submit">쿠폰 등록</button>
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

