<?
// 	require_once $_SERVER["DOCUMENT_ROOT"] . "/mail.php";
	
// 	$length = 64;
// 	$token = bin2hex(openssl_random_pseudo_bytes($length));
	
// 	$recipient = "ganjaboi.navarro@gmail.com";
	
// 	$headers["From"] = "noreply@rhcloud.com";
// 	$headers["To"] = $recipient;
	
// 	$headers["Subject"] = "SMB Brewery";
// 	$body = "Please verify your account to add an appointment by clicking on this link. \n 
// http://smb-virtuallobby.rhcloud.com/verification?token=" . $token;
	
// 	$params["sendmail_path"] = "/usr/lib/sendmail";
// 	$mail =& Mail::factory("sendmail", $params);
// 	$result = $mail->send($recipient, $headers, $body);
// 	var_dump($result);
	
	echo $GLOBALS['resetcodes'];
	
?>