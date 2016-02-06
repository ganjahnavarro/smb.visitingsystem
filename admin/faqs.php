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
	<?php $activeNav = 'faqs'; $activeSubNav = 'faqlist'; ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/admin/navbar.php' ); ?>

	<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset ($_POST ['faqID']) && $_POST ['faqID'] != null) {
				mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
				mysql_select_db ($database) or die(mysql_error());

				$id = $_POST ['faqID'];
				$sql = "DELETE FROM faqs WHERE ID = '$id'";

				$res = mysql_query ($sql) or die(mysql_error());
				echo "<meta http-equiv = 'refresh' content = ''0;url=faqs.php'>";
			}
		}
	?>

	<div class="container">
		<div class="row text-left">
			<div class="col-md-12">
				<h1>
					<span class="glyphicon glyphicon-question-sign"></span> FAQs
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
				<span class="glyphicon glyphicon-question-sign"></span> FAQs
			</div>

			<div class='table-responsive'>
				<table class="table table-condensed small sortableTable searchableTable">
					<thead class="text-uppercase">
						<th class='active'>QUESTION</th>
						<th class='active'>ANSWER</th>
						<th class='active'>DATE</th>
						<th class='active'>TYPE</th>
						<th class='active' width="120px">ACTION</th>
					</thead>

					<?php
						mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
						mysql_select_db ($database) or die(mysql_error());
						$output = '';

						$query = mysql_query ( "SELECT * FROM faqs ORDER BY type" ) or die ( mysql_error () );

						$count = mysql_num_rows ( $query );
						if ($count == 0) {
							$output = "There was no search results!";
						} else {
							while ( $row = mysql_fetch_array ( $query ) ) {
								$id = $row ['id'];
								$question = $row ['question'];
								$answer = $row ['answer'];
								$date = $row ['date'];
								$type = $row ['type'];

								$actionButton = "";

								$actionButtonChangeStatus = "<a href='#' data-toggle='modal' data-target='#changeStatusModal'
									data-pk='" . $id . "'><button class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span></button></a>";

								$actionButtonEdit = "<a href='addfaq.php?id=$id'>
									<button class='btn btn-info'><span class='glyphicon glyphicon-pencil'></span></button></a>";

								echo "<tr class='h6'>
									<td>" . $question . "</td> <td>" . $answer . "</td> <td>" . $date . "</td> <td>" . $type . "</td>
									<td>" . $actionButtonEdit . $actionButtonChangeStatus . "</td>";
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
					<h4 class="modal-title">DELETE</h4>
				</div>

				<form action="faqs.php" method="POST">
					<input id="faqID" type="hidden" name="faqID">

					<div class="modal-body">
						<div class="form-group">
							<p class="text-center text-uppercase">
								Are you sure you want to delete this record?
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
	        	var pk = target.data('pk');

	        	$('#faqID').val(pk);
	        })
        });
    </script>

	</body>
</html>
