var boton = document.getElementById("botonmenu");
var menu = document.getElementById("menulateral");

boton.addEventListener("click", openMenu);

function openMenu() {
  menu.classList.toggle("show");
}

// LOGIN-MODAL
var modal = document.getElementById("modal-login");
var modalBtn = document.getElementById("opens-login");
var closeBtn = document.getElementsByClassName("closes-login")[0];

modalBtn.addEventListener("click", openModal);
closeBtn.addEventListener("click", closeModal);
window.addEventListener("click", closeIfOutside);

function openModal() {
  modal.style.display = "block";
}

function closeModal() {
  modal.style.display = "none";
}

function closeIfOutside(e) {
  if (e.target == modal) {
    modal.style.display = "none";
  }
}

//login - AJAX
$(document).on("submit", "form.login_modal", function (event) {
  event.preventDefault();

  var form = $(this);
  var error = $(".js-error", form);

  var dataObj = {
    email: $("#email").val(),
    pass: $("#password").val(),
  };

  if (dataObj.email.length < 8) {
    error.text("Introduce un email válido").show();
    return false;
  }

  error.hide();

  $.ajax({
    type: "POST",
    url: "http://localhost/shop/users/login/",
    data: dataObj,
    dataType: "json",
    async: true,
  }).done(function ajaxDone(data) {
    if (data.redirect !== undefined) {
      window.location = data.redirect;
    } else if (data.error !== undefined) {
      error.html(data.error).show();
    }
  });
  return false;
});
