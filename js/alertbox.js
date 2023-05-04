document.addEventListener("DOMContentLoaded", function () {
  const myAlert = document.querySelector("#alertBox");
  const btnClose = myAlert.querySelector(".btn-close");
  btnClose.addEventListener("click", function () {
    myAlert.classList.add("hide");
  });
});
