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
	<?php $activeNav = 'faqs'; $activeSubNav = 'faqadd'; ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/admin/navbar.php' ); ?>
	
	<?php
		$ispkset = $_SERVER['REQUEST_METHOD'] === 'GET' && isset ($_GET['id']);

		if($ispkset){
			$id = $_GET['id'];
			
			mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
			mysql_select_db ($database) or die(mysql_error());
			
			$result = mysql_query("SELECT * FROM faqs WHERE id = $id");
			$row = mysql_fetch_array($result);
		}
	?>
	
	<div class="container">
		<div class="row text-left">
			<div class="col-md-12">
				<h1>
					<span class="glyphicon glyphicon-plus-sign"></span><span class="glyphicon glyphicon-question-sign"></span> ADD FAQs
				</h1>
				<br />
			</div>
			<br />

			<div class="col-md-8 col-md-offset-2 has-success">
				<?php
					if (isset ( $_POST ['submit'] )) {
						$submit = $_POST ['submit'];
						$question = strip_tags ( $_POST ['question'] );
						$answer = strip_tags ( $_POST ['answer'] );
						$date = date ( "Y-m-d" );
						$type = strip_tags ( $_POST ['type'] );
										
						if ($submit) {
							if ($question && $answer && $date) {
								if (strlen ( $question ) > 150 || strlen ( $answer ) > 1000) {
									echo "<div class='alert alert-danger' role='alert'>Max limit for Question is 150 characters, and 1000 characters for the Answer</div>";
								} else {
									mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
									mysql_select_db ($database) or die(mysql_error());
									
									$id = $_POST['id'];
								
									if($id != null){
										$typeUpdate = empty($type) ? "type = '$type', " : "type = null, ";
										$queryreg = mysql_query ("UPDATE faqs set " . $typeUpdate . " question = '$question', answer = '$answer', date = '$date' where id = '$id'" ) or die(mysql_error());
									} else {
										if(empty($type)){
											$queryreg = mysql_query ("INSERT INTO faqs(question, answer, date)
													VALUES ('$question', '$answer', '$date')" ) or die(mysql_error());
										} else {
											$queryreg = mysql_query ("INSERT INTO faqs(type, question, answer, date)
													VALUES ('$type', '$question', '$answer', '$date')" ) or die(mysql_error());
										}
									}
									
									echo ("<div class='alert alert-success' role='alert'>Saved successful</div>");
								}
							} else {
								echo "<div class='alert alert-danger' role='alert'>Please fill in all fields!</div>";
							}
						}
					}
				?>

				<form action='addfaq.php' method='POST'>
					<input name="id" type="hidden" value="<?php if($ispkset){ echo $row['id'];} ?>">

					<div class="form-group">
						<p>
							<b>USER TYPE</b>
						</p>
						<select class="form-control" name='type'>
							<option></option>
							<option value="DEFAULT" <?php if($ispkset && $row['type'] == 'DEFAULT'){ echo 'selected';} ?>>DEFAULT</option>
							<option value="GUARD" <?php if($ispkset && $row['type'] == 'GUARD'){ echo 'selected';} ?>>GUARD</option>
							<option value="HR" <?php if($ispkset && $row['type'] == 'HR'){ echo 'selected';} ?>>HR</option>
							<option value="ADMIN" <?php if($ispkset && $row['type'] == 'ADMIN'){ echo 'selected';} ?>>ADMIN</option>
						</select>
					</div>

					<div class="form-group">
						<p>
							<b>QUESTION</b>
						</p>
						<textarea class="form-control" rows="4" name="question"><?php if($ispkset){ echo $row['question'];} ?></textarea>
					</div>

					<p class="help-block">
						<b>EXAMPLE :</b> What is ...?
					</p>

					<div class="form-group">
						<p>
							<b>ANSWER</b>
						</p>
						<textarea class="form-control" rows="4" name="answer"><?php if($ispkset){ echo $row['answer'];} ?></textarea>
					</div>

					<p class="help-block">
						<b>EXAMPLE :</b> The...
					</p>

					<div class="form-group">
						<input type="submit" class="btn btn-primary btn-block " name='submit' value="SAVE">
					</div>
				</form>
			</div>
			<br/>
		</div>
	</div>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>

	</body>
</html>
