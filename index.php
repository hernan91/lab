<?php define('PAGE', "index") ?>

	<?php 
		include("clientSections/section-top.php");
		include_once 'components/cardProduct.php';
		include_once 'components/cardProductMostSelled.php';
		include_once 'api/internal/products.php';
		include_once 'components/modalConfirm.php';
		
		$mostSelledProductsList;
		$category
		if(!isset($_GET['category'])){
			$allProductsList = api_internal_products_getAllProductsBasicData();
			$mostSelledProductsList = api_internal_products_getMostSelledProducts();
			$firstProductsList = $mostSelledProductsList;
			$title = "Productos mas vendidos";	
		}
		
		$registered = true;
	?>

	<div class="ui raised segment">
		<h3 class="ui header"><?php echo $firstTitle ?></h3>
		<div class="ui cards">
			<?php
				if(!isset($_GET['category'])){
					foreach($firstProductsList as $selledProduct){
						$firstImage = api_internal_products_getFirstImg($selledProduct['id']);
						components_cardProductMostSelled($selledProduct['id'], $selledProduct['name'], $selledProduct['code'], $selledProduct['manufacturer'], $selledProduct['catName'], $selledProduct['price'], $firstImage['id'], $firstImage['extension'], $selledProduct['quantity'], true);
					}
				}
				else if(isset($_GET['category'])){
					foreach($firstProductsList as $selledProduct){
						$firstImage = api_internal_products_getFirstImg($selledProduct['id']);
						components_cardProductMostSelled($selledProduct['id'], $selledProduct['name'], $selledProduct['code'], $selledProduct['manufacturer'], $selledProduct['catName'], $selledProduct['price'], $firstImage['id'], $firstImage['extension'], $selledProduct['quantity'], true);
					}
				}
			?>
		</div>
	</div>
	<div style="margin-top:100px;"></div>
	<div class="ui raised segment">
		<h3 class="ui header">Todos los productos</h3>
		<div class="ui cards">
			<?php
				//falta manejo sesion
				foreach($allProductsList as $product){
					$firstImage = api_internal_products_getFirstImg($product['id']);
					components_cardProduct($product['id'], $product['name'], $product['code'], $product['manufacturer'], $product['catName'], $product['price'], $firstImage['id'], $firstImage['extension'], true);
				}
			?>
		</div>
	</div>
	
	<?php include("clientSections/section-bottom.php") ?>

<script>
	$('.addToCartAnchor').click(function(e){
		e.preventDefault();
		console.log($('e.target.parent'));
		$(e.target).parents('form').submit();
	});
</script>