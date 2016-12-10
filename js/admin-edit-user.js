$(function(){
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
		$('#dropRol.ui.selection.dropdown').dropdown();
		$('#botonLimpieza.ui.button').click(function(e){
			e.preventDefault();
			$('#formAgregarUsuario.ui.form').form('reset');
		});

		let modalConfirmed = false;
		$('#modalConfirmacion.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				modalConfirmed = true;
				$('#formAgregarUsuario.ui.form').form('submit');
			}
		});
		$('#botonCrear.ui.button').click(function(e){
			e.preventDefault();
			$('#formAgregarUsuario.ui.form').form('submit');
		});		
		function onValidForm(e, fields){
			if(!modalConfirmed){
				e.preventDefault();
				cryptPass();
				$('#modalConfirmacion.ui.basic.modal').modal('show');	
			}
		}
		function cryptPass(){
			let userForm = $('#formAgregarUsuario.ui.form');
			let passwordField = $('#password');
			if(passwordField.val()){
				let cryptedPassword = CryptoJS.MD5(passwordField.val());
				$('#cryptedPasswordField').val(cryptedPassword);
			}
		}
		$('.ui.form').form({
			on:'blur',
			inline : true,
			onSuccess: onValidForm,
			fields: {
				username: {
					identifier : 'username',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un usuario'
					},{
						type	: 'minLength[6]',
						prompt	: 'El nombre de usuario debe tener al menos 6 caracteres'
					}]
				},
				password: {
					optional: true,
					identifier : 'password',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese una contraseña'
					},{
						type	: 'minLength[6]',
						prompt	: 'La contraseña debe tener al menos 6 caracteres'
					}]
				},
				confPassword: {
					identifier : 'confPassword',
					rules: [{
						type   : 'match[password]',
						prompt : 'Las contraseñas ingresadas deben ser iguales'
					}]
				},
				email: {
					optional: true,
					identifier: 'email',
					rules: [{
						type   : 'email',
						prompt : '{value} no es una dirección de correo válida'
					}]
				},
				name: {
					identifier: 'name',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un nombre'
					}]
				},
				lastname: {
					identifier: 'lastname',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un apellido'
					}]
				},
				dni: {
					identifier: 'dni',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un dni'
					},
					{
						type   : 'integer',
						prompt : 'Por favor, ingrese un número de dni'
					}]
				},
				direction: {
					optional: true,
					identifier: 'direction'
				},
				phone: {
					optional: true,
					identifier: 'phone',
					rules: [{
						type	: 'minLength[5]',
						prompt	: 'El número de telefono debe tener al menos 5 números'
					},
					{
						type	: 'integer',
						prompt	: 'El teléfono debe ser un número'
					}]
				},
				role: {
					identifier: 'role',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor seleccione un rol de usuario'
					}]
				},
			}
		});
	});