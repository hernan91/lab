<?php 
	define('PAGE', "client-show-cart");
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
	//$userId = $_SESSION['id'];
	$listOfProducts = api_internal_sales_getAllUnfinishedProductsBillsByUser($session_userId);
	$success = isset($_GET['success']);
	$error = isset($_GET['error']);

	if(isset($_GET['operation'])){
		$operation = $_GET['operation'];
		if($operation=='add'){
			$productId = $_GET['productId'];
			$quantity = $_GET['quantity'];
			$error = api_internal_sales_AddToCart($session_userId, $productId, $quantity);
			if(!is_bool($error)) return header("Location: client-show-cart.php?error=".$error);
			return header ("Location: client-show-cart.php?success=El producto ha sido agregado al carrito");
		}
		else if($operation=='remove'){
			$productId = $_GET['productId'];
			$saleId = $_GET['saleId'];
			$error = api_internal_sales_RemoveProductFromCart($session_userId, $productId);
			if(!is_bool($error)) return header("Location: client-show-cart.php?error=".$error);
			return header ("Location: client-show-cart.php?success=El producto ha sido removido del carrito");
		}
		else if($operation=='end'){
			$error = api_internal_sales_finishSale($session_userId);
			if(!is_bool($error)) return header("Location: client-show-cart.php?error=".$error);
			return header ("Location: client-show-cart.php?success=La compra se ha realizado correctamente");
		}
	}
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

<div class="ui <?php echo (count($listOfProducts)>0)?'hidden':''?> warning message">
	<div class="header">Advertencia	</div>No se han agregado productos al carrito
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