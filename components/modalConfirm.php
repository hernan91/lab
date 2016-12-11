<?php

function components_modal_confirm($title, $text, $idModal){
	echo'	<div class="ui basic modal" id="'.$idModal.'">
				<i class="close icon"></i>
				<div class="header">'.$title.'</div>
				<div class="image content">
					<div class="small image">
						<i class="add icon"></i>
					</div>
					<div class="description">
						<p>'.$text.'</p>
					</div>
				</div>
				<div class="actions">
					<div class="two fluid ui inverted buttons">
						<div class="ui cancel red basic inverted button">
							<i class="remove icon"></i> No
						</div>
						<div class="ui ok green basic inverted button">
							<i class="checkmark icon"></i> Si
						</div>
					</div>
				</div>
			</div>
	';
}
	
?>