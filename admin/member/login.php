<?php
  session_start();
  $_SESSION['TITLE'] = "로그인";
  include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_header.php";
?>
  <link rel="stylesheet" href="/ksv_lms/admin/css/login.css" />
  <link rel="stylesheet" href="/ksv_lms/admin/css/popup.css" />

  </head>
  <body>
  <section class="notice_portfolio">
        <h2>
          본 사이트는 구직용 포트폴리오 사이트입니다.<br />
        </h2>
        <div>
          <p>※ 본 포트폴리오는 무단으로 복제 , 배포, 사용할 수 없습니다.</p>
        </div>
        <hr>
        <div>
          <p>학습기간 : 22.10.27 ~ 23.04.19</p>
          <p>제작기간 : 23.04.25 ~ 23.05.26</p>
          <p>특징: HTML, CSS, Javascript, JQuery, PHP 활용</p>
          <p>구현 완료 페이지 : 
            <a href="admin/board/board_list.php">Admin Board,</a>
            <a href="admin/class/class_list.php"> Admin Class,</a>
            <a href="admin/lecture/lecture_list.php"> Admin Lecture</a>
          </p>
        </div>
        <hr>
        <div>
          <div>
            <h3>&#8251; 기획, 디자인, 구현</h3>
            <ul>
              <li>Admin Board : 김지은 100%</li>
              <li>Admin Class : 김지은 100%</li>
              <li>Admin Lecture : 김지은 50%</li>
              <li>4차 기획서 : <a href="https://www.figma.com/file/BU3yqu4cKjoSD7MiMNoSxv/about_wldms?type=design&node-id=110%3A3067&t=P2dkwlfdI5qZmZPr-1">Figma</a></li>
              <li>코드보러가기 : <a href="https://github.com/wldms97/4th_KSV_LMS.git">Git Hub</a></li>
            </ul>
          </div>
        </div>
        <p>
          <input
            type="checkbox"
            name="cookieCheck"
            id="cookieCheck"
          />
          <label for="cookieCheck">오늘 하루 보지않기</label>
        </p>
        <button>모달창 닫기 버튼</button>
    </section>
    <main class="inner d-flex justify-content-around align-items-center">
      <section class="img_wrapper deco sticky">
        <div class="img_container deco sticky">
          <p>Korean Silicon Valley</p>
          <div class="slogan"><span class="keyword"></span> 배우는 코딩</div>
          <img src="/ksv_lms/admin/img/img_login1.png" alt="img_login" />
        </div>
      </section>
      <section class="login_wrapper signup sticky">
        <img src="/ksv_lms/admin/img/img_logo.png" alt="logo" />
        <p class="pre_bold_l mt-5">Welcome to Korean Silicon Valley!</p>
        <p class="pre_rg_m">
          This web page is for Admin. If you user,
          <a href="/ksv_lms/user/member/login.php">click this link.</a>
        </p>
        <div class="login_form">
          <form action="login_ok.php" method="post">
            <div class="d-flex flex-column justify-content-between my-5">
              <label for="adminid" class="pre_rg_m">ID</label>
              <input type="text" name="adminid" id="adminid" required placeholder="admin" />
            </div>
            <div class="d-flex flex-column justify-content-between my-5">
              <label for="adminpw" class="pre_rg_m">Password</label>
              <input type="password" name="adminpw" id="adminpw" placeholder="1111" required />
            </div>
            <button type="submit" class="btn_l pre_rg_l my-3 btn_login">
              LOG IN
            </button>
            <ul class="find_wrap d-flex justify-content-end mt-3 gap-3 pre_rg_s">
              <li>
                <a href="#" class="find_text">ID 찾기</a>
              </li>
              <li>
                <a href="#" class="find_text">Password 찾기</a>
              </li>
            </ul>
          </form>
        </div>
      </section>
    </main>

  <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer.php";
  ?>
  <script src="/ksv_lms/admin/js/login.js"></script>
  <script src="/ksv_lms/admin/js/popup.js"></script>
  <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
  ?>
