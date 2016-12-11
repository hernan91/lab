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
				$('#modalConfirmacion.ui.basic.modal').modal('show');	
			}
		}
		$('.ui.form').form({
			on:'blur',
			inline : true,
			onSuccess: onValidForm,
			fields: {
				code: {
					identifier : 'code',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un código'
					},{
						type   : 'integer',
						prompt : 'Por favor, ingrese valor númerico para el código'
					}]
				},
				name: {
					identifier : 'name',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un nombre de producto'
					}]
				},
				manufacturer: {
					identifier : 'manufacturer',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un fabricante'
					}]
				},
				price: {
					identifier: 'price',
					rules: [{
						type   : 'number',
						prompt : 'Por favor, ingrese valor númerico (si es decimal use puntos)'
					},{
						type   : 'empty',
						prompt : 'Por favor, ingrese un precio'
					}]
				},
				state: {
					identifier: 'state',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese un estado'
					}]
				},
				stock: {
					identifier: 'stock',
					rules: [{
						type   : 'integer[0..9999999999]',
						prompt : 'Por favor, ingrese un valor de stock'
					},{
						type   : 'empty',
						prompt : 'Por favor, ingrese un fabricante'
					}]
				},
				description: {
					identifier: 'description',
					optional: 'true'
				},
				category_code: {
					identifier: 'category_code',
					rules: [{
						type   : 'empty',
						prompt : 'Por favor, ingrese una categoría'
					}]
				}
			}
		});
	});