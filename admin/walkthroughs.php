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
	<?php $activeNav = 'walkthroughs'; $activeSubNav = 'walkthroughlist'; ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/admin/navbar.php' ); ?>

	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset ($_POST ['walkthroughID']) && $_POST ['walkthroughID'] != null) {
				mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
				mysql_select_db ($database) or die(mysql_error());

				$id = $_POST ['walkthroughID'];
				$walkthroughName = $_POST ['walkthroughName'];

				$sql = "UPDATE walkthroughs SET active = !active WHERE ID = '$id'";
				$res = mysql_query ($sql) or die(mysql_error());
				echo "<meta http-equiv = 'refresh' content = ''0;url=walkthroughs.php'>";
			}
		}
	?>

	<div class="container">
		<div class="row text-left">
			<div class="col-md-12">
				<h1>
					<span class="glyphicon glyphicon-exclamation-sign"></span> WALKTHROUGHS
				</h1>
			</div>
		</div>
		<br />

		<?php
			mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
			mysql_select_db ($database) or die(mysql_error());
			$output = '';

			$query = mysql_query ("SELECT * from walkthroughs ORDER BY id desc") or die (mysql_error ());

			$count = mysql_num_rows ( $query );
			if ($count == 0) {
				$output = "There was no search results!";
			} else {
				while ( $row = mysql_fetch_array ( $query ) ) {
					$id = $row ['id'];
					$active = $row ['active'];
					$name = $row ['name'];
					$description = $row ['description'];
					$link = $row ['link'];
					$department = $row ['department'];

					$actionButton = "";

					$actionButtonChangeStatus = "<a href='#' data-toggle='modal' data-target='#changeStatusModal'
						data-pk='" . $id . "' data-name='" . $name . "'>
						<button class='btn btn-danger'><span class='glyphicon glyphicon-off'></span></button></a>";

					$actionButtonEdit = "<a href='addwalkthrough.php?id=$id'>
						<button class='btn btn-info'><span class='glyphicon glyphicon-pencil'></span></button></a>";

					if($active == false){
						$name = $name . ' (inactive)';
					}

					echo "<div class='well'>
							<h4>" . $name . "</h4>
							<iframe width='100%' height='440' src='" . $link . "' frameborder='0' allowfullscreen></iframe>
							<div class='pull-right'>" . $actionButtonEdit . $actionButtonChangeStatus . "</div>
							<p class='help-block'>Description: " . $description . "</p>
							<p class='help-block'>Department: " . $department . "</p>
						</div>";
				}
			}
		?>

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

				<form action="walkthroughs.php" method="POST">
					<input id="walkthroughID" type="hidden" name="walkthroughID">
					<input id="walkthroughName" type="hidden" name="walkthroughName">

					<div class="modal-body">
						<div class="form-group">
							<p class="text-center text-uppercase">
								Are you sure you want to change status of <strong id="changeStatusName"></strong> walkthrough?
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
        $(document).ready(function() {
	        $(window).on('show.bs.modal', function (event) {
	        	var target = $(event.relatedTarget);
	        	var name = target.data('name');
	        	var pk = target.data('pk');

	        	$('#changeStatusName').html(name);
	        	$('#walkthroughName').html(name);
	        	$('#walkthroughID').val(pk);
	        })
        });
    </script>

	</body>
</html>
