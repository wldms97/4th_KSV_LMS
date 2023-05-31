<?php
  session_start();
  $_SESSION['TITLE'] = "회원가입";
  // $uid = $_SESSION['AID'];
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/login.css" />

  </head>
  <body>
    <main class="inner d-flex justify-content-around align-items-center">
      <section class="img_wrapper deco sticky">
        <div class="img_container deco sticky">
          <p>Korean Silicon Valley</p>
          <div class="slogan"><span class="keyword"></span> 배우는 코딩</div>
          <img src="/ksv_lms/admin/img/img_signup.png" alt="img_login" />
        </div>
      </section>
      <section class="signup_wrapper signup sticky">
        <div class="sign_form">
          <h2 class="pre_bold_l">sign up</h2>
          <form action="signup_ok.php" method="post" class="form_signup">
            <div class="d-flex flex-column justify-content-between my-4">
              <label for="username" class="pre_bold_m">이름 <span>*</span></label>
              <input
                type="text"
                name="username"
                id="username"
                placeholder="이름을 입력하세요."
                required
              />
            </div>
            <div class="d-flex justify-content-between align-items-end my-4">
              <div class="d-flex flex-column justify-content-between id_wrapper">
                <label for="userid" class="pre_bold_m">아이디 <span>*</span></label>
                <input
                  type="text"
                  name="userid"
                  id="userid"
                  placeholder="아이디를 입력하세요."
                  data-pass="no"
                  required
                />
              </div>
              <button type="button" class="btn_id btn_s_sc pre_rg_s">ID 중복확인</button>
            </div>
            <div class="d-flex flex-column justify-content-between my-4">
              <label for="userpw" class="pre_bold_m">비밀번호 <span>*</span></label>
              <input
                type="password"
                name="userpw"
                id="userpw"
                placeholder="비밀번호를 입력하세요."
                required
              />
            </div>
            <div class="d-flex flex-column justify-content-between my-4 confirm_pw">
              <label for="userpw" class="pre_bold_m">비밀번호 확인 <span>*</span></label>
              <input
                type="password"
                name="userpw"
                id="confirm_pw"
                data-pass="no"
                placeholder="비밀번호를 다시 한 번 입력해주세요."
                required
              />
            </div>
            <div class="d-flex flex-column justify-content-between my-4">
              <label for="useremail" class="pre_bold_m">이메일 <span>*</span></label>
              <input
                type="email"
                name="useremail"
                id="useremail"
                placeholder="이메일을 입력해주세요."
                required
              />
            </div>
            <div class="d-flex flex-column justify-content-between my-4">
              <label for="userphone" class="pre_bold_m">전화번호 <span>*</span></label>
              <input
                type="tel"
                name="userphone"
                id="userphone"
                placeholder="전화번호를 입력해주세요."
                required
              />
            </div>
            <div class="attach_file my-4">
              <p class="pre_bold_m">프로필 이미지</p>
              <div class="d-flex">
                <label for="user_profile" class="pre_rg_s">파일선택</label>
                <input type="file" id="user_profile" name="user_profile" class="file_hidden">
                <input class="file_name" value="파일을 첨부해주세요." placeholder="파일을 첨부해주세요.">
              </div>
            </div>
            <div class="d-flex flex-column justify-content-between my-4">
              <h3 class="pre_bold_m">
                관심 카테고리
                <i class="fa-regular fa-circle-question"
                  data-bs-toggle="tooltip"
                  data-bs-placement="right"
                  data-bs-title="해당 카테고리에 대한 강의를 추천받을 수 있습니다."></i>
              </h3>
              <?php
                $query = "SELECT * from lms_category where cate_step=3";
                $result = $mysqli -> query($query) or die("query error =>".$mysqli-->error);
                while($rs = $result -> fetch_object()){
                  $cate3[]=$rs;
                }
              ?>
              <label for="cate_like1"></label>
              <select name="cate_like1" id="cate_like1" class="form-select my-2">
                <option selected value="none" class="pre_rg_s">
                  관심있는 카테고리를 선택하세요
                </option>
                <?php 
                  foreach($cate3 as $c){
                ?>
                  <option value="<?php echo $c->cate_code; ?>"><?php echo $c->cate_name; ?></option>
                <?php
                  }
                ?>
              </select>
              <label for="cate_like2"></label>
              <select name="cate_like2" id="cate_like2" class="form-select my-2">
                <option selected value="none" class="pre_rg_s">
                  관심있는 카테고리를 선택하세요
                </option>
                <?php 
                  foreach($cate3 as $c){
                ?>
                  <option value="<?php echo $c->cate_code; ?>"><?php echo $c->cate_name; ?></option>
                <?php
                  }
                ?>
              </select>
            </div>
            <div class="d-flex flex-column justify-content-between my-4">
              <label for="user_ability" class="user_ability pre_bold_m">나의 실력</label>
              <span id="range" class="pre_bold_s">당신의 실력을 알려주세요</span>
              <input type="range" class="form-range" min="0" max="5" name="user_ability" id="user_ability" onchange="check_ability()"/>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="total-agree"/>
              <label for="total-agree" class="form-check-label pre_bold_s">전체 약관 동의</label>
            </div>
            <hr />
            <div class="form-check">
              <input type="checkbox" class="form-check-input autocheck" name="use_agree" id="use_agree" value="1" required/>
              <div class="d-flex justify-content-between">
                <label for="use_agree" class="form-check-label pre_rg_s">[필수] 코리안 실리콘밸리 이용 약관에 동의<span>*</span></label>
                <span class="invalid-feedback"> 필수 동의 요소입니다. </span>

                <!-- Button trigger modal -->
                <button type="button" class="see_more" data-bs-toggle="modal" data-bs-target="#use_agreeModal">
                  <i class="fa-solid fa-angle-right"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="use_agreeModal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel1">
                          [필수] 패스트코드 이용 약관에 동의
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <?php   
                          $query = "SELECT * from lms_terms where termtype='use_agree'"; 
                          $result = $mysqli -> query($query) or die("query error =>".$mysqli-->error);
                          $rs = $result -> fetch_object();
                          echo nl2br($rs -> content);
                        ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          취소
                        </button>
                        <button type="button" id="modal_use_agree" class="btn btn-primary" data-bs-dismiss="modal">
                          약관 동의
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input autocheck" name="personalinfo_agree" id="personalinfo_agree" value="1" required />
              <div class="d-flex justify-content-between">
                <label for="personalinfo_agree" class="form-check-label pre_rg_s">[필수] 개인정보 수집 및 이용에 동의 <span>*</span></label>
                <span class="invalid-feedback"> 필수 동의 요소입니다. </span>
                <!-- Button trigger modal -->
                <button type="button" class="see_more" data-bs-toggle="modal" data-bs-target="#personalinfo_agreeModal">
                  <i class="fa-solid fa-angle-right"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="personalinfo_agreeModal" tabindex="-1" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel2">
                          [필수] 개인정보 수집 및 이용에 동의<span>*</span>
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <?php   
                          $query = "SELECT * from lms_terms where termtype='personalinfo_agree'"; 
                          $result = $mysqli -> query($query) or die("query error =>".$mysqli-->error);
                          $rs = $result -> fetch_object();
                          echo nl2br($rs -> content);
                        ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          취소
                        </button>
                        <button type="button" id="modal_personalinfo_agree" class="btn btn-primary" data-bs-dismiss="modal">
                          약관 동의
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input autocheck" name="marketing_agree" id="marketing_agree" value="1"/>
              <div class="d-flex justify-content-between">
                <label for="marketing_agree" class="form-check-label pre_rg_s">[선택] 마케팅 정보 수신 및 선택적 개인정보 제공</label>
                <!-- Button trigger modal -->
                <button type="button" class="see_more" data-bs-toggle="modal"data-bs-target="#marketing_agreeModal">
                  <i class="fa-solid fa-angle-right"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="marketing_agreeModal" tabindex="-1" aria-labelledby="exampleModalLabel3" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h2 class="modal-title fs-5" id="exampleModalLabel3">
                          [선택] 마케팅 정보 수신 및 선택적 개인정보 제공
                        </h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <?php   
                          $query = "SELECT * from lms_terms where termtype='marketing_agree'"; 
                          $result = $mysqli -> query($query) or die("query error =>".$mysqli-->error);
                          $rs = $result -> fetch_object();
                          echo nl2br($rs -> content);
                        ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                          취소
                        </button>
                        <button type="button" id="modal_marketing_agree" class="btn btn-primary" data-bs-dismiss="modal">
                          약관 동의
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn_xl pre_rg_l mb-3 mt-5 btn_signup">
              회원가입
            </button>
            <div class="signup_comment d-flex justify-content-center gap-3">
              <p class="pre_rg_s">이미 회원이신가요?</p>
              <a href="/ksv_lms/admin/member/login.php" class="pre_bold_s">로그인 하기</a>
            </div>
          </form>
        </div>
      </section>
    </main>

  <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
  ?>
  <script src="/ksv_lms/admin/js/signup.js"></script>
  <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
  ?>
