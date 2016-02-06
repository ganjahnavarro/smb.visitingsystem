<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
</head>
<body class="bg-primary">
	<br/><br/><br/>
	
	<div class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2">
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/upload.php' ); ?>
	
	<?php
		if (isset ( $_POST ['submit'] )) {
			$submit = $_POST ['submit'];
			$fname = strip_tags ( $_POST ['fname'] );
			$mname = strip_tags ( $_POST ['mname'] );
			$lname = strip_tags ( $_POST ['lname'] );
			$age = strip_tags ( $_POST ['age'] );
			$bday = strip_tags ( $_POST ['bday'] );
			$gender = strip_tags ( $_POST ['gender'] );
			$address = strip_tags ( $_POST ['address'] );
			$contact = strip_tags ( $_POST ['contact'] );
			$username = strip_tags ( $_POST ['username'] );
			$question = strip_tags ( $_POST ['question'] );
			$answer = strip_tags ( $_POST ['answer'] );
			$password = strip_tags ( $_POST ['password'] );
			$confirm = strip_tags ( $_POST ['confirm'] );
			$date = date ( "Y-m-d" );
			date_default_timezone_set ( 'Asia/Manila' );
			$time = date ( 'h:i A' );

			if ($fname && $mname && $lname && $age && $bday && $gender && $address && $contact
					&& $username && $password && $confirm && $date && $time) {

				if ($password == $confirm) {
					require_once $_SERVER['DOCUMENT_ROOT'] . '/secureimage/securimage.php';
					$securimage = new Securimage ();
					$captcha = $_POST['captchainput'];
					
					if ($securimage->check ( $captcha ) == false) {
						echo "<div class='alert alert-danger' role='alert'>Wrong captcha code entered.</div>";
					} else {
						mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
						mysql_select_db ($database) or die(mysql_error());
						
						$existingusername = mysql_result(mysql_query("SELECT count(*) FROM users where username = '$username'"), 0);
						
						if($existingusername > 0){
							echo "<div class='alert alert-danger' role='alert'>Username already exists.</div>";
						} else {
							$imageFileName = $imageFileName == null ? 'placeholder.png' : $imageFileName;
							
							$queryreg = mysql_query ("INSERT INTO users(fname, mname, lname, age, bday, gender,
									address, contact, username, password, type, date, time, imageFileName, question, answer)
									VALUES ('$fname','$mname','$lname','$age','$bday','$gender',
									'$address','$contact','$username','$password', 'DEFAULT','$date','$time', '$imageFileName', '$question', '$answer')" ) or die(mysql_error());
							
							echo "<div class='alert alert-success' role='alert'>Registration successful.</div>";
						}
					}
				} else {
					echo "<div class='alert alert-danger' role='alert'>Passwords do not match</div>";
				}
			} else {
				echo "<div class='alert alert-danger' role='alert'>Please fill in all fields!</div>";
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

	<form action='register.php' method='POST' name='form'
		class="col-md-10 col-md-offset-1 col-lg-8 col-lg-offset-2 registerform" enctype="multipart/form-data">
		
		<div class="row">
			<div class="form-group col-xs-12">
				<h4>PERSONAL INFORMATION</h4>
			</div>
	
			<div class="form-group col-md-4">
				<label>IMAGE</label>
				<input class="form-control" type="file" name="imageUpload" id="imageUpload" required>
			</div>
	
			<div class="form-group col-md-4">
				<label>FIRST NAME</label>
				<input class="form-control" name='fname' required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters."
					value="<?php if(isset($fname)){ echo $fname;} ?>">
			</div>
	
			<div class="form-group col-md-4">
				<label>MIDDLE NAME</label>
				<input class="form-control" name='mname' required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters."
					value="<?php if(isset($mname)){ echo $mname;} ?>">
			</div>
	
			<div class="form-group col-md-4">
				<label>LASTNAME</label>
				<input class="form-control" name='lname' required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters."
					value="<?php if(isset($lname)){ echo $lname;} ?>">
			</div>
	
			<div class="form-group col-md-4">
				<label>AGE</label>
				<input class="form-control" type="number" name='age' required min="0"
					value="<?php if(isset($age)){ echo $age;} ?>">
			</div>
	
			<div class="form-group col-md-4">
				<label>BIRTHDAY</label>
				<input class="form-control" type="date" name='bday' required
					value="<?php if(isset($bday)){ echo $bday;} ?>">
			</div>
	
			<div class="form-group col-md-4">
				<label>GENDER</label>
				<select class="form-control" name='gender' required>
					<option></option>
					<option value="Male" <?php if(isset($gender) && $gender == 'Male'){ echo 'selected';} ?>>Male</option>
					<option value="Female" <?php if(isset($gender) && $gender == 'Female'){ echo 'selected';} ?>>Female</option>
				</select>
			</div>
	
			<div class="form-group col-md-6">
				<label>ADDRESS</label>
				<input class="form-control" name='address' required
					value="<?php if(isset($address)){ echo $address;} ?>">
			</div>
			<br/>
		</div>
		
		<div class="row">
			<div class="form-group col-xs-12">
				<h4>ACCOUNT INFORMATION</h4>
			</div>
			
			<div class="form-group col-md-6">
				<label>USERNAME</label>
				<input type="text" class="form-control text-uppercase" name="username" required
					pattern="^.{8,}$" title="Minimum of 8 characters is required."
					value="<?php if(isset($username)){ echo $username;} ?>">
			</div>
	
			<div class="form-group col-md-6">
				<label>CONTACT NO.</label>
				<input type="number" class="form-control" name='contact' required min="0"
					value="<?php if(isset($contact)){ echo $contact;} ?>">
			</div>
	
			<div class="form-group col-md-6">
				<label>PASSWORD</label>
				<input type="password" class="form-control" name='password' required
					pattern="^.{6,}$" title="Minimum of 6 characters is required."
					value="<?php if(isset($password)){ echo $password;} ?>">
			</div>
	
			<div class="form-group col-md-6">
				<label>CONFIRM PASSWORD</label>
				<input type="password" class="form-control" name='confirm' required
					pattern="^.{6,}$" title="Minimum of 6 characters is required."
					value="<?php if(isset($confirm)){ echo $confirm;} ?>">
			</div>
			
			<div class="form-group col-md-6">
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
							$questionoption = $row ['question'];
							echo "<option value=" . $id . ">" . $questionoption . "</option>";
						}
					?>
				</select>
			</div>
			
			<div class="form-group col-md-6">
				<label>ANSWER</label>
				<input class="form-control text-uppercase" name='answer' required>
			</div>
	
			<div class="form-group col-md-6">
				<label>CAPTCHA</label>
				<div class="captcha">
		    		<?php
						require_once $_SERVER['DOCUMENT_ROOT'] . '/secureimage/securimage.php';
						$options = array ();
						$options ['input_name'] = 'captchainput';
						$options ['disable_flash_fallback'] = false;
						echo Securimage::getCaptchaHtml ( $options );
					?>
				</div>
				<br/>
			</div>
			

			<div class="form-group col-xs-12">
				<input type="submit" class="btn btn-info btn-lg btn-block" name="submit" value="SUBMIT">
			</div>
	
			<br/> <br/>
		</div>
	</form>

	<script>
		$(document).ready(function() {
			$('#captcha_code').addClass('form-control');
		});
	</script>
</body>
</html>
