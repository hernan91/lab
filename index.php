<?php define('PAGE', "index") ?>

	<?php 
		include("clientSections/section-top.php");
		include_once 'components/cardProduct.php';
		include_once 'components/cardProductMostSelled.php';
		include_once 'api/internal/products.php';
		include_once 'api/internal/categories.php';
		include_once 'components/modalConfirm.php';
		components_modal_confirm("Confirmar acción", "¿Esta seguro de que desea agregar este producto al carrito?", "modalConfirmacion");
		
		$mostSelledProductsList;
		$categoryProductsList;
		if(!isset($_GET['categoryId'])){
			$mostSelledProductsList = api_internal_products_getMostSelledProducts();
			$allProductsList = api_internal_products_getAllProductsBasicData();
			$title = "Productos mas vendidos";
		}
		else{
			$categoryId = $_GET['categoryId'];
			$categoryData = api_internal_categories_getCategoryData($categoryId);
			$categoryProductsList = api_internal_products_getAllProductsBasicDataByCategory($categoryId);
			$title = 'Productos de la categoría '.$categoryData['name'];
		}
		
		$registered = true;
	?>

	<div class="ui raised segment">
		<h3 class="ui header"><?php echo $title ?></h3>
		<div class="ui cards">
			<?php
				if(isset($mostSelledProductsList)){
					foreach($mostSelledProductsList as $selledProduct){
						$firstImage = api_internal_products_getFirstImg($selledProduct['id']);
						components_cardProductMostSelled($selledProduct['id'], $selledProduct['name'], $selledProduct['code'], $selledProduct['manufacturer'], $selledProduct['catName'], $selledProduct['price'], $firstImage['id'], $firstImage['extension'], $selledProduct['quantity'], $selledProduct['stock'], true);
					}
				}
				else if(isset($categoryProductsList)){
					if(count($categoryProductsList)==0) echo '<p>No existen productos para esta categoría</p>';
					else{
						foreach($categoryProductsList as $categoryProduct){
							$firstImage = api_internal_products_getFirstImg($categoryProduct['id']);
							components_cardProduct($categoryProduct['id'], $categoryProduct['name'], $categoryProduct['code'], $categoryProduct['manufacturer'], $categoryProduct['catName'], $categoryProduct['price'], $firstImage['id'], $firstImage['extension'], $categoryProduct['stock'], true);
						}
					}
				}
			?>
		</div>
	</div>
	<div style="margin-top:100px;"></div>
	<div class="ui raised segment">
		<h3 class="ui header"><?php echo isset($allProductsList)?"Todos los productos":"" ?></h3>
		<div class="ui four cards">
			<?php
				//falta manejo sesion
				if(isset($allProductsList)){
					foreach($allProductsList as $product){
						$firstImage = api_internal_products_getFirstImg($product['id']);
						components_cardProduct($product['id'], $product['name'], $product['code'], $product['manufacturer'], $product['catName'], $product['price'], $firstImage['id'], $firstImage['extension'], $product['stock'], true);
					}
				}
			?>
		</div>
	</div>
	
	<?php include("clientSections/section-bottom.php") ?>

<script>
	let addToCartForm;
	$('#modalConfirmacion.ui.basic.modal').modal({
		closable: false,
		onApprove: function(){
			addToCartForm.submit();
		}
	});
	$('.addToCartAnchor').click(function(e){
		e.preventDefault();
		addToCartForm = $(e.target).parents('form');
		$('#modalConfirmacion.ui.basic.modal').modal('show');
	});
</script>