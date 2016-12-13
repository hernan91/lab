<?php
//require 'phpmailer/PHPMailerAutoload.php';

	require 'lib/phpmailer/class.phpmailer.php';
	require 'lib/phpmailer/class.smtp.php';

	function api_internal_mail_sendmail($userEmail){
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug = 1;
		$mail->Debugoutput = 'html';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';		
		$mail->Host = gethostbyname('smtp.gmail.com');
		$mail->Port = 587;		
		$mail->Username = "sharklab2016@gmail.com";
		$mail->Password = "pruebaparalab";
		$mail->setFrom('tecnostore.lab@Gmail.com', 'tecnostore.com');
		$mail->addReplyTo($userEmail, 'tecnostore.com');
		$mail->addAddress($userEmail, 'Lionel Acosta');
		$mail->Subject = 'PHPMailer GMail SMTP test';
		$mail->msgHTML('<p>Su compra fue realizada con éxito.</p>');
		$mail->AltBody = 'This is a plain-text message body';
		return $mail->send();
	}
?>