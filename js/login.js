$().ready(function(){
	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});
	$('#buttonIngresar.ui.button').click(function(e){
		e.preventDefault();
		let passwordField = $('#password');
		let cryptedPassword = CryptoJS.MD5(passwordField.val());
		$('#cryptedPasswordField').val(cryptedPassword);
		$('#loguear.ui.form').submit();		
	});
	/*$('#loguear.ui.form').form({
		on:'blur',
		inline : true,
		fields: {
			username: {
				identifier : 'username',
				rules: [{
					type   : 'empty',
					prompt : 'Ingrese un usuario'
				},{
					type	: 'minLength[6]',
					prompt	: 'El nombre de usuario debe tener al menos 6 caracteres'
				}]
			},
			password: {
				identifier : 'password',
				rules: [{
					type   : 'empty',
					prompt : 'Ingrese una contraseña'
				},{
					type	: 'minLength[6]',
					prompt	: 'La contraseña debe tener al menos 6 caracteres'
				}]
			}
		}
	});*/
});