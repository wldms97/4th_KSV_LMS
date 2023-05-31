// typo effect
let $text = document.querySelector(".keyword");
let letters = ["빠르게", "쉽게", "재밌게"];
// speed text
let speed = 150;
let i = 0;
// typing
let typing = async function () {
  let letter = letters[i].split("");
  while (letter.length) {
    await wait(speed);
    $text.innerHTML += letter.shift();
  }
  await wait(1500);
  remove();
};
// remove text
let remove = async function () {
  let letter = letters[i].split("");
  while (letter.length) {
    await wait(speed);
    letter.pop();
    $text.innerHTML = letter.join("");
  }
  i = !letters[i + 1] ? 0 : i + 1;
  typing();
};
// delay
function wait(ms) {
  return new Promise((res) => setTimeout(res, ms));
}
// typo effect 실행
setTimeout(typing, 1800);

// display comment after check ability
function check_ability() {
  let range_input = document.getElementById("user_ability").value;
  let range_val = document.getElementById("range");

  if (range_input == 0) {
    range_val.innerHTML = "이 분야는 처음이예요!";
  } else if (range_input == 1) {
    range_val.innerHTML = "코딩의 세계에 입문했습니다.";
  } else if (range_input == 2) {
    range_val.innerHTML = "html과 css 정도는 기본이죠!";
  } else if (range_input == 3) {
    range_val.innerHTML = "중급자입니다. 숙련도를 올리고 싶어요!";
  } else if (range_input == 4) {
    range_val.innerHTML = "마스터가 되는 것이 목표입니다.";
  } else if (range_input == 5) {
    range_val.innerHTML = "잘한다고 자랑할 수 있는 정도의 수준";
  }
}

// total check
$("#total-agree").click(function () {
  if ($("#total-agree").prop("checked")) {
    $(".autocheck").prop("checked", true);
  } else {
    $(".autocheck").prop("checked", false);
  }
});

// modal agree check
$("#modal_use_agree").click(function () {
  $("#use_agree").prop("checked", true);
});
$("#modal_personalinfo_agree").click(function () {
  $("#personalinfo_agree").prop("checked", true);
});
$("#modal_marketing_agree").click(function () {
  $("#marketing_agree").prop("checked", true);
});

// deco fixed
let target = $(".signup.sticky");
let targetHeight = target.height();
let sticky = $(".deco.sticky");
let height = targetHeight - 500;

let relocateEvt = new Event("scroll");

$(window).scroll(() => {
  let sct = $(window).scrollTop();

  if (sct < height) {
    sticky.css({ position: "fixed", top: "15%", left: "10%" });
    $(".inner").removeClass("d-flex");
    target.css({ margin: "5% 50%" });
  }
});
window.dispatchEvent(relocateEvt);

// 이미지 파일첨부 시 이름이 파일명으로 바뀔 수 있게 하는 스크립트
let fileTarget = document.querySelector(".attach_file .file_hidden");

fileTarget.addEventListener("change", function () {
  let filename = "";
  if (window.FileReader) {
    filename = this.files[0].name;
  }
  // 추출한 파일명 삽입
  this.nextElementSibling.value = filename;
});

// signup_check 연동
$(".btn_id").click(function () {
  let userid = $("#userid").val();
  var data = {
    userid: userid,
  };
  $.ajax({
    async: false,
    type: "post",
    url: "signup_check.php",
    data: data,
    dataType: "json",
    success: function (result) {
      if (result.cnt > 0) {
        alert("중복된 id가 있습니다, 다시 확인해주세요");
      } else {
        alert("사용가능 id입니다");
        $("#userid").attr("data-pass", "ok");
      }
    },
  });
});

$(".btn_signup").click(function () {
  let pass = $("#userid").attr("data-pass");
  let confirm_pw = $("#userpw").attr("data-pass");
  let confirm_pwcf = $("#confirm_pw").attr("data-pass");
  let use_agree = $("#use_agree").is(":checked");
  let personalinfo_agree = $("#personalinfo_agree").is(":checked");

  if (pass != "ok") {
    alert("id 중복 체크를 해주세요");
    $("#userid").addClass("warning");
    return false;
  }
  if (confirm_pwcf != "ok") {
    alert("비밀번호 확인 체크를 해주세요");
    $("#confirm_pw").addClass("warning");
    return false;
  }
  if (use_agree == false) {
    alert("필수 이용약관에 동의해주세요.");
    $("#use_agree").addClass("warning");
    return false;
  }
  if (personalinfo_agree == false) {
    alert("필수 이용약관에 동의해주세요.");
    $("#personalinfo_agree").addClass("warning");
    return false;
  }
  if (
    pass == "ok" &&
    confirm_pwcf == "ok" &&
    use_agree == "true" &&
    personalinfo_agree == "true"
  ) {
    $(".form_signup").submit();
  }
});
$("#confirm_pw").change(function () {
  if ($("#userpw").val() == $("#confirm_pw").val()) {
    $("#confirm_pw").attr("data-pass", "ok");
    $(".confirm_pw").find("p").hide();
  } else {
    $("#confirm_pw").attr("data-pass", "no");
    $(".confirm_pw").find("p").remove();
    $(".confirm_pw").append("<p>비밀번호가 일치하지 않습니다.</p>");
  }
});
