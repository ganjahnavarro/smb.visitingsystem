<head>
	<title>San Miguel Brewery Virtual Lobby</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link href="/resources/css/bootstrap.css" rel="stylesheet">
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.1/jquery-ui-timepicker-addon.min.css">
	<link href="/resources/css/styles.css" rel="stylesheet">
	<link href="/resources/css/print.css" rel="stylesheet" media="print">
	
	<script src="/resources/js/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
	<script src="/resources/js/bootstrap.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.1/jquery-ui-timepicker-addon.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.25.1/js/jquery.tablesorter.min.js"></script>
</head>

<?php 
	define ( 'DB_HOST', getenv ( 'OPENSHIFT_MYSQL_DB_HOST' ) );
	define ( 'DB_PORT', getenv ( 'OPENSHIFT_MYSQL_DB_PORT' ) );
	define ( 'DB_USER', getenv ( 'OPENSHIFT_MYSQL_DB_USERNAME' ) );
	define ( 'DB_PASS', getenv ( 'OPENSHIFT_MYSQL_DB_PASSWORD' ) );
	define ( 'DB_NAME', getenv ( 'OPENSHIFT_GEAR_NAME' ) );
	
	$dbhost = constant("DB_HOST"); // Host name
	$dbport = constant("DB_PORT"); // Host port
	$dbuser = constant("DB_USER"); // Mysql username
	$dbpass = constant("DB_PASS"); // Mysql password
	$database = 'smb';
?>