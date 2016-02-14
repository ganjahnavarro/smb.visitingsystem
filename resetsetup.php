<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
</head>
<body class="bg-primary">
	<br/><br/><br/>

	<div class="col-md-6 col-md-offset-3">
	<?php
		if (isset ( $_POST ['submit'] )) {
			$username = strip_tags ( $_POST ['username'] );
			
			mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
			mysql_select_db ($database) or die(mysql_error());
			
			$count = mysql_result(mysql_query("SELECT count(*) FROM users where username = '$username'"), 0);
			
			if($count == 1){
				require_once $_SERVER["DOCUMENT_ROOT"] . "/mail.php";
					
				$recipient = mysql_result(mysql_query("SELECT email FROM users where username = '$username'"), 0);

				if($recipient != null){
					$headers["From"] = "noreply@rhcloud.com";
					$headers["To"] = $recipient;
					
					$length = 6;
					$code = bin2hex(openssl_random_pseudo_bytes($length));
					
					$headers["Subject"] = "SMB Brewery: Reset Password";
					$body = "Reset Password code: " . $code;
						
					$params["sendmail_path"] = "/usr/lib/sendmail";
					$mail =& Mail::factory("sendmail", $params);
					$result = $mail->send($recipient, $headers, $body);
					
					$_SESSION ['resetusername'] = $username;
					$_SESSION ['resetcode'] = $code;
					
					header ('Location: resetfinalize.php');
				} else {
					echo "<div class='alert alert-danger' role='alert'>User has no email. Contact SMB Brewery Virtual Lobby administrators.</div>";
				}
			} else {
				echo "<div class='alert alert-danger' role='alert'>Invalid username. Please try again.</div>";
			}
		}
	?>
	</div>

	<div>
		<div class="col-md-6 col-md-offset-3">
			<a href="index.php">
				<img src="/resources/images/logo.png" class="img-responsive center-block" alt="Responsive image">
			</a>
			<br /> <br />
		</div>
	</div>

	<form action='resetsetup.php' method='POST' name='form'
		class="col-md-6 col-md-offset-3">

		<div class="form-group">
			<h4>RESET PASSWORD</h4>
		</div>
		
		<div class="form-group">
			<label>USERNAME</label>
			<input type="text" class="form-control text-uppercase" name="username" required
				pattern="^.{8,}$" title="Minimum of 8 characters is required."
				value="<?php if(isset($username)){ echo $username;} ?>">
		</div>
		<br/>

		<div class="form-group">
			<input type="submit" class="btn btn-info btn-lg btn-block" name="submit" value="NEXT">
		</div>
		
		<br/> <br/>
	</form>

</body>
</html>
