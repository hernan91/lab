<?php 
	define('PAGE', "client-show-story");
	define('LEVEL', 1);
	include_once 'api/auth.php';
?>
<?php 
	include("clientSections/section-top.php"); 
	include_once("api/internal/sales.php");
	include_once 'components/saleTable.php';
?>
<?php
	$listOfSales = api_internal_getFinishedSalesByUser($_SESSION['id']);
?>

<div class="ui <?php echo (count($listOfSales)>0)?'hidden':''?> warning message">
	<div class="header">Advertencia	</div>No existen registros de ventas
</div>

<div class="ui segment">
	<h1>Historial de compras</h1>
	
<?php
	forEach($listOfSales as $sale){
		$listOfProducts = api_internal_getProductsBySale($sale['id']);
		echo '
			<div style="margin-top:80px;" class="ui divider"></div>
				<div class="ui grid">
					<div style ="font-size: 1.5em" class="six wide column"><b>Código de venta: </b>'.$sale['id'].'</div>
					<div style ="font-size: 1.5em" class="six wide column"><b>Fecha de venta: </b>'.$sale['date'].'</div>
				</div>
			
		';
		saleTable($listOfProducts, $sale['id']);
	}
?>			
</div>
<?php include("clientSections/section-bottom.php") ?>
<script>
	$(function(){
		$('.message .close').on('click', function() {
			$(this).closest('.message').transition('fade');
		});
	});
</script>
<?php 
	unset($searchedUser, $usersList, $id, $key, $row, $value);
?>