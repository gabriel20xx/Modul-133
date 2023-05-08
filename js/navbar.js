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
