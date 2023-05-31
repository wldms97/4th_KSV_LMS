</head>
<body>
  <div class="common_wrapper">
    <?php
      //현재 로그인한 관리자 정보 가져오기
      $adminname = $_SESSION['ANAME'];
      $adminid = $_SESSION['AID'];
      $sql = "SELECT * FROM lms_admin where super=1" ;
      $result = $mysqli -> query($sql) or die("query error =>".$mysqli->error);
      $rs = $result -> fetch_object();

    ?>
    <aside>
      <div class="aside_container">
        <div class="profile_wrapper">
          <div class="admin_profile">
            <?php
              if($rs->admin_profile == ''){
            ?>
              <img src="/ksv_lms/admin/img/profile.jpg" style="width:150px;"/>
            <?php
              }else{
            ?>
              <img src="<?php echo $rs->admin_profile ?>" alt="관리자 프로필" />
            <?php
              }
            ?>
          </div>
          <p class="admin_name pre_rg_l"><?php echo $rs->adminid ?> 님</p>
          <div class="d-flex justify-content-center gap-3">
            <div class="icon_wrapper">
              <a href="#"><i class="fa-solid fa-gear"></i></a>
            </div>
            <div class="icon_wrapper">
              <a href="#"><i class="fa-regular fa-calendar-days"></i></a>
            </div>
            <div class="icon_wrapper">
              <a href="<?php $_SERVER['DOCUMENT_ROOT']?>/ksv_lms/admin/member/logout_action.php"><i class="fa-solid fa-arrow-right-from-bracket"></i></a>
            </div>
          </div>
        </div>
        <div class="accordion mt-5" id="main-menu-wrap">
          <div class="accordion-item">
            <h2 class="accordion-header" id="hdDashboard">
              <a
                class="accordion-button"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuDashboard"
                aria-expanded="true"
                aria-controls="menuDashboard"
              >
                <i class="fa-solid fa-chart-line"></i>
                <span  onclick="location.href='/ksv_lms/admin/dashboard.php'" class="main-menu-ft pre_rg_l">대시보드</span >
              </a>
            </h2>
            <div
              id="menuDashboard"
              class="accordion-collapse collapse show"
              aria-labelledby="hdDashboard"
              data-bs-parent="#main-menu-wrap"
            ></div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="hdUser">
              <a
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuUser"
                aria-expanded="false"
                aria-controls="menuUser"
              >
                <i class="fa-solid fa-user-group"></i>
                <span class="main-menu-ft pre_rg_l">회원 관리</span>
              </a>
            </h2>
            <div
              id="menuUser"
              class="accordion-collapse collapse"
              aria-labelledby="hdUser"
              data-bs-parent="#main-menu-wrap"
            >
              <ul class="accordion-body">
                <li>
                  <a href="/ksv_lms/admin/member/member_main.php" class="sub-menu-ft">
                    <span>&middot;</span><span>회원정보</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span><span>강사정보</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span><span>관리자정보</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span><span>휴면/탈퇴회원</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="hdCourse">
              <a
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuCourse"
                aria-expanded="false"
                aria-controls="menuCourse"
              >
                <i class="fa-solid fa-graduation-cap"></i>
                <span class="main-menu-ft pre_rg_l">강좌 관리</span>
              </a>
            </h2>
            <div
              id="menuCourse"
              class="accordion-collapse collapse"
              aria-labelledby="hdCourse"
              data-bs-parent="#main-menu-wrap"
            >
              <ul class="accordion-body">
                <li>
                  <a href="/ksv_lms/admin/category/category_list.php" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span>과정카테고리</span>
                  </a>
                </li>
                <li>
                  <a href="/ksv_lms/admin/class/class_list.php" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span>강좌정보</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="hdEvent">
              <a
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuEvent"
                aria-expanded="false"
                aria-controls="menuEvent"
              >
                <i class="fa-solid fa-bullhorn"></i>
                <span class="main-menu-ft pre_rg_l">이벤트 관리</span>
              </a>
            </h2>
            <div
              id="menuEvent"
              class="accordion-collapse collapse"
              aria-labelledby="hdEvent"
              data-bs-parent="#main-menu-wrap"
            >
              <ul class="accordion-body">
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span onclick="location.href='/ksv_lms/admin/event/event_list.php'">이벤트정보</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span onclick="location.href='/ksv_lms/admin/coupon/coupon_list.php'">쿠폰정보</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="hdBoard">
              <a
                class="accordion-button collapsed"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#menuBoard"
                aria-expanded="false"
                aria-controls="menuBoard"
              >
                <i class="fa-solid fa-clipboard-question"></i>
                <span class="main-menu-ft pre_rg_l">게시판 관리</span>
              </a>
            </h2>
            <div
              id="menuBoard"
              class="accordion-collapse collapse"
              aria-labelledby="hdBoard"
              data-bs-parent="#main-menu-wrap"
            >
              <ul class="accordion-body">
                <li>
                  <a href="/ksv_lms/admin/board/board_list.php" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span>공지사항 게시판</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span>수강후기 게시판</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span>수강문의 게시판</span>
                  </a>
                </li>
                <li>
                  <a href="#" class="sub-menu-ft">
                    <span>&middot;</span>
                    <span>커뮤니티 게시판</span>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </aside>
