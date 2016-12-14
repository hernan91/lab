<?php
//require 'phpmailer/PHPMailerAutoload.php';

	require 'lib/phpmailer/class.phpmailer.php';
	require 'lib/phpmailer/class.smtp.php';

	function api_internal_mail_sendmail($userEmail){
		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'tls';		
		$mail->Host = gethostbyname('smtp.gmail.com');
		$mail->Port = 587;		
		$mail->Username = "tecnostore.lab@Gmail.com";
		$mail->Password = "13579ghj";
		$mail->setFrom('tecnostore.lab@Gmail.com', 'tecnostore.com');
		$mail->addReplyTo($userEmail, 'tecnostore.com');
		$mail->addAddress($userEmail, 'Hernan da Silva');
		$mail->Subject = 'Compra en Tecnostore';
		$mail->msgHTML('<h3>Su compra fue realizada con éxito.</h3><p>');
		$mail->AltBody = 'This is a plain-text message body';
		return $mail->send();
	}
?>