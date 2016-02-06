<!DOCTYPE html>
<?php
	session_start ();
	$role = $_SESSION ['sess_userrole'];
	if (! isset ( $_SESSION ['sess_username'] ) || $role !="ADMIN") {
		header ( 'Location: /index.php?err=2' );
	}
?>
<html>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
<body>
	<?php $activeNav = 'walkthroughs'; $activeSubNav = 'walkthroughadd'; ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/admin/navbar.php' ); ?>

	<?php
		$ispkset = $_SERVER['REQUEST_METHOD'] === 'GET' && isset ($_GET['id']);

		if($ispkset){
			$id = $_GET['id'];

			$connect = mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
			mysql_select_db ($database) or die(mysql_error());

			$result = mysql_query("SELECT * FROM walkthroughs WHERE id = $id");
			$row = mysql_fetch_array($result);
		}
	?>
	<div class="container">
		<div class="row text-left">
			<div class="col-md-12">
				<h1>
					<span class="glyphicon glyphicon-plus-sign"></span>
					<span class="glyphicon glyphicon-facetime-video"></span> ADD WALKTHROUGH
				</h1>
				<br />
			</div>
			<div class="col-md-2">&nbsp;</div>
			<div class="col-md-8 has-success">
			<?php
				if (isset ( $_POST ['submit'] )) {
					$submit = $_POST ['submit'];
					$name = strip_tags ( $_POST ['name'] );
					$description = strip_tags ( $_POST ['description'] );
					$link = strip_tags ( $_POST ['link'] );
					$department = strip_tags ( $_POST ['department'] );
					$floor = strip_tags ( $_POST ['floor'] );

					if ($submit) {
						if ($name && $link) {
							$connect = mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
							mysql_select_db ($database) or die(mysql_error());

							$id = $_POST['id'];

							if($id != null){
								$queryreg = mysql_query ("UPDATE walkthroughs set name = '$name', description = '$description',
										link = '$link', department = '$department', floor = '$floor' where id = '$id'" ) or die(mysql_error());
							} else {
								$queryreg = mysql_query ("INSERT INTO walkthroughs(name, description, link, department, floor)
									VALUES ('$name', '$description', '$link', '$department', '$floor')" ) or die(mysql_error());
							}
							echo"<div class='alert alert-success' role='alert'>Save successful</div>";
						} else
							echo"<div class='alert alert-danger' role='alert'>Please fill in all fields!</div>";
						}
					}
				?>

                <form action='addwalkthrough.php' method='POST' name='form'>
                	<input name="id" type="hidden" value="<?php if($ispkset){ echo $row['id'];} ?>">

					<div class="form-group">
						<label>TITLE</label>
						<input class="form-control" name='name' required
							value="<?php if($ispkset){ echo $row['name'];} ?>">
					</div>
					<p></p>

					<div class="form-group">
						<label>DESCRIPTION</label>
						<textarea class="form-control" name='description'><?php if($ispkset){ echo $row['description'];} ?></textarea>
					</div>
					<p></p>

					<div class="form-group">
						<label>EMBEDDABLE LINK</label>
						<input class="form-control" name='link' required
							value="<?php if($ispkset){ echo $row['link'];} ?>">
					</div>
					<br />

					<div class="form-group">
						<label>DEPARTMENT</label>
						<select class="form-control" name='department' required>
							<option></option>
							<option value="PACKAGING DEPARTMENT">PACKAGING DEPARTMENT</option>
							<option value="ENGINEERING DEPARTMENT">ENGINEERING DEPARTMENT</option>
							<option value="ADMIN DEPARTMENT">ADMIN DEPARTMENT</option>
						</select>
					</div>

					<div class="form-group">
						<label>FLOOR</label>
						<select class="form-control" name='floor' required>
							<option></option>
							<option></option>
							<option value="1st Floor">1ST FLOOR</option>
							<option value="2nd Floor">2ND FLOOR</option>
							<option value="3rd Floor">3RD FLOOR</option>
							<option value="4th Floor">4TH FLOOR</option>
							<option value="5th Floor">5TH FLOOR</option>
							<option value="6th Floor">6TH FLOOR</option>
							<option value="7th Floor">7TH FLOOR</option>
							<option value="8th Floor">8TH FLOOR</option>
						</select>
					</div>

					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-lg btn-block" name="submit" value="SUBMIT">
					</div>
				</form>
			</div>
			<br />

		</div>
	</div>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>
	</body>
</html>
