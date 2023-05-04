var editBtn = document.getElementById("edit-btn");
var saveBtn = document.getElementById("save-btn");
var deleteBtn = document.getElementById("delete-btn");
var usernameInput = document.getElementById("username");
var emailInput = document.getElementById("email");
var passwordInput = document.getElementById("password");

// Enable form inputs and show/hide buttons on edit click
editBtn.addEventListener("click", function () {
  editBtn.classList.add("d-none");
  saveBtn.classList.remove("d-none");
  deleteBtn.classList.add("d-none");
  usernameInput.disabled = false;
  emailInput.disabled = false;
  passwordInput.disabled = false;
});

// Disable form inputs and show/hide buttons on save click
saveBtn.addEventListener("click", function () {
  editBtn.classList.remove("d-none");
  saveBtn.classList.add("d-none");
  deleteBtn.classList.remove("d-none");
});
