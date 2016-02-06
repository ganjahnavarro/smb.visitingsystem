<!DOCTYPE html>
<?php
session_start ();
$role = $_SESSION ['sess_userrole'];
if (! isset ( $_SESSION ['sess_username'] ) || $role != "ADMIN") {
	header ( 'Location: /index.php?err=2' );
}
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
					$age = strip_tags ( $_POST ['age'] );
					$bday = strip_tags ( $_POST ['bday'] );
					$gender = strip_tags ( $_POST ['gender'] );
					$address = strip_tags ( $_POST ['address'] );
					$contact = strip_tags ( $_POST ['contact'] );
					$type = strip_tags ( $_POST ['usertype'] );
					$username = strip_tags ( $_POST ['username'] );
					$password = strip_tags ( $_POST ['password'] );
					$confirm = strip_tags ( $_POST ['confirm'] );
					$date = date ( "Y-m-d" );
					date_default_timezone_set ( 'Asia/Manila' );
					$time = date ( 'h:i A' );

					if ($fname && $mname && $lname && $age && $bday && $gender && $address && $contact && $type
							&& $username && $password && $confirm && $date && $time) {

						if ($password == $confirm) {
							$password = ($password);
							$confirm = ($confirm);
							
							$imageFileName = $imageFileName == null ? 'placeholder.png' : $imageFileName;

							mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
				mysql_select_db ($database) or die(mysql_error());

							$id = $_POST['id'];

							if($id != null){
								$queryreg = mysql_query ("UPDATE users set fname = '$fname', mname = '$mname', lname = '$lname', age = '$age', bday = '$bday', gender = '$gender',
									address = '$address', contact = '$contact', username = '$username', password = '$password', imageFileName = '$imageFileName' where id = '$id'" ) or die(mysql_error());
							} else {
								$queryreg = mysql_query ("INSERT INTO users(fname, mname, lname, age, bday, gender, address, contact, username, password, type, date, time, imageFileName)
									VALUES ('$fname','$mname','$lname','$age','$bday','$gender','$address','$contact','$username','$password','$type','$date','$time', '$imageFileName')" ) or die(mysql_error());
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

					<div class="form-group">
						<h4>PERSONAL INFORMATION</h4>
					</div>
					
					<div class="form-group">
						<p>
							<b>FIRSTNAME</b>
						</p>
						<input class="form-control" name='fname'
							required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters."
							value="<?php if($ispkset){ echo $row['fname'];} ?>">
					</div>
					<p></p>
					<div class="form-group ">
						<p>
							<b>MIDDLE NAME</b>
						</p>
						<input class="form-control" name='mname' required
							required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters."
							value="<?php if($ispkset){ echo $row['mname'];} ?>">
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>LASTNAME</b>
						</p>
						<input class="form-control" name='lname' required
							required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters."
							value="<?php if($ispkset){ echo $row['gender'];} ?>">
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>AGE</b>
						</p>
						<input class="form-control" type="number" name='age' required min="0"
							 value="<?php if($ispkset){ echo $row['age'];} ?>">
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>BIRTHDAY</b>
						</p>
						<input class="form-control" type="date" name='bday' required
							 value="<?php if($ispkset){ echo $row['bday'];} ?>">
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>GENDER</b>
						</p>
						<select class="form-control" name='gender' required>
							<option></option>
							<option value="Male" <?php if($ispkset && $row['gender'] == 'Male'){ echo 'selected';} ?>>Male</option>
							<option value="Female" <?php if($ispkset && $row['gender'] == 'Female'){ echo 'selected';} ?>>Female</option>
						</select>
					</div>
					<p></p>
					<div class="form-group ">
						<p>
							<b>ADDRESS</b>
						</p>
						<input class="form-control" name='address' required
							 value="<?php if($ispkset){ echo $row['address'];} ?>">
					</div>
					<br />
					<div class="form-group">
						<h4>ACCOUNT INFORMATION</h4>
					</div>
					<div class="form-group">
						<p>
							<b>CONTACT NO.</b>
						</p>
						<input type="number" class="form-control" name='contact' required min="0"
							 value="<?php if($ispkset){ echo $row['contact'];} ?>">
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>USER TYPE</b>
						</p>
						<select class="form-control" name='usertype' required>
							<option></option>
							<option value="DEFAULT" <?php if($ispkset && $row['type'] == 'DEFAULT'){ echo 'selected';} ?>>DEFAULT</option>
							<option value="GUARD" <?php if($ispkset && $row['type'] == 'GUARD'){ echo 'selected';} ?>>GUARD</option>
							<option value="HR" <?php if($ispkset && $row['type'] == 'HR'){ echo 'selected';} ?>>HR</option>
							<option value="ADMIN" <?php if($ispkset && $row['type'] == 'ADMIN'){ echo 'selected';} ?>>ADMIN</option>
						</select>
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>USERNAME</b>
						</p>
						<input type="text" class="form-control text-uppercase" name="username" required
							pattern="^.{8,}$" title="Minimum of 8 characters is required."
							value="<?php if($ispkset){ echo $row['username'];} ?>">
						<div id="feedback"></div>
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>PASSWORD</b>
						</p>
						<input type="password" class="form-control" name='password' required
							pattern="^.{6,}$" title="Minimum of 6 characters is required."
							value="<?php if($ispkset){ echo $row['password'];} ?>">
					</div>
					<p></p>
					<div class="form-group">
						<p>
							<b>CONFIRM PASSWORD</b>
						</p>
						<input type="password" class="form-control" name='confirm' required
							pattern="^.{6,}$" title="Minimum of 6 characters is required."
							value="<?php if($ispkset){ echo $row['password'];} ?>">
					</div>
					<br />
					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="SUBMIT">
					</div>
				</form>
			</div>
			<div class="col-md-2">&nbsp;</div>
		</div>
	</div>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>
	</body>
</html>
