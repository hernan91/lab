<?php
	session_start();
	unset($_SESSION['logged']);
	unset($_SESSION['level']);
	session_destroy();
	if ((session_id() != "") || isset($_COOKIE[session_name()])) {
		if ( setcookie(session_name(), '', time()-3600, '/') ) {
			return header('Location: ../login.php');
		}
	}
	else return header('Location: ../login.php');
?>