<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"
					aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title">LOG OUT</h4>
			</div>
			<div class="modal-body">
				<p class="text-center text-uppercase">
					ARE YOU SURE, DO YOU WANT TO LOGOUT <strong><?php echo  $_SESSION['sess_username']; ?>?</strong>
				</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">CANCEL</button>
				<a href="/logout.php">
					<button type="button" class="btn btn-primary">LOG OUT</button></a>
			</div>
		</div>
	</div>
</div>
