<?php
  session_start();
  $_SESSION['TITLE'] = "로그인";
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
  <?php
    include $_SERVER['DOCUMENT_ROOT']."/ksv_lms/admin/inc/admin_footer_tail.php";
  ?>
