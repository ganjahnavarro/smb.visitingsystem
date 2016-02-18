<!DOCTYPE html>
<?php
	session_start ();
	$role = $_SESSION ['sess_userrole'];
	if (! isset ( $_SESSION ['sess_username'] ) || $role != "ADMIN") {
		header ( 'Location: /index.php?err=2' );
	}
	date_default_timezone_set ( 'Asia/Manila' );
?>
<html>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
<body>
	<?php $activeNav = 'users'; $activeSubNav = 'useradd'; ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/admin/navbar.php' ); ?>

	<?php
		$ispkset = $_SERVER['REQUEST_METHOD'] === 'GET' && isset ($_GET['id']);

		if($ispkset){
			$id = $_GET['id'];

			$connect = mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
			mysql_select_db ($database) or die(mysql_error());

			$result = mysql_query("SELECT * FROM users WHERE id = $id");
			$row = mysql_fetch_array($result);
		}
	?>

	<div class="container">
		<div class="row text-left">
			<div class="col-md-12">
				<h1>
					<span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-user"></span> ADD USER
				</h1>
				<br />
			</div>
			<div class="col-md-2">&nbsp;</div>
			<div class="col-md-8 has-success">
			<?php
				if (isset ( $_POST ['submit'] )) {
					$submit = $_POST ['submit'];
					$fname = strip_tags ( $_POST ['fname'] );
					$mname = strip_tags ( $_POST ['mname'] );
					$lname = strip_tags ( $_POST ['lname'] );
					$bday = strip_tags ( $_POST ['bday'] );
					$gender = strip_tags ( $_POST ['gender'] );
					$address = strip_tags ( $_POST ['address'] );
					$contact = strip_tags ( $_POST ['contact'] );
					$email = strip_tags ( $_POST ['email'] );
					$type = strip_tags ( $_POST ['usertype'] );
					$username = strip_tags ( $_POST ['username'] );
					$password = strip_tags ( $_POST ['password'] );
					$confirm = strip_tags ( $_POST ['confirm'] );
					
					$date = date ( "Y-m-d" );
					$time = date ( 'h:i A' );

					if ($fname && $mname && $lname && $bday && $gender && $address && $contact && $type
							&& $email && $username && $password && $confirm && $date && $time) {

						if ($password == $confirm) {
							$password = ($password);
							$confirm = ($confirm);
							
							$imageFileName = 'placeholder.png';

							mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
							mysql_select_db ($database) or die(mysql_error());

							$id = $_POST['id'];

							if($id != null){
								$queryreg = mysql_query ("UPDATE users set fname = '$fname', mname = '$mname', lname = '$lname', bday = '$bday', gender = '$gender', email = '$email',
									address = '$address', contact = '$contact', username = '$username', password = '$password', imageFileName = '$imageFileName' where id = '$id'" ) or die(mysql_error());
							} else {
								$queryreg = mysql_query ("INSERT INTO users(fname, mname, lname, bday, email,
										gender, address, contact, username, password, type, date, time, imageFileName, verified)
									VALUES ('$fname', '$mname', '$lname', '$bday', '$email',
										'$gender','$address','$contact','$username','$password','$type','$date','$time', '$imageFileName', true)" ) or die(mysql_error());
							}
							echo "<div class='alert alert-success' role='alert'>Save successful</div>";
						} else
							echo "<div class='alert alert-danger' role='alert'>Password do not match</div>";
					} else {
						echo "<div class='alert alert-danger' role='alert'>Please fill in all fields!</div>";
					}
				}
			?>

                <form action='adduser.php' method='POST' name='form'>
                	<input name="id" type="hidden" value="<?php if($ispkset){ echo $row['id'];} ?>">

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
						
						<div class="form-group col-md-4">
							<label>USERNAME</label>
							<input type="text" class="form-control text-uppercase" name="username" required
								pattern="^.{8,}$" title="Minimum of 8 characters is required."
								value="<?php if(isset($username)){ echo $username;} ?>">
						</div>
				
						<div class="form-group col-md-4">
							<label>EMAIL</label>
							<input type="email" class="form-control" name='email' required
								value="<?php if(isset($email)){ echo $email;} ?>">
						</div>
						
						<div class="form-group col-md-4">
							<label>CONTACT NO.</label>
							<input type="number" class="form-control" name='contact' required min="0"
								value="<?php if(isset($contact)){ echo $contact;} ?>">
						</div>
				
						<div class="form-group col-md-4">
							<label>PASSWORD</label>
							<input type="password" class="form-control" name='password' required
								pattern="^.{6,}$" title="Minimum of 6 characters is required."
								value="<?php if(isset($password)){ echo $password;} ?>">
						</div>
				
						<div class="form-group col-md-4">
							<label>CONFIRM PASSWORD</label>
							<input type="password" class="form-control" name='confirm' required
								pattern="^.{6,}$" title="Minimum of 6 characters is required."
								value="<?php if(isset($confirm)){ echo $confirm;} ?>">
						</div>
						
						<div class="form-group col-md-4">
							<label>USER TYPE</label>
							<select class="form-control" name='usertype' required>
								<option></option>
								<option value="DEFAULT" <?php if($ispkset && $row['type'] == 'DEFAULT'){ echo 'selected';} ?>>DEFAULT</option>
								<option value="GUARD" <?php if($ispkset && $row['type'] == 'GUARD'){ echo 'selected';} ?>>GUARD</option>
								<option value="HR" <?php if($ispkset && $row['type'] == 'HR'){ echo 'selected';} ?>>HR</option>
								<option value="ADMIN" <?php if($ispkset && $row['type'] == 'ADMIN'){ echo 'selected';} ?>>ADMIN</option>
							</select>
							<br/>
						</div>
						
						<div class="form-group col-xs-12">
							<input type="submit" class="btn btn-info btn-lg btn-block" name="submit" value="SUBMIT">
						</div>
						<br/> <br/>
					</div>
				</form>
			</div>
			<div class="col-md-2">&nbsp;</div>
		</div>
	</div>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>
	</body>
</html>
