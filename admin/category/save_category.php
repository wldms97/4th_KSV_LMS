<?php
session_start();

// 데이터 처리 부분
if (isset($_POST['data'])) {
  $data = json_decode($_POST['data'], true);

  $cate_name = $data['cate_name'];
  $cate_code = $data['cate_code'];
  $cate_pcode = $data['cate_pcode'];
  $cate_step = $data['cate_step'];

  // 데이터베이스 연결 및 쿼리 실행
  include $_SERVER['DOCUMENT_ROOT'] . "/ksv_lms/admin/inc/db.php";

  // 중복 체크를 위한 쿼리
  $check_query = "SELECT COUNT(*) AS count FROM lms_category WHERE cate_name = '$cate_name' OR cate_code = '$cate_code'";
  $check_result = $mysqli->query($check_query) or die("query error =>" . $mysqli->error);
  $check_row = $check_result->fetch_object();

  if ($check_row->count > 0) {
    // 이미 존재하는 카테고리명 또는 코드명인 경우
    $response['result'] = -1;
  } else {
    // 새로운 카테고리 등록
    $insert_query = "INSERT INTO lms_category (cate_name, cate_code, cate_pcode, cate_step) VALUES ('$cate_name', '$cate_code', '$cate_pcode', '$cate_step')";
    $insert_result = $mysqli->query($insert_query) or die("query error =>" . $mysqli->error);

    if ($insert_result) {
      // 등록 성공
      $response['result'] = 1;
    } else {
      // 등록 실패
      $response['result'] = 0;
    }
  }

  // JSON 형식으로 응답 반환
  header('Content-Type: application/json');
  echo json_encode($response);
} else {
  // POST 데이터가 없는 경우
  $response['result'] = 0;

  // JSON 형식으로 응답 반환
  header('Content-Type: application/json');
  echo json_encode($response);
}
?>
