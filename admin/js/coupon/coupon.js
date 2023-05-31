let checkbox = document.getElementById("date_limit");
let target = document.getElementById("checked");

checkbox.addEventListener("change", function () {
  if (checkbox.checked) {
    target.setAttribute("value", 0);
  } else {
    target.setAttribute("value", 1);
  }
});
