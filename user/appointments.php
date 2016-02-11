<div class="modal fade" id="appointmentsModal" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<h2>MY APPOINTMENTS</h2>
				<br/>

				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<span class="glyphicon glyphicon-exclamation-sign"></span>
						APPOINTMENTS
					</div>

					<div class='table-responsive'>
						<table class='table table-condensed text-uppercase small sortableTable'>
							<thead>
								<th class='active'>DEPARTMENT</th>
								<th class='active'>PURPOSE</th>
								<th class='active'>PERSON TO VISIT</th>
								<th class='active'>DATE</th>
								<th class='active'>TIME</th>
								<th class='active'>REF NO</th>
								<th class='active'>STATUS</th>
								<th class='active' width="40px">ACTION</th>
							</thead>

							<?php
								mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
								mysql_select_db ($database) or die(mysql_error());
								$output = '';
								$userId = $_SESSION ['sess_user_id'];

								$query = mysql_query ( "SELECT *, a.id as pk, a.id as refno, v.timein as actualin,
										coalesce(a.date, a.requesteddate) as appointmentdate, coalesce(a.time, a.requestedtime) as appointmenttime
										FROM appointments a left join visitinfo v
											on a.visitinfoid = v.id left join users u on a.userid = u.id
											where u.id = '$userId' ORDER BY v.id desc" ) or die ( mysql_error () );

								$count = mysql_num_rows ( $query );
								if ($count == 0) {
									$output = "There was no search results!";
								} else {
									while ( $row = mysql_fetch_array ( $query ) ) {
										$id = $row ['pk'];
										$dep = $row ['department'];
										$pur = $row ['purpose'];
										$per = $row ['persontovisit'];
										$date = $row ['appointmentdate'];
										$time = $row ['appointmenttime'];
										$referenceno = $row ['refno'];
										$status = $row ['status'];
										$actualin = $row ['actualin'];

										$actionButton = "";

										if($status == "PENDING" || ($status == "RESCHEDULED" && $actualin == null)) {
											$actionButton = "<a href='#' data-toggle='modal' data-target='#cancelAppointmentModal' data-pk='" . $id . "'>
												<button class='btn btn-info'><span class='glyphicon glyphicon-time'></span></button></a>";
										}

										echo "<tr class='h6'><td>" . $dep . "</td> <td>" . $pur . "</td> <td>" . $per . "</td>
											<td>" . $date . "</td> <td>" . $time . "</td> <td>" . $referenceno . "</td>
											<td>" . $status . "</td> <td>" . $actionButton . "</td>";
									}
								}
								?>
						</table>
					</div>
				</div>
				<?php print("$output"); ?>
				<br />

				<div class="clearfix"></div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="cancelAppointmentModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">CANCEL APPOINTMENT</h4>
			</div>

			<form action="index.php" method="POST">
				<input id="appointmentId" name="appointmentId" type="hidden">

				<div class="modal-body">
					<p class="text-center text-uppercase">
						ARE YOU SURE DO YOU WANT TO CANCEL THIS APPOINTMENT?
					</p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">CLOSE</button>
					<button type="submit" class="btn btn-primary" name="cancelAppointment">CONFIRM</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$(window).on('show.bs.modal', function (event) {
			var target = $(event.relatedTarget);
			var pk = target.data('pk');

			$('#appointmentId').val(pk);
		})
	});
</script>
