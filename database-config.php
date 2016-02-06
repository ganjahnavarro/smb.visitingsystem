<?php
	// define database related variables
	define ( 'DB_HOST', getenv ( 'OPENSHIFT_MYSQL_DB_HOST' ) );
	define ( 'DB_PORT', getenv ( 'OPENSHIFT_MYSQL_DB_PORT' ) );
	define ( 'DB_USER', getenv ( 'OPENSHIFT_MYSQL_DB_USERNAME' ) );
	define ( 'DB_PASS', getenv ( 'OPENSHIFT_MYSQL_DB_PASSWORD' ) );
	define ( 'DB_NAME', getenv ( 'OPENSHIFT_GEAR_NAME' ) );
	
	$host = constant("DB_HOST"); // Host name
	$port = constant("DB_PORT"); // Host port
	$user = constant("DB_USER"); // Mysql username
	$pass = constant("DB_PASS"); // Mysql password
	$database = 'smb';
	
	// try to conncet to database
	$dbh = new PDO ( "mysql:dbname={$database};host={$host};port={$port}", $user, $pass );
	
	if (! $dbh) {
		
		echo "unable to connect to database";
	}
?>