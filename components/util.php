<?php
	function getTabPath($uri, $level){
		return explode('/', $uri)[$level];
	}
?>