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
	<?php $activeNav = 'index'; $activeSubNav = 'index'; ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/admin/navbar.php' ); ?>

	<div class="container">
		<div class="row text-left">
			<div class="col-md-12 text-uppercase">
				<h1>
					<span class="glyphicon glyphicon-user"></span><span
						class="glyphicon glyphicon-user"></span> WELCOME <?php echo  $_SESSION['sess_username']; ?></h1>
			</div>

			<div class="col-md-7">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-user"></span> RECENTLY ADDED USER
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small sortableTable">
							<thead>
								<th class="active">NAME</th>
								<th class="active">USERNAME</th>
								<th class="active">TYPE</th>
								<th class="active">DATE</th>
								<th class="active">TIME</th>
							</thead>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT * FROM users order by id desc limit 5";
							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td>" . $row ['fname'] . " " . $row ['lname'] . "</td>
										<td>" . $row ['username'] . "</td>
                						<td>" . $row ['type'] . "</td>
										<td>" . $row ['date'] . "</td>
                						<td>" . $row ['time'] . "</td>
									</tr>";
								}
							} else {
								echo
									"<tr>
										<td colspan='5'><h1 class='text-center'>NO RESULTS</h1></td>
									</tr>";
							}
							$conn->close ();
							?>
						</table>
					</div>
				</div>
				<hr />

				<div class="input-group">
					<input type="text" name="search" class="form-control" placeholder="Search Audit Trail" id="searchInput">
					<span class="input-group-btn">
						<button class="btn btn-primary" name="submit" type="submit" id="btnClick">Search</button>
					</span>
				</div>
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-list-alt"></span> AUDIT TRAIL
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small searchableTable sortableTable">
							<thead>
								<th class="active">DATE TIME</th>
								<th class="active">RECORDS</th>
							</thead>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT * FROM audittrail ORDER BY id desc limit 10";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td>" . $row ['date'] . "</td>
                						<td>" . $row ['message'] . "</td>
									</tr>";
								}
							} else {
								echo
									"<tr>
										<td><h1 class='text-center'>NO RESULTS</h1></td>
									</tr>";
							}
							$conn->close ();
							?>
						</table>
					</div>
				</div>
    		</div>

    		<div class="col-md-5">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-facetime-video"></span> RECENTLY ADDED WALKTHROUGH
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small sortableTable">
							<thead>
								<th class="active">TITLE</th>
								<th class="active">DESCRIPTION</th>
							</thead>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT * FROM walkthroughs ORDER BY id desc limit 5";
							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td>" . $row ['name'] . "</td>
                						<td>" . $row ['description'] . "</td>
									</tr>";
								}
							} else {
								echo
									"<tr>
										<td colspan='2'><h1 class='text-center'>NO RESULTS</h1></td>
									</tr>";
							}
							$conn->close ();
							?>
						</table>
					</div>
				</div>

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-question-sign"></span> RECENTLY ADDED FAQs
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small sortableTable">
							<thead>
								<th class="active">QUESTION</th>
								<th class="active">USER TYPE</th>
							</thead>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT * FROM faqs ORDER BY id desc limit 5";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									$type = $row ['type'];
									$type = empty($type) ? 'FOR ALL' : $type;

									echo
									"<tr>
										<td>" . $row ['question'] . "</td>
                						<td>" . $type . "</td>
									</tr>";
								}
							} else {
								echo
									"<tr>
										<td colspan='2'><h1 class='text-center'>NO RESULTS</h1></td>
									</tr>";
							}
							$conn->close ();
							?>
						</table>
					</div>
				</div>
    		</div>
		</div>
	</div>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>
	</body>
</html>
