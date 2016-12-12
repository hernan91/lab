$(function(){
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
		$('#botonLimpieza.ui.button').click(function(e){
			e.preventDefault();
			$('#formModificarCategoria.ui.form').form('reset');
		});

		let modalConfirmed = false;
		$('#modalConfirmacion.ui.basic.modal').modal({
			closable: false,
			onApprove: function(){
				modalConfirmed = true;
				$('#formModificarCategoria.ui.form').form('submit');
			}
		});
		$('#botonCrear.ui.button').click(function(e){
			e.preventDefault();
			$('#formModificarCategoria.ui.form').form('submit');
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
						prompt : 'Por favor, ingrese un nombre de categoría'
					}]
				}
			}
		});
	});