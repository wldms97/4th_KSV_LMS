//북마크

let bookmark = document.querySelector(".bookmark");
let icon = bookmark.firstElementChild;
let value = icon.value;
console.log(value);

bookmark.addEventListener("change", () => {
  if (icon.checked) {
    console.log("추가됨");
    let data = {
      value: value,
    };
    $.ajax({
      async: true,
      type: "post",
      url: "../bookmark_add.php",
      data: data,
      dataType: "json",
    });
  } else {
    console.log("삭제됨");
    let data = {
      value: value,
    };
    $.ajax({
      async: true,
      type: "post",
      url: "../bookmark_delete.php",
      data: data,
      dataType: "json",
    });
  }
});
