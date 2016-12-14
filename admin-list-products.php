<?php 
	define('PAGE', "admin-list-products");
	define('LEVEL', 2);
	include_once 'api/auth.php';
?> 
?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/products.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea eliminar este producto?", "modalConfirmacion");
?>
<?php
	$searchedUser = isset($_GET['user'])?$_GET['user']:"";
	$productsList = api_internal_products_getAllProductsBasicTableData();
	$success = isset($_GET['success']);
	$error = isset($_GET['error']);
?>

<div class="ui <?php echo $success?"":"hidden" ?> success message">
	<i class="close icon"></i>
	<div class="header">Operacion completada correctamente</div>
	<p><?php echo $success?$_GET['success']:""?></p>
</div>

<div class="ui <?php echo $error?"":"hidden" ?> error message">
	<i class="close icon"></i>
	<div class="header">Surgió un error al realizar la operación</div>
	<p><?php echo $error?$_GET['error']:""?></p>
</div>

<div class="ui <?php echo (count($productsList)>0)?'hidden':''?> warning message">
	<div class="header">Advertencia</div>
	No existen productos registrados
</div>

<div class="ui segment">
	<div class="ui sub header">Filtro</div>
	<form class="ui form" id="formFiltro">
		<div class="inline fields">
			<div class="field">
				<div class="ui action left icon input">
					<i class="search icon"></i>
					<input name="user" type="text" value="<?php echo $searchedUser?$searchedUser:''?>" placeholder="Introducir producto">
					<div class="ui button" id="botonBusqueda">Buscar</div>
				</div>
			</div>
			<div class="field">
				<a href="admin-add-product.php">
					<div class="ui right floated basic blue small labeled icon button">
						<i class="plus icon"></i> Agregar producto
					</div>
				</a>
			</div>
		</div>
	</form>

	<div class="ui clearing horizontal divider">-</div>

	<table class="ui selectable celled table">
		<thead>
			<tr>
				<div class="ui sub header">Información básica acerca de productos registrados en el sistema</div>
			</tr>
			<tr>
				<th class="center aligned">Código</th>
				<th class="center aligned">Nombre</th>
				<th class="center aligned">Precio</th>
				<th class="center aligned">Categoría</th>
				<th class="center aligned">Fabricante</th>
				<th class="center aligned">Estado</th>
				<th class="center aligned">Stock</th>
				<th class="center aligned">Operaciones</th>
				<th class="center aligned">Detalles</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$str = '';
				foreach($productsList as $row){
					echo '<tr>';
					$code;
					foreach($row as $key=>$value){
						if($key=="code") $code = $value;
						echo '<td class="center aligned">'.$value.'</td>';
					}
					echo 	'<td class="center aligned">
								<a data-tooltip="Editar el producto" data-inverted="" href="admin-edit-product.php?code='.$code.'"><i class="icon edit"></i></a>
								<a data-tooltip="Borrar el producto" data-inverted="" class="buttonRemove" link="admin-remove-product.php?code='.$code.'"><i class="icon remove"></i></a>
								<a data-tooltip="Modificar imagenes y/o videos del producto" data-inverted="" href="admin-edit-files.php?code='.$code.'"><i class="icon image"></i></a>
							</td>';
					echo 	'<td class="center aligned">
								<a href="admin-detail-product.php?code='.$code.'">Ver màs</a>
							</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot class="full-width">
			<tr>
				<th colspan="10">
					<a href="admin-add-product.php">
						<div class="ui right floated basic blue small labeled icon button">
							<i class="plus icon"></i> Agregar producto
						</div>
					</a>
				</th>
			</tr>
		</tfoot>
	</table>
</div>
<?php include("adminSections/section-bottom.php") ?>
<script>
	let link;
	$('#modalConfirmacion.ui.basic.modal').modal({
		closable: false,
		onApprove: function(e){
			window.location = link;
		}
	});
	$('.buttonRemove').click(function(e){
		e.preventDefault();
		link = e.target.parentElement.getAttribute('link');
		$('#modalConfirmacion.ui.basic.modal').modal('show');
	});
	$('.message .close').on('click', function() {
		$(this).closest('.message').transition('fade');
	});
	$('#buscarDrop.ui.dropdown').dropdown();
	$('#botonBusqueda').click(function(e){
		e.preventDefault();
		$('form#formFiltro').submit();
	});
</script>
<?php 
	/*unset($productsList, $id, $key, $row, $value);*/
?>