//mostrar y ocultar menu lateral izquierdo
//seleccionar el botón
var boton = document.getElementById('botonmenu');
//seleccionar el menu
var menu = document.getElementById('menulateral');
//listener en el botón, se abre/cierra al hacer click
boton.addEventListener('click', openMenu);
//función que muestra/oculta el menú
function openMenu() {
	menu.classList.toggle('show');
}

//LOGIN-MODAL
//selecciona modal
var modal = document.getElementById('modal-login');
//selecciona el botón que abre el modal
var modalBtn = document.getElementById('opens-login');
//selecciona el botón que cierra el modal
var closeBtn = document.getElementsByClassName('closes-login')[0];
//Listeners para abrir y cerrar 
modalBtn.addEventListener('click', openModal);
closeBtn.addEventListener('click', closeModal);
window.addEventListener('click', closeIfOutside);
//función que abre modal
function openModal() {
	modal.style.display = 'block';
}
///función que cierra modal
function closeModal() {
	modal.style.display = 'none';
}
///función que cierra modal si el evento ocurre fuera de la ventana 
function closeIfOutside(e) {
	if (e.target == modal) {
		modal.style.display = 'none';
	}
}

//login con ajax
$(document)
	.on("submit", "form.login_modal", function (event) {
		event.preventDefault();

		var form = $(this);
		var error = $(".js-error", form);
		//almacenamos los datos introducidos por el usuario
		var dataObj = {
			email: $("#email").val(),
			pass: $("#password").val()
		};

		if (dataObj.email.length < 8) {
			error
				.text("Introduce un email válido")
				.show();
			return false;
		}

		error.hide();

		//ajax
		$.ajax({
			type: 'POST',
			url: 'http://localhost/shop/users/login/',
			data: dataObj,
			dataType: 'json',
			async: true,
		})
			.done(function ajaxDone(data) {
				//redirigimos
				if (data.redirect !== undefined) {
					window.location = data.redirect;

					//mostramos los errores
				} else if (data.error !== undefined) {
					error
						.html(data.error)
						.show();
				}
			})
		return false;
	})

