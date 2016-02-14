<!DOCTYPE html>
<html>
<head>
	<?php include( $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php' ); ?>
</head>
<body class="bg-primary">
	<br /> <br /> <br />
	
	<div class="col-md-6 col-md-offset-3">
		<img src="/resources/images/logo.png" class="img-responsive center-block" alt="Responsive image"> <br /> <br />
	</div>

	<form action="authenticate.php" method="POST" role="form">
		<div class="col-md-6 col-md-offset-3">
			<p class="loginp">
				<b>USERNAME</b>
			</p>
			<input id="username" class="form-control input-lg logininput" type="text" placeholder="Username" name="username">
		</div>


		<div class="col-md-6 col-md-offset-3">
			<p></p>
			<p class="loginp">
				<b>PASSWORD</b>
			</p>
			<input class="form-control input-lg logininput" type="password" placeholder="Password" name="password">
			<br/>
		</div>

		<div class="form-group col-md-6 col-md-offset-3">
			<button type="submit" class="btn btn-info btn-block btn-lg logininput">
				<span class="glyphicon glyphicon-off"></span> LOGIN
			</button>
			<br />
			<p class="text-center"><a href="register.php"><b>CLICK HERE TO REGISTER</b></a></p>
			<p class="text-center"><a href="resetsetup.php"><b>FORGOT PASSWORD?</b></a></p>
		</div>
		
		<div class="form-group col-md-6 col-md-offset-3">
			<p id="retryTimeRemaining"></p>
		</div>
	</form>
     <?php 
     	$errors = array (
			1 => "Invalid user name or password, Try again",
			2 => "Please login to access this area" 
		);
					
		$error_id = isset ( $_GET ['err'] ) ? ( int ) $_GET ['err'] : 0;
					
		if ($error_id == 1) {
			echo '<div class="form-group col-md-6 col-md-offset-3"><div class="alert alert-danger">
					<p><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> ' . $errors [$error_id] . '</p>
				</div></div>';
			
			echo '<script>
					var retryCount = parseInt(localStorage.getItem("retryCount"));
			        retryCount = isNaN(retryCount) ? 1 : retryCount + 1;
			        localStorage.setItem("retryCount", retryCount);
				</script>';
		} elseif ($error_id == 2) {
			echo '<div class="form-group col-md-6 col-md-offset-3 alert alert-danger">
					<p><span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span> ' . $errors [$error_id] . '</p>
				</div>';
		}
	?>  

	<script>
		var retryCount = parseInt(localStorage.getItem("retryCount"));
	    retryCount = isNaN(retryCount) ? 0 : retryCount;

	    if(retryCount >= 5){
	    	window.setInterval(function(){
	    		if(retryCount >= 5){
	    			var timeRemaining = parseInt(localStorage.getItem("timeRemaining"));
		    		timeRemaining = isNaN(timeRemaining) ? 300 : timeRemaining;

		    		if(timeRemaining > 1){
		    			$(".logininput").attr("disabled", true);
			    		
		    			timeRemaining = timeRemaining - 1;
			    		localStorage.setItem("timeRemaining", timeRemaining)
				    	$('#retryTimeRemaining').html("You have incorrectly typed your username/password more than 4 times. Please wait " + timeRemaining + " seconds and try again.");
		    		} else {
		    			retryCount = 0;
		    			localStorage.setItem("retryCount", retryCount);
		    			$(".logininput").attr("disabled", false);
			    		
		    			localStorage.removeItem("timeRemaining");
		    			$('#retryTimeRemaining').html("");
		    		}
	    		}
    		}, 1000);
	    }
	
        document.getElementById('username').focus();
    </script>
</body>
</html>