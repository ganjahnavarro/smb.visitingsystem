<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
</head>
<body class="bg-primary lobby-body">
	<div class="lobby-background">
		<br/><br/><br/>
	
		<div class="col-md-6 col-md-offset-3 lobby-panel">
			<?php
				if (isset ( $_POST ['submit'] )) {
					$username = $_SESSION ['resetusername'];
					$code = strip_tags ( $_POST ['code'] );
					$password = strip_tags ( $_POST ['password'] );
					$confirm = strip_tags ( $_POST ['confirm'] );
					
					mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
					mysql_select_db ($database) or die(mysql_error());
					
					$valid = false;
					
					if ($code != $_SESSION ['resetcode']){
						echo "<div class='alert alert-danger' role='alert'>Invalid reset password code.</div>";
					} else if ($password != $confirm){
						echo "<div class='alert alert-danger' role='alert'>Passwords do not match.</div>";
					} else {
						$valid = true;
					}
					
					if($valid){
						echo "<div class='alert alert-success' role='alert'>Your password has been updated.</div>";
						$queryreg = mysql_query ("UPDATE users SET password = '$password' WHERE username = '$username'" ) or die(mysql_error());
						header ('Location: index.php');
					}
				}
			?>
			
			<div>
				<a href="index.php">
					<img src="/resources/images/logo.png" class="img-responsive center-block" alt="Responsive image">
				</a>
				<br /> <br />
			</div>
		
			<form action='resetfinalize.php' method='POST' name='form'>
				<div class="form-group">
					<h4>RESET PASSWORD</h4>
				</div>
				
				<p class="text-warning">Please check your inbox/spam in your email for reset password code.</p>
				
				<div class="form-group">
					<label>CODE</label>
					<input class="form-control text-uppercase" name='code' required>
				</div>
				
				<div class="form-group">
					<label>NEW PASSWORD</label>
					<input type="password" class="form-control" name='password' required
						pattern="^.{6,}$" title="Minimum of 6 characters is required.">
				</div>
		
				<div class="form-group">
					<label>CONFIRM PASSWORD</label>
					<input type="password" class="form-control" name='confirm' required
						pattern="^.{6,}$" title="Minimum of 6 characters is required.">
				</div>
				<br/>
		
				<div class="form-group">
					<input type="submit" class="btn btn-info btn-lg btn-block" name="submit" value="SUBMIT">
				</div>
				<br/>
			</form>
		</div>
	</div>

</body>
</html>
