<!DOCTYPE html>
<?php
	session_start ();
	$role = $_SESSION ['sess_userrole'];
	if (! isset ( $_SESSION ['sess_username'] ) || $role != "GUARD") {
		header ( 'Location: /index.php?err=2' );
	}
	date_default_timezone_set ( 'Asia/Manila' );
?>
<html>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
<body>
	<?php $activeNav = 'register' ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/guard/navbar.php' ); ?>
	
	<div class="container has-success ">
		<div class="row text-left">
			<div class="col-md-12">
				<h1>
					<span class="glyphicon glyphicon-edit"></span><span
						class="glyphicon glyphicon-user"></span>REGISTER VISITOR
				</h1>
			</div>
			<div class="row">
       <?php
			if (isset ( $_POST ['submit'] )) {
				$submit = $_POST ['submit'];
				$firstname = strip_tags ( $_POST ['firstname'] );
				$lastname = strip_tags ( $_POST ['lastname'] );
				$address = strip_tags ( $_POST ['address'] );
				$genderr = strip_tags ( $_POST ['gender'] );
				$department = strip_tags ( $_POST ['department'] );
				
				$purpose = strip_tags ( $_POST ['purpose'] );
				$otherpurpose = strip_tags ( $_POST ['otherpurpose'] );
				
				if($purpose == 'OTHERS'){
					$purpose = $otherpurpose;
				}
				
				$person = strip_tags ( $_POST ['person'] );
				$date = date ( "Y-m-d" );
				$timein = date ( 'h:i A' );
				$passno = strip_tags ( $_POST ['passno'] );
				$issuedby = $_SESSION ['sess_username'];

				if ($submit) {
				    if ($firstname && $lastname && $genderr && $address && $department && $purpose && $person && $date && $timein) {
				        if (strlen ($firstname) >25||strlen ($lastname) >25||strlen ($address) >25) {
							echo "<div class='alert alert-danger' role='alert'>Max limit for First name, Last name, and Company/Address are 25 characters</div>";
						} else  {
							$connect = mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
							mysql_select_db ($database) or die(mysql_error());
							
							$highest_id = mysql_result(mysql_query("SELECT coalesce(MAX(id), 0) + 1 FROM visitinfo"), 0) or die(mysql_error());
							
							$queryvisitinfo = mysql_query("INSERT INTO visitinfo(id, department, purpose, persontovisit, date, timein, passno, issuedby)
									VALUES ('$highest_id', '$department', '$purpose', '$person', '$date', '$timein', '$passno', '$issuedby')") or die(mysql_error());
							
							$querywalkin = mysql_query("INSERT INTO walkinvisitors(firstname, lastname, gender, address, visitinfoid)
									VALUES ('$firstname', '$lastname', '$genderr', '$address', '$highest_id')") or die(mysql_error());
							
							echo ("<div class='alert alert-success' role='alert'>Save Successful</div>");
						}
				    } else {
				    	echo "<div class='alert alert-danger' role='alert'>Please fill in all fields!</div>";
				    }
				}
			}
		?>
		
				<form action="registervisitor.php" method="POST">
					<div class="col-md-6">
						<h3>Personal Information</h3>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>First name
									</h5>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control " name='firstname'
										required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters.">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Last name
									</h5>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control " name='lastname'
										required pattern="[A-Za-z ]{1,25}" title="Letters only. Up to 25 characters.">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Gender
									</h5>
								</div>
								<div class="col-md-8">
									<select class="form-control " name='gender' required>
										<option></option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Company / Address
									</h5>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control " name='address'
										required>
								</div>
							</div>
						</div>
					</div>
					
					<div class="col-md-6">
						<h3>Person To Visit</h3>
						<br>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Department
									</h5>
								</div>
								<div class="col-md-8">
									<select class="form-control " name='department' required>
										<option></option>
										<option value="PACKAGING DEPARTMENT">PACKAGING DEPARTMENT</option>
										<option value="ENGINEERING DEPARTMENT">ENGINEERING DEPARTMENT</option>
										<option value="ADMIN DEPARTMENT">ADMIN DEPARTMENT</option>
									</select>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Purpose</strong>
									</h5>
								</div>
								<div class="col-md-8">
									<select id="purpose" class="form-control" name='purpose' required>
										<option></option>
										<option value="EMPLOYEE / OJT">EMPLOYEE / OJT</option>
										<option value="TRAINING / SEMINAR">TRAINING / SEMINAR</option>
										<option value="COLLECTION">COLLECTION</option>
										<option value="COUNTER">COUNTER</option>
										<option value="DELIVERY">DELIVERY</option>
										<option value="FOR FOLLOW UP">FOR FOLLOW UP</option>
										<option value="INQUIRY">INQUIRY</option>
										<option value="INTERVIEW / EXAM">INTERVIEW / EXAM</option>
										<option value="MASS">MASS</option>
										<option value="MEETING">MEETING</option>
										<option value="PAYMENT">PAYMENT</option>
										<option value="OTHERS">OTHERS</option>
									</select>
								</div>
							</div>
						</div>
						
						<div id="otherpurpose" class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Please Specify</strong>
									</h5>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control " name='otherpurpose' required>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Person To Visit
									</h5>
								</div>
								<div class="col-md-8">
									<input class="form-control " name='person' required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="form-group">
								<div class="col-md-3 text-left">
									<h5>
										<strong>Pass No.
									</h5>
								</div>
								<div class="col-md-8">
									<input type="text" class="form-control " name='passno' required
										 pattern="[A-Za-z0-9]+" title="Letters and numbers only.">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-2">
						<br>
					</div>
					<div class="col-md-8">
						<br> <input type="submit" class="btn btn-primary btn-block"
							name="submit" value="SUBMIT">
					</div>
					<div class="col-md-2">
						<br>
					</div>
				</div>
			</div>
		</div>
	</form>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>
	
	<script>
		$("#purpose").change(function() {
			if($(this).val() == 'OTHERS'){
				$("#otherpurpose").show();
			} else {
				$("#otherpurpose").hide();
			}
		}
	</script>
	
	</body>
</html>