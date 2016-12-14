<?php 
	define('PAGE', "admin-list-users");
	define('LEVEL', 2);
	include_once 'api/auth.php';
?>
<?php 
	include("adminSections/section-top.php");
	include_once("api/internal/users.php");
	include_once 'components/modalConfirm.php'; 
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea eliminar este usuario?", "modalConfirmacion");
?>
<?php
	$searchedUser = isset($_GET['user'])?$_GET['user']:"";
	$usersList = api_internal_users_getAllUsersData();
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

<div class="ui <?php echo (count($usersList)>0)?'hidden':''?> warning message">
	<div class="header">
		Advertencia
	</div>
	No existen usuarios registrados
</div>

<div class="ui segment">
	<div class="ui sub header">Filtro</div>
	<form class="ui form" id="formFiltro">
		<div class="inline fields">
			<div class="field">
				<div class="ui action left icon input">
					<i class="search icon"></i>
					<input name="user" type="text" value="<?php echo $searchedUser?$searchedUser:''?>" placeholder="Introducir usuario">
					<div class="ui button" id="botonBusqueda">Buscar</div>
				</div>
			</div>
			<div class="field">
				<a href="admin-add-user.php">
					<div class="ui right floated basic blue small labeled icon button">
						<i class="plus icon"></i> Agregar usuario
					</div>
				</a>
			</div>
		</div>
	</form>

	<div class="ui clearing horizontal divider">-</div>

	<table class="ui selectable celled table">
		<thead>
			<tr>
				<div class="ui sub header">Usuarios registrados en el sistema</div>
			</tr>
			<tr>
				<th class="center aligned">Usuario</th>
				<th class="center aligned">DNI</th>
				<th class="center aligned">Email</th>
				<th class="center aligned">Nombre</th>
				<th class="center aligned">Apellido</th>
				<th class="center aligned">Dirección</th>
				<th class="center aligned">Teléfono</th>
				<th class="center aligned">Rol</th>
				<th class="center aligned">Operaciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$str = '';
				foreach($usersList as $row){
					echo '<tr>';
					$id;
					foreach($row as $key=>$value){
						if($key=="id"){
							$id = $value;
							continue;
						}
						$lit = $value?$value:"---";
						echo '<td class="center aligned">'.$lit.'</td>';
					}
					echo 	'<td class="center aligned">
								<a data-tooltip="Editar el usuario" data-inverted="" href="admin-edit-user.php?id='.$id.'"><i class="icon edit"></i></a>
								<a data-tooltip="Borrar el usuario" data-inverted="" class="buttonRemove" link="admin-remove-user.php?id='.$id.'"><i class="icon remove"></i></a>
							</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot class="full-width">
			<tr>
				<th colspan="9">
					<a href="admin-add-user.php">
						<div class="ui right floated basic blue small labeled icon button">
							<i class="plus icon"></i> Agregar usuario
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
	});
</script>
<?php 
	unset($searchedUser, $usersList, $id, $key, $row, $value);
?>