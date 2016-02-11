<!DOCTYPE html>
<?php
	session_start ();
	$role = $_SESSION ['sess_userrole'];
	if (! isset ( $_SESSION ['sess_username'] ) || $role != "HR") {
		header ( 'Location: /index.php?err=2' );
	}
?>
<html>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
<body>
	<?php $activeNav = 'visitors' ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/hr/navbar.php' ); ?>

	<div class="container">
		<div class="row text-left">
			<div class="row">
				<div class="col-md-8 hide-on-print">
					<h1>
						<span class="glyphicon glyphicon-user"></span>
						<span class="glyphicon glyphicon-user"></span> VISITORS
					</h1>
				</div>
				<div class="col-md-4 hide-on-print">
					<button class="btn btn-info pull-right" onclick="window.print();">Print</button>
				</div>
			</div>
			<br />
			
			<div class="clearfix"></div>

			<div class="row">
				<form action="visitors.php" method="POST">
					<div class="col-md-4 hide-on-print">
						<div class="datepicker">
							<input name="startDate" class="form-control" placeholder="Start Date" required
								value="<?php if(isset ($_POST ['startDate'])){ echo $_POST ['startDate'];} ?>"/>
						</div>
					</div>

					<div class="col-md-4 hide-on-print">
						<div class="datepicker">
							<input name="endDate" class="form-control" placeholder="End Date" required
								value="<?php if(isset ($_POST ['endDate'])){ echo $_POST ['endDate'];} ?>"/>
						</div>
					</div>

					<div class=" col-md-4 hide-on-print">
						<div class="input-group">
							<input type="text" name="search" class="form-control" placeholder="Type here..." id="searchInput">
							<span class="input-group-btn">
								<button class="btn btn-primary" name="submit" type="submit" id="searchBtn">Search</button>
							</span>
						</div>
					</div>
				</form>
			</div>
			<br />

			<div class='panel panel-primary'>
				<div class='panel-heading hide-on-print'>
					<span class='glyphicon glyphicon-user'></span><span class='glyphicon glyphicon-user '></span> VISITORS
				</div>
				<div class='table-responsive'>
					<table class='table table-condensed text-uppercase small'>
						<thead>
							<th class='active'>NAME</th>
							<th class='active'>COMPANY</th>
							<th class='active'>PERSON TO VISIT</th>
							<th class='active'>PURPOSE TO VISIT</th>
							<th class='active'>DEPARTMENT</th>
							<th class='active'>DATE</th>
							<th class='active'>TIME IN</th>
							<th class='active'>TIME OUT</th>
							<th class='active'>PASS</th>
							<th class='active'>ISSUED BY</th>
						</thead>

						<?php
							mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
							mysql_select_db ($database) or die(mysql_error());
							$output = '';

							$startDate = '';
							$endDate = '';

							$queryString = "SELECT *, v.id as pk FROM walkinvisitors w left join visitinfo v
								on w.visitinfoid = v.id ORDER BY v.id desc";

							if(isset ($_POST ['startDate']) && isset ($_POST ['endDate'])){
								$startDate = $_POST ['startDate'];
								$endDate = $_POST ['endDate'];

								$mysqlStartDate = date("Y-m-d", strtotime($startDate));
								$mysqlEndDate = date("Y-m-d", strtotime($endDate));

								$queryString = "SELECT *, v.id as pk FROM walkinvisitors w left join visitinfo v on w.visitinfoid = v.id
									where v.date between '$mysqlStartDate' and '$mysqlEndDate'
									ORDER BY v.id desc";
							}

							$query = mysql_query ($queryString) or die ( mysql_error () );

							$count = mysql_num_rows ( $query );
							if ($count == 0) {
								$output = "There was no search results!";
							} else {
								while ( $row = mysql_fetch_array ( $query ) ) {
									$id = $row ['pk'];
									$fname = $row ['firstname'];
									$lname = $row ['lastname'];
									$add = $row ['address'];
									$dep = $row ['department'];
									$pur = $row ['purpose'];
									$per = $row ['persontovisit'];
									$date = $row ['date'];
									$time = $row ['timein'];
									$timeout = $row ['timeout'];
									$passno = $row ['passno'];
									$issuedby = $row ['issuedby'];

									echo "<tr class='h6'><td>" . $fname . " " . $lname . "</td>
											<td>" . $add . "</td> <td>" . $per . "</td> <td>" . $pur . "</td> <td>" . $dep . "</td>
											<td>" . $date . "</td> <td>" . $time . "</td> <td>" . $timeout . "</td>
											<td>" . $passno . "</td> <td>" . $issuedby . "</td>";
								}
							}
						?>

						<?php
							mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
							mysql_select_db ($database) or die(mysql_error());
							$output = '';

							$queryString = "SELECT *, v.id as pk, v.date as vdate FROM appointments a left join visitinfo v
									on a.visitinfoid = v.id left join users u on a.userid = u.id
									where (a.status = 'APPROVED' or a.status = 'RESCHEDULED')
									and v.timein is not null ORDER BY v.id desc";

							if(isset ($_POST ['startDate']) && isset ($_POST ['endDate'])){
								$startDate = $_POST ['startDate'];
								$endDate = $_POST ['endDate'];

								$mysqlStartDate = date("Y-m-d", strtotime($startDate));
								$mysqlEndDate = date("Y-m-d", strtotime($endDate));

								$queryString = "SELECT *, v.id as pk, v.date as vdate FROM appointments a left join visitinfo v
									on a.visitinfoid = v.id left join users u on a.userid = u.id
									where (a.status = 'APPROVED' or a.status = 'RESCHEDULED')
									and v.timein is not null and v.date between '$mysqlStartDate' and '$mysqlEndDate' ORDER BY v.id desc";
							}

							$query = mysql_query ($queryString) or die ( mysql_error () );

							$count = mysql_num_rows ( $query );
							if ($count == 0) {
								$output = "There was no search results!";
							} else {
								while ( $row = mysql_fetch_array ( $query ) ) {
									$id = $row ['pk'];
									$fname = $row ['fname'];
									$lname = $row ['lname'];
									$add = $row ['address'];
									$dep = $row ['department'];
									$pur = $row ['purpose'];
									$per = $row ['persontovisit'];
									$date = $row ['date'];
									$time = $row ['timein'];
									$timeout = $row ['timeout'];
									$passno = $row ['passno'];
									$issuedby = $row ['issuedby'];

									$actionButton = "";

									if ($timeout == null) {
										$actionButton = "<a href='#' data-toggle='modal' data-target='#timeOutModal'
											data-pk='" . $id . "' data-name='" . $fname . ' ' . $lname . "'>
											<button class='btn btn-danger'><span class='glyphicon glyphicon-off'></span></button></a>";
									}

									echo "<tr class='h6'><td>" . $fname . " " . $lname . "</td>
											<td>" . $add . "</td> <td>" . $per . "</td> <td>" . $pur . "</td> <td>" . $dep . "</td>
											<td>" . $date . "</td> <td>" . $time . "</td> <td>" . $timeout . "</td>
											<td>" . $passno . "</td> <td>" . $issuedby . "</td>";
								}
							}
						?>
					</table>
				</div>
			</div>
			<?php print("$output"); ?>
			<br />
		</div>
	</div>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>

	<script>
      document.getElementById('searchInput').focus();
			$(function() {
				$(".datepicker input").datepicker();
			});
  </script>

</body>
</html>
