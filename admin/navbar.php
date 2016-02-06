<nav class="navbar navbar-default navbar-fixed-top small hide-on-print">
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
				<li <?php if($activeNav != null && $activeNav == 'users') {echo 'class="active"';} ?>>
					<a class="dropdown-toggle"
						data-toggle="dropdown" role="button" aria-haspopup="true"
						aria-expanded="false" href="#"><span
							class="glyphicon glyphicon-user"></span> MANAGE USERS
							<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li <?php if($activeSubNav != null && $activeSubNav == 'userlist') {echo 'class="active"';} ?>>
							<a href="users.php">
								<span class="glyphicon glyphicon-user"></span> USERS
							</a>
						</li>
						<li <?php if($activeSubNav != null && $activeSubNav == 'useradd') {echo 'class="active"';} ?>>
							<a href="adduser.php">
								<span class="glyphicon glyphicon-plus-sign"></span>
								<span class="glyphicon glyphicon-user"></span> ADD USER
							</a>
						</li>
					</ul>
				</li>

				<li <?php if($activeNav != null && $activeNav == 'walkthroughs') {echo 'class="active"';} ?>>
					<a class="dropdown-toggle"
						data-toggle="dropdown" role="button" aria-haspopup="true"
						aria-expanded="false" href="#">
						<span class="glyphicon glyphicon-facetime-video"></span> MANAGE WALKTHROUGHS
						<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li <?php if($activeSubNav != null && $activeSubNav == 'walkthroughlist') {echo 'class="active"';} ?>>
							<a href="walkthroughs.php">
							<span class="glyphicon glyphicon-facetime-video"></span> WALKTHROUGHS</a></li>
						<li <?php if($activeSubNav != null && $activeSubNav == 'walkthroughadd') {echo 'class="active"';} ?>>
							<a href="addwalkthrough.php">
								<span class="glyphicon glyphicon-plus-sign"></span>
								<span class="glyphicon glyphicon-facetime-video"></span> ADD
								WALKTHROUGH
							</a>
						</li>
					</ul>
				</li>

				<li <?php if($activeNav != null && $activeNav == 'faqs') {echo 'class="active"';} ?>>
					<a class="dropdown-toggle"
						data-toggle="dropdown" role="button" aria-haspopup="true"
						aria-expanded="false" href="#">
						<span class="glyphicon glyphicon-question-sign"></span> MANAGE FAQs
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu">
						<li <?php if($activeSubNav != null && $activeSubNav == 'faqlist') {echo 'class="active"';} ?>>
							<a href="faqs.php">
								<span class="glyphicon glyphicon-question-sign"></span> FAQS
							</a>
						</li>
						<li <?php if($activeSubNav != null && $activeSubNav == 'faqadd') {echo 'class="active"';} ?>>
							<a href="addfaq.php">
								<span class="glyphicon glyphicon-plus-sign"></span>
								<span class="glyphicon glyphicon-question-sign"></span> ADD FAQs
							</a>
						</li>
					</ul>
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

<br /> <br />
<br /> <br />
