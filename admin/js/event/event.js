let fileInput = document.querySelectorAll("[type='file']");
for (file of fileInput) {
  file.addEventListener("change", (e) => {
    let fileName = e.target.files[0].name;
    let target = e.target.previousElementSibling.lastElementChild;
    target.innerText = fileName;
    let changeCheck = e.target.nextElementSibling;
    nextElementSibling.setAttribute("value", 1);
  });
}
