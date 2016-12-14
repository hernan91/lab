<?php
	function components_cardProduct($id, $name, $code, $manufacturer, $category, $price, $imgId, $imgExtension, $stock, $registered){
		$tagPrice = $registered?'<b>$'.$price.'</b>':"";
		if($imgId==""||$imgExtension==""){
			$imgId = "Relleno";
			$imgExtension = "png";
		}
		$tagAddToCart = "";
		if($registered){
			$tagAddToCart = '
				<div style="margin-left:30px" class="ui left action input">
					<form id="addToCartForm" action="client-show-cart.php">
						<input type="hidden" name="operation" value="add">
						<input type="hidden" name="productId" value="'.$id.'">
						<a class="addToCartAnchor"><i class="cart icon"></i>Agregar</a>
						<input name="quantity" style="padding: 2px; width:50px" type="number" value="1" min="1" max="'.$stock.'">
					</form>
				</div>
			';
		}
		echo '
			<div class="ui card">
				<div class="ui slide masked reveal image">
					<img src="data/img/products/'.$imgId.'.'.$imgExtension.'" class="visible content">
					<div class="hidden content">
						<div class="ui segment">
							<b>Código</b><p>'.$code.'</p>
							<b>Fabricante</b><p>'.$manufacturer.'</p>
							<b>Categoria</b><p>'.$category.'</p>
						</div>
					</div>
				</div>
				<div class="content">
					<a href="client-detail-product.php?code='.$code.'" class="header">'.$name.'</a>
					<div class="meta">
					'.$tagPrice.'
					</div>
				</div>
				<div class="extra content">
					<div>En stock: '.$stock.'</div>
					<div class="ui divider"></div>
					<a href="client-detail-product.php?code='.$code.'" class="seeMore"><i class="add icon"></i>Ver mas</a>
					'.$tagAddToCart.'
				</div>
			</div>
		';
	}	
?>