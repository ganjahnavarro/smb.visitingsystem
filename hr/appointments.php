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
	<?php $activeNav = 'appointments' ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/hr/navbar.php' ); ?>
	
	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset ($_POST ['appointmentID']) && $_POST ['appointmentID'] != null) {
				mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
				mysql_select_db ($database) or die(mysql_error());
					
				date_default_timezone_set ('Asia/Manila');
				$timein = date ('h:i A');
				
				$id = $_POST ['appointmentID'];
				$status = $_POST ['appointmentStatus'];
				$userName = $_SESSION ['sess_username'];
				
				if($status == 'RESCHEDULED'){
					$datetime = $_POST ['datetime'];
					$pieces = explode(' ', $datetime);
					$rescheddate = strtotime($pieces[0]);
					$mysqldate = date("Y-m-d H:i:s", $rescheddate);
					
					$sql = "UPDATE appointments SET status = '$status', processedBy = '$userName', 
						date = '$mysqldate', time = '$pieces[1]' WHERE ID = '$id'";
				} else {
					$sql = "UPDATE appointments SET status = '$status', processedBy = '$userName', date = requesteddate, time = requestedtime WHERE ID = '$id'";
				}
				
				$res = mysql_query ($sql) or die(mysql_error());
				echo "<meta http-equiv = 'refresh' content = ''0;url=visitors.php'>";
				header ( 'Location: appointments.php' );
			}
		}
	?>
	
	<script>
		$(function() {
			$("#datetime").datetimepicker({
				controlType: 'select',
				stepMinute: 5,
				oneLine: true
			});
		});
	</script>

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

		<ul class="nav nav-tabs" role="tablist">
			<li class="active"><a href="#pending" aria-controls="pending" role="tab" data-toggle="tab"><strong>Pending</strong></a></li>
			<li><a href="#processed" aria-controls="processed" role="tab" data-toggle="tab"><strong>Processed</strong></a></li>
		</ul>

		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="pending">
				<br/>
			
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<span class="glyphicon glyphicon-exclamation-sign"></span>
						APPOINTMENTS
					</div>
					
					<div class='table-responsive'>
						<table class="table table-condensed text-uppercase small sortableTable searchableTable">
							<thead>
								<th class='active'>IMAGE</th>
								<th class='active'>NAME</th>
								<th class='active'>COMPANY</th>
								<th class='active'>PERSON TO VISIT</th>
								<th class='active'>PURPOSE TO VISIT</th>
								<th class='active'>DEPARTMENT</th>
								<th class='active'>DATE</th>
								<th class='active'>TIME</th>
								<th class='active'>ACTION</th>
							</thead>
		
							<?php
								mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
								mysql_select_db ($database) or die(mysql_error());
								$output = '';
							
							$query = mysql_query ( "SELECT *, a.id as pk FROM appointments a left join visitinfo v
									on a.visitinfoid = v.id left join users u on a.userid = u.id
									where a.status = 'PENDING' ORDER BY v.id desc" ) or die ( mysql_error () );
							
							$count = mysql_num_rows ( $query );
							if ($count == 0) {
								$output = "There was no search results!";
							} else {
								while ( $row = mysql_fetch_array ( $query ) ) {
									$id = $row ['pk'];
									$imageFileName = $row ['imageFileName'];
									$imageFileName = empty($imageFileName) ? 'placeholder.png' : $imageFileName; 
									$fname = $row ['fname'];
									$lname = $row ['lname'];
									$add = $row ['address'];
									$dep = $row ['department'];
									$pur = $row ['purpose'];
									$per = $row ['persontovisit'];
									$date = $row ['requesteddate'];
									$time = $row ['requestedtime'];
									
									$actionButtonApprove = "<a href='#' data-toggle='modal' data-target='#appointmentModal'
										data-pk='" . $id . "' data-name='" . $fname . ' ' . $lname . "' data-status='approve'>
										<button class='btn btn-info'><span class='glyphicon glyphicon-ok'></span></button></a>";
									
									$actionButtonResched = "<a href='#' data-toggle='modal' data-target='#appointmentModal'
										data-pk='" . $id . "' data-name='" . $fname . ' ' . $lname . "' data-status='reschedule'>
										<button class='btn btn-warning'><span class='glyphicon glyphicon-time'></span></button></a>";
									
									$actionButtonDisapprove = "<a href='#' data-toggle='modal' data-target='#appointmentModal'
										data-pk='" . $id . "' data-name='" . $fname . ' ' . $lname . "' data-status='disapprove'>
										<button class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span></button></a>";
									
									echo "<tr class='h6'>
										<td> <img src='/uploads/" . $imageFileName . "' class='user-image'> </td>
										<td>" . $fname . " " . $lname . "</td>
										<td>" . $add . "</td> <td>" . $per . "</td> <td>" . $pur . "</td> <td>" . $dep . "</td>
										<td>" . $date . "</td> <td>" . $time . "</td>
										<td>" . $actionButtonApprove . $actionButtonResched . $actionButtonDisapprove . "</td>";
								}
							}
							?>
						</table>
					</div>
				</div>
			</div>
			
			<div role="tabpanel" class="tab-pane" id="processed">
				<br/>
			
				<div class='panel panel-primary'>
					<div class='panel-heading'>
						<span class="glyphicon glyphicon-exclamation-sign"></span>
						APPOINTMENTS
					</div>
					
					<div class='table-responsive'>
						<table class="table table-condensed text-uppercase small sortableTable searchableTable">
							<th class='active'>IMAGE</th>
							<th class='active'>NAME</th>
							<th class='active'>COMPANY</th>
							<th class='active'>PERSON TO VISIT</th>
							<th class='active'>PURPOSE TO VISIT</th>
							<th class='active'>DEPARTMENT</th>
							<th class='active'>DATE</th>
							<th class='active'>TIME</th>
							<th class='active'>STATUS</th>
							<th class='active'>PROCESSED BY</th>
		
							<?php
							mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
							mysql_select_db ($database) or die(mysql_error());
							$output = '';
							
							$query = mysql_query ( "SELECT *, a.id as pk FROM appointments a left join visitinfo v
									on a.visitinfoid = v.id left join users u on a.userid = u.id
									where a.status != 'PENDING' ORDER BY v.id desc" ) or die ( mysql_error () );
							
							$count = mysql_num_rows ( $query );
							if ($count == 0) {
								$output = "There was no search results!";
							} else {
								while ( $row = mysql_fetch_array ( $query ) ) {
									$id = $row ['pk'];
									$imageFileName = $row ['imageFileName'];
									$imageFileName = empty($imageFileName) ? 'placeholder.png' : $imageFileName; 
									$fname = $row ['fname'];
									$lname = $row ['lname'];
									$add = $row ['address'];
									$dep = $row ['department'];
									$pur = $row ['purpose'];
									$per = $row ['persontovisit'];
									$date = $row ['date'];
									$time = $row ['time'];
									$status = $row ['status'];
									$processedby = $row ['processedby'];
									
									echo "<tr class='h6'>
										<td> <img src='/uploads/" . $imageFileName . "' class='user-image'> </td>
										<td>" . $fname . " " . $lname . "</td>
										<td>" . $add . "</td> <td>" . $per . "</td> <td>" . $pur . "</td> <td>" . $dep . "</td>
										<td>" . $date . "</td> <td>" . $time . "</td>
										<td>" . $status . "</td> <td>" . $processedby . "</td>";
								}
							}
							?>
						</table>
					</div>
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
					<h4 class="modal-title">APPOINTMENT PROCESS</h4>
				</div>
				
				<form action="appointments.php" method="POST">
					<input id="appointmentID" type="hidden" name="appointmentID">
					<input id="appointmentStatus" type="hidden" name="appointmentStatus">
					
					<div class="modal-body">
						<p class="text-center text-uppercase">
							Are you sure you want to <span id="appointmentAction"></span> this appointment?
						</p>
						
						<div id="reschedDiv" class="form-group">
							<label for="datetime" class="control-label">Time</label>
							<input id="datetime" class="form-control" name="datetime" required />
						</div>
					</div>
					
					<div class='modal-footer'>
						<button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
						<button type='submit' class='btn btn-primary'>CONFIRM</button>
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
	        	var status = target.data('status');
	
	        	$('#appointmentAction').html(status);
	        	$('#appointmentID').val(pk);

	        	status = status + 'd';
	        	$('#appointmentStatus').val(status.toUpperCase());

	        	if(status == 'rescheduled'){
	        		$('#reschedDiv').show();
	        		$('#reschedDiv').find('input').attr('type', 'text');
	        	} else {
	        		$('#reschedDiv').hide();
	        		$('#reschedDiv').find('input').attr('type', 'hidden');
	        	}
	        })
        });
    </script>
    
	</body>
</html>