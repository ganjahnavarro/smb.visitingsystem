<!DOCTYPE html>
<?php
session_start ();
$role = $_SESSION ['sess_userrole'];
if (! isset ( $_SESSION ['sess_username'] ) || $role != "GUARD") {
	header ( 'Location: /index.php?err=2' );
}
?>
<html>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
<body>
	<?php $activeNav = 'index'?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/guard/navbar.php' ); ?>
	
	<div class="container">
		<div class="row text-left">
			<div class="col-md-12 text-uppercase">
				<h1>
					<span class="glyphicon glyphicon-user"></span><span
						class="glyphicon glyphicon-user"></span> WELCOME <?php echo  $_SESSION['sess_username']; ?></h1>
			</div>
			
			<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/dashboard.php' ); ?>
		</div>
	</div>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>
	</body>
</html>