<!DOCTYPE html>
<html>
<head>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
</head>
<body class="bg-primary">
	<br /> <br /> <br />
	
	<div class="col-md-6 col-md-offset-3">
		<img src="/resources/images/logo.png" class="img-responsive center-block" alt="Responsive image"> <br /> <br />
	</div>
	
	<?php
		$username = filter_input(INPUT_GET, 'username');
		$token = filter_input(INPUT_GET, 'token');
		
		mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
		mysql_select_db ($database) or die(mysql_error());
		
		$success = false;
		
		try {
			$validcount = mysql_result(mysql_query("SELECT count(*) FROM users where username = '$username' and verification_token = '$token'"), 0);
			
			if($validcount == 1){
				$success = true;
			}
		} catch (Exception $e) {
			$success = false;
		}
		
		if($success){
			$updateuser = mysql_query ("UPDATE users set verified = true where username = '$username'" ) or die(mysql_error());
			
			echo '
				<div class="form-group col-md-6 col-md-offset-3">
					<div class="alert alert-success">
						<p>Your account is now verified.</p>
					</div> <br/>
					<a href="user/index.php"><button class="btn btn-info">Go to SMB Brewery Virtual Lobby</button></a>
				</div>';
		} else {
			echo '
				<div class="form-group col-md-6 col-md-offset-3">
					<div class="alert alert-danger">
						<p>Invalid username or token.</p>
					</div>
				</div>';
		}
	?>
	
</body>
</html>