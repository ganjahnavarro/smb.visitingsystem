<nav class="navbar navbar-default navbar-fixed-top small">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed"
				data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"
				aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">
			<strong><img src="/resources/images/logo.png" class="img-responsive"></strong></a>
		</div>

		<div class="navbar-collapse collapse"
			id="bs-example-navbar-collapse-1" aria-expanded="false"
			style="height: 1px;">
			<ul class="nav navbar-nav navbar-right">
				<li <?php if($activeNav != null && $activeNav == 'visitors') {echo 'class="active"';} ?>>
					<a href="visitors.php">
						<span class="glyphicon glyphicon-user"></span>
						<span class="glyphicon glyphicon-user"></span> VISITORS
					</a>
				</li>
				
				<li <?php if($activeNav != null && $activeNav == 'register') {echo 'class="active"';} ?>>
					<a href="registervisitor.php">
						<span class="glyphicon glyphicon-edit"></span>
						<span class="glyphicon glyphicon-user"></span> REGISTER VISITOR
					</a>
				</li>
				
				<li <?php if($activeNav != null && $activeNav == 'appointments') {echo 'class="active"';} ?>>
					<a href="appointments.php">
						<span class="glyphicon glyphicon-exclamation-sign"></span> APPOINTMENTS
					</a>
				</li>
				
				<li <?php if($activeNav != null && $activeNav == 'faqs') {echo 'class="active"';} ?>>
					<a href="faqs.php">
						<span class="glyphicon glyphicon-question-sign"></span> FAQs
					</a>
				</li>
				
				<li class="dropdown">
					<a class="dropdown-toggle text-uppercase"
						data-toggle="dropdown" role="button" aria-haspopup="true"
						aria-expanded="false" href="#"><?php echo  $_SESSION['sess_username']; ?>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="#" data-toggle="modal" data-target="#logoutModal">
								<span class="glyphicon glyphicon-off"></span> LOG OUT
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<br /><br />
<br /><br />