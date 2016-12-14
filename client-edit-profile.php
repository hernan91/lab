<?php 
	define('PAGE', "client-edit-profile");
	include_once 'api/session.php';
?>
<?php 
	include("clientSections/section-top.php"); 
	include_once("api/internal/sales.php");
	include_once 'components/modalConfirm.php';
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea eliminar este producto del carrito?", "modalConfirmacionEliminarProducto");
	components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea finalizar la compra?", "modalConfirmacionFinalizarCompra");
?>
<?php
	$listOfProducts = api_internal_sales_getAllFinishedProductsBillsByUser($session_userId);
	$success = isset($_GET['success']);
	$error = isset($_GET['error']);
?>

<div class="ui <?php echo (count($listOfProducts)>0)?'hidden':''?> warning message">
	<div class="header">Advertencia	</div>No existen registros de ventas
</div>

<div style="padding-bottom:50px" class="ui segment">
	<table class="ui selectable celled table">
		<thead>
			<tr>
				<div class="ui sub header">Productos agregados al carro de compras</div>
			</tr>
			<tr>
				<th class="center aligned">Código de producto</th>
				<th class="center aligned">Nombre de producto</th>
				<th class="center aligned">Fabricante</th>
				<th class="center aligned">Precio</th>
				<th class="center aligned">Cantidad</th>
				<th class="center aligned">Operaciones</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$totalPrice = 0;
				foreach($listOfProducts as $product){
					echo '<tr>';
					$saleId = $product['sale_id'];
					$productId = $product['product_id'];
					$price = $product['product_price'];
					$quantity = $product['quantity'];
					
					foreach($product as $key=>$value){
						if($key=="sale_id" || $key=="product_id") continue;
						if($key=="product_name"){
							echo '<td class="center aligned"><a href="client-detail-product.php?code='.$product["product_code"].'">'.$value.'</a></td>';	
						}
						echo '<td class="center aligned">'.$value.'</td>';
					}
					echo 	'<td class="center aligned">
								<a data-tooltip="Borrar el producto del carro" data-inverted="" class="buttonRemove" link="client-show-cart.php?operation=remove&productId='.$productId.'&saleId='.$saleId.'"><i class="icon remove"></i></a>
							</td>';
					echo '</tr>';
					$totalPrice = $totalPrice + $price*$quantity;
				}
			?>
		</tbody>
		<tfoot align="right" class="full-width">
			<tr>
				<th colspan="6"><h3 style="display:inline">Total</h3><span><?php echo ' $'.$totalPrice?></span></th>
			</tr>
		</tfoot>
	</table>
	<a style="display: <?php echo (count($listOfProducts)>0)?'inline':'none'?>" class="disable buttonCompra" href="client-show-cart.php?operation=end">
		<div class="ui right floated basic blue small labeled icon button">
			<i class="check icon"></i> Finalizar compra
		</div>
	</a>
	
</div>
<?php include("clientSections/section-bottom.php") ?>
<script>
	$(function(){
		let link;
		$('#modalConfirmacionEliminarProducto.ui.basic.modal').modal({
			closable: false,
			onApprove: function(e){
				window.location = link;
			}
		});
		$('#modalConfirmacionFinalizarCompra.ui.basic.modal').modal({
			closable: false,
			onApprove: function(e){
				window.location = "client-show-cart.php?operation=end";
			}
		});
		$('.buttonRemove').click(function(e){
			e.preventDefault();
			link = e.target.parentElement.getAttribute('link');
			$('#modalConfirmacionEliminarProducto.ui.basic.modal').modal('show');
		});
		$('.buttonCompra').click(function(e){
			e.preventDefault();
			$('#modalConfirmacionFinalizarCompra.ui.basic.modal').modal('show');
		});
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
	});
</script>
<?php 
	unset($searchedUser, $usersList, $id, $key, $row, $value);
?>