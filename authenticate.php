<?php
	require 'database-config.php';
	
	session_start ();
	
	$username = "";
	$password = "";
	
	if (isset ( $_POST ['username'] )) {
		$username = $_POST ['username'];
	}
	if (isset ( $_POST ['password'] )) {
		$password = $_POST ['password'];
	}
	
	$q = 'SELECT * FROM users WHERE username=:username AND password=:password AND active = true';
	
	$query = $dbh->prepare ( $q );
	
	$query->execute ( array (
			':username' => $username,
			':password' => $password 
	) );
	
	if ($query->rowCount () == 0) {
		header ('Location: index.php?err=1');
	} else {
		$row = $query->fetch ( PDO::FETCH_ASSOC );
		
		session_regenerate_id ();
		$_SESSION ['sess_user_id'] = $row ['id'];
		$_SESSION ['sess_username'] = $row ['username'];
		$_SESSION ['sess_userrole'] = $row ['type'];
		$role = $_SESSION ['sess_userrole'];
		session_write_close ();
		
		if ($role == "HR") {
			header ('Location: hr/index.php');
		} else if ($role == "GUARD") {
			header ('Location: guard/index.php');
		} else if ($role == "ADMIN") {
			header ('Location: admin/index.php');
		} else if ($role == "DEFAULT") {
			header ('Location: user/index.php');
		}
		
		$_SESSION ['username'] = $username;
	}
		
?>