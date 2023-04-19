<footer>
  <!-- Insert Footer Code here -->
  <div class="row mt-3">
    <div class="col-12 text-center">
      <p>&copy; 2023 The GCT Corner. All rights reserved.</p>
    </div>
  </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.3/umd/popper.min.js"></script>

<!-- JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js" integrity="sha512-5i6jK1CQ2r5O5EaU5KjxwtWEnu8MFVYIjKu0lZgEjb6fbF7/IOHVKDq3pVFKxWYt8RW/gtODnTq3p9oT+iPxgg==" crossorigin="anonymous"></script>
<script>
  const button = document.querySelector('.navbar-toggler');
  const menu = document.querySelector('.navbar-collapse');

  button.addEventListener('click', function() {
    if (menu.classList.contains('show')) {
      menu.classList.remove('show');
    } else {
      menu.classList.add('show');
    }
  });
</script>
<script>
  // Gets current document name for example: /index.php 
  // document.getElementById("footerr").innerHTML = window.location.pathname;
  // Get the current page URL
  var currentPage = window.location.pathname;

  // Get all the links in the navbar
  var navLinks = document.querySelectorAll('.navbar-nav a');

  // Loop through each link and update the active class if it matches the current page URL
  for (var i = 0; i < navLinks.length; i++) {
    var link = navLinks[i];
    if (link.pathname === currentPage) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  }
</script>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    const myAlert = document.querySelector("#alertBox");
    const btnClose = myAlert.querySelector(".btn-close");
    btnClose.addEventListener("click", function() {
      myAlert.classList.add("hide");
    });
  });
</script>
</body>

</html>