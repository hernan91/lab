<?php
	session_start();
	unset($_SESSION['logged']);
	unset($_SESSION['level']);
	session_destroy();
	if ((session_id() != "") || isset($_COOKIE[session_name()])) {
		if ( setcookie(session_name(), '', time()-3600, '/') ) {
			return header('Location: ../login.php?success=Usted%20se%20ha%20desautentificado%20correctamente');
		}
	}
	else return header('Location: ../login.php?success=Usted%20se%20ha%20desautentificado%20correctamente');
?>