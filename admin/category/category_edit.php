<?php
  session_start();
  $_SESSION['TITLE'] = "카테고리 수정";
  if(!$_SESSION['AID']){
    echo
      "<script>
        alert('접근 권한이 없습니다');
        history.back();
      </script>";
  };
  
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/category_add.css" />
<?php
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_aside.php";

  $cateidx = $_GET['idx'];
  $sql = "SELECT * from lms_category WHERE cate_step=1";
  $result = $mysqli -> query($sql) or die("Query Error ! => ".$mysqli -> error);
  while($rs = $result -> fetch_object()){
    $cate1[]=$rs;
  }

  $sql2 = "SELECT * from lms_category WHERE cateidx={$cateidx}";
  $result2 = $mysqli -> query($sql2) or die("Query Error ! => ".$mysqli -> error);
  $row = $result2 -> fetch_assoc();

?>
      <main class="main_container content_pd">
        <div class="tt_wrapper d-flex justify-content-between align-items-center">
          <div class="d-flex justify-content-between align-items-center gap-3">
            <h2 class="main_tt pre_bold_l">카테고리 수정(teacher)</h2>
          </div>
          <img src="/ksv_lms/admin/img/img_logo.png" alt="logo" />
        </div>
        <div class="category_wrapper">
          <form method="post" action="category_edit_ok.php">
            <input type="hidden" id="cateidx" name="cateidx" value="<?php echo $cateidx; ?>">
            <input type="hidden" id="cate_name" name="cate_name" value="<?php echo $cate_name; ?>">
            <input type="hidden" id="cate_code" name="cate_code" value="<?php echo $cate_code; ?>">
            <input type="hidden" id="cate_pcode" name="cate_pcode" value="<?php echo $cate_pcode; ?>">
            <input type="hidden" id="cate_step" name="cate_step" value="<?php echo $cate_step; ?>">

            <div class="d-flex justify-content-between mb-5">
              <div class="select_container">
                <select class="select_cate" id="cate1" name="cate1" aria-label=".form-select-lg example">
                  <option selected>대분류</option>
                  <?php
                    foreach($cate1 as $c){
                      print_r($c->cate_code);
                      print_r($row['cate_code']);
                  ?>
                  <option value="<?php echo $c->cate_code; ?>"><?php echo $c->cate_name; ?></option>
                  <?php
                    }
                  ?>
                </select>
              </div>
              <div class="select_container">
                <select name="cateidx" class="select_cate" aria-label=".form-select-lg example" name="cate2" id="cate2">
                  <option selected>중분류</option>
                </select>
               
              </div>
              <div class="select_container">
                <select name="cateidx" class="select_cate" aria-label=".form-select-lg example" name="cate3" id="cate3">
                  <option selected>소분류</option>
                </select>
  
              </div>
            </div>
            <div class="btn_wrapper d-flex justify-content-end gap-3">
              <button type="button" class="btn_m_pc pre_rg_m" onclick="category_edit('<?php echo $cateidx; ?>')">카테고리 수정</button>
              <button type="button" class="btn_m_sc pre_rg_m" onclick="location.href='category_list.php'">취소</button>
            </div>
          </form>
        </div>
      </main>
      <div class="modal_bg">
        <!-- cate1 Modal -->
        <dialog class="cate1Modal" id="cate1Modal">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="pre_bold_m">대분류 등록</h2>
            </div>
            <div class="modal-body d-flex flex-coulmn">
              <input type="text" name="name1" id="name1" placeholder="카테고리명" />
              <input type="text" name="code1" id="code1" placeholder="코드 입력" />
            </div>
            <div class="modal-footer row justify-content-center gap-4 mt-5">
              <button type="button" class="btn_m_pc pre_rg_m" onclick="category_save(1)">
                카테고리 등록
              </button>
              <button type="button" class="modal_close btn_m_pr pre_rg_m">
                취소
              </button>
            </div>
          </div>
        </dialog>

        <!-- cate2 Modal -->
        <dialog class="cate2Modal" id="cate2Modal">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="pre_bold_m">중분류 등록</h2>
            </div>
            <div class="modal-body d-flex flex-coulmn">
              <input type="text" name="name2" id="name2" placeholder="카테고리명"/>
              <select name="pcode" id="pcode2">
                <option selected>대분류 선택</option>
                <?php 
                  foreach($cate1 as $c){
                ?>
                  <option value="<?php echo $c->cate_code; ?>"><?php echo $c->cate_name; ?></option>
                <?php
                  }
                ?>
                <!-- {category1} select#cate1에서 선택된 값이 있을 경우 이 자리에 해당 option을 selected하여 보이게 -->
              </select>
              <input type="text" name="code2" id="code2" placeholder="코드 입력"/>
            </div>
            <div class="modal-footer row justify-content-center gap-4 mt-5">
              <button type="button" class="btn_m_pc pre_rg_m" onclick="category_save(2)">
                카테고리 등록
              </button>
              <button type="button" class="modal_close btn_m_pr pre_rg_m">
                취소
              </button>
            </div>
          </div>
        </dialog>

        <!-- cate3 Modal -->
        <dialog class="cate3Modal" id="cate3Modal">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="pre_bold_m">소분류 등록</h2>
            </div>
            <div class="modal-body d-flex flex-coulmn">
              <input type="text" name="name3" id="name3" placeholder="카테고리명"/>
              <select name="pcode" id="pcode2_1">
                <option selected>대분류 선택</option>
                <?php 
                  foreach($cate1 as $c){
                ?>
                  <option value="<?php echo $c->cate_code; ?>"><?php echo $c->cate_name; ?></option>
                <?php
                  }
                ?>
                <!-- {category1} select#cate1에서 선택된 값이 있을 경우 이 자리에 해당 option을 selected하여 보이게 -->
              </select>
              <select name="pcode" id="pcode3">
                <option selected>중분류 선택</option>
                <!-- {category2} category4.php  select#cate2에서 선택된 값이 있을 경우 이 자리에 해당 option을 selected하여 보이게-->
              </select>
              <input type="text" name="code3" id="code3" placeholder="코드 입력"/>
            </div>
            <div class="modal-footer row justify-content-center gap-4 mt-5">
              <button type="button" class="btn_m_pc pre_rg_m" onclick="category_save(3)">
                카테고리 등록
              </button>
              <button type="button" class="modal_close btn_m_pr pre_rg_m">
                취소
              </button>
            </div>
          </div>
        </dialog>
      </div>

    </div>
    
  <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
  ?>
  <script>
    //div.select-container:nth-child button 누르면 각각 dialog show()
    function open_Modal(idx) {
      $(".modal_bg dialog").eq(idx).show();
      $(".modal_bg").addClass("active");
    }
    //.modal_close를 click하면 dialog hide()
    $(".modal_close").click(() => {
      $(".modal_bg dialog").hide();
      $(".modal_bg").removeClass("active");
    });

    //cate1 change 할일  category2.php cate1에 아래 중분류 cate2를 #cate2에 html로 넣어주기
    $("#cate1").change(function () {
      let cate1 = $(this).val();
      let data = {
        cate1: cate1
      };
      $.ajax({
        async: false,
        type: "post",
        data: data,
        url: "category_edit2.php",
        dataType: "html",
        success: function (return_data) {
          $("#cate2").html(return_data);
        }
      });
    }); // #cate1 change

    //cate2 change 할일  category3.php cate2에 아래 소분류 cate3를 #cate3에 html로 넣어주기
    $("#cate2").change(function () {
      let cate2 = $(this).val();
      let data = {
        cate2: cate2
      };
      $.ajax({
        async: false,
        type: "post",
        data: data,
        url: "category_edit3.php",
        dataType: "html",
        success: function (return_data) {
          $("#cate3").html(return_data);
        },
      });
    }); //#cate2 change

    // function category_edit(){}
    function category_edit(cate_step) {
      let cate_name = $("#name" + cate_step).val();
      let cate_code = $("#code" + cate_step).val();
      let cate_pcode = $("#pcode" + cate_step + " option:selected").val();

      if (cate_step > 1 && !cate_pcode) {
        alert("상위 분류를 선택하세요");
        return;
      }
      if (!cate_code) {
        alert("분류 코드를 입력하세요");
        return;
      }
      if (!cate_name) {
        alert("카테고리명을 입력하s세요");
        return;
      }
      let data = {
        cate_name: cate_name,
        cate_code: cate_code,
        cate_pcode: cate_pcode,
        cate_step: cate_step,
      };
      $.ajax({
        async: false,
        type: "post",
        data: data,
        url: "edit_category.php",
        dataType: "json",
        error: function () {},
        success: function (return_data) {
          if (return_data.result == 1) {
            alert("새 카테고리가 등록되었습니다");
            location.reload();
          } else if (return_data.result == -1) {
            alert("입력한 코드명 또는 카테고리명이 이미 존재합니다");
            location.reload();
          } else {
            alert("카테고리 등록에 실패했습니다");
          }
        },
      });
    }
  </script>
  <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
  ?>