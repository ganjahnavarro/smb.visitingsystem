			<div class="col-md-4">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-user"></span>
							<span class="glyphicon glyphicon-user"></span> RECENT VISITORS
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small sortableTable">
							<thead>
								<th class="active">NAME</th>
								<th class="active">DATE</th>
								<th class="active">TIME IN</th>
								<th class="active">TIME OUT</th>
							</thead>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT coalesce(w.firstname, a.firstname) as firstname, coalesce(w.lastname, a.lastname) as lastname, v.date, v.timein, v.timeout
							 	FROM visitinfo v LEFT JOIN walkinvisitors w ON w.visitinfoid = v.id
								LEFT JOIN
								(select a.visitinfoid, u.fname as firstname, u.lname as lastname from appointments a left join users u on a.userid = u.id) a
								ON a.visitinfoid = v.id
								WHERE v.timein is not null GROUP BY w.firstname, w.lastname, a.firstname, a.lastname ORDER BY v.id DESC LIMIT 5";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td>" . $row ['firstname'] . " " . $row ['lastname'] . "</td>
                		<td>" . $row ['date'] . "</td>
										<td>" . $row ['timein'] . "</td>
                		<td>" . $row ['timeout'] . "</td>
									</tr>";
								}
							} else {
								echo
									"<tr>
										<td colspan='4'><h1 class='text-center'>NO RESULTS</h1></td>
									</tr>";
							}
							$conn->close ();
							?>
						</table>
					</div>
				</div>
    		</div>

    		<div class="col-md-4">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-user"></span>
							<span class="glyphicon glyphicon-user"></span> MOST VISITOR
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small sortableTable">
							<thead>
								<th class="active">NAME</th>
								<th class="active"></th>
							</thead>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT coalesce(w.firstname, a.firstname) as firstname, coalesce(w.lastname, a.lastname) as lastname, count(v.id) as visit
							 	FROM visitinfo v LEFT JOIN walkinvisitors w ON w.visitinfoid = v.id
								LEFT JOIN
								(select a.visitinfoid, u.fname as firstname, u.lname as lastname from appointments a left join users u on a.userid = u.id) a
								ON a.visitinfoid = v.id
								WHERE v.timein is not null GROUP BY w.firstname, w.lastname, a.firstname, a.lastname ORDER BY visit DESC LIMIT 5";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td>" . $row ['firstname'] . " " . $row ['lastname'] . "</td>
                						<td>" . $row ['visit'] . "</td>
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

    		<div class="col-md-4">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-user"></span>
							<span class="glyphicon glyphicon-user"></span> MOST VISITED PERSON
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small sortableTable">
							<thead>
								<th class="active">NAME</th>
								<th class="active"></th>
							</thead>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT persontovisit, count(persontovisit) as total FROM visitinfo v WHERE timein is not null
								GROUP BY persontovisit ORDER BY total DESC LIMIT 5";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td>" . $row ['persontovisit'] . "</td>
                						<td>" . $row ['total'] . "</td>
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

    		<div class="clearfix"></div>

    		<div class="col-md-4">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-user"></span>
							<span class="glyphicon glyphicon-user"></span> MOST VISITED DEPARTMENT
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small">
							<th class="active">DEPARTMENT</th>
							<th class="active"></th>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT department, count(department) as total FROM visitinfo v WHERE timein is not null
								GROUP BY department ORDER BY total DESC LIMIT 5";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td>" . $row ['department'] . "</td>
                						<td>" . $row ['total'] . "</td>
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

    		<div class="col-md-4">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-user"></span>
							<span class="glyphicon glyphicon-user"></span> TODAY'S NO. OF VISITORS
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small">
							<th class="active">TOTAL</th>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT count(*) as today FROM visitinfo WHERE DATE(`date`) = CURDATE()";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
                						<td><h1 class='text-center'>" . $row ['today'] . "</h1></td>
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

    		<div class="col-md-4">
				<br />

				<div class="panel panel-success">
					<div class="panel-heading">
						<h4>
							<span class="glyphicon glyphicon-user"></span>
							<span class="glyphicon glyphicon-user"></span> TOTAL NO. OF VISITORS
						</h4>
					</div>

					<div class="table-responsive">
						<table class="table table-condensed text-uppercase small">
							<th class="active">TOTAL</th>

							<?php
							$conn = new mysqli ($dbhost, $dbuser, $dbpass, $database);

							if ($conn->connect_error) {
								die ("Connection failed: " . $conn->connect_error);
							}

							$sql = "SELECT count(*) as ct FROM visitinfo where timein is not null";

							$result = $conn->query ($sql);

							if ($result->num_rows > 0) {
								while ( $row = $result->fetch_assoc () ) {
									echo
									"<tr>
										<td><h1 class='text-center'>" . $row ['ct'] . "</h1></td>
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
