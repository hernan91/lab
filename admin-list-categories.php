<?php 
	define('PAGE', "admin-list-categories");
	define('LEVEL', 2);
	include_once 'api/auth.php';
?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/categories.php");
	include_once 'components/modalConfirm.php';
	include_once 'components/modalError.php';
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea eliminar esta categoría?", "modalConfirmacion");
	components_modal_error("Error", "Existen productos que pertenecen a esta categoría, elimínelos primero", "modalError");
?>
<?php
	$searchedCategory = isset($_GET['user'])?$_GET['user']:"";
	$categoriesList = api_internal_categories_getAllCategoriesData();
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

<div class="ui <?php echo (count($categoriesList)>0)?'hidden':''?> warning message">
	<div class="header">Advertencia	</div>
	No existen categorías registradass
</div>

<div class="ui segment">
	<div class="ui sub header">Filtro</div>
	<form class="ui form" id="formFiltro">
		<div class="inline fields">
			<div class="field">
				<div class="ui action left icon input">
					<i class="search icon"></i>
					<input name="user" type="text" value="<?php echo $searchedCategory?$searchedCategory:''?>" placeholder="Introducir usuario">
					<div class="ui button" id="botonBusqueda">Buscar</div>
				</div>
			</div>
			<div class="field">
				<a href="admin-add-category.php">
					<div class="ui right floated basic blue small labeled icon button">
						<i class="plus icon"></i> Agregar categoría
					</div>
				</a>
			</div>
		</div>
	</form>

	<div class="ui clearing horizontal divider">-</div>

	<table class="ui selectable celled table">
		<thead>
			<tr>
				<div class="ui sub header">Categorías registradas en el sistema</div>
			</tr>
			<tr>
				<th class="center aligned">Código</th>
				<th class="center aligned">Nombre</th>
				<th class="center aligned">Ver descripción</th>
				<th class="center aligned">Operaciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$str = '';
				foreach($categoriesList as $row){
					echo '<tr>';
					$id;
					foreach($row as $key=>$value){
						if($key=="id"){
							$id = $value;
							continue;
						}
						else if($key=="description"){
							echo'
								<td class="center aligned">
									<a data-id="'.$id.'" href="" class="buttonDescription">Ver descripción</a>
								</td>
							';
							echo '
							
								<div id="modal'.$id.'" class="description ui modal">
									<i class="close icon"></i>
									<div class="header">
										Descripcion de la categoría
									</div>
									<div class="image content">
										<h4>'.($value?$value:"No existe una descripción para esta categoría").'</h4>
									</div>
									<div class="actions">
										<div class="ui black deny button">Cerrar</div>
									</div>
								</div>
							';
							continue;
						}
						echo '<td class="center aligned">'.$value.'</td>';
					}
					echo 	'<td class="center aligned">
								<a data-tooltip="Editar la categoría" data-inverted="" href="admin-edit-category.php?id='.$id.'"><i class="icon edit"></i></a>
								<a data-tooltip="Borrar la categoría" data-inverted="" class="buttonRemove" link="admin-remove-category.php?id='.$id.'"><i class="icon remove"></i></a>
							</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot class="full-width">
			<tr>
				<th colspan="9">
					<a href="admin-add-category.php">
						<div class="ui right floated basic blue small labeled icon button">
							<i class="plus icon"></i> Agregar categoría
						</div>
					</a>
				</th>
			</tr>
		</tfoot>
	</table>
</div>
<?php include("adminSections/section-bottom.php") ?>
<script>
	$(function(){
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

		$('.buttonDescription').click(function(e){
			e.preventDefault();
			let id = $(e.target).attr('data-id');
			$('#modal'+id+'.description.ui.modal').modal('show');	
		});
		
	});
</script>
<?php 
	unset($searchedUser, $usersList, $id, $key, $row, $value);
?>