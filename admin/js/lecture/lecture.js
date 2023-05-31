// lecture_add.php 파일첨부 시 이름이 파일명으로 바뀔 수 있게 하는 스크립트
let fileTarget = document.querySelector(".lec_thumb #lec_thumb");

fileTarget.addEventListener("change", function () {
  let filename = "";
  if (window.FileReader) {
    filename = this.files[0].name;
  }
  // 추출한 파일명 삽입
  this.nextElementSibling.value = filename;
});
const modiform = document.querySelector("#lecture_modify");
const modibtns = document.querySelectorAll(".btn_edit");

// 강의리스트 추가
function tsplus() {
  const addHtml2 = document.querySelector("#lec_ts_content").innerHTML;
  const addHtml = `<div class="d-flex justify-content-between gap-3 lec_ts_up">${addHtml2}</div>`;

  document.querySelector("#lec_ts").insertAdjacentHTML("beforeend", addHtml);
}

// 멀티 파일 수정용
if (modibtns) {
  modibtns.forEach(function (btn) {
    btn.addEventListener("click", function (e) {
      if (e.target.classList.contains("btn_edit")) {
        const lecidx = e.target.getAttribute("id");
        fetch("lecture_edit_load.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({
            lecidx: lecidx,
          }),
        })
          .then(function (response) {
            return response.json();
          })
          .then(function (data) {
            console.log(data);
            document.querySelector("#lecidx").value = data.lecidx;
            const timeStamp = document.querySelectorAll(".lec_ts_up");
            const row1 = data.row1;
            if (data.row1) {
              row1.forEach(function (r) {
                timeStamp.forEach(function (ts) {
                  ts.insertAdjacentHTML(
                    "beforeend",
                    `<div class="d-flex justify-content-between gap-3 lec_ts_up" id="lec_ts_content">
                    <input type="text" id="ts_min" name="ts_min[]" class="ts_min" placeholder="분" value="${r.stp_minute}">
                    <input type="text" id="ts_sec" name="ts_sec[]" class="ts_sec" placeholder="초" value="${r.stp_second}">
                    <input type="text" id="ts_desc" name="ts_desc[]" class="ts_desc" placeholder="해당 부분 설명을 입력하세요" value="${r.stp_desc}">
                  </div>`
                  );
                });
              });
            } else {
              tsplus();
            }
          });
      }
    });
  });
}

// 수정사항 반영
if (modiform) {
  modiform.addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("lecture_edit_ok.php", {
      method: "POST",
      body: formData,
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        if (data.result === "success") {
          location.href = `lecture_view.php?lecidx=${data.lecidx}`;
        }
      })
      .catch(function (error) {
        console.error(error);
      });
  });
}
