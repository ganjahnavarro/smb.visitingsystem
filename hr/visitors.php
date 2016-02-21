<!DOCTYPE html>
<?php
	session_start ();
	$role = $_SESSION ['sess_userrole'];
	if (! isset ( $_SESSION ['sess_username'] ) || $role != "HR") {
		header ( 'Location: /index.php?err=2' );
	}
	date_default_timezone_set ( 'Asia/Manila' );
?>
<html>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
<body>
	<?php $activeNav = 'visitors' ?>
	<?php
		include( $_SERVER['DOCUMENT_ROOT'] . '/hr/navbar.php' );
		
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST ['startDate']) && isset ($_POST ['endDate'])){
			$startDate = $_POST ['startDate'];
			$endDate = $_POST ['endDate'];
		} else {
			$startDate = date("m/d/Y");
			$endDate = date("m/d/Y");
		}
	?>

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
							<input id="startDate" name="startDate" class="form-control" placeholder="Start Date" required
								value="<?php echo $startDate; ?>"/>
						</div>
					</div>

					<div class="col-md-4 hide-on-print">
						<div class="datepicker">
							<input id="endDate" name="endDate" class="form-control" placeholder="End Date" required
								value="<?php echo $endDate; ?>"/>
						</div>
					</div>

					<div class=" col-md-4 hide-on-print">
						<div class="input-group">
							<input type="text" name="search" class="form-control" placeholder="Type here..." id="searchInput">
							<span class="input-group-btn">
								<button class="btn btn-primary">Search</button>
							</span>
						</div>
					</div>
				</form>
			</div>
			<br />

			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#walkins" aria-controls="walkins" role="tab" data-toggle="tab"><strong>Walkin Visitors</strong></a></li>
				<li><a href="#appointments" aria-controls="appointments" role="tab" data-toggle="tab"><strong>Appointment Visitors</strong></a></li>
				<li><a href="#all" aria-controls="all" role="tab" data-toggle="tab"><strong>All</strong></a></li>
			</ul>

			<div class="tab-content">
				<div role="tabpanel" class="tab-pane active" id="walkins">
					<br/>
					<?php
						$tab = 'WALKINS';
						include( $_SERVER['DOCUMENT_ROOT'] . '/hr/visitorsplugin.php' );
					?>
				</div>
			
				<div role="tabpanel" class="tab-pane" id="appointments">
					<br/>
					<?php
						$tab = 'APPOINTMENTS';
						include( $_SERVER['DOCUMENT_ROOT'] . '/hr/visitorsplugin.php' );
					?>
				</div>
				
				<div role="tabpanel" class="tab-pane" id="all">
					<br/>
					<?php
						$tab = 'ALL';
						include( $_SERVER['DOCUMENT_ROOT'] . '/hr/visitorsplugin.php' );
					?>
				</div>
			</div>
		</div>
	</div>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/footer.php' ); ?>

	<script>
		document.getElementById('searchInput').focus();
      
      	$(function() {
      		$(".datepicker input").datepicker({
         		onSelect: function(dateText) {
                  	if($("#startDate").val() != null && $("#endDate").val() != null){
                    	$("#searchForm").submit();   
            		}
          		}
          	});
		});
	</script>

</body>
</html>
