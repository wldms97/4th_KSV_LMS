function delAjax($cateidx, $url, $destination) {
  let data = {
    cateidx: $cateidx,
  };

  $.ajax({
    async: false,
    type: "post",
    url: $url,
    data: data,
    dataType: "json",
    error: function () {
      alert("error");
    },
    success: function (result) {
      if (result.result == true) {
        alert("삭제되었습니다.");
        location.href = $destination;
      }
    },
  });
}
