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
	<?php $activeNav = 'appointments' ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/guard/navbar.php' ); ?>

	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset ($_POST ['visitInfoID']) && $_POST ['visitInfoID'] != null) {
				mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
				mysql_select_db ($database) or die(mysql_error());

				$timein = date ('h:i A');

				$id = $_POST ['visitInfoID'];
				$passNo = $_POST ['passNo'];
				$userName = $_SESSION ['sess_username'];

				$sql = "UPDATE visitinfo SET date = current_date, timein = '$timein', passNo = '$passNo', issuedby = '$userName' WHERE ID = '$id'";
				$res = mysql_query ($sql) or die(mysql_error());
				echo "<meta http-equiv = 'refresh' content = ''0;url=visitors.php'>";
				header ( 'Location: appointments.php' );
			}
		}
	?>

	<div class="container">
		<div class="row text-left">
			<div class="col-md-12">
				<h1>
					<span class="glyphicon glyphicon-exclamation-sign"></span> APPOINTMENTS
				</h1>
			</div>
		</div>
		<br />

		<div class="row">
			<div class="col-md-offset-8 col-md-4">
				<div class="input-group">
					<input type="text" name="search" class="form-control" placeholder="Type here..." id="searchInput">
					<span class="input-group-btn">
						<button class="btn btn-primary" name="submit" type="submit" id="btnClick">Search</button>
					</span>
				</div>
			</div>
		</div>
		<br />

		<div class='panel panel-primary'>
			<div class='panel-heading'>
				<span class="glyphicon glyphicon-exclamation-sign"></span>
				APPOINTMENTS
			</div>

			<div class='table-responsive'>
				<table class="table table-condensed text-uppercase small sortableTable searchableTable">
					<thead>
						<th class='active'>NAME</th>
						<th class='active'>COMPANY</th>
						<th class='active'>PERSON TO VISIT</th>
						<th class='active'>PURPOSE TO VISIT</th>
						<th class='active'>DEPARTMENT</th>
						<th class='active'>DATE</th>
						<th class='active'>TIME</th>
						<th class='active'>REFERENCE NO</th>
						<th class='active'>PROCESSED BY</th>
						<th class='active' width="40px">ACTION</th>
					</thead>

					<?php
					mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
					mysql_select_db ($database) or die(mysql_error());
					$output = '';

					$query = mysql_query ( "SELECT *, v.id as pk, a.id as refno, a.date as appointmentdate, a.time as appointmenttime
							FROM appointments a left join visitinfo v
								on a.visitinfoid = v.id left join users u on a.userid = u.id
								where (a.status = 'APPROVED' or a.status = 'RESCHEDULED') and v.timein is null ORDER BY v.id desc" ) or die ( mysql_error () );

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
							$date = $row ['appointmentdate'];
							$time = $row ['appointmenttime'];
							$referenceno = $row ['refno'];
							$processedby = $row ['processedby'];

							$actionButton = "<a href='#' data-toggle='modal' data-target='#appointmentModal'
								data-pk='" . $id . "' data-name='" . $fname . ' ' . $lname . "'>
								<button class='btn btn-info'><span class='glyphicon glyphicon-time'></span></button></a>";

							echo "<tr class='h6'><td>" . $fname . " " . $lname . "</td>
								<td>" . $add . "</td> <td>" . $per . "</td> <td>" . $pur . "</td> <td>" . $dep . "</td>
								<td>" . $date . "</td> <td>" . $time . "</td>
								<td>" . $referenceno . "</td> <td>" . $processedby . "</td> <td>" . $actionButton . "</td>";
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

	<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">APPOINTMENT TIME-IN</h4>
				</div>

				<form action="appointments.php" method="POST">
					<input id="visitInfoID" type="hidden" name="visitInfoID">

					<div class="modal-body">
						<div class="form-group">
							<p class="text-center text-uppercase">
								Please input pass no. for <strong id="appointmentName"></strong>
							</p>
							<div>
								<input type="text" class="form-control" name='passNo' required
									 pattern="[A-Za-z0-9]+" title="Letters and numbers only.">
							</div>
						</div>
					</div>

					<div class='modal-footer'>
						<button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
						<button type='submit' class='btn btn-primary'>TIME-IN</button>
					</div>
				</form>
			</div>
		</div>
	</div>

    <?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>

    <script>
        document.getElementById('searchInput').focus();

        $(document).ready(function() {
	        $(window).on('show.bs.modal', function (event) {
	        	var target = $(event.relatedTarget);
	        	var name = target.data('name');
	        	var pk = target.data('pk');

	        	$('#appointmentName').html(name);
	        	$('#visitInfoID').val(pk);
	        })
        });
    </script>

	</body>
</html>
