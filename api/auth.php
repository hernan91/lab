<?php
	session_start();
	
	if(!isset($_SESSION['level']) && LEVEL==2) return header('Location: login.php?error=Para continuar primero debe ingresar');
	if(isset($_SESSION['level']) && $_SESSION['level']==1 && LEVEL==2) return header('Location: login.php?error=Esta sección es solo para administradores');
?>