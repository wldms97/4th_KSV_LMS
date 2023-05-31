// board_add.php 파일첨부 시 이름이 파일명으로 바뀔 수 있게 하는 스크립트
let fileTarget = document.querySelector('.attach_file .file_hidden');
  
  fileTarget.addEventListener('change', function() {
    let filename = "";
    if (window.FileReader) {
      filename = this.files[0].name;
    }
    // 추출한 파일명 삽입
    this.nextElementSibling.value = filename;
  });
