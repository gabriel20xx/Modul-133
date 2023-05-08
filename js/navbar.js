/* const button = document.querySelector(".navbar-toggler");
const menu = document.querySelector(".navbar-collapse");

button.addEventListener("click", function () {
  if (menu.classList.contains("show")) {
    menu.classList.remove("show");
  } else {
    menu.classList.add("show");
  }
});

 */
var currentPage = window.location.pathname;
var navLinks = document.querySelectorAll(".navbar-nav a");

for (var i = 0; i < navLinks.length; i++) {
  var link = navLinks[i];
  if (link.pathname === currentPage) {
    link.classList.add("active");
  } else {
    link.classList.remove("active");
  }
}
