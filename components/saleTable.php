<?php

	function saleTable($listOfProducts, $idSale){
			echo'
				<table class="ui selectable celled table">
					<thead>
						<tr>
							<th class="center aligned">Código de producto</th>
							<th class="center aligned">Nombre de producto</th>
							<th class="center aligned">Fabricante</th>
							<th class="center aligned">Precio</th>
							<th class="center aligned">Cantidad</th>
						</tr>
					</thead>
					<tbody>';
							$totalPrice = 0;
							foreach($listOfProducts as $product){
								$product = api_internal_products_getProductData($product['id_product'], $idSale);
								echo '<tr>';
								$productId = $product['product_id'];
								$price = $product['product_price'];
								$quantity = $product['quantity'];
								
								foreach($product as $key=>$value){
									if($key=="sale_id" || $key=="product_id") continue;
									if($key=="product_name"){
										echo '<td class="center aligned"><a href="client-detail-product.php?code='.$product["product_code"].'">'.$value.'</a></td>';
										continue;	
									}
									echo '<td class="center aligned">'.$value.'</td>';
								}
								echo '</tr>';
								$totalPrice = $totalPrice + $price*$quantity;
							}
			echo	'</tbody>
					<tfoot align="right" class="full-width">
						<tr>
							<th colspan="6"><h3 style="display:inline">Total</h3><span> $ '.$totalPrice.'</span></th>
						</tr>
					</tfoot>
				</table>	
			';
		}

?>