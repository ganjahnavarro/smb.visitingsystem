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
	<?php $activeNav = 'users'; $activeSubNav = 'userlist'; ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/admin/navbar.php' ); ?>

	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset ($_POST ['userID']) && $_POST ['userID'] != null) {
				mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
				mysql_select_db ($database) or die(mysql_error());

				$id = $_POST ['userID'];
				$sql = "UPDATE users SET active = !active WHERE ID = '$id'";
				$res = mysql_query ($sql) or die(mysql_error());
				echo "<meta http-equiv = 'refresh' content = ''0;url=users.php'>";
			}
		}
	?>

	<div class="container">
		<div class="row text-left">
			<div class="col-md-12 hide-on-print">
				<h1>
					<span class="glyphicon glyphicon-user"></span> USERS
				</h1>
			</div>
			<br />
		</div>

		<div class="row hide-on-print">
			<div class="col-md-4">
				<button class="btn btn-info" onclick="window.print();">Print</button>
			</div>

			<div class="col-md-offset-4 col-md-4">
				<div class="input-group">
					<input type="text" name="search" class="form-control" placeholder="Type here" id="searchInput">
					<span class="input-group-btn">
						<button class="btn btn-primary" name="submit" type="submit" id="btnClick">Search</button>
					</span>
				</div>
			</div>
		</div>
		<br />

		<div class='panel panel-primary'>
			<div class='panel-heading hide-on-print'>
				<span class="glyphicon glyphicon-user"></span> USERS
			</div>

			<div class='table-responsive'>
				<table class="table table-condensed text-uppercase small sortableTable searchableTable">
					<thead>
						<th class='active'>IMAGE</th>
						<th class='active'>USERNAME</th>
						<th class='active'>ACTIVE</th>
	                    <th class='active'>TYPE</th>
	                    <th class='active'>NAME</th>
	                    <th class='active'>GENDER</th>
	                    <th class='active'>AGE</th>
	                    <th class='active'>BIRTHDAY</th>
	                    <th class='active'>ADDRESS</th>
	                    <th class='active'>CONTACT NO</th>
	                    <th class='active'>DATE ADDED</th>
						<th class='active hide-on-print' width="120px">ACTION</th>
					</thead>

					<?php
					mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
					mysql_select_db ($database) or die(mysql_error());
					$output = '';

					$query = mysql_query ("SELECT * FROM users ORDER BY type") or die ( mysql_error () );

					$count = mysql_num_rows ( $query );
					if ($count == 0) {
						$output = "There was no search results!";
					} else {
						while ( $row = mysql_fetch_array ( $query ) ) {
							$id = $row ['id'];
							$username = $row ['username'];
							$active = $row ['active'];
							$type = $row ['type'];
							$fname = $row ['fname'];
							$mname = $row ['mname'];
							$lname = $row ['lname'];
							$gender = $row ['gender'];
							$age = $row ['age'];
							$bday = $row ['bday'];
							$add = $row ['address'];
							$contact = $row ['contact'];
							$date = $row ['date'];
							$time = $row ['time'];
							$imageFileName = $row ['imageFileName'];
							$imageFileName = empty($imageFileName) ? 'placeholder.png' : $imageFileName; 

							$actionButton = "";

							$active = $active ? 'true' : 'false';

							$actionButtonChangeStatus = "<a href='#' data-toggle='modal' data-target='#changeStatusModal'
								data-pk='" . $id . "' data-name='" . $fname . ' ' . $lname . "'>
								<button class='btn btn-danger'><span class='glyphicon glyphicon-off'></span></button></a>";

							$actionButtonEdit = "<a href='adduser.php?id=$id'>
								<button class='btn btn-info'><span class='glyphicon glyphicon-pencil'></span></button></a>";
								
							echo "<tr class='h6'>
									<td> <img src='/uploads/" . $imageFileName . "' class='user-image'> </td>
									<td>" . $username . "</td> <td>" . $active . "</td> <td>" . $type . "</td>
									<td>" . $fname . " " . $mname . " " . $lname . "</td>
									<td>" . $gender . "</td> <td>" . $age . "</td> <td>" . $bday . "</td> <td>" . $add . "</td>
									<td>" . $contact . "</td> <td> <p title='$time'> " . $date . " </p> </td>
									<td class='hide-on-print'>" . $actionButtonEdit . $actionButtonChangeStatus . "</td>";
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

	<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"
						aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">CHANGE STATUS</h4>
				</div>

				<form action="users.php" method="POST">
					<input id="userID" type="hidden" name="userID">

					<div class="modal-body">
						<div class="form-group">
							<p class="text-center text-uppercase">
								Are you sure you want to change status of <strong id="changeStatusName"></strong>?
							</p>
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

	        	$('#changeStatusName').html(name);
	        	$('#userID').val(pk);
	        })
        });
    </script>

	</body>
</html>
