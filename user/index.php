<!DOCTYPE html>
<?php
	session_start ();
	$role = $_SESSION ['sess_userrole'];
	if (! isset ( $_SESSION ['sess_username'] ) || $role != "DEFAULT") {
		header ( 'Location: /index.php?err=2' );
	}
?>
<html>
<link href="/resources/css/lobby.css" rel="stylesheet">
<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>

<script src="/resources/js/jquery.maphilight.min.js"></script>
<script src="/resources/js/jquery.rwdImageMaps.min.js"></script>
<script src="/resources/js/app.js"></script>

<body>
	<?php
		if (isset ( $_POST ['appointmentId'] ) && isset ( $_POST ['cancelAppointment'] )){
			mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
			mysql_select_db ($database) or die(mysql_error());

			$id = $_POST ['appointmentId'];
			$sql = "UPDATE appointments SET status = 'CANCELLED' WHERE ID = '$id'";
			$res = mysql_query ($sql) or die(mysql_error());
			header ('Location: index.php');
		} else if (isset ( $_POST ['submit'] )) {
			$submit = $_POST ['submit'];
			$department = strip_tags ( $_POST ['department'] );
			$purpose = strip_tags ( $_POST ['purpose'] );
			$person = strip_tags ( $_POST ['person'] );

		    if ($department && $purpose && $person) {
		    	$datetime = $_POST ['datetime'];
		    	$pieces = explode(' ', $datetime);
		    	$rescheddate = strtotime($pieces[0]);
		    	$mysqldate = date("Y-m-d H:i:s", $rescheddate);
		    	$userId = $_SESSION ['sess_user_id'];

				$connect = mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
				mysql_select_db ($database) or die(mysql_error());

				$highest_id = mysql_result(mysql_query("SELECT coalesce(MAX(id), 0) + 1 FROM visitinfo"), 0) or die(mysql_error());

				$queryvisitinfo = mysql_query("INSERT INTO visitinfo(id, department, purpose, persontovisit)
						VALUES ('$highest_id', '$department', '$purpose', '$person')") or die(mysql_error());

				$querywalkin = mysql_query("INSERT INTO appointments(requesteddate, requestedtime, status, userid, visitinfoid)
						VALUES ('$mysqldate', '$pieces[1]', 'PENDING', '$userId', '$highest_id')") or die(mysql_error());
		    }
				header ('Location: index.php');
		}
	?>

	<div id="infopanel" class="overlaypanel">
		<p>Welcome to San Miguel Brewery Virtual Lobby.</p>
	</div>

	<div id="logoutpanel" class="overlaypanel">
		<a href="#" data-toggle="modal" data-target="#logoutModal">
			<span class="glyphicon glyphicon-off"></span>
		</a>
	</div>

	<div id="pancontainer">
		<div>
			<img id="smblobby" class="panzoom" src="/resources/images/guard.png" usemap="#npcs" alt="SMB">

			<map id="npcs" class="panzoom" name="npcs">
				<area alt="Guard" title="Guard" href="#" data-toggle="modal" data-target="#guardModal"
					shape="poly" coords="2091,346,2090,366,2091,381,2094,388,2095,401,2068,417,2051,466,2050,474,2053,477,2045,504,2046,549,2042,575,2047,590,2060,594,2070,591,2070,600,2074,658,2074,704,2077,735,2062,764,2085,771,2103,758,2103,754,2110,749,2111,734,2116,719,2111,704,2115,681,2118,611,2126,647,2128,663,2131,673,2131,688,2133,695,2134,717,2137,725,2135,737,2140,746,2134,771,2136,780,2152,781,2170,773,2169,746,2174,727,2174,675,2168,656,2169,619,2176,619,2176,599,2186,595,2193,580,2193,505,2186,472,2190,469,2180,427,2164,407,2140,398,2135,392,2135,383,2140,372,2138,357,2125,334,2104,334" />
				<area alt="PRODUCTS AND SERVICES" title="PAS" href="#" data-toggle="modal" data-target="#PASModal"
					shape="poly" coords="1625,669,1665,665,1706,657,1738,651,1773,643,1798,637,1829,629,1828,607,1826,582,1825,557,1824,525,1822,482,1820,470,1810,458,1784,448,1772,440,1760,417,1744,392,1738,360,1724,346,1693,348,1690,370,1687,388,1677,410,1662,434,1654,451,1619,481,1607,495,1608,522,1610,556,1613,599,1614,649,1623,670" />
				<area alt="WALKTHROUGH" title="PAS" href="#" data-toggle="modal" data-target="#WALKTHROUGHModal"
					shape="poly" coords="452, 526, 465, 505, 493, 428, 514, 412, 530, 394, 537, 371, 540, 339, 533, 311, 512, 280, 486, 266, 455, 261, 423, 265, 398, 279, 380, 294, 368, 322, 362, 350, 369, 379, 384, 404, 407, 424, 415, 431, 439, 513, 452, 526" />
			
			</map>			
		</div>
	</div>

	<div class="modal fade" id="guardModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					<p class="text-uppercase">
						Good day. What can i do to help you?
					</p>

					<div class="col-xs-12 action-item">
						<?php
							$connect = mysql_connect ($dbhost, $dbuser, $dbpass) or die(mysql_error());
							mysql_select_db ($database) or die(mysql_error());

							$userId = $_SESSION ['sess_user_id'];

							try {
								$pendingappointments = mysql_result(mysql_query("SELECT coalesce(count(*), 0) FROM appointments a
										left join visitinfo v on a.visitinfoid = v.id where a.userid = '$userId'
										and (status = 'PENDING' or ((status = 'APPROVED' or status = 'RESCHEDULED') and v.timein is null))"), 0);
							} catch(Exception $e) {
								$pendingappointments = 0;
							}
						?>

						<a href="#" data-toggle="modal" data-target="#addAppointmentModal">
							<button type="button" class="btn btn-info" <?php if($pendingappointments > 0){ echo 'disabled';} ?>>SET AN APPOINTMENT</button>
						</a>

						<?php if($pendingappointments > 0){ echo '<p class="help-block">You cannot set an appointment if you have still have a pending one.</p>';} ?>
					</div>

					<div class="col-xs-12 action-item">
						<a href="#" data-toggle="modal" data-target="#appointmentsModal">
							<button type="button" class="btn btn-info">VIEW MY APPOINTMENTS</button>
						</a>
					</div>
					
					<div class="col-xs-12 action-item">
						<a href="#" data-toggle="modal" data-target="#faqsModal">
							<button type="button" class="btn btn-info">VIEW FAQs</button>
						</a>
					</div>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="PASModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					<div class="col-xs-12 action-item">
						<a href="http://www.sanmiguel.com.ph/business.html" target="_blank">
							<button type="button" class="btn btn-info">VIEW SMB PRODUCTS AND SERVICES</button>
						</a>
					</div>

					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="WALKTHROUGHModal" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>

					<p class="text-uppercase">
						This will guide the visitors to their destination building within the San Miguel Brewery.
					</p>

					<div class="col-xs-12 action-item">
						<a href="#" data-toggle="modal" data-target="#walkthroughsModal">
							<button type="button" class="btn btn-info">VIEW WALKTHROUGHS</button>
						</a>
					</div>
								
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/user/appointments.php' ); ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/user/addappointment.php' ); ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/user/walkthroughs.php' ); ?>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/user/faqs.php' ); ?>

	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/logoutmodal.php' ); ?>

	<script>
		$( document ).ready(function() {
			$('img[usemap]').rwdImageMaps();

			$(function () {
				scrollTo(($(document).width() - $(window).width()) / 2, 0);
			});
		});

		$(function() {
			$("#datetime").datetimepicker({
				controlType: 'select',
				stepMinute: 5,
				oneLine: true
			});
		});

		localStorage.setItem("retryCount", 0);
		init();
	</script>
</body>
</html>
