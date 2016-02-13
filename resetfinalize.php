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
			$question = strip_tags ( $_POST ['question'] );
			$answer = strip_tags ( $_POST ['answer'] );
			$password = strip_tags ( $_POST ['password'] );
			$confirm = strip_tags ( $_POST ['confirm'] );
			
			mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
			mysql_select_db ($database) or die(mysql_error());
			
			$count = mysql_result(mysql_query("SELECT count(*) FROM users where username = '$username'
					and question = '$question' and answer = '$answer'"), 0);
			
			if($count > 0){
				if ($password == $confirm) {
					$queryreg = mysql_query ("update users set password = '$password' where username = '$username'" ) or die(mysql_error());
					echo "<div class='alert alert-success' role='alert'>Your password has been reset.</div>";
				} else {
					echo "<div class='alert alert-danger' role='alert'>Passwords do not match</div>";
				}
			} else {
				echo "<div class='alert alert-danger' role='alert'>Invalid username, security question or answer.</div>";
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

	<form action='resetpassword.php' method='POST' name='form'
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
		
		<div class="form-group">
			<label>SECURITY QUESTION</label>
			<select class="form-control" name='question' required>
				<option></option>
				<?php
					mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
					mysql_select_db ($database) or die(mysql_error());
					
					$queryString = "SELECT * FROM securityquestions ORDER BY id desc";
					$query = mysql_query ($queryString) or die ( mysql_error () );

					while ( $row = mysql_fetch_array ( $query ) ) {
						$id = $row ['id'];
						$question = $row ['question'];
						echo "<option value=" . $id . ">" . $question . "</option>";
					}
				?>
			</select>
		</div>
		
		<div class="form-group">
			<label>ANSWER</label>
			<input class="form-control text-uppercase" name='answer' required>
		</div>
		
		<div class="form-group">
			<label>PASSWORD</label>
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

		<br/> <br/>
	</form>

</body>
</html>
